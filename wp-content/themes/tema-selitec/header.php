<?php

if (!defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php get_template_part('template-parts/site/top-bar'); ?>
<header class="site-header">
    <div class="container site-header__inner">
        <div class="site-logo">
            <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="Volver al inicio">
                <img src="<?php echo esc_url(tema_selitec_asset_url('assets/logo_selitec.jpg')); ?>" alt="SELITEC" class="site-logo__img" width="174" height="70" loading="eager">
            </a>
        </div>

        <button class="mobile-menu-toggle" aria-label="Abrir menú de navegación" aria-expanded="false" aria-controls="main-nav">
            <span class="hamburger-icon"></span>
        </button>

        <?php get_template_part('template-parts/site/main-nav'); ?>
    </div>
</header>
