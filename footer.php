</div><!-- /.main-content  (opened in header.php) -->


<!-- ============================================================
     INSTAGRAM SECTION
     Note: Uses "Smash Balloon Social Photo Feed" plugin.
     Drop the shortcode or widget block here in production.
============================================================ -->
<?php if (is_active_widget(false, false, 'null-instagram-feed', true) || shortcode_exists('instagram-feed')): ?>
    <section class="axil-instagram-area axil-section-gap bg-color-grey"
        aria-label="<?php esc_attr_e('Instagram Feed', 'blogar'); ?>">
        <div class="blg-container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center mb--30">
                        <h2 class="title"><?php esc_html_e('Instagram', 'blogar'); ?></h2>
                    </div>
                </div>
            </div>
            <div class="row mt--30">
                <div class="col-lg-12">
                    <?php echo do_shortcode('[instagram-feed num=6 cols=6 showheader=false showbutton=false showfollow=false]'); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- End Instagram Area -->


<!-- ============================================================
     FOOTER
============================================================ -->
<footer class="axil-footer-area axil-default-footer" role="contentinfo">

    <!-- Footer Top: Widget Columns -->
    <div class="footer-mainmenu">
        <div class="container">
            <div class="row">

                <!-- Col 1 -->
                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget-item axil-border-right">
                        <?php if (is_active_sidebar('blg-footer-col-1')):
                            dynamic_sidebar('blg-footer-col-1');
                        else: ?>
                            <h5 class="widget-title"><?php esc_html_e('World', 'blogar'); ?></h5>
                            <ul class="menu">
                                <li><a href="#"><?php esc_html_e('U.N.', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Conflicts', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Terrorism', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Disasters', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Global Economy', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Environment', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Religion', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Scandals', 'blogar'); ?></a></li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Col 2 -->
                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget-item">
                        <?php if (is_active_sidebar('blg-footer-col-2')):
                            dynamic_sidebar('blg-footer-col-2');
                        else: ?>
                            <h5 class="widget-title"><?php esc_html_e('Politics', 'blogar'); ?></h5>
                            <ul class="menu">
                                <li><a href="#"><?php esc_html_e('Executive', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Senate', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('House', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Judiciary', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Global Economy', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Foreign policy', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Polls', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Elections', 'blogar'); ?></a></li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Col 3 -->
                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget-item">
                        <?php if (is_active_sidebar('blg-footer-col-3')):
                            dynamic_sidebar('blg-footer-col-3');
                        else: ?>
                            <h5 class="widget-title"><?php esc_html_e('Entertainment', 'blogar'); ?></h5>
                            <ul class="menu">
                                <li><a href="#"><?php esc_html_e('Celebrity News', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Movies', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('TV', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Music', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Reviews', 'blogar'); ?></a></li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Col 4 -->
                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget-item">
                        <?php if (is_active_sidebar('blg-footer-col-4')):
                            dynamic_sidebar('blg-footer-col-4');
                        else: ?>
                            <h5 class="widget-title"><?php esc_html_e('Health', 'blogar'); ?></h5>
                            <ul class="menu">
                                <li><a href="#"><?php esc_html_e('Body', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Mind & Body', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Fitness', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Nutrition', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Weight Loss', 'blogar'); ?></a></li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Col 5 -->
                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget-item">
                        <?php if (is_active_sidebar('blg-footer-col-5')):
                            dynamic_sidebar('blg-footer-col-5');
                        else: ?>
                            <h5 class="widget-title"><?php esc_html_e('Science', 'blogar'); ?></h5>
                            <ul class="menu">
                                <li><a href="#"><?php esc_html_e('Space', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Environment', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Origins', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Physics', 'blogar'); ?></a></li>
                                <li><a href="#"><?php esc_html_e('Animals', 'blogar'); ?></a></li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>
    <!-- End Footer Top -->


    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">

            <!-- Logo -->
            <div class="footer-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php if (has_custom_logo()):
                        $logo_id = get_theme_mod('custom_logo');
                        $logo_url = wp_get_attachment_image_url($logo_id, 'full');
                        ?>
                        <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>">
                    <?php else: ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/logo/logo.png'); ?>"
                            alt="<?php bloginfo('name'); ?>">
                    <?php endif; ?>
                </a>
            </div>

            <!-- Bottom Nav -->
            <?php
            wp_nav_menu([
                'theme_location' => 'footer',
                'container' => false,
                'menu_class' => 'footer-bottom-nav',
                'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                'depth' => 1,
                'fallback_cb' => false,
            ]);
            ?>

            <!-- Copyright -->
            <div class="copyright-right text-left text-lg-right">
                <p>
                    &copy; <?php echo esc_html(gmdate('Y')); ?>.
                    <?php
                    printf(
                        /* translators: %s: site name */
                        esc_html__('All rights reserved by %s.', 'blogar'),
                        '<a href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a>'
                    );
                    ?>
                </p>
            </div>

        </div>
    </div>
    <!-- End Footer Bottom -->

</footer>
<!-- End Footer -->


<!-- Back To Top -->
<a id="backto-top" href="#" aria-label="<?php esc_attr_e('Back to top', 'blogar'); ?>"></a>

<?php wp_footer(); ?>
</body>

</html>