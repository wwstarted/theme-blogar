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
 * Sidebar v3:
 *  - Đồng bộ với archive.php: Popular Posts / Categories / Subscribe Newsletter.
 *  - Wrapper đổi từ .single-sidebar-sticky → .archive-sidebar-inner.
 *
 * SEO heading hierarchy:
 *  h1 → page title (hero banner)
 *  h2 → page content / contact form / sidebar groups
 *  h3 → sidebar widget titles
 *  h4 → sidebar popular post titles
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// ── Hero banner setup (run before output) ────────────────────────
while (have_posts()):
    the_post();
    $page_id = get_the_ID();
    $page_title = get_the_title();
    $page_excerpt = has_excerpt() ? get_the_excerpt() : '';

    $banner_url = has_post_thumbnail($page_id)
        ? get_the_post_thumbnail_url($page_id, 'full')
        : get_template_directory_uri() . '/images/frontpage/demo_image-28.jpg';
endwhile;
rewind_posts();
?>

<!-- ================================================================
     HERO BANNER — identical to page.php
     ================================================================ -->
<div class="axil-banner banner-style-1 bg_image page-banner"
    style="background-image: url('<?php echo esc_url($banner_url); ?>');" role="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner">
                    <h1 class="title"><?php echo esc_html($page_title); ?></h1>
                    <?php if (!empty($page_excerpt)): ?>
                    <p class="description"><?php echo esc_html($page_excerpt); ?></p>
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
                        <div class="blogar-visually-hidden">
                            <h2><?php esc_html_e('Page content', 'blogar'); ?></h2>
                        </div>

                        <!-- Intro prose (admin viết via WP editor) -->
                        <div class="single-post-content page-content entry-content">
                            <?php the_content(); ?>
                        </div>

                    </article>

                    <?php endwhile; ?>

                    <!-- ── CONTACT FORM SECTION ──────────────────── -->
                    <section class="contact-form-section" aria-labelledby="contact-form-heading">

                        <!--
                            SEO FIX: đổi h4 → h2.
                            "Send Us a Message" là section title chính sau h1 banner.
                            the_content() intro có thể không chứa heading nào,
                            nên h4 trực tiếp sau h1 skip h2/h3 — vi phạm hierarchy.
                            CSS dùng class .contact-form-section__title → layout không đổi.
                        -->
                        <h2 class="contact-form-section__title" id="contact-form-heading">
                            <?php esc_html_e('Send Us a Message', 'blogar'); ?>
                        </h2>
                        <p class="contact-form-section__subtitle">
                            <?php esc_html_e('Your email address will not be published. All the fields are required.', 'blogar'); ?>
                        </p>

                        <div class="axil-contact-form-area">
                            <div class="axil-contact-form contact-form--1 row">

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
                                            <span><?php esc_html_e('Submit', 'blogar'); ?></span>
                                        </button>
                                    </div>

                                </form>

                            </div><!-- .axil-contact-form -->
                        </div><!-- .axil-contact-form-area -->

                    </section><!-- .contact-form-section -->

                </div><!-- .col-lg-8 -->


                <!-- ── SIDEBAR col-lg-4 ──────────────────────────── -->
                <aside class="col-lg-4 col-md-12 col-12 order-2 order-lg-2
                              archive-sidebar page-sidebar" aria-label="<?php esc_attr_e('Sidebar', 'blogar'); ?>">

                    <div class="archive-sidebar-inner">
                        <!-- ① Popular Posts -->
                        <div class="blogar-widget widget-popular-posts mt--30">
                            <h2 class="widget-title"><?php esc_html_e('Popular Posts', 'blogar'); ?></h2>
                            <?php
                            $popular_posts = get_posts(array(
                                'numberposts' => 5,
                                'post_status' => 'publish',
                                'orderby' => 'comment_count',
                                'order' => 'DESC',
                                'ignore_sticky_posts' => true,
                            ));
                            foreach ($popular_posts as $pp):
                                $pp_url = get_permalink($pp->ID);
                                $pp_thumb = blogar_thumbnail_url($pp->ID, 'blogar-thumb');
                                $pp_alt = blogar_thumbnail_alt($pp->ID);
                                $pp_title = wp_trim_words($pp->post_title, 9, '...');
                                ?>
                            <div class="popular-post-item">
                                <div class="popular-post-inner">
                                    <div class="popular-post-thumb">
                                        <a href="<?php echo esc_url($pp_url); ?>">
                                            <img loading="lazy" decoding="async" width="110" height="83"
                                                src="<?php echo esc_url($pp_thumb); ?>"
                                                alt="<?php echo esc_attr($pp_alt); ?>">
                                        </a>
                                    </div>
                                    <div class="popular-post-text">
                                        <h3 class="popular-post-title">
                                            <a
                                                href="<?php echo esc_url($pp_url); ?>"><?php echo esc_html($pp_title); ?></a>
                                        </h3>
                                        <div class="popular-post-meta">
                                            <time datetime="<?php echo esc_attr(get_the_date('c', $pp->ID)); ?>">
                                                <?php echo esc_html(get_the_date('', $pp->ID)); ?>
                                            </time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;
                            wp_reset_postdata(); ?>
                        </div>

                        <!-- ② Categories -->
                        <div class="blogar-widget widget-sidebar-cats mt--30">
                            <h2 class="widget-title"><?php esc_html_e('Categories', 'blogar'); ?></h2>
                            <?php
                            $sidebar_cats = get_categories(array(
                                'hide_empty' => true,
                                'orderby' => 'count',
                                'order' => 'DESC',
                                'number' => 10,
                            ));
                            if ($sidebar_cats):
                                ?>
                            <ul class="sidebar-cat-list">
                                <?php foreach ($sidebar_cats as $sc): ?>
                                <li>
                                    <a href="<?php echo esc_url(get_category_link($sc->term_id)); ?>">
                                        <?php echo esc_html($sc->name); ?>
                                    </a>
                                    <span class="sidebar-cat-count"><?php echo (int) $sc->count; ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </div>

                        <!-- ③ Subscribe Newsletter -->
                        <div class="blogar-widget widget-sidebar-newsletter mt--30">
                            <h2 class="widget-title"><?php esc_html_e('Subscribe Newsletter', 'blogar'); ?></h2>
                            <div class="sidebar-newsletter-inner">
                                <p class="sidebar-newsletter-desc">
                                    <?php esc_html_e('Subscribe our newsletter for latest news &amp; updates. Let\'s stay updated!', 'blogar'); ?>
                                </p>
                                <form class="sidebar-newsletter-form" action="#" method="post">
                                    <div class="form-group">
                                        <input type="text" name="FNAME"
                                            placeholder="<?php esc_attr_e('Your name...', 'blogar'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="EMAIL"
                                            placeholder="<?php esc_attr_e('Your email...', 'blogar'); ?>" required>
                                    </div>
                                    <div class="form-submit">
                                        <button type="submit" class="sidebar-newsletter-btn">
                                            <?php esc_html_e('Subscribe', 'blogar'); ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                </aside>

            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .axil-post-list-area -->
</div><!-- .main-wrapper -->

<?php get_footer(); ?>
