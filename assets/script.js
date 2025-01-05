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


