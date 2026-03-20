<?php
/**
 * Event meta boxes and admin behavior for the "Evento" CPT.
 *
 * @package tema-selitec
 */

if (!defined('ABSPATH')) {
    exit;
}

function tema_selitec_event_modality_options(): array
{
    return array(
        'presencial' => 'Presencial',
        'elearning' => 'E-learning',
        'presencial-elearning' => 'Presencial - E-learning',
    );
}

function tema_selitec_event_status_options(): array
{
    return array(
        'abierto' => 'Abierto',
        'cerrado' => 'Cerrado',
        'ultimos-cupos' => 'Últimos cupos',
    );
}

function tema_selitec_event_leveling_options(): array
{
    return array(
        '1ro' => '1ro medio',
        '2do' => '2do medio',
        '3ro' => '3ro medio',
        '4to' => '4to medio',
        'none' => 'Ninguno',
    );
}

function tema_selitec_event_type_options(): array
{
    return array(
        'programacion' => 'Programación mensual',
        'otros' => 'Otros (por demanda/contacto)',
    );
}

function tema_selitec_event_meta_first(int $post_id, array $keys)
{
    foreach ($keys as $key) {
        $value = get_post_meta($post_id, $key, true);

        if (is_array($value) && !empty($value)) {
            return $value;
        }

        if (!is_array($value) && trim((string) $value) !== '') {
            return $value;
        }
    }

    return '';
}

