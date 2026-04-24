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

// ── Section render order ─────────────────────────────────────────
$_default_order = array('s11', 's11p', 's5', 's13', 's14', 's12', 's4', 's10', 's15', 's16', 's17', 's18', 's19', 's20');
$_raw_order = get_option('blogar_section_order', '');
$_section_order = (!empty($_raw_order)) ? (array) json_decode($_raw_order, true) : array();
$_normalized_order = array();

foreach ($_section_order as $_section_key) {
    if (in_array($_section_key, $_default_order, true) && !in_array($_section_key, $_normalized_order, true)) {
        $_normalized_order[] = $_section_key;
    }
}

foreach ($_default_order as $_section_key) {
    if (!in_array($_section_key, $_normalized_order, true)) {
        $_normalized_order[] = $_section_key;
    }
}

$_section_order = !empty($_normalized_order) ? $_normalized_order : $_default_order;
$_sections = array();
?>

<?php ob_start(); ?>
<!-- ================================================================
             SECTION 11 — NEWS HIGHLIGHT BLOCK
             ================================================================ -->
<?php if (get_option('blogar_s11_enabled', '1')): ?>
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
                        <button type="button" class="blogar-news-highlight-control blogar-news-highlight-ticker-prev"
                            aria-label="<?php esc_attr_e('Previous headline', 'blogar'); ?>">
                            <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true">
                                <path d="M15 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </button>
                        <button type="button" class="blogar-news-highlight-control blogar-news-highlight-ticker-next"
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
                        <h2 class="title"><a
                                href="<?php echo esc_url($hb_url); ?>"><?php echo esc_html($hb_title); ?></a>
                        </h2>
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
                        <h2 class="title"><?php esc_html_e('No featured post selected yet.', 'blogar'); ?></h2>
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
                            <a href="<?php echo esc_url($hs_url); ?>" class="blogar-news-highlight-card-image-link">
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
<?php endif; // s11_enabled ?>
<?php $_sections['s11'] = ob_get_clean();
ob_start(); ?>

<!-- ================================================================
     SECTION s11p — PENCI FEATURED LAYOUT (faithful Penci clone)
     3-col: hero 50% | big-grid+trending 25% | big-grid+small-list 25%
     ================================================================ -->
<?php if (get_option('blogar_s11p_enabled', '1')): ?>
<?php
    $d11p = blogar_get_s11p_data();
    $s11p_slider = isset($d11p['slider']) ? $d11p['slider'] : array();
    $s11p_mid1 = $d11p['mid1'];
    $s11p_mid2 = $d11p['mid2'];
    $s11p_left_small = isset($d11p['left_small']) ? $d11p['left_small'] : array();
    $s11p_right_small = isset($d11p['right_small']) ? $d11p['right_small'] : array();
    $s11p_trend = $d11p['trending'];
    $s11p_tlabel = $d11p['trending_label'];
    ?>
<section class="blogar-s11p">
    <div class="container">
        <div class="pc-row">

            <!-- ══ LEFT 50% — featured slider + 4 small cards (2-col) ══ -->
            <div class="pc-col pc-col-50">

                <div
                    class="penci-featured-content featured-area featured-style-1 vertical-align-bottom horizontal-align-center text-align-center">
                    <div class="penci-feat-slider" data-s11p-slider>
                        <?php if (count($s11p_slider) > 1): ?>
                        <button type="button" class="penci-feat-nav penci-feat-prev"
                            aria-label="<?php esc_attr_e('Previous featured post', 'blogar'); ?>">&#8249;</button>
                        <?php endif; ?>

                        <div class="penci-feat-slides" aria-live="polite">
                            <?php $s11p_slide_i = 0;
                                foreach ($s11p_slider as $sl):
                                    if (!$sl instanceof WP_Post)
                                        continue;
                                    $sl_id = $sl->ID;
                                    $sl_url = get_permalink($sl_id);
                                    $sl_ttl = get_the_title($sl_id);
                                    $sl_img = blogar_thumbnail_url($sl_id, 'blogar-hero');
                                    $sl_cats = array_slice(get_the_category($sl_id), 0, 1);
                                    $sl_aid = (int) get_post_field('post_author', $sl_id);
                                    $sl_name = get_the_author_meta('display_name', $sl_aid);
                                    $sl_aurl = get_author_posts_url($sl_aid);
                                    $sl_date = get_the_date('F j, Y', $sl_id);
                                    ?>
                            <div class="penci-feat-slide<?php echo $s11p_slide_i === 0 ? ' active' : ''; ?>"
                                aria-hidden="<?php echo $s11p_slide_i === 0 ? 'false' : 'true'; ?>"
                                <?php echo $s11p_slide_i === 0 ? '' : 'hidden'; ?>>
                                <div class="penci-image-holder"
                                    style="background-image:url(<?php echo esc_url($sl_img); ?>)">
                                    <div class="featured-slider-overlay"></div>
                                    <a class="penci-feat-link" href="<?php echo esc_url($sl_url); ?>"
                                        aria-label="<?php echo esc_attr($sl_ttl); ?>"></a>
                                    <div class="feat-text">
                                        <div class="feat-text-inner">
                                            <?php if ($sl_cats): ?>
                                            <div class="cat feat-cat featured-cat">
                                                <a
                                                    href="<?php echo esc_url(get_category_link($sl_cats[0]->term_id)); ?>">
                                                    <?php echo esc_html($sl_cats[0]->name); ?>
                                                </a>
                                            </div>
                                            <?php endif; ?>
                                            <div class="feat-text-box">
                                                <h3 class="feat-title">
                                                    <a
                                                        href="<?php echo esc_url($sl_url); ?>"><?php echo esc_html($sl_ttl); ?></a>
                                                </h3>
                                                <div class="feat-meta">
                                                    <span class="feat-author"><?php esc_html_e('by', 'blogar'); ?>
                                                        <a
                                                            href="<?php echo esc_url($sl_aurl); ?>"><?php echo esc_html($sl_name); ?></a>
                                                    </span>
                                                    <span class="feat-sep">&#8226;</span>
                                                    <time datetime="<?php echo esc_attr(get_the_date('c', $sl_id)); ?>">
                                                        <?php echo esc_html($sl_date); ?>
                                                    </time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $s11p_slide_i++; endforeach; ?>

                            <?php if (empty($s11p_slider)): ?>
                            <div class="penci-feat-slide active" aria-hidden="false">
                                <div class="penci-image-holder">
                                    <div class="featured-slider-overlay"></div>
                                    <div class="feat-text">
                                        <div class="feat-text-inner">
                                            <h3 class="feat-title">
                                                <?php esc_html_e('No featured post selected.', 'blogar'); ?>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div><!-- /penci-feat-slides -->

                        <?php if (count($s11p_slider) > 1): ?>
                        <button type="button" class="penci-feat-nav penci-feat-next"
                            aria-label="<?php esc_attr_e('Next featured post', 'blogar'); ?>">&#8250;</button>
                        <?php endif; ?>
                    </div><!-- /penci-feat-slider -->
                </div><!-- /penci-featured-content -->

                <!-- Small list: 4 posts, 2-col -->
                <?php if (!empty($s11p_left_small)): ?>
                <div class="pcsl-inner pcsl-2col">
                    <?php foreach ($s11p_left_small as $rc):
                                if (!$rc instanceof WP_Post)
                                    continue;
                                $rc_id = $rc->ID;
                                $rc_url = get_permalink($rc_id);
                                $rc_ttl = get_the_title($rc_id);
                                $rc_img = blogar_thumbnail_url($rc_id, 'blogar-featured');
                                $rc_alt = blogar_thumbnail_alt($rc_id);
                                $rc_aid = (int) get_post_field('post_author', $rc_id);
                                $rc_name = get_the_author_meta('display_name', $rc_aid);
                                $rc_aurl = get_author_posts_url($rc_aid);
                                ?>
                    <article class="pcsl-item">
                        <div class="pcsl-itemin">
                            <div class="pcsl-iteminer">
                                <div class="pcsl-thumb">
                                    <a href="<?php echo esc_url($rc_url); ?>">
                                        <img loading="lazy" decoding="async" src="<?php echo esc_url($rc_img); ?>"
                                            alt="<?php echo esc_attr($rc_alt); ?>">
                                    </a>
                                </div>
                                <div class="pcsl-content">
                                    <h3 class="pcsl-title">
                                        <a href="<?php echo esc_url($rc_url); ?>"><?php echo esc_html($rc_ttl); ?></a>
                                    </h3>
                                    <div class="pcsl-meta">
                                        <?php esc_html_e('by', 'blogar'); ?>
                                        <a href="<?php echo esc_url($rc_aurl); ?>"><?php echo esc_html($rc_name); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

            </div><!-- /pc-col-50 -->

            <!-- ══ MIDDLE 25% — big grid card + trending list ══ -->
            <div class="pc-col pc-col-25 pc-col-mid">

                <?php if ($s11p_mid1 instanceof WP_Post):
                        $m1_id = $s11p_mid1->ID;
                        $m1_url = get_permalink($m1_id);
                        $m1_ttl = get_the_title($m1_id);
                        $m1_img = blogar_thumbnail_url($m1_id, 'blogar-grid-big');
                        $m1_aid = (int) get_post_field('post_author', $m1_id);
                        $m1_name = get_the_author_meta('display_name', $m1_aid);
                        $m1_aurl = get_author_posts_url($m1_aid);
                        ?>
                <div class="pcbg-bgmain">
                    <div class="pcbg-thumb">
                        <div class="pcbg-thumbin">
                            <div class="penci-image-holder"
                                style="background-image:url(<?php echo esc_url($m1_img); ?>)">
                                <div class="pcbg-bgoverlay"></div>
                            </div>
                        </div>
                    </div>
                    <div class="pcbg-content pcbg-content-flex">
                        <a class="pcbg-link" href="<?php echo esc_url($m1_url); ?>"
                            aria-label="<?php echo esc_attr($m1_ttl); ?>"></a>
                        <div class="pcbg-content-inner bgcontent-block">
                            <div class="pcbg-heading item-hover">
                                <h3 class="pcbg-title">
                                    <a href="<?php echo esc_url($m1_url); ?>"><?php echo esc_html($m1_ttl); ?></a>
                                </h3>
                            </div>
                            <div class="pcbg-meta item-hover">
                                <?php esc_html_e('by', 'blogar'); ?>
                                <a href="<?php echo esc_url($m1_aurl); ?>"><?php echo esc_html($m1_name); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="pcbg-bgmain pcbg-empty"></div>
                <?php endif; ?>

                <!-- Trending list (no thumbnails) -->
                <div class="penci-trending-box">
                    <div class="penci-border-arrow style-7">
                        <h3 class="widget-title"><?php echo esc_html($s11p_tlabel); ?></h3>
                    </div>
                    <ul class="pcsl-nothumb">
                        <?php foreach ($s11p_trend as $tp):
                                if (!$tp instanceof WP_Post)
                                    continue;
                                ?>
                        <li>
                            <a href="<?php echo esc_url(get_permalink($tp->ID)); ?>">
                                <?php echo esc_html(get_the_title($tp->ID)); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div><!-- /pc-col-mid -->

            <!-- ══ RIGHT 25% — big grid card + 3 small cards (1-col) ══ -->
            <div class="pc-col pc-col-25 pc-col-right">

                <?php if ($s11p_mid2 instanceof WP_Post):
                        $m2_id = $s11p_mid2->ID;
                        $m2_url = get_permalink($m2_id);
                        $m2_ttl = get_the_title($m2_id);
                        $m2_img = blogar_thumbnail_url($m2_id, 'blogar-grid-big');
                        $m2_aid = (int) get_post_field('post_author', $m2_id);
                        $m2_name = get_the_author_meta('display_name', $m2_aid);
                        $m2_aurl = get_author_posts_url($m2_aid);
                        ?>
                <div class="pcbg-bgmain">
                    <div class="pcbg-thumb">
                        <div class="pcbg-thumbin">
                            <div class="penci-image-holder"
                                style="background-image:url(<?php echo esc_url($m2_img); ?>)">
                                <div class="pcbg-bgoverlay"></div>
                            </div>
                        </div>
                    </div>
                    <div class="pcbg-content pcbg-content-flex">
                        <a class="pcbg-link" href="<?php echo esc_url($m2_url); ?>"
                            aria-label="<?php echo esc_attr($m2_ttl); ?>"></a>
                        <div class="pcbg-content-inner bgcontent-block">
                            <div class="pcbg-heading item-hover">
                                <h3 class="pcbg-title">
                                    <a href="<?php echo esc_url($m2_url); ?>"><?php echo esc_html($m2_ttl); ?></a>
                                </h3>
                            </div>
                            <div class="pcbg-meta item-hover">
                                <?php esc_html_e('by', 'blogar'); ?>
                                <a href="<?php echo esc_url($m2_aurl); ?>"><?php echo esc_html($m2_name); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="pcbg-bgmain pcbg-empty"></div>
                <?php endif; ?>

                <!-- Small list: 3 posts, 1-col -->
                <?php if (!empty($s11p_right_small)): ?>
                <div class="pcsl-inner pcsl-1col">
                    <?php foreach ($s11p_right_small as $sc):
                                if (!$sc instanceof WP_Post)
                                    continue;
                                $sc_id = $sc->ID;
                                $sc_url = get_permalink($sc_id);
                                $sc_ttl = get_the_title($sc_id);
                                $sc_img = blogar_thumbnail_url($sc_id, 'blogar-featured');
                                $sc_alt = blogar_thumbnail_alt($sc_id);
                                $sc_aid = (int) get_post_field('post_author', $sc_id);
                                $sc_name = get_the_author_meta('display_name', $sc_aid);
                                $sc_aurl = get_author_posts_url($sc_aid);
                                ?>
                    <article class="pcsl-item">
                        <div class="pcsl-itemin">
                            <div class="pcsl-iteminer">
                                <div class="pcsl-thumb">
                                    <a href="<?php echo esc_url($sc_url); ?>">
                                        <img loading="lazy" decoding="async" src="<?php echo esc_url($sc_img); ?>"
                                            alt="<?php echo esc_attr($sc_alt); ?>">
                                    </a>
                                </div>
                                <div class="pcsl-content">
                                    <h3 class="pcsl-title">
                                        <a href="<?php echo esc_url($sc_url); ?>"><?php echo esc_html($sc_ttl); ?></a>
                                    </h3>
                                    <div class="pcsl-meta">
                                        <?php esc_html_e('by', 'blogar'); ?>
                                        <a href="<?php echo esc_url($sc_aurl); ?>"><?php echo esc_html($sc_name); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

            </div><!-- /pc-col-right -->

        </div><!-- /pc-row -->
    </div><!-- /container -->
