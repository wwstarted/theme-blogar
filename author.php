<?php
/**
 * author.php — Blogar Theme
 *
 * Template: Author archive page — hiển thị tất cả bài viết của một author.
 *
 * SEO  : Đúng 1 <h1> per page — author name trong breadcrumb area.
 * Data : WordPress default author query (have_posts() / the_post()).
 * CSS  : archive.css (reuse toàn bộ) + author.css (chỉ author info block).
 * JS   : frontpage.js (copy-link) — reuse, không thêm mới.
 *
 * Sidebar v2:
 *  - Đồng bộ với archive.php: Popular Posts / Categories / Subscribe Newsletter.
 *  - Bỏ 8 widgets cũ (Search, Recent, Newsletter, Social, Gallery, Videos, Tags, Ad).
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// ── Inline SVG icons ─────────────────────────────────────────────
$svg_fb = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>';
$svg_tw = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>';
$svg_li = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>';

// ── Author data ──────────────────────────────────────────────────
$author_id = (int) get_queried_object_id();
$author_name = get_the_author_meta('display_name', $author_id);
$author_bio = get_the_author_meta('description', $author_id);
$author_avatar = get_avatar_url($author_id, array('size' => 96));
$author_url = get_author_posts_url($author_id);
$post_count = (int) count_user_posts($author_id, 'post');

$img = get_template_directory_uri() . '/images/frontpage/';
?>

<!-- ================================================================
     BREADCRUMB + AUTHOR INFO AREA
     SEO: h1 nằm ở đây — 1 h1 duy nhất per page.
     ================================================================ -->
<div class="axil-breadcrumb-area breadcrumb-style-1 bg-color-grey">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner">

                    <nav aria-label="<?php esc_attr_e('Breadcrumb', 'blogar'); ?>">
                        <ul class="axil-breadcrumb liststyle">
                            <li class="item-home">
                                <a class="bread-link bread-home" href="<?php echo esc_url(home_url('/')); ?>">
                                    <?php esc_html_e('Home', 'blogar'); ?>
                                </a>
                            </li>
                            <li class="separator separator-home" aria-hidden="true">&nbsp;</li>
                            <li class="item-current item-author" aria-current="page">
                                <span class="bread-current bread-author">
                                    <?php echo esc_html($author_name); ?>
                                </span>
                            </li>
                        </ul>
                    </nav>

                    <h1 class="page-title">
                        <?php
                        printf(
                            wp_kses(__('Author: <span>%s</span>', 'blogar'), array('span' => array())),
                            esc_html($author_name)
                        );
                        ?>
                    </h1>

                </div>
            </div>
        </div>

        <!-- ── AUTHOR INFO BLOCK ──────────────────────────────── -->
        <div class="row">
            <div class="col-lg-12">
                <div class="author-info-block">

                    <div class="author-info-avatar">
                        <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>"
                            width="96" height="96" loading="eager" decoding="async">
                    </div>

                    <div class="author-info-meta">
                        <span class="author-info-label">
                            <?php esc_html_e('Written By', 'blogar'); ?>
                        </span>

                        <h2 class="author-info-name">
                            <?php echo esc_html($author_name); ?>
                        </h2>

                        <?php if (!empty(trim($author_bio))): ?>
                        <p class="author-info-bio">
                            <?php echo esc_html($author_bio); ?>
                        </p>
                        <?php endif; ?>

                        <span class="author-info-count">
                            <?php
                            printf(
                                esc_html(_n('%d Post', '%d Posts', $post_count, 'blogar')),
                                (int) $post_count
                            );
                            ?>
                        </span>
                    </div>

                </div><!-- .author-info-block -->
            </div>
        </div>

    </div><!-- .container -->
</div>
<!-- End Breadcrumb + Author Info Area -->


<!-- ================================================================
     BLOG AREA — clone từ archive.php
     ================================================================ -->
<div class="main-wrapper">
    <div class="axil-blog-area axil-section-gap bg-color-white">
        <div class="container">
            <div class="row row--40">

                <!-- ── POST LIST COL ──────────────────────────────── -->
                <div class="col-lg-8 col-md-12 col-12 order-1 order-lg-2">

                    <?php if (have_posts()): ?>

                    <?php while (have_posts()):
                            the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('content-block post-list-view mt--30'); ?>>

                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <img loading="lazy" decoding="async" width="295" height="221"
                                    src="<?php echo esc_url(blogar_thumbnail_url(get_the_ID(), 'blogar-list')); ?>"
                                    alt="<?php echo esc_attr(blogar_thumbnail_alt(get_the_ID())); ?>">
                            </a>
                        </div>

                        <div class="post-content">

                            <?php $cats = get_the_category();
                                    if ($cats): ?>
                            <div class="post-cat">
                                <div class="post-cat-list">
                                    <?php foreach ($cats as $cat): ?>
                                    <a class="hover-flip-item-wrapper"
                                        href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
                                        <span class="hover-flip-item">
                                            <span data-text="<?php echo esc_attr($cat->name); ?>">
                                                <?php echo esc_html($cat->name); ?>
                                            </span>
                                        </span>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <h2 class="title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <?php if (has_excerpt() || get_the_excerpt()): ?>
                            <p class="post-description">
                                <?php echo esc_html(wp_strip_all_tags(get_the_excerpt())); ?>
                            </p>
                            <?php endif; ?>

                            <div class="post-meta-wrapper">
                                <div class="post-meta">
                                    <div class="content">
                                        <h6 class="post-author-name">
                                            <a class="hover-flip-item-wrapper"
                                                href="<?php echo esc_url($author_url); ?>">
                                                <span class="hover-flip-item">
                                                    <span data-text="<?php echo esc_attr($author_name); ?>">
                                                        <?php echo esc_html($author_name); ?>
                                                    </span>
                                                </span>
                                            </a>
                                        </h6>
                                        <ul class="post-meta-list">
                                            <li class="post-meta-date">
                                                <?php echo esc_html(get_the_date()); ?>
                                            </li>
                                            <li class="post-meta-reading-time">
                                                <?php echo esc_html(blogar_reading_time(get_the_ID())); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- .post-meta-wrapper -->

                        </div><!-- .post-content -->
                    </article>

                    <?php endwhile; ?>

                    <div class="ads-container mt--30">
                        <a class="after-content-ad-color" href="<?php echo esc_url(home_url('/')); ?>">
                            <img loading="lazy" src="<?php echo esc_url($img . 'banner-03.png'); ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        </a>
                    </div>

                    <?php
                        the_posts_pagination(array(
                            'mid_size' => 2,
                            'prev_text' => __('&larr; Previous', 'blogar'),
                            'next_text' => __('Next &rarr;', 'blogar'),
                            'class' => 'axil-pagination mt--30',
                        ));
                        ?>

                    <?php else: ?>

                    <div class="no-posts-found mt--30">
                        <div class="no-posts-inner">
                            <p class="no-posts-message">
                                <?php
                                    printf(
                                        esc_html__('No posts found for %s yet.', 'blogar'),
                                        '<strong>' . esc_html($author_name) . '</strong>'
                                    );
                                    ?>
                            </p>
                            <a class="axil-button button-rounded cerchio" href="<?php echo esc_url(home_url('/')); ?>">
                                <?php esc_html_e('Back to Home', 'blogar'); ?>
                            </a>
                        </div>
                    </div>

                    <?php endif; ?>

                </div><!-- .col-lg-8 -->


                <!-- ── SIDEBAR ─────────────────────────────────────── -->
                <!-- Đồng bộ với archive.php: 3 widgets chuẩn. -->
                <aside class="col-lg-4 col-md-12 col-12 order-2 order-lg-2 archive-sidebar"
                    aria-label="<?php esc_attr_e('Sidebar', 'blogar'); ?>">

                    <div class="archive-sidebar-inner">

                        <!-- ① Popular Posts -->
                        <div class="blogar-widget widget-popular-posts mt--30">
                            <h5 class="widget-title"><?php esc_html_e('Popular Posts', 'blogar'); ?></h5>
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
                                        <h6 class="popular-post-title">
                                            <a
                                                href="<?php echo esc_url($pp_url); ?>"><?php echo esc_html($pp_title); ?></a>
                                        </h6>
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
                            <h5 class="widget-title"><?php esc_html_e('Categories', 'blogar'); ?></h5>
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
                            <h5 class="widget-title"><?php esc_html_e('Subscribe Newsletter', 'blogar'); ?></h5>
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

                </aside><!-- .archive-sidebar -->

            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .axil-blog-area -->
</div><!-- .main-wrapper -->

<?php get_footer(); ?>