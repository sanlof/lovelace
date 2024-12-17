<?php

declare(strict_types=1);

// funktion för felmeddelanden
function showError($message)
{
    header('Location: ../pages/rooms.php?message=ERROR: ' . $message . '#book');
    exit();
}

// connect:a till databasen
$db = new PDO('sqlite:' . realpath(__DIR__ . '/../hotel.db'));

// tvätta data
$check_in_date = $_POST['check-in'];
$check_out_date = $_POST['check-out'];
$total_price = $_POST['totalcost'];  // totala priset skickas från JavaScript

// konvertera till rätt format
$check_in_date = date('Y-m-d', strtotime($check_in_date));
$check_out_date = date('Y-m-d', strtotime($check_out_date));

// kolla om check-out är senare än check-in
if (strtotime($check_out_date) <= strtotime($check_in_date)) {
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
$room_id = $_POST['room'];

// skapa feature_details array
$feature_details = [];
foreach ($features as $feature_id) {
    $stmt = $db->prepare("SELECT name, base_price FROM features WHERE id = :feature_id");
    $stmt->bindParam(':feature_id', $feature_id);
    $stmt->execute();
    $feature_data = $stmt->fetch();

    if ($feature_data) {
        $feature_details[] = [
            'name' => $feature_data['name'],
            'cost' => $feature_data['base_price']
        ];
    }
}

// kontrollera om rummet redan är bokat på datumen
$stmt = $db->prepare("
        SELECT COUNT(*) 
        FROM bookings 
        WHERE room_id = :room_id 
        AND (check_in <= :check_out AND check_out >= :check_in)
    ");
$stmt->bindParam(':room_id', $room_id);
$stmt->bindParam(':check_in', $check_in_date);
$stmt->bindParam(':check_out', $check_out_date);
$stmt->execute();

$result = $stmt->fetchColumn();

if ($result > 0) {
    showError('Sorry, the selected room is already booked for the selected dates.');
}

// om rummet är tillgängligt, skicka bokningen till databsen
$stmt = $db->prepare("
INSERT INTO bookings (
    check_in, check_out, 
    room_id, 
    feature_1, feature_2, feature_3, 
    total_price
)
VALUES (
    :check_in_date, :check_out_date, 
    :room_id, 
    :feature_1, :feature_2, :feature_3, 
    :total_price
)
");
$stmt->bindParam(':check_in_date', $check_in_date);
$stmt->bindParam(':check_out_date', $check_out_date);
$stmt->bindParam(':room_id', $room_id);
$stmt->bindParam(':feature_1', $feature_1);
$stmt->bindParam(':feature_2', $feature_2);
$stmt->bindParam(':feature_3', $feature_3);
$stmt->bindParam(':total_price', $total_price);
$stmt->execute();

// visa kvitto i json-format
$image_urls = [
    "https://giffiles.alphacoders.com/368/36829.gif",
    "https://giffiles.alphacoders.com/365/36520.gif",
    "https://giffiles.alphacoders.com/364/36497.gif"
];
$random_image_url = $image_urls[rand(0, count($image_urls) - 1)];

$receipt = [
    'island' => 'Vampisle',
    'hotel' => 'The Lovelace Hotel',
    'stars' => 3,
    'arrival_date' => $check_in_date,
    'departure_date' => $check_out_date,
    'features' => $feature_details,
    'totalcost' => $total_price,
    'additional_info' => [
        'greeting' => 'Thank you for trusting us... We wish you a splendid stay!',
        'imageUrl' => $random_image_url
    ]
];

header('Content-Type: application/json');
echo json_encode($receipt);
exit;
