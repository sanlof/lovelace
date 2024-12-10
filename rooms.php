<?php require_once(__DIR__ . '/header.php'); ?>

<section class="hero" id="hero-exp">
    <h1>Find Your<br />Sanctuary</h1>
    <img src="images/room8.jpeg" alt="" />
</section>
<a href="#explore" class="cta">Available Rooms</a>
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
    <section id="book">
        <article>
            <div class="inner-wrapper grid">
                <h3>Make a Reservation</h3>
                <section>
                    <p>CALENDARS HERE</p>
                </section>
                <section>
                    <form action="book.php" method="post" id="booking-form">
                        <label for="transferCode">Payment details (transferCode)</label>
                        <input type="text" name="transferCode">

                        <label for="check-in">Check-in</label>
                        <input type="date" name="check-in" min="2025-01-01" max="2025-01-31">

                        <label for="check-out">Check-out</label>
                        <input type="date" name="check-out" min="2025-01-01" max="2025-01-31">

                        <label for="room">Chose a Room</label>
                        <select name="room" id="room">
                            <option value="1">Luxury</option>
                            <option value="2">Standard</option>
                            <option value="3">Budget</option>
                        </select>

                        <label for="features">
                            <input type="checkbox" name="features[]" value="1">Wellness package (includes: Bone-Breaking Massage, Virgin Blood Bath and Stake Through the Heart) ($4)
                        </label>

                        <label for="features">
                            <input type="checkbox" name="features[]" value="2">
                            Mindfulness package (includes: Morninstar Meditations and Moonlight Yoga) ($2)
                        </label>

                        <label for="features">
                            <input type="checkbox" name="features[]" value="7">
                            Forgive a Foe (one session) ($2)
                        </label>

                        <p>Access to the Muscle Dungeon and activities for little ones are always free.</p>

                        <button name="book" type="submit" class="cta">Book</button>
                    </form>
                </section>
            </div>
        </article>
    </section>
</main>

<?php require_once(__DIR__ . '/footer.php'); ?>