<?php require_once(__DIR__ . '/../templates/header.php');

require_once(__DIR__ . '/../includes/calendar.php');

// connect:a till databasen
$db = new PDO('sqlite:' . realpath(__DIR__ . '/../hotel.db'));

// hämta datan ur databasen för att loopa in rum och features i formuläret
$stmt = $db->prepare("SELECT * FROM rooms");
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT * FROM features");
$stmt->execute();
$features = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<section class="hero" id="hero-exp">
    <h1>Find Your<br />Sanctuary</h1>
    <img src="../assets/images/room8.jpeg" alt="" />
</section>
<a href="#explore" class="cta">View Available</a>
</header>
<main id="exp">
    <article class="basic" id="explore">
        <div class="inner-wrapper grid">
            <section>
                <h3>Luxury</h3>
                <h2>The Sanguine Suite</h2>
                <p>This luxury suite is situated in one of the castle towers. It features three separate rooms and a walk-in-closet. The bed has a firm matress with lovely velvet bedding. The windows are of the highest quality and faces all directions, so that you may enjoy the splendid views of both sunrise and sunset from high above.</p>
                <p><a href="#book-now" class="cta">Book now</a></p>
            </section>
            <img src="../assets/images/room15.jpeg" alt="" />
        </div>
    </article>
    <article class="basic">
        <div class="inner-wrapper grid">
            <section>
                <h3>Standard</h3>
                <h2>The Crimson Chamber</h2>
                <p>This comfortable chamber is situated in the middle-section of the castle. It features one room with windows facing two directions. It comes with a firm bed and velvet bedding, making it a given choice for those who want a deluxe feel without the expensive prize tag.</p>
                <p><a href="#book-now" class="cta">Book now</a></p>
            </section>
            <img src="../assets/images/room9.jpeg" alt="" />
        </div>
    </article>
    <article class="basic">
        <div class="inner-wrapper grid">
            <section>
                <h3>Budget</h3>
                <h2>The Twilight Tomb</h2>
                <p>On the bottom level of the castle, this very reasonably priced little gem can be found. Its single window offers good views of the sunset and is reinforced with silver bars, securing a good nights rest without the fear of attacks from wolves or the like.</p>
                <p><a href="#book-now" class="cta">Book now</a></p>
            </section>
            <img src="../assets/images/room4.jpeg" alt="" />
        </div>
    </article>
    <article id="book-now">
        <div class="inner-wrapper flex">
            <section>
                <h3>Make a Reservation</h3>
                <h2>Ready to Have a Bloody Good Time?</h2>
            </section>
            <img src="https://giffiles.alphacoders.com/368/36817.gif" class="bg" />
        </div>
        <div class="inner-wrapper">
            <section class="grid-3">
                <article>
                    <?php generateCalendar(date('m'), date('Y'), $room1BookedDates); ?>
                    <h3>The Sanguine Suite</h3>
                    <h4>Luxury</h4>
                </article>
                <article>
                    <?php generateCalendar(date('m'), date('Y'), $room2BookedDates); ?>
                    <h3>The Crimson Chamber</h3>
                    <h4>Standard</h4>
                </article>
                <article>
                    <?php generateCalendar(date('m'), date('Y'), $room3BookedDates); ?>
                    <h3>The Twilight Tomb</h3>
                    <h4>Budget</h4>
                </article>
            </section>
            <form action="../includes/booking.php" method="post" id="book">
                <?php if (!empty($_GET['message'])) : ?>
                    <div class="error">
                        <p><?= htmlspecialchars($_GET['message']); ?></p>
                        <img src="https://giffiles.alphacoders.com/365/36557.gif" alt="Vampire Emergency Gif" />
                    </div>
                <?php endif; ?>
                <section>
                    <div>
                        <label for="check-in">Check-in</label>
                        <input type="date" name="check-in" min="2025-01-01" max="2025-01-31" required>
                    </div>
                    <div>
                        <label for="check-out">Check-out</label>
                        <input type="date" name="check-out" min="2025-01-01" max="2025-01-31" required>
                    </div>
                </section>
                <section>
                    <h3>Room Preference</h3>
                    <?php foreach ($rooms as $room) : ?>
                        <label for="room-<?= $room['id'] ?>" class="room">
                            <input
                                type="radio"
                                name="room"
                                id="room-<?= $room['id'] ?>"
                                value="<?= $room['id']  ?>"
                                required>
                            <span><?= $room['name']; ?></span>
                            <span><?= $room['category'] ?></span>
                            <span id="room-price-<?= $room['id'] ?>">$<?= $room['base_price'] ?></span>
                        </label>
                    <?php endforeach; ?>
                </section>
                <section>
                    <h3>Additional features</h3>
                    <?php foreach ($features as $feature) : ?>
                        <label for="feature-<?= $feature['id'] ?>" class="feature">
                            <input
                                type="checkbox"
                                class="features"
                                name="features[]"
                                id="feature-<?= $feature['id'] ?>"
                                value="<?= $feature['id']  ?>">
                            <span><?= $feature['name']; ?></span>
                            <span><?= $feature['description'] ?></span>
                            <span id="feature-<?= $feature['id'] ?>-price">$<?= $feature['base_price'] ?></span>
                        </label>
                    <?php endforeach; ?>
                </section>
                <section>
                    Total Cost: <span id="total-cost-display">$0</span>
                </section>
                <section>
                    <div>
                        <label for="transferCode" id="transferCode-label">Payment details (transferCode)</label>
                        <input type="text" name="transferCode" id="transferCode" required>
                    </div>
                    <div>
                        <label for="discountCode" id="discountCode-label">Discount code?</label>
                        <input type="text" name="discountCode" id="discountCode">
                    </div>
                    <input type="hidden" name="totalcost" id="totalcost" value="" required>
                </section>

                <button name="book" type="submit" class="cta">Book</button>

            </form>
        </div>
    </article>
