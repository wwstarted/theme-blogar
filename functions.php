<?php
if (!defined('ABSPATH')) {
    exit;
}

// ================================================================
// THEME INCLUDES
// ================================================================

require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/theme-options.php';


// ================================================================
// THEME SETUP
// ================================================================

function blogar_theme_setup()
{
    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'blogar'),
        )
    );

    add_theme_support(
        'custom-logo',
        array(
            'height' => 37,
            'width' => 158,
            'flex-height' => true,
            'flex-width' => true,
        )
    );

    // Hỗ trợ featured image cho posts.
    add_theme_support('post-thumbnails');

    // ── Custom image sizes ─────────────────────────────────────
    // Hero slider: 1230x615 (ratio 2:1)
    add_image_size('blogar-hero', 1230, 615, true);

    // Featured posts / grid cards
    add_image_size('blogar-featured', 300, 169, true);

    // Tab carousel cards
    add_image_size('blogar-card', 390, 260, true);

    // Big grid post
    add_image_size('blogar-grid-big', 705, 660, true);

    // Small grid post
    add_image_size('blogar-grid-small', 495, 300, true);

    // Post list view
    add_image_size('blogar-list', 300, 169, true);

    // Sidebar recent posts / thumbnail round
    add_image_size('blogar-thumb', 150, 150, true);

    // Category carousel (square)
    add_image_size('blogar-cat', 300, 300, true);

    // Video section small cards
    add_image_size('blogar-video-small', 285, 190, true);

    // Video section big card
    add_image_size('blogar-featured-video-big', 600, 500, true);
}
add_action('after_setup_theme', 'blogar_theme_setup');


// ================================================================
// ASSET VERSIONING
// ================================================================

function blogar_asset_version($relative_path)
{
    $path = get_template_directory() . '/' . ltrim($relative_path, '/');

    if (file_exists($path)) {
        return (string) filemtime($path);
    }

    return wp_get_theme()->get('Version');
}


// ================================================================
// ENQUEUE ASSETS
// ================================================================

function blogar_enqueue_assets()
{
    wp_enqueue_style(
        'blogar-fonts',
        'https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;700;900&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'blogar-global',
        get_template_directory_uri() . '/css/style.css',
        array('blogar-fonts'),
        blogar_asset_version('css/style.css')
    );

    wp_enqueue_style(
        'blogar-header',
        get_template_directory_uri() . '/css/header.css',
        array('blogar-global'),
        blogar_asset_version('css/header.css')
    );

    wp_enqueue_style(
        'blogar-footer',
        get_template_directory_uri() . '/css/footer.css',
        array('blogar-global'),
        blogar_asset_version('css/footer.css')
    );

    if (is_front_page() || is_archive() || is_search() || is_single() || is_page() || (is_home() && !is_front_page())) {
        wp_enqueue_style(
            'blogar-frontpage',
            get_template_directory_uri() . '/css/frontpage.css',
            array('blogar-global'),
            blogar_asset_version('css/frontpage.css')
        );
    }

    wp_enqueue_script(
        'blogar-header',
        get_template_directory_uri() . '/js/header.js',
        array(),
        blogar_asset_version('js/header.js'),
        true
    );

    wp_enqueue_script(
        'blogar-footer',
        get_template_directory_uri() . '/js/footer.js',
        array(),
        blogar_asset_version('js/footer.js'),
        true
    );

    if (is_front_page() || is_archive() || is_search() || is_single() || is_page() || (is_home() && !is_front_page())) {
        wp_enqueue_script(
            'blogar-frontpage',
            get_template_directory_uri() . '/js/frontpage.js',
            array(),
            blogar_asset_version('js/frontpage.js'),
            true
        );
    }

    if (is_archive() || is_search() || is_single() || is_page() || (is_home() && !is_front_page())) {
        wp_enqueue_style(
            'blogar-archive',
            get_template_directory_uri() . '/css/archive.css',
            array('blogar-frontpage'),
            blogar_asset_version('css/archive.css')
        );
    }

    if (is_single() || is_page()) {
        wp_enqueue_style(
            'blogar-single',
            get_template_directory_uri() . '/css/single.css',
            array('blogar-frontpage', 'blogar-archive'),
            blogar_asset_version('css/single.css')
        );
    }

    if (is_page()) {
        wp_enqueue_style(
            'blogar-page',
            get_template_directory_uri() . '/css/page.css',
            array('blogar-archive', 'blogar-single'),
            blogar_asset_version('css/page.css')
        );
    }

    if (is_author()) {
        wp_enqueue_style(
            'blogar-author',                                        // handle
            get_template_directory_uri() . '/css/author.css',
            array('blogar-archive'),                             // depends on archive.css
            wp_get_theme()->get('Version')
        );
    }

    if (is_page_template('page-contact.php')) {
        wp_enqueue_style(
            'blogar-page-contact',
            get_template_directory_uri() . '/css/page-contact.css',
            array('blogar-page'),
            blogar_asset_version('css/page-contact.css')
        );
    }
}
add_action('wp_enqueue_scripts', 'blogar_enqueue_assets');


