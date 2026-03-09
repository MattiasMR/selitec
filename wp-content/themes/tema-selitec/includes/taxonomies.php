<?php

if (!defined('ABSPATH')) {
    exit;
}

function tema_selitec_allowed_course_categories(): array
{
    return array(
        'maquinas'    => 'Máquinas y equipos',
        'mantencion'  => 'Mantención y producción',
        'seguridad'   => 'Seguridad y prevención de riesgos',
        'computacion' => 'Computación',
    );
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

function tema_selitec_sync_course_category_terms(): void
{
    $taxonomy = 'course_category';
    $allowed  = tema_selitec_allowed_course_categories();

    foreach ($allowed as $slug => $name) {
        $term = get_term_by('slug', $slug, $taxonomy);
        if (!$term) {
            wp_insert_term($name, $taxonomy, array('slug' => $slug));
        }
    }

    $fallback_term = get_term_by('slug', 'mantencion', $taxonomy);
    $fallback_id = ($fallback_term && !is_wp_error($fallback_term)) ? (int) $fallback_term->term_id : 0;

    $terms = get_terms(array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
    ));

    if (is_wp_error($terms) || empty($terms)) {
        return;
    }

    foreach ($terms as $term) {
        if (!isset($allowed[$term->slug])) {
            wp_delete_term((int) $term->term_id, $taxonomy, array('default' => $fallback_id));
        }
    }
}
add_action('init', 'tema_selitec_sync_course_category_terms', 20);

function tema_selitec_restrict_course_category_insert($term, $taxonomy)
{
    if ($taxonomy !== 'course_category') {
        return $term;
    }

    $allowed = tema_selitec_allowed_course_categories();

    // Check if the sanitized name matches an allowed slug key.
    $normalized = sanitize_title($term);
    if (isset($allowed[$normalized])) {
        return $term;
    }

    // Check if the term name matches an allowed display name
    // (wp_insert_term passes the name, not the slug).
    if (in_array($term, $allowed, true)) {
        return $term;
    }

    return new WP_Error(
        'invalid_course_category',
        __('Solo se permiten las 4 categorias oficiales de cursos.', 'tema-selitec')
    );
}
add_filter('pre_insert_term', 'tema_selitec_restrict_course_category_insert', 10, 2);
