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

    if (menuToggle && mainNav) {
        menuToggle.addEventListener('click', () => {
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            mainNav.classList.toggle('is-open');
            menuToggle.setAttribute('aria-expanded', !isExpanded);
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
        // Mock Data for Courses
        const coursesData = [
            {
                id: 1,
                title: "Operación de Calderas y Autoclaves",
                category: "mantencion",
                modality: "presencial",
                hours: 40,
                desc: "Curso habilitante para examen Seremi de Salud. Decreto 10.",
                slug: "operacion-calderas",
                image: "../assets/temario_mantencionYproduccion.jpg"
            },
            {
                id: 2,
                title: "Excel Intermedio para Gestión",
                category: "computacion",
                modality: "elearning",
                hours: 24,
                desc: "Tablas dinámicas, funciones lógicas y gestión de datos.",
                slug: "excel-intermedio",
                image: "../assets/temario_computacion.jpg"
            },
            {
                id: 3,
                title: "Liderazgo Efectivo y Trabajo en Equipo",
                category: "habilidades",
                modality: "presencial",
                hours: 16,
                desc: "Mejore la comunicación y productividad de su equipo.",
                slug: "liderazgo-equipos",
                image: "../assets/temario_habilidadesblandas.jpg"
            },
            {
                id: 4,
                title: "Inglés Técnico para Mantención",
                category: "idiomas",
                modality: "elearning",
                hours: 30,
                desc: "Vocabulario técnico específico para manuales y procedimientos.",
                slug: "ingles-tecnico",
                image: "../assets/temario_idiomas.jpg"
            },
            {
                id: 5,
                title: "Electricidad Industrial Básica",
                category: "mantencion",
                modality: "presencial",
                hours: 40,
                desc: "Fundamentos de circuitos, seguridad y mediciones.",
                slug: "electricidad-basica",
                image: "../assets/temario_mantencionYproduccion.jpg"
            },
            {
                id: 6,
                title: "Técnicas de Ventas Consultivas",
                category: "habilidades",
                modality: "elearning",
                hours: 20,
                desc: "Estrategias modernas para cerrar negocios B2B.",
                slug: "ventas-consultivas",
                image: "../assets/temario_habilidadesblandas.jpg"
            }
        ];

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
                
                // Determine badge colors based on category (simplified logic)
                let badgeClass = 'badge--technical';
                if (course.category === 'computacion') badgeClass = 'badge--office';
                if (course.category === 'habilidades') badgeClass = 'badge--soft';
                
                card.innerHTML = `
                    <img src="${course.image}" alt="${course.title}" class="course-card__image">
                    <div class="course-card__header">
                        <span class="badge ${badgeClass}">${course.category}</span>
                        <span class="badge badge--modality">${course.modality}</span>
                    </div>
                    <div class="course-card__body">
                        <h3 class="course-card__title"><a href="../curso/${course.slug}/">${course.title}</a></h3>
                        <p class="course-card__excerpt">${course.desc}</p>
                        <ul class="course-card__meta">
                            <li><i class="far fa-clock" aria-hidden="true"></i> ${course.hours} Horas</li>
                            <li><i class="fas fa-laptop" aria-hidden="true"></i> ${course.modality === 'elearning' ? 'Online' : 'Presencial'}</li>
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
            const searchInput = document.getElementById('course-search').value.toLowerCase();
            
            const selectedCategories = Array.from(document.querySelectorAll('#category-filters input:checked'))
                .map(cb => cb.value);
                
            const selectedModalities = Array.from(document.querySelectorAll('#modality-filters input:checked'))
                .map(cb => cb.value);

            const filtered = coursesData.filter(course => {
                const matchesSearch = course.title.toLowerCase().includes(searchInput) || 
                                      course.desc.toLowerCase().includes(searchInput);
                const matchesCategory = selectedCategories.includes(course.category);
                const matchesModality = selectedModalities.includes(course.modality);
                
                return matchesSearch && matchesCategory && matchesModality;
            });

            renderCourses(filtered);
        };

        // Event Listeners for Filters
        document.getElementById('course-search').addEventListener('input', filterCourses);
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

    console.log('Selitec App Initialized - Filters & Accordions Ready');
});
