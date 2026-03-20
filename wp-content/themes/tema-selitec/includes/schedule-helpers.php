<?php

if (!defined('ABSPATH')) {
    exit;
}

function tema_selitec_programacion_month_label(string $month): string
{
    $parts = explode('-', $month);
    if (count($parts) !== 2) {
        return $month;
    }

    $year = (int) $parts[0];
    $month_num = (int) $parts[1];
    if ($year < 2000 || $month_num < 1 || $month_num > 12) {
        return $month;
    }

    $names = array(
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    );

    return $names[$month_num] . ' ' . $year;
}

function tema_selitec_programacion_prev_month(string $month): string
{
    $dt = DateTime::createFromFormat('Y-m', $month);
    if (!$dt) {
        return '';
    }

    $dt->modify('-1 month');
    return $dt->format('Y-m');
}

function tema_selitec_programacion_next_month(string $month): string
{
    $dt = DateTime::createFromFormat('Y-m', $month);
    if (!$dt) {
        return '';
    }

    $dt->modify('+1 month');
    return $dt->format('Y-m');
}

function tema_selitec_programacion_parse_date(string $raw): string
{
    if (function_exists('tema_selitec_event_parse_iso_date')) {
        return tema_selitec_event_parse_iso_date($raw);
    }

    $raw = trim($raw);
    if ($raw === '') {
        return '';
    }

    if (preg_match('/^(\d{4}-\d{2}-\d{2})/', $raw, $matches) === 1) {
        $raw = $matches[1];
    }

    $formats = array('Y-m-d', 'd/m/Y', 'd-m-Y', 'Y/m/d');
    foreach ($formats as $format) {
        $date = DateTime::createFromFormat('!' . $format, $raw);
        if ($date instanceof DateTime && $date->format($format) === $raw) {
            return $date->format('Y-m-d');
        }
    }

    return '';
}

function tema_selitec_programacion_date_label(string $iso_date): string
{
    if ($iso_date === '') {
        return 'Por confirmar';
    }

    $date = DateTime::createFromFormat('Y-m-d', $iso_date);
    if (!$date) {
        return 'Por confirmar';
    }

    return $date->format('d/m/Y');
}

function tema_selitec_programacion_event_type(int $event_id): string
{
    $raw = tema_selitec_course_meta_first($event_id, array('event_type'), 'programacion');
    if (function_exists('tema_selitec_event_normalize_type')) {
        return tema_selitec_event_normalize_type($raw);
    }

    $raw = strtolower(remove_accents(trim($raw)));
    return in_array($raw, array('otros', 'otro', 'demanda', 'contacto'), true) ? 'otros' : 'programacion';
}

function tema_selitec_programacion_modality_label(int $event_id): string
{
    $raw = tema_selitec_course_meta_first($event_id, array('modality', 'modalidad', 'online'), 'presencial');

    if (function_exists('tema_selitec_event_normalize_modality')) {
        $normalized = tema_selitec_event_normalize_modality($raw);
    } else {
        $normalized = strtolower(remove_accents(trim($raw)));
    }

    if ($normalized === 'presencial-elearning') {
        return 'Presencial - E-learning';
    }

    if ($normalized === 'elearning' || $normalized === 'online') {
        return 'E-learning';
    }

    return 'Presencial';
}

function tema_selitec_programacion_status_data(int $event_id): array
{
    $raw = tema_selitec_course_meta_first($event_id, array('status', 'estado'), 'abierto');

    if (function_exists('tema_selitec_event_normalize_status')) {
        $normalized = tema_selitec_event_normalize_status($raw);
    } else {
        $normalized = strtolower(remove_accents(trim($raw)));
    }

    if ($normalized === 'cerrado') {
        return array(
            'label' => 'Cerrado',
            'dot_class' => 'status-dot--red',
        );
    }

    if ($normalized === 'ultimos-cupos') {
        return array(
            'label' => 'Últimos cupos',
            'dot_class' => 'status-dot--yellow',
        );
    }

    return array(
        'label' => 'Abierto',
        'dot_class' => 'status-dot--green',
    );
}

function tema_selitec_programacion_row_from_event(int $event_id): array
{
    $start_iso = tema_selitec_programacion_parse_date(
        tema_selitec_course_meta_first($event_id, array('event_start_date', 'start_date', 'date', 'fecha_inicio'))
    );

    $end_iso = tema_selitec_programacion_parse_date(
        tema_selitec_course_meta_first($event_id, array('event_end_date', 'end_date', 'fecha_termino', 'fecha_fin'))
    );

    $course_id = (int) tema_selitec_course_meta_first($event_id, array('related_course_id', 'course_id'), '0');
    $target_url = $course_id > 0 ? get_permalink($course_id) : get_permalink($event_id);

    $status = tema_selitec_programacion_status_data($event_id);

    return array(
        'title' => get_the_title($event_id),
        'url' => $target_url,
        'modality' => tema_selitec_programacion_modality_label($event_id),
        'start_date' => tema_selitec_programacion_date_label($start_iso),
        'end_date' => tema_selitec_programacion_date_label($end_iso),
        'class_days' => tema_selitec_course_meta_first($event_id, array('event_class_days', 'dias_clases', 'dias'), 'Por confirmar'),
        'time' => tema_selitec_course_meta_first($event_id, array('schedule', 'time', 'horario'), 'Por confirmar'),
        'status' => $status['label'],
        'status_dot_class' => $status['dot_class'],
        'event_type' => tema_selitec_programacion_event_type($event_id),
        'start_month' => $start_iso !== '' ? substr($start_iso, 0, 7) : '',
        'sort_start' => $start_iso,
    );
}

function tema_selitec_programacion_rows(string $month): array
{
    $rows = array();

    $events_query = new WP_Query(array(
        'post_type' => 'event',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC',
    ));

    if ($events_query->have_posts()) {
        while ($events_query->have_posts()) {
            $events_query->the_post();
            $event_id = get_the_ID();
            $row = tema_selitec_programacion_row_from_event($event_id);

            if ($row['event_type'] !== 'programacion') {
                continue;
            }

            if ($row['start_month'] !== $month) {
                continue;
            }

            $rows[] = $row;
        }
    }

    wp_reset_postdata();

    usort($rows, static function (array $a, array $b): int {
        return strcmp((string) $a['sort_start'], (string) $b['sort_start']);
    });

    foreach ($rows as &$row) {
        unset($row['sort_start'], $row['event_type'], $row['start_month']);
    }
    unset($row);

    return $rows;
}

function tema_selitec_programacion_otros_rows(): array
{
    $rows = array();

    $events_query = new WP_Query(array(
        'post_type' => 'event',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    ));

    if ($events_query->have_posts()) {
        while ($events_query->have_posts()) {
            $events_query->the_post();
            $event_id = get_the_ID();
            $row = tema_selitec_programacion_row_from_event($event_id);

            if ($row['event_type'] !== 'otros') {
                continue;
            }

            $rows[] = array(
                'title' => $row['title'],
                'url' => $row['url'],
            );
        }
    }

    wp_reset_postdata();

    return $rows;
}
