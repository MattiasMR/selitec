<?php

if (!defined('ABSPATH')) {
    exit;
}

function tema_selitec_course_category_map(): array
{
    return array(
        'maquinas' => 'Máquinas y equipos',
        'mantencion' => 'Mantención y producción',
        'seguridad' => 'Seguridad y prevención de riesgos',
        'computacion' => 'Computación',
    );
}

function tema_selitec_course_category_slug(int $post_id): string
{
    $terms = wp_get_post_terms($post_id, 'course_category', array('fields' => 'slugs'));
    if (is_wp_error($terms) || empty($terms)) {
        return 'mantencion';
    }

    return (string) $terms[0];
}

function tema_selitec_course_category_label(string $slug): string
{
    $map = tema_selitec_course_category_map();
    if (isset($map[$slug])) {
        return $map[$slug];
    }

    return ucwords(str_replace('-', ' ', $slug));
}

function tema_selitec_course_category_badge_class(string $slug): string
{
    if ($slug === 'computacion') {
        return 'badge--office';
    }

    return 'badge--technical';
}

function tema_selitec_course_fallback_image(string $category_slug): string
{
    $map = array(
        'maquinas' => 'assets/temario_maquinasYequipos.jpg',
        'mantencion' => 'assets/temario_mantencionYproduccion.jpg',
        'seguridad' => 'assets/temario_seguridadYprevencion.jpg',
        'computacion' => 'assets/temario_computacion.jpg',
    );

    return tema_selitec_asset_url($map[$category_slug] ?? 'assets/temario_todoslostemarios.jpg');
}

function tema_selitec_course_image_url(int $post_id, string $category_slug, string $size = 'large'): string
{
    $thumbnail = get_the_post_thumbnail_url($post_id, $size);
    if (!empty($thumbnail)) {
        return $thumbnail;
    }

    return tema_selitec_course_fallback_image($category_slug);
}

function tema_selitec_course_meta_first(int $post_id, array $keys, string $default = ''): string
{
    foreach ($keys as $key) {
        $value = trim((string) get_post_meta($post_id, $key, true));
        if ($value !== '') {
            return $value;
        }
    }

    return $default;
}

function tema_selitec_course_modality(int $post_id): string
{
    $raw = strtolower(tema_selitec_course_meta_first(
        $post_id,
        array('modality', 'course_modality', 'st_course_modality', 'modalidad', 'selitec_modality'),
        'presencial'
    ));

    return in_array($raw, array('presencial', 'elearning'), true) ? $raw : 'presencial';
}

function tema_selitec_course_modality_label(string $modality): string
{
    return $modality === 'elearning' ? 'E-learning' : 'Presencial';
}

function tema_selitec_course_hours(int $post_id): string
{
    return tema_selitec_course_meta_first(
        $post_id,
        array('hours', 'course_hours', 'duration', 'course_duration', 'duracion', 'selitec_hours'),
        'Consultar'
    );
}

function tema_selitec_course_summary(int $post_id): string
{
    $excerpt = trim((string) get_the_excerpt($post_id));
    if ($excerpt !== '') {
        return $excerpt;
    }

    $post = get_post($post_id);
    if ($post instanceof WP_Post) {
        $content = wp_strip_all_tags((string) $post->post_content);
        if ($content !== '') {
            return wp_trim_words($content, 26);
        }
    }

    return 'Curso técnico especializado de Selitec Capacitación.';
}

function tema_selitec_course_syllabus_html(int $post_id): string
{
    $syllabus = tema_selitec_course_meta_first(
        $post_id,
        array('syllabus_html', 'course_syllabus', 'st_syllabus', 'temario_html', 'selitec_syllabus')
    );

    if ($syllabus !== '') {
        return wp_kses_post($syllabus);
    }

    $post = get_post($post_id);
    if ($post instanceof WP_Post && trim((string) $post->post_content) !== '') {
        return apply_filters('the_content', $post->post_content);
    }

    return '<p>Temario disponible bajo solicitud en contacto@selitec.cl.</p>';
}

function tema_selitec_course_description(int $post_id): string
{
    return tema_selitec_course_meta_first(
        $post_id,
        array('course_description'),
        'El curso de <strong>' . esc_html(get_the_title($post_id)) . '</strong> está diseñado para entregar competencias técnicas específicas orientadas a la práctica profesional y al cumplimiento de estándares operativos.'
    );
}

function tema_selitec_course_pdf_url(int $post_id): string
{
    $pdf = tema_selitec_course_meta_first(
        $post_id,
        array('pdf', 'pdf_url', 'course_pdf', 'temario_pdf', 'selitec_pdf')
    );

    if ($pdf === '') {
        return '';
    }

    if (filter_var($pdf, FILTER_VALIDATE_URL)) {
        return esc_url_raw($pdf);
    }

    if (substr($pdf, 0, 1) === '/') {
        return esc_url_raw(home_url($pdf));
    }

    return esc_url_raw(tema_selitec_asset_url(ltrim($pdf, './')));
}
