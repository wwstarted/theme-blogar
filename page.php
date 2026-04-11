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
                <?php get_template_part('template-parts/sidebar', null, array('extra_class' => 'page-sidebar')); ?>

            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .axil-post-list-area -->
</div><!-- .main-wrapper -->

<?php get_footer(); ?>
