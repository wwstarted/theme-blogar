<?php
/**
 * Blogar — inc/theme-setup.php
 * Core WordPress theme support & image sizes
 */

if (!defined('ABSPATH'))
    exit;

function blg_theme_setup()
{

    load_theme_textdomain('blogar', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('post-formats', ['video', 'audio', 'quote', 'gallery']);
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ]);
    add_theme_support('automatic-feed-links');

    add_theme_support('custom-logo', [
        'height' => 60,
        'width' => 200,
        'flex-height' => true,
        'flex-width' => true,
    ]);

    // Image sizes matching the original theme
    add_image_size('blg-slider', 1230, 615, true);  // Hero slider
    add_image_size('blg-hero-thumb', 600, 400, true);  // Large hero
    add_image_size('blg-tab-thumb', 390, 260, true);  // Tab post thumbnails
    add_image_size('blg-grid-small', 285, 190, true);  // Small grid
    add_image_size('blg-category-icon', 180, 180, true);  // Category circle
    add_image_size('blg-medium', 300, 169, true);  // Medium horizontal
    add_image_size('blg-thumbnail', 150, 150, true);  // Sidebar small
}
add_action('after_setup_theme', 'blg_theme_setup');