function tema_selitec_event_parse_iso_date(string $raw): string
{
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

function tema_selitec_event_normalize_modality(string $value): string
{
    $value = strtolower(remove_accents(trim($value)));
    $value = str_replace('_', '-', $value);

    if (
        strpos($value, 'presencial') !== false
        && (strpos($value, 'learning') !== false || strpos($value, 'online') !== false)
    ) {
        return 'presencial-elearning';
    }

    if (in_array($value, array('presencial-elearning', 'presencial-e-learning', 'mixta', 'mixto'), true)) {
        return 'presencial-elearning';
    }

    if (
        strpos($value, 'learning') !== false
        || strpos($value, 'online') !== false
        || strpos($value, 'distancia') !== false
    ) {
        return 'elearning';
    }

    return 'presencial';
}

function tema_selitec_event_normalize_status(string $value): string
{
    $value = strtolower(remove_accents(trim($value)));

    if (strpos($value, 'cerr') !== false) {
        return 'cerrado';
    }

    if (strpos($value, 'ult') !== false || strpos($value, 'cupo') !== false) {
        return 'ultimos-cupos';
    }

    if (strpos($value, 'confirm') !== false || strpos($value, 'abier') !== false) {
        return 'abierto';
    }

    return 'abierto';
}

function tema_selitec_event_normalize_type(string $value): string
{
    $value = strtolower(remove_accents(trim($value)));

    if (in_array($value, array('otros', 'otro', 'demanda', 'contacto'), true)) {
        return 'otros';
    }

    return 'programacion';
}

function tema_selitec_event_leveling_codes_from_string(string $value): array
{
    $value = strtolower(remove_accents(trim($value)));
    if ($value === '') {
        return array();
    }

    if (
        strpos($value, 'ninguno') !== false
        || strpos($value, 'sin nivel') !== false
        || strpos($value, 'no aplica') !== false
    ) {
        return array('none');
    }

    $codes = array();
    $patterns = array(
        '1ro' => '/(^|[^0-9])(1|1ro|1o|1er|primero)($|[^0-9])/',
        '2do' => '/(^|[^0-9])(2|2do|2o|segundo)($|[^0-9])/',
        '3ro' => '/(^|[^0-9])(3|3ro|3o|tercero)($|[^0-9])/',
        '4to' => '/(^|[^0-9])(4|4to|4o|cuarto)($|[^0-9])/',
    );

    foreach ($patterns as $code => $pattern) {
        if (preg_match($pattern, $value) === 1) {
            $codes[] = $code;
        }
    }

    return $codes;
}

function tema_selitec_event_normalize_leveling($value): array
{
    $allowed = array_keys(tema_selitec_event_leveling_options());
    $selected = array();

    $values = is_array($value) ? $value : array($value);
    foreach ($values as $entry) {
        if (is_array($entry)) {
            continue;
        }

        $entry = trim((string) $entry);
        if ($entry === '') {
            continue;
        }

        $entry = strtolower(remove_accents($entry));
        if (in_array($entry, $allowed, true)) {
            $selected[] = $entry;
            continue;
        }

        $selected = array_merge($selected, tema_selitec_event_leveling_codes_from_string($entry));
    }

    $selected = array_values(array_unique($selected));

    if (in_array('none', $selected, true) && count($selected) > 1) {
        $selected = array_values(array_diff($selected, array('none')));
    }

    $ordered = array();
    foreach (array('1ro', '2do', '3ro', '4to', 'none') as $code) {
        if (in_array($code, $selected, true)) {
            $ordered[] = $code;
        }
    }

    if (empty($ordered)) {
        return array('none');
    }

    return $ordered;
}

function tema_selitec_event_value(int $post_id, string $key)
{
    switch ($key) {
        case 'related_course_id':
            $course_id = (int) tema_selitec_event_meta_first($post_id, array('related_course_id', 'course_id'));
            return $course_id > 0 ? $course_id : 0;

        case 'event_leveling':
            $raw = tema_selitec_event_meta_first($post_id, array('event_leveling', 'nivelacion', 'leveling'));
            return tema_selitec_event_normalize_leveling($raw);

        case 'modality':
            $raw = (string) tema_selitec_event_meta_first($post_id, array('modality', 'modalidad'));
            if ($raw === '') {
                $online_legacy = (string) get_post_meta($post_id, 'online', true);
                if ($online_legacy !== '') {
                    $raw = $online_legacy;
                }
            }
            return tema_selitec_event_normalize_modality($raw);

        case 'event_start_date':
            return tema_selitec_event_parse_iso_date((string) tema_selitec_event_meta_first($post_id, array('event_start_date', 'start_date', 'date', 'fecha_inicio')));

        case 'event_end_date':
            return tema_selitec_event_parse_iso_date((string) tema_selitec_event_meta_first($post_id, array('event_end_date', 'end_date', 'fecha_termino', 'fecha_fin')));

        case 'event_class_days':
            return trim((string) tema_selitec_event_meta_first($post_id, array('event_class_days', 'dias_clases', 'dias')));

        case 'schedule':
            return trim((string) tema_selitec_event_meta_first($post_id, array('schedule', 'time', 'horario')));

        case 'status':
            return tema_selitec_event_normalize_status((string) tema_selitec_event_meta_first($post_id, array('status', 'estado')));

        case 'event_student_value':
            return trim((string) tema_selitec_event_meta_first($post_id, array('event_student_value', 'valor_alumno', 'valor', 'precio')));

        case 'event_type':
            return tema_selitec_event_normalize_type((string) tema_selitec_event_meta_first($post_id, array('event_type')));
    }

    return '';
}

/**
 * Register event meta boxes.
 */
function tema_selitec_event_metaboxes(): void
{
    add_meta_box(
        'tema_selitec_event_details',
        'Datos del Evento',
        'tema_selitec_event_details_render',
        'event',
        'normal',
        'high'
    );

    add_meta_box(
        'tema_selitec_event_type',
        'Sección en Programación',
        'tema_selitec_event_type_render',
        'event',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'tema_selitec_event_metaboxes');

/**
 * Render primary event data fields.
 */
function tema_selitec_event_details_render(WP_Post $post): void
{
    wp_nonce_field('tema_selitec_event_save', 'tema_selitec_event_nonce');

    $values = array(
        'related_course_id' => tema_selitec_event_value($post->ID, 'related_course_id'),
        'event_leveling' => tema_selitec_event_value($post->ID, 'event_leveling'),
        'modality' => tema_selitec_event_value($post->ID, 'modality'),
        'event_start_date' => tema_selitec_event_value($post->ID, 'event_start_date'),
        'event_end_date' => tema_selitec_event_value($post->ID, 'event_end_date'),
        'event_class_days' => tema_selitec_event_value($post->ID, 'event_class_days'),
        'schedule' => tema_selitec_event_value($post->ID, 'schedule'),
        'status' => tema_selitec_event_value($post->ID, 'status'),
        'event_student_value' => tema_selitec_event_value($post->ID, 'event_student_value'),
    );

    $courses = get_posts(array(
        'post_type' => 'course',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => array('menu_order' => 'ASC', 'title' => 'ASC'),
        'order' => 'ASC',
    ));

    echo '<table class="form-table"><tbody>';

    // A) Curso relacionado.
    echo '<tr>';
    echo '<th scope="row"><label for="related_course_id">Curso relacionado</label></th>';
    echo '<td>';
    echo '<input type="search" id="related_course_id_search" class="regular-text" placeholder="Buscar curso..." autocomplete="off" style="max-width:420px; margin-bottom:8px;" />';
    echo '<br />';
    echo '<select id="related_course_id" name="related_course_id" class="regular-text" style="max-width:420px;">';
    echo '<option value="">— Ninguno —</option>';
    foreach ($courses as $course) {
        $selected = selected((string) $values['related_course_id'], (string) $course->ID, false);
        echo '<option value="' . esc_attr((string) $course->ID) . '"' . $selected . '>' . esc_html(get_the_title($course)) . '</option>';
    }
    echo '</select>';
    echo '<p class="description">Seleccione el curso al que pertenece este evento.</p>';
    echo '</td>';
    echo '</tr>';

    // B) Nivelación.
    $leveling_options = tema_selitec_event_leveling_options();
    echo '<tr>';
    echo '<th scope="row">Nivelación</th>';
    echo '<td>';
    foreach ($leveling_options as $level_key => $level_label) {
        $checked = in_array($level_key, $values['event_leveling'], true) ? ' checked="checked"' : '';
        $none_attr = $level_key === 'none' ? ' data-leveling-none="1"' : ' data-leveling-option="1"';
        echo '<label style="display:inline-block; margin:0 14px 8px 0;">';
        echo '<input type="checkbox" name="event_leveling[]" value="' . esc_attr($level_key) . '"' . $checked . $none_attr . ' /> ';
        echo esc_html($level_label);
        echo '</label>';
    }
    echo '<p class="description">Puede combinar niveles (ej: 1ro y 2do). Si marca Ninguno, se desmarcan los demás.</p>';
    echo '</td>';
    echo '</tr>';

    // C) Modalidad.
    echo '<tr>';
    echo '<th scope="row"><label for="modality">Modalidad</label></th>';
    echo '<td>';
    echo '<select id="modality" name="modality">';
    foreach (tema_selitec_event_modality_options() as $key => $label) {
        echo '<option value="' . esc_attr($key) . '"' . selected($values['modality'], $key, false) . '>' . esc_html($label) . '</option>';
    }
    echo '</select>';
    echo '</td>';
    echo '</tr>';

    // D) Fecha inicio.
    echo '<tr>';
    echo '<th scope="row"><label for="event_start_date">Fecha inicio</label></th>';
    echo '<td><input type="date" id="event_start_date" name="event_start_date" value="' . esc_attr((string) $values['event_start_date']) . '" /></td>';
    echo '</tr>';

    // E) Fecha término.
    echo '<tr>';
    echo '<th scope="row"><label for="event_end_date">Fecha término</label></th>';
    echo '<td><input type="date" id="event_end_date" name="event_end_date" value="' . esc_attr((string) $values['event_end_date']) . '" /></td>';
    echo '</tr>';

    // F) Días clases.
    echo '<tr>';
    echo '<th scope="row"><label for="event_class_days">Días clases</label></th>';
    echo '<td>';
    echo '<input type="text" id="event_class_days" name="event_class_days" value="' . esc_attr((string) $values['event_class_days']) . '" class="regular-text" placeholder="Ej: Lunes a viernes" />';
    echo '</td>';
    echo '</tr>';

    // G) Horario.
    echo '<tr>';
    echo '<th scope="row"><label for="schedule">Horario</label></th>';
    echo '<td>';
    echo '<input type="text" id="schedule" name="schedule" value="' . esc_attr((string) $values['schedule']) . '" class="regular-text" placeholder="Ej: 09:00 - 18:00" />';
    echo '</td>';
    echo '</tr>';

    // H) Estado.
    echo '<tr>';
    echo '<th scope="row"><label for="status">Estado</label></th>';
    echo '<td>';
    echo '<select id="status" name="status">';
    foreach (tema_selitec_event_status_options() as $key => $label) {
        echo '<option value="' . esc_attr($key) . '"' . selected($values['status'], $key, false) . '>' . esc_html($label) . '</option>';
    }
    echo '</select>';
    echo '</td>';
    echo '</tr>';

    // I) Valor alumno.
    echo '<tr>';
    echo '<th scope="row"><label for="event_student_value">Valor alumno</label></th>';
    echo '<td>';
    echo '<input type="text" id="event_student_value" name="event_student_value" value="' . esc_attr((string) $values['event_student_value']) . '" class="regular-text" placeholder="Ej: $ 245.000" />';
    echo '</td>';
    echo '</tr>';

    echo '</tbody></table>';
}

/**
 * Render side field for section assignment.
 */
function tema_selitec_event_type_render(WP_Post $post): void
{
    $current = tema_selitec_event_value($post->ID, 'event_type');

    echo '<fieldset>';
    foreach (tema_selitec_event_type_options() as $key => $label) {
        echo '<label style="display:block; margin-bottom:8px;">';
        echo '<input type="radio" name="event_type" value="' . esc_attr($key) . '"' . checked($current, $key, false) . ' /> ';
        echo esc_html($label);
        echo '</label>';
    }
    echo '</fieldset>';
    echo '<p class="description">Use "Otros" para cursos por demanda/contacto que no van en la grilla con fechas.</p>';
}

/**
 * Save canonical event meta.
 */
function tema_selitec_event_save(int $post_id): void
{
    if (!isset($_POST['tema_selitec_event_nonce']) || !wp_verify_nonce((string) $_POST['tema_selitec_event_nonce'], 'tema_selitec_event_save')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $related_course_id = isset($_POST['related_course_id']) ? (int) wp_unslash($_POST['related_course_id']) : 0;
    if ($related_course_id > 0 && get_post_type($related_course_id) === 'course') {
        update_post_meta($post_id, 'related_course_id', $related_course_id);
    } else {
        delete_post_meta($post_id, 'related_course_id');
    }

    $leveling_input = isset($_POST['event_leveling']) ? (array) wp_unslash($_POST['event_leveling']) : array();
    $leveling = tema_selitec_event_normalize_leveling($leveling_input);
    update_post_meta($post_id, 'event_leveling', $leveling);

    $modality_input = isset($_POST['modality']) ? sanitize_text_field((string) wp_unslash($_POST['modality'])) : '';
    update_post_meta($post_id, 'modality', tema_selitec_event_normalize_modality($modality_input));

    $start_input = isset($_POST['event_start_date']) ? sanitize_text_field((string) wp_unslash($_POST['event_start_date'])) : '';
    $start_date = tema_selitec_event_parse_iso_date($start_input);
    if ($start_date !== '') {
        update_post_meta($post_id, 'event_start_date', $start_date);
    } else {
        delete_post_meta($post_id, 'event_start_date');
    }

    $end_input = isset($_POST['event_end_date']) ? sanitize_text_field((string) wp_unslash($_POST['event_end_date'])) : '';
    $end_date = tema_selitec_event_parse_iso_date($end_input);
    if ($end_date !== '') {
        update_post_meta($post_id, 'event_end_date', $end_date);
    } else {
        delete_post_meta($post_id, 'event_end_date');
    }

    $class_days = isset($_POST['event_class_days']) ? sanitize_text_field((string) wp_unslash($_POST['event_class_days'])) : '';
    if ($class_days !== '') {
        update_post_meta($post_id, 'event_class_days', $class_days);
    } else {
        delete_post_meta($post_id, 'event_class_days');
    }

    $schedule = isset($_POST['schedule']) ? sanitize_text_field((string) wp_unslash($_POST['schedule'])) : '';
    if ($schedule !== '') {
        update_post_meta($post_id, 'schedule', $schedule);
    } else {
        delete_post_meta($post_id, 'schedule');
    }

    $status_input = isset($_POST['status']) ? sanitize_text_field((string) wp_unslash($_POST['status'])) : '';
    update_post_meta($post_id, 'status', tema_selitec_event_normalize_status($status_input));

    $student_value = isset($_POST['event_student_value']) ? sanitize_text_field((string) wp_unslash($_POST['event_student_value'])) : '';
    if ($student_value !== '') {
        update_post_meta($post_id, 'event_student_value', $student_value);
    } else {
        delete_post_meta($post_id, 'event_student_value');
    }

    $type_input = isset($_POST['event_type']) ? sanitize_text_field((string) wp_unslash($_POST['event_type'])) : 'programacion';
    update_post_meta($post_id, 'event_type', tema_selitec_event_normalize_type($type_input));
}
add_action('save_post_event', 'tema_selitec_event_save');

function tema_selitec_event_admin_enqueue(string $hook): void
{
    if (!in_array($hook, array('post.php', 'post-new.php'), true)) {
        return;
    }

    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'event') {
        return;
    }

    $js_path = TEMA_SELITEC_DIR . '/assets/js/admin-event.js';
    wp_enqueue_script(
        'tema-selitec-admin-event',
        TEMA_SELITEC_URI . '/assets/js/admin-event.js',
        array(),
        file_exists($js_path) ? (string) filemtime($js_path) : TEMA_SELITEC_VERSION,
        true
    );
}
add_action('admin_enqueue_scripts', 'tema_selitec_event_admin_enqueue');

function tema_selitec_event_start_dates_by_post(): array
{
    global $wpdb;

    static $cached = null;
    if (is_array($cached)) {
        return $cached;
    }

    $keys = array('event_start_date', 'start_date', 'date', 'fecha_inicio');
    $placeholders = implode(', ', array_fill(0, count($keys), '%s'));

    // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared -- placeholders are generated safely above.
    $sql = "
        SELECT pm.post_id, pm.meta_key, pm.meta_value
        FROM {$wpdb->postmeta} pm
        INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE p.post_type = 'event'
          AND p.post_status NOT IN ('trash', 'auto-draft')
          AND pm.meta_key IN ({$placeholders})
    ";

    // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared -- dynamic placeholder list.
    $rows = $wpdb->get_results($wpdb->prepare($sql, $keys), ARRAY_A);

    $priority = array(
        'event_start_date' => 0,
        'start_date' => 1,
        'date' => 2,
        'fecha_inicio' => 3,
    );

    $best = array();
    foreach ($rows as $row) {
        $post_id = (int) $row['post_id'];
        $iso_date = tema_selitec_event_parse_iso_date((string) $row['meta_value']);
        if ($iso_date === '') {
            continue;
        }

        $meta_key = (string) $row['meta_key'];
        $rank = isset($priority[$meta_key]) ? $priority[$meta_key] : 99;

        if (!isset($best[$post_id]) || $rank < $best[$post_id]['rank']) {
            $best[$post_id] = array(
                'rank' => $rank,
                'date' => $iso_date,
            );
        }
    }

    $cached = array();
    foreach ($best as $post_id => $row) {
        $cached[(int) $post_id] = (string) $row['date'];
    }

    return $cached;
}

function tema_selitec_event_start_month_options(): array
{
    $months = array();

    foreach (tema_selitec_event_start_dates_by_post() as $date) {
        $month = substr((string) $date, 0, 7);
        if ($month === '' || !preg_match('/^\d{4}-\d{2}$/', $month)) {
            continue;
        }

        if (!isset($months[$month])) {
            $months[$month] = tema_selitec_programacion_month_label($month);
        }
    }

    krsort($months);
    return $months;
}

function tema_selitec_event_ids_by_start_month(string $month): array
{
    if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
        return array();
    }

    $ids = array();
    foreach (tema_selitec_event_start_dates_by_post() as $post_id => $date) {
        if (substr($date, 0, 7) === $month) {
            $ids[] = (int) $post_id;
        }
    }

    return $ids;
}

function tema_selitec_event_admin_month_filter(): void
{
    global $typenow;

    if ($typenow !== 'event') {
        return;
    }

    $selected = isset($_GET['event_start_month']) ? sanitize_text_field((string) wp_unslash($_GET['event_start_month'])) : '';
    $months = tema_selitec_event_start_month_options();

    echo '<label for="filter-by-event-start-month" class="screen-reader-text">Filtrar por mes de inicio</label>';
    echo '<select name="event_start_month" id="filter-by-event-start-month">';
    echo '<option value="">Todas las fechas de inicio</option>';
    foreach ($months as $month_value => $month_label) {
        echo '<option value="' . esc_attr($month_value) . '"' . selected($selected, $month_value, false) . '>' . esc_html($month_label) . '</option>';
    }
    echo '</select>';
}
add_action('restrict_manage_posts', 'tema_selitec_event_admin_month_filter');

function tema_selitec_event_apply_admin_month_filter(WP_Query $query): void
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    global $pagenow;
    if ('edit.php' !== $pagenow || $query->get('post_type') !== 'event') {
        return;
    }

    $month = isset($_GET['event_start_month']) ? sanitize_text_field((string) wp_unslash($_GET['event_start_month'])) : '';
    if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
        return;
    }

    $ids = tema_selitec_event_ids_by_start_month($month);
    $query->set('post__in', !empty($ids) ? $ids : array(0));
}
add_action('pre_get_posts', 'tema_selitec_event_apply_admin_month_filter');
