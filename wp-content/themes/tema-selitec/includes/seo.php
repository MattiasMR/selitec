<?php

if (!defined('ABSPATH')) {
    exit;
}

function tema_selitec_meta_description_text(): string
{
    if (is_singular('course')) {
        return tema_selitec_course_summary(get_the_ID());
    }

    if (is_page('cursos')) {
        return 'Catálogo de cursos técnicos SELITEC. Filtra por área y modalidad para encontrar la capacitación adecuada.';
    }

    if (is_page('programacion') || get_query_var('programacion_mes') !== '') {
        return 'Programación mensual de cursos SELITEC en formato HTML indexable, con enlaces directos a fichas de curso.';
    }

    if (is_page('nivelacion')) {
        return 'Programa de nivelación de estudios para adultos con apoyo docente y preparación para exámenes libres.';
    }

    if (is_page('empresa')) {
        return 'Servicios de capacitación para empresas con gestión SENCE, cursos cerrados y detección de necesidades.';
    }

    if (is_page('contacto')) {
        return 'Contacto SELITEC para cotizaciones, consultas de cursos y coordinación de capacitación.';
    }

    if (is_front_page()) {
        return 'SELITEC Capacitación: cursos técnicos, programación mensual y formación para empresas y trabajadores en Chile.';
    }

    if (is_singular()) {
        $excerpt = get_the_excerpt();
        if (!empty($excerpt)) {
            return wp_strip_all_tags($excerpt);
        }
    }

    return 'SELITEC Capacitación: cursos técnicos, nivelación de estudios y soluciones de formación para empresas.';
}

function tema_selitec_output_meta_description(): void
{
    $description = trim(tema_selitec_meta_description_text());
    if ($description === '') {
        return;
    }

    echo '<meta name="description" content="' . esc_attr(wp_trim_words($description, 28, '...')) . '">' . "\n";
}
add_action('wp_head', 'tema_selitec_output_meta_description', 2);

function tema_selitec_output_programacion_canonical(): void
{
    $month = (string) get_query_var('programacion_mes');
    if ($month === '') {
        return;
    }

    echo '<link rel="canonical" href="' . esc_url(home_url('/programacion/' . $month . '/')) . '">' . "\n";
}
add_action('wp_head', 'tema_selitec_output_programacion_canonical', 3);

function tema_selitec_output_organization_schema(): void
{
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        '@id' => home_url('/#organization'),
        'name' => 'Selitec Capacitación',
        'url' => home_url('/'),
        'logo' => tema_selitec_asset_url('assets/logo_selitec.jpg'),
        'contactPoint' => array(
            array(
                '@type' => 'ContactPoint',
                'telephone' => '+56-2-2638-5307',
                'contactType' => 'customer service',
            ),
        ),
        'email' => 'contacto@selitec.cl',
    );

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'tema_selitec_output_organization_schema', 20);
