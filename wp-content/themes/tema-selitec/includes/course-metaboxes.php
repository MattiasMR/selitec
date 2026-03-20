<?php
/**
 * Course meta boxes — admin fields for the "Curso" CPT.
 *
 * Allows creating/editing courses with standard fields:
 * modalidad, duración/horas, descripción, objetivos y URL de temario.
 *
 * @package tema-selitec
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the "Datos del Curso" meta box.
 */
function tema_selitec_course_metaboxes(): void
{
    add_meta_box(
        'tema_selitec_course_details',
        'Datos del Curso',
        'tema_selitec_course_details_render',
        'course',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'tema_selitec_course_metaboxes');

/**
 * Display a clear label indicating the main editor is for "Temario".
 */
function tema_selitec_course_editor_syllabus_label(WP_Post $post): void
{
    if ($post->post_type !== 'course') {
        return;
    }

    echo '<h2 style="margin: 12px 0 8px; font-size: 1rem;">' . esc_html__('Temario', 'tema-selitec') . '</h2>';
}
add_action('edit_form_after_title', 'tema_selitec_course_editor_syllabus_label');

/**
 * Render the meta box fields.
 */
function tema_selitec_course_details_render(WP_Post $post): void
{
    wp_nonce_field('tema_selitec_course_save', 'tema_selitec_course_nonce');

    $modality    = tema_selitec_course_modality($post->ID);
    $hours       = tema_selitec_course_meta_first($post->ID, array('course_hours', 'hours', 'duration', 'course_duration', 'duracion', 'selitec_hours'));
    $description = get_post_meta($post->ID, 'course_description', true);
    $objectives  = tema_selitec_course_objectives($post->ID);
    $pdf         = tema_selitec_course_meta_first($post->ID, array('pdf_url', 'pdf', 'course_pdf', 'temario_pdf', 'selitec_pdf'));
    $modality_options = tema_selitec_course_modality_options();

    ?>
    <table class="form-table"><tbody>
        <tr>
            <th scope="row"><label for="course_modality">Modalidad</label></th>
            <td>
                <select id="course_modality" name="course_modality">
                    <?php foreach ($modality_options as $key => $label) : ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php selected($modality, $key); ?>><?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
                <p class="description">Seleccione la modalidad del curso.</p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="course_hours">Duración (horas)</label></th>
            <td>
                <input type="text" id="course_hours" name="course_hours" value="<?php echo esc_attr($hours); ?>" class="regular-text" placeholder="Ej: 40" />
                <p class="description">Número de horas del curso. Deje vacío para mostrar "Consultar".</p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="course_description">Descripción del Curso</label></th>
            <td>
                <textarea id="course_description" name="course_description" rows="5" class="large-text"><?php echo esc_textarea($description); ?></textarea>
                <p class="description">Descripción del curso que se muestra en la ficha. Si se deja vacío se usa un texto por defecto.</p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="course_objectives">Objetivos Generales</label></th>
            <td>
                <textarea id="course_objectives" name="course_objectives" rows="5" class="large-text"><?php echo esc_textarea($objectives); ?></textarea>
                <p class="description">Objetivos generales del curso. Compatible con metas antiguas y editable desde este campo.</p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pdf_url">URL del Temario (PDF/DOC)</label></th>
            <td>
                <input type="text" id="pdf_url" name="pdf_url" value="<?php echo esc_attr($pdf); ?>" class="large-text" placeholder="https://ejemplo.com/temario.pdf" />
                <p class="description">URL del archivo descargable del temario. Puede subir el archivo a la Biblioteca de Medios y pegar la URL aquí.</p>
            </td>
        </tr>
    </tbody></table>
    <p style="margin-top: 1rem; color: #666;">
        <strong>Recuerde:</strong> Use la <em>Imagen destacada</em> (columna derecha) para la imagen del curso
        y asigne una <em>Categoría de curso</em>.
    </p>
    <?php
}

/**
 * Save course meta on post save.
 */
function tema_selitec_course_save(int $post_id): void
{
    if (!isset($_POST['tema_selitec_course_nonce']) || !wp_verify_nonce($_POST['tema_selitec_course_nonce'], 'tema_selitec_course_save')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['course_modality'])) {
        $modality = sanitize_text_field((string) wp_unslash($_POST['course_modality']));
        update_post_meta($post_id, 'course_modality', tema_selitec_course_normalize_modality($modality));
    }

    if (isset($_POST['course_hours'])) {
        update_post_meta($post_id, 'course_hours', sanitize_text_field((string) wp_unslash($_POST['course_hours'])));
    }

    if (isset($_POST['course_description'])) {
        update_post_meta($post_id, 'course_description', sanitize_textarea_field((string) wp_unslash($_POST['course_description'])));
    }

    if (isset($_POST['course_objectives'])) {
        update_post_meta($post_id, 'course_objectives', sanitize_textarea_field((string) wp_unslash($_POST['course_objectives'])));
    }

    if (isset($_POST['pdf_url'])) {
        update_post_meta($post_id, 'pdf_url', sanitize_text_field((string) wp_unslash($_POST['pdf_url'])));
    }
}
add_action('save_post_course', 'tema_selitec_course_save');
