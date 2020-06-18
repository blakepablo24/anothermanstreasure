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

// Modal for larger enlarged images

// create references to the modal...
var modal = document.getElementById('myModal');
// to all images -- note I'm using a class!
var images = document.getElementsByClassName('myImages');
// the image in the modal
var modalImg = document.getElementById("img01");

// Go through all of the images with our custom class
for (var i = 0; i < images.length; i++) {
  var img = images[i];
  // and attach our click listener for this image.
  img.onclick = function(evt) {
    modal.style.display = "grid";
    modalImg.src = this.src;
  }
}

var span = document.getElementsByClassName("close")[0];

span.onclick = function() {
  modal.style.display = "none";
}

// Single Item Modal Slide Show container

var slideEnlargedIndex = 1;
showEnlargedSlides(slideEnlargedIndex);

function plusEnlargedSlides(n) {
  showEnlargedSlides(slideEnlargedIndex += n);
}

function currentEnlargedSlide(n) {
  showEnlargedSlides(slideEnlargedIndex = n);
}

function showEnlargedSlides(n) {
  var i;
  var slides = document.getElementsByClassName("myEnlargedSlides");
  if (n > slides.length) {slideEnlargedIndex = 1}
  if (n < 1) {slideEnlargedIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }

  slides[slideEnlargedIndex-1].style.display = "grid";
}