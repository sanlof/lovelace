<?php

$menuItems2 = [
    [
        'menuText' => 'Home',
        'link' => '../index.php'
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

foreach ($menuItems2 as $menuItem2): ?>

    <a href="<?= $menuItem2['link']; ?>"><?= $menuItem2['menuText']; ?></a></li>

<?php endforeach; ?>