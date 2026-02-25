<?php

if (!defined('ABSPATH')) {
    exit;
}

$author = get_queried_object();
$name = ($author instanceof WP_User) ? $author->display_name : 'Autor';

get_header();
?>
<main class="container section">
    <header class="mb-4">
        <h1 class="section-title">Publicaciones de <?php echo esc_html($name); ?></h1>
    </header>

    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class('mb-4'); ?>>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p><?php echo esc_html(get_the_date()); ?></p>
                <?php the_excerpt(); ?>
            </article>
        <?php endwhile; ?>

        <nav aria-label="Paginación de autor">
            <?php the_posts_pagination(); ?>
        </nav>
    <?php else : ?>
        <p>No hay publicaciones disponibles para este autor.</p>
    <?php endif; ?>
</main>
<?php
get_footer();
