document.getElementById("scrollToTopBtn").addEventListener("click", function() {
    // Faites défiler la page vers le haut en douceur
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});

// Ajoutez un gestionnaire de défilement pour vérifier la position de défilement
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

// Ajoutez un gestionnaire de clic pour le lien "A propos"
document.querySelector('a[href="#a_propos"]').addEventListener("click", function(e) {
    e.preventDefault(); // Empêche le comportement de lien par défaut
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
});

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



// Récupérer tous les éléments avec la classe "stat-value"
const statValues = document.querySelectorAll(".stat-value");

//Fonction pour mettre à jour la valeur de la statistique
function updateStatValue(element, finalValue) {
                let currentValue = parseInt(element.textContent, 10);
                if (currentValue < finalValue) {
                    // Si la valeur actuelle est inférieure à la valeur finale, ajoutez 1
                    element.textContent = (currentValue + 1).toString();
                    // Appelez à nouveau la fonction après un court délai
                    setTimeout(() => updateStatValue(element, finalValue), 10);
                }
            }
            
            // Détecter quand l'utilisateur fait défiler la page
            window.addEventListener("scroll", function () {
                statValues.forEach((statValue) => {
                    const rect = statValue.getBoundingClientRect();
                    if (rect.top < window.innerHeight) {
                        // Quand l'élément est visible à l'écran, mettez à jour la valeur de la statistique
                        updateStatValue(statValue, parseInt(statValue.getAttribute("data-final-value"), 10));
                    }
                });
            });


// Sélectionnez l'élément de l'image dans le cercle
const imageInCircle = document.querySelector(".image-in-circle");

// Définissez la vitesse de défilement
const scrollSpeed = 0.4; // Vous pouvez ajuster cette valeur

// Fonction pour mettre à jour la position de l'image en fonction du défilement
function updateImagePosition() {
    const scrollY = window.scrollY; // Obtenez la position de défilement verticale
    const newPosition = scrollY * scrollSpeed; // Calculez la nouvelle position de l'image

    // Appliquez la nouvelle position à l'image
    imageInCircle.style.transform = `translateY(${newPosition}px)`;
}

// Écoutez l'événement de défilement de la page
window.addEventListener("scroll", updateImagePosition);

// Appelez la fonction pour définir la position initiale
updateImagePosition();



const sidebar = document.querySelector('.sidebar');
const contactButton = document.getElementById('contactButton');
const contactForm = document.querySelector('.contact-form');

contactButton.addEventListener('click', () => {
    sidebar.classList.toggle('expanded');
    contactForm.style.display = contactForm.style.display === 'none' ? 'block' : 'none';
});
