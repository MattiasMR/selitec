<?php

if (!defined('ABSPATH')) {
    exit;
}

function tema_selitec_register_taxonomies(): void
{
    register_taxonomy('course_category', array('course'), array(
        'labels' => array(
            'name'          => __('Categorías de cursos', 'tema-selitec'),
            'singular_name' => __('Categoría de curso', 'tema-selitec'),
            'search_items'  => __('Buscar categorías', 'tema-selitec'),
            'all_items'     => __('Todas las categorías', 'tema-selitec'),
            'edit_item'     => __('Editar categoría', 'tema-selitec'),
            'update_item'   => __('Actualizar categoría', 'tema-selitec'),
            'add_new_item'  => __('Agregar nueva categoría', 'tema-selitec'),
            'menu_name'     => __('Categorías', 'tema-selitec'),
        ),
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'hierarchical'      => true,
        'rewrite'           => array('slug' => 'cursos/categoria', 'with_front' => false),
    ));
}
add_action('init', 'tema_selitec_register_taxonomies');
