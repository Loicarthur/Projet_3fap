const slider = document.querySelector('.banner-slider');
let isTransitioning = false;

function nextSlide() {
    if (!isTransitioning) {
        isTransitioning = true;
        const firstSlide = slider.children[0];
        slider.style.transition = 'transform 0.5s ease-in-out';
        slider.style.transform = 'translateX(-100%)';
        setTimeout(() => {
            slider.appendChild(firstSlide);
            slider.style.transition = 'none';
            slider.style.transform = 'translateX(0)';
            isTransitioning = false;
        }, 500);
    }
}

setInterval(nextSlide, 3000); // Changez le délai selon vos préférences