</main>
<script>
    document.getElementById('book').addEventListener('submit', function(event) {
        event.preventDefault(); // förhindra submit innan totalcost har räknats ut

        // Få tillbaka totalCost från calculateTotalCost
        const {
            totalCost
        } = calculateTotalCost();
        if (totalCost === null) {
            return; // man måste ha valt åtminstone ett rum, så totalcost kan inte vara null
        }

        const transferCode = document.getElementById('transferCode').value;
        const apiData = {
            transferCode: transferCode,
            totalcost: totalCost
        };

        // kod för verifiering av transferCode
        fetch('https://www.yrgopelago.se/centralbank/transferCode', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(apiData)
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response from external API:', data);
                // om API response status = 'success'
                if (data.status === 'success') {
                    console.log('API request was successful, form will be submitted.');
                    alert('Payment was successful!');

                    // Andra API-anropet - använd /deposit för att sätta in pengar
                    const depositData = {
                        user: 'sandra',
                        transferCode: transferCode
                    };

                    return fetch('https://www.yrgopelago.se/centralbank/deposit', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(depositData)
                        })
                        .then(depositResponse => depositResponse.json())
                        .then(depositData => {
                            console.log('Response from external API (deposit):', depositData);
                            if (depositData.status === 'success') {
                                console.log('Deposit was successful!');
                                alert('Deposit was successful! Your booking is confirmed.');

                                document.getElementById('book').submit(); // NU kan vi submitta formuläret! 
                            } else {
                                console.error('Deposit failed:', depositData);
                                alert('Deposit failed. Please try again.');
                            }
                        })
                        .catch(depositError => {
                            console.error('Error with deposit API:', depositError);
                            alert('There was an error with the deposit request.');
                        });

                } else {
                    alert('Payment failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error with API:', error);
                alert('There was an error with the payment request.');
            });
    }); // slut på eventlistener för submit

    // uppdatera (change) totalcost dynamiskt beroende på vad som är markerat
    document.querySelectorAll('input[name="room"], input.features, input[name="check-in"], input[name="check-out"], input[name="discountCode"]').forEach(input => {
        input.addEventListener('change', updateTotalCost);
    });

    function updateTotalCost() {
        const {
            totalCost
        } = calculateTotalCost(); // nu får vi totalCost
        if (totalCost !== null) {
            // uppdatera totaltcost som syns
            document.getElementById('total-cost-display').innerText = `$${totalCost}`;
            // uppdatera totalcost i dolt fält i formuläret
            document.getElementById('totalcost').value = totalCost;
        }
    }

    // funktion för att beräkna totalkostnad
    function calculateTotalCost() {
        const checkInDate = document.querySelector('input[name="check-in"]').value;
        const checkOutDate = document.querySelector('input[name="check-out"]').value;
        const discountCode = document.querySelector('input[name="discountCode"]').value;
        const selectedRoom = document.querySelector('input[name="room"]:checked');

        if (!checkInDate || !checkOutDate || !selectedRoom) {
            return {
                totalCost: null
            }; // alla dessa fält måste vara ifyllad för att kunna göra en uträkning
        }

        const roomPrice = parseFloat(document.querySelector(`#room-price-${selectedRoom.value}`).innerText.replace('$', '')); // parseFloat gör om en string till nummer

        // räkna ut antal nätter
        const checkIn = new Date(checkInDate);
        const checkOut = new Date(checkOutDate);
        const timeDiff = checkOut - checkIn;
        const numberOfNights = (timeDiff / (1000 * 3600 * 24)) + 1; // konvertera millisek till dygn, och lägg till 1 för att man ska kunna boka bara en dag t.ex. 15, tidigare var man tvungen att väjla t.ex. 15 till 16 men då kunde inte 16:e bokas sedan

        if (numberOfNights <= 0) {
            alert('Check-out date must be after check-in date.');
            return {
                totalCost: null
            }; // returera null om check-out är före check-in
        }

        // beräkna totalkostnad för rum
        let totalCost = roomPrice * numberOfNights;

        // rabatt om man bokar minst tre nätter och skriver rätt kod
        if (numberOfNights >= 3 && discountCode === 'Jan25') {
            totalCost = totalCost * 0.8;
        }

        // lägg till ev kostnad för valda features
        const selectedFeatures = document.querySelectorAll('input.features:checked');
        selectedFeatures.forEach(function(feature) {
            const featurePrice = parseFloat(document.querySelector(`#feature-${feature.value}-price`).innerText.replace('$', ''));
            totalCost += featurePrice;
        });

        return {
            totalCost: totalCost.toFixed(2) // så det inte blir fler än två decimaler
        };
    }
</script>
<?php require_once(__DIR__ . '/../templates/footer.php'); ?>