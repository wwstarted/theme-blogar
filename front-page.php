<?php
get_header();

$img = get_template_directory_uri() . '/images/frontpage/';

// ── Inline SVG icons (replaces Font Awesome) ──────────────────────
$svg_fb = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>';
$svg_tw = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>';
$svg_li = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>';
$svg_lk = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>';
$svg_ig = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5" fill="none" stroke="currentColor" stroke-width="2"/><path fill="none" stroke="currentColor" stroke-width="2" d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>';
$svg_pi = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12c0 4.24 2.65 7.86 6.39 9.29-.09-.78-.17-1.98.04-2.83.18-.77 1.22-5.17 1.22-5.17s-.31-.63-.31-1.56c0-1.46.85-2.55 1.9-2.55.9 0 1.33.67 1.33 1.48 0 .9-.58 2.26-.87 3.52-.25 1.05.52 1.9 1.55 1.9 1.86 0 3.3-1.96 3.3-4.8 0-2.51-1.8-4.26-4.38-4.26-2.98 0-4.73 2.23-4.73 4.54 0 .9.35 1.86.78 2.39.09.1.1.19.07.29-.08.33-.26 1.05-.29 1.19-.05.19-.16.23-.37.14-1.39-.65-2.26-2.68-2.26-4.32 0-3.51 2.55-6.74 7.35-6.74 3.86 0 6.86 2.75 6.86 6.42 0 3.83-2.41 6.9-5.76 6.9-1.13 0-2.19-.59-2.55-1.28l-.69 2.59c-.25.96-.93 2.17-1.38 2.9.04.01.08.01.12.01.96.29 1.97.45 3.02.45 5.52 0 10-4.48 10-10S17.52 2 12 2z"/></svg>';
$svg_yt = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-1.96C18.88 4 12 4 12 4s-6.88 0-8.6.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.4 19.54C5.12 20 12 20 12 20s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-1.94A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#fff"/></svg>';
$svg_db = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path fill="none" stroke="#fff" stroke-width="1.2" d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"/></svg>';
$svg_be = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M1.5 8.25h5.25c2.06 0 3.75 1.06 3.75 3s-1.44 2.81-2.56 3.06c1.44.25 3.06 1.31 3.06 3.44C11 20.19 9.19 21.75 6.94 21.75H1.5V8.25zm2.44 5.25h2.69c1 0 1.62-.44 1.62-1.31S7.63 11 6.63 11H3.94v2.5zm0 5.25h2.94c1.12 0 1.87-.56 1.87-1.5s-.75-1.5-1.87-1.5H3.94V18.75zM15 8.25h6v1.5h-6V8.25zm-1.5 7.5c0-2.81 2.06-5.25 4.87-5.25C21.25 10.5 23 12.94 23 15.75c0 .25 0 .5-.06.75H16c.25 1.19 1.19 2 2.37 2 .81 0 1.5-.44 2.06-1.06l1.69 1c-.75 1.19-2.06 2.06-3.75 2.06C15.63 20.5 13.5 18.44 13.5 15.75zm5.94-1.5c-.06-1-1-1.75-1.94-1.75-1 0-1.87.75-2.06 1.75h4z"/></svg>';
$svg_search = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>';
?>




