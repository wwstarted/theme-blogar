<?php
get_header();

$img = get_template_directory_uri() . '/images/frontpage/';

// ── Inline SVG icons ──────────────────────────────────────────
$svg_fb = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>';
$svg_tw = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>';
$svg_li = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>';
$svg_lk = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>';
$svg_ig = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5" fill="none" stroke="currentColor" stroke-width="2"/><path fill="none" stroke="currentColor" stroke-width="2" d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>';
$svg_search = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>';
?>

<div class="blogar-front-page-shell">
    <div class="main-wrapper">

        <!-- ================================================================
             SECTION 11 — NEWS HIGHLIGHT BLOCK
             ================================================================ -->
        <?php
        $news_highlight_data = blogar_get_news_highlight_block_data();
        $news_highlight_ticker_posts = isset($news_highlight_data['ticker_posts']) ? $news_highlight_data['ticker_posts'] : array();
        $news_highlight_grid_posts = isset($news_highlight_data['grid_posts']) ? $news_highlight_data['grid_posts'] : array();
        $news_highlight_big_post = !empty($news_highlight_grid_posts) ? $news_highlight_grid_posts[0] : null;
        $news_highlight_small_posts = count($news_highlight_grid_posts) > 1 ? array_slice($news_highlight_grid_posts, 1, 3) : array();
        ?>

        <section class="axil-highlight-showcase-area axil-section-gap bg-color-grey">
            <div class="container">
                <div class="blogar-news-highlight-shell">

                    <!-- Ticker -->
                    <div class="blogar-news-highlight-ticker" data-news-ticker data-autotime="3000">
                        <div class="blogar-news-highlight-ticker-bar">
                            <span class="blogar-news-highlight-label">
                                <?php echo esc_html($news_highlight_data['ticker_title']); ?>
                            </span>
                            <div class="blogar-news-highlight-controls" role="group"
                                aria-label="<?php esc_attr_e('Headline navigation', 'blogar'); ?>">
                                <button type="button"
                                    class="blogar-news-highlight-control blogar-news-highlight-ticker-prev"
                                    aria-label="<?php esc_attr_e('Previous headline', 'blogar'); ?>">
                                    <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true">
                                        <path d="M15 6l-6 6 6 6" fill="none" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                    </svg>
                                </button>
                                <button type="button"
                                    class="blogar-news-highlight-control blogar-news-highlight-ticker-next"
                                    aria-label="<?php esc_attr_e('Next headline', 'blogar'); ?>">
                                    <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true">
                                        <path d="M9 6l6 6-6 6" fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="blogar-news-highlight-ticker-viewport" aria-live="polite">
                            <?php if (!empty($news_highlight_ticker_posts)): ?>
                            <?php foreach ($news_highlight_ticker_posts as $ticker_index => $ticker_post):
                                        $ticker_is_active = ($ticker_index === 0);
                                        ?>
                            <div class="blogar-news-highlight-ticker-item<?php echo $ticker_is_active ? ' is-active' : ''; ?>"
                                aria-hidden="<?php echo $ticker_is_active ? 'false' : 'true'; ?>">
                                <a href="<?php echo esc_url(get_permalink($ticker_post->ID)); ?>"
                                    tabindex="<?php echo $ticker_is_active ? '0' : '-1'; ?>">
                                    <?php echo esc_html(get_the_title($ticker_post->ID)); ?>
                                </a>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <div class="blogar-news-highlight-ticker-item is-active" aria-hidden="false">
                                <span
                                    class="blogar-news-highlight-ticker-text"><?php esc_html_e('Latest updates will appear here soon.', 'blogar'); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div><!-- /.blogar-news-highlight-ticker -->

                    <!-- Grid -->
                    <div class="blogar-news-highlight-grid">

                        <!-- Big featured card -->
                        <article class="blogar-news-highlight-card blogar-news-highlight-card-featured">
                            <div class="blogar-news-highlight-card-media">
                                <?php if ($news_highlight_big_post instanceof WP_Post):
                                    $hb_id = $news_highlight_big_post->ID;
                                    $hb_url = get_permalink($hb_id);
                                    $hb_title = get_the_title($hb_id);
                                    $hb_thumb_url = blogar_thumbnail_url($hb_id, 'full');
                                    $hb_thumb_alt = blogar_thumbnail_alt($hb_id);
                                    $hb_author_id = (int) get_post_field('post_author', $hb_id);
                                    $hb_author_name = get_the_author_meta('display_name', $hb_author_id);
                                    $hb_author_url = get_author_posts_url($hb_author_id);
                                    $hb_cats = array_slice(get_the_category($hb_id), 0, 2);
                                    ?>
                                <a href="<?php echo esc_url($hb_url); ?>" class="blogar-news-highlight-card-image-link">
                                    <img loading="lazy" decoding="async" src="<?php echo esc_url($hb_thumb_url); ?>"
                                        alt="<?php echo esc_attr($hb_thumb_alt); ?>">
                                </a>
                                <?php else: ?>
                                <span class="blogar-news-highlight-card-image-link is-placeholder">
                                    <img loading="lazy" decoding="async"
                                        src="<?php echo esc_url(blogar_thumbnail_url(0, 'full')); ?>"
                                        alt="<?php esc_attr_e('Placeholder image', 'blogar'); ?>">
                                </span>
                                <?php endif; ?>
                            </div>

                            <div class="blogar-news-highlight-card-content">
                                <?php if ($news_highlight_big_post instanceof WP_Post): ?>
                                <?php if (!empty($hb_cats)): ?>
                                <div class="blogar-news-highlight-card-cats">
                                    <?php foreach ($hb_cats as $ci => $hb_cat): ?>
                                    <?php echo blogar_hover_flip_link_html(get_category_link($hb_cat->term_id), $hb_cat->name, 'blogar-news-highlight-card-cat'); // phpcs:ignore ?>
                                    <?php if ($ci < count($hb_cats) - 1): ?><span
                                        class="blogar-news-highlight-card-cat-dot"></span><?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                                <h1 class="title"><a
                                        href="<?php echo esc_url($hb_url); ?>"><?php echo esc_html($hb_title); ?></a>
                                </h1>
                                <div class="blogar-news-highlight-card-meta">
                                    <span class="blogar-news-highlight-card-meta-item">
                                        <?php esc_html_e('by', 'blogar'); ?>
                                        <?php echo blogar_hover_flip_link_html($hb_author_url, $hb_author_name, 'blogar-news-highlight-card-author'); // phpcs:ignore ?>
                                    </span>
                                    <span class="blogar-news-highlight-card-meta-dot"></span>
                                    <time class="blogar-news-highlight-card-meta-item"
                                        datetime="<?php echo esc_attr(get_the_date('c', $hb_id)); ?>">
                                        <?php echo esc_html(get_the_date('F j, Y', $hb_id)); ?>
                                    </time>
                                </div>
                                <?php else: ?>
                                <h1 class="title"><?php esc_html_e('No featured post selected yet.', 'blogar'); ?></h1>
                                <?php endif; ?>
                            </div>
                        </article>

                        <div class="blogar-visually-hidden">
                            <h2><?php esc_html_e('More top stories', 'blogar'); ?></h2>
                        </div>

                        <!-- Small stacked cards -->
                        <div class="blogar-news-highlight-stack">
                            <?php foreach ($news_highlight_small_posts as $sp): ?>
                            <article class="blogar-news-highlight-card blogar-news-highlight-card-small">
                                <div class="blogar-news-highlight-card-media">
                                    <?php if ($sp instanceof WP_Post):
                                                $hs_id = $sp->ID;
                                                $hs_url = get_permalink($hs_id);
                                                $hs_title = get_the_title($hs_id);
                                                $hs_thumb_url = blogar_thumbnail_url($hs_id, 'full');
                                                $hs_thumb_alt = blogar_thumbnail_alt($hs_id);
                                                $hs_author_id = (int) get_post_field('post_author', $hs_id);
                                                $hs_author_name = get_the_author_meta('display_name', $hs_author_id);
                                                $hs_author_url = get_author_posts_url($hs_author_id);
                                                ?>
                                    <a href="<?php echo esc_url($hs_url); ?>"
                                        class="blogar-news-highlight-card-image-link">
                                        <img loading="lazy" decoding="async" src="<?php echo esc_url($hs_thumb_url); ?>"
                                            alt="<?php echo esc_attr($hs_thumb_alt); ?>">
                                    </a>
                                    <?php else: ?>
                                    <span class="blogar-news-highlight-card-image-link is-placeholder">
                                        <img loading="lazy" decoding="async"
                                            src="<?php echo esc_url(blogar_thumbnail_url(0, 'full')); ?>"
                                            alt="<?php esc_attr_e('Placeholder image', 'blogar'); ?>">
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="blogar-news-highlight-card-content">
                                    <?php if ($sp instanceof WP_Post): ?>
                                    <h3 class="title"><a
                                            href="<?php echo esc_url($hs_url); ?>"><?php echo esc_html($hs_title); ?></a>
                                    </h3>
                                    <div class="blogar-news-highlight-card-meta">
                                        <span class="blogar-news-highlight-card-meta-item">
                                            <?php esc_html_e('by', 'blogar'); ?>
                                            <?php echo blogar_hover_flip_link_html($hs_author_url, $hs_author_name, 'blogar-news-highlight-card-author'); // phpcs:ignore ?>
                                        </span>
                                        <span class="blogar-news-highlight-card-meta-dot"></span>
                                        <time class="blogar-news-highlight-card-meta-item"
                                            datetime="<?php echo esc_attr(get_the_date('c', $hs_id)); ?>">
                                            <?php echo esc_html(get_the_date('F j, Y', $hs_id)); ?>
                                        </time>
                                    </div>
                                    <?php else: ?>
                                    <h3 class="title"><?php esc_html_e('No post available yet.', 'blogar'); ?></h3>
                                    <?php endif; ?>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        </div>

                    </div><!-- /.blogar-news-highlight-grid -->
                </div><!-- /.blogar-news-highlight-shell -->
            </div>
        </section>


        <!-- ================================================================
             SECTION 5 — TRENDING TOPICS (categories carousel)
             ================================================================ -->
        <?php
        $topics_data = blogar_get_trending_topics_data();
        $topics = $topics_data['categories'];
        ?>
        <?php if (!empty($topics)): ?>
        <section class="axil-categories-list axil-section-gap bg-color-grey">
            <div class="container">
                <div class="categories-section-header">
                    <div class="section-title text-left">
                        <h2 class="title"><?php echo esc_html($topics_data['title']); ?></h2>
                    </div>
                    <div class="see-all-topics">
                        <a class="axil-link-button"
                            href="<?php echo esc_url($topics_data['archive_url']); ?>"><?php esc_html_e('See All Topics', 'blogar'); ?></a>
                    </div>
                </div>
                <div class="list-categories categories-activation arrow-between-side mt--30" data-cat-carousel>
                    <div class="carousel-viewport">
                        <div class="carousel-track">
                            <?php foreach ($topics as $cat): ?>
                            <div class="single-cat">
                                <div class="inner">
                                    <a href="<?php echo esc_url($cat['url']); ?>">
                                        <div class="thumbnail">
                                            <img loading="lazy" decoding="async" width="180" height="180"
                                                src="<?php echo esc_url($cat['thumb_url']); ?>"
                                                alt="<?php echo esc_attr($cat['thumb_alt']); ?>">
                                        </div>
                                        <div class="content">
                                            <span
                                                class="title"><?php echo blogar_hover_flip_text_html($cat['name'], 'blogar-card-flip-text blogar-card-flip-text--light'); // phpcs:ignore ?></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button class="slide-arrow prev-arrow" aria-label="<?php esc_attr_e('Previous', 'blogar'); ?>">
                        <svg viewBox="0 0 24 24">
                            <path d="M19 12H5M12 5l-7 7 7 7" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button class="slide-arrow next-arrow" aria-label="<?php esc_attr_e('Next', 'blogar'); ?>">
                        <svg viewBox="0 0 24 24">
                            <path d="M5 12h14M12 19l7-7-7-7" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>
        <?php endif; ?>


        <!-- ================================================================
             SECTION 13 — FEATURED GRID 2+3 (dark, fvg2)
             ================================================================ -->
        <?php $fvg2_data = blogar_get_featured_grid_2plus3_data(); ?>
        <?php if (!empty($fvg2_data['top_posts']) || !empty($fvg2_data['bottom_posts'])): ?>
        <section class="axil-fvg2-area">

            <div class="fvg2-header">
                <div class="container">
                    <h2 class="fvg2-header__title"><?php echo esc_html($fvg2_data['title']); ?></h2>
                </div>
            </div>

            <div class="container">
                <div class="fvg2-grid">

                    <!-- Top row: 2 equal cards -->
                    <div class="fvg2-row fvg2-row--top">
                        <?php foreach ($fvg2_data['top_posts'] as $tp):
                                if (!$tp instanceof WP_Post)
                                    continue;
                                $tp_id = $tp->ID;
                                $tp_url = get_permalink($tp_id);
                                $tp_title = get_the_title($tp_id);
                                $tp_thumb = blogar_thumbnail_url($tp_id, 'blogar-grid-big');
                                $tp_alt = blogar_thumbnail_alt($tp_id);
                                $tp_author = get_the_author_meta('display_name', (int) $tp->post_author);
                                $tp_date = get_the_date('F j, Y', $tp_id);
                                ?>
                        <a href="<?php echo esc_url($tp_url); ?>" class="fvg2-card fvg2-card--top"
                            aria-label="<?php echo esc_attr($tp_title); ?>">
                            <div class="fvg2-card__thumb"><img loading="lazy" decoding="async"
                                    src="<?php echo esc_url($tp_thumb); ?>" alt="<?php echo esc_attr($tp_alt); ?>">
                            </div>
                            <div class="fvg2-card__overlay" aria-hidden="true"></div>
                            <div class="fvg2-card__content">
                                <h3 class="fvg2-card__title"><span
                                        class="blogar-home-title-fill"><?php echo esc_html($tp_title); ?></span></h3>
                                <div class="fvg2-card__meta">
                                    <span class="fvg2-meta-by"><?php esc_html_e('by', 'blogar'); ?></span>
                                    <?php echo blogar_hover_flip_text_html($tp_author, 'fvg2-meta-author blogar-card-flip-text blogar-card-flip-text--light'); // phpcs:ignore ?>
                                    <span class="fvg2-meta-dot" aria-hidden="true">•</span>
                                    <span class="fvg2-meta-date"><?php echo esc_html($tp_date); ?></span>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>

                    <!-- Bottom row: 3 equal cards -->
                    <div class="fvg2-row fvg2-row--bottom">
                        <?php foreach ($fvg2_data['bottom_posts'] as $bp):
                                if (!$bp instanceof WP_Post)
                                    continue;
                                $bp_id = $bp->ID;
                                $bp_url = get_permalink($bp_id);
                                $bp_title = get_the_title($bp_id);
                                $bp_thumb = blogar_thumbnail_url($bp_id, 'blogar-card');
                                $bp_alt = blogar_thumbnail_alt($bp_id);
                                $bp_author = get_the_author_meta('display_name', (int) $bp->post_author);
                                $bp_date = get_the_date('F j, Y', $bp_id);
                                ?>
                        <a href="<?php echo esc_url($bp_url); ?>" class="fvg2-card fvg2-card--bottom"
                            aria-label="<?php echo esc_attr($bp_title); ?>">
                            <div class="fvg2-card__thumb"><img loading="lazy" decoding="async"
                                    src="<?php echo esc_url($bp_thumb); ?>" alt="<?php echo esc_attr($bp_alt); ?>">
                            </div>
                            <div class="fvg2-card__overlay" aria-hidden="true"></div>
                            <div class="fvg2-card__content">
                                <h3 class="fvg2-card__title"><span
                                        class="blogar-home-title-fill"><?php echo esc_html($bp_title); ?></span></h3>
                                <div class="fvg2-card__meta">
                                    <span class="fvg2-meta-by"><?php esc_html_e('by', 'blogar'); ?></span>
                                    <?php echo blogar_hover_flip_text_html($bp_author, 'fvg2-meta-author blogar-card-flip-text blogar-card-flip-text--light'); // phpcs:ignore ?>
                                    <span class="fvg2-meta-dot" aria-hidden="true">•</span>
                                    <span class="fvg2-meta-date"><?php echo esc_html($bp_date); ?></span>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </section>
        <?php endif; ?>


        <!-- ================================================================
             SECTION 14 — LATEST POSTS GRID
             ================================================================ -->
        <?php $lp_data = blogar_get_latest_posts_data(); ?>
        <?php if (!empty($lp_data['posts'])): ?>
        <section class="axil-latest-posts-area axil-section-gap bg-color-white">
            <div class="container">

                <div class="lp-section-title">
                    <div class="lp-title-inner">
                        <span class="lp-title-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                                <polyline points="10 9 9 9 8 9" />
                            </svg>
                        </span>
                        <h2 class="lp-title-text"><?php echo esc_html($lp_data['title']); ?></h2>
                    </div>
                </div>

                <div class="lp-grid mt--30">
                    <?php foreach ($lp_data['posts'] as $lp):
                            $lp_id = $lp->ID;
                            $lp_url = get_permalink($lp_id);
                            $lp_title = get_the_title($lp_id);
                            $lp_thumb = blogar_thumbnail_url($lp_id, 'blogar-card');
                            $lp_alt = blogar_thumbnail_alt($lp_id);
                            $lp_author = get_the_author_meta('display_name', (int) $lp->post_author);
                            $lp_aurl = get_author_posts_url((int) $lp->post_author);
                            $lp_date = get_the_date('F j, Y', $lp_id);
                            $lp_cats = get_the_category($lp_id);
                            ?>
                    <article class="lp-card">
                        <div class="lp-card__thumb">
                            <a href="<?php echo esc_url($lp_url); ?>" tabindex="-1" aria-hidden="true">
                                <img loading="lazy" decoding="async" src="<?php echo esc_url($lp_thumb); ?>"
                                    alt="<?php echo esc_attr($lp_alt); ?>">
                            </a>
                        </div>
                        <div class="lp-card__body">
                            <?php if ($lp_cats): ?>
                            <div class="lp-card__cat">
                                <?php echo blogar_hover_flip_link_html(get_category_link($lp_cats[0]->term_id), $lp_cats[0]->name, 'lp-card__cat-link'); // phpcs:ignore ?>
                            </div>
                            <?php endif; ?>
                            <h3 class="lp-card__title">
                                <a href="<?php echo esc_url($lp_url); ?>"><?php echo esc_html($lp_title); ?></a>
                            </h3>
                            <div class="lp-card__meta">
                                <span class="lp-meta-by"><?php esc_html_e('by', 'blogar'); ?></span>
                                <?php echo blogar_hover_flip_link_html($lp_aurl, $lp_author, 'lp-meta-author'); // phpcs:ignore ?>
                                <span class="lp-meta-dot" aria-hidden="true">•</span>
                                <span class="lp-meta-date"><?php echo esc_html($lp_date); ?></span>
                            </div>
                            <div class="lp-card__readmore">
                                <a href="<?php echo esc_url($lp_url); ?>"
                                    class="lp-readmore-btn"><?php esc_html_e('Read The Article', 'blogar'); ?></a>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>

                <div class="lp-loadmore mt--30">
                    <a href="<?php echo esc_url($lp_data['more_url']); ?>" class="lp-loadmore-btn">
                        <span><?php esc_html_e('Load More Posts', 'blogar'); ?></span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"
                            width="14" height="14">
                            <polyline points="23 4 23 10 17 10" />
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                        </svg>
                    </a>
                </div>

            </div>
        </section>
        <?php endif; ?>


        <!-- ================================================================
             SECTION 12 — FEATURED GRID THIS WEEK (asymmetric fvg)
             ================================================================ -->
        <?php $fvg_data = blogar_get_featured_grid_this_week_data(); ?>
        <?php if ($fvg_data['big'] instanceof WP_Post): ?>
        <section class="axil-featured-grid-area axil-section-gap bg-color-white">
            <div class="container">

                <div class="section-title text-left">
                    <h2 class="title"><?php echo esc_html($fvg_data['title']); ?></h2>
                </div>

                <div class="fvg-grid mt--30">

                    <!-- BIG POST — LEFT -->
                    <div class="fvg-left">
                        <?php
                            $fvg_big = $fvg_data['big'];
                            $big_id = $fvg_big->ID;
                            $big_url = get_permalink($big_id);
                            $big_title = get_the_title($big_id);
                            $big_thumb = blogar_thumbnail_url($big_id, 'blogar-grid-big');
                            $big_alt = blogar_thumbnail_alt($big_id);
                            $big_author = get_the_author_meta('display_name', (int) $fvg_big->post_author);
                            $big_date = get_the_date('M j, Y', $big_id);
                            $big_cats = get_the_category($big_id);
                            $big_read = blogar_reading_time($big_id);
                            ?>
                        <a href="<?php echo esc_url($big_url); ?>" class="fvg-card fvg-card--big"
                            aria-label="<?php echo esc_attr($big_title); ?>">
                            <div class="fvg-card-thumb"><img loading="lazy" decoding="async"
                                    src="<?php echo esc_url($big_thumb); ?>" alt="<?php echo esc_attr($big_alt); ?>">
                            </div>
                            <div class="fvg-card-overlay" aria-hidden="true"></div>
                            <div class="fvg-card-content">
                                <?php if ($big_cats): ?>
                                <?php echo blogar_hover_flip_text_html($big_cats[0]->name, 'fvg-card-cat blogar-card-flip-text blogar-card-flip-text--badge'); // phpcs:ignore ?>
                                <?php endif; ?>
                                <h3 class="fvg-card-title"><span
                                        class="blogar-home-title-fill"><?php echo esc_html($big_title); ?></span></h3>
                                <div class="fvg-card-meta">
                                    <span><?php echo esc_html($big_author); ?></span>
                                    <span class="fvg-dot" aria-hidden="true">·</span>
                                    <span><?php echo esc_html($big_date); ?></span>
                                    <span class="fvg-dot" aria-hidden="true">·</span>
                                    <span><?php echo esc_html($big_read); ?></span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- RIGHT COLUMN -->
                    <div class="fvg-right">

                        <!-- Medium post — top-right -->
                        <?php if ($fvg_data['medium'] instanceof WP_Post):
                                $fvg_med = $fvg_data['medium'];
                                $med_id = $fvg_med->ID;
                                $med_url = get_permalink($med_id);
                                $med_title = get_the_title($med_id);
                                $med_thumb = blogar_thumbnail_url($med_id, 'blogar-card');
                                $med_alt = blogar_thumbnail_alt($med_id);
                                $med_date = get_the_date('M j, Y', $med_id);
                                $med_cats = get_the_category($med_id);
                                $med_read = blogar_reading_time($med_id);
                                ?>
                        <div class="fvg-right-top">
                            <a href="<?php echo esc_url($med_url); ?>" class="fvg-card fvg-card--medium"
                                aria-label="<?php echo esc_attr($med_title); ?>">
                                <div class="fvg-card-thumb"><img loading="lazy" decoding="async"
                                        src="<?php echo esc_url($med_thumb); ?>"
                                        alt="<?php echo esc_attr($med_alt); ?>"></div>
                                <div class="fvg-card-overlay" aria-hidden="true"></div>
                                <div class="fvg-card-content">
                                    <?php if ($med_cats): ?>
                                    <?php echo blogar_hover_flip_text_html($med_cats[0]->name, 'fvg-card-cat blogar-card-flip-text blogar-card-flip-text--badge'); // phpcs:ignore ?>
                                    <?php endif; ?>
                                    <h3 class="fvg-card-title"><span
                                            class="blogar-home-title-fill"><?php echo esc_html($med_title); ?></span>
                                    </h3>
                                    <div class="fvg-card-meta">
                                        <span><?php echo esc_html($med_date); ?></span>
                                        <span class="fvg-dot" aria-hidden="true">·</span>
                                        <span><?php echo esc_html($med_read); ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endif; ?>

                        <!-- 3 small posts — bottom-right -->
                        <?php if (!empty($fvg_data['smalls'])): ?>
                        <div class="fvg-right-bottom">
                            <?php foreach ($fvg_data['smalls'] as $sp):
                                            if (!$sp instanceof WP_Post)
                                                continue;
                                            $sp_id = $sp->ID;
                                            $sp_url = get_permalink($sp_id);
                                            $sp_title = get_the_title($sp_id);
                                            $sp_thumb = blogar_thumbnail_url($sp_id, 'blogar-featured');
                                            $sp_alt = blogar_thumbnail_alt($sp_id);
                                            $sp_date = get_the_date('M j, Y', $sp_id);
                                            $sp_cats = get_the_category($sp_id);
                                            ?>
                            <a href="<?php echo esc_url($sp_url); ?>" class="fvg-card fvg-card--small"
                                aria-label="<?php echo esc_attr($sp_title); ?>">
                                <div class="fvg-card-thumb"><img loading="lazy" decoding="async"
                                        src="<?php echo esc_url($sp_thumb); ?>" alt="<?php echo esc_attr($sp_alt); ?>">
                                </div>
                                <div class="fvg-card-overlay" aria-hidden="true"></div>
                                <div class="fvg-card-content">
                                    <?php if ($sp_cats): ?>
                                    <?php echo blogar_hover_flip_text_html($sp_cats[0]->name, 'fvg-card-cat blogar-card-flip-text blogar-card-flip-text--badge'); // phpcs:ignore ?>
                                    <?php endif; ?>
                                    <h3 class="fvg-card-title"><span
                                            class="blogar-home-title-fill"><?php echo esc_html($sp_title); ?></span>
                                    </h3>
                                    <div class="fvg-card-meta"><span><?php echo esc_html($sp_date); ?></span></div>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                    </div><!-- /.fvg-right -->

                </div><!-- /.fvg-grid -->
            </div>
        </section>
        <?php endif; ?>


        <!-- ================================================================
             SECTION 4 — INNOVATION & TECH (tabs + carousel)
             ================================================================ -->
        <?php
        $inno_data = blogar_get_innovation_data();
        $inno_tabs = $inno_data['tabs'];
        $inno_first = true;
        ?>
        <?php if (!empty($inno_tabs)): ?>
        <section class="axil-tab-area axil-section-gap bg-color-white">
            <div class="wrapper">
                <div class="container">

                    <div class="inno-section-head">
                        <div class="section-title text-left">
                            <h2 class="title"><?php echo esc_html($inno_data['title']); ?></h2>
                            <p class="inno-section-subtitle">
                                <?php esc_html_e('Explore the latest innovations and ideas shaping the world.', 'blogar'); ?>
                            </p>
                        </div>
                    </div>

                    <ul class="axil-tab-button inno-tab-button mt--20" role="tablist">
                        <?php foreach ($inno_tabs as $ti => $tab):
                                $tab_id = 'tab-inno-' . ($ti + 1);
                                $is_active = $inno_first;
                                $inno_first = false;
                                ?>
                        <li role="presentation">
                            <a class="tab-link<?php echo $is_active ? ' active' : ''; ?>"
                                data-tab="#<?php echo esc_attr($tab_id); ?>" role="tab"
                                aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>">
                                <?php echo esc_html($tab['label']); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="tab-content">
                        <?php
                            $inno_first = true;
                            foreach ($inno_tabs as $ti => $tab):
                                $tab_id = 'tab-inno-' . ($ti + 1);
                                $is_active = $inno_first;
                                $inno_first = false;
                                ?>
                        <div class="single-tab-content<?php echo $is_active ? ' active' : ''; ?>"
                            id="<?php echo esc_attr($tab_id); ?>" role="tabpanel">

                            <div class="modern-post-activation axil-slick-arrow arrow-between-side" data-tab-carousel>
                                <div class="carousel-viewport">
                                    <div class="carousel-track">

                                        <?php while ($tab['query']->have_posts()):
                                                        $tab['query']->the_post();
                                                        $post_id = get_the_ID();
                                                        $post_url = get_permalink();
                                                        $post_title = get_the_title();
                                                        $post_excerpt = wp_trim_words(get_the_excerpt(), 20, '…');
                                                        $post_date = get_the_date('M j, Y');
                                                        $read_time = blogar_reading_time($post_id);
                                                        $thumb_url = blogar_thumbnail_url($post_id, 'blogar-card');
                                                        $thumb_alt = blogar_thumbnail_alt($post_id);
                                                        $author_id = (int) get_the_author_meta('ID');
                                                        $author_name = get_the_author();
                                                        $author_url = get_author_posts_url($author_id);
                                                        $author_avatar = get_avatar_url($author_id, array('size' => 40));
                                                        ?>
                                        <div class="slick-single-layout">
                                            <div class="content-block modern-post-style">
                                                <div class="modern-card-thumb post-thumbnail">
                                                    <a href="<?php echo esc_url($post_url); ?>">
                                                        <img loading="lazy" decoding="async" width="390" height="260"
                                                            src="<?php echo esc_url($thumb_url); ?>"
                                                            alt="<?php echo esc_attr($thumb_alt); ?>">
                                                    </a>
                                                </div>
                                                <div class="modern-card-body post-content">
                                                    <div class="post-cat">
                                                        <div class="post-cat-list">
                                                            <?php echo blogar_post_categories_html($post_id, 1); // phpcs:ignore ?>
                                                        </div>
                                                    </div>
                                                    <h3 class="title"><a
                                                            href="<?php echo esc_url($post_url); ?>"><?php echo esc_html($post_title); ?></a>
                                                    </h3>
                                                    <?php if ($post_excerpt): ?>
                                                    <p class="modern-card-excerpt">
                                                        <?php echo esc_html($post_excerpt); ?></p>
                                                    <?php endif; ?>
                                                    <div class="modern-card-meta">
                                                        <img class="modern-card-avatar"
                                                            src="<?php echo esc_url($author_avatar); ?>"
                                                            alt="<?php echo esc_attr($author_name); ?>" width="32"
                                                            height="32" loading="lazy">
                                                        <div class="modern-card-author-info">
                                                            <a class="hover-flip-item-wrapper modern-card-author-name"
                                                                href="<?php echo esc_url($author_url); ?>">
                                                                <span class="hover-flip-item"><span
                                                                        data-text="<?php echo esc_attr($author_name); ?>"><?php echo esc_html($author_name); ?></span></span>
                                                            </a>
                                                            <div class="modern-card-meta-sub">
                                                                <span><?php echo esc_html($post_date); ?></span>
                                                                <span class="meta-dot" aria-hidden="true">·</span>
                                                                <span><?php echo esc_html($read_time); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endwhile;
                                                    wp_reset_postdata(); ?>

                                    </div>
                                </div>
                                <button class="slide-arrow prev-arrow"
                                    aria-label="<?php esc_attr_e('Previous', 'blogar'); ?>">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M19 12H5M12 5l-7 7 7 7" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <button class="slide-arrow next-arrow"
                                    aria-label="<?php esc_attr_e('Next', 'blogar'); ?>">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M5 12h14M12 19l7-7-7-7" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>

                        </div><!-- /.single-tab-content -->
                        <?php endforeach; ?>
                    </div><!-- /.tab-content -->

                </div>
            </div>
        </section>
        <?php endif; ?>


        <!-- ================================================================
             SECTION 10 — FEATURED VIDEO
             ================================================================ -->
        <?php $featured_video_data = blogar_get_featured_video_data(); ?>
        <section class="axil-video-post-area axil-section-gap bg-color-black">
            <div class="container">
                <div class="section-title text-left">
                    <h2 class="title"><?php echo esc_html($featured_video_data['title']); ?></h2>
                </div>

                <div class="video-posts-grid">
                    <?php if ($featured_video_data['big_post'] instanceof WP_Post):
                        $vb_id = $featured_video_data['big_post']->ID;
                        $vb_url = get_permalink($vb_id);
                        $vb_title = get_the_title($vb_id);
                        $vb_thumb_url = blogar_thumbnail_url($vb_id, 'blogar-featured-video-big');
                        $vb_thumb_alt = blogar_thumbnail_alt($vb_id);
                        $vb_author_id = (int) get_post_field('post_author', $vb_id);
                        $vb_author = get_the_author_meta('display_name', $vb_author_id);
                        $vb_author_url = get_author_posts_url($vb_author_id);
                        $vb_avatar = get_avatar_url($vb_author_id, array('size' => 50));
                        $vb_share = blogar_social_share_urls($vb_url, $vb_title);
                        ?>
                    <div class="content-block post-default image-rounded mt--30 axil-big-post-image">
                        <div class="post-thumbnail">
                            <a href="<?php echo esc_url($vb_url); ?>" class="video-post-link">
                                <img loading="lazy" decoding="async" width="600" height="500"
                                    src="<?php echo esc_url($vb_thumb_url); ?>"
                                    alt="<?php echo esc_attr($vb_thumb_alt); ?>">
                            </a>
                        </div>
                        <div class="post-content">
                            <div class="post-cat">
                                <div class="post-cat-list">
                                    <?php echo blogar_post_categories_html($vb_id, 1); // phpcs:ignore ?></div>
                            </div>
                            <h3 class="title"><a
                                    href="<?php echo esc_url($vb_url); ?>"><?php echo esc_html($vb_title); ?></a></h3>
                            <div class="post-meta-wrapper">
                                <div class="post-meta">
                                    <div class="post-author-avatar border-rounded">
                                        <img alt="<?php echo esc_attr($vb_author); ?>"
                                            src="<?php echo esc_url($vb_avatar); ?>" width="50" height="50">
                                    </div>
                                    <div class="content">
                                        <p class="post-author-name">
                                            <a class="hover-flip-item-wrapper"
                                                href="<?php echo esc_url($vb_author_url); ?>">
                                                <span class="hover-flip-item"><span
                                                        data-text="<?php echo esc_attr($vb_author); ?>"><?php echo esc_html($vb_author); ?></span></span>
                                            </a>
                                        </p>
                                        <ul class="post-meta-list">
                                            <li class="post-meta-date"><?php echo esc_html(get_the_date('', $vb_id)); ?>
                                            </li>
                                            <li class="post-meta-reading-time">
                                                <?php echo esc_html(blogar_reading_time($vb_id)); ?></li>
                                        </ul>
                                    </div>
                                </div>
                                <ul class="social-share-transparent justify-content-end">
                                    <li><a href="<?php echo esc_url($vb_share['facebook']); ?>" target="_blank"
                                            rel="noopener nofollow"
                                            aria-label="Facebook"><?php echo $svg_fb; // phpcs:ignore ?></a></li>
                                    <li><a href="<?php echo esc_url($vb_share['twitter']); ?>" target="_blank"
                                            rel="noopener nofollow"
                                            aria-label="Twitter"><?php echo $svg_tw; // phpcs:ignore ?></a></li>
                                    <li><a href="<?php echo esc_url($vb_share['linkedin']); ?>" target="_blank"
                                            rel="noopener nofollow"
                                            aria-label="LinkedIn"><?php echo $svg_li; // phpcs:ignore ?></a></li>
                                    <li><button class="axilcopyLink" data-link="<?php echo esc_url($vb_url); ?>"
                                            aria-label="Copy link"><?php echo $svg_lk; // phpcs:ignore ?></button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="content-block post-default image-rounded mt--30 axil-big-post-image">
                        <div class="post-thumbnail">
                            <a href="#" class="video-post-link"><img loading="lazy" decoding="async" width="600"
                                    height="500"
                                    src="<?php echo esc_url(blogar_thumbnail_url(0, 'blogar-featured-video-big')); ?>"
                                    alt="<?php esc_attr_e('Placeholder image', 'blogar'); ?>"></a>
                        </div>
                        <div class="post-content">
                            <h3 class="title"><?php esc_html_e('No featured post selected yet.', 'blogar'); ?></h3>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Small posts right column -->
                    <div class="video-posts-right">
                        <?php foreach ($featured_video_data['small_posts'] as $vs): ?>
                        <div class="content-block post-default image-rounded mt--30 axil-small-post-image">
                            <div class="post-thumbnail">
                                <?php if ($vs instanceof WP_Post):
                                            $vs_id = $vs->ID;
                                            $vs_url = get_permalink($vs_id);
                                            $vs_title = get_the_title($vs_id);
                                            $vs_thumb_url = blogar_thumbnail_url($vs_id, 'blogar-video-small');
                                            $vs_thumb_alt = blogar_thumbnail_alt($vs_id);
                                            ?>
                                <a href="<?php echo esc_url($vs_url); ?>" class="video-post-link">
                                    <img loading="lazy" decoding="async" width="285" height="190"
                                        src="<?php echo esc_url($vs_thumb_url); ?>"
                                        alt="<?php echo esc_attr($vs_thumb_alt); ?>">
                                </a>
                                <?php else: ?>
                                <a href="#" class="video-post-link"><img loading="lazy" decoding="async" width="285"
                                        height="190"
                                        src="<?php echo esc_url(blogar_thumbnail_url(0, 'blogar-video-small')); ?>"
                                        alt="<?php esc_attr_e('Placeholder image', 'blogar'); ?>"></a>
                                <?php endif; ?>
                            </div>
                            <div class="post-content">
                                <div class="post-cat">
                                    <div class="post-cat-list"><?php if ($vs instanceof WP_Post)
                                            echo blogar_post_categories_html($vs->ID, 1); // phpcs:ignore ?></div>
                                </div>
                                <?php if ($vs instanceof WP_Post): ?>
                                <h3 class="title"><a
                                        href="<?php echo esc_url($vs_url); ?>"><?php echo esc_html($vs_title); ?></a>
                                </h3>
                                <?php else: ?>
                                <h3 class="title"><?php esc_html_e('No post selected yet.', 'blogar'); ?></h3>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </section>

    </div><!-- /.main-wrapper -->
</div><!-- /.blogar-front-page-shell -->

<?php get_footer(); ?>