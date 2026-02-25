<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main>
    <section class="hero hero--compact" style="background-image: linear-gradient(rgba(38, 34, 98, 0.85), rgba(38, 34, 98, 0.7)), url('<?php echo esc_url(tema_selitec_asset_url('assets/empresa.jpg')); ?>');">
        <div class="container hero__content">
            <h1 class="hero__title">Certificaciones</h1>
            <p class="hero__subtitle">Compromiso con la calidad y el cumplimiento de estándares para capacitación técnica.</p>
        </div>
    </section>

    <section class="section">
        <div class="container text-center">
            <h2 class="section-title">Calidad Certificada</h2>
            <p class="section-subtitle" style="margin-left:auto; margin-right:auto; max-width: 900px;">Selitec mantiene estándares formales de calidad para procesos de capacitación y gestión educativa.</p>

            <div class="certification-badges">
                <article class="cert-badge">
                    <img src="<?php echo esc_url(tema_selitec_asset_url('assets/SGS_NCh_2728_2015/For%20Office%20use/SGS_NCh_2728.Of2003_span_TCL.jpg')); ?>" alt="Certificación NCh 2728" style="max-height: 140px; margin-bottom: 1.5rem; object-fit: contain;" loading="lazy">
                    <h3 class="h4">Norma NCh 2728</h3>
                    <p style="font-size: .95rem; color: var(--c-text-muted); margin-top: .5rem;">Acreditación por SGS</p>
                </article>

                <article class="cert-badge">
                    <div style="width: 140px; height: 140px; display: flex; align-items: center; justify-content: center; border: 3px solid var(--c-secondary); border-radius: 50%; color: var(--c-secondary); font-weight: bold; font-size: 1.5rem; margin-bottom: 1.5rem;">SENCE</div>
                    <h3 class="h4">OTEC Vigente</h3>
                    <p style="font-size: .95rem; color: var(--c-text-muted); margin-top: .5rem;">Organismo Técnico de Capacitación</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section" style="background-color: var(--c-bg-light);">
        <div class="container text-center">
            <h2 class="section-title">¿Necesita respaldo documental?</h2>
            <p class="mb-4">Podemos compartir antecedentes de certificación y alcance de cursos para su proceso interno.</p>
            <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--primary">Solicitar Información</a>
        </div>
    </section>
</main>
<?php
get_footer();
