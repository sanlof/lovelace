/*** smooth transition between pages ***/

document.addEventListener('DOMContentLoaded', function(event) {
    document.querySelector('body').style.opacity = 1
})

/*** menu ***/

const menuBtn = document.getElementById("menu-btn");
const menu = document.getElementById("menu");

menuBtn.addEventListener("click", function() {
    menu.classList.toggle("show");
});



/*** hero section ***/

const hero = document.getElementById('hero');

// Define the headers and images data
const heroContent = [
    {
        title: "Rediscover<br /> the Light",
        image: "../assets/images/castle.jpeg"
    },
    {
        title: "Taste the<br /> Sunshine",
        image: "../assets/images/ada26.jpeg"
    },
    {
        title: "Find Your<br /> Sanctuary",
        image: "../assets/images/room8.jpeg"
    }
];

let currentIndex = 0;

// Function to update the hero section with new content
function updateHeroContent() {
    // Clear previous content (before adding new content)
    hero.innerHTML = '';

    // Create and append the new content
    const { title, image } = heroContent[currentIndex];
    
    const h1 = document.createElement('h1');
    h1.innerHTML = title;
    
    const img = document.createElement('img');
    img.src = image;
    img.alt = '';

    hero.appendChild(h1);
    hero.appendChild(img);

    // Trigger the smooth fade-in transition for the new image and title
    setTimeout(() => {
        h1.classList.add('active');  // Fade in the image
        setTimeout(() => {
            img.classList.add('active'); // Fade in the title after the image
        }, 1000); // Slight delay for title to fade after image
    }, 50); // Small delay to allow DOM updates before triggering the transition
}

// Function to switch to the next header and image with fading effect
function switchHeader() {
    // Fade out the current image and title
    const currentImage = hero.querySelector('img');
    const currentTitle = hero.querySelector('h1');

    // If content exists, fade out
    if (currentImage) {
        currentImage.classList.remove('active');
    }
    if (currentTitle) {
        currentTitle.classList.remove('active');
    }

    // Update the current index and wrap it around
    currentIndex = (currentIndex + 1) % heroContent.length;

    // Wait for the fade-out to complete, then update content
    setTimeout(() => {
        updateHeroContent();
    }, 2000);
}

// Initialize the hero section with the first content immediately
updateHeroContent();

// Automatically change the header and image every 5 seconds
setInterval(switchHeader, 10000); // 5000 milliseconds = 5 seconds