</section>
<?php endif; // s11p_enabled ?>
<?php $_sections['s11p'] = ob_get_clean();
ob_start(); ?>

<!-- ================================================================
             SECTION 5 — TRENDING TOPICS (categories carousel)
             ================================================================ -->
<?php if (get_option('blogar_s5_enabled', '1')): ?>
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
<?php endif; // s5_enabled ?>
<?php $_sections['s5'] = ob_get_clean();
ob_start(); ?>

<?php if (get_option('blogar_s13_enabled', '1')): ?>
<?php $fvg2_data = blogar_get_featured_grid_2plus3_data(); ?>
<?php if (!empty($fvg2_data['top_posts']) || !empty($fvg2_data['bottom_posts'])): ?>
<section class="axil-fvg2-area">
    <div class="container">

        <div class="fvg2-section-title">
            <span class="fvg2-section-line" aria-hidden="true"></span>
            <div class="fvg2-title-inner lp-title-inner">
                <span class="fvg2-title-icon lp-title-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                    </svg>
                </span>
                <h2 class="fvg2-title-text lp-title-text"><?php echo esc_html($fvg2_data['title']); ?></h2>
            </div>
            <span class="fvg2-section-line" aria-hidden="true"></span>
        </div>

        <div class="fvg2-grid mt--30">

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
                        <div class=" fvg2-card__meta">
                            <span class="fvg2-meta-by"><?php esc_html_e('by', 'blogar'); ?></span>
                            <?php echo blogar_hover_flip_text_html($tp_author, 'fvg2-meta-author blogar-card-flip-text blogar-card-flip-text--light'); // phpcs:ignore ?>
                            <span class=" fvg2-meta-dot" aria-hidden="true">•</span>
                            <span class="fvg2-meta-date"><?php echo esc_html($tp_date); ?></span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Bottom row: 3 equal cards -->
            <div class=" fvg2-row fvg2-row--bottom">
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
                        <div class=" fvg2-card__meta">
                            <span class="fvg2-meta-by"><?php esc_html_e('by', 'blogar'); ?></span>
                            <?php echo blogar_hover_flip_text_html($bp_author, 'fvg2-meta-author blogar-card-flip-text blogar-card-flip-text--light'); // phpcs:ignore ?>
                            <span class=" fvg2-meta-dot" aria-hidden="true">•</span>
                            <span class="fvg2-meta-date"><?php echo esc_html($bp_date); ?></span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
    </div>
</section>
<?php endif; ?>
<?php endif; // s13_enabled ?>
<?php $_sections['s13'] = ob_get_clean();
ob_start(); ?>

<!-- ================================================================
             SECTION 14 — LATEST POSTS GRID
             ================================================================ -->
<?php if (get_option('blogar_s14_enabled', '1')): ?>
<?php $lp_data = blogar_get_latest_posts_data(); ?>
<?php if (!empty($lp_data['posts'])): ?>
<section class=" axil-latest-posts-area axil-section-gap bg-color-white">
    <div class="container">

        <div class="lp-section-title">
            <div class="lp-title-inner">
                <span class="lp-title-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
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

        <div class=" lp-grid mt--30">
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
                        <span class=" lp-meta-dot" aria-hidden="true">•</span>
                        <span class="lp-meta-date"><?php echo esc_html($lp_date); ?></span>
                    </div>
                    <div class=" lp-card__readmore">
                        <a href="<?php echo esc_url($lp_url); ?>"
                            class="lp-readmore-btn"><?php esc_html_e('Read The Article', 'blogar'); ?></a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <div class="lp-loadmore mt--30">
            <a href="<?php echo esc_url($lp_data['more_url']); ?>" class="lp-loadmore-btn">
                <span><?php esc_html_e('Load More Posts', 'blogar'); ?>
                </span>
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
<?php endif; // s14_enabled ?>
<?php $_sections['s14'] = ob_get_clean();
ob_start(); ?>

<!-- ================================================================
             SECTION 12 — FEATURED GRID THIS WEEK (asymmetric fvg)
             ================================================================ -->
<?php if (get_option('blogar_s12_enabled', '1')): ?>
<?php $fvg_data = blogar_get_featured_grid_this_week_data(); ?>
<?php if ($fvg_data['big'] instanceof WP_Post): ?>
<section class="axil-featured-grid-area axil-section-gap bg-color-white">
    <div class="container">

        <div class="fvg-section-title">
            <span class="fvg-section-line" aria-hidden="true"></span>
            <div class="fvg-title-inner lp-title-inner">
                <span class="fvg-title-icon lp-title-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                </span>
                <h2 class="fvg-title-text lp-title-text"><?php echo esc_html($fvg_data['title']); ?></h2>
            </div>
            <span class="fvg-section-line" aria-hidden="true"></span>
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
                        <div class=" fvg-card-meta">
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
                                src="<?php echo esc_url($med_thumb); ?>" alt="<?php echo esc_attr($med_alt); ?>"></div>
                        <div class="fvg-card-overlay" aria-hidden="true"></div>
                        <div class="fvg-card-content">
                            <?php if ($med_cats): ?>
                            <?php echo blogar_hover_flip_text_html($med_cats[0]->name, 'fvg-card-cat blogar-card-flip-text blogar-card-flip-text--badge'); // phpcs:ignore ?>
                            <?php endif; ?>
                            <h3 class="fvg-card-title"><span
                                    class="blogar-home-title-fill"><?php echo esc_html($med_title); ?></span>
                            </h3>
                            <div class=" fvg-card-meta">
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
                            <div class=" fvg-card-meta"><span><?php echo esc_html($sp_date); ?></span>
                            </div>
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
<?php endif; // s12_enabled ?>
<?php $_sections['s12'] = ob_get_clean();
ob_start(); ?>

<!-- ================================================================
             SECTION 4 — INNOVATION & TECH (tabs + carousel)
             ================================================================ -->
<?php if (get_option('blogar_s4_enabled', '1')): ?>
<?php
    $inno_data = blogar_get_innovation_data();
    $inno_tabs = $inno_data['tabs'];
    $inno_first = true;
    ?>
<?php if (!empty($inno_tabs)): ?>
<section class="axil-tab-area axil-section-gap bg-color-white">
    <div class="wrapper">
        <div class="container">

            <div class="fvg-section-title">
                <span class="fvg-section-line" aria-hidden="true"></span>
                <div class="fvg-title-inner lp-title-inner">
                    <span class="lp-title-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                        </svg>
                    </span>
                    <h2 class="lp-title-text"><?php echo esc_html($inno_data['title']); ?></h2>
                </div>
                <span class="fvg-section-line" aria-hidden="true"></span>
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

                                <?php foreach ($tab['posts'] as $post):
                                                setup_postdata($post);
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
                                                <?php echo esc_html($post_excerpt); ?>
                                            </p>

                                            <?php endif; ?>
                                            <div class="modern-card-meta">
                                                <img class="modern-card-avatar"
                                                    src="<?php echo esc_url($author_avatar); ?>"
                                                    alt="<?php echo esc_attr($author_name); ?>" width="32" height="32"
                                                    loading="lazy">
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
                                <?php endforeach;
                                            wp_reset_postdata(); ?>

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

                </div><?php endforeach; ?>
            </div>

        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; // s4_enabled ?>
<?php $_sections['s4'] = ob_get_clean();
ob_start(); ?>

<!-- ================================================================
             SECTION 10 — FEATURED VIDEO
             ================================================================ -->
<?php if (get_option('blogar_s10_enabled', '1')): ?>
<?php $featured_video_data = blogar_get_featured_video_data(); ?>
<section class="axil-video-post-area axil-section-gap bg-color-black">
    <div class="container">
        <div class="fvg-section-title">
            <span class="fvg-section-line" aria-hidden="true"></span>
            <div class="fvg-title-inner lp-title-inner">
                <span class="lp-title-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polygon points="23 7 16 12 23 17 23 7" />
                        <rect x="1" y="5" width="15" height="14" rx="2" ry="2" />
                    </svg>
                </span>
                <h2 class="lp-title-text"><?php echo esc_html($featured_video_data['title']); ?></h2>
            </div>
            <span class="fvg-section-line" aria-hidden="true"></span>
        </div>

        <div class=" video-posts-grid">
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
                            src="<?php echo esc_url($vb_thumb_url); ?>" alt="<?php echo esc_attr($vb_thumb_alt); ?>">
                    </a>
                </div>
                <div class="post-content">
                    <div class="post-cat">
                        <div class="post-cat-list">
                            <?php echo blogar_post_categories_html($vb_id, 1); // phpcs:ignore ?>
                        </div>
                    </div>
                    <h3 class="title"><a href="<?php echo esc_url($vb_url); ?>"><?php echo esc_html($vb_title); ?></a>
                    </h3>
                    <div class="post-meta-wrapper">
                        <div class="post-meta">
                            <div class="post-author-avatar border-rounded">
                                <img alt="<?php echo esc_attr($vb_author); ?>" src="<?php echo esc_url($vb_avatar); ?>"
                                    width="50" height="50">
                            </div>
                            <div class="content">
                                <p class="post-author-name">
                                    <a class="hover-flip-item-wrapper" href="<?php echo esc_url($vb_author_url); ?>">
                                        <span class="hover-flip-item"><span
                                                data-text="<?php echo esc_attr($vb_author); ?>"><?php echo esc_html($vb_author); ?></span></span>
                                    </a>
                                </p>
                                <ul class="post-meta-list">
                                    <li class="post-meta-date"><?php echo esc_html(get_the_date('', $vb_id)); ?>
                                    </li>
                                    <li class=" post-meta-reading-time">
                                        <?php echo esc_html(blogar_reading_time($vb_id)); ?>
                                    </li>
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
                    <a href="#" class="video-post-link"><img loading="lazy" decoding="async" width="600" height="500"
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
                                height="190" src="<?php echo esc_url(blogar_thumbnail_url(0, 'blogar-video-small')); ?>"
                                alt="<?php esc_attr_e('Placeholder image', 'blogar'); ?>"></a>
                        <?php endif; ?>
                    </div>
                    <div class="post-content">
                        <div class="post-cat">
                            <div class="post-cat-list"><?php if ($vs instanceof WP_Post)
                                        echo blogar_post_categories_html($vs->ID, 1); // phpcs:ignore ?></div>
                        </div>
                        <?php if ($vs instanceof WP_Post): ?>
                        <h3 class=" title"><a
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
<?php endif; // s10_enabled ?>
<?php $_sections['s10'] = ob_get_clean(); ?>

