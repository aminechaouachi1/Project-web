document.getElementById("scrollToTopBtn").addEventListener("click", function() {
    // Faites défiler la page vers le haut en douceur
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});

// Vérifiez si un paramètre d'URL ancre (hash) est présent
if (window.location.hash === "#a_propos") {
    // Le paramètre est présent, faites défiler la page vers la section "A propos"
    var aproposSection = document.getElementById("a_propos");
    if (aproposSection) {
        // Obtenez la position de la section "A propos"
        var offsetTop = aproposSection.offsetTop;
        
        // Faites défiler la page vers la position de la section en douceur
        window.scrollTo({
            top: 1500,
            behavior: "smooth"
        });
    }
}
window.addEventListener("scroll", function() {
    var scrollToTopBtn = document.getElementById("scrollToTopBtn");
    if (window.scrollY === 0) {
        // Si vous êtes en haut de la page, masquez la flèche
        scrollToTopBtn.style.display = "none";
    } else {
        // Sinon, affichez la flèche
        scrollToTopBtn.style.display = "block";
    }
});

document.getElementById("scrollToTopBtn").addEventListener("click", function() {
    // Faites défiler la page vers le haut en douceur
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});