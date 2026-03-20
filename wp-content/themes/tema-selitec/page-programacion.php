<?php

if (!defined('ABSPATH')) {
    exit;
}

$month = gmdate('Y-m');
$month_label = tema_selitec_programacion_month_label($month);
$prev_month = tema_selitec_programacion_prev_month($month);
$next_month = tema_selitec_programacion_next_month($month);
$rows = tema_selitec_programacion_rows($month);
$other_rows = tema_selitec_programacion_otros_rows();

get_header();
?>
<main>
    <section class="hero hero--compact">
        <div class="container hero__content">
            <h1 class="hero__title">Programación de Cursos Abiertos</h1>
            <p class="hero__subtitle">Calendario de actividades confirmadas para <strong><?php echo esc_html($month_label); ?></strong>. Cupos limitados.</p>
        </div>
    </section>

    <section class="section schedule-section">
        <div class="container">
            <div class="month-nav">
                <a href="<?php echo esc_url(home_url('/programacion/' . $prev_month . '/')); ?>" class="month-nav__link"><i class="fas fa-chevron-left"></i> <?php echo esc_html(tema_selitec_programacion_month_label($prev_month)); ?></a>
                <span class="month-nav__current"><?php echo esc_html($month_label); ?></span>
                <a href="<?php echo esc_url(home_url('/programacion/' . $next_month . '/')); ?>" class="month-nav__link"><?php echo esc_html(tema_selitec_programacion_month_label($next_month)); ?> <i class="fas fa-chevron-right"></i></a>
            </div>

            <div class="schedule-card">
                <?php if (!empty($rows)) : ?>
                <div class="table-responsive">
                    <table class="schedule-table">
                        <caption>Programación de cursos para <?php echo esc_html($month_label); ?></caption>
                        <thead>
                            <tr>
                                <th scope="col">Curso</th>
                                <th scope="col">Modalidad</th>
                                <th scope="col">Fecha Inicio</th>
                                <th scope="col">Fecha Término</th>
                                <th scope="col">Días Clases</th>
                                <th scope="col">Horario</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row) : ?>
                                <tr>
                                    <td data-label="Curso"><strong><a href="<?php echo esc_url((string) $row['url']); ?>"><?php echo esc_html((string) $row['title']); ?></a></strong></td>
                                    <td data-label="Modalidad"><span class="badge badge--modality"><?php echo esc_html((string) $row['modality']); ?></span></td>
                                    <td data-label="Fecha Inicio"><?php echo esc_html((string) $row['start_date']); ?></td>
                                    <td data-label="Fecha Término"><?php echo esc_html((string) $row['end_date']); ?></td>
                                    <td data-label="Días Clases"><?php echo esc_html((string) $row['class_days']); ?></td>
                                    <td data-label="Horario"><?php echo esc_html((string) $row['time']); ?></td>
                                    <td data-label="Estado"><span class="status-dot <?php echo esc_attr((string) $row['status_dot_class']); ?>"></span><?php echo esc_html((string) $row['status']); ?></td>
                                    <td data-label="Acción"><a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--primary">Inscribir</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else : ?>
                <div class="schedule-empty" style="text-align:center; padding:3rem 1rem;">
                    <i class="fas fa-calendar-xmark" style="font-size:3rem; color:var(--c-primary); margin-bottom:1rem; display:block;"></i>
                    <h3>No hay cursos programados para <?php echo esc_html($month_label); ?></h3>
                    <p>Estamos preparando la programación. Contáctenos para consultar fechas disponibles.</p>
                    <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--primary" style="margin-top:1rem;">Consultar Disponibilidad</a>
                </div>
                <?php endif; ?>
            </div>

            <div class="schedule-card">
                <h2 class="schedule-card__title">Otros</h2>
                <?php if (!empty($other_rows)) : ?>
                <div class="table-responsive">
                    <table class="schedule-table">
                        <caption>Cursos por demanda y contacto</caption>
                        <thead>
                            <tr>
                                <th scope="col">Curso</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($other_rows as $row) : ?>
                                <tr>
                                    <td data-label="Curso"><strong><a href="<?php echo esc_url((string) $row['url']); ?>"><?php echo esc_html((string) $row['title']); ?></a></strong></td>
                                    <td data-label="Acción"><a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--primary">Consultar</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else : ?>
                <div class="schedule-empty" style="text-align:center; padding:2rem 1rem;">
                    <p>No hay cursos disponibles en la sección Otros.</p>
                </div>
                <?php endif; ?>
            </div>

            <div class="schedule-note">
                <p><i class="fas fa-info-circle"></i> Las fechas pueden sufrir modificaciones y dependen de quórum mínimo.</p>
            </div>

            <p class="schedule-commercial">CONSULTE CURSOS ESPECIFICOS PARA SU EMPRESA 100% FRANQUICIA SENCE</p>
        </div>
    </section>

    <section class="section" style="background-color: var(--c-bg-light);">
        <div class="container text-center">
            <h2 class="section-title">¿No encuentra la fecha que necesita?</h2>
            <p class="section-subtitle" style="margin-left: auto; margin-right: auto;">Podemos coordinar cursos cerrados para su empresa en la fecha que más le acomode.</p>
            <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--secondary">Solicitar Curso Cerrado</a>
        </div>
    </section>
</main>
<?php
get_footer();
