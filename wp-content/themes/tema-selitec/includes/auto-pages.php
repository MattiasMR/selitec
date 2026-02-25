<?php
/**
 * Auto-create required pages on theme activation.
 *
 * WordPress page-{slug}.php templates only work when a WP page with that slug
 * exists in the database. This file ensures those pages are created automatically.
 *
 * @package tema-selitec
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Pages required by the theme's page-{slug}.php templates.
 * Format: slug => title.
 */
function tema_selitec_required_pages(): array
{
    return array(
        'inicio'          => 'Inicio',
        'cursos'          => 'Catálogo de Cursos',
        'empresa'         => 'Empresa',
        'contacto'        => 'Contacto',
        'clientes'        => 'Clientes',
        'nivelacion'      => 'Nivelación de Estudios',
        'programacion'    => 'Programación Mensual',
        'certificaciones' => 'Certificaciones',
    );
}

/**
 * Create missing pages and configure Reading Settings.
 *
 * Hooked to after_switch_theme so it runs once when the theme is activated.
 * Safe to run multiple times — it skips pages that already exist.
 */
function tema_selitec_create_pages(): void
{
    $pages = tema_selitec_required_pages();
    $created_ids = array();

    foreach ($pages as $slug => $title) {
        // Check if a page with this slug already exists (any status).
        $existing = get_page_by_path($slug, OBJECT, 'page');
        if ($existing instanceof WP_Post) {
            $created_ids[$slug] = $existing->ID;
            // Ensure it's published.
            if ($existing->post_status !== 'publish') {
                wp_update_post(array(
                    'ID'          => $existing->ID,
                    'post_status' => 'publish',
                ));
            }
            continue;
        }

        $page_id = wp_insert_post(array(
            'post_title'   => $title,
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
            'post_author'  => 1,
        ));

        if (!is_wp_error($page_id)) {
            $created_ids[$slug] = $page_id;
        }
    }

    // Configure Reading Settings: use "inicio" as static front page.
    if (isset($created_ids['inicio'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $created_ids['inicio']);
    }

    // Flush rewrite rules so CPT slugs and custom rewrites work immediately.
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'tema_selitec_create_pages');

/**
 * Admin notice shown once after theme activation.
 */
function tema_selitec_activation_notice(): void
{
    if (get_transient('tema_selitec_activated') !== '1') {
        return;
    }
    delete_transient('tema_selitec_activated');

    $pages = tema_selitec_required_pages();
    $list = implode(', ', $pages);

    echo '<div class="notice notice-success is-dismissible">';
    echo '<p><strong>Tema Selitec activado.</strong> Se verificaron/crearon las páginas: ' . esc_html($list) . '.</p>';
    echo '<p>Configuración de lectura ajustada: página de inicio estática = "Inicio".</p>';
    echo '</div>';
}
add_action('admin_notices', 'tema_selitec_activation_notice');

/**
 * Set activation transient so the admin notice fires once.
 */
function tema_selitec_set_activation_transient(): void
{
    set_transient('tema_selitec_activated', '1', 60);
}
add_action('after_switch_theme', 'tema_selitec_set_activation_transient');
