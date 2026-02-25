<?php

if (!defined('ABSPATH')) {
    exit;
}

function tema_selitec_setup(): void
{
    load_theme_textdomain('tema-selitec', TEMA_SELITEC_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails', array('post', 'page', 'course', 'event'));
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('automatic-feed-links');
    add_theme_support('custom-logo');
    add_theme_support('woocommerce');

    // Prevent WP from treating this as a block theme
    // (templates/index.html exists only for installer validation)
    remove_theme_support('block-templates');

    register_nav_menus(array(
        'primary' => __('Navegación principal', 'tema-selitec'),
        'top'     => __('Navegación superior', 'tema-selitec'),
        'footer'  => __('Navegación footer', 'tema-selitec'),
    ));
}
add_action('after_setup_theme', 'tema_selitec_setup');

function tema_selitec_register_sidebars(): void
{
    $common = array(
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    );

    register_sidebar(array_merge($common, array(
        'name'        => __('Sidebar general', 'tema-selitec'),
        'id'          => 'sidebar_default',
        'description' => __('Sidebar por defecto para páginas y entradas.', 'tema-selitec'),
    )));

    register_sidebar(array_merge($common, array(
        'name'        => __('Sidebar cursos', 'tema-selitec'),
        'id'          => 'sidebar_course',
        'description' => __('Sidebar para fichas de curso.', 'tema-selitec'),
    )));

    register_sidebar(array_merge($common, array(
        'name'        => __('Sidebar eventos', 'tema-selitec'),
        'id'          => 'sidebar_event',
        'description' => __('Sidebar para fichas de evento.', 'tema-selitec'),
    )));
}
add_action('widgets_init', 'tema_selitec_register_sidebars');
