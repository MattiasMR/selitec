<?php

if (!defined('ABSPATH')) {
    exit;
}

$logo_files = glob(TEMA_SELITEC_DIR . '/assets/clientes/*.{jpg,jpeg,png,webp,svg,JPG,JPEG,PNG,WEBP,SVG}', GLOB_BRACE);
$logo_files = is_array($logo_files) ? $logo_files : array();
sort($logo_files);

get_header();
?>
<main>
    <section class="hero hero--compact">
        <div class="container hero__content">
            <h1 class="hero__title">Nuestros Clientes</h1>
            <p class="hero__subtitle">Organizaciones que confían en nuestra calidad y experiencia.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Confianza y Trayectoria</h2>
                <p class="section-subtitle" style="margin: 0 auto;">Hemos capacitado a equipos de múltiples industrias en todo Chile.</p>
            </div>

            <div style="display:grid; grid-template-columns: repeat(auto-fill,minmax(150px,1fr)); gap:2rem; align-items:center; justify-items:center; margin-top:2rem;">
                <?php foreach ($logo_files as $logo_file) : ?>
                    <?php
                    $basename = basename($logo_file);
                    $alt = preg_replace('/\.[^.]+$/', '', $basename);
                    $alt = str_replace(array('_', '-'), ' ', $alt);
                    $relative = str_replace(TEMA_SELITEC_DIR . '/', '', $logo_file);
                    ?>
                    <div style="display:flex; align-items:center; justify-content:center; width:100%; height:120px; padding:1rem; border:1px solid var(--c-border); border-radius:var(--radius-md); background:white;">
                        <img src="<?php echo esc_url(tema_selitec_asset_url($relative)); ?>" alt="<?php echo esc_attr(ucwords($alt)); ?>" loading="lazy" style="max-width:100%; max-height:100%; object-fit:contain; filter:grayscale(100%);">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section" style="background-color: var(--c-bg-light);">
        <div class="container text-center">
            <h2 class="section-title">¿Desea capacitar a su personal?</h2>
            <p class="mb-4">Diseñamos programas de formación a medida para su empresa.</p>
            <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
                <a href="<?php echo esc_url(home_url('/empresa/')); ?>" class="btn btn--primary">Servicios Empresas</a>
                <a href="<?php echo esc_url(home_url('/contacto/')); ?>" class="btn btn--secondary">Contáctenos</a>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
