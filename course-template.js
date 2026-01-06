// Script para generar páginas individuales de cursos
// Este archivo puede ejecutarse en Node.js para generar todas las páginas HTML

const fs = require('fs');
const path = require('path');

// Función para leer el archivo cursos.md y parsearlo
function parseCursosFromMd(mdContent) {
    const cursos = [];
    const bloques = mdContent.split('[CURSO]').slice(1); // Ignorar el contenido antes del primer [CURSO]
    
    bloques.forEach((bloque, index) => {
        const lines = bloque.trim().split('\n');
        const curso = {
            id: index + 1,
            categoria: '',
            titulo_tarjeta: '',
            cuerpo_tarjeta: '',
            texto_pagina: '',
            pdf_temario: ''
        };
        
        let capturandoTexto = false;
        let textoBuffer = [];
        
        lines.forEach(line => {
            if (line.startsWith('categoria:')) {
                curso.categoria = line.replace('categoria:', '').trim();
            } else if (line.startsWith('titulo_tarjeta:')) {
                curso.titulo_tarjeta = line.replace('titulo_tarjeta:', '').trim();
            } else if (line.startsWith('cuerpo_tarjeta:')) {
                curso.cuerpo_tarjeta = line.replace('cuerpo_tarjeta:', '').trim();
            } else if (line.startsWith('texto_pagina: |')) {
                capturandoTexto = true;
            } else if (line.startsWith('pdf_temario:')) {
                curso.pdf_temario = line.replace('pdf_temario:', '').trim();
                capturandoTexto = false;
            } else if (capturandoTexto) {
                textoBuffer.push(line);
            }
        });
        
        curso.texto_pagina = textoBuffer.join('\n').trim();
        cursos.push(curso);
    });
    
    return cursos;
}

