<?php

// funktion för felmeddelanden
function showError($message)
{
    header('Location: rooms.php?message=ERROR: ' . $message . '#book');
    exit();
}

// connect:a till databasen
$db = new PDO('sqlite:hotel.db');

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
$total_price = $room_total_price + $features_total_price;





// kolla om transferCode är giltig och har tillräckligt med pengar

$transferCode = trim($_POST['transferCode']);

$url = 'https://www.yrgopelago.se/centralbank/transferCode'; // Replace with the actual API URL

// gör datan till json-format så api:n kan läsa det vi skickar
$data = json_encode([
    'transfercode' => $transferCode
]);

// detta måste vara med för att vi ska kunna skicka data till API:n för verifiering
$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => 'Content-Type: application/json',
        'content' => $data
    ]
];
$context = stream_context_create($options);

// vi ber om data-validering genom file_get_contents() och fångar svaret i en variabel
$response = file_get_contents($url, false, $context);

// kolla om api:n svarar
if ($response === FALSE) {
    die('Error: Unable to send POST request');
}

// ta svaret från api:n och ta bort json-formatet
$responseData = json_decode($response, true);

// Check if the response contains the transferCode, fromAccount, and amount
if (isset($responseData['transferCode'])) {
    $transferCodeResponse = $responseData['transferCode'];
    $fromAccount = $responseData['fromAccount'];
    $amount = $responseData['amount'];

    // Output the details from the API response
    echo "Transfer Code: " . $transferCodeResponse . "<br>";
    echo "From Account: " . $fromAccount . "<br>";
    echo "Amount: " . $amount . "<br>";
} else {
    echo "Error: Invalid response from the API.";
    exit;
}

// logik för om transfercode är giltig och det är tillräckligt med pengar på "checken", godkänn i så fall bokningen och skicka till databasen
// if ($transferCode === true && $totalCost > $total_price) {

//     // skicka bokningen till databsen
//     $stmt = $db->prepare("
//         INSERT INTO bookings (
//             check_in, check_out, 
//             room_id, 
//             feature_1, feature_2, feature_3, 
//             total_price
//         )
//         VALUES (
//             :check_in, :check_out, 
//             :room_id, 
//             :feature_1, :feature_2, :feature_3, 
//             :total_price
//         )
//     ");
//     $stmt->bindParam(':check_in', $check_in);
//     $stmt->bindParam(':check_out', $check_out);
//     $stmt->bindParam(':room_id', $room_id);
//     $stmt->bindParam(':feature_1', $feature_1);
//     $stmt->bindParam(':feature_2', $feature_2);
//     $stmt->bindParam(':feature_3', $feature_3);
//     $stmt->bindParam(':total_price', $total_price);
//     $stmt->execute();
// } else {
//     showError('Invalid transferCode!');
// }


// visa kvitto i json-format

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
    'total_cost' => $total_price,
    'additional_info' => [
        'greeting' => 'Thanks... We wish you a splendid stay!',
        'imageUrl' => $random_image_url
    ]
];

// skicka kvittot som JSON
header('Content-Type: application/json');
echo json_encode($receipt, JSON_PRETTY_PRINT);
exit;
