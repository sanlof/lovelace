/*** smooth transition between pages ***/

window.addEventListener('load', function() {
    document.body.style.transition = "opacity 1s ease-in";
    document.body.style.opacity = 1;
});

/*** menu ***/

const menuBtn = document.getElementById("menu-btn");
const menu = document.getElementById("menu");

menuBtn.addEventListener("click", function() {
    menu.classList.toggle("show");
});


/*** bookings ***/

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
