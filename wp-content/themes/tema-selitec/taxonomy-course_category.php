<?php

if (!defined('ABSPATH')) {
    exit;
}

$term = get_queried_object();
$term_name = $term instanceof WP_Term ? $term->name : 'Categoría';
$term_slug = $term instanceof WP_Term ? $term->slug : '';

$query = new WP_Query(array(
    'post_type' => 'course',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'course_category',
            'field' => 'slug',
            'terms' => array($term_slug),
        ),
    ),
));

get_header();
?>
<main>
    <section class="hero hero--compact" style="background-image: linear-gradient(rgba(38, 34, 98, 0.85), rgba(38, 34, 98, 0.7)), url('<?php echo esc_url(tema_selitec_asset_url('assets/temario_todoslostemarios.jpg')); ?>');">
        <div class="container hero__content">
            <h1 class="hero__title"><?php echo esc_html($term_name); ?></h1>
            <p class="hero__subtitle">Cursos disponibles en esta categoría.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="courses-grid">
                <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <?php
                        $category_slug = tema_selitec_course_category_slug(get_the_ID());
                        $modality_label = tema_selitec_course_modality_label(tema_selitec_course_modality(get_the_ID()));
                        ?>
                        <article class="course-card">
                            <img src="<?php echo esc_url(tema_selitec_course_image_url(get_the_ID(), $category_slug)); ?>" alt="<?php the_title_attribute(); ?>" class="course-card__image" width="300" height="200" loading="lazy">
                            <div class="course-card__header">
                                <span class="badge <?php echo esc_attr(tema_selitec_course_category_badge_class($category_slug)); ?>"><?php echo esc_html(tema_selitec_course_category_label($category_slug)); ?></span>
                                <span class="badge badge--modality"><?php echo esc_html($modality_label); ?></span>
                            </div>
                            <div class="course-card__body">
                                <h2 class="course-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <p class="course-card__excerpt"><?php echo esc_html(tema_selitec_course_summary(get_the_ID())); ?></p>
                            </div>
                            <div class="course-card__footer">
                                <a href="<?php the_permalink(); ?>" class="btn btn--outline btn--full">Ver Temario</a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>No hay cursos disponibles en esta categoría.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<?php
wp_reset_postdata();
get_footer();
