<?php
/**
 * Event meta boxes — simple admin fields for the "Evento" CPT.
 *
 * Adds labelled inputs so the user can manage the monthly schedule
 * directly from wp-admin > Eventos > Agregar/Editar.
 *
 * @package tema-selitec
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the "Datos del Evento" meta box.
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
}
add_action('add_meta_boxes', 'tema_selitec_event_metaboxes');

/**
 * Render the meta box fields.
 */
function tema_selitec_event_details_render(WP_Post $post): void
{
    wp_nonce_field('tema_selitec_event_save', 'tema_selitec_event_nonce');

    $fields = array(
        'event_start_date' => array(
            'label' => 'Fecha de Inicio',
            'type'  => 'date',
            'desc'  => 'Formato: AAAA-MM-DD',
        ),
        'schedule' => array(
            'label' => 'Horario',
            'type'  => 'text',
            'desc'  => 'Ej: 09:00 - 18:00',
        ),
        'modality' => array(
            'label'   => 'Modalidad',
            'type'    => 'select',
            'options' => array(
                'presencial' => 'Presencial',
                'elearning'  => 'E-learning',
                'online'     => 'Online (en vivo)',
            ),
        ),
        'status' => array(
            'label'   => 'Estado',
            'type'    => 'select',
            'options' => array(
                'Confirmado'      => 'Confirmado',
                'Últimos Cupos'   => 'Últimos Cupos',
                'Abierto'         => 'Abierto',
                'Cerrado'         => 'Cerrado',
            ),
        ),
        'related_course_id' => array(
            'label' => 'Curso Relacionado',
            'type'  => 'course_select',
            'desc'  => 'Seleccione el curso al que pertenece este evento.',
        ),
    );

    echo '<table class="form-table"><tbody>';

    foreach ($fields as $key => $field) {
        $value = get_post_meta($post->ID, $key, true);
        echo '<tr>';
        echo '<th scope="row"><label for="' . esc_attr($key) . '">' . esc_html($field['label']) . '</label></th>';
        echo '<td>';

        switch ($field['type']) {
            case 'date':
                echo '<input type="date" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" class="regular-text" />';
                break;

            case 'text':
                echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" class="regular-text" />';
                break;

            case 'select':
                echo '<select id="' . esc_attr($key) . '" name="' . esc_attr($key) . '">';
                foreach ($field['options'] as $opt_value => $opt_label) {
                    $selected = selected($value, $opt_value, false);
                    echo '<option value="' . esc_attr($opt_value) . '"' . $selected . '>' . esc_html($opt_label) . '</option>';
                }
                echo '</select>';
                break;

            case 'course_select':
                $courses = get_posts(array(
                    'post_type'      => 'course',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ));
                echo '<select id="' . esc_attr($key) . '" name="' . esc_attr($key) . '">';
                echo '<option value="">— Ninguno —</option>';
                foreach ($courses as $course) {
                    $selected = selected($value, (string) $course->ID, false);
                    echo '<option value="' . esc_attr((string) $course->ID) . '"' . $selected . '>' . esc_html(get_the_title($course)) . '</option>';
                }
                echo '</select>';
                break;
        }

        if (!empty($field['desc'])) {
            echo '<p class="description">' . esc_html($field['desc']) . '</p>';
        }

        echo '</td></tr>';
    }

    echo '</tbody></table>';
}

/**
 * Save event meta on post save.
 */
function tema_selitec_event_save(int $post_id): void
{
    if (!isset($_POST['tema_selitec_event_nonce']) || !wp_verify_nonce($_POST['tema_selitec_event_nonce'], 'tema_selitec_event_save')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $meta_keys = array('event_start_date', 'schedule', 'modality', 'status', 'related_course_id');

    foreach ($meta_keys as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_text_field(wp_unslash($_POST[$key])));
        }
    }
}
add_action('save_post_event', 'tema_selitec_event_save');
