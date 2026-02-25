<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main>
    <section class="hero hero--compact" style="background-image: linear-gradient(rgba(38, 34, 98, 0.85), rgba(38, 34, 98, 0.7)), url('<?php echo esc_url(tema_selitec_asset_url('assets/nivelacion.jpg')); ?>');">
        <div class="container hero__content">
            <h1 class="hero__title">Termina tu Enseñanza Media</h1>
            <p class="hero__subtitle">Programa de nivelación de estudios para adultos con preparación para exámenes libres.</p>
            <div class="hero__actions"><a href="#inscripcion" class="btn btn--secondary">¡Inscríbete Ahora!</a></div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2 class="section-title">¿Por qué nivelar tus estudios?</h2>
            <p class="mb-4">Completar la enseñanza media ayuda a acceder a mejores empleos, continuar estudios técnicos y mejorar oportunidades personales.</p>
            <ul class="check-list">
                <li>Acceso a mejores ofertas laborales.</li>
                <li>Requisito para cursos de certificación laboral.</li>
                <li>Posibilidad de seguir estudios técnicos o superiores.</li>
                <li>Superación personal y familiar.</li>
            </ul>
        </div>
    </section>

    <section class="section" style="background-color: var(--c-bg-light);">
        <div class="container">
            <h2 class="section-title text-center">¿Cómo funciona el proceso?</h2>
            <div class="grid grid--3-cols" style="margin-top: 3rem;">
                <article class="step-card">
                    <div style="background: var(--c-primary); color: white; width: 40px; height: 40px; border-radius: 50%; display:flex; align-items:center; justify-content:center; font-weight:700; margin: 0 auto 1rem auto;">1</div>
                    <h3 class="h4 mb-2">Inscripción</h3>
                    <div class="step-details" style="max-height: none; opacity:1; margin-top:0;">
                        <p>Validación de antecedentes en portal MINEDUC y revisión de documentos de ingreso.</p>
                    </div>
                </article>
                <article class="step-card">
                    <div style="background: var(--c-primary); color: white; width: 40px; height: 40px; border-radius: 50%; display:flex; align-items:center; justify-content:center; font-weight:700; margin: 0 auto 1rem auto;">2</div>
                    <h3 class="h4 mb-2">Preparación</h3>
                    <div class="step-details" style="max-height: none; opacity:1; margin-top:0;">
                        <p>Clases de apoyo presenciales u online con material enfocado en temario oficial.</p>
                    </div>
                </article>
                <article class="step-card">
                    <div style="background: var(--c-primary); color: white; width: 40px; height: 40px; border-radius: 50%; display:flex; align-items:center; justify-content:center; font-weight:700; margin: 0 auto 1rem auto;">3</div>
                    <h3 class="h4 mb-2">Examen y Certificación</h3>
                    <div class="step-details" style="max-height: none; opacity:1; margin-top:0;">
                        <p>Rendición de pruebas oficiales y obtención de licencia de enseñanza media al aprobar.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title text-center">Preguntas Frecuentes</h2>
            <div class="accordion">
                <div class="accordion-item">
                    <button class="accordion-header" aria-expanded="false" aria-controls="nfaq1"><span class="accordion-title">¿Cuánto dura el proceso?</span><span class="accordion-icon"><i class="fas fa-chevron-down"></i></span></button>
                    <div id="nfaq1" class="accordion-content" hidden><div class="accordion-body"><p>Depende de modalidad y cursos a nivelar; en general entre 3 y 5 meses de preparación.</p></div></div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header" aria-expanded="false" aria-controls="nfaq2"><span class="accordion-title">¿Qué documentos necesito?</span><span class="accordion-icon"><i class="fas fa-chevron-down"></i></span></button>
                    <div id="nfaq2" class="accordion-content" hidden><div class="accordion-body"><p>Certificados de estudios previos en MINEDUC y cédula de identidad vigente.</p></div></div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header" aria-expanded="false" aria-controls="nfaq3"><span class="accordion-title">¿Tiene costo?</span><span class="accordion-icon"><i class="fas fa-chevron-down"></i></span></button>
                    <div id="nfaq3" class="accordion-content" hidden><div class="accordion-body"><p>Puede variar según modalidad, becas y acceso por franquicia tributaria de empresa.</p></div></div>
                </div>
            </div>
        </div>
    </section>

    <section id="inscripcion" class="section" style="background-color: var(--c-primary); color: white;">
        <div class="container text-center">
            <h2 class="section-title" style="color:white;">¡Da el siguiente paso en tu vida!</h2>
            <p class="mb-4" style="font-size: 1.2rem; opacity: 0.9;">Termina tu cuarto medio con apoyo docente y preparación guiada.</p>
            <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
                <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--secondary">Inscribirme Ahora</a>
                <a href="https://wa.me/56226385307" class="btn btn--whatsapp"><i class="fab fa-whatsapp"></i> Consultar por WhatsApp</a>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
