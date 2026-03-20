<?php

if (!defined('ABSPATH')) {
    exit;
}

$category_terms = get_terms(array(
    'taxonomy'   => 'course_category',
    'hide_empty' => false,
    'orderby'    => 'name',
    'order'      => 'ASC',
));

$category_options = array();
if (!is_wp_error($category_terms)) {
    foreach ($category_terms as $term) {
        $category_options[$term->slug] = $term->name;
    }
}

if (empty($category_options)) {
    $category_options = tema_selitec_course_category_map();
}

$modality_options = function_exists('tema_selitec_course_modality_options')
    ? tema_selitec_course_modality_options()
    : array(
        'presencial' => 'Presencial',
        'elearning' => 'E-learning',
        'presencial-elearning' => 'Presencial - E-learning',
    );

get_header();
?>
<main>
    <section class="hero hero--compact" style="background-image: linear-gradient(rgba(38, 34, 98, 0.85), rgba(38, 34, 98, 0.7)), url('<?php echo esc_url(tema_selitec_asset_url('assets/temario_todoslostemarios.jpg')); ?>');">
        <div class="container hero__content">
            <h1 class="hero__title">Catálogo de Cursos</h1>
            <p class="hero__subtitle">Explore nuestra oferta de capacitación técnica y habilidades transversales.</p>
        </div>
    </section>

    <div class="container catalog-layout">
        <aside class="catalog-sidebar">
                <div class="filter-group">
                    <h3 class="filter-title">Buscar</h3>
                    <div class="search-box">
                        <input type="text" id="course-search" placeholder="Ej: Calderas, Excel..." aria-label="Buscar curso">
                        <button aria-label="Buscar"><i class="fas fa-search"></i></button>
                    </div>
                </div>

                <div class="filter-group">
                    <h3 class="filter-title">Categoría</h3>
                    <ul class="filter-list" id="category-filters">
                        <?php foreach ($category_options as $slug => $label) : ?>
                            <li>
                                <label class="checkbox-label">
                                    <input type="checkbox" value="<?php echo esc_attr($slug); ?>" checked>
                                    <span class="checkbox-custom"></span>
                                    <?php echo esc_html($label); ?>
                                </label>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="filter-group">
                    <h3 class="filter-title">Modalidad</h3>
                    <ul class="filter-list" id="modality-filters">
                        <?php foreach ($modality_options as $slug => $label) : ?>
                            <li>
                                <label class="checkbox-label">
                                    <input type="checkbox" value="<?php echo esc_attr($slug); ?>" checked>
                                    <span class="checkbox-custom"></span>
                                    <?php echo esc_html($label); ?>
                                </label>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
        </aside>

        <section class="catalog-content">
            <div class="catalog-status" aria-live="polite">
                Mostrando <span id="result-count">0</span> cursos disponibles
            </div>

            <div id="courses-grid" class="courses-grid">
                <div class="loading-spinner">Cargando cursos...</div>
            </div>
        </section>
    </div>

    <section class="section faq-section">
        <div class="container" style="max-width: 800px;">
            <h2 class="section-title text-center">Preguntas Frecuentes</h2>
            <div class="accordion" id="faq-accordion">
                <div class="accordion-item">
                    <button class="accordion-header" aria-expanded="false" aria-controls="faq1">
                        <span class="accordion-title">¿Los cursos incluyen temario y certificación?</span>
                        <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
                    </button>
                    <div id="faq1" class="accordion-content" hidden>
                        <div class="accordion-body">
                            <p>Sí, todos los cursos cuentan con su temario detallado. Además, si tiene un requerimiento específico para su empresa, podemos codificar y adaptar el curso según sus necesidades (SENCE).</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-header" aria-expanded="false" aria-controls="faq2">
                        <span class="accordion-title">¿Cómo me inscribo en un curso?</span>
                        <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
                    </button>
                    <div id="faq2" class="accordion-content" hidden>
                        <div class="accordion-body">
                            <p>Puede inscribirse por WhatsApp, llamando al +56 2 2638 5307 y al +56 2 2639 7059, o en nuestro formulario de contacto.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-header" aria-expanded="false" aria-controls="faq3">
                        <span class="accordion-title">¿Entregan certificado al finalizar?</span>
                        <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
                    </button>
                    <div id="faq3" class="accordion-content" hidden>
                        <div class="accordion-body">
                            <p>Sí, los participantes que cumplan requisitos de asistencia y evaluación reciben certificado oficial de Selitec.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4" style="margin-top: 2rem;">
                <p class="mb-2">¿Más dudas sobre inscripciones?</p>
                <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--primary">Ir a Formulario de Contacto</a>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