<?php ob_start(); ?>
<?php if (get_option('blogar_s15_enabled', '1')): ?>
<?php
    /**
     * BLOGAR S15 — Entertainment Category Slider
     * Template block for front-page.php
     * Source block: elementor-element-184c1d6 > penci-small-list widget 242bb3e
     *
     * Note: Soledad also reuses penci-structure-10 for a banner section elsewhere.
     * This block is the Entertainment tabs grid, not that banner.
     */

    $s15_data = blogar_get_s15_data();
    $s15_legacy_opts = get_option('blogar_s15_settings', array());

    $s15_title = trim((string) get_option('blogar_s15_title', ''));
    if ($s15_title === '') {
        $s15_title = !empty($s15_legacy_opts['title']) ? $s15_legacy_opts['title'] : __('Entertainment', 'blogar');
    }

    $s15_parent_cat_id = isset($s15_data['parent_cat_id']) ? (int) $s15_data['parent_cat_id'] : 0;
    $s15_default_link = home_url('/');
    if ($s15_parent_cat_id) {
        $s15_term_link = get_category_link($s15_parent_cat_id);
        if (!is_wp_error($s15_term_link)) {
            $s15_default_link = $s15_term_link;
        }
    }

    $s15_link = trim((string) get_option('blogar_s15_link', ''));
    if ($s15_link === '' && !empty($s15_legacy_opts['cat_link'])) {
        $s15_link = $s15_legacy_opts['cat_link'];
    }
    if ($s15_link === '') {
        $s15_link = $s15_default_link;
    }
    $s15_cats = isset($s15_data['cats']) ? $s15_data['cats'] : array();
    $s15_posts = isset($s15_data['posts']) ? $s15_data['posts'] : array();
    $s15_ppp = 4;
    $s15_show_all_tab = (bool) get_option('blogar_s15_show_all_tab', 1);

    $s15_placeholder_cards = array(
        array(
            'title' => __('Entertainment headline placeholder', 'blogar'),
            'author' => __('Blogar Editorial', 'blogar'),
            'url' => '#',
            'author_url' => '#',
            'img_style' => 'background-image:linear-gradient(135deg,#e5eefc 0%,#dbeafe 50%,#f8fafc 100%)',
        ),
        array(
            'title' => __('Category slider fallback card', 'blogar'),
            'author' => __('Blogar Editorial', 'blogar'),
            'url' => '#',
            'author_url' => '#',
            'img_style' => 'background-image:linear-gradient(135deg,#f5efe6 0%,#fef3c7 52%,#fff7ed 100%)',
        ),
        array(
            'title' => __('Homepage section stays visible even when posts are empty', 'blogar'),
            'author' => __('Blogar Editorial', 'blogar'),
            'url' => '#',
            'author_url' => '#',
            'img_style' => 'background-image:linear-gradient(135deg,#ede9fe 0%,#e9d5ff 52%,#faf5ff 100%)',
        ),
        array(
            'title' => __('Replace these placeholders by assigning a category in Blogar Settings', 'blogar'),
            'author' => __('Blogar Editorial', 'blogar'),
            'url' => admin_url('admin.php?page=blogar-homepage-settings&tab=s15_category_slider'),
            'author_url' => admin_url('admin.php?page=blogar-homepage-settings&tab=s15_category_slider'),
            'img_style' => 'background-image:linear-gradient(135deg,#e2f7f0 0%,#ccfbf1 52%,#f0fdfa 100%)',
        ),
    );

    if (empty($s15_posts['all'])) {
        $s15_posts = array(
            'all' => $s15_placeholder_cards,
        );
        $s15_cats = array();
    }

    // Remove "All" group when the tab is hidden so we don't render unused slides
    if (!$s15_show_all_tab) {
        unset($s15_posts['all']);
    }

    // Determine which cat is active on load
    $s15_first_cat = $s15_show_all_tab ? 'all' : (string) (isset($s15_cats[0]['id']) ? $s15_cats[0]['id'] : 'all');

    $s15_normalize_item = static function ($item) {
        if ($item instanceof WP_Post) {
            $item_id = $item->ID;
            $img_url = get_the_post_thumbnail_url($item_id, 'penci-thumb');
            if (!$img_url) {
                $img_url = get_the_post_thumbnail_url($item_id, 'large');
            }

            $author_id = (int) $item->post_author;

            return array(
                'title' => get_the_title($item_id),
                'url' => get_permalink($item_id),
                'author_name' => get_the_author_meta('display_name', $author_id),
                'author_url' => get_author_posts_url($author_id),
                'img_style' => $img_url ? 'background-image:url(' . esc_url($img_url) . ')' : '',
                'is_placeholder' => false,
            );
        }

        if (is_array($item)) {
            return array(
                'title' => !empty($item['title']) ? $item['title'] : __('Sample post', 'blogar'),
                'url' => !empty($item['url']) ? $item['url'] : '#',
                'author_name' => !empty($item['author']) ? $item['author'] : __('Blogar Editorial', 'blogar'),
                'author_url' => !empty($item['author_url']) ? $item['author_url'] : '#',
                'img_style' => !empty($item['img_style']) ? $item['img_style'] : '',
                'is_placeholder' => true,
            );
        }

        return null;
    };
    ?>
<section class="blogar-section blogar-s15" data-section="s15"
    data-initial-cat="<?php echo esc_attr($s15_first_cat); ?>">
    <div class="blogar-s15-inner">

        <!-- ── Header: style-12 ── -->
        <div class="blogar-s15-header">
            <h2 class="s15-title-label">
                <a href="<?php echo esc_url($s15_link); ?>">
                    <?php echo esc_html($s15_title); ?>
                </a>
            </h2>

            <nav class="blogar-s15-nav" aria-label="<?php esc_attr_e('Filter posts', 'blogar'); ?>">

                <!-- Category filter tabs -->
                <ul class="s15-cat-list" role="tablist" aria-label="<?php esc_attr_e('Category filters', 'blogar'); ?>">
                    <?php if ($s15_show_all_tab): ?>
                    <li>
                        <button type="button" class="s15-tab s15-active" data-cat="all" role="tab" aria-selected="true"
                            aria-label="<?php esc_attr_e('All', 'blogar'); ?>">
                            <?php esc_html_e('All', 'blogar'); ?>
                        </button>
                    </li>
                    <?php endif; ?>
                    <?php foreach ($s15_cats as $cat_index => $cat): ?>
                    <li>
                        <button type="button"
                            class="s15-tab<?php echo (!$s15_show_all_tab && $cat_index === 0) ? ' s15-active' : ''; ?>"
                            data-cat="<?php echo esc_attr($cat['id']); ?>" role="tab"
                            aria-selected="<?php echo (!$s15_show_all_tab && $cat_index === 0) ? 'true' : 'false'; ?>"
                            aria-label="<?php echo esc_attr($cat['name']); ?>">
                            <?php echo esc_html($cat['name']); ?>
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Prev / Next -->
                <ul class="s15-pager">
                    <li class="s15-prev-wrap">
                        <button type="button" class="s15-btn-prev s15-btn-disable"
                            aria-label="<?php esc_attr_e('Previous', 'blogar'); ?>" aria-disabled="true" disabled>
                            <svg class="s15-icon" width="7" height="11" viewBox="0 0 7 11" fill="none"
                                aria-hidden="true" focusable="false">
                                <path d="M6 10L1 5.5L6 1" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </li>
                    <li class="s15-next-wrap">
                        <button type="button" class="s15-btn-next" aria-label="<?php esc_attr_e('Next', 'blogar'); ?>"
                            aria-disabled="false">
                            <svg class="s15-icon" width="7" height="11" viewBox="0 0 7 11" fill="none"
                                aria-hidden="true" focusable="false">
                                <path d="M1 10L6 5.5L1 1" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </li>
                </ul>

            </nav>
        </div><!-- /.blogar-s15-header -->

        <!-- ── Slides: grouped per category ── -->
        <div class="blogar-s15-slides" aria-live="polite">

            <?php foreach ($s15_posts as $cat_id => $cat_posts):
                    // Split posts into groups of 4 (slides)
                    $slides = array_chunk($cat_posts, $s15_ppp);
                    foreach ($slides as $slide_index => $slide_posts):
                        $is_first = ($cat_id === $s15_first_cat && $slide_index === 0);
                        $active_cls = $is_first ? ' s15-slide-active' : '';
                        ?>
            <div class="blogar-s15-slide<?php echo $active_cls; ?>" data-cat="<?php echo esc_attr($cat_id); ?>"
                data-slide="<?php echo (int) $slide_index; ?>" aria-hidden="<?php echo $is_first ? 'false' : 'true'; ?>"
                <?php echo $is_first ? '' : 'hidden'; ?>>

                <div class="s15-grid">

                    <?php foreach ($slide_posts as $slide_item):
                                    $card = $s15_normalize_item($slide_item);
                                    if (!$card) {
                                        continue;
                                    }
                                    ?>
                    <div class="s15-item">
                        <div class="s15-item-inner">
                            <div class="s15-item-wrap">

                                <!-- Thumbnail -->
                                <div class="s15-thumb">
                                    <a href="<?php echo esc_url($card['url']); ?>"
                                        class="s15-img<?php echo !empty($card['is_placeholder']) ? ' s15-placeholder-img' : ''; ?>"
                                        style="<?php echo esc_attr($card['img_style']); ?>"
                                        title="<?php echo esc_attr($card['title']); ?>"
                                        aria-label="<?php echo esc_attr($card['title']); ?>"></a>
                                </div>

                                <!-- Content -->
                                <div class="s15-content">
                                    <h3 class="s15-post-title">
                                        <a href="<?php echo esc_url($card['url']); ?>"
                                            title="<?php echo esc_attr($card['title']); ?>">
                                            <?php echo esc_html($card['title']); ?>
                                        </a>
                                    </h3>
                                    <div class="s15-meta">
                                        <span class="s15-author">
                                            <?php esc_html_e('by', 'blogar'); ?>
                                            <a href="<?php echo esc_url($card['author_url']); ?>" class="author-url">
                                                <?php echo esc_html($card['author_name']); ?>
                                            </a>
                                        </span>
                                    </div>
                                </div>

                            </div><!-- /.s15-item-wrap -->
                        </div><!-- /.s15-item-inner -->
                    </div><!-- /.s15-item -->
                    <?php endforeach; ?>

                </div><!-- /.s15-grid -->
            </div><!-- /.blogar-s15-slide -->
            <?php endforeach; endforeach; ?>

        </div><!-- /.blogar-s15-slides -->

    </div>
</section>
<?php endif; ?>
<?php $_sections['s15'] = ob_get_clean(); ?>

