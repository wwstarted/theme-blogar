<?php
/**
 * Blogar — functions.php
 * Theme prefix: blg_
 */

add_filter('show_admin_bar', '__return_false');

if (!defined('ABSPATH'))
    exit;

// ============================================================
// 1. INCLUDE FILES
// ============================================================
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/header-setup.php';
require_once get_template_directory() . '/inc/footer-setup.php';


// ============================================================
// 2. ENQUEUE ASSETS
// ============================================================
function blg_enqueue_scripts()
{
    $ver = '1.0.0';
    $theme = get_template_directory_uri();

    // ── Vendor ────────────────────────────────────────────────
    wp_enqueue_style(
        'blg-font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        [],
        '6.5.0'
    );
    wp_enqueue_style(
        'blg-bootstrap',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css',
        [],
        '4.6.2'
    );
    wp_enqueue_style(
        'blg-slick',
        $theme . '/css/vendor/slick.css',
        [],
        $ver
    );
    wp_enqueue_style(
        'blg-slick-theme',
        $theme . '/css/vendor/slick-theme.css',
        [],
        $ver
    );

    // ── Global / Base ──────────────────────────────────────────
    wp_enqueue_style('blg-style', get_stylesheet_uri(), [], $ver);

    // ── Header (every page) ───────────────────────────────────
    wp_enqueue_style('blg-header', $theme . '/css/header.css', [], $ver);

    // ── Footer (every page) ───────────────────────────────────
    wp_enqueue_style('blg-footer', $theme . '/css/footer.css', [], $ver);

    // ── Homepage ──────────────────────────────────────────────
    if (is_front_page()) {
        wp_enqueue_style('blg-frontpage', $theme . '/css/frontpage.css', [], $ver);
    }

    // ── JS Vendor ─────────────────────────────────────────────
    wp_enqueue_script('jquery');

    wp_enqueue_script(
        'blg-bootstrap-js',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js',
        ['jquery'],
        '4.6.2',
        true
    );
    wp_enqueue_script(
        'blg-slick-js',
        $theme . '/js/vendor/slick.min.js',
        ['jquery'],
        $ver,
        true
    );

    // ── Header JS (every page) ────────────────────────────────
    wp_enqueue_script(
        'blg-header-js',
        $theme . '/js/header.js',
        ['jquery'],
        $ver,
        true
    );

    // ── Footer JS (every page) ────────────────────────────────
    wp_enqueue_script(
        'blg-footer-js',
        $theme . '/js/footer.js',
        ['jquery'],
        $ver,
        true
    );

    // ── Homepage JS ───────────────────────────────────────────
    if (is_front_page()) {
        wp_enqueue_script(
            'blg-frontpage-js',
            $theme . '/js/frontpage.js',
            ['jquery', 'blg-slick-js'],
            $ver,
            true
        );
    }

    // ── Pass data to JS ───────────────────────────────────────
    wp_localize_script('blg-header-js', 'blgConfig', [
        'homeUrl' => esc_url(home_url('/')),
        'themeUrl' => esc_url($theme),
    ]);
}
add_action('wp_enqueue_scripts', 'blg_enqueue_scripts');


// ============================================================
// 3. UTILITY HELPERS
// ============================================================

/**
 * Get reading time estimate (minutes)
 */
function blg_reading_time($post_id = null)
{
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $minutes = max(1, (int) ceil($word_count / 200));
    return $minutes . ' ' . __('min read', 'blogar');
}

/**
 * Nav menu fallback
 */
function blg_nav_fallback()
{
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'blogar') . '</a></li>';
}

/**
 * Custom excerpt length
 */
function blg_excerpt_length($length)
{
    return 18;
}
add_filter('excerpt_length', 'blg_excerpt_length', 999);

/**
 * Excerpt more string
 */
function blg_excerpt_more($more)
{
    return '&hellip;';
}
add_filter('excerpt_more', 'blg_excerpt_more');