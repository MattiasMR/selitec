<?php

if (!defined('ABSPATH')) {
    exit;
}

define('TEMA_SELITEC_VERSION', '1.0.0');
define('TEMA_SELITEC_DIR', get_template_directory());
define('TEMA_SELITEC_URI', get_template_directory_uri());

$tema_selitec_includes = array(
    'includes/setup.php',
    'includes/helpers.php',
    'includes/seo.php',
    'includes/course-helpers.php',
    'includes/schedule-helpers.php',
    'includes/enqueue.php',
    'includes/post-types.php',
    'includes/taxonomies.php',
    'includes/rewrite.php',
    'includes/compat.php',
    'includes/auto-pages.php',
    'includes/event-metaboxes.php',
);

foreach ($tema_selitec_includes as $file) {
    $path = TEMA_SELITEC_DIR . '/' . $file;
    if (file_exists($path)) {
        require_once $path;
    }
}
