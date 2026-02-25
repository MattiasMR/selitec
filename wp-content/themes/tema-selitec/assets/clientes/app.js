
/* =========================================
   CAROUSEL
   ========================================= */
document.addEventListener('DOMContentLoaded', () => {
    const track = document.querySelector('.carousel-track');
    if (!track) return;

    const nextBtn = document.querySelector('.carousel-btn--next');
    const prevBtn = document.querySelector('.carousel-btn--prev');
    const slides = Array.from(track.children);
    
    let currentIndex = 0;
    let autoPlayInterval;

    const updateCarousel = () => {
        const slideWidth = slides[0].getBoundingClientRect().width;
        const gap = 20; // Matches CSS gap
        // We move by index * (width + gap)
        const moveAmount = currentIndex * (slideWidth + gap);
        track.style.transform = `translateX(-${moveAmount}px)`;
        
        // Hide prev button if at start? optional. For loop, we do complex logic. 
        // For simple carousel:
        // Adjust index boundaries
    };

    const getVisibleSlides = () => {
        if (window.innerWidth <= 480) return 1;
        if (window.innerWidth <= 768) return 2;
        return 3;
    };

    const moveNext = () => {
        const visibleSlides = getVisibleSlides();
        const maxIndex = slides.length - visibleSlides;
        
        if (currentIndex < maxIndex) {
            currentIndex++;
        } else {
            currentIndex = 0; // Loop back to start
        }
        updateCarousel();
    };

    const movePrev = () => {
        const visibleSlides = getVisibleSlides();
        const maxIndex = slides.length - visibleSlides;

        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = maxIndex; // Loop to end
        }
        updateCarousel();
    };

    if (nextBtn) nextBtn.addEventListener('click', () => {
        moveNext();
        resetAutoPlay();
    });
    
    if (prevBtn) prevBtn.addEventListener('click', () => {
        movePrev();
        resetAutoPlay();
    });

    const startAutoPlay = () => {
        autoPlayInterval = setInterval(moveNext, 4000);
    };

    const resetAutoPlay = () => {
        clearInterval(autoPlayInterval);
        startAutoPlay();
    };
    
    // Resize handler to reset position if layout changes drastically
    window.addEventListener('resize', () => {
        currentIndex = 0; 
        updateCarousel();
    });

    startAutoPlay();
});
