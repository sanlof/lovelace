<?php require_once(__DIR__ . '/templates/header.php'); ?>

<section class="hero" id="hero-exp">
    <h1>Rediscover<br />the Light</h1>
    <img src="../assets/images/castle.jpeg" alt="" />
</section>
<a href="#intro" class="cta">Explore</a>
</header>
<main>
    <article class="basic" id="intro">
        <div class="inner-wrapper grid">
            <section>
                <h3>The Lovelace Hotel</h3>
                <h2>Experience the Magic of Sunrise and Sunset Once More</h2>
                <p>The Lovelace Hotel is a one of a kind sanctuary for vampires. Unique windows that filter out harmful uv-light enables you to relive the magic of watching the sunrise, before you go to rest, as well as catch a glimpse of the sunset, when it’s time to rise again.</p>
            </section>
            <section>
                <img src="../assets/images/ada24.jpeg" alt="" />
                <img src="../assets/images/room11.jpeg" alt="" />
            </section>
        </div>
    </article>
    <article id="rooms">
        <div class="inner-wrapper flex">
            <section>
                <h3>Rooms & Suites</h3>
                <h2>Find Your Sanctuary</h2>
                <p>Stay three nights or more – get twenty percent off with code Jan25.</p>
                <p><a href="../pages/rooms.php" class="cta">View Rooms</a></p>
            </section>
            <img src="../assets/images/room10.jpeg" class="bg" alt="" />
        </div>
    </article>
    <article class="basic">
        <div class="inner-wrapper grid">
            <section>
                <h3>Restaurant</h3>
                <h2>Fancy a Bite?</h2>
                <p>Regardless of wether you prefer to sink your teeth directly into warm flesh or rather savour your meal out of a fancy crystal glass, our blood-bags are trained to be gentle, tasteful and discreet.</p>
                <p>We also offer synthetic blood in the form of the somewhat tolerable Tru:Blood.</p>
                <p><a href="../pages/food.php" class="cta">Learn more</a></p>
            </section>
            <img src="../assets/images/restaurant8.jpeg" alt="" />
        </div>
    </article>
    <article>
        <div class="inner-wrapper flex">
            <section>
                <h3>Experiences</h3>
                <h2>Treatments & Activities</h2>
                <p>Vampires of the modern times know, that even though it might not alter one's already perfect complextion, exercise and other treatments are still important to feel good. When you book a stay with us, you get free access to a variety of activities and experiences which aim to fill the soulless inner void.</p>
                <p><a href="../pages/treats.php" class="cta">Explore</a></p>
            </section>
            <img src="../assets/images/spa2.png" class="bg" id="exp" alt="" />
        </div>
    </article>
    <article id="reviews">
        <div class="inner-wrapper grid-3">
            <?php require_once('includes/reviews.php'); ?>
        </div>
    </article>
    <article class="basic">
        <div class="inner-wrapper grid">
            <section>
                <h3>January 5th</h3>
                <h2>Eclipse Orchestra</h2>
                <p>On January 5th, the Ecplise Orchestra is back to give another one of their supernatural concerts. All hotel guests are welcome to gather in the Great Hall and listen as the music from strings and bows deafens the sounds of church bells.</p>
            </section>
            <img src="../assets/images/music2.jpeg" alt="" />
        </div>
    </article>
    <article class="basic">
        <div class="inner-wrapper grid">
            <section>
                <h3>January 31st</h3>
                <h2>Silver Bullet for My Valentine</h2>
                <p>The annual ball is arranged every year in the ballroom with the Chess-tiled floor. Hotel guests booked in luxury suites or standard rooms are welcome to join. This year's theme is forbidden love, inspired by the unlucky romance between a vampire and werewolf.</p>
            </section>
            <img src="../assets/images/dance.jpeg" alt="" />
        </div>
    </article>
</main>
<?php require_once(__DIR__ . '/templates/footer.php'); ?>