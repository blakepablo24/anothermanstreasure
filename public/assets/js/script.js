function openBurgerMenu() {
    document.getElementById("burger-menu-overlay").style.width = "50%";
}

function closeBurgerMenu() {
    document.getElementById("burger-menu-overlay").style.width = "0%";
}

// Single Item Slide Show container

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }

  slides[slideIndex-1].style.display = "grid";
}