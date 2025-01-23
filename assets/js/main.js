// Auto-hide Navbar on scroll
let prevScrollPos = window.scrollY; // Reemplazamos pageYOffset por scrollY
const navbar = document.getElementById("navbar");

window.onscroll = function () {
    let currentScrollPos = window.scrollY; // Reemplazamos pageYOffset por scrollY
    if (prevScrollPos > currentScrollPos) {
        navbar.style.transform = "translateY(0)";
    } else {
        navbar.style.transform = "translateY(-100%)";
    }
    prevScrollPos = currentScrollPos;
};

// Mobile Menu Toggle
const menuBtn = document.getElementById("menu-btn");
const mobileMenu = document.getElementById("mobile-menu");

menuBtn.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
});
