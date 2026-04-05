<?php
/**
 * page.php — Blogar Theme
 *
 * Template: WordPress CMS Page (About Us, Privacy Policy, Terms, Contact…)
 *
 * SEO  : Exactly 1 <h1> per page — the page title inside the hero banner.
 * Data : WordPress loop; the_title() + the_content() + get_the_excerpt().
 * CSS  : archive.css (sidebar/shared) + single.css (content prose) + page.css (banner).
 *
 * Sidebar v3:
 *  - Đồng bộ với archive.php: Popular Posts / Categories / Subscribe Newsletter.
 *  - Wrapper đổi từ .single-sidebar-sticky → .archive-sidebar-inner (sticky xử lý bởi archive.css).
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$img = get_template_directory_uri() . '/images/frontpage/';

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
     h1 sống ở đây — duy nhất 1 h1 per page.
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

                <!-- ── PAGE CONTENT col-lg-8 ─────────────────────── -->
                <div class="col-lg-8 col-md-12 col-12 order-1 order-lg-1">

                    <?php while (have_posts()):
                        the_post(); ?>

                    <article id="page-<?php the_ID(); ?>" <?php post_class('page-article'); ?>>
                        <div class="blogar-visually-hidden">
                            <h2><?php esc_html_e('Page content', 'blogar'); ?></h2>
                        </div>

                        <!-- Page prose content -->
                        <div class="single-post-content page-content entry-content">
                            <?php the_content(); ?>
                        </div>

                        <!-- WordPress multi-page pagination (<!--nextpage-->) -->
                        <?php wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'blogar'),
                                'after' => '</div>',
                                'link_before' => '<span class="page-link-item">',
                                'link_after' => '</span>',
                            )); ?>

                    </article>

                    <?php endwhile; ?>

                </div><!-- .col-lg-8 -->


                <!-- ── SIDEBAR col-lg-4 ──────────────────────────── -->
                <!-- Sidebar đồng bộ với archive.php: 3 widgets chuẩn.
                     Wrapper .archive-sidebar-inner xử lý sticky qua archive.css. -->
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

                    </div><!-- .archive-sidebar-inner -->

                </aside><!-- .page-sidebar -->

            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .axil-post-list-area -->
</div><!-- .main-wrapper -->

<?php get_footer(); ?>
