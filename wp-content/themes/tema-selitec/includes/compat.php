<?php

if (!defined('ABSPATH')) {
    exit;
}

function tema_selitec_is_woocommerce_active(): bool
{
    return class_exists('WooCommerce');
}

function tema_selitec_maybe_enqueue_comment_reply(): void
{
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'tema_selitec_maybe_enqueue_comment_reply', 30);
