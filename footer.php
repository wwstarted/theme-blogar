<?php
if (! defined('ABSPATH')) {
    exit;
}

$logo_dark = get_template_directory_uri() . '/images/logo/logo.png';

$footer_columns = array(
    'World' => array('U.N.', 'Conflicts', 'Terrorism', 'Disasters', 'Global Economy', 'Environment', 'Religion', 'Scandals'),
    'Politics' => array('Executive', 'Senate', 'House', 'Judiciary', 'Global Economy', 'Foreign policy', 'Polls', 'Elections'),
    'Entertainment' => array('Celebrity News', 'Movies', 'TV News', 'Disasters', 'Music News', 'Environment', 'Style News', 'Entertainment Video'),
    'Business' => array('Environment', 'Conflicts', 'Terrorism', 'Disasters', 'Global Economy', 'Environment', 'Religion', 'Scandals'),
    'Health' => array('Movies', 'Conflicts', 'Terrorism', 'Disasters', 'Global Economy', 'Global Economy', 'Environment', 'Religion', 'Scandals'),
    'About' => array('U.N.', 'Conflicts', 'Terrorism', 'Disasters', 'Global Economy', 'Environment', 'Religion', 'Scandals'),
);

$social_links = array(
    array(
        'label' => 'Facebook',
        'url'   => 'https://www.facebook.com/',
        'icon'  => '<path d="M14 8h2V4h-2.5C10.9 4 10 5.6 10 8.1V10H8v4h2v6h4v-6h2.7l.3-4H14V8z"></path>',
    ),
    array(
        'label' => 'Twitter',
        'url'   => 'https://twitter.com/',
        'icon'  => '<path d="M20 7.4c-.6.3-1.3.5-2 .6.7-.4 1.2-1 1.5-1.8-.7.4-1.5.7-2.3.9A3.5 3.5 0 0 0 11.3 10c0 .3 0 .5.1.8-2.9-.1-5.5-1.5-7.2-3.7-.3.5-.5 1-.5 1.7 0 1.2.6 2.2 1.5 2.8-.6 0-1.1-.2-1.6-.4 0 1.7 1.2 3 2.8 3.4-.3.1-.6.1-1 .1-.2 0-.5 0-.7-.1.5 1.4 1.8 2.4 3.4 2.4A7 7 0 0 1 4 18.3 10 10 0 0 0 9.4 20c6.5 0 10.1-5.4 10.1-10.1v-.5c.7-.5 1.3-1.1 1.8-1.9-.6.3-1.2.5-1.9.6.7-.4 1.2-1 1.5-1.7-.6.4-1.3.7-2 .9z"></path>',
    ),
    array(
        'label' => 'LinkedIn',
        'url'   => 'https://linkedin.com/',
        'icon'  => '<path d="M6.5 8.5A1.5 1.5 0 1 1 6.5 5a1.5 1.5 0 0 1 0 3.5zM5 10h3v9H5zm5 0h2.9v1.3h.1c.4-.8 1.4-1.6 2.9-1.6 3.1 0 3.6 2 3.6 4.7V19h-3v-4c0-1 0-2.4-1.5-2.4s-1.7 1.1-1.7 2.3V19h-3z"></path>',
    ),
    array(
        'label' => 'Instagram',
        'url'   => 'https://instagram.com/',
        'icon'  => '<path d="M12 7.2A4.8 4.8 0 1 0 16.8 12 4.8 4.8 0 0 0 12 7.2zm0 7.9A3.1 3.1 0 1 1 15.1 12 3.1 3.1 0 0 1 12 15.1zm5.2-8.1a1.1 1.1 0 1 1-1.1-1.1 1.1 1.1 0 0 1 1.1 1.1zm3 1.1c-.1-1.3-.4-2.4-1.3-3.3s-2-1.2-3.3-1.3C14.2 3.4 9.8 3.4 8.4 3.5 7 3.6 5.9 4 5 4.8S3.8 6.8 3.7 8.1C3.6 9.5 3.6 13.9 3.7 15.3c.1 1.3.4 2.4 1.3 3.3S7 19.8 8.4 19.9c1.4.1 5.8.1 7.2 0 1.3-.1 2.4-.4 3.3-1.3s1.2-2 1.3-3.3c.1-1.4.1-5.8 0-7.2zm-2 8.7c-.3.8-.9 1.4-1.7 1.7-1.2.5-4 .4-5.3.4s-4.1.1-5.3-.4c-.8-.3-1.4-.9-1.7-1.7-.5-1.2-.4-4-.4-5.3s-.1-4.1.4-5.3c.3-.8.9-1.4 1.7-1.7 1.2-.5 4-.4 5.3-.4s4.1-.1 5.3.4c.8.3 1.4.9 1.7 1.7.5 1.2.4 4 .4 5.3s.1 4.1-.4 5.3z"></path>',
    ),
);

$bottom_links = array('Contact Us', 'Terms of Use', 'Advertise with Us', 'Blogar Store');
?>
<footer class="axil-footer-area axil-default-footer axil-footer-var-1 footer-menu-active">
    <div class="footer-mainmenu">
        <div class="footer-container">
            <div class="footer-grid">
                <?php
                $index = 0;
                foreach ($footer_columns as $title => $links) :
                    $index++;
                    ?>
                    <div class="footer-grid-col">
                        <div class="footer-widget-item<?php echo 1 === $index ? ' axil-border-right' : ''; ?><?php echo $index >= 4 ? ' widget-last' : ''; ?>">
                            <section class="footer-widget-item widget widget_nav_menu" aria-label="<?php echo esc_attr($title); ?>">
                                <h5 class="widget-title"><?php echo esc_html($title); ?></h5>
                                <ul class="menu">
                                    <?php foreach ($links as $link) : ?>
                                        <li class="menu-item">
                                            <a href="#"><?php echo esc_html($link); ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </section>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="footer-top">
        <div class="footer-container">
            <div class="footer-top-row">
                <div class="footer-top-brand">
                    <div class="logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                            <img class="dark-logo" src="<?php echo esc_url($logo_dark); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        </a>
                    </div>
                </div>

                <div class="footer-top-social">
                    <div class="footer-social-wrap">
                        <h5 class="follow-title">Follow us</h5>
                        <ul class="social-icon color-tertiary md-size justify-content-start">
                            <?php foreach ($social_links as $social) : ?>
                                <li>
                                    <a class="social-icon-link" href="<?php echo esc_url($social['url']); ?>" title="<?php echo esc_attr($social['label']); ?>" target="_blank" rel="noopener">
                                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                            <?php echo $social['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                        </svg>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright-area">
        <div class="footer-container">
            <div class="copyright-row">
                <div class="copyright-left">
                    <ul class="mainmenu justify-content-start">
                        <?php foreach ($bottom_links as $link) : ?>
                            <li class="menu-item">
                                <a href="#"><?php echo esc_html($link); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="copyright-right">
                    <p>&copy; 2022. All rights reserved by <a href="https://themeforest.net/user/axilthemes/portfolio" target="_blank" rel="noopener">Axilthemes.</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>

</div>

<?php wp_footer(); ?>
</body>
</html>
