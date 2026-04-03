<?php
/**
 * page-contact.php — Blogar Theme
 *
 * Template Name: Contact Page
 *
 * SEO  : Exactly 1 <h1> per page — inside the hero banner.
 * Data : WordPress loop; the_title() cho banner, the_content() cho intro prose.
 * CSS  : archive.css (sidebar/shared) + single.css (prose) + page.css (banner + contact form).
 *
 * Layout:
 *   Hero banner  → identical to page.php
 *   col-lg-8     → the_content() (intro) + contact form section
 *   col-lg-4     → sidebar: Search, Recent Posts, Newsletter, Social
 *
 * Contact form:
 *   UI-only HTML form (no CF7 dependency).
 *   Compatible với CF7 class hooks nếu plugin được install sau.
 *   Backend handling cần CF7 hoặc custom wp_ajax handler.
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// ── Inline SVG icons ─────────────────────────────────────────────
$svg_fb = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>';
$svg_tw = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>';
$svg_li = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>';
$svg_ig = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5" fill="none" stroke="currentColor" stroke-width="2"/><path fill="none" stroke="currentColor" stroke-width="2" d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>';
$svg_pi = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12c0 4.24 2.65 7.86 6.39 9.29-.09-.78-.17-1.98.04-2.83.18-.77 1.22-5.17 1.22-5.17s-.31-.63-.31-1.56c0-1.46.85-2.55 1.9-2.55.9 0 1.33.67 1.33 1.48 0 .9-.58 2.26-.87 3.52-.25 1.05.52 1.9 1.55 1.9 1.86 0 3.3-1.96 3.3-4.8 0-2.51-1.8-4.26-4.38-4.26-2.98 0-4.73 2.23-4.73 4.54 0 .9.35 1.86.78 2.39.09.1.1.19.07.29-.08.33-.26 1.05-.29 1.19-.05.19-.16.23-.37.14-1.39-.65-2.26-2.68-2.26-4.32 0-3.51 2.55-6.74 7.35-6.74 3.86 0 6.86 2.75 6.86 6.42 0 3.83-2.41 6.9-5.76 6.9-1.13 0-2.19-.59-2.55-1.28l-.69 2.59c-.25.96-.93 2.17-1.38 2.9.04.01.08.01.12.01.96.29 1.97.45 3.02.45 5.52 0 10-4.48 10-10S17.52 2 12 2z"/></svg>';
$svg_search = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>';

// ── Hero banner setup (run before output) ────────────────────────
while (have_posts()):
    the_post();
    $page_id = get_the_ID();
    $page_title = get_the_title();
    $page_excerpt = has_excerpt() ? get_the_excerpt() : '';

    // Banner bg: featured image → theme default fallback
    $banner_url = has_post_thumbnail($page_id)
        ? get_the_post_thumbnail_url($page_id, 'full')
        : get_template_directory_uri() . '/images/frontpage/demo_image-28.jpg';
endwhile;
rewind_posts();
?>

<!-- ================================================================
     HERO BANNER
     1 h1 duy nhất per page — identical to page.php
     ================================================================ -->
<div class="axil-banner banner-style-1 bg_image page-banner"
    style="background-image: url('<?php echo esc_url($banner_url); ?>');" role="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner">
                    <h1 class="title">
                        <?php echo esc_html($page_title); ?>
                    </h1>
                    <?php if (!empty($page_excerpt)): ?>
                    <p class="description">
                        <?php echo esc_html($page_excerpt); ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ================================================================
     MAIN WRAPPER — 2 col: content col-lg-8 + sidebar col-lg-4
     ================================================================ -->
<div class="main-wrapper">
    <div class="axil-post-list-area axil-section-gap bg-color-white">
        <div class="container">
            <div class="row row--40">

                <!-- ── CONTENT col-lg-8 ──────────────────────────── -->
                <div class="col-lg-8 col-md-12 col-12 order-1 order-lg-1">

                    <?php while (have_posts()):
                        the_post(); ?>

                    <article id="page-<?php the_ID(); ?>" <?php post_class('page-article'); ?>>

                        <!-- Intro prose (admin writes via WP editor: "Say Hello!" + paragraphs) -->
                        <div class="single-post-content page-content entry-content">
                            <?php the_content(); ?>
                        </div>

                    </article>

                    <?php endwhile; ?>

                    <!-- ── CONTACT FORM SECTION ────────────────────
                         Render ngoài the_content() để admin không
                         vô tình xóa form khi edit intro text.
                         ─────────────────────────────────────────── -->
                    <section class="contact-form-section" aria-labelledby="contact-form-heading">

                        <h4 class="contact-form-section__title" id="contact-form-heading">
                            <?php esc_html_e('Send Us a Message', 'blogar'); ?>
                        </h4>
                        <p class="contact-form-section__subtitle">
                            <?php esc_html_e('Your email address will not be published. All the fields are required.', 'blogar'); ?>
                        </p>

                        <div class="axil-contact-form-area">
                            <div class="axil-contact-form contact-form--1 row">

                                <!-- Nếu CF7 được install: thay toàn bộ form tag bằng
                                     [contact-form-7 id="..." title="Contact form"]
                                     wrapped trong axil-contact-form-area.
                                     Template HTML này là fallback UI-only. -->

                                <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post"
                                    class="wpcf7-form contact-form-html"
                                    aria-label="<?php esc_attr_e('Contact form', 'blogar'); ?>" novalidate>

                                    <?php wp_nonce_field('blogar_contact_submit', 'blogar_contact_nonce'); ?>
                                    <input type="hidden" name="action" value="blogar_contact">

                                    <!-- Row 1: Name / Phone / Email -->
                                    <div class="cf-row">

                                        <div class="cf-col cf-col-3">
                                            <div class="form-group">
                                                <label for="contact-name">
                                                    <?php esc_html_e('Your Name', 'blogar'); ?>
                                                    <span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input type="text" id="contact-name" name="your-name"
                                                    class="wpcf7-form-control wpcf7-text" maxlength="400" required
                                                    aria-required="true"
                                                    placeholder="<?php esc_attr_e('John Doe', 'blogar'); ?>">
                                            </div>
                                        </div>

                                        <div class="cf-col cf-col-3">
                                            <div class="form-group">
                                                <label for="contact-phone">
                                                    <?php esc_html_e('Phone', 'blogar'); ?>
                                                </label>
                                                <input type="tel" id="contact-phone" name="phone"
                                                    class="wpcf7-form-control wpcf7-tel" maxlength="400"
                                                    placeholder="<?php esc_attr_e('+1 (555) 000-0000', 'blogar'); ?>">
                                            </div>
                                        </div>

                                        <div class="cf-col cf-col-3">
                                            <div class="form-group">
                                                <label for="contact-email">
                                                    <?php esc_html_e('Your Email', 'blogar'); ?>
                                                    <span class="required" aria-hidden="true">*</span>
                                                </label>
                                                <input type="email" id="contact-email" name="your-email"
                                                    class="wpcf7-form-control wpcf7-email" maxlength="400" required
                                                    aria-required="true"
                                                    placeholder="<?php esc_attr_e('you@example.com', 'blogar'); ?>">
                                            </div>
                                        </div>

                                    </div><!-- .cf-row -->

                                    <!-- Row 2: Message -->
                                    <div class="form-group">
                                        <label for="contact-message">
                                            <?php esc_html_e('Your Message', 'blogar'); ?>
                                            <span class="required" aria-hidden="true">*</span>
                                        </label>
                                        <textarea id="contact-message" name="your-message"
                                            class="wpcf7-form-control wpcf7-textarea" rows="5" maxlength="2000" required
                                            aria-required="true"
                                            placeholder="<?php esc_attr_e('Write your message here…', 'blogar'); ?>"></textarea>
                                    </div>

                                    <!-- Submit -->
                                    <div class="form-submit">
                                        <button type="submit" class="axil-button button-rounded btn-primary">
                                            <span>
                                                <?php esc_html_e('Submit', 'blogar'); ?>
                                            </span>
                                        </button>
                                    </div>

                                </form>

                            </div><!-- .axil-contact-form -->
                        </div><!-- .axil-contact-form-area -->

                    </section><!-- .contact-form-section -->

                </div><!-- .col-lg-8 -->


                <!-- ── SIDEBAR col-lg-4 ──────────────────────────── -->
                <!-- Identical to page.php sidebar: 4 widgets only. -->
                <aside class="col-lg-4 col-md-12 col-12 order-2 order-lg-2
                              single-sidebar archive-sidebar page-sidebar"
                    aria-label="<?php esc_attr_e('Sidebar', 'blogar'); ?>">

                    <div class="single-sidebar-sticky">

                        <!-- ① Search -->
                        <div class="search-2 axil-single-widget widget_search">
                            <h5 class="widget-title">
                                <?php esc_html_e('Search', 'blogar'); ?>
                            </h5>
                            <div class="inner">
                                <form action="<?php echo esc_url(home_url('/')); ?>" method="GET" role="search"
                                    class="blog-search">
                                    <div class="axil-search form-group">
                                        <button type="submit" class="search-button"
                                            aria-label="<?php esc_attr_e('Search', 'blogar'); ?>">
                                            <?php echo $svg_search; // phpcs:ignore ?>
                                        </button>
                                        <input type="search" name="s"
                                            placeholder="<?php echo esc_attr__('Search ...', 'blogar'); ?>"
                                            value="<?php echo esc_attr(get_search_query()); ?>">
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- ② Recent Posts -->
                        <div class="blogar_recent_post-1 axil-single-widget widget_blogar_recent_post mt--30">
                            <h5 class="widget-title">
                                <?php esc_html_e('Recent on Blogar', 'blogar'); ?>
                            </h5>
                            <?php
                            $recent_posts = get_posts(array(
                                'numberposts' => 3,
                                'post_status' => 'publish',
                            ));
                            foreach ($recent_posts as $rp): ?>
                            <div class="content-block post-medium mb--20">
                                <div class="post-thumbnail">
                                    <a href="<?php echo esc_url(get_permalink($rp->ID)); ?>">
                                        <img loading="lazy" decoding="async" width="150" height="150"
                                            src="<?php echo esc_url(blogar_thumbnail_url($rp->ID, 'blogar-thumb')); ?>"
                                            alt="<?php echo esc_attr(blogar_thumbnail_alt($rp->ID)); ?>">
                                    </a>
                                </div>
                                <div class="post-content">
                                    <h6 class="title">
                                        <a href="<?php echo esc_url(get_permalink($rp->ID)); ?>">
                                            <?php echo esc_html(wp_trim_words($rp->post_title, 8)); ?>
                                        </a>
                                    </h6>
                                    <div class="post-meta">
                                        <ul class="post-meta-list">
                                            <li>
                                                <?php echo esc_html(get_the_date('', $rp->ID)); ?>
                                            </li>
                                            <li>
                                                <?php echo esc_html(blogar_reading_time($rp->ID)); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;
                            wp_reset_postdata(); ?>
                        </div>

                        <!-- ③ Newsletter -->
                        <div class="axil-single-widget widget_mc4wp_form_widget mt--30">
                            <div class="newsletter-inner text-center">
                                <h4 class="title mb--15">
                                    <?php esc_html_e('Never Miss A Post!', 'blogar'); ?>
                                </h4>
                                <p class="b2 mb--30">
                                    <?php esc_html_e('Sign up for free and be the first to get notified about updates.', 'blogar'); ?>
                                </p>
                                <form class="archive-newsletter-form">
                                    <div class="form-group">
                                        <input type="email" name="EMAIL"
                                            placeholder="<?php esc_attr_e('Your email address', 'blogar'); ?>" required>
                                    </div>
                                    <div class="form-submit">
                                        <button type="submit" class="axil-button button-rounded cerchio">
                                            <span>
                                                <?php esc_html_e('Subscribe', 'blogar'); ?>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- ④ Stay In Touch (social) -->
                        <div class="blogar_social_widget-1 axil-single-widget mt--30">
                            <h5 class="widget-title">
                                <?php esc_html_e('Stay In Touch', 'blogar'); ?>
                            </h5>
                            <ul class="social-icon md-size justify-content-center">
                                <li><a href="#" aria-label="Facebook">
                                        <?php echo $svg_fb; // phpcs:ignore ?>
                                    </a></li>
                                <li><a href="#" aria-label="Twitter">
                                        <?php echo $svg_tw; // phpcs:ignore ?>
                                    </a></li>
                                <li><a href="#" aria-label="Instagram">
                                        <?php echo $svg_ig; // phpcs:ignore ?>
                                    </a></li>
                                <li><a href="#" aria-label="Pinterest">
                                        <?php echo $svg_pi; // phpcs:ignore ?>
                                    </a></li>
                                <li><a href="#" aria-label="LinkedIn">
                                        <?php echo $svg_li; // phpcs:ignore ?>
                                    </a></li>
                            </ul>
                        </div>

                    </div><!-- .single-sidebar-sticky -->
                </aside><!-- .page-sidebar -->

            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .axil-post-list-area -->
</div><!-- .main-wrapper -->

<?php get_footer(); ?>