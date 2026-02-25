<?php

if (!defined('ABSPATH')) {
    exit;
}

if (post_password_required()) {
    return;
}
?>
<section id="comments" class="section" aria-label="Comentarios">
    <div class="container" style="max-width: 900px;">
        <?php if (have_comments()) : ?>
            <h2 class="section-title"><?php echo esc_html(get_comments_number()) . ' Comentarios'; ?></h2>
            <ol class="comment-list" style="display:flex; flex-direction:column; gap:1rem; margin-bottom:1.5rem;">
                <?php
                wp_list_comments(array(
                    'style' => 'ol',
                    'short_ping' => true,
                    'avatar_size' => 48,
                ));
                ?>
            </ol>

            <?php the_comments_pagination(); ?>
        <?php endif; ?>

        <?php
        comment_form(array(
            'class_submit' => 'btn btn--primary',
            'title_reply' => 'Deja un comentario',
            'label_submit' => 'Publicar comentario',
        ));
        ?>
    </div>
</section>