<?php ob_start(); ?>
<?php if (get_option('blogar_s16_enabled', '1')): ?>
<?php
    /**
     * BLOGAR S16 — Money Category Grid Slider
     * Template block for front-page.php
     * Source: elementor-element-b65f622 / penci-small-list widget 345687c
     *
     * Layout: 4 cols × 3 rows = 12 posts per slide (imgpos-left, thumb 104px × 80%ar)
     * Nav: style-12 title badge + category tabs + prev/next chevrons
     */

    $s16_data = blogar_get_s16_data();

    $s16_title = trim((string) get_option('blogar_s16_title', ''));
    if ($s16_title === '') {
        $s16_title = __('Money', 'blogar');
    }

    $s16_parent_cat_id = isset($s16_data['parent_cat_id']) ? (int) $s16_data['parent_cat_id'] : 0;
    $s16_default_link = home_url('/');
    if ($s16_parent_cat_id) {
        $s16_term_link = get_category_link($s16_parent_cat_id);
        if (!is_wp_error($s16_term_link)) {
            $s16_default_link = $s16_term_link;
        }
    }

    $s16_link = trim((string) get_option('blogar_s16_link', ''));
    if ($s16_link === '') {
        $s16_link = $s16_default_link;
    }

    $s16_cats = isset($s16_data['cats']) ? $s16_data['cats'] : array();
    $s16_posts = isset($s16_data['posts']) ? $s16_data['posts'] : array();
    $s16_ppp = 12; // 4 cols × 3 rows per slide

    $s16_show_all_tab = (bool) get_option('blogar_s16_show_all_tab', 1);

    // Placeholder cards shown when no posts configured yet
    $s16_placeholder_cards = array();
    for ($i = 0; $i < 12; $i++) {
        $s16_placeholder_cards[] = array(
            'title' => __('Post title placeholder — configure a category in Blogar Settings', 'blogar'),
            'author' => __('Blogar Editorial', 'blogar'),
            'url' => admin_url('admin.php?page=blogar-homepage-settings&tab=s16_category_slider'),
            'author_url' => admin_url('admin.php?page=blogar-homepage-settings&tab=s16_category_slider'),
            'img_style' => 'background-image:linear-gradient(135deg,#eef2f7 0%,#e5edf6 52%,#f8fafc 100%)',
        );
    }

    if (empty($s16_posts['all'])) {
        $s16_posts = array('all' => $s16_placeholder_cards);
        $s16_cats = array();
    }

    if (!$s16_show_all_tab) {
        unset($s16_posts['all']);
    }

    $s16_first_cat = $s16_show_all_tab ? 'all' : (string) (isset($s16_cats[0]['id']) ? $s16_cats[0]['id'] : 'all');

    $s16_normalize_item = static function ($item) {
        if ($item instanceof WP_Post) {
            $item_id = $item->ID;
            $img_url = get_the_post_thumbnail_url($item_id, 'medium');
            if (!$img_url) {
                $img_url = get_the_post_thumbnail_url($item_id, 'large');
            }
            $author_id = (int) $item->post_author;
            return array(
                'title' => get_the_title($item_id),
                'url' => get_permalink($item_id),
                'author_name' => get_the_author_meta('display_name', $author_id),
                'author_url' => get_author_posts_url($author_id),
                'img_style' => $img_url ? 'background-image:url(' . esc_url($img_url) . ')' : '',
                'is_placeholder' => false,
            );
        }
        if (is_array($item)) {
            return array(
                'title' => !empty($item['title']) ? $item['title'] : __('Sample post', 'blogar'),
                'url' => !empty($item['url']) ? $item['url'] : '#',
                'author_name' => !empty($item['author']) ? $item['author'] : __('Blogar Editorial', 'blogar'),
                'author_url' => !empty($item['author_url']) ? $item['author_url'] : '#',
                'img_style' => !empty($item['img_style']) ? $item['img_style'] : '',
                'is_placeholder' => true,
            );
        }
        return null;
    };
    ?>
<section class="blogar-section blogar-s16" data-section="s16"
    data-initial-cat="<?php echo esc_attr($s16_first_cat); ?>">
    <div class="blogar-s16-inner">

        <!-- ── Header: style-12 badge ── -->
        <div class="blogar-s16-header">
            <h2 class="s16-title-label">
                <a href="<?php echo esc_url($s16_link); ?>">
                    <?php echo esc_html($s16_title); ?>
                </a>
            </h2>

            <nav class="blogar-s16-nav" aria-label="<?php esc_attr_e('Filter posts', 'blogar'); ?>">

                <!-- Category filter tabs -->
                <ul class="s16-cat-list" role="tablist" aria-label="<?php esc_attr_e('Category filters', 'blogar'); ?>">
                    <?php if ($s16_show_all_tab): ?>
                    <li>
                        <button type="button" class="s16-tab s16-active" data-cat="all" role="tab" aria-selected="true"
                            aria-label="<?php esc_attr_e('All', 'blogar'); ?>">
                            <?php esc_html_e('All', 'blogar'); ?>
                        </button>
                    </li>
                    <?php endif; ?>
                    <?php foreach ($s16_cats as $s16_cat_index => $s16_cat): ?>
                    <li>
                        <button type="button"
                            class="s16-tab<?php echo (!$s16_show_all_tab && $s16_cat_index === 0) ? ' s16-active' : ''; ?>"
                            data-cat="<?php echo esc_attr($s16_cat['id']); ?>" role="tab"
                            aria-selected="<?php echo (!$s16_show_all_tab && $s16_cat_index === 0) ? 'true' : 'false'; ?>"
                            aria-label="<?php echo esc_attr($s16_cat['name']); ?>">
                            <?php echo esc_html($s16_cat['name']); ?>
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Prev / Next -->
                <ul class="s16-pager">
                    <li>
                        <button type="button" class="s16-btn-prev s16-btn-disable"
                            aria-label="<?php esc_attr_e('Previous', 'blogar'); ?>" aria-disabled="true" disabled>
                            <svg class="s16-icon" width="7" height="11" viewBox="0 0 7 11" fill="none"
                                aria-hidden="true" focusable="false">
                                <path d="M6 10L1 5.5L6 1" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="s16-btn-next" aria-label="<?php esc_attr_e('Next', 'blogar'); ?>"
                            aria-disabled="false">
                            <svg class="s16-icon" width="7" height="11" viewBox="0 0 7 11" fill="none"
                                aria-hidden="true" focusable="false">
                                <path d="M1 10L6 5.5L1 1" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </li>
                </ul>

            </nav>
        </div><!-- /.blogar-s16-header -->

        <!-- ── Slides: each slide = 12 posts (4×3 grid) ── -->
        <div class="blogar-s16-slides" aria-live="polite">

            <?php foreach ($s16_posts as $s16_cat_id => $s16_cat_posts):
                    $s16_slides = array_chunk($s16_cat_posts, $s16_ppp);
                    foreach ($s16_slides as $s16_slide_idx => $s16_slide_posts):
                        $s16_is_first = ($s16_cat_id === $s16_first_cat && $s16_slide_idx === 0);
                        $s16_slide_cls = $s16_is_first ? ' s16-slide-active' : '';
                        ?>
            <div class="blogar-s16-slide<?php echo $s16_slide_cls; ?>" data-cat="<?php echo esc_attr($s16_cat_id); ?>"
                data-slide="<?php echo (int) $s16_slide_idx; ?>"
                aria-hidden="<?php echo $s16_is_first ? 'false' : 'true'; ?>"
                <?php echo $s16_is_first ? '' : 'hidden'; ?>>

                <div class="s16-grid">

                    <?php foreach ($s16_slide_posts as $s16_item):
                                    $s16_card = $s16_normalize_item($s16_item);
                                    if (!$s16_card) {
                                        continue;
                                    }
                                    ?>
                    <div class="s16-item">
                        <div class="s16-itemin">
                            <div class="s16-iteminer">

                                <!-- Thumbnail: 104px × 80% aspect ratio -->
                                <div class="s16-thumb">
                                    <a href="<?php echo esc_url($s16_card['url']); ?>" class="s16-img"
                                        style="<?php echo esc_attr($s16_card['img_style']); ?>"
                                        title="<?php echo esc_attr($s16_card['title']); ?>"
                                        aria-label="<?php echo esc_attr($s16_card['title']); ?>" tabindex="-1"></a>
                                </div>

                                <!-- Content: title + author meta -->
                                <div class="s16-content">
                                    <div class="s16-post-title">
                                        <a href="<?php echo esc_url($s16_card['url']); ?>"
                                            title="<?php echo esc_attr($s16_card['title']); ?>">
                                            <?php echo esc_html($s16_card['title']); ?>
                                        </a>
                                    </div>
                                    <div class="s16-meta">
                                        <?php esc_html_e('by', 'blogar'); ?>
                                        <a href="<?php echo esc_url($s16_card['author_url']); ?>"
                                            class="s16-author-link">
                                            <?php echo esc_html($s16_card['author_name']); ?>
                                        </a>
                                    </div>
                                </div>

                            </div><!-- /.s16-iteminer -->
                        </div><!-- /.s16-itemin -->
                    </div><!-- /.s16-item -->
                    <?php endforeach; ?>

                </div><!-- /.s16-grid -->
            </div><!-- /.blogar-s16-slide -->
            <?php endforeach; endforeach; ?>

        </div><!-- /.blogar-s16-slides -->

    </div><!-- /.blogar-s16-inner -->
</section>
<?php endif; ?>
<?php $_sections['s16'] = ob_get_clean(); ?>

<?php ob_start(); ?>
<?php if (get_option('blogar_s17_enabled', '1')): ?>
<?php
    /**
     * BLOGAR S17 — Editor's Picks Mixed Layout
     * Template block for front-page.php
     * Source: elementor-element-c971b65 + elementor-element-02d4f33
     *
     * Layout: 4 equal cols per slide — 8 posts total (1 + 3 + 3 + 1)
     *   Col 1 (feat): post[0]       — img-top, 3:2 ratio
     *   Col 2 (mini): posts[1..3]   — img-left, 88px thumb
     *   Col 3 (mini): posts[4..6]   — img-left, 88px thumb
     *   Col 4 (feat): post[7]       — img-top, 3:2 ratio
     * Nav: style-12 title badge + category tabs + prev/next chevrons
     */

    $s17_data = blogar_get_s17_data();

    $s17_title = trim((string) get_option('blogar_s17_title', ''));
    if ($s17_title === '') {
        $s17_title = __("Editor's Picks", 'blogar');
    }

    $s17_parent_cat_id = isset($s17_data['parent_cat_id']) ? (int) $s17_data['parent_cat_id'] : 0;
    $s17_default_link = home_url('/');
    if ($s17_parent_cat_id) {
        $s17_term_link = get_category_link($s17_parent_cat_id);
        if (!is_wp_error($s17_term_link)) {
            $s17_default_link = $s17_term_link;
        }
    }

    $s17_link = trim((string) get_option('blogar_s17_link', ''));
    if ($s17_link === '') {
        $s17_link = $s17_default_link;
    }

    $s17_cats = isset($s17_data['cats']) ? $s17_data['cats'] : array();
    $s17_posts = isset($s17_data['posts']) ? $s17_data['posts'] : array();

    $s17_show_all_tab = (bool) get_option('blogar_s17_show_all_tab', 1);

    $s17_settings_url = add_query_arg(
        array(
            'page' => 'blogar-settings',
            'tab' => 's17_editors_picks',
        ),
        admin_url('themes.php')
    );

    // Placeholder cards shown when no posts configured yet
    $s17_placeholder_cards = array();
    for ($i = 0; $i < 8; $i++) {
        $s17_placeholder_cards[] = array(
            'title' => __('Post title placeholder — configure a category in Blogar Settings', 'blogar'),
            'author' => __('Blogar Editorial', 'blogar'),
            'url' => $s17_settings_url,
            'author_url' => $s17_settings_url,
            'img_style' => 'background-image:linear-gradient(135deg,#eef2f7 0%,#e5edf6 52%,#f8fafc 100%)',
        );
    }

    if (empty($s17_posts['all'])) {
        $s17_posts = array('all' => $s17_placeholder_cards);
        $s17_cats = array();
    }

    if (!$s17_show_all_tab) {
        unset($s17_posts['all']);
    }

    if (empty($s17_posts)) {
        $s17_posts = array('all' => $s17_placeholder_cards);
        $s17_show_all_tab = true;
    }

    $s17_available_cat_ids = array_map('strval', array_keys($s17_posts));
    $s17_cats = array_values(array_filter($s17_cats, static function ($cat) use ($s17_available_cat_ids) {
        return isset($cat['id']) && in_array((string) $cat['id'], $s17_available_cat_ids, true);
    }));

    $s17_first_cat = 'all';
    if ($s17_show_all_tab && isset($s17_posts['all'])) {
        $s17_first_cat = 'all';
    } elseif (!empty($s17_cats[0]['id'])) {
        $s17_first_cat = (string) $s17_cats[0]['id'];
    } else {
        $s17_post_keys = array_keys($s17_posts);
        if (!empty($s17_post_keys)) {
            $s17_first_cat = (string) reset($s17_post_keys);
        }
    }

    $s17_normalize_item = static function ($item) {
        if ($item instanceof WP_Post) {
            $item_id = $item->ID;
            $img_url = get_the_post_thumbnail_url($item_id, 'blogar-card');
            if (!$img_url) {
                $img_url = get_the_post_thumbnail_url($item_id, 'large');
            }
            $author_id = (int) $item->post_author;
            return array(
                'title' => get_the_title($item_id),
                'url' => get_permalink($item_id),
                'author_name' => get_the_author_meta('display_name', $author_id),
                'author_url' => get_author_posts_url($author_id),
                'img_style' => $img_url ? 'background-image:url(' . esc_url($img_url) . ')' : '',
                'is_placeholder' => false,
            );
        }
        if (is_array($item)) {
            return array(
                'title' => !empty($item['title']) ? $item['title'] : __('Sample post', 'blogar'),
                'url' => !empty($item['url']) ? $item['url'] : '#',
                'author_name' => !empty($item['author']) ? $item['author'] : __('Blogar Editorial', 'blogar'),
                'author_url' => !empty($item['author_url']) ? $item['author_url'] : '#',
                'img_style' => !empty($item['img_style']) ? $item['img_style'] : '',
                'is_placeholder' => true,
            );
        }
        return null;
    };

    $s17_split_middle_posts = static function ($items) {
        $left_count = (int) ceil(count($items) / 2);
        return array(
            array_slice($items, 0, $left_count),
            array_slice($items, $left_count),
        );
    };
    ?>
