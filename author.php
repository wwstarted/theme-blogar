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
 * UI   : Clone 100% từ archive.php.
 *        Điểm khác duy nhất: thêm author info block (avatar + bio)
 *        bên trong breadcrumb area, ngay sau breadcrumb nav.
 *
 * Link nguồn: single.php → "View All Posts" → get_author_posts_url() → author.php
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// ── Inline SVG icons (reuse bộ giống archive.php / single.php) ─────
$svg_fb = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>';
$svg_tw = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>';
$svg_li = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>';
$svg_ig = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5" fill="none" stroke="currentColor" stroke-width="2"/><path fill="none" stroke="currentColor" stroke-width="2" d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>';
$svg_pi = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12c0 4.24 2.65 7.86 6.39 9.29-.09-.78-.17-1.98.04-2.83.18-.77 1.22-5.17 1.22-5.17s-.31-.63-.31-1.56c0-1.46.85-2.55 1.9-2.55.9 0 1.33.67 1.33 1.48 0 .9-.58 2.26-.87 3.52-.25 1.05.52 1.9 1.55 1.9 1.86 0 3.3-1.96 3.3-4.8 0-2.51-1.8-4.26-4.38-4.26-2.98 0-4.73 2.23-4.73 4.54 0 .9.35 1.86.78 2.39.09.1.1.19.07.29-.08.33-.26 1.05-.29 1.19-.05.19-.16.23-.37.14-1.39-.65-2.26-2.68-2.26-4.32 0-3.51 2.55-6.74 7.35-6.74 3.86 0 6.86 2.75 6.86 6.42 0 3.83-2.41 6.9-5.76 6.9-1.13 0-2.19-.59-2.55-1.28l-.69 2.59c-.25.96-.93 2.17-1.38 2.9.04.01.08.01.12.01.96.29 1.97.45 3.02.45 5.52 0 10-4.48 10-10S17.52 2 12 2z"/></svg>';
$svg_search = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>';

// ── Author data ─────────────────────────────────────────────────────
$author_id = (int) get_queried_object_id();
$author_name = get_the_author_meta('display_name', $author_id);
$author_bio = get_the_author_meta('description', $author_id);
$author_avatar = get_avatar_url($author_id, array('size' => 96));
$author_url = get_author_posts_url($author_id);
$post_count = (int) count_user_posts($author_id, 'post');

// ── Image base ─────────────────────────────────────────────────────
$img = get_template_directory_uri() . '/images/frontpage/';
?>

<!-- ================================================================
     BREADCRUMB + AUTHOR INFO AREA
     SEO: h1 nằm ở đây — 1 h1 duy nhất per page.
     Clone từ archive.php breadcrumb, bổ sung author info block.
     ================================================================ -->
<div class="axil-breadcrumb-area breadcrumb-style-1 bg-color-grey">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner">

                    <!-- Breadcrumb nav — giống archive.php -->
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

                    <!-- h1 — ONE per page, giống pattern archive.php -->
                    <h1 class="page-title">
                        <?php
                        printf(
                            /* translators: %s: author display name */
                            wp_kses(__('Author: <span>%s</span>', 'blogar'), array('span' => array())),
                            esc_html($author_name)
                        );
                        ?>
                    </h1>

                </div>
            </div>
        </div>

        <!-- ── AUTHOR INFO BLOCK ──────────────────────────────────────────
             Chỉ có ở author.php — nằm trong cùng breadcrumb area.
             Clone style từ single.php .single-author-box nhưng layout ngang.
             ─────────────────────────────────────────────────────────── -->
        <div class="row">
            <div class="col-lg-12">
                <div class="author-info-block">

                    <!-- Avatar -->
                    <div class="author-info-avatar">
                        <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>"
                            width="96" height="96" loading="eager" decoding="async">
                    </div>

                    <!-- Meta -->
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
                                /* translators: %d: number of posts */
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
     BLOG AREA — CLONE 100% TỪ ARCHIVE.PHP
     Không thay đổi bất cứ class / structure / spacing nào.
     WordPress tự handle author query qua $wp_query.
     ================================================================ -->
