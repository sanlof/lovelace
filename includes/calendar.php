<?php

declare(strict_types=1);

// connect:a till databasen
$db = new PDO('sqlite:' . realpath(__DIR__ . '/../hotel.db'));

// funktion för att visa en kalender per rum utifrån id
function getBookedDates($room_id)
{
    global $db; // måste skriva global för att komma år db som ligger utanför funktionen
    $stmt = $db->prepare("SELECT check_in, check_out FROM bookings WHERE room_id = :room_id");
    $stmt->bindParam(':room_id', $room_id);
    $stmt->execute();

    $bookedDates = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $check_in = new DateTime($row['check_in']);
        $check_out = new DateTime($row['check_out']);

        // lägg till alla datum som är bokade i arrayen för att i kalendern kunna visa att de inte är tillgängliga
        while ($check_in <= $check_out) {
            $bookedDates[] = $check_in->format('Y-m-d');
            $check_in->modify('+1 day'); // så att nästa rad kollas tills det inte finns fler bokade datum att hittas
        }
    }

    return $bookedDates;
}

// kör funktionen för varje rum utifrån id-nummer
$room1BookedDates = getBookedDates(1);
$room2BookedDates = getBookedDates(2);
$room3BookedDates = getBookedDates(3);


// generera en kalender för varje rum
function generateCalendar($month, $year, $bookedDates = [])
{
    $month = '01';
    $year = '2025'; // vill bara kolla januari 2025

    // kolla vilken dag januari börjar på
    $firstDayOfMonth = new DateTime("$year-$month-01");
    $firstDayOfMonthWeekday = $firstDayOfMonth->format('N');
    $monthName = $firstDayOfMonth->format('M');

    // kolla hur många dagar januari har
    $lastDayOfMonth = new DateTime("$year-$month-01");
    $lastDayOfMonth->modify('last day of this month');
    $daysInMonth = $lastDayOfMonth->format('d');

    // skapa kalender med tables
    echo '<table border="0">';
    echo '<thead><tr><th colspan="7">' . $monthName . ' ' . $year . '</th></tr></thead>';
    echo '<tr>';

    $daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    foreach ($daysOfWeek as $day) {
        echo "<th>$day</th>";
    }
    echo '</tr>';

    echo '<tbody><tr>';

    // tomma celler för de dagar som föregår den första dagen i månaden
    for ($i = 1; $i < $firstDayOfMonthWeekday; $i++) {
        echo '<td></td>';
    }

    // visa dagarna i den första veckan
    $day = 1;
    for ($i = $firstDayOfMonthWeekday; $i <= 7; $i++) {
        $currentDate = "$year-$month-" . sprintf('%02d', $day); // man måste ha en nolla framför dagana som bara består av en siffra
        if (in_array($currentDate, $bookedDates)) {
            // markera uppbokade dagar
            echo "<td class='booked'>$day</td>";
        } else {
            // och/eller markera lediga dagar
            echo "<td class='available'>$day</td>";
        }
        $day++;
    }

    echo '</tr>';

    // visa dagar i de andra veckorna
    while ($day <= $daysInMonth) {
        echo '<tr>';
        for ($i = 1; $i <= 7; $i++) {
            if ($day <= $daysInMonth) {
                $currentDate = "$year-$month-" . sprintf('%02d', $day); // man måste ha en nolla framför dagana som bara består av en siffra
                if (in_array($currentDate, $bookedDates)) {
                    // markera uppbokade dagar
                    echo "<td class='booked'>$day</td>";
                } else {
                    // och/eller markera lediga dagar
                    echo "<td class='available'>$day</td>";
                }
            } else {
                echo '<td></td>';  // tom cell om fler dagar inte finns men veckan inte är slut
            }
            $day++;
        }
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}