<section class="blogar-section blogar-s17" data-section="s17"
    data-initial-cat="<?php echo esc_attr($s17_first_cat); ?>">
    <div class="blogar-s17-inner">

        <!-- ── Header: style-12 badge ── -->
        <div class="blogar-s17-header">
            <h2 class="s17-title-label">
                <a href="<?php echo esc_url($s17_link); ?>">
                    <?php echo esc_html($s17_title); ?>
                </a>
            </h2>

            <nav class="blogar-s17-nav" aria-label="<?php esc_attr_e('Filter posts', 'blogar'); ?>">

                <!-- Category filter tabs -->
                <ul class="s17-cat-list" role="tablist" aria-label="<?php esc_attr_e('Category filters', 'blogar'); ?>">
                    <?php if ($s17_show_all_tab): ?>
                    <li>
                        <button type="button" class="s17-tab s17-active" data-cat="all" role="tab" aria-selected="true"
                            aria-label="<?php esc_attr_e('All', 'blogar'); ?>">
                            <?php esc_html_e('All', 'blogar'); ?>
                        </button>
                    </li>
                    <?php endif; ?>
                    <?php foreach ($s17_cats as $s17_cat_index => $s17_cat): ?>
                    <li>
                        <button type="button"
                            class="s17-tab<?php echo (!$s17_show_all_tab && $s17_cat_index === 0) ? ' s17-active' : ''; ?>"
                            data-cat="<?php echo esc_attr($s17_cat['id']); ?>" role="tab"
                            aria-selected="<?php echo (!$s17_show_all_tab && $s17_cat_index === 0) ? 'true' : 'false'; ?>"
                            aria-label="<?php echo esc_attr($s17_cat['name']); ?>">
                            <?php echo esc_html($s17_cat['name']); ?>
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div><!-- /.blogar-s17-header -->

        <!-- ── Slides: each slide = 8 posts (1 feat + 3 mini + 3 mini + 1 feat) ── -->
        <div class="blogar-s17-slides" aria-live="polite">

            <?php foreach ($s17_posts as $s17_cat_id => $s17_cat_posts):
                    $s17_normalized = array();
                    foreach ($s17_cat_posts as $_raw_post) {
                        $n = $s17_normalize_item($_raw_post);
                        if ($n) {
                            $s17_normalized[] = $n;
                        }
                    }
                    if (empty($s17_normalized)) {
                        continue;
                    }

                    $s17_is_first = ((string) $s17_cat_id === $s17_first_cat);
                    $s17_slide_cls = $s17_is_first ? ' s17-slide-active' : '';

                    // Keep the original reading order: first left, last right,
                    // and split everything in between across the middle columns.
                    $s17_feat1 = $s17_normalized[0];
                    $s17_feat4 = count($s17_normalized) > 1 ? $s17_normalized[count($s17_normalized) - 1] : null;
                    $s17_middle_all = count($s17_normalized) > 2 ? array_slice($s17_normalized, 1, -1) : array();
                    list($s17_middle_left, $s17_middle_right) = $s17_split_middle_posts($s17_middle_all);
                    $s17_left_list_class = 's17-mini-list' . (count($s17_middle_left) > 3 ? ' s17-mini-list-variable' : '');
                    $s17_right_list_class = 's17-mini-list' . (count($s17_middle_right) > 3 ? ' s17-mini-list-variable' : '');
                    ?>
            <div class="blogar-s17-slide<?php echo $s17_slide_cls; ?>" data-cat="<?php echo esc_attr($s17_cat_id); ?>"
                aria-hidden="<?php echo $s17_is_first ? 'false' : 'true'; ?>"
                <?php echo $s17_is_first ? '' : 'hidden'; ?>>

                <div class="s17-columns">

                    <!-- Col 1: Featured post -->
                    <div class="s17-col s17-col-feat">
                        <?php if ($s17_feat1): ?>
                        <article class="s17-feat-post">
                            <div class="s17-feat-img-wrap"<?php echo !empty($s17_feat1['img_style']) ? ' data-has-img="true"' : ''; ?>>
                                <a href="<?php echo esc_url($s17_feat1['url']); ?>" class="s17-feat-img"
                                    style="<?php echo esc_attr($s17_feat1['img_style']); ?>"
                                    title="<?php echo esc_attr($s17_feat1['title']); ?>"
                                    aria-label="<?php echo esc_attr($s17_feat1['title']); ?>" tabindex="-1"></a>
                            </div>
                            <div class="s17-feat-content">
                                <h3 class="s17-feat-title">
                                    <a href="<?php echo esc_url($s17_feat1['url']); ?>"
                                        title="<?php echo esc_attr($s17_feat1['title']); ?>">
                                        <?php echo esc_html($s17_feat1['title']); ?>
                                    </a>
                                </h3>
                                <div class="s17-feat-meta">
                                    <?php esc_html_e('by', 'blogar'); ?>
                                    <a href="<?php echo esc_url($s17_feat1['author_url']); ?>">
                                        <?php echo esc_html($s17_feat1['author_name']); ?>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <?php endif; ?>
                    </div>

                    <!-- Col 2: First half of middle posts -->
                    <div class="s17-col s17-col-mini">
                        <div class="<?php echo esc_attr($s17_left_list_class); ?>">
                            <?php foreach ($s17_middle_left as $s17_mini): ?>
                            <article class="s17-mini-item">
                                <div class="s17-mini-inner">
                                    <div class="s17-mini-thumb">
                                        <a href="<?php echo esc_url($s17_mini['url']); ?>" class="s17-mini-img"
                                            style="<?php echo esc_attr($s17_mini['img_style']); ?>"
                                            title="<?php echo esc_attr($s17_mini['title']); ?>"
                                            aria-label="<?php echo esc_attr($s17_mini['title']); ?>" tabindex="-1"></a>
                                    </div>
                                    <div class="s17-mini-content">
                                        <div class="s17-mini-title">
                                            <a href="<?php echo esc_url($s17_mini['url']); ?>"
                                                title="<?php echo esc_attr($s17_mini['title']); ?>">
                                                <?php echo esc_html($s17_mini['title']); ?>
                                            </a>
                                        </div>
                                        <div class="s17-mini-meta">
                                            <?php esc_html_e('by', 'blogar'); ?>
                                            <a href="<?php echo esc_url($s17_mini['author_url']); ?>">
                                                <?php echo esc_html($s17_mini['author_name']); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Col 3: Second half of middle posts -->
                    <div class="s17-col s17-col-mini">
                        <div class="<?php echo esc_attr($s17_right_list_class); ?>">
                            <?php foreach ($s17_middle_right as $s17_mini): ?>
                            <article class="s17-mini-item">
                                <div class="s17-mini-inner">
                                    <div class="s17-mini-thumb">
                                        <a href="<?php echo esc_url($s17_mini['url']); ?>" class="s17-mini-img"
                                            style="<?php echo esc_attr($s17_mini['img_style']); ?>"
                                            title="<?php echo esc_attr($s17_mini['title']); ?>"
                                            aria-label="<?php echo esc_attr($s17_mini['title']); ?>" tabindex="-1"></a>
                                    </div>
                                    <div class="s17-mini-content">
                                        <div class="s17-mini-title">
                                            <a href="<?php echo esc_url($s17_mini['url']); ?>"
                                                title="<?php echo esc_attr($s17_mini['title']); ?>">
                                                <?php echo esc_html($s17_mini['title']); ?>
                                            </a>
                                        </div>
                                        <div class="s17-mini-meta">
                                            <?php esc_html_e('by', 'blogar'); ?>
                                            <a href="<?php echo esc_url($s17_mini['author_url']); ?>">
                                                <?php echo esc_html($s17_mini['author_name']); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Col 4: Last post -->
                    <div class="s17-col s17-col-feat">
                        <?php if ($s17_feat4): ?>
                        <article class="s17-feat-post">
                            <div class="s17-feat-img-wrap"<?php echo !empty($s17_feat4['img_style']) ? ' data-has-img="true"' : ''; ?>>
                                <a href="<?php echo esc_url($s17_feat4['url']); ?>" class="s17-feat-img"
                                    style="<?php echo esc_attr($s17_feat4['img_style']); ?>"
                                    title="<?php echo esc_attr($s17_feat4['title']); ?>"
                                    aria-label="<?php echo esc_attr($s17_feat4['title']); ?>" tabindex="-1"></a>
                            </div>
                            <div class="s17-feat-content">
                                <h3 class="s17-feat-title">
                                    <a href="<?php echo esc_url($s17_feat4['url']); ?>"
                                        title="<?php echo esc_attr($s17_feat4['title']); ?>">
                                        <?php echo esc_html($s17_feat4['title']); ?>
                                    </a>
                                </h3>
                                <div class="s17-feat-meta">
                                    <?php esc_html_e('by', 'blogar'); ?>
                                    <a href="<?php echo esc_url($s17_feat4['author_url']); ?>">
                                        <?php echo esc_html($s17_feat4['author_name']); ?>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <?php endif; ?>
                    </div>

                </div><!-- /.s17-columns -->
            </div><!-- /.blogar-s17-slide -->
            <?php endforeach; ?>

        </div><!-- /.blogar-s17-slides -->

    </div><!-- /.blogar-s17-inner -->
</section>
<?php endif; ?>
<?php $_sections['s17'] = ob_get_clean(); ?>

<?php ob_start(); ?>
<?php if (get_option('blogar_s18_enabled', '1')): ?>
<?php
    /**
     * BLOGAR S18 - Life Style News Mixed Layout
     * Template block for front-page.php
     * Source: elementor-element-02c6eb5 / penci-structure-32
     *
     * Layout: 4 columns by reading order, 12 posts total
     *   Left 50%:  posts[0..3]   -> 2x2 featured grid
     *   Mid 25%:   posts[4..9]   -> 6 horizontal mini cards
     *   Right 25%: posts[10..11] -> 2 stacked featured cards
     * Nav: style-12 title badge + category tabs (static panel switch, no pager)
     */

    $s18_data = blogar_get_s18_data();

    $s18_title = trim((string) get_option('blogar_s18_title', ''));
    if ($s18_title === '') {
        $s18_title = __('Life Style News', 'blogar');
    }

    $s18_parent_cat_id = isset($s18_data['parent_cat_id']) ? (int) $s18_data['parent_cat_id'] : 0;
    $s18_default_link = home_url('/');
    if ($s18_parent_cat_id) {
        $s18_term_link = get_category_link($s18_parent_cat_id);
        if (!is_wp_error($s18_term_link)) {
            $s18_default_link = $s18_term_link;
        }
    }

    $s18_link = trim((string) get_option('blogar_s18_link', ''));
    if ($s18_link === '') {
        $s18_link = $s18_default_link;
    }

    $s18_cats = isset($s18_data['cats']) ? $s18_data['cats'] : array();
    $s18_posts = isset($s18_data['posts']) ? $s18_data['posts'] : array();
    $s18_show_all_tab = (bool) get_option('blogar_s18_show_all_tab', 1);

    $s18_settings_url = add_query_arg(
        array(
            'page' => 'blogar-settings',
            'tab' => 's18_life_style_news',
        ),
        admin_url('themes.php')
    );

    $s18_placeholder_cards = array();
    for ($i = 0; $i < 12; $i++) {
        $hue = $i % 4;
        $gradients = array(
            'linear-gradient(135deg,#eef2f7 0%,#e5edf6 52%,#f8fafc 100%)',
            'linear-gradient(135deg,#fdf2f8 0%,#fce7f3 52%,#fff1f2 100%)',
            'linear-gradient(135deg,#fef3c7 0%,#fde68a 52%,#fffbeb 100%)',
            'linear-gradient(135deg,#dcfce7 0%,#bbf7d0 52%,#f0fdf4 100%)',
        );
        $s18_placeholder_cards[] = array(
            'title' => __('Post title placeholder - configure categories in Blogar Settings', 'blogar'),
            'author' => __('Blogar Editorial', 'blogar'),
            'url' => $s18_settings_url,
            'author_url' => $s18_settings_url,
            'img_style' => 'background-image:' . $gradients[$hue],
        );
    }

    if (empty($s18_posts['all'])) {
        $s18_posts = array('all' => $s18_placeholder_cards);
        $s18_cats = array();
    }

    if (!$s18_show_all_tab) {
        unset($s18_posts['all']);
    }

    if (empty($s18_posts)) {
        $s18_posts = array('all' => $s18_placeholder_cards);
        $s18_show_all_tab = true;
    }

    $s18_available_cat_ids = array_map('strval', array_keys($s18_posts));
    $s18_cats = array_values(array_filter($s18_cats, static function ($cat) use ($s18_available_cat_ids) {
        return isset($cat['id']) && in_array((string) $cat['id'], $s18_available_cat_ids, true);
    }));

    $s18_first_cat = 'all';
    if ($s18_show_all_tab && isset($s18_posts['all'])) {
        $s18_first_cat = 'all';
    } elseif (!empty($s18_cats[0]['id'])) {
        $s18_first_cat = (string) $s18_cats[0]['id'];
    } else {
        $s18_post_keys = array_keys($s18_posts);
        if (!empty($s18_post_keys)) {
            $s18_first_cat = (string) reset($s18_post_keys);
        }
    }

    $s18_normalize_item = static function ($item) {
        if ($item instanceof WP_Post) {
            $item_id = $item->ID;
            $img_url = get_the_post_thumbnail_url($item_id, 'penci-masonry-thumb');
            if (!$img_url) {
                $img_url = get_the_post_thumbnail_url($item_id, 'large');
            }
            $author_id = (int) $item->post_author;
            return array(
                'title' => get_the_title($item_id),
                'url' => get_permalink($item_id),
                'author_name' => get_the_author_meta('display_name', $author_id),
                'author_url' => get_author_posts_url($author_id),
                'img_style' => $img_url ? 'background-image:url(' . esc_url($img_url) . ')' : '',
                'is_placeholder' => false,
            );
        }
        if (is_array($item)) {
            return array(
                'title' => !empty($item['title']) ? $item['title'] : __('Sample post', 'blogar'),
                'url' => !empty($item['url']) ? $item['url'] : '#',
                'author_name' => !empty($item['author']) ? $item['author'] : __('Blogar Editorial', 'blogar'),
                'author_url' => !empty($item['author_url']) ? $item['author_url'] : '#',
                'img_style' => !empty($item['img_style']) ? $item['img_style'] : '',
                'is_placeholder' => true,
            );
        }
        return null;
    };
    ?>
