<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main class="container section">
    <section class="text-center">
        <h1 class="section-title"><?php esc_html_e('Página no encontrada', 'tema-selitec'); ?></h1>
        <p><?php esc_html_e('La URL que buscaste no existe o fue movida.', 'tema-selitec'); ?></p>
        <p><a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary"><?php esc_html_e('Volver al inicio', 'tema-selitec'); ?></a></p>
    </section>
</main>
<?php
get_footer();
