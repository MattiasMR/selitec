<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main class="container section">
    <header>
        <h1 class="section-title"><?php printf(esc_html__('Resultados para: %s', 'tema-selitec'), esc_html(get_search_query())); ?></h1>
    </header>

    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class('mb-4'); ?>>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php the_excerpt(); ?>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p><?php esc_html_e('No se encontraron resultados.', 'tema-selitec'); ?></p>
    <?php endif; ?>
</main>
<?php
get_footer();
