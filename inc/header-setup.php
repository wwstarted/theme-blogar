<?php
/**
 * Blogar — inc/header-setup.php
 * Nav menus registration
 */

if (!defined('ABSPATH'))
    exit;

function blg_register_menus()
{
    register_nav_menus([
        'primary' => __('Primary Navigation', 'blogar'),
        'footer' => __('Footer Navigation', 'blogar'),
    ]);
}
add_action('after_setup_theme', 'blg_register_menus');