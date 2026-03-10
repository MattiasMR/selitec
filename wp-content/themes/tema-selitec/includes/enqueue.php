<?php

if (!defined('ABSPATH')) {
    exit;
}

function tema_selitec_enqueue_assets(): void
{
    if (is_admin()) {
        return;
    }

    wp_enqueue_style(
        'tema-selitec-google-fonts',
        'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'tema-selitec-fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        array(),
        '6.4.0'
    );

    $styles_path = TEMA_SELITEC_DIR . '/assets/css/styles.css';
    wp_enqueue_style(
        'tema-selitec-styles',
        tema_selitec_asset_url('assets/css/styles.css'),
        array('tema-selitec-google-fonts', 'tema-selitec-fontawesome'),
        file_exists($styles_path) ? (string) filemtime($styles_path) : TEMA_SELITEC_VERSION
    );

    // WordPress-specific overrides (admin bar, full-height layout, etc.)
    $wp_overrides = '
        /* Full-height layout so footer stays at bottom */
        body { display: flex; flex-direction: column; min-height: 100vh; }
        main { flex: 1 0 auto; }
        .site-footer { flex-shrink: 0; }

        /* WP admin bar offset */
        .admin-bar .site-header { top: 32px; }
        @media screen and (max-width: 782px) {
            .admin-bar .site-header { top: 46px; }
        }

        /* Catalog layout – high-priority defense against plugin overrides */
        .container.catalog-layout {
            display: grid !important;
            grid-template-columns: 250px minmax(0, 1fr) !important;
            gap: 2rem;
            align-items: start;
        }
        .catalog-layout > .catalog-sidebar {
            grid-column: 1;
            grid-row: 1;
            max-width: 250px;
            min-width: 0;
            overflow: hidden;
        }
        .catalog-layout > .catalog-content {
            grid-column: 2;
            grid-row: 1;
            min-width: 0;
            width: 100%;
        }
        .catalog-content .courses-grid {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 2rem;
        }
        @media (max-width: 992px) {
            .catalog-content .courses-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
        @media (max-width: 768px) {
            .container.catalog-layout {
                grid-template-columns: 1fr !important;
            }
            .catalog-layout > .catalog-sidebar,
            .catalog-layout > .catalog-content {
                grid-column: 1;
                max-width: 100%;
            }
            .catalog-content .courses-grid {
                grid-template-columns: 1fr !important;
            }
        }
    ';
    wp_add_inline_style('tema-selitec-styles', $wp_overrides);

    // Build CURSOS_DATA exclusively from published WP courses.
    $wp_courses = get_posts(array(
        'post_type'      => 'course',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => array('menu_order' => 'ASC', 'title' => 'ASC'),
    ));

    $cursos_js = array();
    foreach ($wp_courses as $idx => $c) {
        $cid  = $c->ID;
        $slug = $c->post_name;
        $cat  = tema_selitec_course_category_slug($cid);
        $category_terms = wp_get_post_terms($cid, 'course_category');
        $cat_label = (!is_wp_error($category_terms) && !empty($category_terms) && isset($category_terms[0]->name))
            ? (string) $category_terms[0]->name
            : tema_selitec_course_category_label($cat);
        $cat_badge = tema_selitec_course_category_badge_class($cat);
        $mod  = tema_selitec_course_modality($cid);
        $hrs  = tema_selitec_course_hours($cid);
        $desc = tema_selitec_course_summary($cid);
        $img  = tema_selitec_course_image_url($cid, $cat);

        if (empty($slug) || empty($c->post_title)) {
            continue;
        }

        $cursos_js[] = array(
            'id'         => $idx + 1,
            'slug'       => $slug,
            'category'   => $cat,
            'categoryLabel' => $cat_label,
            'categoryBadge' => $cat_badge,
            'title'      => $c->post_title,
            'shortTitle' => $c->post_title,
            'modality'   => $mod,
            'hours'      => $hrs,
            'desc'       => $desc,
            'image'      => $img,
        );
    }

    wp_register_script('tema-selitec-cursos-data', '', array(), TEMA_SELITEC_VERSION, true);
    wp_enqueue_script('tema-selitec-cursos-data');
    wp_add_inline_script(
        'tema-selitec-cursos-data',
        'const CURSOS_DATA = ' . wp_json_encode($cursos_js, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ';'
    );

    $app_path = TEMA_SELITEC_DIR . '/assets/js/app.js';
    wp_enqueue_script(
        'tema-selitec-app',
        tema_selitec_asset_url('assets/js/app.js'),
        array('tema-selitec-cursos-data'),
        file_exists($app_path) ? (string) filemtime($app_path) : TEMA_SELITEC_VERSION,
        true
    );

    // Expose theme URL to JS so asset paths can be resolved.
    wp_localize_script('tema-selitec-app', 'selitecTheme', array(
        'url'  => trailingslashit(TEMA_SELITEC_URI),
        'home' => trailingslashit(home_url()),
    ));
}
add_action('wp_enqueue_scripts', 'tema_selitec_enqueue_assets', 20);

/**
 * Remove WP default styles that conflict with this theme.
 * Runs at priority 100 so these styles are already enqueued.
 */
function tema_selitec_dequeue_wp_styles(): void
{
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('global-styles');
    wp_dequeue_style('global-styles-inline');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('core-block-supports');
    wp_dequeue_style('wp-block-post-content');
}
add_action('wp_enqueue_scripts', 'tema_selitec_dequeue_wp_styles', 100);

/**
 * Remove WP block layout engine inline CSS that conflicts with theme grids.
 */
function tema_selitec_remove_layout_styles(): void
{
    // Prevent WP from injecting the block layout engine CSS
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
}
add_action('after_setup_theme', 'tema_selitec_remove_layout_styles');
