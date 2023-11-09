const carousel = document.getElementById('carousel');
const carousel2 = document.getElementById('carousel2'); // Ajoutez une référence à la deuxième liste
const prev = document.getElementById('prev');
const next = document.getElementById('next');

let currentIndex = 0;
let currentIndex2 = 0; // Ajoutez un nouvel index pour la deuxième liste
const itemWidth = 300; // Largeur d'un élément, ajustez selon vos besoins
const itemCount = carousel.children.length;
const itemCount2 = carousel2.children.length; // Nombre d'éléments dans la deuxième liste

// Dupliquez les éléments et ajoutez-les à la fin du carrousel
for (let i = 0; i < itemCount; i++) {
  const clone = carousel.children[i].cloneNode(true);
  carousel.appendChild(clone);
}

for (let i = 0; i < itemCount2; i++) {
  const clone = carousel2.children[i].cloneNode(true);
  carousel2.appendChild(clone);
}

// Ajustez la largeur du conteneur pour qu'elle puisse contenir tous les éléments répétés
carousel.style.width = itemWidth * (itemCount * 2) + 'px';
carousel2.style.width = itemWidth * (itemCount2 * 2) + 'px';

prev.addEventListener('click', () => {
  currentIndex--;
  updateCarousel();
});

next.addEventListener('click', () => {
  currentIndex++;
  updateCarousel();
});

// Ajoutez des événements de clic pour la deuxième liste
prev2.addEventListener('click', () => {
  currentIndex2--;
  updateCarousel2();
});

next2.addEventListener('click', () => {
  currentIndex2++;
  updateCarousel2();
});

function updateCarousel() {
  const translateX = -currentIndex * itemWidth;
  carousel.style.transform = `translateX(${translateX}px)`;

  // Si nous atteignons la fin (à droite), déplacez le carrousel instantanément au début
  if (currentIndex === itemCount) {
    currentIndex = 0;
    carousel.style.transition = 'none'; // Désactivez temporairement la transition
    carousel.style.transform = `translateX(${currentIndex * itemWidth}px)`;
    setTimeout(() => {
      carousel.style.transition = ''; // Réactivez la transition
    }, 0);
  } else if (currentIndex === -1) {
    // Si nous atteignons le début (à gauche), déplacez le carrousel instantanément à la fin
    currentIndex = itemCount - 1;
    carousel.style.transition = 'none';
    carousel.style.transform = `translateX(${currentIndex * itemWidth}px)`;
    setTimeout(() => {
      carousel.style.transition = '';
    }, 0);
  }
}

// Ajoutez une fonction similaire pour la deuxième liste
function updateCarousel2() {
  const translateX = -currentIndex2 * itemWidth;
  carousel2.style.transform = `translateX(${translateX}px)`;

  if (currentIndex2 === itemCount2) {
    currentIndex2 = 0;
    carousel2.style.transition = 'none';
    carousel2.style.transform = `translateX(${currentIndex2 * itemWidth}px)`;
    setTimeout(() => {
      carousel2.style.transition = '';
    }, 0);
  } else if (currentIndex2 === -1) {
    currentIndex2 = itemCount2 - 1;
    carousel2.style.transition = 'none';
    carousel2.style.transform = `translateX(${currentIndex2 * itemWidth}px)`;
    setTimeout(() => {
      carousel2.style.transition = '';
    }, 0);
  }
}

// Démarrez le défilement automatique pour la première liste
let autoScrollInterval;

function startAutoScroll() {
  autoScrollInterval = setInterval(() => {
    currentIndex++;
    updateCarousel();
  }, 2000);
}

// Démarrez le défilement automatique pour la deuxième liste
let autoScrollInterval2;

function startAutoScroll2() {
  autoScrollInterval2 = setInterval(() => {
    currentIndex2++;
    updateCarousel2();
  }, 2000);
}

// Lancez le défilement automatique lorsque la page se charge pour les deux listes
startAutoScroll();
startAutoScroll2();