<div class="blogar-front-page-shell">
    <div class="main-wrapper">
        <!-- ================================================================
     SECTION 11 â€” NEWS HIGHLIGHT BLOCK
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
                                    $ticker_post_id = $ticker_post->ID;
                                    $ticker_post_url = get_permalink($ticker_post_id);
                                    $ticker_post_title = get_the_title($ticker_post_id);
                                    $ticker_is_active = ($ticker_index === 0);
                                    ?>
                            <div class="blogar-news-highlight-ticker-item<?php echo $ticker_is_active ? ' is-active' : ''; ?>"
                                aria-hidden="<?php echo $ticker_is_active ? 'false' : 'true'; ?>">
                                <a href="<?php echo esc_url($ticker_post_url); ?>"
                                    tabindex="<?php echo $ticker_is_active ? '0' : '-1'; ?>">
                                    <?php echo esc_html($ticker_post_title); ?>
                                </a>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <div class="blogar-news-highlight-ticker-item is-active" aria-hidden="false">
                                <span class="blogar-news-highlight-ticker-text">
                                    <?php esc_html_e('Latest updates will appear here soon.', 'blogar'); ?>
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="blogar-news-highlight-grid">
                        <article class="blogar-news-highlight-card blogar-news-highlight-card-featured">
                            <div class="blogar-news-highlight-card-media">
                                <?php if ($news_highlight_big_post instanceof WP_Post):
                                    $highlight_big_id = $news_highlight_big_post->ID;
                                    $highlight_big_url = get_permalink($highlight_big_id);
                                    $highlight_big_title = get_the_title($highlight_big_id);
                                    $highlight_big_thumb_url = blogar_thumbnail_url($highlight_big_id, 'full');
                                    $highlight_big_thumb_alt = blogar_thumbnail_alt($highlight_big_id);
                                    $highlight_big_author_id = (int) get_post_field('post_author', $highlight_big_id);
                                    $highlight_big_author_name = get_the_author_meta('display_name', $highlight_big_author_id);
                                    $highlight_big_author_url = get_author_posts_url($highlight_big_author_id);
                                    $highlight_big_categories_all = get_the_category($highlight_big_id);
                                    $highlight_big_categories = !empty($highlight_big_categories_all) ? array_slice($highlight_big_categories_all, 0, 2) : array();
                                    ?>
                                <a href="<?php echo esc_url($highlight_big_url); ?>"
                                    class="blogar-news-highlight-card-image-link">
                                    <img loading="lazy" decoding="async"
                                        src="<?php echo esc_url($highlight_big_thumb_url); ?>"
                                        alt="<?php echo esc_attr($highlight_big_thumb_alt); ?>">
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
                                <?php if (!empty($highlight_big_categories)): ?>
                                <div class="blogar-news-highlight-card-cats">
                                    <?php foreach ($highlight_big_categories as $cat_index => $highlight_cat): ?>
                                    <?php echo blogar_hover_flip_link_html(get_category_link($highlight_cat->term_id), $highlight_cat->name, 'blogar-news-highlight-card-cat'); // phpcs:ignore ?>
                                    <?php if ($cat_index < count($highlight_big_categories) - 1): ?>
                                    <span class="blogar-news-highlight-card-cat-dot"></span>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>

                                <h2 class="title"><a href="<?php echo esc_url($highlight_big_url); ?>">
                                        <?php echo esc_html($highlight_big_title); ?>
                                    </a>
                                </h2>

                                <div class="blogar-news-highlight-card-meta">
                                    <span class="blogar-news-highlight-card-meta-item">
                                        <?php esc_html_e('by', 'blogar'); ?>
                                        <?php echo blogar_hover_flip_link_html($highlight_big_author_url, $highlight_big_author_name, 'blogar-news-highlight-card-author'); // phpcs:ignore ?>
                                    </span>
                                    <span class="blogar-news-highlight-card-meta-dot"></span>
                                    <time class="blogar-news-highlight-card-meta-item"
                                        datetime="<?php echo esc_attr(get_the_date('c', $highlight_big_id)); ?>">
                                        <?php echo esc_html(get_the_date('F j, Y', $highlight_big_id)); ?>
                                    </time>
                                </div>
                                <?php else: ?>
                                <h2 class="title">
                                    <?php esc_html_e('No featured post selected yet.', 'blogar'); ?>
                                </h2>
                                <?php endif; ?>
                            </div>
                        </article>

                        <div class="blogar-news-highlight-stack">
                            <?php foreach ($news_highlight_small_posts as $small_post): ?>
                            <article class="blogar-news-highlight-card blogar-news-highlight-card-small">
                                <div class="blogar-news-highlight-card-media">
                                    <?php if ($small_post instanceof WP_Post):
                                            $highlight_small_id = $small_post->ID;
                                            $highlight_small_url = get_permalink($highlight_small_id);
                                            $highlight_small_title = get_the_title($highlight_small_id);
                                            $highlight_small_thumb_url = blogar_thumbnail_url($highlight_small_id, 'full');
                                            $highlight_small_thumb_alt = blogar_thumbnail_alt($highlight_small_id);
                                            $highlight_small_author_id = (int) get_post_field('post_author', $highlight_small_id);
                                            $highlight_small_author_name = get_the_author_meta('display_name', $highlight_small_author_id);
                                            $highlight_small_author_url = get_author_posts_url($highlight_small_author_id);
                                            ?>
                                    <a href="<?php echo esc_url($highlight_small_url); ?>"
                                        class="blogar-news-highlight-card-image-link">
                                        <img loading="lazy" decoding="async"
                                            src="<?php echo esc_url($highlight_small_thumb_url); ?>"
                                            alt="<?php echo esc_attr($highlight_small_thumb_alt); ?>">
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
                                    <?php if ($small_post instanceof WP_Post): ?>
                                    <h3 class="title"><a href="<?php echo esc_url($highlight_small_url); ?>">
                                            <?php echo esc_html($highlight_small_title); ?>
                                        </a>
                                    </h3>
                                    <div class="blogar-news-highlight-card-meta">
                                        <span class="blogar-news-highlight-card-meta-item">
                                            <?php esc_html_e('by', 'blogar'); ?>
                                            <?php echo blogar_hover_flip_link_html($highlight_small_author_url, $highlight_small_author_name, 'blogar-news-highlight-card-author'); // phpcs:ignore ?>
                                        </span>
                                        <span class="blogar-news-highlight-card-meta-dot"></span>
                                        <time class="blogar-news-highlight-card-meta-item"
                                            datetime="<?php echo esc_attr(get_the_date('c', $highlight_small_id)); ?>">
                                            <?php echo esc_html(get_the_date('F j, Y', $highlight_small_id)); ?>
                                        </time>
                                    </div>
                                    <?php else: ?>
                                    <h3 class="title">
                                        <?php esc_html_e('No post available yet.', 'blogar'); ?>
                                    </h3>
                                    <?php endif; ?>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
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
                        <a class="axil-link-button" href="<?php echo esc_url($topics_data['archive_url']); ?>">
                            <?php esc_html_e('See All Topics', 'blogar'); ?>
                        </a>
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
                                            <h5 class="title">
                                                <?php echo blogar_hover_flip_text_html($cat['name'], 'blogar-card-flip-text blogar-card-flip-text--light'); // phpcs:ignore ?>
                                            </h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div><!-- .carousel-track -->
                    </div><!-- .carousel-viewport -->

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
                </div><!-- .list-categories -->
            </div><!-- .container -->
        </section>
        <?php endif; ?>

        <!-- ================================================================
     SECTION 13 — FEATURED GRID 2+3
     Layout: 2 equal top cards | 3 equal bottom cards
     Card style: full-bleed image + gradient + text centered bottom
     Dark header title bar — style riêng
     ================================================================ -->
        <?php
        $fvg2_posts = get_posts(array(
            'numberposts' => 5,
            'post_status' => 'publish',
            'meta_key' => '_thumbnail_id',
            'offset' => 5, // tránh trùng với section 12
        ));

        // Fallback nếu không đủ offset
        if (count($fvg2_posts) < 5) {
            $fvg2_posts = get_posts(array(
                'numberposts' => 5,
                'post_status' => 'publish',
                'meta_key' => '_thumbnail_id',
                'orderby' => 'rand',
            ));
        }
        ?>

        <?php if (!empty($fvg2_posts)): ?>
        <section class="axil-fvg2-area">

            <!-- ── Dark title bar ─────────────────────────────────── -->
            <div class="fvg2-header">
                <div class="container">
                    <h2 class="fvg2-header__title">
                        <?php esc_html_e('Featured Videos In This Week', 'blogar'); ?>
                    </h2>
                </div>
            </div>

            <!-- ── Grid ───────────────────────────────────────────── -->

            <div class="container">
                <div class="fvg2-grid">

                    <!-- Row 1: 2 equal top cards -->
                    <div class="fvg2-row fvg2-row--top">
                        <?php
                            $top_posts = array_slice($fvg2_posts, 0, 2);
                            foreach ($top_posts as $tp):
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

                            <div class="fvg2-card__thumb">
                                <img loading="lazy" decoding="async" src="<?php echo esc_url($tp_thumb); ?>"
                                    alt="<?php echo esc_attr($tp_alt); ?>">
                            </div>

                            <div class="fvg2-card__overlay" aria-hidden="true"></div>

                            <div class="fvg2-card__content">
                                <h3 class="fvg2-card__title">
                                    <span class="blogar-home-title-fill"><?php echo esc_html($tp_title); ?></span>
                                </h3>
                                <div class="fvg2-card__meta">
                                    <span class="fvg2-meta-by">
                                        <?php esc_html_e('by', 'blogar'); ?>
                                    </span>
                                    <?php echo blogar_hover_flip_text_html($tp_author, 'fvg2-meta-author blogar-card-flip-text blogar-card-flip-text--light'); // phpcs:ignore ?>
                                    <span class="fvg2-meta-dot" aria-hidden="true">•</span>
                                    <span class="fvg2-meta-date">
                                        <?php echo esc_html($tp_date); ?>
                                    </span>
                                </div>
                            </div>

                        </a>
                        <?php endforeach; ?>
                    </div><!-- .fvg2-row--top -->

                    <!-- Row 2: 3 equal bottom cards -->
                    <div class="fvg2-row fvg2-row--bottom">
                        <?php
                            $bot_posts = array_slice($fvg2_posts, 2, 3);
                            foreach ($bot_posts as $bp):
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

                            <div class="fvg2-card__thumb">
                                <img loading="lazy" decoding="async" src="<?php echo esc_url($bp_thumb); ?>"
                                    alt="<?php echo esc_attr($bp_alt); ?>">
                            </div>

                            <div class="fvg2-card__overlay" aria-hidden="true"></div>

                            <div class="fvg2-card__content">
                                <h4 class="fvg2-card__title">
                                    <span class="blogar-home-title-fill"><?php echo esc_html($bp_title); ?></span>
                                </h4>
                                <div class="fvg2-card__meta">
                                    <span class="fvg2-meta-by">
                                        <?php esc_html_e('by', 'blogar'); ?>
                                    </span>
                                    <?php echo blogar_hover_flip_text_html($bp_author, 'fvg2-meta-author blogar-card-flip-text blogar-card-flip-text--light'); // phpcs:ignore ?>
                                    <span class="fvg2-meta-dot" aria-hidden="true">•</span>
                                    <span class="fvg2-meta-date">
                                        <?php echo esc_html($bp_date); ?>
                                    </span>
                                </div>
                            </div>

                        </a>
                        <?php endforeach; ?>
                    </div><!-- .fvg2-row--bottom -->

                </div><!-- .fvg2-grid -->

            </div><!-- /.container -->
        </section>
        <?php endif; ?>


        <!-- ================================================================
     SECTION 14 — LATEST POSTS GRID
     Layout: 4 cols × 2 rows = 8 cards
     Card style: image top + content below (title, meta, button)
     Load More button centered
     ================================================================ -->
        <?php
        $lp_posts = get_posts(array(
            'numberposts' => 8,
            'post_status' => 'publish',
            'meta_key' => '_thumbnail_id',
            'orderby' => 'date',
            'order' => 'DESC',
        ));
        ?>

        <?php if (!empty($lp_posts)): ?>
        <section class="axil-latest-posts-area axil-section-gap bg-color-white">
            <div class="container">

                <!-- ── Section title ─────────────────────────────── -->
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
                        <span class="lp-title-text">
                            <?php esc_html_e('Latest Posts', 'blogar'); ?>
                        </span>
                    </div>
                </div>

                <!-- ── Grid ──────────────────────────────────────── -->
                <div class="lp-grid mt--30">
                    <?php foreach ($lp_posts as $lp):
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

                        <!-- Image -->
                        <div class="lp-card__thumb">
                            <a href="<?php echo esc_url($lp_url); ?>" tabindex="-1" aria-hidden="true">
                                <img loading="lazy" decoding="async" src="<?php echo esc_url($lp_thumb); ?>"
                                    alt="<?php echo esc_attr($lp_alt); ?>">
                            </a>
                        </div>

                        <!-- Content below image -->
                        <div class="lp-card__body">

                            <?php if ($lp_cats): ?>
                            <div class="lp-card__cat">
                                <?php echo blogar_hover_flip_link_html(get_category_link($lp_cats[0]->term_id), $lp_cats[0]->name, 'lp-card__cat-link'); // phpcs:ignore ?>
                            </div>
                            <?php endif; ?>

                            <h3 class="lp-card__title">
                                <a href="<?php echo esc_url($lp_url); ?>">
                                    <?php echo esc_html($lp_title); ?>
                                </a>
                            </h3>

                            <div class="lp-card__meta">
                                <span class="lp-meta-by"><?php esc_html_e('by', 'blogar'); ?></span>
                                <?php echo blogar_hover_flip_link_html($lp_aurl, $lp_author, 'lp-meta-author'); // phpcs:ignore ?>
                                <span class="lp-meta-dot" aria-hidden="true">•</span>
                                <span class="lp-meta-date">
                                    <?php echo esc_html($lp_date); ?>
                                </span>
                            </div>

                            <div class="lp-card__readmore">
                                <a href="<?php echo esc_url($lp_url); ?>" class="lp-readmore-btn">
                                    <?php esc_html_e('Read The Article', 'blogar'); ?>
                                </a>
                            </div>

                        </div><!-- .lp-card__body -->

                    </article><!-- .lp-card -->
                    <?php endforeach; ?>
                </div><!-- .lp-grid -->

                <!-- ── Load More ─────────────────────────────────── -->
                <div class="lp-loadmore mt--30">
                    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts')) ?: home_url('/')); ?>"
                        class="lp-loadmore-btn">
                        <span><?php esc_html_e('Load More Posts', 'blogar'); ?></span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"
                            width="14" height="14">
                            <polyline points="23 4 23 10 17 10" />
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                        </svg>
                    </a>
                </div>

            </div><!-- .container -->
        </section>
        <?php endif; ?>


        <!-- ================================================================
     SECTION 12 — FEATURED GRID THIS WEEK
     Layout: Big left | Right (medium top + 3 small bottom row)
     Card style: full-bleed image + gradient overlay + text bottom
     Query: 5 posts mới nhất có thumbnail
     ================================================================ -->
        <?php
        $fvg_posts = get_posts(array(
            'numberposts' => 5,
            'post_status' => 'publish',
            'meta_key' => '_thumbnail_id',
        ));

        $fvg_big = !empty($fvg_posts) ? $fvg_posts[0] : null;
        $fvg_medium = !empty($fvg_posts[1]) ? $fvg_posts[1] : null;
        $fvg_smalls = count($fvg_posts) > 2 ? array_slice($fvg_posts, 2, 3) : array();
        ?>

        <?php if ($fvg_big): ?>
        <section class="axil-featured-grid-area axil-section-gap bg-color-white">
            <div class="container">

                <div class="section-title text-left">
                    <h2 class="title"><?php esc_html_e('Featured Videos In This Week', 'blogar'); ?></h2>
                </div>

                <div class="fvg-grid mt--30">

                    <!-- ── BIG POST — LEFT ─────────────────────────── -->
                    <div class="fvg-left">
                        <?php
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

                            <div class="fvg-card-thumb">
                                <img loading="lazy" decoding="async" src="<?php echo esc_url($big_thumb); ?>"
                                    alt="<?php echo esc_attr($big_alt); ?>">
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
                    </div><!-- .fvg-left -->


                    <!-- ── RIGHT COLUMN ───────────────────────────── -->
                    <div class="fvg-right">

                        <!-- Medium post: right top -->
                        <?php if ($fvg_medium):
                                $med_id = $fvg_medium->ID;
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

                                <div class="fvg-card-thumb">
                                    <img loading="lazy" decoding="async" src="<?php echo esc_url($med_thumb); ?>"
                                        alt="<?php echo esc_attr($med_alt); ?>">
                                </div>

                                <div class="fvg-card-overlay" aria-hidden="true"></div>

                                <div class="fvg-card-content">
                                    <?php if ($med_cats): ?>
                                    <?php echo blogar_hover_flip_text_html($med_cats[0]->name, 'fvg-card-cat blogar-card-flip-text blogar-card-flip-text--badge'); // phpcs:ignore ?>
                                    <?php endif; ?>
                                    <h4 class="fvg-card-title"><span
                                            class="blogar-home-title-fill"><?php echo esc_html($med_title); ?></span></h4>
                                    <div class="fvg-card-meta">
                                        <span><?php echo esc_html($med_date); ?></span>
                                        <span class="fvg-dot" aria-hidden="true">·</span>
                                        <span><?php echo esc_html($med_read); ?></span>
                                    </div>
                                </div>

                            </a>
                        </div><!-- .fvg-right-top -->
                        <?php endif; ?>

                        <!-- 3 small posts: right bottom -->
                        <?php if (!empty($fvg_smalls)): ?>
                        <div class="fvg-right-bottom">
                            <?php foreach ($fvg_smalls as $sp):
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

                                <div class="fvg-card-thumb">
                                    <img loading="lazy" decoding="async" src="<?php echo esc_url($sp_thumb); ?>"
                                        alt="<?php echo esc_attr($sp_alt); ?>">
                                </div>

                                <div class="fvg-card-overlay" aria-hidden="true"></div>

                                <div class="fvg-card-content">
                                    <?php if ($sp_cats): ?>
                                    <?php echo blogar_hover_flip_text_html($sp_cats[0]->name, 'fvg-card-cat blogar-card-flip-text blogar-card-flip-text--badge'); // phpcs:ignore ?>
                                    <?php endif; ?>
                                    <h5 class="fvg-card-title"><span
                                            class="blogar-home-title-fill"><?php echo esc_html($sp_title); ?></span></h5>
                                    <div class="fvg-card-meta">
                                        <span><?php echo esc_html($sp_date); ?></span>
                                    </div>
                                </div>

                            </a>
                            <?php endforeach; ?>
                        </div><!-- .fvg-right-bottom -->
                        <?php endif; ?>

                    </div><!-- .fvg-right -->

                </div><!-- .fvg-grid -->
            </div><!-- .container -->
        </section>
        <?php endif; ?>




        <!-- ================================================================
     SECTION 4 — INNOVATION & TECH (tabs + carousel)
     v2: card redesigned — image top, excerpt + author row.
     CHỈ THAY THẾ ĐOẠN NÀY trong front-page.php, giữ nguyên các section khác.
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

                    <!-- Section header: title + optional subtitle -->
                    <div class="inno-section-head">
                        <div class="section-title text-left">
                            <h2 class="title"><?php echo esc_html($inno_data['title']); ?></h2>
                            <p class="inno-section-subtitle">
                                <?php esc_html_e('Explore the latest innovations and ideas shaping the world.', 'blogar'); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Tab buttons -->
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

                    <!-- Tab panels -->
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

                                                <!-- ── Image (top) ───────────── -->
                                                <div class="modern-card-thumb post-thumbnail">
                                                    <a href="<?php echo esc_url($post_url); ?>">
                                                        <img loading="lazy" decoding="async" width="390" height="260"
                                                            src="<?php echo esc_url($thumb_url); ?>"
                                                            alt="<?php echo esc_attr($thumb_alt); ?>">
                                                    </a>
                                                </div>

                                                <!-- ── Card body ─────────────── -->
                                                <div class="modern-card-body post-content">

                                                    <!-- Category -->
                                                    <div class="post-cat">
                                                        <div class="post-cat-list">
                                                            <?php echo blogar_post_categories_html($post_id, 1); // phpcs:ignore ?>
                                                        </div>
                                                    </div>

                                                    <!-- Title -->
                                                    <h4 class="title">
                                                        <a href="<?php echo esc_url($post_url); ?>">
                                                            <?php echo esc_html($post_title); ?>
                                                        </a>
                                                    </h4>

                                                    <!-- Excerpt -->
                                                    <?php if ($post_excerpt): ?>
                                                    <p class="modern-card-excerpt">
                                                        <?php echo esc_html($post_excerpt); ?>
                                                    </p>
                                                    <?php endif; ?>

                                                    <!-- Author + meta (pinned to bottom) -->
                                                    <div class="modern-card-meta">
                                                        <img class="modern-card-avatar"
                                                            src="<?php echo esc_url($author_avatar); ?>"
                                                            alt="<?php echo esc_attr($author_name); ?>" width="32"
                                                            height="32" loading="lazy">
                                                        <div class="modern-card-author-info">
                                                            <a class="hover-flip-item-wrapper modern-card-author-name"
                                                                href="<?php echo esc_url($author_url); ?>">
                                                                <span class="hover-flip-item">
                                                                    <span
                                                                        data-text="<?php echo esc_attr($author_name); ?>">
                                                                        <?php echo esc_html($author_name); ?>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                            <div class="modern-card-meta-sub">
                                                                <span><?php echo esc_html($post_date); ?></span>
                                                                <span class="meta-dot" aria-hidden="true">·</span>
                                                                <span><?php echo esc_html($read_time); ?></span>
                                                            </div>
                                                        </div>
                                                    </div><!-- .modern-card-meta -->

                                                </div><!-- .modern-card-body -->
                                            </div><!-- .content-block.modern-post-style -->
                                        </div><!-- .slick-single-layout -->

                                        <?php endwhile;
                                                wp_reset_postdata(); ?>

                                    </div><!-- .carousel-track -->
                                </div><!-- .carousel-viewport -->

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
                            </div><!-- .modern-post-activation -->

                        </div><!-- .single-tab-content -->
                        <?php endforeach; ?>
                    </div><!-- .tab-content -->

                </div><!-- .container -->
            </div><!-- .wrapper -->
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
                    <!-- Big blog-mode featured post -->
                    <?php if ($featured_video_data['big_post'] instanceof WP_Post):
                        $video_big_id = $featured_video_data['big_post']->ID;
                        $video_big_url = get_permalink($video_big_id);
                        $video_big_title = get_the_title($video_big_id);
                        $video_big_thumb_url = blogar_thumbnail_url($video_big_id, 'blogar-featured-video-big');
                        $video_big_thumb_alt = blogar_thumbnail_alt($video_big_id);
                        $video_big_author_id = (int) get_post_field('post_author', $video_big_id);
                        $video_big_author = get_the_author_meta('display_name', $video_big_author_id);
                        $video_big_author_url = get_author_posts_url($video_big_author_id);
                        $video_big_avatar = get_avatar_url($video_big_author_id, array('size' => 50));
                        $video_big_share_urls = blogar_social_share_urls($video_big_url, $video_big_title);
                        ?>
                    <div class="content-block post-default image-rounded mt--30 axil-big-post-image">
                        <div class="post-thumbnail">
                            <a href="<?php echo esc_url($video_big_url); ?>" class="video-post-link">
                                <img loading="lazy" decoding="async" width="600" height="500"
                                    src="<?php echo esc_url($video_big_thumb_url); ?>"
                                    alt="<?php echo esc_attr($video_big_thumb_alt); ?>">
                            </a>
                        </div>
                        <div class="post-content">
                            <div class="post-cat">
                                <div class="post-cat-list">
                                    <?php echo blogar_post_categories_html($video_big_id, 1); // phpcs:ignore ?>
                                </div>
                            </div>
                            <h4 class="title"><a
                                    href="<?php echo esc_url($video_big_url); ?>"><?php echo esc_html($video_big_title); ?></a>
                            </h4>
                            <div class="post-meta-wrapper">
                                <div class="post-meta">
                                    <div class="post-author-avatar border-rounded">
                                        <img alt="<?php echo esc_attr($video_big_author); ?>"
                                            src="<?php echo esc_url($video_big_avatar); ?>" width="50" height="50">
                                    </div>
                                    <div class="content">
                                        <h6 class="post-author-name">
                                            <a class="hover-flip-item-wrapper"
                                                href="<?php echo esc_url($video_big_author_url); ?>">
                                                <span class="hover-flip-item"><span
                                                        data-text="<?php echo esc_attr($video_big_author); ?>"><?php echo esc_html($video_big_author); ?></span></span>
                                            </a>
                                        </h6>
                                        <ul class="post-meta-list">
                                            <li class="post-meta-date">
                                                <?php echo esc_html(get_the_date('', $video_big_id)); ?>
                                            </li>
                                            <li class="post-meta-reading-time">
                                                <?php echo esc_html(blogar_reading_time($video_big_id)); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <ul class="social-share-transparent justify-content-end">
                                    <li><a href="<?php echo esc_url($video_big_share_urls['facebook']); ?>"
                                            target="_blank" rel="noopener nofollow"
                                            aria-label="Facebook"><?php echo $svg_fb; // phpcs:ignore ?></a></li>
                                    <li><a href="<?php echo esc_url($video_big_share_urls['twitter']); ?>"
                                            target="_blank" rel="noopener nofollow"
                                            aria-label="Twitter"><?php echo $svg_tw; // phpcs:ignore ?></a></li>
                                    <li><a href="<?php echo esc_url($video_big_share_urls['linkedin']); ?>"
                                            target="_blank" rel="noopener nofollow"
                                            aria-label="LinkedIn"><?php echo $svg_li; // phpcs:ignore ?></a></li>
                                    <li><button class="axilcopyLink" data-link="<?php echo esc_url($video_big_url); ?>"
                                            aria-label="Copy link"><?php echo $svg_lk; // phpcs:ignore ?></button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="content-block post-default image-rounded mt--30 axil-big-post-image">
                        <div class="post-thumbnail">
                            <a href="#" class="video-post-link">
                                <img loading="lazy" decoding="async" width="600" height="500"
                                    src="<?php echo esc_url(blogar_thumbnail_url(0, 'blogar-featured-video-big')); ?>"
                                    alt="<?php esc_attr_e('Placeholder image', 'blogar'); ?>">
                            </a>
                        </div>
                        <div class="post-content">
                            <h4 class="title"><?php esc_html_e('No featured post selected yet.', 'blogar'); ?></h4>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Small blog-mode posts (2x2 grid) -->
                    <div class="video-posts-right">
                        <?php foreach ($featured_video_data['small_posts'] as $video_small_post): ?>
                        <div class="content-block post-default image-rounded mt--30 axil-small-post-image">
                            <div class="post-thumbnail">
                                <?php if ($video_small_post instanceof WP_Post):
                                        $video_small_id = $video_small_post->ID;
                                        $video_small_url = get_permalink($video_small_id);
                                        $video_small_title = get_the_title($video_small_id);
                                        $video_small_thumb_url = blogar_thumbnail_url($video_small_id, 'blogar-video-small');
                                        $video_small_thumb_alt = blogar_thumbnail_alt($video_small_id);
                                        ?>
                                <a href="<?php echo esc_url($video_small_url); ?>" class="video-post-link">
                                    <img loading="lazy" decoding="async" width="285" height="190"
                                        src="<?php echo esc_url($video_small_thumb_url); ?>"
                                        alt="<?php echo esc_attr($video_small_thumb_alt); ?>">
                                </a>
                                <?php else: ?>
                                <a href="#" class="video-post-link">
                                    <img loading="lazy" decoding="async" width="285" height="190"
                                        src="<?php echo esc_url(blogar_thumbnail_url(0, 'blogar-video-small')); ?>"
                                        alt="<?php esc_attr_e('Placeholder image', 'blogar'); ?>">
                                </a>
                                <?php endif; ?>
                            </div>
                            <div class="post-content">
                                <div class="post-cat">
                                    <div class="post-cat-list">
                                        <?php
                                            if ($video_small_post instanceof WP_Post) {
                                                echo blogar_post_categories_html($video_small_post->ID, 1); // phpcs:ignore
                                            }
                                            ?>
                                    </div>
                                </div>
                                <?php if ($video_small_post instanceof WP_Post): ?>
                                <h5 class="title"><a
                                        href="<?php echo esc_url($video_small_url); ?>"><?php echo esc_html($video_small_title); ?></a>
                                </h5>
                                <?php else: ?>
                                <h5 class="title"><?php esc_html_e('No post selected yet.', 'blogar'); ?></h5>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div><!-- .video-posts-right -->
                </div><!-- .video-posts-grid -->
            </div><!-- .container -->
        </section>





    </div><!-- .main-wrapper -->
</div>




<?php get_footer(); ?>
