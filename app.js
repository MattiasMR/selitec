document.addEventListener('DOMContentLoaded', () => {
    
    /* =========================================
       0. TYPEWRITER EFFECT (Hero)
       ========================================= */
    const TypeWriter = function(txtElement, words, wait = 3000) {
        this.txtElement = txtElement;
        this.words = words;
        this.txt = '';
        this.wordIndex = 0;
        this.wait = parseInt(wait, 10);
        this.type();
        this.isDeleting = false;
    }

    TypeWriter.prototype.type = function() {
        const current = this.wordIndex % this.words.length;
        const fullTxt = this.words[current];

        if(this.isDeleting) {
            this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
            this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.txtElement.innerHTML = `<span class="txt">${this.txt}</span>`;

        let typeSpeed = 200;

        if(this.isDeleting) {
            typeSpeed /= 2;
        }

        if(!this.isDeleting && this.txt === fullTxt) {
            typeSpeed = this.wait;
            this.isDeleting = true;
        } else if(this.isDeleting && this.txt === '') {
            this.isDeleting = false;
            this.wordIndex++;
            typeSpeed = 500;
        }

        setTimeout(() => this.type(), typeSpeed);
    }

    const txtElement = document.querySelector('.txt-type');
    if (txtElement) {
        const words = JSON.parse(txtElement.getAttribute('data-words'));
        const wait = txtElement.getAttribute('data-wait');
        new TypeWriter(txtElement, words, wait);
    }

    /* =========================================
       1. MOBILE MENU & NAVIGATION
       ========================================= */
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.getElementById('main-nav');
    
    // Support for both header styles (site-header and header)
    const headerToggle = document.querySelector('.header__mobile-toggle');
    const headerNav = document.querySelector('.header__nav');

    if (menuToggle && mainNav) {
        menuToggle.addEventListener('click', () => {
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            mainNav.classList.toggle('is-open');
            menuToggle.setAttribute('aria-expanded', !isExpanded);
        });
    }
    
    if (headerToggle && headerNav) {
        headerToggle.addEventListener('click', () => {
            const navList = headerNav.querySelector('.nav__list');
            if (navList) {
                navList.classList.toggle('is-open');
                const isExpanded = headerToggle.getAttribute('aria-expanded') === 'true';
                headerToggle.setAttribute('aria-expanded', !isExpanded);
            }
        });
    }

    /* =========================================
       2. SMOOTH SCROLL
       ========================================= */
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth' });
                targetElement.setAttribute('tabindex', '-1');
                targetElement.focus();
            }
        });
    });

    /* =========================================
       3. ACCORDION LOGIC (Accessible)
       ========================================= */
    const accordions = document.querySelectorAll('.accordion-header');
    
    accordions.forEach(acc => {
        acc.addEventListener('click', () => {
            const isExpanded = acc.getAttribute('aria-expanded') === 'true';
            const contentId = acc.getAttribute('aria-controls');
            const content = document.getElementById(contentId);
            
            // Toggle current
            acc.setAttribute('aria-expanded', !isExpanded);
            content.hidden = isExpanded;
        });
    });

    /* =========================================
       4. CATALOG FILTERS (Client-Side Demo)
       ========================================= */
    const coursesGrid = document.getElementById('courses-grid');
    
    if (coursesGrid) {
        // Use coursesData from cursos-data.js (mantener orden original por ID)
        const coursesData = typeof CURSOS_DATA !== 'undefined' ? [...CURSOS_DATA] : [];

        const renderCourses = (courses) => {
            coursesGrid.innerHTML = '';
            const resultCount = document.getElementById('result-count');
            
            if (courses.length === 0) {
                coursesGrid.innerHTML = '<p class="text-center col-span-full">No se encontraron cursos con estos filtros.</p>';
                if(resultCount) resultCount.textContent = 0;
                return;
            }

            if(resultCount) resultCount.textContent = courses.length;

            courses.forEach(course => {
                const card = document.createElement('article');
                card.className = 'course-card';
                
                // Determine badge colors based on category
                let badgeClass = 'badge--technical';
                let categoryLabel = 'Mantención y Producción';
                
                if (course.category === 'computacion') {
                    badgeClass = 'badge--office';
                    categoryLabel = 'Computación';
                }
                if (course.category === 'habilidades') {
                    badgeClass = 'badge--soft';
                    categoryLabel = 'Habilidades Blandas';
                }
                if (course.category === 'idiomas') {
                    badgeClass = 'badge--language';
                    categoryLabel = 'Idiomas';
                }
                
                const modalityLabel = course.modality === 'elearning' ? 'E-learning' : 'Presencial';
                
                card.innerHTML = `
                    <img src="${course.image}" alt="${course.title}" class="course-card__image" width="300" height="200" loading="lazy">
                    <div class="course-card__header">
                        <span class="badge ${badgeClass}">${categoryLabel}</span>
                        <span class="badge badge--modality">${modalityLabel}</span>
                    </div>
                    <div class="course-card__body">
                        <h3 class="course-card__title"><a href="../curso/${course.slug}/">${course.shortTitle}</a></h3>
                        <p class="course-card__excerpt">${course.desc.substring(0, 120)}...</p>
                        <ul class="course-card__meta">
                            <li><i class="far fa-clock" aria-hidden="true"></i> ${course.hours} Horas</li>
                            <li><i class="fas fa-laptop" aria-hidden="true"></i> ${modalityLabel}</li>
                        </ul>
                    </div>
                    <div class="course-card__footer">
                        <a href="../curso/${course.slug}/" class="btn btn--outline btn--full">Ver Temario</a>
                    </div>
                `;
                coursesGrid.appendChild(card);
            });
        };

        // Filter Logic
        const filterCourses = () => {
            const searchInput = document.getElementById('course-search')?.value.toLowerCase() || '';
            
            const selectedCategories = Array.from(document.querySelectorAll('#category-filters input:checked'))
                .map(cb => cb.value);
                
            const selectedModalities = Array.from(document.querySelectorAll('#modality-filters input:checked'))
                .map(cb => cb.value);

            const filtered = coursesData.filter(course => {
                const matchesSearch = course.title.toLowerCase().includes(searchInput) || 
                                      course.desc.toLowerCase().includes(searchInput) ||
                                      course.shortTitle.toLowerCase().includes(searchInput);
                const matchesCategory = selectedCategories.includes(course.category);
                const matchesModality = selectedModalities.includes(course.modality);
                
                return matchesSearch && matchesCategory && matchesModality;
            });

            renderCourses(filtered);
        };

        // Event Listeners for Filters
        const searchInput = document.getElementById('course-search');
        if (searchInput) {
            searchInput.addEventListener('input', filterCourses);
        }
        
        document.querySelectorAll('#category-filters input').forEach(cb => cb.addEventListener('change', filterCourses));
        document.querySelectorAll('#modality-filters input').forEach(cb => cb.addEventListener('change', filterCourses));

        // Check URL params for filters
        const urlParams = new URLSearchParams(window.location.search);
        const categoryParam = urlParams.get('category');

        if (categoryParam) {
            // Uncheck all categories first
            document.querySelectorAll('#category-filters input').forEach(cb => cb.checked = false);
            
            // Check the requested category
            const targetCheckbox = document.querySelector(`#category-filters input[value="${categoryParam}"]`);
            if (targetCheckbox) {
                targetCheckbox.checked = true;
            }
        }

        // Initial Render
        filterCourses();
    }

    /* =========================================
       5. CONTACT FORM (Mailto Fallback)
       ========================================= */
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const formData = new FormData(contactForm);
            const name = formData.get('name');
            const email = formData.get('email');
            const phone = formData.get('phone');
            const subject = formData.get('subject');
            const message = formData.get('message');
            
            const mailtoLink = `mailto:contacto@selitec.cl?subject=Contacto Web: ${subject}&body=Nombre: ${name}%0D%0AEmail: ${email}%0D%0ATeléfono: ${phone}%0D%0A%0D%0AMensaje:%0D%0A${message}`;
            
            window.location.href = mailtoLink;
            
            
            alert('Se abrirá su cliente de correo para enviar el mensaje.');
            contactForm.reset();
        });
    }

});

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
