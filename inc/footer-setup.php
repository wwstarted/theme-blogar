<?php
/**
 * Blogar — inc/footer-setup.php
 * Register widget areas (sidebars)
 */

if (!defined('ABSPATH'))
    exit;

function blg_register_sidebars()
{

    // Homepage right sidebar (Latest posts, Social, Gallery widgets)
    register_sidebar([
        'name' => __('Homepage Sidebar', 'blogar'),
        'id' => 'blg-home-sidebar',
        'description' => __('Sidebar widgets displayed on the homepage right column.', 'blogar'),
        'before_widget' => '<div id="%1$s" class="widget-sidebar widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title"><h3>',
        'after_title' => '</h3></div>',
    ]);

    // Footer widget columns (World, Politics, Entertainment, Health, Science)
    $footer_cols = [
        'blg-footer-col-1' => __('Footer Column 1 (World)', 'blogar'),
        'blg-footer-col-2' => __('Footer Column 2 (Politics)', 'blogar'),
        'blg-footer-col-3' => __('Footer Column 3 (Entertainment)', 'blogar'),
        'blg-footer-col-4' => __('Footer Column 4 (Health)', 'blogar'),
        'blg-footer-col-5' => __('Footer Column 5 (Science)', 'blogar'),
    ];

    foreach ($footer_cols as $id => $name) {
        register_sidebar([
            'name' => $name,
            'id' => $id,
            'description' => __('Footer navigation column widget area.', 'blogar'),
            'before_widget' => '<div id="%1$s" class="footer-widget-item widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h5 class="widget-title">',
            'after_title' => '</h5>',
        ]);
    }
}
add_action('widgets_init', 'blg_register_sidebars');