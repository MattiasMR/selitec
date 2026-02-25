<?php

if (!defined('ABSPATH')) {
    exit;
}

function tema_selitec_register_post_types(): void
{
    register_post_type('course', array(
        'labels' => array(
            'name'          => __('Cursos', 'tema-selitec'),
            'singular_name' => __('Curso', 'tema-selitec'),
            'menu_name'     => __('Cursos', 'tema-selitec'),
            'all_items'     => __('Todos los cursos', 'tema-selitec'),
            'add_new_item'  => __('Agregar curso', 'tema-selitec'),
            'edit_item'     => __('Editar curso', 'tema-selitec'),
            'view_item'     => __('Ver curso', 'tema-selitec'),
            'search_items'  => __('Buscar cursos', 'tema-selitec'),
        ),
        'public'       => true,
        'show_ui'      => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-welcome-learn-more',
        'rewrite'      => array('slug' => 'curso', 'with_front' => false),
        'has_archive'  => false,
        'supports'     => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions'),
    ));

    register_post_type('event', array(
        'labels' => array(
            'name'          => __('Eventos', 'tema-selitec'),
            'singular_name' => __('Evento', 'tema-selitec'),
            'menu_name'     => __('Eventos', 'tema-selitec'),
            'all_items'     => __('Todos los eventos', 'tema-selitec'),
            'add_new_item'  => __('Agregar evento', 'tema-selitec'),
            'edit_item'     => __('Editar evento', 'tema-selitec'),
            'view_item'     => __('Ver evento', 'tema-selitec'),
            'search_items'  => __('Buscar eventos', 'tema-selitec'),
        ),
        'public'       => true,
        'show_ui'      => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-calendar-alt',
        'rewrite'      => array('slug' => 'evento', 'with_front' => false),
        'has_archive'  => false,
        'supports'     => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions'),
    ));
}
add_action('init', 'tema_selitec_register_post_types');