// ================================================================
// FALLBACK MENU
// ================================================================

function blogar_primary_menu_fallback($args)
{
    $menu_class = isset($args['menu_class']) ? $args['menu_class'] : 'mainmenu';

    $items = array(
        array(
            'label' => __('Home', 'blogar'),
            'url' => home_url('/'),
            'current' => is_front_page() || is_home(),
            'children' => array(
                array(
                    'label' => __('Home Default', 'blogar'),
                    'url' => home_url('/'),
                    'current' => is_front_page() || is_home(),
                ),
            ),
        ),
        array(
            'label' => __('Posts', 'blogar'),
            'url' => home_url('/'),
            'children' => array(
                array(
                    'label' => __('Latest Posts', 'blogar'),
                    'url' => home_url('/'),
                ),
            ),
        ),
        array(
            'label' => __('Pages', 'blogar'),
            'url' => '#',
            'children' => array(
                array(
                    'label' => __('About Us', 'blogar'),
                    'url' => '#',
                ),
                array(
                    'label' => __('Contact Us', 'blogar'),
                    'url' => '#',
                ),
            ),
        ),
        array(
            'label' => __('Lifestyle', 'blogar'),
            'url' => '#',
        ),
        array(
            'label' => __('Technology', 'blogar'),
            'url' => '#',
        ),
        array(
            'label' => __('Shop', 'blogar'),
            'url' => '#',
            'children' => array(
                array(
                    'label' => __('Shop', 'blogar'),
                    'url' => '#',
                ),
                array(
                    'label' => __('Cart', 'blogar'),
                    'url' => '#',
                ),
                array(
                    'label' => __('Checkout', 'blogar'),
                    'url' => '#',
                ),
            ),
        ),
    );

    $output = '<ul class="' . esc_attr($menu_class) . '">';

    foreach ($items as $item) {
        $classes = array('menu-item');

        if (!empty($item['children'])) {
            $classes[] = 'menu-item-has-children';
        }

        if (!empty($item['current'])) {
            $classes[] = 'current-menu-item';
            $classes[] = 'current_page_item';
        }

        $output .= '<li class="' . esc_attr(implode(' ', $classes)) . '">';
        $output .= '<a href="' . esc_url($item['url']) . '"' . (!empty($item['current']) ? ' aria-current="page"' : '') . '>' . esc_html($item['label']) . '</a>';

        if (!empty($item['children'])) {
            $output .= '<ul class="sub-menu">';

            foreach ($item['children'] as $child) {
                $child_classes = array('menu-item');

                if (!empty($child['current'])) {
                    $child_classes[] = 'current-menu-item';
                    $child_classes[] = 'current_page_item';
                }

                $output .= '<li class="' . esc_attr(implode(' ', $child_classes)) . '">';
                $output .= '<a href="' . esc_url($child['url']) . '"' . (!empty($child['current']) ? ' aria-current="page"' : '') . '>' . esc_html($child['label']) . '</a>';
                $output .= '</li>';
            }

            $output .= '</ul>';
        }

        $output .= '</li>';
    }

    $output .= '</ul>';

    if (!empty($args['echo'])) {
        echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    return $output;
}


// ================================================================
// WOOCOMMERCE CART COUNT
// ================================================================

function blogar_get_cart_count()
{
    if (class_exists('WooCommerce') && function_exists('WC') && WC()->cart) {
        return WC()->cart->get_cart_contents_count();
    }

    return 0;
}