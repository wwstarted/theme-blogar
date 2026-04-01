<?php
if (!defined('ABSPATH')) {
    exit;
}

$logo_dark = get_template_directory_uri() . '/images/logo/logo.png';
$logo_light = get_template_directory_uri() . '/images/logo/white-logo.png';
$cart_count = blogar_get_cart_count();
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div class="main-content">
        <header class="header axil-header header-style-1 header-light header-with-shadow header-sticky">
            <div class="header-wrap">
                <div class="header-inner">
                    <div class="header-branding">
                        <div class="logo">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"
                                aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                                <img class="dark-logo" src="<?php echo esc_url($logo_dark); ?>"
                                    alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                                <img class="light-logo" src="<?php echo esc_url($logo_light); ?>"
                                    alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                            </a>
                        </div>
                    </div>

                    <div class="header-navigation">
                        <div class="mainmenu-wrapper">
                            <nav class="mainmenu-nav" aria-label="<?php esc_attr_e('Primary menu', 'blogar'); ?>">
                                <?php
                                wp_nav_menu(
                                    array(
                                        'theme_location' => 'primary',
                                        'menu_class' => 'mainmenu',
                                        'container' => false,
                                        'fallback_cb' => 'blogar_primary_menu_fallback',
                                    )
                                );
                                ?>
                            </nav>
                        </div>

                        <button class="hamburger-menu" type="button" aria-expanded="false"
                            aria-controls="blogar-mobile-menu" aria-label="<?php esc_attr_e('Open menu', 'blogar'); ?>">
                            <span class="hamburger-inner">
                                <span class="icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" focusable="false">
                                        <path d="M4 7h16M4 12h16M4 17h16" fill="none" stroke="currentColor"
                                            stroke-linecap="round" stroke-width="2"></path>
                                    </svg>
                                </span>
                            </span>
                        </button>
                    </div>

                    <div class="header-actions header-actions-desktop">
                        <div class="header-search">
                            <form role="search" method="get" class="blog-search header-search-form"
                                action="<?php echo esc_url(home_url('/')); ?>">
                                <div class="axil-search form-group">
                                    <button type="submit" class="search-button"
                                        aria-label="<?php esc_attr_e('Search', 'blogar'); ?>">
                                        <svg viewBox="0 0 24 24" focusable="false">
                                            <circle cx="11" cy="11" r="6.5" fill="none" stroke="currentColor"
                                                stroke-width="2"></circle>
                                            <path d="M16 16l4.5 4.5" fill="none" stroke="currentColor"
                                                stroke-linecap="round" stroke-width="2"></path>
                                        </svg>
                                    </button>
                                    <input type="search" name="s" class="form-control"
                                        placeholder="<?php echo esc_attr__('Search ...', 'blogar'); ?>"
                                        value="<?php echo esc_attr(get_search_query()); ?>">
                                </div>
                            </form>

                            <ul class="metabar-block">
                                <li class="icon">
                                    <a href="<?php echo esc_url(function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#'); ?>"
                                        aria-label="<?php esc_attr_e('Cart', 'blogar'); ?>">
                                        <span class="mini-cart">
                                            <svg viewBox="0 0 24 24" focusable="false">
                                                <circle cx="9" cy="20" r="1.5"></circle>
                                                <circle cx="18" cy="20" r="1.5"></circle>
                                                <path d="M3 4h2l2.2 10.2a1 1 0 0 0 1 .8H18a1 1 0 0 0 1-.8L21 7H7"
                                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.8"></path>
                                            </svg>
                                            <span class="aw-cart-count"><?php echo esc_html($cart_count); ?></span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="header-actions header-actions-mobile">
                        <div class="header-search">
                            <div class="search-mobile-icon">
                                <button type="button" aria-expanded="false" aria-controls="blogar-mobile-search"
                                    aria-label="<?php esc_attr_e('Open search', 'blogar'); ?>">
                                    <svg viewBox="0 0 24 24" focusable="false">
                                        <circle cx="11" cy="11" r="6.5" fill="none" stroke="currentColor"
                                            stroke-width="2"></circle>
                                        <path d="M16 16l4.5 4.5" fill="none" stroke="currentColor"
                                            stroke-linecap="round" stroke-width="2"></path>
                                    </svg>
                                </button>
                            </div>

                            <form id="blogar-mobile-search" role="search" method="get"
                                class="blog-search large-mobile-blog-search"
                                action="<?php echo esc_url(home_url('/')); ?>">
                                <div class="axil-search-mobile form-group">
                                    <button type="submit" class="search-button"
                                        aria-label="<?php esc_attr_e('Search', 'blogar'); ?>">
                                        <svg viewBox="0 0 24 24" focusable="false">
                                            <circle cx="11" cy="11" r="6.5" fill="none" stroke="currentColor"
                                                stroke-width="2"></circle>
                                            <path d="M16 16l4.5 4.5" fill="none" stroke="currentColor"
                                                stroke-linecap="round" stroke-width="2"></path>
                                        </svg>
                                    </button>
                                    <input type="search" name="s" class="form-control"
                                        placeholder="<?php echo esc_attr__('Search ...', 'blogar'); ?>"
                                        value="<?php echo esc_attr(get_search_query()); ?>">
                                </div>
                            </form>

                            <ul class="metabar-block">
                                <li class="icon">
                                    <a href="<?php echo esc_url(function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#'); ?>"
                                        aria-label="<?php esc_attr_e('Cart', 'blogar'); ?>">
                                        <span class="mini-cart">
                                            <svg viewBox="0 0 24 24" focusable="false">
                                                <circle cx="9" cy="20" r="1.5"></circle>
                                                <circle cx="18" cy="20" r="1.5"></circle>
                                                <path d="M3 4h2l2.2 10.2a1 1 0 0 0 1 .8H18a1 1 0 0 0 1-.8L21 7H7"
                                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.8"></path>
                                            </svg>
                                            <span class="aw-cart-count"><?php echo esc_html($cart_count); ?></span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="popup-mobilemenu-area" aria-hidden="true">
            <div class="inner">
                <div class="mobile-menu-top">
                    <div class="logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"
                            aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                            <img class="dark-logo" src="<?php echo esc_url($logo_dark); ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                            <img class="light-logo" src="<?php echo esc_url($logo_light); ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        </a>
                    </div>
                    <button class="mobile-close" type="button"
                        aria-label="<?php esc_attr_e('Close menu', 'blogar'); ?>">
                        <span class="icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" focusable="false">
                                <path d="M6 6l12 12M18 6L6 18" fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-width="2"></path>
                            </svg>
                        </span>
                    </button>
                </div>

                <nav id="blogar-mobile-menu" class="menu-item"
                    aria-label="<?php esc_attr_e('Mobile menu', 'blogar'); ?>">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_class' => 'mainmenu-item',
                            'container' => false,
                            'fallback_cb' => 'blogar_primary_menu_fallback',
                        )
                    );
                    ?>
                </nav>
            </div>
        </div>