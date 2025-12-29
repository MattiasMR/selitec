document.addEventListener('DOMContentLoaded', () => {
    
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
                slug: "operacion-calderas"
            },
            {
                id: 2,
                title: "Excel Intermedio para Gestión",
                category: "computacion",
                modality: "elearning",
                hours: 24,
                desc: "Tablas dinámicas, funciones lógicas y gestión de datos.",
                slug: "excel-intermedio"
            },
            {
                id: 3,
                title: "Liderazgo Efectivo y Trabajo en Equipo",
                category: "habilidades",
                modality: "presencial",
                hours: 16,
                desc: "Mejore la comunicación y productividad de su equipo.",
                slug: "liderazgo-equipos"
            },
            {
                id: 4,
                title: "Inglés Técnico para Mantención",
                category: "idiomas",
                modality: "elearning",
                hours: 30,
                desc: "Vocabulario técnico específico para manuales y procedimientos.",
                slug: "ingles-tecnico"
            },
            {
                id: 5,
                title: "Electricidad Industrial Básica",
                category: "mantencion",
                modality: "presencial",
                hours: 40,
                desc: "Fundamentos de circuitos, seguridad y mediciones.",
                slug: "electricidad-basica"
            },
            {
                id: 6,
                title: "Técnicas de Ventas Consultivas",
                category: "habilidades",
                modality: "elearning",
                hours: 20,
                desc: "Estrategias modernas para cerrar negocios B2B.",
                slug: "ventas-consultivas"
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

        // Initial Render
        renderCourses(coursesData);
    }

    console.log('Selitec App Initialized - Filters & Accordions Ready');
});
