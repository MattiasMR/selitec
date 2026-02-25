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

            $date_raw = tema_selitec_course_meta_first($event_id, array('event_start_date', 'start_date', 'date', 'fecha_inicio'));
            if ($date_raw === '') {
                continue;
            }

            $date = DateTime::createFromFormat('Y-m-d', $date_raw);
            if (!$date) {
                $date = DateTime::createFromFormat('d/m/Y', $date_raw);
            }
            if (!$date || $date->format('Y-m') !== $month) {
                continue;
            }

            $course_id = (int) tema_selitec_course_meta_first($event_id, array('course_id', 'related_course_id'), '0');
            $course_url = $course_id > 0 ? get_permalink($course_id) : get_permalink($event_id);
            $course_title = $course_id > 0 ? get_the_title($course_id) : get_the_title($event_id);

            $modality = strtolower(tema_selitec_course_meta_first($event_id, array('modality', 'modalidad'), 'presencial'));
            $modality_label = $modality === 'elearning' ? 'E-learning' : 'Presencial';

            $rows[] = array(
                'title' => $course_title,
                'url' => $course_url,
                'modality' => $modality_label,
                'date' => $date->format('d M Y'),
                'time' => tema_selitec_course_meta_first($event_id, array('schedule', 'time', 'horario'), 'Por confirmar'),
                'status' => tema_selitec_course_meta_first($event_id, array('status', 'estado'), 'Confirmado'),
            );
        }
    }
    wp_reset_postdata();

    return $rows;
}
