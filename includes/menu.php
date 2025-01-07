<?php

$menuItems = [
    [
        'menuText' => 'Home',
        'link' => '../pages/index.php'
    ],
    [
        'menuText' => 'Rooms & Booking',
        'link' => '../pages/rooms.php'
    ],
    [
        'menuText' => 'Restaurant',
        'link' => '../pages/food.php'
    ],
    [
        'menuText' => 'Experiences',
        'link' => '../pages/treats.php'
    ]
];

foreach ($menuItems as $menuItem): ?>

    <a href="<?= $menuItem['link']; ?>"><?= $menuItem['menuText']; ?></a>

<?php endforeach; ?>