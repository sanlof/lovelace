<?php

declare(strict_types=1);

// funktion för felmeddelanden
function showError($message)
{
    header('Location: rooms.php?message=ERROR: ' . $message . '#book');
    exit();
}

// connect:a till databasen
$db = new PDO('sqlite:' . realpath(__DIR__ . '/hotel.db'));

// tvätta data
$check_in = htmlspecialchars($_POST['check-in']);
$check_out = htmlspecialchars($_POST['check-out']);

// kolla om check-out är senare än check-in
if (strtotime($check_out) <= strtotime($check_in)) {
    showError('Check-out date must be later than check-in date!');
}

// tvätta data
$features = isset($_POST['features']) ? $_POST['features'] : []; // spara i array
$feature_1 = $feature_2 = $feature_3 = null; // default ingen vald
if (isset($features[0])) {
    $feature_1 = filter_var($features[0], FILTER_SANITIZE_NUMBER_INT);
}
if (isset($features[1])) {
    $feature_2 = filter_var($features[1], FILTER_SANITIZE_NUMBER_INT);
}
if (isset($features[2])) {
    $feature_3 = filter_var($features[2], FILTER_SANITIZE_NUMBER_INT);
}

// tvätta data
$room_id = htmlspecialchars($_POST['room']);

// kolla vad rummet kostar
$stmt = $db->prepare("SELECT base_price FROM rooms WHERE id = :room_id");
$stmt->bindParam(':room_id', $room_id);
$stmt->execute();
$room = $stmt->fetch();

// kolla om rummet finns
if (!$room) {
    showError('Room not found!');
}

$base_price = $room['base_price']; // rummets pris

// räkna ut totalt pris för antal nätter (baserat på check-in och check-out)
$check_in_date = new DateTime($check_in);
$check_out_date = new DateTime($check_out);
$interval = $check_in_date->diff($check_out_date); // differensen...
$num_nights = $interval->days; // ...antal nätter
$room_total_price = $base_price * $num_nights; // totalt pris för rummet

// räkna ut totalt pris för valda features
$features_total_price = 0; // default om inga features har valts
$feature_details = []; // lagra feature-detaljer i array

foreach ($features as $feature) {
    $stmt = $db->prepare("SELECT name, base_price FROM features WHERE id = :feature_id");
    $stmt->bindParam(':feature_id', $feature);
    $stmt->execute();
    $feature_data = $stmt->fetch(); // rätta variabelnamnet från $feature till $feature_data

    if ($feature_data) {
        $features_total_price += $feature_data['base_price']; // lägg till varje valt features pris i totala summan
        $feature_details[] = [
            'name' => $feature_data['name'],
            'cost' => $feature_data['base_price']
        ];
    }
}

// räknk ut totalt pris för alla nätter och valda features
$_POST['total_cost'] = $room_total_price + $features_total_price;
$total_price = $_POST['total_cost'];  // This is where the fix happens

if (isset($_POST['transferCode'], $_POST['totalcost'])) {

    // skicka bokningen till databsen
    $stmt = $db->prepare("
    INSERT INTO bookings (
        check_in, check_out, 
        room_id, 
        feature_1, feature_2, feature_3, 
        total_price
    )
    VALUES (
        :check_in, :check_out, 
        :room_id, 
        :feature_1, :feature_2, :feature_3, 
        :total_price
    )
    ");
    $stmt->bindParam(':check_in', $check_in);
    $stmt->bindParam(':check_out', $check_out);
    $stmt->bindParam(':room_id', $room_id);
    $stmt->bindParam(':feature_1', $feature_1);
    $stmt->bindParam(':feature_2', $feature_2);
    $stmt->bindParam(':feature_3', $feature_3);
    $stmt->bindParam(':total_price', $total_price);  // Ensure this is bound to $total_price
    $stmt->execute();
}

//visa kvitto i json-format

// olika imageUrl:s för additional_info
$image_urls = [
    "https://giffiles.alphacoders.com/368/36829.gif", // ...thanks
    "https://giffiles.alphacoders.com/365/36520.gif", // thank you
    "https://giffiles.alphacoders.com/364/36497.gif", // jessica
    "https://giffiles.alphacoders.com/368/36817.gif" // eric smiley
];
$random_image_url = $image_urls[rand(0, count($image_urls) - 1)]; // välj en bild på random

$receipt = [
    'island' => 'Vampisle',
    'hotel' => 'The Lovelace Hotel',
    'stars' => 3,
    'arrival_date' => $check_in_date->format('Y-m-d'),
    'departure_date' => $check_out_date->format('Y-m-d'),
    'features' => $feature_details,
    'total_cost' => $total_price,  // Ensure total_cost is being passed correctly
    'additional_info' => [
        'greeting' => 'Thank you for trusting us! We wish you a splendid stay...',
        'imageUrl' => $random_image_url
    ]
];

// skicka kvittot som JSON
header('Content-Type: application/json');
echo json_encode($receipt);
exit;
