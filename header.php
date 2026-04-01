<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <!-- Custom animated cursor -->
    <div class="mouse-cursor cursor-outer"></div>
    <div class="mouse-cursor cursor-inner"></div>

    <!-- Dark / Light mode switcher -->
    <div id="my_switcher" class="my_switcher" aria-label="<?php esc_attr_e('Color mode switcher', 'blogar'); ?>">
        <ul>
            <li>
                <a href="#" data-theme="light" class="setColor light"
                    aria-label="<?php esc_attr_e('Light Mode', 'blogar'); ?>">
                    <span><?php esc_html_e('Light', 'blogar'); ?></span>
                </a>
            </li>
            <li>
                <a href="#" data-theme="dark" class="setColor dark"
                    aria-label="<?php esc_attr_e('Dark Mode', 'blogar'); ?>">
                    <span><?php esc_html_e('Dark', 'blogar'); ?></span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">

        <!-- ============================================================
     HEADER
============================================================ -->
        <header class="header axil-header header-style-1 header-light" role="banner" id="blg-header">
            <div class="header-wrap">

                <!-- Logo -->
                <div class="blg-logo col-xl-2 col-lg-3 col-md-3 col-sm-6 col-6">
                    <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>" rel="home">
                        <?php if (has_custom_logo()):
                            $logo_id = get_theme_mod('custom_logo');
                            $logo_url = wp_get_attachment_image_url($logo_id, 'full');
                            ?>
                            <img class="dark-logo" src="<?php echo esc_url($logo_url); ?>"
                                alt="<?php bloginfo('name'); ?>">
                            <img class="light-logo" src="<?php echo esc_url($logo_url); ?>"
                                alt="<?php bloginfo('name'); ?>">
                        <?php else: ?>
                            <img class="dark-logo"
                                src="<?php echo esc_url(get_template_directory_uri() . '/images/logo/logo.png'); ?>"
                                alt="<?php bloginfo('name'); ?>">
                            <img class="light-logo"
                                src="<?php echo esc_url(get_template_directory_uri() . '/images/logo/white-logo.png'); ?>"
                                alt="<?php bloginfo('name'); ?>">
                        <?php endif; ?>
                    </a>
                </div>
                <!-- End Logo -->

                <!-- Desktop Navigation -->
                <div class="axil-mainmenu-withbar col-md-3 col-sm-3 col-3 col-xl-6 d-none d-xl-block">
                    <div class="mainmenu-wrapper">
                        <nav class="mainmenu-nav" aria-label="<?php esc_attr_e('Primary Navigation', 'blogar'); ?>">
                            <?php
                            wp_nav_menu([
                                'theme_location' => 'primary',
                                'container' => false,
                                'menu_id' => 'main-menu',
                                'menu_class' => 'mainmenu',
                                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                'fallback_cb' => 'blg_nav_fallback',
                                'depth' => 3,
                            ]);
                            ?>
                        </nav>
                    </div>

                    <!-- Hamburger (tablet) -->
                    <div class="hamburger-menu d-block d-xl-none" id="blg-hamburger"
                        aria-label="<?php esc_attr_e('Open Menu', 'blogar'); ?>" aria-expanded="false">
                        <div class="hamburger-inner">
                            <div class="icon"><i class="fal fa-bars"></i></div>
                        </div>
                    </div>
                </div>
                <!-- End Desktop Navigation -->

                <!-- Hamburger (mobile — shown outside nav col on small screens) -->
                <div class="d-block d-xl-none col-sm-3 col-3"
                    style="display:flex; align-items:center; justify-content:flex-start;">
                    <div class="hamburger-menu" id="blg-hamburger-mobile"
                        aria-label="<?php esc_attr_e('Open Menu', 'blogar'); ?>" aria-expanded="false">
                        <div class="hamburger-inner">
                            <div class="icon"><i class="fal fa-bars"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Right: Search + Cart -->
                <div class="d-none d-sm-block col-lg-3 col-md-3">
                    <div class="blg-header-actions">
                        <!-- Search form -->
                        <form id="blg-header-search" action="<?php echo esc_url(home_url('/')); ?>" method="GET"
                            class="blog-search" role="search">
                            <div class="axil-search form-group">
                                <button type="submit" class="search-button"
                                    aria-label="<?php esc_attr_e('Search', 'blogar'); ?>">
                                    <i class="fal fa-search"></i>
                                </button>
                                <input type="text" name="s" class="form-control"
                                    placeholder="<?php esc_attr_e('Search ...', 'blogar'); ?>"
                                    value="<?php echo esc_attr(get_search_query()); ?>" autocomplete="off">
                            </div>
                        </form>

                        <!-- Cart (WooCommerce optional) -->
                        <?php if (function_exists('WC')): ?>
                            <ul class="metabar-block">
                                <li class="icon">
                                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>"
                                        aria-label="<?php esc_attr_e('View cart', 'blogar'); ?>">
                                        <span class="mini-cart">
                                            <i class="far fa-shopping-cart"></i>
                                            <span
                                                class="aw-cart-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Mobile Search Toggle -->
                <div class="mobile-search-wrapper d-block d-sm-none col-3">
                    <div class="blg-header-actions">
                        <div class="search-mobile-icon" id="blg-mobile-search-toggle">
                            <button aria-label="<?php esc_attr_e('Search', 'blogar'); ?>">
                                <i class="fal fa-search"></i>
                            </button>
                        </div>
                        <form id="blg-mobile-search" action="<?php echo esc_url(home_url('/')); ?>" method="GET"
                            class="blog-search large-mobile-blog-search" role="search">
                            <div class="axil-search-mobile form-group">
                                <button type="submit" class="search-button"
                                    aria-label="<?php esc_attr_e('Search', 'blogar'); ?>">
                                    <i class="fal fa-search"></i>
                                </button>
                                <input type="text" name="s" class="form-control"
                                    placeholder="<?php esc_attr_e('Search ...', 'blogar'); ?>" autocomplete="off">
                            </div>
                        </form>
                    </div>
                </div>

            </div><!-- /.header-wrap -->
        </header>
        <!-- End Header -->


        <!-- ============================================================
     MOBILE MENU POPUP (Drawer)
============================================================ -->
        <div class="popup-mobilemenu-area" id="blg-mobile-menu" aria-hidden="true">
            <div class="inner" role="dialog" aria-label="<?php esc_attr_e('Mobile Navigation', 'blogar'); ?>">

                <!-- Menu header -->
                <div class="mobile-menu-top">
                    <div class="logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img class="dark-logo"
                                src="<?php echo esc_url(get_template_directory_uri() . '/images/logo/logo.png'); ?>"
                                alt="<?php bloginfo('name'); ?>">
                            <img class="light-logo"
                                src="<?php echo esc_url(get_template_directory_uri() . '/images/logo/white-logo.png'); ?>"
                                alt="<?php bloginfo('name'); ?>">
                        </a>
                    </div>
                    <div class="mobile-close" id="blg-mobile-close"
                        aria-label="<?php esc_attr_e('Close Menu', 'blogar'); ?>">
                        <div class="icon"><i class="fal fa-times"></i></div>
                    </div>
                </div>

                <!-- Mobile Nav -->
                <nav class="menu-item" aria-label="<?php esc_attr_e('Mobile Navigation', 'blogar'); ?>">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_id' => 'mobile-menu',
                        'menu_class' => 'mainmenu-item',
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'fallback_cb' => 'blg_nav_fallback',
                        'depth' => 2,
                    ]);
                    ?>
                </nav>

            </div>
        </div>
        <!-- End Mobile Menu Popup -->