<?php
/**
 * search.php — Blogar Theme
 *
 * Template: Search results.
 *
 * SEO  : Exactly 1 <h1> per page (page-title inside breadcrumb).
 * Data : Uses the main WordPress search query; sidebar widgets use WP functions.
 * CSS  : Reuses archive.php structure + css/archive.css styles for identical UI.
 * JS   : Reuses js/frontpage.js (copy-link) — no new JS needed.
 *
 * Sidebar v2:
 *  - Đồng bộ với archive.php: Popular Posts / Categories / Subscribe Newsletter.
 *  - Bỏ 8 widgets cũ (Search, Recent, Newsletter, Social, Gallery, Videos, Tags, Ad).
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$svg_fb = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>';
$svg_tw = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>';
$svg_li = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>';
$svg_lk = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>';

$search_query = get_search_query();
$page_title = sprintf(
    /* translators: %s: search keyword */
    __('Search Results for: <span>%s</span>', 'blogar'),
    esc_html($search_query)
);

$img = get_template_directory_uri() . '/images/frontpage/';
?>

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
                                    <?php echo esc_html($search_query); ?>
                                </span>
                            </li>
                        </ul>
                    </nav>

                    <h1 class="page-title"><?php echo wp_kses($page_title, array('span' => array())); ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>

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
                            <?php $cats = get_the_category(); ?>
                            <?php if ($cats): ?>
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
                                            <li class="post-meta-date"><?php echo esc_html(get_the_date()); ?></li>
                                            <li class="post-meta-reading-time">
                                                <?php echo esc_html(blogar_reading_time(get_the_ID())); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php endwhile; ?>

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
                        <p>
                            <?php
                                printf(
                                    /* translators: %s: search keyword */
                                    esc_html__('No results found for: %s', 'blogar'),
                                    esc_html($search_query)
                                );
                                ?>
                        </p>
                    </div>

                    <?php endif; ?>

                </div><!-- .col-lg-8 -->


                <!-- ── SIDEBAR ─────────────────────────────────────── -->
                <?php get_template_part('template-parts/sidebar'); ?>

            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .axil-blog-area -->
</div><!-- .main-wrapper -->

<?php get_footer(); ?>