<section class="blogar-section blogar-s18" data-section="s18"
    data-initial-cat="<?php echo esc_attr($s18_first_cat); ?>">
    <div class="blogar-s18-inner">

        <div class="blogar-s18-header">
            <h2 class="s18-title-label">
                <a href="<?php echo esc_url($s18_link); ?>">
                    <?php echo esc_html($s18_title); ?>
                </a>
            </h2>

            <nav class="blogar-s18-nav" aria-label="<?php esc_attr_e('Filter posts', 'blogar'); ?>">
                <ul class="s18-cat-list" role="tablist" aria-label="<?php esc_attr_e('Category filters', 'blogar'); ?>">
                    <?php if ($s18_show_all_tab): ?>
                    <li>
                        <button type="button" class="s18-tab s18-active" data-cat="all" role="tab" aria-selected="true"
                            aria-label="<?php esc_attr_e('All', 'blogar'); ?>">
                            <?php esc_html_e('All', 'blogar'); ?>
                        </button>
                    </li>
                    <?php endif; ?>
                    <?php foreach ($s18_cats as $s18_cat_index => $s18_cat): ?>
                    <li>
                        <button type="button"
                            class="s18-tab<?php echo (!$s18_show_all_tab && $s18_cat_index === 0) ? ' s18-active' : ''; ?>"
                            data-cat="<?php echo esc_attr($s18_cat['id']); ?>" role="tab"
                            aria-selected="<?php echo (!$s18_show_all_tab && $s18_cat_index === 0) ? 'true' : 'false'; ?>"
                            aria-label="<?php echo esc_attr($s18_cat['name']); ?>">
                            <?php echo esc_html($s18_cat['name']); ?>
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div><!-- /.blogar-s18-header -->

        <div class="blogar-s18-slides" aria-live="polite">
            <?php foreach ($s18_posts as $s18_cat_id => $s18_cat_posts):
                    $s18_normalized = array();
                    foreach ($s18_cat_posts as $_raw_post) {
                        $n = $s18_normalize_item($_raw_post);
                        if ($n) {
                            $s18_normalized[] = $n;
                        }
                    }
                    if (empty($s18_normalized)) {
                        continue;
                    }

                    $s18_is_first = ((string) $s18_cat_id === $s18_first_cat);
                    $s18_slide_cls = $s18_is_first ? ' s18-slide-active' : '';

                    $s18_left_posts   = array_slice($s18_normalized, 0, 4);
                    $s18_middle_posts = array_slice($s18_normalized, 4, 6);
                    $s18_right_posts  = array_slice($s18_normalized, 10, 2);
                    ?>
            <div class="blogar-s18-slide<?php echo $s18_slide_cls; ?>" data-cat="<?php echo esc_attr($s18_cat_id); ?>"
                aria-hidden="<?php echo $s18_is_first ? 'false' : 'true'; ?>"
                <?php echo $s18_is_first ? '' : 'hidden'; ?>>

                <div class="s18-columns">

                    <div class="s18-col s18-col-main">
                        <div class="s18-main-grid">
                            <?php foreach ($s18_left_posts as $s18_feat): ?>
                            <article class="s18-feature-card s18-feature-card-main">
                                <div class="s18-feature-img-wrap"<?php echo !empty($s18_feat['img_style']) ? ' data-has-img="true"' : ''; ?>>
                                    <a href="<?php echo esc_url($s18_feat['url']); ?>" class="s18-feature-img"
                                        style="<?php echo esc_attr($s18_feat['img_style']); ?>"
                                        title="<?php echo esc_attr($s18_feat['title']); ?>"
                                        aria-label="<?php echo esc_attr($s18_feat['title']); ?>" tabindex="-1"></a>
                                </div>
                                <div class="s18-feature-content">
                                    <h3 class="s18-feature-title">
                                        <a href="<?php echo esc_url($s18_feat['url']); ?>"
                                            title="<?php echo esc_attr($s18_feat['title']); ?>">
                                            <?php echo esc_html($s18_feat['title']); ?>
                                        </a>
                                    </h3>
                                    <div class="s18-feature-meta">
                                        <?php esc_html_e('by', 'blogar'); ?>
                                        <a href="<?php echo esc_url($s18_feat['author_url']); ?>">
                                            <?php echo esc_html($s18_feat['author_name']); ?>
                                        </a>
                                    </div>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="s18-col s18-col-list">
                        <div class="s18-mini-list">
                            <?php foreach ($s18_middle_posts as $s18_mini): ?>
                            <article class="s18-mini-item">
                                <div class="s18-mini-inner">
                                    <div class="s18-mini-thumb">
                                        <a href="<?php echo esc_url($s18_mini['url']); ?>" class="s18-mini-img"
                                            style="<?php echo esc_attr($s18_mini['img_style']); ?>"
                                            title="<?php echo esc_attr($s18_mini['title']); ?>"
                                            aria-label="<?php echo esc_attr($s18_mini['title']); ?>" tabindex="-1"></a>
                                    </div>
                                    <div class="s18-mini-content">
                                        <div class="s18-mini-title">
                                            <a href="<?php echo esc_url($s18_mini['url']); ?>"
                                                title="<?php echo esc_attr($s18_mini['title']); ?>">
                                                <?php echo esc_html($s18_mini['title']); ?>
                                            </a>
                                        </div>
                                        <div class="s18-mini-meta">
                                            <?php esc_html_e('by', 'blogar'); ?>
                                            <a href="<?php echo esc_url($s18_mini['author_url']); ?>">
                                                <?php echo esc_html($s18_mini['author_name']); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="s18-col s18-col-side">
                        <div class="s18-side-stack">
                            <?php foreach ($s18_right_posts as $s18_feat): ?>
                            <article class="s18-feature-card s18-feature-card-side">
                                <div class="s18-feature-img-wrap"<?php echo !empty($s18_feat['img_style']) ? ' data-has-img="true"' : ''; ?>>
                                    <a href="<?php echo esc_url($s18_feat['url']); ?>" class="s18-feature-img"
                                        style="<?php echo esc_attr($s18_feat['img_style']); ?>"
                                        title="<?php echo esc_attr($s18_feat['title']); ?>"
                                        aria-label="<?php echo esc_attr($s18_feat['title']); ?>" tabindex="-1"></a>
                                </div>
                                <div class="s18-feature-content">
                                    <h3 class="s18-feature-title">
                                        <a href="<?php echo esc_url($s18_feat['url']); ?>"
                                            title="<?php echo esc_attr($s18_feat['title']); ?>">
                                            <?php echo esc_html($s18_feat['title']); ?>
                                        </a>
                                    </h3>
                                    <div class="s18-feature-meta">
                                        <?php esc_html_e('by', 'blogar'); ?>
                                        <a href="<?php echo esc_url($s18_feat['author_url']); ?>">
                                            <?php echo esc_html($s18_feat['author_name']); ?>
                                        </a>
                                    </div>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div><!-- /.s18-columns -->
            </div><!-- /.blogar-s18-slide -->
            <?php endforeach; ?>
        </div><!-- /.blogar-s18-slides -->

    </div><!-- /.blogar-s18-inner -->
</section>
<?php endif; ?>
<?php $_sections['s18'] = ob_get_clean(); ?>

<?php ob_start(); ?>
<?php if (get_option('blogar_s19_enabled', '1')): ?>
<?php
    /**
     * BLOGAR S19 - Dual Featured Blocks
     * Template block for front-page.php
     * Source: elementor-element-929e262 / penci-structure-20
     *
     * Layout: 2 independent 50% blocks
     *   Each block = 1 featured horizontal post + 6 mini posts (2 cols × 3)
     * Nav: style-12 title badge + category tabs + prev/next pager
     */

    $s19_settings_url = add_query_arg(
        array(
            'page' => 'blogar-settings',
            'tab' => 's19_dual_featured_blocks',
        ),
        admin_url('themes.php')
    );

    $s19_build_placeholder_cards = static function ($settings_url, $block_title) {
        $cards = array();
        $date_text = wp_date(get_option('date_format'));
        $gradients = array(
            'linear-gradient(135deg,#eef2f7 0%,#e5edf6 52%,#f8fafc 100%)',
            'linear-gradient(135deg,#fdf2f8 0%,#fce7f3 52%,#fff1f2 100%)',
            'linear-gradient(135deg,#fef3c7 0%,#fde68a 52%,#fffbeb 100%)',
            'linear-gradient(135deg,#dcfce7 0%,#bbf7d0 52%,#f0fdf4 100%)',
        );

        for ($i = 0; $i < 14; $i++) {
            $cards[] = array(
                'title' => sprintf(__('Placeholder post %d for %s', 'blogar'), $i + 1, $block_title),
                'author' => __('Blogar Editorial', 'blogar'),
                'url' => $settings_url,
                'author_url' => $settings_url,
                'img_style' => 'background-image:' . $gradients[$i % count($gradients)],
                'date_text' => $date_text,
                'excerpt' => __('Assign categories in Blogar Settings to replace these fallback cards with live posts.', 'blogar'),
            );
        }

        return $cards;
    };

    $s19_prepare_block = static function ($side, $title_default, $data, $settings_url) use ($s19_build_placeholder_cards) {
        $prefix = 'blogar_s19_' . $side;

        $title = trim((string) get_option($prefix . '_title', ''));
        if ($title === '') {
            $title = $title_default;
        }

        $parent_cat_id = isset($data['parent_cat_id']) ? (int) $data['parent_cat_id'] : 0;
        $default_link = home_url('/');
        if ($parent_cat_id) {
            $term_link = get_category_link($parent_cat_id);
            if (!is_wp_error($term_link)) {
                $default_link = $term_link;
            }
        }

        $link = trim((string) get_option($prefix . '_link', ''));
        if ($link === '') {
            $link = $default_link;
        }

        $cats = isset($data['cats']) ? $data['cats'] : array();
        $posts = isset($data['posts']) ? $data['posts'] : array();
        $show_all_tab = (bool) get_option($prefix . '_show_all_tab', 1);

        $placeholder_cards = $s19_build_placeholder_cards($settings_url, $title);
        if (empty($posts['all'])) {
            $posts = array('all' => $placeholder_cards);
            $cats = array();
        }

        if (!$show_all_tab) {
            unset($posts['all']);
        }

        if (empty($posts)) {
            $posts = array('all' => $placeholder_cards);
            $show_all_tab = true;
        }

        $available_cat_ids = array_map('strval', array_keys($posts));
        $cats = array_values(array_filter($cats, static function ($cat) use ($available_cat_ids) {
            return isset($cat['id']) && in_array((string) $cat['id'], $available_cat_ids, true);
        }));

        $first_cat = 'all';
        if ($show_all_tab && isset($posts['all'])) {
            $first_cat = 'all';
        } elseif (!empty($cats[0]['id'])) {
            $first_cat = (string) $cats[0]['id'];
        } else {
            $post_keys = array_keys($posts);
            if (!empty($post_keys)) {
                $first_cat = (string) reset($post_keys);
            }
        }

        return array(
            'side' => $side,
            'title' => $title,
            'link' => $link,
            'cats' => $cats,
            'posts' => $posts,
            'show_all_tab' => $show_all_tab,
            'first_cat' => $first_cat,
        );
    };

    $s19_normalize_item = static function ($item) {
        if ($item instanceof WP_Post) {
            $item_id = $item->ID;
            $img_url = get_the_post_thumbnail_url($item_id, 'blogar-card');
            if (!$img_url) {
                $img_url = get_the_post_thumbnail_url($item_id, 'large');
            }

            $author_id = (int) $item->post_author;
            $excerpt_source = has_excerpt($item_id) ? get_the_excerpt($item_id) : wp_strip_all_tags($item->post_excerpt ? $item->post_excerpt : $item->post_content);

            return array(
                'title' => get_the_title($item_id),
                'url' => get_permalink($item_id),
                'author_name' => get_the_author_meta('display_name', $author_id),
                'author_url' => get_author_posts_url($author_id),
                'img_style' => $img_url ? 'background-image:url(' . esc_url($img_url) . ')' : '',
                'date_text' => get_the_date(get_option('date_format'), $item_id),
                'excerpt' => wp_trim_words($excerpt_source, 24, '...'),
                'is_placeholder' => false,
            );
        }

        if (is_array($item)) {
            return array(
                'title' => !empty($item['title']) ? $item['title'] : __('Sample post', 'blogar'),
                'url' => !empty($item['url']) ? $item['url'] : '#',
                'author_name' => !empty($item['author']) ? $item['author'] : __('Blogar Editorial', 'blogar'),
                'author_url' => !empty($item['author_url']) ? $item['author_url'] : '#',
                'img_style' => !empty($item['img_style']) ? $item['img_style'] : '',
                'date_text' => !empty($item['date_text']) ? $item['date_text'] : wp_date(get_option('date_format')),
                'excerpt' => !empty($item['excerpt']) ? $item['excerpt'] : __('Section preview content appears here until categories are assigned.', 'blogar'),
                'is_placeholder' => true,
            );
        }

        return null;
    };

    $s19_blocks = array(
        'left' => $s19_prepare_block('left', __('Esports News', 'blogar'), blogar_get_s19_block_data('left'), $s19_settings_url),
        'right' => $s19_prepare_block('right', __('Movie Update', 'blogar'), blogar_get_s19_block_data('right'), $s19_settings_url),
    );
    ?>
