<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main>
    <section class="hero">
        <img src="<?php echo esc_url(tema_selitec_asset_url('assets/principal.jpg')); ?>" alt="" style="display:none;" fetchpriority="high" width="1280" height="442">
        <div class="hero__overlay"></div>
        <div class="container hero__content">
            <h1 class="hero__title">Capacitación Técnica para<br> <span class="txt-type" data-wait="3000" data-words='["Empresas", "Trabajadores", "Su Futuro"]'>Empresas</span></h1>
            <p class="hero__subtitle">Especialistas en Mantención, Operaciones y Seguridad Industrial. Cursos con Franquicia Tributaria SENCE.</p>

            <div class="hero__actions">
                <a href="<?php echo esc_url(home_url('/cursos/')); ?>" class="btn btn--primary">Ver Cursos Disponibles</a>
                <a href="<?php echo esc_url(home_url('/programacion/')); ?>" class="btn btn--secondary">Ver Programación del Mes</a>
            </div>

            <div class="hero__trust-badges">
                <span><i class="fas fa-user-graduate" aria-hidden="true"></i> +10.000 Alumnos Certificados</span>
                <span><i class="fas fa-building" aria-hidden="true"></i> Cobertura Nacional</span>
            </div>

            <div style="margin-top: 1.5rem; font-size: 0.9rem; opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">
                <p><strong>Programación | 100% Franquicia Sence</strong><br>
                *Selitec realiza tramitación Licencia D y examen ante la SEREMI</p>
            </div>
        </div>
    </section>

    <section class="accreditation-section">
        <div class="container accreditation-content">
            <div class="accreditation-text">
                <img src="<?php echo esc_url(tema_selitec_asset_url('assets/SGS_NCh_2728_2015/For%20Office%20use/SGS_NCh_2728.Of2003_span_TCL.jpg')); ?>" alt="Logo SGS" class="accreditation-logo" loading="lazy">
                <span>Acreditados por la NCH 2728 por SGS</span>
            </div>
            <div class="accreditation-text">
                <i class="fas fa-check-double" style="font-size: 2rem; color: var(--c-secondary); margin-right: 0.5rem;"></i>
                <span>Cursos con Franquicia Impulsa Personas Sence (ex Franquicia Tributaria)</span>
            </div>
        </div>
    </section>

    <section class="section categories-section">
        <div class="container">
            <h2 class="section-title">Áreas de Capacitación</h2>
            <p class="section-subtitle">Encuentra el curso específico para tu sector industrial o administrativo.</p>

            <div class="categories-grid">
                <a href="<?php echo esc_url(home_url('/cursos/?category=maquinas')); ?>" class="area-card--bg" style="background-image: url('<?php echo esc_url(tema_selitec_asset_url('assets/temario_mantencionYproduccion.jpg')); ?>');">
                    <div class="area-icon"><i class="fas fa-truck-loading" aria-hidden="true"></i></div>
                    <h3 class="area-title">Máquinas y equipos</h3>
                    <p class="area-desc">Grúas, Operación de equipos.</p>
                </a>

                <a href="<?php echo esc_url(home_url('/cursos/?category=mantencion')); ?>" class="area-card--bg" style="background-image: url('<?php echo esc_url(tema_selitec_asset_url('assets/temario_mantencionYproduccion.jpg')); ?>');">
                    <div class="area-icon"><i class="fas fa-cogs" aria-hidden="true"></i></div>
                    <h3 class="area-title">Mantención y producción</h3>
                    <p class="area-desc">Calderas, Electricidad, Hidráulica.</p>
                </a>

                <a href="<?php echo esc_url(home_url('/cursos/?category=seguridad')); ?>" class="area-card--bg" style="background-image: url('<?php echo esc_url(tema_selitec_asset_url('assets/temario_todoslostemarios.jpg')); ?>');">
                    <div class="area-icon"><i class="fas fa-hard-hat" aria-hidden="true"></i></div>
                    <h3 class="area-title">Seguridad y prevención</h3>
                    <p class="area-desc">Prevención de Riesgos, Primeros Auxilios.</p>
                </a>

                <a href="<?php echo esc_url(home_url('/cursos/?category=computacion')); ?>" class="area-card--bg" style="background-image: url('<?php echo esc_url(tema_selitec_asset_url('assets/temario_computacion.jpg')); ?>');">
                    <div class="area-icon"><i class="fas fa-laptop-code" aria-hidden="true"></i></div>
                    <h3 class="area-title">Computación</h3>
                    <p class="area-desc">Excel, Word, Herramientas Digitales.</p>
                </a>
            </div>
        </div>
    </section>

    <section class="section leveling-section">
        <div class="container leveling-section__inner">
            <div class="leveling-section__content">
                <h2 class="section-title section-title--light">Nivelación de Estudios para Adultos</h2>
                <p>Complete su Enseñanza Básica y Media con horarios flexibles y apoyo docente. Programa reconocido por MINEDUC y financiable vía SENCE.</p>
                <ul class="feature-list">
                    <li><i class="fas fa-check" aria-hidden="true"></i> Modalidad flexible compatible con el trabajo</li>
                    <li><i class="fas fa-check" aria-hidden="true"></i> Exámenes válidos ante el Ministerio de Educación</li>
                    <li><i class="fas fa-check" aria-hidden="true"></i> Material de estudio incluido</li>
                </ul>
                <a href="<?php echo esc_url(home_url('/nivelacion/')); ?>" class="btn btn--accent">Más información sobre Nivelación</a>
            </div>
        </div>
    </section>

    <section class="section featured-courses">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Cursos Destacados</h2>
                <a href="<?php echo esc_url(home_url('/programacion/')); ?>" class="link-arrow">Ver calendario completo <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>

            <div class="courses-grid">
                <?php
                // Pick 1 real published course from each of 3 different categories
                $featured_categories = array('mantencion', 'maquinas', 'seguridad', 'computacion');
                $shown = 0;
                foreach ($featured_categories as $cat_slug) {
                    if ($shown >= 3) break;
                    $featured_q = new WP_Query(array(
                        'post_type'      => 'course',
                        'post_status'    => 'publish',
                        'posts_per_page' => 1,
                        'tax_query'      => array(array(
                            'taxonomy' => 'course_category',
                            'field'    => 'slug',
                            'terms'    => $cat_slug,
                        )),
                    ));
                    if ($featured_q->have_posts()) {
                        $featured_q->the_post();
                        $fid       = get_the_ID();
                        $fcat_label = tema_selitec_course_category_label($cat_slug);
                        $fbadge     = tema_selitec_course_category_badge_class($cat_slug);
                        $fmodality  = tema_selitec_course_modality_label(tema_selitec_course_modality($fid));
                        $fimage     = tema_selitec_course_image_url($fid, $cat_slug);
                        $fsummary   = tema_selitec_course_summary($fid);
                        $fhours     = tema_selitec_course_hours($fid);
                        ?>
                        <article class="course-card">
                            <div class="course-card__image-container">
                                <img src="<?php echo esc_url($fimage); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="course-card__image" width="366" height="191" loading="lazy">
                            </div>
                            <div class="course-card__header">
                                <span class="badge <?php echo esc_attr($fbadge); ?>"><?php echo esc_html($fcat_label); ?></span>
                                <span class="badge badge--modality"><?php echo esc_html($fmodality); ?></span>
                            </div>
                            <div class="course-card__body">
                                <h3 class="course-card__title"><?php the_title(); ?></h3>
                                <p class="course-card__excerpt"><?php echo esc_html(wp_trim_words($fsummary, 20)); ?></p>
                            </div>
                            <div class="course-card__footer">
                                <a href="<?php the_permalink(); ?>" class="btn btn--outline btn--full">Ver Temario</a>
                            </div>
                        </article>
                        <?php
                        $shown++;
                    }
                    wp_reset_postdata();
                }
                ?>
            </div>
        </div>
    </section>

    <section class="section trust-section">
        <div class="container">
            <h2 class="section-title text-center">Algunas de las empresas que confían en nosotros</h2>

            <div class="carousel-wrapper" style="margin-top: 3rem; margin-bottom: 2rem;">
                <button class="carousel-btn carousel-btn--prev" aria-label="Anterior"><i class="fas fa-chevron-left"></i></button>

                <div class="carousel-container">
                    <div class="carousel-track">
                        <div class="carousel-slide"><img src="<?php echo esc_url(tema_selitec_asset_url('assets/clientes/aislapol.jpg')); ?>" alt="Aislapol" loading="lazy"></div>
                        <div class="carousel-slide"><img src="<?php echo esc_url(tema_selitec_asset_url('assets/clientes/alimex.jpeg')); ?>" alt="Alimex" loading="lazy"></div>
                        <div class="carousel-slide"><img src="<?php echo esc_url(tema_selitec_asset_url('assets/clientes/carozzi.jpg')); ?>" alt="Carozzi" loading="lazy"></div>
                        <div class="carousel-slide"><img src="<?php echo esc_url(tema_selitec_asset_url('assets/clientes/copec.jpg')); ?>" alt="Copec" loading="lazy"></div>
                        <div class="carousel-slide"><img src="<?php echo esc_url(tema_selitec_asset_url('assets/clientes/ccu.png')); ?>" alt="CCU" loading="lazy"></div>
                        <div class="carousel-slide"><img src="<?php echo esc_url(tema_selitec_asset_url('assets/clientes/veterquimica.jpg')); ?>" alt="Veterquimica" loading="lazy"></div>
                    </div>
                </div>

                <button class="carousel-btn carousel-btn--next" aria-label="Siguiente"><i class="fas fa-chevron-right"></i></button>
            </div>

            <div class="trust-cta">
                <p>Más de 50 grandes empresas capacitan a sus equipos con nosotros.</p>
                <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1rem; flex-wrap: wrap;">
                    <a href="<?php echo esc_url(home_url('/clientes/')); ?>" class="btn btn--outline">Ver Todos Nuestros Clientes</a>
                    <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--primary">Solicitar Cotización Empresas</a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
