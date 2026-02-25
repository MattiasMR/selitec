<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main>
    <section class="hero hero--compact" style="background-image: linear-gradient(rgba(38, 34, 98, 0.85), rgba(38, 34, 98, 0.7)), url('<?php echo esc_url(tema_selitec_asset_url('assets/empresa.jpg')); ?>');">
        <div class="container hero__content">
            <h1 class="hero__title">Soluciones de Capacitación para Empresas</h1>
            <p class="hero__subtitle">Optimizamos el capital humano de su organización mediante cursos técnicos y gestión SENCE.</p>
            <div class="hero__actions">
                <a href="#contacto-empresa" class="btn btn--secondary">Solicitar Reunión</a>
            </div>
        </div>
    </section>

    <section class="accreditation-section">
        <div class="container accreditation-content">
            <div class="accreditation-text">
                <img src="<?php echo esc_url(tema_selitec_asset_url('assets/SGS_NCh_2728_2015/For%20Office%20use/SGS_NCh_2728.Of2003_span_TCL.jpg')); ?>" alt="Logo SGS" class="accreditation-logo" loading="lazy">
                <span>Acreditados por la NCH 2728 por SGS</span>
            </div>
            <div class="accreditation-text">
                <i class="fas fa-check-double" style="font-size: 2rem; color: var(--c-secondary); margin-right: 0.5rem;"></i>
                <span>Cursos con Franquicia Impulsa Personas Sence</span>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2 class="section-title">¿Por qué elegir Selitec?</h2>
            <p class="mb-4">Con 35 años de antigüedad, nos especializamos en capacitación técnica de alta calidad adaptada a necesidades reales de la industria chilena.</p>
            <ul class="check-list">
                <li>Cursos con Código SENCE vigente.</li>
                <li>Modalidad presencial, e-learning y mixta.</li>
                <li>Flexibilidad horaria para turnos de trabajo.</li>
                <li>Relatores expertos con experiencia de terreno.</li>
                <li>Gestión administrativa ágil y transparente.</li>
            </ul>
        </div>
    </section>

    <section class="section" style="background-color: var(--c-bg-light);">
        <div class="container">
            <h2 class="section-title text-center">Nuestros Servicios</h2>
            <div class="services-grid" style="margin-top: 3rem;">
                <article style="background: white; padding: 2rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); text-align: center;">
                    <div style="font-size: 3rem; color: var(--c-secondary); margin-bottom: 1rem;"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h3 class="h4 mb-2">Cursos Cerrados</h3>
                    <p>Llevamos la capacitación a sus instalaciones o realizamos cursos exclusivos para su personal.</p>
                </article>
                <article style="background: white; padding: 2rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); text-align: center;">
                    <div style="font-size: 3rem; color: var(--c-secondary); margin-bottom: 1rem;"><i class="fas fa-file-invoice-dollar"></i></div>
                    <h3 class="h4 mb-2">Gestión Franquicia SENCE</h3>
                    <p>Asesoramos en el uso eficiente de la franquicia para maximizar su presupuesto de capacitación.</p>
                </article>
                <article style="background: white; padding: 2rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); text-align: center;">
                    <div style="font-size: 3rem; color: var(--c-secondary); margin-bottom: 1rem;"><i class="fas fa-search"></i></div>
                    <h3 class="h4 mb-2">Detección de Necesidades</h3>
                    <p>Identificamos brechas de competencias para diseñar planes de formación efectivos.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="contacto-empresa" class="section" style="background-color: var(--c-primary); color: white;">
        <div class="container text-center">
            <h2 class="section-title" style="color:white;">¿Listo para potenciar su equipo?</h2>
            <p class="mb-4" style="font-size: 1.2rem; opacity: 0.9;">Contáctenos hoy para diseñar una propuesta a medida.</p>
            <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--secondary">Contactar Área Empresas</a>
        </div>
    </section>
</main>
<?php
get_footer();