<section class="blogar-section blogar-s19" data-section="s19">
    <div class="blogar-s19-inner">
        <div class="s19-blocks">
            <?php foreach ($s19_blocks as $s19_block): ?>
            <div class="blogar-s19-block blogar-s19-block-<?php echo esc_attr($s19_block['side']); ?>"
                data-initial-cat="<?php echo esc_attr($s19_block['first_cat']); ?>">

                <div class="blogar-s19-header">
                    <h2 class="s19-title-label">
                        <a href="<?php echo esc_url($s19_block['link']); ?>">
                            <?php echo esc_html($s19_block['title']); ?>
                        </a>
                    </h2>

                    <nav class="blogar-s19-nav" aria-label="<?php esc_attr_e('Filter posts', 'blogar'); ?>">
                        <ul class="s19-cat-list" role="tablist" aria-label="<?php esc_attr_e('Category filters', 'blogar'); ?>">
                            <?php if ($s19_block['show_all_tab']): ?>
                            <li>
                                <button type="button" class="s19-tab s19-active" data-cat="all" role="tab"
                                    aria-selected="true" aria-label="<?php esc_attr_e('All', 'blogar'); ?>">
                                    <?php esc_html_e('All', 'blogar'); ?>
                                </button>
                            </li>
                            <?php endif; ?>
                            <?php foreach ($s19_block['cats'] as $s19_cat_index => $s19_cat): ?>
                            <li>
                                <button type="button"
                                    class="s19-tab<?php echo (!$s19_block['show_all_tab'] && $s19_cat_index === 0) ? ' s19-active' : ''; ?>"
                                    data-cat="<?php echo esc_attr($s19_cat['id']); ?>" role="tab"
                                    aria-selected="<?php echo (!$s19_block['show_all_tab'] && $s19_cat_index === 0) ? 'true' : 'false'; ?>"
                                    aria-label="<?php echo esc_attr($s19_cat['name']); ?>">
                                    <?php echo esc_html($s19_cat['name']); ?>
                                </button>
                            </li>
                            <?php endforeach; ?>
                        </ul>

                        <ul class="s19-pager">
                            <li>
                                <button type="button" class="s19-btn-prev s19-btn-disable"
                                    aria-label="<?php esc_attr_e('Previous', 'blogar'); ?>" aria-disabled="true" disabled>
                                    <svg class="s19-icon" width="7" height="11" viewBox="0 0 7 11" fill="none"
                                        aria-hidden="true" focusable="false">
                                        <path d="M6 10L1 5.5L6 1" stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="s19-btn-next"
                                    aria-label="<?php esc_attr_e('Next', 'blogar'); ?>" aria-disabled="false">
                                    <svg class="s19-icon" width="7" height="11" viewBox="0 0 7 11" fill="none"
                                        aria-hidden="true" focusable="false">
                                        <path d="M1 10L6 5.5L1 1" stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="blogar-s19-block-slides" aria-live="polite">
                    <?php foreach ($s19_block['posts'] as $s19_cat_id => $s19_cat_posts):
                            $s19_normalized = array();
                            foreach ($s19_cat_posts as $_raw_post) {
                                $s19_card = $s19_normalize_item($_raw_post);
                                if ($s19_card) {
                                    $s19_normalized[] = $s19_card;
                                }
                            }

                            if (empty($s19_normalized)) {
                                continue;
                            }

                            $s19_slides = array_chunk($s19_normalized, 7);
                            foreach ($s19_slides as $s19_slide_idx => $s19_slide_posts):
                                $s19_is_first = ((string) $s19_cat_id === $s19_block['first_cat'] && $s19_slide_idx === 0);
                                $s19_slide_cls = $s19_is_first ? ' s19-slide-active' : '';
                                $s19_featured = !empty($s19_slide_posts[0]) ? $s19_slide_posts[0] : null;
                                $s19_list = array_slice($s19_slide_posts, 1, 6);
                                $s19_col1 = array_slice($s19_list, 0, 3);
                                $s19_col2 = array_slice($s19_list, 3, 3);
                                ?>
                    <div class="blogar-s19-slide<?php echo $s19_slide_cls; ?>"
                        data-cat="<?php echo esc_attr($s19_cat_id); ?>" data-slide="<?php echo (int) $s19_slide_idx; ?>"
                        aria-hidden="<?php echo $s19_is_first ? 'false' : 'true'; ?>"
                        <?php echo $s19_is_first ? '' : 'hidden'; ?>>

                        <?php if ($s19_featured): ?>
                        <article class="s19-featured-post">
                            <div class="s19-featured-thumb"<?php echo !empty($s19_featured['img_style']) ? ' data-has-img="true"' : ''; ?>>
                                <a href="<?php echo esc_url($s19_featured['url']); ?>" class="s19-featured-img"
                                    style="<?php echo esc_attr($s19_featured['img_style']); ?>"
                                    title="<?php echo esc_attr($s19_featured['title']); ?>"
                                    aria-label="<?php echo esc_attr($s19_featured['title']); ?>" tabindex="-1"></a>
                            </div>
                            <div class="s19-featured-content">
                                <h3 class="s19-featured-title">
                                    <a href="<?php echo esc_url($s19_featured['url']); ?>"
                                        title="<?php echo esc_attr($s19_featured['title']); ?>">
                                        <?php echo esc_html($s19_featured['title']); ?>
                                    </a>
                                </h3>
                                <div class="s19-featured-meta">
                                    <?php esc_html_e('by', 'blogar'); ?>
                                    <a href="<?php echo esc_url($s19_featured['author_url']); ?>">
                                        <?php echo esc_html($s19_featured['author_name']); ?>
                                    </a>
                                    <span class="s19-meta-sep">&bull;</span>
                                    <span><?php echo esc_html($s19_featured['date_text']); ?></span>
                                </div>
                                <?php if (!empty($s19_featured['excerpt'])): ?>
                                <div class="s19-featured-excerpt">
                                    <p><?php echo esc_html($s19_featured['excerpt']); ?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </article>
                        <?php endif; ?>

                        <div class="s19-list-columns">
                            <div class="s19-list-col">
                                <?php foreach ($s19_col1 as $s19_mini): ?>
                                <article class="s19-mini-item">
                                    <div class="s19-mini-thumb"<?php echo !empty($s19_mini['img_style']) ? ' data-has-img="true"' : ''; ?>>
                                        <a href="<?php echo esc_url($s19_mini['url']); ?>" class="s19-mini-img"
                                            style="<?php echo esc_attr($s19_mini['img_style']); ?>"
                                            title="<?php echo esc_attr($s19_mini['title']); ?>"
                                            aria-label="<?php echo esc_attr($s19_mini['title']); ?>" tabindex="-1"></a>
                                    </div>
                                    <div class="s19-mini-content">
                                        <h3 class="s19-mini-title">
                                            <a href="<?php echo esc_url($s19_mini['url']); ?>"
                                                title="<?php echo esc_attr($s19_mini['title']); ?>">
                                                <?php echo esc_html($s19_mini['title']); ?>
                                            </a>
                                        </h3>
                                        <div class="s19-mini-meta">
                                            <?php echo esc_html($s19_mini['date_text']); ?>
                                        </div>
                                    </div>
                                </article>
                                <?php endforeach; ?>
                            </div>

                            <div class="s19-list-col">
                                <?php foreach ($s19_col2 as $s19_mini): ?>
                                <article class="s19-mini-item">
                                    <div class="s19-mini-thumb"<?php echo !empty($s19_mini['img_style']) ? ' data-has-img="true"' : ''; ?>>
                                        <a href="<?php echo esc_url($s19_mini['url']); ?>" class="s19-mini-img"
                                            style="<?php echo esc_attr($s19_mini['img_style']); ?>"
                                            title="<?php echo esc_attr($s19_mini['title']); ?>"
                                            aria-label="<?php echo esc_attr($s19_mini['title']); ?>" tabindex="-1"></a>
                                    </div>
                                    <div class="s19-mini-content">
                                        <h3 class="s19-mini-title">
                                            <a href="<?php echo esc_url($s19_mini['url']); ?>"
                                                title="<?php echo esc_attr($s19_mini['title']); ?>">
                                                <?php echo esc_html($s19_mini['title']); ?>
                                            </a>
                                        </h3>
                                        <div class="s19-mini-meta">
                                            <?php echo esc_html($s19_mini['date_text']); ?>
                                        </div>
                                    </div>
                                </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php $_sections['s19'] = ob_get_clean(); ?>

