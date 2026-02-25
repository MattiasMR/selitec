<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main class="container section">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>
                <div>
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <article>
            <h1><?php esc_html_e('Sin contenido', 'tema-selitec'); ?></h1>
            <p><?php esc_html_e('No se encontraron publicaciones.', 'tema-selitec'); ?></p>
        </article>
    <?php endif; ?>
</main>
<?php
get_footer();
