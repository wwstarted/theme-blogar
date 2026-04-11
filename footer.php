<?php
if (!defined('ABSPATH')) {
    exit;
}

$logo_light = get_template_directory_uri() . '/images/logo/white-logo.png';
$logo_dark  = get_template_directory_uri() . '/images/logo/logo.png';

// ── Colors ──────────────────────────────────────────────────────
$footer_bg         = get_option('blogar_footer_bg_color', '#0f1c1e');
$footer_text_color = get_option('blogar_footer_text_color', '#a8bfc2');

// ── Col 1: Brand ────────────────────────────────────────────────
$footer_desc    = get_option('blogar_footer_desc', '');
$footer_phone   = get_option('blogar_footer_phone', '');
$footer_email   = get_option('blogar_footer_email', '');
$footer_address = get_option('blogar_footer_address', '');

// ── Col 2 & 3: Titles ───────────────────────────────────────────
$footer_col2_title = get_option('blogar_footer_col2_title', 'Quick Links');
$footer_col3_title = get_option('blogar_footer_col3_title', 'Our Pages');

// ── Col 4: Newsletter or Social ─────────────────────────────────
$footer_col4_type  = get_option('blogar_footer_col4_type', 'newsletter');
$footer_col4_title = get_option('blogar_footer_col4_title', '');
$footer_col4_desc  = get_option('blogar_footer_col4_desc', '');

$social_items = array(
    'fb' => array(
        'label' => 'Facebook',
        'url'   => get_option('blogar_footer_fb_url', ''),
        'icon'  => '<path d="M14 8h2V4h-2.5C10.9 4 10 5.6 10 8.1V10H8v4h2v6h4v-6h2.7l.3-4H14V8z"/>',
    ),
    'tw' => array(
        'label' => 'Twitter / X',
        'url'   => get_option('blogar_footer_tw_url', ''),
        'icon'  => '<path d="M20 7.4c-.6.3-1.3.5-2 .6.7-.4 1.2-1 1.5-1.8-.7.4-1.5.7-2.3.9A3.5 3.5 0 0 0 11.3 10c0 .3 0 .5.1.8-2.9-.1-5.5-1.5-7.2-3.7-.3.5-.5 1-.5 1.7 0 1.2.6 2.2 1.5 2.8-.6 0-1.1-.2-1.6-.4 0 1.7 1.2 3 2.8 3.4-.3.1-.6.1-1 .1-.2 0-.5 0-.7-.1.5 1.4 1.8 2.4 3.4 2.4A7 7 0 0 1 4 18.3 10 10 0 0 0 9.4 20c6.5 0 10.1-5.4 10.1-10.1v-.5c.7-.5 1.3-1.1 1.8-1.9-.6.3-1.2.5-1.9.6.7-.4 1.2-1 1.5-1.7-.6.4-1.3.7-2 .9z"/>',
    ),
    'li' => array(
        'label' => 'LinkedIn',
        'url'   => get_option('blogar_footer_li_url', ''),
        'icon'  => '<path d="M6.5 8.5A1.5 1.5 0 1 1 6.5 5a1.5 1.5 0 0 1 0 3.5zM5 10h3v9H5zm5 0h2.9v1.3h.1c.4-.8 1.4-1.6 2.9-1.6 3.1 0 3.6 2 3.6 4.7V19h-3v-4c0-1 0-2.4-1.5-2.4s-1.7 1.1-1.7 2.3V19h-3z"/>',
    ),
    'ig' => array(
        'label' => 'Instagram',
        'url'   => get_option('blogar_footer_ig_url', ''),
        'icon'  => '<path d="M12 7.2A4.8 4.8 0 1 0 16.8 12 4.8 4.8 0 0 0 12 7.2zm0 7.9A3.1 3.1 0 1 1 15.1 12 3.1 3.1 0 0 1 12 15.1zm5.2-8.1a1.1 1.1 0 1 1-1.1-1.1 1.1 1.1 0 0 1 1.1 1.1zm3 1.1c-.1-1.3-.4-2.4-1.3-3.3s-2-1.2-3.3-1.3C14.2 3.4 9.8 3.4 8.4 3.5 7 3.6 5.9 4 5 4.8S3.8 6.8 3.7 8.1C3.6 9.5 3.6 13.9 3.7 15.3c.1 1.3.4 2.4 1.3 3.3S7 19.8 8.4 19.9c1.4.1 5.8.1 7.2 0 1.3-.1 2.4-.4 3.3-1.3s1.2-2 1.3-3.3c.1-1.4.1-5.8 0-7.2zm-2 8.7c-.3.8-.9 1.4-1.7 1.7-1.2.5-4 .4-5.3.4s-4.1.1-5.3-.4c-.8-.3-1.4-.9-1.7-1.7-.5-1.2-.4-4-.4-5.3s-.1-4.1.4-5.3c.3-.8.9-1.4 1.7-1.7 1.2-.5 4-.4 5.3-.4s4.1-.1 5.3.4c.8.3 1.4.9 1.7 1.7.5 1.2.4 4 .4 5.3s.1 4.1-.4 5.3z"/>',
    ),
    'yt' => array(
        'label' => 'YouTube',
        'url'   => get_option('blogar_footer_yt_url', ''),
        'icon'  => '<path d="M21.8 8s-.2-1.4-.8-2c-.8-.8-1.6-.8-2-.9C16.6 5 12 5 12 5s-4.6 0-7 .1c-.4.1-1.2.1-2 .9-.6.6-.8 2-.8 2S2 9.6 2 11.2v1.5c0 1.6.2 3.2.2 3.2s.2 1.4.8 2c.8.8 1.8.8 2.3.8C6.8 19 12 19 12 19s4.6 0 7-.1c.4-.1 1.2-.1 2-.9.6-.6.8-2 .8-2s.2-1.6.2-3.2v-1.5C22 9.6 21.8 8 21.8 8zM9.8 14.5V9l5.5 2.8-5.5 2.7z"/>',
    ),
);