<?php ob_start(); ?>
<?php if (get_option('blogar_s20_enabled', '1')): ?>
    <?php
    $s20_settings_url = add_query_arg(
        array(
            'page' => 'blogar-settings',
            'tab'  => 's20_dual_col_featured',
        ),
        admin_url('themes.php')
    );

    $s20_build_placeholder_cards = static function ($settings_url, $block_title) {
        $cards = array();
        $date_text = wp_date(get_option('date_format'));
        $gradients = array(
            'linear-gradient(135deg,#eef2f7 0%,#e5edf6 52%,#f8fafc 100%)',
            'linear-gradient(135deg,#fdf2f8 0%,#fce7f3 52%,#fff1f2 100%)',
            'linear-gradient(135deg,#fef3c7 0%,#fde68a 52%,#fffbeb 100%)',
            'linear-gradient(135deg,#dcfce7 0%,#bbf7d0 52%,#f0fdf4 100%)',
        );

        for ($i = 0; $i < 10; $i++) {
            $cards[] = array(
                'title'      => sprintf(__('Placeholder post %d for %s', 'blogar'), $i + 1, $block_title),
                'author'     => __('Blogar Editorial', 'blogar'),
                'url'        => $settings_url,
                'author_url' => $settings_url,
                'img_style'  => 'background-image:' . $gradients[$i % count($gradients)],
                'date_text'  => $date_text,
                'excerpt'    => __('Assign categories in Blogar Settings to replace these fallback cards with live posts.', 'blogar'),
            );
        }

        return $cards;
    };

    $s20_prepare_block = static function ($side, $title_default, $data, $settings_url) use ($s20_build_placeholder_cards) {
        $prefix = 'blogar_s20_' . $side;

        $title = trim((string) get_option($prefix . '_title', ''));
        if ($title === '') {
            $title = $title_default;
        }

        $parent_cat_id = isset($data['parent_cat_id']) ? (int) $data['parent_cat_id'] : 0;
        $default_link  = home_url('/');
        if ($parent_cat_id) {
            $term_link = get_category_link($parent_cat_id);
            if (!is_wp_error($term_link)) {
                $default_link = $term_link;
            }
        }

        $link = trim((string) get_option($prefix . '_link', ''));
        if ($link === '') {
            $link = $default_link;
        }

        $cats         = isset($data['cats']) ? $data['cats'] : array();
        $posts        = isset($data['posts']) ? $data['posts'] : array();
        $show_all_tab = (bool) get_option($prefix . '_show_all_tab', 1);

        $placeholder_cards = $s20_build_placeholder_cards($settings_url, $title);
        if (empty($posts['all'])) {
            $posts = array('all' => $placeholder_cards);
            $cats  = array();
        }

        if (!$show_all_tab) {
            unset($posts['all']);
        }

        if (empty($posts)) {
            $posts        = array('all' => $placeholder_cards);
            $show_all_tab = true;
        }

        $available_cat_ids = array_map('strval', array_keys($posts));
        $cats = array_values(array_filter($cats, static function ($cat) use ($available_cat_ids) {
            return isset($cat['id']) && in_array((string) $cat['id'], $available_cat_ids, true);
        }));

        $first_cat = 'all';
        if ($show_all_tab && isset($posts['all'])) {
            $first_cat = 'all';
        } elseif (!empty($cats[0]['id'])) {
            $first_cat = (string) $cats[0]['id'];
        } else {
            $post_keys = array_keys($posts);
            if (!empty($post_keys)) {
                $first_cat = (string) reset($post_keys);
            }
        }

        return array(
            'side'         => $side,
            'title'        => $title,
            'link'         => $link,
            'cats'         => $cats,
            'posts'        => $posts,
            'show_all_tab' => $show_all_tab,
            'first_cat'    => $first_cat,
        );
    };

    $s20_normalize_item = static function ($item) {
        if ($item instanceof WP_Post) {
            $item_id  = $item->ID;
            $img_url  = get_the_post_thumbnail_url($item_id, 'blogar-card');
            if (!$img_url) {
                $img_url = get_the_post_thumbnail_url($item_id, 'large');
            }

            $author_id      = (int) $item->post_author;
            $excerpt_source = has_excerpt($item_id)
                ? get_the_excerpt($item_id)
                : wp_strip_all_tags($item->post_excerpt ? $item->post_excerpt : $item->post_content);

            return array(
                'title'       => get_the_title($item_id),
                'url'         => get_permalink($item_id),
                'author_name' => get_the_author_meta('display_name', $author_id),
                'author_url'  => get_author_posts_url($author_id),
                'img_style'   => $img_url ? 'background-image:url(' . esc_url($img_url) . ')' : '',
                'date_text'   => get_the_date(get_option('date_format'), $item_id),
                'excerpt'     => wp_trim_words($excerpt_source, 24, '...'),
                'is_placeholder' => false,
            );
        }

        if (is_array($item)) {
            return array(
                'title'       => !empty($item['title']) ? $item['title'] : __('Sample post', 'blogar'),
                'url'         => !empty($item['url']) ? $item['url'] : '#',
                'author_name' => !empty($item['author']) ? $item['author'] : __('Blogar Editorial', 'blogar'),
                'author_url'  => !empty($item['author_url']) ? $item['author_url'] : '#',
                'img_style'   => !empty($item['img_style']) ? $item['img_style'] : '',
                'date_text'   => !empty($item['date_text']) ? $item['date_text'] : wp_date(get_option('date_format')),
                'excerpt'     => !empty($item['excerpt']) ? $item['excerpt'] : __('Section preview content appears here until categories are assigned.', 'blogar'),
                'is_placeholder' => true,
            );
        }

        return null;
    };

    $s20_blocks = array(
        'left'  => $s20_prepare_block('left',  __('Food & Cuisine', 'blogar'), blogar_get_s20_block_data('left'),  $s20_settings_url),
        'right' => $s20_prepare_block('right', __('Music News',     'blogar'), blogar_get_s20_block_data('right'), $s20_settings_url),
    );
    ?>
<section class="blogar-section blogar-s20" data-section="s20">
    <div class="blogar-s20-inner">
        <div class="s20-blocks">
            <?php foreach ($s20_blocks as $s20_block): ?>
            <div class="blogar-s20-block blogar-s20-block-<?php echo esc_attr($s20_block['side']); ?>"
                data-initial-cat="<?php echo esc_attr($s20_block['first_cat']); ?>">

                <div class="blogar-s20-header">
                    <h2 class="s20-title-label">
                        <a href="<?php echo esc_url($s20_block['link']); ?>">
                            <?php echo esc_html($s20_block['title']); ?>
                        </a>
                    </h2>

                    <nav class="blogar-s20-nav" aria-label="<?php esc_attr_e('Filter posts', 'blogar'); ?>">
                        <ul class="s20-cat-list" role="tablist" aria-label="<?php esc_attr_e('Category filters', 'blogar'); ?>">
                            <?php if ($s20_block['show_all_tab']): ?>
                            <li role="presentation">
                                <button type="button" class="s20-tab s20-active" data-cat="all" role="tab"
                                    aria-selected="true" aria-label="<?php esc_attr_e('All', 'blogar'); ?>">
                                    <?php esc_html_e('All', 'blogar'); ?>
                                </button>
                            </li>
                            <?php endif; ?>
                            <?php foreach ($s20_block['cats'] as $s20_cat_index => $s20_cat): ?>
                            <li role="presentation">
                                <button type="button"
                                    class="s20-tab<?php echo (!$s20_block['show_all_tab'] && $s20_cat_index === 0) ? ' s20-active' : ''; ?>"
                                    data-cat="<?php echo esc_attr($s20_cat['id']); ?>" role="tab"
                                    aria-selected="<?php echo (!$s20_block['show_all_tab'] && $s20_cat_index === 0) ? 'true' : 'false'; ?>"
                                    aria-label="<?php echo esc_attr($s20_cat['name']); ?>">
                                    <?php echo esc_html($s20_cat['name']); ?>
                                </button>
                            </li>
                            <?php endforeach; ?>
                        </ul>

                        <ul class="s20-pager">
                            <li>
                                <button type="button" class="s20-btn-prev s20-btn-disable"
                                    aria-label="<?php esc_attr_e('Previous', 'blogar'); ?>" aria-disabled="true" disabled>
                                    <svg class="s20-icon" width="7" height="11" viewBox="0 0 7 11" fill="none"
                                        aria-hidden="true" focusable="false">
                                        <path d="M6 10L1 5.5L6 1" stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="s20-btn-next"
                                    aria-label="<?php esc_attr_e('Next', 'blogar'); ?>" aria-disabled="false">
                                    <svg class="s20-icon" width="7" height="11" viewBox="0 0 7 11" fill="none"
                                        aria-hidden="true" focusable="false">
                                        <path d="M1 10L6 5.5L1 1" stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="blogar-s20-block-slides" aria-live="polite">
                    <?php foreach ($s20_block['posts'] as $s20_cat_id => $s20_cat_posts):
                            $s20_normalized = array();
                            foreach ($s20_cat_posts as $_raw_post) {
                                $s20_card = $s20_normalize_item($_raw_post);
                                if ($s20_card) {
                                    $s20_normalized[] = $s20_card;
                                }
                            }

                            if (empty($s20_normalized)) {
                                continue;
                            }

                            $s20_slides = array_chunk($s20_normalized, 5);
                            foreach ($s20_slides as $s20_slide_idx => $s20_slide_posts):
                                $s20_is_first   = ((string) $s20_cat_id === $s20_block['first_cat'] && $s20_slide_idx === 0);
                                $s20_slide_cls  = $s20_is_first ? ' s20-slide-active' : '';
                                $s20_featured   = !empty($s20_slide_posts[0]) ? $s20_slide_posts[0] : null;
                                $s20_mini_items = array_slice($s20_slide_posts, 1, 4);
                                ?>
                    <div class="blogar-s20-slide<?php echo $s20_slide_cls; ?>"
                        data-cat="<?php echo esc_attr($s20_cat_id); ?>" data-slide="<?php echo (int) $s20_slide_idx; ?>"
                        aria-hidden="<?php echo $s20_is_first ? 'false' : 'true'; ?>"
                        <?php echo $s20_is_first ? '' : 'hidden'; ?>>

                        <div class="s20-cols">

                            <!-- Left: featured post (image top + content below) -->
                            <div class="s20-col-left">
                                <?php if ($s20_featured): ?>
                                <article class="s20-featured-card">
                                    <div class="s20-featured-thumb"<?php echo !empty($s20_featured['img_style']) ? ' data-has-img="true"' : ''; ?>>
                                        <a href="<?php echo esc_url($s20_featured['url']); ?>" class="s20-featured-img"
                                            style="<?php echo esc_attr($s20_featured['img_style']); ?>"
                                            title="<?php echo esc_attr($s20_featured['title']); ?>"
                                            aria-label="<?php echo esc_attr($s20_featured['title']); ?>" tabindex="-1"></a>
                                    </div>
                                    <div class="s20-featured-content">
                                        <h3 class="s20-featured-title">
                                            <a href="<?php echo esc_url($s20_featured['url']); ?>"
                                                title="<?php echo esc_attr($s20_featured['title']); ?>">
                                                <?php echo esc_html($s20_featured['title']); ?>
                                            </a>
                                        </h3>
                                        <div class="s20-featured-meta">
                                            <?php esc_html_e('by', 'blogar'); ?>
                                            <a href="<?php echo esc_url($s20_featured['author_url']); ?>">
                                                <?php echo esc_html($s20_featured['author_name']); ?>
                                            </a>
                                            <span class="s20-meta-sep">&bull;</span>
                                            <span><?php echo esc_html($s20_featured['date_text']); ?></span>
                                        </div>
                                        <?php if (!empty($s20_featured['excerpt'])): ?>
                                        <div class="s20-featured-excerpt">
                                            <p><?php echo esc_html($s20_featured['excerpt']); ?></p>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </article>
                                <?php endif; ?>
                            </div>

                            <!-- Right: 4 mini items stacked -->
                            <div class="s20-col-right">
                                <?php foreach ($s20_mini_items as $s20_mini): ?>
                                <article class="s20-mini-item">
                                    <div class="s20-mini-thumb"<?php echo !empty($s20_mini['img_style']) ? ' data-has-img="true"' : ''; ?>>
                                        <a href="<?php echo esc_url($s20_mini['url']); ?>" class="s20-mini-img"
                                            style="<?php echo esc_attr($s20_mini['img_style']); ?>"
                                            title="<?php echo esc_attr($s20_mini['title']); ?>"
                                            aria-label="<?php echo esc_attr($s20_mini['title']); ?>" tabindex="-1"></a>
                                    </div>
                                    <div class="s20-mini-content">
                                        <h3 class="s20-mini-title">
                                            <a href="<?php echo esc_url($s20_mini['url']); ?>"
                                                title="<?php echo esc_attr($s20_mini['title']); ?>">
                                                <?php echo esc_html($s20_mini['title']); ?>
                                            </a>
                                        </h3>
                                        <div class="s20-mini-meta">
                                            <?php echo esc_html($s20_mini['date_text']); ?>
                                        </div>
                                    </div>
                                </article>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                    <?php endforeach; endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php $_sections['s20'] = ob_get_clean(); ?>

<div class="blogar-front-page-shell">
    <div class="main-wrapper">
        <h1 class="blogar-visually-hidden"><?php bloginfo('name'); ?></h1>

        <?php foreach ($_section_order as $_sk): ?>
        <?php if (isset($_sections[$_sk]))
                echo $_sections[$_sk]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php endforeach; ?>
    </div>
</div>

<?php get_footer(); ?>
