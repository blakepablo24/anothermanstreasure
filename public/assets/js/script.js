function openBurgerMenu() {
    document.getElementById("burger-menu-overlay").style.width = "50%";
}

function closeBurgerMenu() {
    document.getElementById("burger-menu-overlay").style.width = "0%";
}

function loader() {
    document.getElementById("loader-background").style.display = "grid";
    document.getElementById("loader").style.display = "block";
}