// Función para generar slug desde título
function generateSlug(titulo) {
    return titulo.toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // Quitar acentos
        .replace(/[^\w\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/--+/g, '-')
        .replace(/^-+|-+$/g, '');
}

// Template HTML para cada curso
function generateCourseHTML(curso, slug) {
    const categoryMap = {
        'Mantención y Producción': 'mantencion',
        'Computación': 'computacion',
        'Habilidades Blandas': 'habilidades',
        'Idiomas': 'idiomas'
    };
    
    const imageMap = {
        'mantencion': '../assets/temario_mantencionYproduccion.jpg',
        'computacion': '../assets/temario_computacion.jpg',
        'habilidades': '../assets/temario_habilidadesblandas.jpg',
        'idiomas': '../assets/temario_idiomas.jpg'
    };
    
    const categorySlug = categoryMap[curso.categoria] || 'mantencion';
    const imagen = imageMap[categorySlug];
    
    // Extraer horas del título si existe (buscar números entre paréntesis)
    const horasMatch = curso.titulo_tarjeta.match(/\((\d+)\s+horas?\)/i);
    const horas = horasMatch ? horasMatch[1] : '40';
    
    // Convertir texto_pagina a HTML (convertir líneas en párrafos y listas)
    const textoHTML = curso.texto_pagina
        .split('\n')
        .map(line => {
            line = line.trim();
            if (!line) return '';
            if (line.startsWith('- ')) {
                return `<li>${line.substring(2)}</li>`;
            }
            if (/^\d+\./.test(line)) {
                return `<h4>${line}</h4>`;
            }
            if (line.includes(':') && line.length < 100) {
                return `<h4>${line}</h4>`;
            }
            return `<p>${line}</p>`;
        })
        .join('\n');
    
    return `<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="${curso.cuerpo_tarjeta.substring(0, 155)}">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="Referrer-Policy" content="strict-origin-when-cross-origin">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <title>${curso.titulo_tarjeta} | Selitec Capacitación</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <!-- Barra Superior -->
    <div class="top-bar">
        <div class="container top-bar__content">
            <div class="top-bar__contact">
                <a href="tel:+56226385307" aria-label="Llamar a Selitec"><i class="fas fa-phone-alt" aria-hidden="true"></i> +56 2 2638 5307</a>
                <a href="tel:+56226397059" aria-label="Llamar a Selitec"><i class="fas fa-phone-alt" aria-hidden="true"></i> +56 2 2639 7059</a>
                <a href="mailto:contacto@selitec.cl" aria-label="Enviar correo a Selitec"><i class="fas fa-envelope" aria-hidden="true"></i> contacto@selitec.cl</a>
            </div>
            <div class="top-bar__trust">
                <span class="trust-badge"><i class="fas fa-check-circle" aria-hidden="true"></i> Certificación NCh 2728</span>
                <span class="trust-badge"><i class="fas fa-certificate" aria-hidden="true"></i> Certificado por Sence</span>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="site-header">
        <div class="container site-header__inner">
            <div class="site-logo">
                <a href="../../" aria-label="Volver al inicio">
                    <img src="../../assets/logo oficial.jpg" alt="SELITEC" class="site-logo__img">
                </a>
            </div>

            <button class="mobile-menu-toggle" aria-label="Abrir menú de navegación" aria-expanded="false" aria-controls="main-nav">
                <span class="hamburger-icon"></span>
            </button>

            <nav id="main-nav" class="main-nav">
                <ul class="main-nav__list">
                    <li><a href="../../" class="main-nav__link">Inicio</a></li>
                    <li><a href="../../cursos/" class="main-nav__link">Cursos</a></li>
                    <li><a href="../../programacion/" class="main-nav__link">Programación Mensual</a></li>
                    <li><a href="../../nivelacion/" class="main-nav__link">Nivelación de Estudios</a></li>
                    <li><a href="../../empresa/" class="main-nav__link">Empresa</a></li>
                    <li><a href="../../contacto/" class="main-nav__link">Contacto</a></li>
                    <li><a href="https://www.selitec.cl/elearning" class="main-nav__link main-nav__link--highlight">Aula Virtual</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <!-- Course Hero -->
        <section class="course-hero" style="background: linear-gradient(rgba(38, 34, 98, 0.85), rgba(38, 34, 98, 0.85)), url('${imagen}'); background-size: cover; background-position: center;">
            <div class="container">
                <div class="course-hero__breadcrumb">
                    <a href="../../">Inicio</a> / <a href="../../cursos/">Cursos</a> / <span>${curso.titulo_tarjeta}</span>
                </div>
                <h1 class="course-hero__title">${curso.titulo_tarjeta}</h1>
                <p class="course-hero__subtitle">${curso.cuerpo_tarjeta}</p>
                <div class="course-hero__meta">
                    <span class="badge badge--large">${curso.categoria}</span>
                    <span class="meta-item"><i class="far fa-clock"></i> ${horas} Horas</span>
                    <span class="meta-item"><i class="fas fa-certificate"></i> Certificación SENCE</span>
                </div>
            </div>
        </section>

        <!-- Course Content -->
        <div class="container course-layout">
            <article class="course-main">
                <section class="course-section">
                    <h2 class="section-title">Descripción del Curso</h2>
                    <p>${curso.cuerpo_tarjeta}</p>
                </section>

                <section class="course-section">
                    <h2 class="section-title">Temario Detallado</h2>
                    <div class="course-syllabus">
                        ${textoHTML}
                    </div>
                </section>

                <section class="course-section">
                    <h2 class="section-title">Certificación</h2>
                    <p>Al finalizar el curso y cumplir con el 75% de asistencia, recibirá un <strong>Certificado Oficial</strong> emitido por Selitec, organismo técnico reconocido por SENCE.</p>
                    <p>Este certificado valida sus competencias laborales y puede ser utilizado para procesos de acreditación profesional.</p>
                </section>
            </article>

            <aside class="course-sidebar">
                <div class="course-cta-box">
                    <h3>¿Interesado en este curso?</h3>
                    <p>Contáctenos para conocer fechas, valores y modalidades disponibles.</p>
                    <a href="https://wa.me/56226385307?text=Hola, me interesa el curso: ${encodeURIComponent(curso.titulo_tarjeta)}" class="btn btn--whatsapp btn--full" target="_blank" rel="noopener">
                        <i class="fab fa-whatsapp"></i> Consultar por WhatsApp
                    </a>
                    <a href="tel:+56226385307" class="btn btn--outline btn--full">
                        <i class="fas fa-phone"></i> Llamar Ahora
                    </a>
                    <a href="../../contacto/" class="btn btn--outline btn--full">
                        <i class="fas fa-envelope"></i> Formulario de Contacto
                    </a>
                </div>

                ${curso.pdf_temario ? `
                <div class="course-download-box">
                    <h4>Descargar Temario PDF</h4>
                    <a href="../../assets/temarios/${curso.pdf_temario}" class="btn btn--outline btn--full" download>
                        <i class="fas fa-file-pdf"></i> Descargar PDF
                    </a>
                </div>
                ` : ''}

                <div class="course-info-box">
                    <h4>Información del Curso</h4>
                    <ul class="info-list">
                        <li><strong>Duración:</strong> ${horas} Horas</li>
                        <li><strong>Categoría:</strong> ${curso.categoria}</li>
                        <li><strong>Certificación:</strong> SENCE</li>
                        <li><strong>Modalidad:</strong> Consultar</li>
                    </ul>
                </div>

                <div class="course-related-box">
                    <h4>Ver también</h4>
                    <a href="../../cursos/?category=${categorySlug}" class="btn btn--outline btn--full">
                        <i class="fas fa-th-list"></i> Más cursos de ${curso.categoria}
                    </a>
                    <a href="../../programacion/" class="btn btn--outline btn--full">
                        <i class="fas fa-calendar-alt"></i> Ver Programación Mensual
                    </a>
                </div>
            </aside>
        </div>

    </main>

    <footer class="site-footer">
        <div class="container site-footer__inner">
            <div class="footer-col">
                <h3 class="footer-title">Selitec Capacitación</h3>
                <p>Organismo Técnico de Capacitación (OTEC) reconocido por SENCE. Certificación de Calidad NCh 2728.</p>
                <div class="social-links">
                    <a href="https://www.facebook.com/selitec?fref=ts" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                    <a href="https://www.linkedin.com/company/selitec/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                    <a href="https://www.instagram.com/selitec.cl/" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                </div>
            </div>
            
            <div class="footer-col">
                <h3 class="footer-title">Enlaces Rápidos</h3>
                <ul class="footer-links">
                    <li><a href="../../cursos/">Catálogo de Cursos</a></li>
                    <li><a href="../../programacion/">Programación Mensual</a></li>
                    <li><a href="../../nivelacion/">Nivelación de Estudios</a></li>
                    <li><a href="https://www.selitec.cl/elearning">Plataforma E-learning</a></li>
                    <li><a href="../../politicas/">Políticas de Privacidad</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3 class="footer-title">Contacto</h3>
                <ul class="contact-list">
                    <li><i class="fas fa-phone" aria-hidden="true"></i> <a href="tel:+56226385307">+56 2 2638 5307</a></li>
                    <li><i class="fas fa-phone" aria-hidden="true"></i> <a href="tel:+56226397059">+56 2 2639 7059</a></li>
                    <li><i class="fas fa-envelope" aria-hidden="true"></i> <a href="mailto:contacto@selitec.cl">contacto@selitec.cl</a></li>
                </ul>
            </div>
        </div>
        <div class="site-footer__bottom">
            <div class="container">
                <p>&copy; 2025 Selitec Capacitación. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="../../app.js"></script>
</body>
</html>`;
}

// Exportar funciones
module.exports = {
    parseCursosFromMd,
    generateSlug,
    generateCourseHTML
};

// Si se ejecuta directamente desde Node.js
if (require.main === module) {
    console.log('Para generar las páginas, ejecuta: node generate-pages.js');
}
