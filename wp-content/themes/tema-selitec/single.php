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
                <h1 class="section-title"><?php the_title(); ?></h1>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>
</main>
<?php
get_footer();
