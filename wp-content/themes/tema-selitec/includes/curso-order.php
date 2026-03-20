<?php
/**
 * Drag & Drop ordering for the 'course' CPT in wp-admin.
 *
 * - Enqueues jquery-ui-sortable + custom JS only on the course list screen.
 * - AJAX handler saves correlative menu_order values (0, 1, 2…).
 * - Ensures the admin list table is sorted by menu_order ASC.
 */

if (!defined('ABSPATH')) {
    exit;
}

/* ---------------------------------------------------------------
 * 1) Enqueue scripts on the course list screen only
 * ------------------------------------------------------------- */
function tema_selitec_admin_curso_order_scripts(string $hook): void
{
    if ('edit.php' !== $hook) {
        return;
    }

    $screen = get_current_screen();
    if (!$screen || 'course' !== $screen->post_type) {
        return;
    }

    wp_enqueue_script('jquery-ui-sortable');

    $js_path = TEMA_SELITEC_DIR . '/assets/js/admin-curso-order.js';
    wp_enqueue_script(
        'tema-selitec-curso-order',
        TEMA_SELITEC_URI . '/assets/js/admin-curso-order.js',
        array('jquery', 'jquery-ui-sortable'),
        file_exists($js_path) ? (string) filemtime($js_path) : TEMA_SELITEC_VERSION,
        true
    );

    wp_localize_script('tema-selitec-curso-order', 'cursoOrder', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('curso_order_nonce'),
    ));

    // Minimal inline CSS for the sortable placeholder row
    wp_add_inline_style('wp-admin', '
        .curso-sortable-placeholder {
            background: #f0f6fc !important;
            height: 40px;
            border: 2px dashed #2271b1;
        }
    ');
}
add_action('admin_enqueue_scripts', 'tema_selitec_admin_curso_order_scripts');

/* ---------------------------------------------------------------
 * 2) AJAX handler — saves correlative menu_order per position
 * ------------------------------------------------------------- */
function tema_selitec_ajax_update_curso_order(): void
{
    check_ajax_referer('curso_order_nonce', 'nonce');

    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Permiso denegado.', 403);
    }

    $order = isset($_POST['order']) ? array_map('intval', (array) $_POST['order']) : array();

    if (empty($order)) {
        wp_send_json_error('Sin IDs.', 400);
    }

    foreach ($order as $position => $post_id) {
        if ($post_id <= 0) {
            continue;
        }
        wp_update_post(array(
            'ID'         => $post_id,
            'menu_order' => (int) $position,
        ));
    }

    wp_send_json_success();
}
add_action('wp_ajax_update_curso_order', 'tema_selitec_ajax_update_curso_order');

/* ---------------------------------------------------------------
 * 3) Course taxonomy filter in admin list
 * ------------------------------------------------------------- */
function tema_selitec_course_admin_filter_taxonomy(): string
{
    if (taxonomy_exists('course_category') && is_object_in_taxonomy('course', 'course_category')) {
        return 'course_category';
    }

    $taxonomies = get_object_taxonomies('course', 'objects');
    foreach ($taxonomies as $taxonomy) {
        if (!($taxonomy instanceof WP_Taxonomy)) {
            continue;
        }

        if (!empty($taxonomy->show_ui)) {
            return (string) $taxonomy->name;
        }
    }

    return '';
}

function tema_selitec_course_admin_category_filter_dropdown(string $post_type): void
{
    if ($post_type !== 'course') {
        return;
    }

    $taxonomy = tema_selitec_course_admin_filter_taxonomy();
    if ($taxonomy === '') {
        return;
    }

    $tax_obj = get_taxonomy($taxonomy);
    if (!$tax_obj instanceof WP_Taxonomy) {
        return;
    }

    $selected = isset($_GET[$taxonomy]) ? sanitize_text_field((string) wp_unslash($_GET[$taxonomy])) : '';

    wp_dropdown_categories(array(
        'show_option_all' => $tax_obj->labels->all_items ?? __('Todas las categorías', 'tema-selitec'),
        'taxonomy'        => $taxonomy,
        'name'            => $taxonomy,
        'orderby'         => 'name',
        'selected'        => $selected,
        'show_count'      => false,
        'hide_empty'      => false,
        'hierarchical'    => (bool) $tax_obj->hierarchical,
        'value_field'     => 'slug',
    ));
}
add_action('restrict_manage_posts', 'tema_selitec_course_admin_category_filter_dropdown');

function tema_selitec_course_admin_apply_category_filter(WP_Query $query): void
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ('course' !== $query->get('post_type')) {
        return;
    }

    $taxonomy = tema_selitec_course_admin_filter_taxonomy();
    if ($taxonomy === '' || !isset($_GET[$taxonomy])) {
        return;
    }

    $selected = sanitize_text_field((string) wp_unslash($_GET[$taxonomy]));
    if ($selected === '') {
        return;
    }

    $query->set($taxonomy, sanitize_title($selected));
}
add_action('pre_get_posts', 'tema_selitec_course_admin_apply_category_filter');

/* ---------------------------------------------------------------
 * 4) Default admin list ordering: menu_order ASC
 *    Only when no explicit orderby is set by the user.
 * ------------------------------------------------------------- */
function tema_selitec_curso_default_order(WP_Query $query): void
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ('course' !== $query->get('post_type')) {
        return;
    }

    // Respect any explicit user sort (column header clicks)
    if ($query->get('orderby')) {
        return;
    }

    $query->set('orderby', 'menu_order');
    $query->set('order', 'ASC');
}
add_action('pre_get_posts', 'tema_selitec_curso_default_order');
