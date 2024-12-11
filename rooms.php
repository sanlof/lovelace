<?php require_once(__DIR__ . '/header.php'); ?>

<section class="hero" id="hero-exp">
    <h1>Find Your<br />Sanctuary</h1>
    <img src="images/room8.jpeg" alt="" />
</section>
<a href="#explore" class="cta">View Available</a>
</header>
<main id="exp">
    <article id="explore">
        <div class="inner-wrapper grid">
            <section>
                <h3>Luxury</h3>
                <h2>The Sanguine Suite</h2>
                <p>This large suite is situated in one of the castle towers. The windows are of the highest quality and faces all directions, so that you may enjoy the splendid views of both sunrise and sunset from high above.</p>
                <p><a href="#book" class="cta">Book now</a></p>
            </section>
            <img src="images/room15.jpeg" alt="" />
        </div>
    </article>
    <article>
        <div class="inner-wrapper grid">
            <section>
                <h3>Standard</h3>
                <h2>The Crimson Chamber</h2>
                <p>At the middle section of the castle, the Crimson Chamber is situated together with the other standard rooms. It has great views and secure windows.</p>
                <p><a href="#book" class="cta">Book now</a></p>
            </section>
            <img src="images/room9.jpeg" alt="" />
        </div>
    </article>
    <article>
        <div class="inner-wrapper grid">
            <section>
                <h3>Budget</h3>
                <h2>The Twilight Tomb</h2>
                <p>On the bottom level of the castle, this reasonably priced gem can be found. Even though limited to one window, the uv-filtering glass still offers good views of the sunset. Moreover, the windows are reinforced with silver bars, securing a good nights rest without the fear of attacks from wolves or the like.</p>
                <p></p>
                <p><a href="#book" class="cta">Book now</a></p>
            </section>
            <img src="images/room4.jpeg" alt="" />
        </div>
    </article>
    <article id="book-now">
        <div class="inner-wrapper flex">
            <section>
                <h3>Make a Reservation</h3>
                <h2>Ready to Have a Bloody Good Time?</h2>
            </section>
        </div>
        <div class="inner-wrapper">
            <section class="grid-3">
                <article>
                    <p>CALENDAR for BUDGET</p>
                </article>
                <article>
                    <p>CALENDAR for STANDARD</p>
                </article>
                <article>
                    <p>CALENDAR for LUXURY</p>
                </article>
            </section>
            <form action="book.php" method="post" id="book">
                <section>
                    <div>
                        <label for="check-in">Check-in</label>
                        <input type="date" name="check-in" min="2025-01-01" max="2025-01-31">
                    </div>
                    <div>
                        <label for="check-out">Check-out</label>
                        <input type="date" name="check-out" min="2025-01-01" max="2025-01-31">
                    </div>
                </section>
                <section>
                    <h3>Room Preference</h3>
                    <label for="room-1" class="room">
                        <input type="radio" name="room" id="room-1" value="1">
                        <span>The Sanguine Suite</span> <span>Luxury</span> <span>$3</span>
                    </label>
                    <label for="room-2" class="room">
                        <input type="radio" name="room" id="room-2" value="2">
                        <span>The Crimson Chamber</span> <span>Standard</span> <span>$2</span>
                    </label>
                    <label for="room-3" class="room">
                        <input type="radio" name="room" id="room-3" value="3">
                        <span>The Twilight Tomb</span> <span>Budget</span> <span>$1</span>
                    </label>
                </section>

                <section>
                    <h3>Additional features</h3>

                    <label for="feature-1" class="feature">
                        <input type="checkbox" id="feature-1" name="features[]" value="1">
                        <span>Sinister Sauna</span> <span>Unholy heat to vaporize your unmortal sorrows</span> <span>$3</span>
                    </label>

                    <label for="feature-2" class="feature">
                        <input type="checkbox" id="feature-2" name="features[]" value="1">
                        <span>Beastly Bathtub</span> <span>Relax in the luxurious warmth of crimson waters</span> <span>$2</span>
                    </label>

                    <label for="feature-3" class="feature">
                        <input type="checkbox" id="feature-3" name="features[]" value="1">
                        <span>Macabre Minibar</span> <span>Cursed concoctions to fuel your darkest desires</span> <span>$1</span>
                    </label>
                </section>

                <section>
                    <label for="transferCode" id="transferCode-label">Payment details (transferCode)</label>
                    <input type="text" name="transferCode" id="transferCode">
                </section>

                <button name="book" type="submit" class="cta">Book</button>

            </form>
        </div>
    </article>
</main>

<?php require_once(__DIR__ . '/footer.php'); ?>