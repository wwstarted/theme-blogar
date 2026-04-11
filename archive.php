<?php
/**
 * archive.php — Blogar Theme
 *
 * Layout được điều khiển bởi option: Appearance > Blogar Settings > Archive Page Layout
 *   'sidebar' (mặc định) → col-8 content + col-4 sticky sidebar
 *   'full'               → col-12 full-width, 2-col card grid, không sidebar
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// ── Inline SVG icons ───────────────────────────────────────────────
$svg_fb = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>';
$svg_tw = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>';
$svg_li = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>';
$svg_lk = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>';

// ── Read layout option ─────────────────────────────────────────────
// 'sidebar' = with sidebar (default), 'full' = full-width 2-col grid
$archive_layout = get_option('blogar_archive_layout', 'sidebar');
$is_full = ('full' === $archive_layout);

// ── Queried object / page title ────────────────────────────────────
$page_title = '';

if (is_category()) {
    $page_title = sprintf(
        /* translators: %s: category name */
        __('Category: <span>%s</span>', 'blogar'),
        single_cat_title('', false)
    );
} elseif (is_tag()) {
    $page_title = sprintf(
        /* translators: %s: tag name */
        __('Tag: <span>%s</span>', 'blogar'),
        single_tag_title('', false)
    );
} elseif (is_author()) {
    $page_title = sprintf(
        /* translators: %s: author display name */
        __('Author: <span>%s</span>', 'blogar'),
        esc_html(get_the_author_meta('display_name', get_queried_object_id()))
    );
} elseif (is_date()) {
    $page_title = sprintf(
        /* translators: %s: date string */
        __('Archives: <span>%s</span>', 'blogar'),
        get_the_date('F Y')
    );
} else {
    $page_title = __('Blog', 'blogar');
}

// ── Archive description + post count ──────────────────────────────
$archive_desc = '';
$archive_count = '';

if (is_category() || is_tag()) {
    $term = get_queried_object();
    $term_desc = term_description();
    if (!empty(trim(strip_tags($term_desc)))) {
        $archive_desc = $term_desc; // already wpautop'd + kses'd by WP
    }
    if ($term && isset($term->count)) {
        $cnt = (int) $term->count;
        $archive_count = sprintf(
            /* translators: %s: formatted post count */
            _n('%s article', '%s articles', $cnt, 'blogar'),
            number_format_i18n($cnt)
        );
    }
} elseif (is_author()) {
    $bio = get_the_author_meta('description', get_queried_object_id());
    if (!empty(trim($bio))) {
        $archive_desc = wpautop(wp_kses_post($bio));
    }
}

$img = get_template_directory_uri() . '/images/frontpage/';
?>

<!-- ================================================================
     BREADCRUMB — h1 sống ở đây, duy nhất 1 h1/page.
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
                            <li class="item-current item-cat" aria-current="page">
                                <span class="bread-current bread-cat">
                                    <?php
                                    if (is_category()) {
                                        echo esc_html(single_cat_title('', false));
                                    } elseif (is_tag()) {
                                        echo esc_html(single_tag_title('', false));
                                    } elseif (is_author()) {
                                        echo esc_html(get_the_author_meta('display_name', get_queried_object_id()));
                                    } elseif (is_date()) {
                                        echo esc_html(get_the_date('F Y'));
                                    } else {
                                        esc_html_e('Blog', 'blogar');
                                    }
                                    ?>
                                </span>
                            </li>
                        </ul>
                    </nav>
                    <h1 class="page-title"><?php echo wp_kses($page_title, array('span' => array())); ?></h1>

                    <?php if (!empty($archive_count) || !empty($archive_desc)): ?>
                        <div class="archive-info-block">
                            <?php if (!empty($archive_desc)): ?>
                                <div class="archive-description"><?php echo wp_kses_post($archive_desc); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($archive_count)): ?>
                                <div class="archive-info-meta">
                                    <span class="archive-count-pill"><?php echo esc_html($archive_count); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ================================================================
     BLOG AREA
     .archive-layout-sidebar  → col-8 + col-4 sidebar
     .archive-layout-full     → col-12, 2-col grid, no sidebar
     ================================================================ -->