<div class="main-wrapper">
    <div class="axil-blog-area axil-section-gap bg-color-white">
        <div class="container">
            <div class="row row--40">

                <!-- ── POST LIST COL — clone từ archive.php ──────────── -->
                <div class="col-lg-8 col-md-12 col-12 order-1 order-lg-2">

                    <?php if (have_posts()): ?>

                    <?php while (have_posts()):
                            the_post(); ?>

                    <!-- Post card: giống 100% archive.php -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class('content-block post-list-view mt--30'); ?>>

                        <!-- Thumbnail -->
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <img loading="lazy" decoding="async" width="295" height="250"
                                    src="<?php echo esc_url(blogar_thumbnail_url(get_the_ID(), 'blogar-list')); ?>"
                                    alt="<?php echo esc_attr(blogar_thumbnail_alt(get_the_ID())); ?>">
                            </a>
                        </div>

                        <!-- Post content -->
                        <div class="post-content">

                            <!-- Categories -->
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

                            <!-- Title: h2 theo hierarchy (h1 đã dùng cho author name) -->
                            <h2 class="title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <?php if (has_excerpt() || get_the_excerpt()): ?>
                            <p class="post-description">
                                <?php echo esc_html(wp_strip_all_tags(get_the_excerpt())); ?>
                            </p>
                            <?php endif; ?>

                            <!-- Meta row — giống archive.php, không có avatar -->
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

                                <!-- Social share — giống archive.php -->
                                <ul class="social-share-transparent justify-content-end">
                                    <li>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode(get_permalink()); ?>"
                                            target="_blank" rel="noopener noreferrer" class="aw-facebook"
                                            aria-label="<?php esc_attr_e('Share on Facebook', 'blogar'); ?>">
                                            <?php echo $svg_fb; // phpcs:ignore ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/share?url=<?php echo rawurlencode(get_permalink()); ?>&amp;text=<?php echo rawurlencode(get_the_title()); ?>"
                                            target="_blank" rel="noopener noreferrer" class="aw-twitter"
                                            aria-label="<?php esc_attr_e('Share on Twitter', 'blogar'); ?>">
                                            <?php echo $svg_tw; // phpcs:ignore ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/shareArticle?url=<?php echo rawurlencode(get_permalink()); ?>&amp;title=<?php echo rawurlencode(get_the_title()); ?>"
                                            target="_blank" rel="noopener noreferrer" class="aw-linkdin"
                                            aria-label="<?php esc_attr_e('Share on LinkedIn', 'blogar'); ?>">
                                            <?php echo $svg_li; // phpcs:ignore ?>
                                        </a>
                                    </li>
                                    <li>
                                        <button class="axilcopyLink" title="<?php esc_attr_e('Copy Link', 'blogar'); ?>"
                                            data-link="<?php echo esc_attr(get_permalink()); ?>"
                                            aria-label="<?php esc_attr_e('Copy link', 'blogar'); ?>">
                                            <?php
                                                    // svg_lk — inline copy-link icon
                                                    echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>'; // phpcs:ignore
                                                    ?>
                                        </button>
                                    </li>
                                </ul>
                            </div><!-- .post-meta-wrapper -->

                        </div><!-- .post-content -->
                    </article>

                    <?php endwhile; ?>

                    <!-- Ad banner sau post list — giống archive.php -->
                    <div class="ads-container mt--30">
                        <a class="after-content-ad-color" href="<?php echo esc_url(home_url('/')); ?>">
                            <img loading="lazy" src="<?php echo esc_url($img . 'banner-03.png'); ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        </a>
                    </div>

                    <!-- Pagination — giống archive.php -->
                    <?php
                        the_posts_pagination(array(
                            'mid_size' => 2,
                            'prev_text' => __('&larr; Previous', 'blogar'),
                            'next_text' => __('Next &rarr;', 'blogar'),
                            'class' => 'axil-pagination mt--30',
                        ));
                        ?>

                    <?php else: ?>

                    <!-- Fallback: không có bài viết -->
                    <div class="no-posts-found mt--30">
                        <div class="no-posts-inner">
                            <p class="no-posts-message">
                                <?php
                                    printf(
                                        /* translators: %s: author display name */
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


                <!-- ── SIDEBAR — clone 100% từ archive.php ────────────── -->
                <aside class="col-lg-4 col-md-12 col-12 order-2 order-lg-2 archive-sidebar"
                    aria-label="<?php esc_attr_e('Sidebar', 'blogar'); ?>">

                    <!-- ① Search -->
                    <div class="search-1 axil-single-widget widget_search mt--30">
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

                    <!-- ② Recent Post -->
                    <div class="blogar_recent_post-1 axil-single-widget widget_blogar_recent_post mt--30">
                        <h5 class="widget-title">
                            <?php esc_html_e('Recent Post', 'blogar'); ?>
                        </h5>
                        <?php
                        $recent_posts = get_posts(array(
                            'numberposts' => 3,
                            'post_status' => 'publish',
                        ));
                        foreach ($recent_posts as $rp):
                            ?>
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

                    <!-- ④ Stay In Touch -->
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

                    <!-- ⑤ Gallery -->
                    <div class="media_gallery-1 axil-single-widget widget_media_gallery mt--30">
                        <h5 class="widget-title">
                            <?php esc_html_e('Gallery', 'blogar'); ?>
                        </h5>
                        <?php
                        $gallery_posts = get_posts(array(
                            'numberposts' => 6,
                            'post_status' => 'publish',
                            'meta_key' => '_thumbnail_id',
                        ));
                        if ($gallery_posts):
                            ?>
                        <div class="gallery gallery-columns-3">
                            <?php foreach ($gallery_posts as $gp): ?>
                            <figure class="gallery-item">
                                <div class="gallery-icon">
                                    <a href="<?php echo esc_url(get_permalink($gp->ID)); ?>">
                                        <img loading="lazy" decoding="async" width="150" height="150"
                                            src="<?php echo esc_url(get_the_post_thumbnail_url($gp->ID, 'thumbnail')); ?>"
                                            alt="<?php echo esc_attr($gp->post_title); ?>">
                                    </a>
                                </div>
                            </figure>
                            <?php endforeach;
                                wp_reset_postdata(); ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- ⑥ Featured Videos -->
                    <div class="blogar_featured_posts-1 axil-single-widget widget_blogar_featured_posts mt--30">
                        <h5 class="widget-title">
                            <?php esc_html_e('Featured Videos', 'blogar'); ?>
                        </h5>
                        <?php
                        $featured_posts = get_posts(array(
                            'numberposts' => 2,
                            'post_status' => 'publish',
                            'meta_key' => '_thumbnail_id',
                            'offset' => 3,
                        ));
                        foreach ($featured_posts as $fp):
                            $fp_thumb = get_the_post_thumbnail_url($fp->ID, 'blogar-card');
                            ?>
                        <div class="content-block image-rounded mt--20">
                            <?php if ($fp_thumb): ?>
                            <div class="post-thumbnail">
                                <a href="<?php echo esc_url(get_permalink($fp->ID)); ?>">
                                    <img loading="lazy" decoding="async" width="390" height="260"
                                        src="<?php echo esc_url($fp_thumb); ?>"
                                        alt="<?php echo esc_attr($fp->post_title); ?>">
                                </a>
                            </div>
                            <?php endif; ?>
                            <h6 class="title mt--10">
                                <a href="<?php echo esc_url(get_permalink($fp->ID)); ?>">
                                    <?php echo esc_html(wp_trim_words($fp->post_title, 8)); ?>
                                </a>
                            </h6>
                        </div>
                        <?php endforeach;
                        wp_reset_postdata(); ?>
                    </div>

                    <!-- ⑦ All Tags -->
                    <div class="tag_cloud-1 axil-single-widget widget_tag_cloud mt--30">
                        <h5 class="widget-title">
                            <?php esc_html_e('All Tags', 'blogar'); ?>
                        </h5>
                        <div class="tagcloud">
                            <?php wp_tag_cloud(array(
                                'smallest' => 8,
                                'largest' => 14,
                                'unit' => 'pt',
                                'number' => 10,
                                'format' => 'flat',
                            )); ?>
                        </div>
                    </div>

                    <!-- ⑧ Ad banner -->
                    <div class="media_image-1 axil-single-widget widget_media_image mt--30">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img loading="lazy" decoding="async" src="<?php echo esc_url($img . 'banner-03.png'); ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>" style="max-width:100%;height:auto;">
                        </a>
                    </div>

                </aside><!-- .archive-sidebar -->

            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .axil-blog-area -->
</div><!-- .main-wrapper -->

<?php get_footer(); ?>