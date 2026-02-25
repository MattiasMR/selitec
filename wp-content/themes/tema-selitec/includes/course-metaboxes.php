<?php
/**
 * Course meta boxes — admin fields for the "Curso" CPT.
 *
 * Allows creating/editing courses with standard fields:
 * imagen (thumbnail), categoría (taxonomy), modalidad, duración/horas,
 * título (post_title), descripción (editor), objetivos, temario, PDF.
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
 * Render the meta box fields.
 */
function tema_selitec_course_details_render(WP_Post $post): void
{
    wp_nonce_field('tema_selitec_course_save', 'tema_selitec_course_nonce');

    $modality   = get_post_meta($post->ID, 'course_modality', true);
    $hours      = get_post_meta($post->ID, 'course_hours', true);
    $objectives = get_post_meta($post->ID, 'course_objectives', true);
    $syllabus   = get_post_meta($post->ID, 'syllabus_html', true);
    $pdf        = get_post_meta($post->ID, 'pdf_url', true);

    ?>
    <table class="form-table"><tbody>
        <tr>
            <th scope="row"><label for="course_modality">Modalidad</label></th>
            <td>
                <select id="course_modality" name="course_modality">
                    <option value="presencial" <?php selected($modality, 'presencial'); ?>>Presencial</option>
                    <option value="elearning" <?php selected($modality, 'elearning'); ?>>E-learning / Online</option>
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
            <th scope="row"><label for="course_objectives">Objetivos Generales</label></th>
            <td>
                <textarea id="course_objectives" name="course_objectives" rows="5" class="large-text"><?php echo esc_textarea($objectives); ?></textarea>
                <p class="description">Objetivos generales del curso. Si se deja vacío se usa un texto por defecto.</p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="syllabus_html">Contenido / Temario (HTML)</label></th>
            <td>
                <?php
                wp_editor($syllabus, 'syllabus_html', array(
                    'textarea_name' => 'syllabus_html',
                    'textarea_rows' => 10,
                    'media_buttons' => false,
                    'teeny'         => false,
                    'quicktags'     => true,
                ));
                ?>
                <p class="description">Temario detallado del curso. Use listas (&lt;ul&gt;&lt;li&gt;) para los puntos del contenido. Si se deja vacío se usa el contenido principal del editor.</p>
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
        <strong>Recuerde:</strong> Use la <em>Imagen destacada</em> (columna derecha) para la imagen del curso,
        el <em>Extracto</em> para la descripción corta, y asigne una <em>Categoría de curso</em>.
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

    // Text fields
    $text_keys = array('course_modality', 'course_hours', 'course_objectives', 'pdf_url');
    foreach ($text_keys as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_text_field(wp_unslash($_POST[$key])));
        }
    }

    // HTML field (syllabus) — allow safe HTML
    if (isset($_POST['syllabus_html'])) {
        update_post_meta($post_id, 'syllabus_html', wp_kses_post(wp_unslash($_POST['syllabus_html'])));
    }
}
add_action('save_post_course', 'tema_selitec_course_save');