<div class="main-wrapper">
    <div class="axil-blog-area axil-section-gap bg-color-white archive-layout-<?php echo esc_attr($archive_layout); ?>">
        <div class="container">
            <div class="row row--40">

                <!-- ── POST LIST ──────────────────────────────────── -->
                <div
                    class="<?php echo $is_full ? 'col-lg-12 col-md-12 col-12' : 'col-lg-8 col-md-12 col-12 order-1 order-lg-2'; ?>">

                    <?php if (have_posts()): ?>

                        <?php if ($is_full): ?>
                            <!-- ── FULL-WIDTH: 2-col card grid ──────────── -->
                            <div class="archive-full-grid">
                            <?php endif; ?>

                            <?php while (have_posts()):
                                the_post(); ?>

                                <?php if ($is_full): ?>
                                    <!-- ── Card dọc (full-width layout) ───── -->
                                    <article id="post-<?php the_ID(); ?>" <?php post_class('archive-card-full'); ?>>

                                        <div class="archive-card-thumb">
                                            <a href="<?php the_permalink(); ?>">
                                                <img loading="lazy" decoding="async"
                                                    src="<?php echo esc_url(blogar_thumbnail_url(get_the_ID(), 'blogar-card')); ?>"
                                                    alt="<?php echo esc_attr(blogar_thumbnail_alt(get_the_ID())); ?>" width="390"
                                                    height="260">
                                            </a>
                                        </div>

                                        <div class="archive-card-body">
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

                                            <?php if (get_the_excerpt()): ?>
                                                <p class="archive-card-excerpt">
                                                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '…')); ?>
                                                </p>
                                            <?php endif; ?>

                                            <div class="archive-card-meta">
                                                <span class="archive-card-author">
                                                    <?php echo esc_html(get_the_author()); ?>
                                                </span>
                                                <span class="archive-card-sep" aria-hidden="true">·</span>
                                                <span class="archive-card-date">
                                                    <?php echo esc_html(get_the_date()); ?>
                                                </span>
                                                <span class="archive-card-sep" aria-hidden="true">·</span>
                                                <span class="archive-card-read">
                                                    <?php echo esc_html(blogar_reading_time(get_the_ID())); ?>
                                                </span>
                                            </div>
                                        </div>

                                    </article>

                                <?php else: ?>
                                    <!-- ── Card ngang (sidebar layout, giữ nguyên) ── -->
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
                                                        <p class="post-author-name">
                                                            <a class="hover-flip-item-wrapper"
                                                                href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                                <span class="hover-flip-item">
                                                                    <span data-text="<?php echo esc_attr(get_the_author()); ?>">
                                                                        <?php echo esc_html(get_the_author()); ?>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </p>
                                                        <ul class="post-meta-list">
                                                            <li class="post-meta-date"><?php echo esc_html(get_the_date()); ?>
                                                            </li>
                                                            <li class="post-meta-reading-time">
                                                                <?php echo esc_html(blogar_reading_time(get_the_ID())); ?>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </article>
                                <?php endif; // end $is_full card switch ?>

                            <?php endwhile; ?>

                            <?php if ($is_full): ?>
                            </div><!-- .archive-full-grid -->
                        <?php endif; ?>



                        <!-- Pagination -->
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
                            <p><?php esc_html_e('No posts found.', 'blogar'); ?></p>
                        </div>
                    <?php endif; ?>

                </div><!-- post list col -->


                <!-- ── SIDEBAR (chỉ render khi layout = 'sidebar') ─── -->
                <?php if (!$is_full):
                    get_template_part('template-parts/sidebar');
                endif; ?>

            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .axil-blog-area -->
</div><!-- .main-wrapper -->

<?php get_footer(); ?>