// Check if any social URL is configured
$has_socials = false;
foreach ($social_items as $s) {
    if (!empty($s['url'])) {
        $has_socials = true;
        break;
    }
}

// ── Copyright ────────────────────────────────────────────────────
$footer_copyright    = get_option('blogar_footer_copyright', '');
$default_copyright   = '&copy; ' . gmdate('Y') . ' ' . get_bloginfo('name') . '. ' . __('All rights reserved.', 'blogar');

// ── Newsletter feedback message ──────────────────────────────────
$nl_status = isset($_GET['newsletter']) ? sanitize_key($_GET['newsletter']) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

// Use light logo if bg is dark (simple check: first char of hex after # is 0-4)
$use_light_logo = hexdec(substr(ltrim($footer_bg, '#'), 0, 2)) < 128;
$logo_src = $use_light_logo ? $logo_light : $logo_dark;
// Fallback: if light logo file doesn't exist, always use dark
?>
<footer class="site-footer" style="--f-bg:<?php echo esc_attr($footer_bg); ?>;--f-text:<?php echo esc_attr($footer_text_color); ?>">
    <div class="footer-main">
        <div class="footer-container">
            <div class="footer-cols">

                <!-- Col 1: Brand info -->
                <div class="footer-col footer-col--brand">
                    <div class="footer-logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"
                            aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                            <img src="<?php echo esc_url($logo_src); ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        </a>
                    </div>

                    <?php if ($footer_desc): ?>
                    <p class="footer-brand-desc"><?php echo esc_html($footer_desc); ?></p>
                    <?php endif; ?>

                    <?php if ($footer_phone || $footer_email || $footer_address): ?>
                    <ul class="footer-contact-list">
                        <?php if ($footer_phone): ?>
                        <li class="footer-contact-item">
                            <svg class="footer-contact-icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/>
                            </svg>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^\d+]/', '', $footer_phone)); ?>">
                                <?php echo esc_html($footer_phone); ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if ($footer_email): ?>
                        <li class="footer-contact-item">
                            <svg class="footer-contact-icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <a href="mailto:<?php echo esc_attr($footer_email); ?>">
                                <?php echo esc_html($footer_email); ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if ($footer_address): ?>
                        <li class="footer-contact-item">
                            <svg class="footer-contact-icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            <span><?php echo esc_html($footer_address); ?></span>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <?php endif; ?>
                </div>

                <!-- Col 2: Category nav -->
                <div class="footer-col footer-col--nav">
                    <p class="footer-col-title"><?php echo esc_html($footer_col2_title); ?></p>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-col2',
                        'container'      => false,
                        'menu_class'     => 'footer-nav-list',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>

                <!-- Col 3: Pages nav -->
                <div class="footer-col footer-col--nav">
                    <p class="footer-col-title"><?php echo esc_html($footer_col3_title); ?></p>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-col3',
                        'container'      => false,
                        'menu_class'     => 'footer-nav-list',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>

                <!-- Col 4: Newsletter or Social -->
                <div class="footer-col footer-col--cta">

                    <?php if ('social' === $footer_col4_type): ?>

                    <p class="footer-col-title"><?php echo esc_html($footer_col4_title ?: __('Follow Us', 'blogar')); ?></p>
                    <?php if ($footer_col4_desc): ?>
                    <p class="footer-cta-desc"><?php echo esc_html($footer_col4_desc); ?></p>
                    <?php endif; ?>
                    <?php if ($has_socials): ?>
                    <ul class="footer-social-list">
                        <?php foreach ($social_items as $social):
                            if (empty($social['url'])) continue;
                        ?>
                        <li>
                            <a href="<?php echo esc_url($social['url']); ?>"
                                title="<?php echo esc_attr($social['label']); ?>"
                                target="_blank" rel="noopener noreferrer">
                                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                    <?php echo $social['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </svg>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <?php else: ?>

                    <p class="footer-col-title"><?php echo esc_html($footer_col4_title ?: __('Newsletter', 'blogar')); ?></p>
                    <?php if ($footer_col4_desc): ?>
                    <p class="footer-cta-desc"><?php echo esc_html($footer_col4_desc); ?></p>
                    <?php endif; ?>

                    <?php if ('success' === $nl_status): ?>
                    <p class="footer-nl-notice footer-nl-notice--ok">
                        <?php esc_html_e('Thank you! You have been subscribed.', 'blogar'); ?>
                    </p>
                    <?php elseif ('invalid' === $nl_status): ?>
                    <p class="footer-nl-notice footer-nl-notice--err">
                        <?php esc_html_e('Please enter a valid email address.', 'blogar'); ?>
                    </p>
                    <?php endif; ?>

                    <form class="footer-newsletter-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                        <input type="hidden" name="action" value="blogar_newsletter">
                        <?php wp_nonce_field('blogar_newsletter_nonce', '_wpnonce'); ?>
                        <div class="footer-newsletter-row">
                            <div class="footer-newsletter-input-wrap">
                                <svg class="footer-nl-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                                <input type="email" name="blogar_nl_email"
                                    class="footer-newsletter-input"
                                    placeholder="<?php esc_attr_e('Enter your email...', 'blogar'); ?>"
                                    required>
                            </div>
                            <button type="submit" class="footer-newsletter-btn"
                                aria-label="<?php esc_attr_e('Subscribe', 'blogar'); ?>">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </form>

                    <?php if ($has_socials): ?>
                    <ul class="footer-social-list footer-social-list--inline">
                        <?php foreach ($social_items as $social):
                            if (empty($social['url'])) continue;
                        ?>
                        <li>
                            <a href="<?php echo esc_url($social['url']); ?>"
                                title="<?php echo esc_attr($social['label']); ?>"
                                target="_blank" rel="noopener noreferrer">
                                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                    <?php echo $social['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </svg>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <?php endif; ?>
                </div>

            </div><!-- /.footer-cols -->
        </div>
    </div><!-- /.footer-main -->

    <div class="footer-bottom">
        <div class="footer-container">
            <p class="footer-copyright">
                <?php
                if ($footer_copyright) {
                    echo wp_kses_post($footer_copyright);
                } else {
                    echo wp_kses_post($default_copyright);
                }
                ?>
            </p>
        </div>
    </div>
</footer>

</div>

<?php wp_footer(); ?>
</body>

</html>
