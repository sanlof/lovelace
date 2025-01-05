<?php

$reviews = [
    [
        'rating' => '&starf; &starf; &starf; &starf; &star;',
        'text' => 'The blood-bags in this establishment are delicious. However, one will do best to keep their fairies close at all times.',
        'name' => 'Eric Northman',
        'img' => '../assets/images/review-eric-northman.jpg'
    ],
    [
        'rating' => '&starf; &starf; &starf; &starf; &starf;',
        'text' => 'I love the stylish and vintage feel of this place, and the virgin blood baths make my skin glow like nothing else!',
        'name' => 'Countess Elizabeth',
        'img' => '../assets/images/review-countess-elizabeth.jpg'
    ],
    [
        'rating' => '&starf; &starf; &starf; &starf; &starf;',
        'text' => 'The South Tower is my favourite thing. I don\'t care too much for the sun, but those meetings truly light up my immortal life.',
        'name' => 'Claudia',
        'img' => '../assets/images/review-claudia.jpg'
    ],
];

foreach ($reviews as $review) : ?>

    <section>
        <div>
            <p><?= $review['rating'] ?></p>
            <p><?= $review['text'] ?></p>
        </div>
        <div>
            <img src="<?= $review['img'] ?>" alt="" />
            <strong><?= $review['name'] ?></strong>
        </div>
    </section>

<?php endforeach; ?>