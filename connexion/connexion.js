const card = document.querySelector('.card');
const switchToSignup = document.getElementById('switchToSignup');
const switchToLogin = document.getElementById('switchToLogin');

switchToSignup.addEventListener('click', () => {
    card.style.transform = 'rotateY(180deg)';
});

switchToLogin.addEventListener('click', () => {
    card.style.transform = 'rotateY(0deg)';
});


var slideIndex = 0;
showSlides();

function showSlides() {
    var slides = document.getElementsByClassName("mySlides");
    for (var i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }
    slides[slideIndex - 1].style.display = "block";
    setTimeout(showSlides, 3000); // Change d'image toutes les 2 secondes
}
