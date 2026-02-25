<?php

if (!defined('ABSPATH')) {
    exit;
}

function tema_selitec_asset_url(string $relative_path): string
{
    $relative_path = ltrim($relative_path, '/');
    return trailingslashit(TEMA_SELITEC_URI) . $relative_path;
}

function tema_selitec_current_path(): string
{
    $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '/';
    $path = (string) wp_parse_url($request_uri, PHP_URL_PATH);
    return trim($path, '/');
}

function tema_selitec_nav_class(string $path = '', bool $is_external = false): string
{
    if ($is_external) {
        return 'main-nav__link main-nav__link--highlight';
    }

    $current = tema_selitec_current_path();
    $target = trim((string) wp_parse_url(home_url($path), PHP_URL_PATH), '/');

    $is_home = ($target === '' && is_front_page());
    $is_current = $is_home || ($target !== '' && $current === $target);

    return $is_current ? 'main-nav__link main-nav__link--active' : 'main-nav__link';
}

function tema_selitec_nav_aria_current(string $path = ''): string
{
    $current = tema_selitec_current_path();
    $target = trim((string) wp_parse_url(home_url($path), PHP_URL_PATH), '/');

    $is_home = ($target === '' && is_front_page());
    $is_current = $is_home || ($target !== '' && $current === $target);

    return $is_current ? 'page' : '';
}
