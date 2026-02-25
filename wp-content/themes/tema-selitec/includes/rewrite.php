<?php

if (!defined('ABSPATH')) {
    exit;
}

function tema_selitec_register_query_vars(array $vars): array
{
    $vars[] = 'programacion_mes';
    return $vars;
}
add_filter('query_vars', 'tema_selitec_register_query_vars');

function tema_selitec_add_rewrite_rules(): void
{
    add_rewrite_rule(
        '^programacion/([0-9]{4}-[0-9]{2})/?$',
        'index.php?programacion_mes=$matches[1]',
        'top'
    );
}
add_action('init', 'tema_selitec_add_rewrite_rules');

function tema_selitec_programacion_template_include(string $template): string
{
    $month = (string) get_query_var('programacion_mes');
    if ($month === '') {
        return $template;
    }

    $custom_template = TEMA_SELITEC_DIR . '/programacion-month.php';
    if (file_exists($custom_template)) {
        return $custom_template;
    }

    return $template;
}
add_filter('template_include', 'tema_selitec_programacion_template_include', 99);

function tema_selitec_after_switch_theme(): void
{
    tema_selitec_add_rewrite_rules();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'tema_selitec_after_switch_theme');
