<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!have_posts()) {
    get_header();
    ?>
    <main class="container section">
        <h1 class="section-title">Curso no encontrado</h1>
    </main>
    <?php
    get_footer();
    return;
}

the_post();
$post_id = get_the_ID();
$category_slug = tema_selitec_course_category_slug($post_id);
$category_label = tema_selitec_course_category_label($category_slug);
$modality = tema_selitec_course_modality($post_id);
$modality_label = tema_selitec_course_modality_label($modality);
$hours = tema_selitec_course_hours($post_id);
$syllabus_html = tema_selitec_course_syllabus_html($post_id);
$pdf_url = tema_selitec_course_pdf_url($post_id);
$description = tema_selitec_course_description($post_id);
$summary = wp_strip_all_tags($description);
$objectives = tema_selitec_course_objectives($post_id);

$related_courses = new WP_Query(array(
    'post_type' => 'course',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'post__not_in' => array($post_id),
    'tax_query' => array(
        array(
            'taxonomy' => 'course_category',
            'field' => 'slug',
            'terms' => array($category_slug),
        ),
    ),
));

$schema = array(
    '@context' => 'https://schema.org',
    '@type' => 'Course',
    'name' => get_the_title(),
    'description' => $summary,
    'provider' => array(
        '@type' => 'Organization',
        'name' => 'Selitec Capacitación',
        'url' => home_url('/'),
    ),
    'inLanguage' => 'es-CL',
    'timeRequired' => 'PT' . preg_replace('/\D+/', '', $hours) . 'H',
    'courseMode' => $modality_label,
);

get_header();
?>
<main class="course-page">
    <script type="application/ld+json"><?php echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>

    <nav class="breadcrumbs" aria-label="Breadcrumb">
        <div class="container">
            <ol>
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Inicio</a></li>
                <li><a href="<?php echo esc_url(home_url('/cursos/')); ?>">Cursos</a></li>
                <li><a href="<?php echo esc_url(home_url('/cursos/?category=' . $category_slug)); ?>"><?php echo esc_html($category_label); ?></a></li>
                <li aria-current="page"><?php the_title(); ?></li>
            </ol>
        </div>
    </nav>

    <section class="course-hero">
        <div class="container">
            <div class="course-hero__image">
                <img src="<?php echo esc_url(tema_selitec_course_image_url($post_id, $category_slug)); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" width="640" height="426" loading="eager">
            </div>
            <div class="course-hero__content">
                <div class="course-hero__badges">
                    <span class="badge <?php echo esc_attr(tema_selitec_course_category_badge_class($category_slug)); ?>"><?php echo esc_html($category_label); ?></span>
                    <span class="badge badge--modality"><?php echo esc_html($modality_label); ?></span>
                </div>
                <h1 class="course-hero__title"><?php the_title(); ?></h1>
                <p class="course-hero__duration"><i class="fas fa-clock"></i> <?php echo esc_html($hours); ?> horas</p>
                <div class="course-hero__text">
                    <h2>Descripción del Curso</h2>
                    <p><?php echo wp_kses_post($description); ?></p>
                    <h2>Objetivos Generales</h2>
                    <p><?php echo esc_html($objectives); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="course-content">
        <div class="container">
            <div class="course-content__grid">
                <div class="course-content__main">
                    <div class="course-syllabus">
                        <h2>Contenido del Curso</h2>
                        <div class="syllabus-content">
                            <?php echo $syllabus_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    </div>
                </div>

                <aside class="course-sidebar">
                    <div class="cta-box">
                        <h3>¿Te interesa este curso?</h3>
                        <a href="tel:+56226385307" class="btn btn--phone"><i class="fas fa-phone"></i> Llamar ahora</a>
                        <a href="https://wa.me/56226385307" class="btn btn--whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                        <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--secondary"><i class="fas fa-envelope"></i> Enviar consulta</a>
                    </div>

                    <div class="course-info-box">
                        <h3>Información del Curso</h3>
                        <ul>
                            <li><i class="fas fa-clock"></i><span><strong>Duración:</strong> <?php echo esc_html($hours); ?> horas</span></li>
                            <li><i class="fas fa-tag"></i><span><strong>Categoría:</strong> <?php echo esc_html($category_label); ?></span></li>
                            <li><i class="fas fa-certificate"></i><span><strong>Certificación:</strong> Disponible</span></li>
                            <li><i class="fas fa-map-marker-alt"></i><span><strong>Modalidad:</strong> <?php echo esc_html($modality_label); ?></span></li>
                        </ul>
                    </div>

                    <?php if ($pdf_url !== '') : ?>
                        <div class="download-box">
                            <h3>Descargar Temario</h3>
                            <a href="<?php echo esc_url($pdf_url); ?>" class="btn btn--download" download>
                                <i class="fas fa-file-pdf"></i> Descargar PDF
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if ($related_courses->have_posts()) : ?>
                        <div class="related-courses">
                            <h3>Cursos Relacionados</h3>
                            <ul>
                                <?php while ($related_courses->have_posts()) : $related_courses->the_post(); ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </aside>
            </div>
        </div>
    </section>
</main>
<?php
wp_reset_postdata();
get_footer();
