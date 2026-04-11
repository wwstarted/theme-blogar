<?php
/**
 * home.php — Blogar Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// ── Layout option ──────────────────────────────────────────────────
$home_layout = get_option('blogar_home_layout', 'sidebar');
$is_full = ('full' === $home_layout);

// ── Active category filter ─────────────────────────────────────────
// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$current_cat = isset($_GET['cat']) ? absint($_GET['cat']) : 0;

// ── Posts page base URL (cho filter tab links) ─────────────────────
$posts_page_id  = (int) get_option('page_for_posts');
$posts_page_url = $posts_page_id ? get_permalink($posts_page_id) : home_url('/');

// ── Page description (fallback khi category không có desc) ──────────
$page_desc = '';
if ($posts_page_id) {
    $raw_page_desc = get_post_meta($posts_page_id, 'blogar_home_description', true);
    if (!empty(trim($raw_page_desc))) {
        $page_desc = wpautop(wp_kses_post($raw_page_desc));
    }
}

// ── Archive info: description + count (cho breadcrumb area) ──────────
$home_archive_desc  = '';
$home_archive_count = '';

if ($current_cat > 0) {
    // Filter category đang active → ưu tiên desc của category, fallback về page desc
    $filtered_term = get_category($current_cat);
    if ($filtered_term && !is_wp_error($filtered_term)) {
        $term_desc = term_description($current_cat, 'category');
        if (!empty(trim(strip_tags($term_desc)))) {
            $home_archive_desc = $term_desc; // already wpautop'd + kses'd by WP
        } else {
            $home_archive_desc = $page_desc; // fallback về page description
        }
        $cnt = (int) $filtered_term->count;
        if ($cnt > 0) {
            $home_archive_count = sprintf(
                /* translators: %s: formatted post count */
                _n('%s article', '%s articles', $cnt, 'blogar'),
                number_format_i18n($cnt)
            );
        }
    }
} else {
    // All tab → dùng page description + đếm tổng post publish
    $home_archive_desc = $page_desc;
    $post_counts       = wp_count_posts('post');
    $total             = isset($post_counts->publish) ? (int) $post_counts->publish : 0;
    if ($total > 0) {
        $home_archive_count = sprintf(
            /* translators: %s: formatted post count */
            _n('%s article', '%s articles', $total, 'blogar'),
            number_format_i18n($total)
        );
    }
}

// ── Lấy danh sách categories cho tabs filter ───────────────────────
$filter_cats = get_categories(array(
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
    'number'     => 20,
));
?>

<!-- ================================================================
     BREADCRUMB — h1 duy nhất/page
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
                            <li class="item-current" aria-current="page">
                                <span class="bread-current">
                                    <?php
                                    if ($current_cat > 0) {
                                        $active_term = get_category($current_cat);
                                        if ($active_term && !is_wp_error($active_term)) {
                                            echo esc_html($active_term->name);
                                        } else {
                                            esc_html_e('Blog', 'blogar');
                                        }
                                    } else {
                                        esc_html_e('Blog', 'blogar');
                                    }
                                    ?>
                                </span>
                            </li>
                        </ul>
                    </nav>
                    <h1 class="page-title">
                        <?php
                        if ($current_cat > 0) {
                            $active_term = get_category($current_cat);
                            if ($active_term && !is_wp_error($active_term)) {
                                echo wp_kses(
                                    sprintf(
                                        /* translators: %s: category name */
                                        __('Blog: <span>%s</span>', 'blogar'),
                                        esc_html($active_term->name)
                                    ),
                                    array('span' => array())
                                );
                            } else {
                                esc_html_e('Blog', 'blogar');
                            }
                        } else {
                            esc_html_e('Blog', 'blogar');
                        }
                        ?>
                    </h1>

                    <?php if (!empty($home_archive_count) || !empty($home_archive_desc)): ?>
                    <div class="archive-info-block">
                        <?php if (!empty($home_archive_desc)): ?>
                        <div class="archive-description"><?php echo wp_kses_post($home_archive_desc); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($home_archive_count)): ?>
                        <div class="archive-info-meta">
                            <span class="archive-count-pill"><?php echo esc_html($home_archive_count); ?></span>
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
     CATEGORY FILTER TABS
     ================================================================ -->
<?php if (!empty($filter_cats)): ?>
<div class="home-filter-bar">
    <div class="container">
        <nav class="home-filter-tabs" aria-label="<?php esc_attr_e('Filter posts by category', 'blogar'); ?>">

            <!-- Tab: All -->
            <a href="<?php echo esc_url($posts_page_url); ?>"
                class="home-filter-tab<?php echo (0 === $current_cat) ? ' is-active' : ''; ?>"
                <?php echo (0 === $current_cat) ? 'aria-current="page"' : ''; ?>>
                <?php esc_html_e('All', 'blogar'); ?>
            </a>

            <!-- Tab: từng category -->
            <?php foreach ($filter_cats as $fcat): ?>
            <a href="<?php echo esc_url(add_query_arg('cat', $fcat->term_id, $posts_page_url)); ?>"
                class="home-filter-tab<?php echo ($current_cat === $fcat->term_id) ? ' is-active' : ''; ?>"
                <?php echo ($current_cat === $fcat->term_id) ? 'aria-current="page"' : ''; ?>>
                <?php echo esc_html($fcat->name); ?>
            </a>
            <?php endforeach; ?>

        </nav>
    </div>
</div>
<?php endif; ?>


<!-- ================================================================
     BLOG AREA
     .archive-layout-sidebar  → col-8 + col-4 sidebar
     .archive-layout-full     → col-12, 3-col grid, no sidebar
     ================================================================ -->
<div class="main-wrapper">
    <div class="axil-blog-area axil-section-gap bg-color-white archive-layout-<?php echo esc_attr($home_layout); ?>">
        <div class="container">
            <div class="row row--40">

                <!-- ── POST LIST ──────────────────────────────────── -->
                <div class="<?php echo $is_full
                    ? 'col-lg-12 col-md-12 col-12'
                    : 'col-lg-8 col-md-12 col-12 order-1 order-lg-2'; ?>">

                    <div class="blogar-visually-hidden">
                        <h2><?php esc_html_e('Blog posts', 'blogar'); ?></h2>
                    </div>

                    <?php if (have_posts()): ?>

                    <?php if ($is_full): ?>
                    <div class="archive-full-grid">
                        <?php endif; ?>

                        <?php while (have_posts()): the_post(); ?>

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
                                <?php $cats = get_the_category(); if ($cats): ?>
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

                                <h3 class="title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>

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
                        <!-- ── Card ngang (sidebar layout) ──── -->
                        <article id="post-<?php the_ID(); ?>"
                            <?php post_class('content-block post-list-view mt--30'); ?>>

                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <img loading="lazy" decoding="async" width="295" height="221"
                                        src="<?php echo esc_url(blogar_thumbnail_url(get_the_ID(), 'blogar-list')); ?>"
                                        alt="<?php echo esc_attr(blogar_thumbnail_alt(get_the_ID())); ?>">
                                </a>
                            </div>

                            <div class="post-content">
                                <?php $cats = get_the_category(); if ($cats): ?>
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

                                <h3 class="title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>

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
                                                <li class="post-meta-date">
                                                    <?php echo esc_html(get_the_date()); ?>
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
                            'mid_size'  => 2,
                            'prev_text' => __('&larr; Previous', 'blogar'),
                            'next_text' => __('Next &rarr;', 'blogar'),
                            'class'     => 'axil-pagination mt--30',
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