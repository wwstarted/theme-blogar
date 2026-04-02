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
     SECTION 1 — HERO SLIDER
     Dữ liệu: WP_Query từ posts được chọn trong Appearance > Blogar Settings.
     Fallback: 3 bài mới nhất nếu admin chưa cấu hình.
     ================================================================ -->
        <?php
        $hero_query = blogar_get_hero_posts();
        $is_first_slide = true;
        ?>
        <section class="slider-area bg-color-grey axil-section-gap">
            <div class="axil-slide slider-style-1">
                <div class="container">
                    <div class="slider-activation-wrap">
                        <div class="slider-activation axil-slick-arrow" data-slider>

                            <?php while ($hero_query->have_posts()):
                                $hero_query->the_post();

                                // ── Post data ─────────────────────────────────────────
                                $post_id = get_the_ID();
                                $post_url = get_permalink();
                                $post_title = get_the_title();
                                $post_date = get_the_date('F j, Y');
                                $read_time = blogar_reading_time($post_id);

                                // ── Featured image ────────────────────────────────────
                                // Dùng size 'blogar-hero' (1230x615) đã đăng ký trong functions.php.
                                $thumb_url = blogar_thumbnail_url($post_id, 'blogar-hero');
                                $thumb_alt = blogar_thumbnail_alt($post_id);

                                // ── Author ────────────────────────────────────────────
                                $author_id = (int) get_the_author_meta('ID');
                                $author_name = get_the_author();
                                $author_url = get_author_posts_url($author_id);
                                $author_avatar = get_avatar_url($author_id, array('size' => 50));

                                // ── Heading + loading strategy ────────────────────────
                                // Slide đầu tiên: h1 (SEO) + eager loading.
                                // Các slide sau: h2 + lazy loading.
                                $heading_tag = $is_first_slide ? 'h1' : 'h2';
                                $loading_attr = $is_first_slide ? 'eager' : 'lazy';
                                $is_first_slide = false; // reset sau khi dùng
                            
                                // ── Social share URLs ─────────────────────────────────
                                $share_urls = blogar_social_share_urls($post_url, $post_title);
                                ?>

                            <div class="content-block">
                                <div class="post-thumbnail">
                                    <a href="<?php echo esc_url($post_url); ?>">
                                        <img <?php echo $loading_attr === 'eager' ? 'fetchpriority="high"' : ''; ?>
                                            loading="<?php echo esc_attr($loading_attr); ?>" decoding="async"
                                            width="1230" height="615" src="<?php echo esc_url($thumb_url); ?>"
                                            alt="<?php echo esc_attr($thumb_alt); ?>"
                                            sizes="(max-width: 1230px) 100vw, 1230px">
                                    </a>
                                </div>
                                <div class="post-content">
                                    <div class="post-cat">
                                        <div class="post-cat-list">
                                            <?php echo blogar_post_categories_html($post_id, 1); // phpcs:ignore ?>
                                        </div>
                                    </div>

                                    <<?php echo esc_attr($heading_tag); ?> class="title">
                                        <a
                                            href="<?php echo esc_url($post_url); ?>"><?php echo esc_html($post_title); ?></a>
                                    </<?php echo esc_attr($heading_tag); ?>>

                                    <div class="post-meta-wrapper with-button">
                                        <div class="post-meta">
                                            <div class="post-author-avatar border-rounded">
                                                <img alt="<?php echo esc_attr($author_name); ?>"
                                                    src="<?php echo esc_url($author_avatar); ?>" width="50" height="50">
                                            </div>
                                            <div class="content">
                                                <h6 class="post-author-name">
                                                    <a class="hover-flip-item-wrapper"
                                                        href="<?php echo esc_url($author_url); ?>">
                                                        <span class="hover-flip-item">
                                                            <span
                                                                data-text="<?php echo esc_attr($author_name); ?>"><?php echo esc_html($author_name); ?></span>
                                                        </span>
                                                    </a>
                                                </h6>
                                                <ul class="post-meta-list">
                                                    <li class="post-meta-date"><?php echo esc_html($post_date); ?>
                                                    </li>
                                                    <li class="post-meta-reading-time">
                                                        <?php echo esc_html($read_time); ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <ul class="social-share-transparent justify-content-end">
                                            <li>
                                                <a href="<?php echo esc_url($share_urls['facebook']); ?>"
                                                    target="_blank" rel="noopener nofollow" class="aw-facebook"
                                                    aria-label="<?php esc_attr_e('Share on Facebook', 'blogar'); ?>">
                                                    <?php echo $svg_fb; // phpcs:ignore ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo esc_url($share_urls['twitter']); ?>" target="_blank"
                                                    rel="noopener nofollow" class="aw-twitter"
                                                    aria-label="<?php esc_attr_e('Share on Twitter', 'blogar'); ?>">
                                                    <?php echo $svg_tw; // phpcs:ignore ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo esc_url($share_urls['linkedin']); ?>"
                                                    target="_blank" rel="noopener nofollow" class="aw-linkdin"
                                                    aria-label="<?php esc_attr_e('Share on LinkedIn', 'blogar'); ?>">
                                                    <?php echo $svg_li; // phpcs:ignore ?>
                                                </a>
                                            </li>
                                            <li>
                                                <button class="axilcopyLink"
                                                    title="<?php esc_attr_e('Copy Link', 'blogar'); ?>"
                                                    data-link="<?php echo esc_url($post_url); ?>"
                                                    aria-label="<?php esc_attr_e('Copy link', 'blogar'); ?>">
                                                    <?php echo $svg_lk; // phpcs:ignore ?>
                                                </button>
                                            </li>
                                        </ul>

                                        <div class="read-more-button cerchio">
                                            <a class="axil-button button-rounded hover-flip-item-wrapper"
                                                href="<?php echo esc_url($post_url); ?>">
                                                <span class="hover-flip-item">
                                                    <span data-text="<?php esc_attr_e('Read Post', 'blogar'); ?>">
                                                        <?php esc_html_e('Read Post', 'blogar'); ?>
                                                    </span>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php endwhile;
                            wp_reset_postdata(); ?>

                        </div><!-- .slider-activation -->

                        <!-- Prev / Next arrows -->
                        <button class="slide-arrow prev-arrow"
                            aria-label="<?php esc_attr_e('Previous slide', 'blogar'); ?>">
                            <svg viewBox="0 0 24 24">
                                <path d="M19 12H5M12 5l-7 7 7 7" />
                            </svg>
                        </button>
                        <button class="slide-arrow next-arrow"
                            aria-label="<?php esc_attr_e('Next slide', 'blogar'); ?>">
                            <svg viewBox="0 0 24 24">
                                <path d="M5 12h14M12 19l7-7-7-7" />
                            </svg>
                        </button>

                    </div><!-- .slider-activation-wrap -->
                </div><!-- .container -->
            </div><!-- .axil-slide -->
        </section>

        <!-- ================================================================
     SECTION 2 — FEATURED POSTS
     ================================================================ -->
        <section class="axil-featured-post axil-section-gap bg-color-grey">
            <div class="container">
                <div class="section-title text-left">
                    <h2 class="title">More Featured Posts.</h2>
                </div>

                <div class="featured-posts-grid">
                    <!-- Post 1 -->
                    <div
                        class="content-block content-direction-column axil-control is-active post-horizontal thumb-border-rounded">
                        <div class="post-content">
                            <div class="post-cat">
                                <div class="post-cat-list">
                                    <a class="hover-flip-item-wrapper" href="#">
                                        <span class="hover-flip-item"><span
                                                data-text="Lifestyle">Lifestyle</span></span>
                                    </a>
                                </div>
                            </div>
                            <h4 class="title">
                                <a href="#">Fashion portrait of young businessman handsome model man in casual
                                    cloth.</a>
                            </h4>
                            <div class="post-meta">
                                <div class="post-author-avatar border-rounded">
                                    <img alt="axilthemes"
                                        src="https://secure.gravatar.com/avatar/1b70c830da30f39d5c6fab323017430c?s=50&d=mm&r=g"
                                        width="50" height="50">
                                </div>
                                <div class="content">
                                    <h6 class="post-author-name">
                                        <a class="hover-flip-item-wrapper" href="#">
                                            <span class="hover-flip-item"><span
                                                    data-text="axilthemes">axilthemes</span></span>
                                        </a>
                                    </h6>
                                    <ul class="post-meta-list">
                                        <li class="post-meta-date">January 21, 2021</li>
                                        <li class="post-meta-reading-time">4 min read</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="post-thumbnail">
                            <a href="#">
                                <img loading="lazy" decoding="async" width="300" height="169"
                                    src="<?php echo esc_url($img . 'demo_image-300x169.jpg'); ?>" alt="demo_image">
                            </a>
                        </div>
                    </div>
                    <!-- End Post 1 -->

                    <!-- Post 2 -->
                    <div
                        class="content-block content-direction-column axil-control is-active post-horizontal thumb-border-rounded">
                        <div class="post-content">
                            <div class="post-cat">
                                <div class="post-cat-list">
                                    <a class="hover-flip-item-wrapper" href="#">
                                        <span class="hover-flip-item"><span data-text="Design">Design</span></span>
                                    </a>
                                </div>
                            </div>
                            <h4 class="title">
                                <a href="#">Security isn&#8217;t just a technology problem it&#8217;s about design,
                                    too</a>
                            </h4>
                            <div class="post-meta">
                                <div class="post-author-avatar border-rounded">
                                    <img alt="axilthemes"
                                        src="https://secure.gravatar.com/avatar/1b70c830da30f39d5c6fab323017430c?s=50&d=mm&r=g"
                                        width="50" height="50">
                                </div>
                                <div class="content">
                                    <h6 class="post-author-name">
                                        <a class="hover-flip-item-wrapper" href="#">
                                            <span class="hover-flip-item"><span
                                                    data-text="axilthemes">axilthemes</span></span>
                                        </a>
                                    </h6>
                                    <ul class="post-meta-list">
                                        <li class="post-meta-date">January 20, 2021</li>
                                        <li class="post-meta-reading-time">4 min read</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="post-thumbnail">
                            <a href="#">
                                <img loading="lazy" decoding="async" width="300" height="169"
                                    src="<?php echo esc_url($img . 'demo_image-5-300x169.jpg'); ?>" alt="demo_image-5">
                            </a>
                        </div>
                    </div>
                    <!-- End Post 2 -->
                </div><!-- .featured-posts-grid -->
            </div><!-- .container -->
        </section>


        <!-- ================================================================
     SECTION 3 — AD BANNER
     ================================================================ -->
        <section class="axil-banner-ad bg-color-white">
            <div class="container">
                <img loading="lazy" decoding="async" width="1230" height="200"
                    src="<?php echo esc_url($img . 'banner-03.png'); ?>" alt="banner-03"
                    sizes="(max-width: 1230px) 100vw, 1230px">
            </div>
        </section>


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
                    <div class="section-title text-left">
                        <h2 class="title"><?php echo esc_html($inno_data['title']); ?></h2>
                    </div>

                    <ul class="axil-tab-button mt--20" role="tablist">
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
                                                    $thumb_url = blogar_thumbnail_url($post_id, 'blogar-card');
                                                    $thumb_alt = blogar_thumbnail_alt($post_id);
                                                    ?>
                                        <div class="slick-single-layout">
                                            <div
                                                class="content-block modern-post-style text-center content-block-column">
                                                <div class="post-content">
                                                    <div class="post-cat">
                                                        <div class="post-cat-list">
                                                            <?php echo blogar_post_categories_html($post_id, 1); // phpcs:ignore ?>
                                                        </div>
                                                    </div>
                                                    <h4 class="title">
                                                        <a href="<?php echo esc_url($post_url); ?>">
                                                            <?php echo esc_html($post_title); ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div class="post-thumbnail">
                                                    <a href="<?php echo esc_url($post_url); ?>">
                                                        <img loading="lazy" decoding="async" width="390" height="260"
                                                            src="<?php echo esc_url($thumb_url); ?>"
                                                            alt="<?php echo esc_attr($thumb_alt); ?>">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
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
                        </div>
                        <?php endforeach; ?>
                    </div><!-- .tab-content -->

                </div><!-- .container -->
            </div><!-- .wrapper -->
        </section>
        <?php endif; ?>

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
                                            <h5 class="title"><?php echo esc_html($cat['name']); ?></h5>
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
     SECTION 6 — MOST POPULAR (numbered list)
     ================================================================ -->
        <?php
        $popular_list_data = blogar_get_most_popular_list_data();
        $popular_list_tabs = $popular_list_data['tabs'];
        $popular_list_first = true;
        ?>
        <?php if (!empty($popular_list_tabs)): ?>
        <section class="axil-trending-post-area axil-section-gap bg-color-white">
            <div class="wrapper">
                <div class="container">
                    <div class="section-title text-left">
                        <h2 class="title"><?php echo esc_html($popular_list_data['title']); ?></h2>
                    </div>

                    <ul class="axil-tab-button mt--20" role="tablist">
                        <?php foreach ($popular_list_tabs as $ti => $tab):
                            $tab_id = 'tab-trend-' . ($ti + 1);
                            $is_active = $popular_list_first;
                            $popular_list_first = false;
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
                        $popular_list_first = true;
                        foreach ($popular_list_tabs as $ti => $tab):
                            $tab_id = 'tab-trend-' . ($ti + 1);
                            $active = $popular_list_first ? ' active' : '';
                            $popular_list_first = false;
                            ?>
                        <div class="trend-tab-content<?php echo esc_attr($active); ?>"
                            id="<?php echo esc_attr($tab_id); ?>" role="tabpanel">
                            <div class="trend-tab-grid">
                                <div class="trend-posts-full">
                                    <?php
                                    $num = 1;
                                    if ($tab['query']->have_posts()):
                                    while ($tab['query']->have_posts()):
                                        $tab['query']->the_post();
                                        $post_id = get_the_ID();
                                        $post_url = get_permalink();
                                        $post_title = get_the_title();
                                        $post_date = get_the_date('F j, Y');
                                        $read_time = blogar_reading_time($post_id);
                                        $thumb_url = blogar_thumbnail_url($post_id, 'blogar-card');
                                        $thumb_alt = blogar_thumbnail_alt($post_id);
                                        $author_id = (int) get_the_author_meta('ID');
                                        $author_name = get_the_author();
                                        $author_url = get_author_posts_url($author_id);
                                        $share_urls = blogar_social_share_urls($post_url, $post_title);
                                        ?>
                                    <div
                                        class="content-block trend-post post-order-list axil-control<?php echo 1 === $num ? ' is-active' : ''; ?>">
                                        <div class="post-inner">
                                            <span class="post-order-list"><?php echo sprintf('%02d', $num); ?></span>
                                            <div class="post-content">
                                                <div class="post-cat">
                                                    <div class="post-cat-list">
                                                        <?php echo blogar_post_categories_html($post_id, 2); // phpcs:ignore ?>
                                                    </div>
                                                </div>
                                                <h3 class="title"><a
                                                        href="<?php echo esc_url($post_url); ?>"><?php echo esc_html($post_title); ?></a>
                                                </h3>
                                                <div class="post-meta-wrapper">
                                                    <div class="post-meta">
                                                        <div class="content">
                                                            <h6 class="post-author-name">
                                                                <a class="hover-flip-item-wrapper"
                                                                    href="<?php echo esc_url($author_url); ?>">
                                                                    <span class="hover-flip-item"><span
                                                                            data-text="<?php echo esc_attr($author_name); ?>"><?php echo esc_html($author_name); ?></span></span>
                                                                </a>
                                                            </h6>
                                                            <ul class="post-meta-list">
                                                                <li class="post-meta-date">
                                                                    <?php echo esc_html($post_date); ?>
                                                                </li>
                                                                <li class="post-meta-reading-time">
                                                                    <?php echo esc_html($read_time); ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="social-share-transparent justify-content-end">
                                                        <li><a href="<?php echo esc_url($share_urls['facebook']); ?>"
                                                                target="_blank" rel="noopener nofollow"
                                                                class="aw-facebook"
                                                                aria-label="<?php esc_attr_e('Share on Facebook', 'blogar'); ?>"><?php echo $svg_fb; // phpcs:ignore ?></a>
                                                        </li>
                                                        <li><a href="<?php echo esc_url($share_urls['twitter']); ?>"
                                                                target="_blank" rel="noopener nofollow"
                                                                class="aw-twitter"
                                                                aria-label="<?php esc_attr_e('Share on Twitter', 'blogar'); ?>"><?php echo $svg_tw; // phpcs:ignore ?></a>
                                                        </li>
                                                        <li><a href="<?php echo esc_url($share_urls['linkedin']); ?>"
                                                                target="_blank" rel="noopener nofollow"
                                                                class="aw-linkdin"
                                                                aria-label="<?php esc_attr_e('Share on LinkedIn', 'blogar'); ?>"><?php echo $svg_li; // phpcs:ignore ?></a>
                                                        </li>
                                                        <li><button class="axilcopyLink"
                                                                title="<?php esc_attr_e('Copy Link', 'blogar'); ?>"
                                                                data-link="<?php echo esc_url($post_url); ?>"
                                                                aria-label="<?php esc_attr_e('Copy link', 'blogar'); ?>"><?php echo $svg_lk; // phpcs:ignore ?></button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-thumbnail trend-preview-thumbnail">
                                            <a href="<?php echo esc_url($post_url); ?>">
                                                <img loading="lazy" decoding="async" width="390" height="260"
                                                    src="<?php echo esc_url($thumb_url); ?>"
                                                    alt="<?php echo esc_attr($thumb_alt); ?>">
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                    $num++;
                                    endwhile;
                                    else:
                                        ?>
                                    <div class="content-block trend-post post-order-list axil-control is-active">
                                        <div class="post-inner">
                                            <span class="post-order-list">--</span>
                                            <div class="post-content">
                                                <h3 class="title">
                                                    <?php esc_html_e('No posts found in this tab yet.', 'blogar'); ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    endif;
                                    wp_reset_postdata();
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div><!-- .tab-content -->
                </div><!-- .container -->
            </div><!-- .wrapper -->
        </section>
        <?php endif; ?>


        <!-- ================================================================
     SECTION 7 — SOCIAL NETWORKS
     ================================================================ -->
        <section class="axil-post-grid-area bg-color-grey">
            <div class="container">
                <div class="axil-social-wrapper bg-color-white radius">
                    <ul class="social-with-text">
                        <li class="twitter"><a href="#" target="_blank"
                                rel="nofollow"><?php echo $svg_tw; // phpcs:ignore ?><span>Twitter</span></a></li>
                        <li class="facebook"><a href="#" target="_blank"
                                rel="nofollow"><?php echo $svg_fb; // phpcs:ignore ?><span>Facebook</span></a></li>
                        <li class="youtube"><a href="#" target="_blank"
                                rel="nofollow"><?php echo $svg_yt; // phpcs:ignore ?><span>Youtube</span></a></li>
                        <li class="dribbble"><a href="#" target="_blank"
                                rel="nofollow"><?php echo $svg_db; // phpcs:ignore ?><span>Dribbble</span></a></li>
                        <li class="behance"><a href="#" target="_blank"
                                rel="nofollow"><?php echo $svg_be; // phpcs:ignore ?><span>Behance</span></a></li>
                        <li class="linkedin"><a href="#" target="_blank"
                                rel="nofollow"><?php echo $svg_li; // phpcs:ignore ?><span>Linkedin</span></a></li>
                    </ul>
                </div>
            </div>
        </section>


        <!-- ================================================================
     SECTION 8 — MOST POPULAR (grid)
     ================================================================ -->
        <?php
        $popular_grid_data = blogar_get_most_popular_grid_data();
        $popular_grid_tabs = $popular_grid_data['tabs'];
        $popular_grid_first = true;
        ?>
        <?php if (!empty($popular_grid_tabs)): ?>
        <section class="axil-post-grid-area axil-section-gap bg-color-grey most-popular-grid-area">
            <div class="wrapper">
                <div class="container">
                    <div class="section-title text-left">
                        <h2 class="title"><?php echo esc_html($popular_grid_data['title']); ?></h2>
                    </div>

                    <ul class="axil-tab-button mt--20" role="tablist">
                        <?php foreach ($popular_grid_tabs as $ti => $tab):
                            $tab_id = 'tab-grid-' . ($ti + 1);
                            $is_active = $popular_grid_first;
                            $popular_grid_first = false;
                            ?>
                        <li role="presentation"><a class="tab-link<?php echo $is_active ? ' active' : ''; ?>"
                                data-tab="#<?php echo esc_attr($tab_id); ?>" role="tab"
                                aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>">
                                <?php echo esc_html($tab['label']); ?>
                            </a></li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="grid-tab-content tab-content mt--10">

                        <?php
                        $popular_grid_first = true;
                        foreach ($popular_grid_tabs as $ti => $tab):
                            $tab_id = 'tab-grid-' . ($ti + 1);
                            $active = $popular_grid_first ? ' active' : '';
                            $popular_grid_first = false;
                            $posts = isset($tab['posts']) ? $tab['posts'] : array();
                            $big = !empty($posts) ? $posts[0] : null;
                            $smalls = count($posts) > 1 ? array_slice($posts, 1, 2) : array();
                            ?>
                        <div class="trend-tab-content<?php echo esc_attr($active); ?>"
                            id="<?php echo esc_attr($tab_id); ?>" role="tabpanel">
                            <div class="post-grid-layout">
                                <!-- Big post (left) -->
                                <div class="post-grid-main">
                                    <?php if ($big instanceof WP_Post):
                                        $big_id = $big->ID;
                                        $big_url = get_permalink($big_id);
                                        $big_title = get_the_title($big_id);
                                        $big_date = get_the_date('F j, Y', $big_id);
                                        $big_read_time = blogar_reading_time($big_id);
                                        $big_thumb_url = blogar_thumbnail_url($big_id, 'blogar-grid-big');
                                        $big_thumb_alt = blogar_thumbnail_alt($big_id);
                                        $big_author_id = (int) $big->post_author;
                                        $big_author_name = get_the_author_meta('display_name', $big_author_id);
                                        $big_author_url = get_author_posts_url($big_author_id);
                                        $big_author_avatar = get_avatar_url($big_author_id, array('size' => 50));
                                        $big_share_urls = blogar_social_share_urls($big_url, $big_title);
                                        ?>
                                    <div class="content-block post-grid post-grid-large mt--30 axil-big-post-image">
                                        <div class="post-thumbnail">
                                            <a href="<?php echo esc_url($big_url); ?>">
                                                <img loading="lazy" decoding="async"
                                                    src="<?php echo esc_url($big_thumb_url); ?>"
                                                    alt="<?php echo esc_attr($big_thumb_alt); ?>">
                                            </a>
                                        </div>
                                        <div class="post-grid-content">
                                            <div class="post-content">
                                                <div class="post-cat">
                                                    <div class="post-cat-list">
                                                        <?php echo blogar_post_categories_html($big_id, 1); // phpcs:ignore ?>
                                                    </div>
                                                </div>
                                                <h3 class="title"><a
                                                        href="<?php echo esc_url($big_url); ?>"><?php echo esc_html($big_title); ?></a>
                                                </h3>
                                                <div class="post-meta-wrapper">
                                                    <div class="post-meta">
                                                        <div class="post-author-avatar border-rounded">
                                                            <img alt="<?php echo esc_attr($big_author_name); ?>"
                                                                src="<?php echo esc_url($big_author_avatar); ?>"
                                                                width="50" height="50">
                                                        </div>
                                                        <div class="content">
                                                            <h6 class="post-author-name">
                                                                <a class="hover-flip-item-wrapper"
                                                                    href="<?php echo esc_url($big_author_url); ?>">
                                                                    <span class="hover-flip-item"><span
                                                                            data-text="<?php echo esc_attr($big_author_name); ?>"><?php echo esc_html($big_author_name); ?></span></span>
                                                                </a>
                                                            </h6>
                                                            <ul class="post-meta-list">
                                                                <li class="post-meta-date">
                                                                    <?php echo esc_html($big_date); ?>
                                                                </li>
                                                                <li class="post-meta-reading-time">
                                                                    <?php echo esc_html($big_read_time); ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="social-share-transparent justify-content-end">
                                                        <li><a href="<?php echo esc_url($big_share_urls['facebook']); ?>"
                                                                target="_blank" rel="noopener nofollow"
                                                                aria-label="<?php esc_attr_e('Facebook', 'blogar'); ?>"><?php echo $svg_fb; // phpcs:ignore ?></a>
                                                        </li>
                                                        <li><a href="<?php echo esc_url($big_share_urls['twitter']); ?>"
                                                                target="_blank" rel="noopener nofollow"
                                                                aria-label="<?php esc_attr_e('Twitter', 'blogar'); ?>"><?php echo $svg_tw; // phpcs:ignore ?></a>
                                                        </li>
                                                        <li><a href="<?php echo esc_url($big_share_urls['linkedin']); ?>"
                                                                target="_blank" rel="noopener nofollow"
                                                                aria-label="<?php esc_attr_e('LinkedIn', 'blogar'); ?>"><?php echo $svg_li; // phpcs:ignore ?></a>
                                                        </li>
                                                        <li><button class="axilcopyLink"
                                                                data-link="<?php echo esc_url($big_url); ?>"
                                                                aria-label="<?php esc_attr_e('Copy link', 'blogar'); ?>"><?php echo $svg_lk; // phpcs:ignore ?></button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <div class="content-block post-grid post-grid-large mt--30 axil-big-post-image">
                                        <div class="post-grid-content">
                                            <div class="post-content">
                                                <h3 class="title">
                                                    <?php esc_html_e('No posts found in this tab yet.', 'blogar'); ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Small posts (right) -->
                                <div class="post-grid-right">
                                    <?php foreach ($smalls as $small_post):
                                        $small_id = $small_post->ID;
                                        $small_url = get_permalink($small_id);
                                        $small_title = get_the_title($small_id);
                                        $small_thumb_url = blogar_thumbnail_url($small_id, 'blogar-grid-small');
                                        $small_thumb_alt = blogar_thumbnail_alt($small_id);
                                        ?>
                                    <div
                                        class="content-block post-grid post-grid-large mt--30 axil-small-post-image post-grid-small-card">
                                        <div class="post-thumbnail">
                                            <a href="<?php echo esc_url($small_url); ?>">
                                                <img loading="lazy" decoding="async"
                                                    src="<?php echo esc_url($small_thumb_url); ?>"
                                                    alt="<?php echo esc_attr($small_thumb_alt); ?>">
                                            </a>
                                        </div>
                                        <div class="post-grid-content">
                                            <div class="post-content">
                                                <div class="post-cat">
                                                    <div class="post-cat-list">
                                                        <?php echo blogar_post_categories_html($small_id, 1); // phpcs:ignore ?>
                                                    </div>
                                                </div>
                                                <h3 class="title"><a
                                                        href="<?php echo esc_url($small_url); ?>"><?php echo esc_html($small_title); ?></a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                    </div><!-- .tab-content -->
                </div><!-- .container -->
            </div><!-- .wrapper -->
        </section>
        <?php endif; ?>


        <!-- ================================================================
     SECTION 9 — POST LIST + SIDEBAR
     ================================================================ -->
        <section
            class="axil-post-list-area post-listview-visible-color axil-section-gap bg-color-white home-post-list-area">
            <div class="container">
                <div class="post-list-layout">
                    <?php $post_list_sidebar_data = blogar_get_post_list_sidebar_data(); ?>

                    <!-- Main content -->
                    <div class="post-list-main">
                        <img loading="lazy" decoding="async" width="810" height="210"
                            src="<?php echo esc_url($img . 'banner-01.png'); ?>" alt="banner-01">

                        <div class="axil-post-list-area mt--30">
                            <?php if ($post_list_sidebar_data['main_query']->have_posts()): ?>
                            <?php while ($post_list_sidebar_data['main_query']->have_posts()):
                                $post_list_sidebar_data['main_query']->the_post();
                                $list_post_id = get_the_ID();
                                $list_post_url = get_permalink($list_post_id);
                                $list_post_title = get_the_title($list_post_id);
                                $list_thumb_url = blogar_thumbnail_url($list_post_id, 'blogar-list');
                                $list_thumb_alt = blogar_thumbnail_alt($list_post_id);
                                $list_post_date = get_the_date('', $list_post_id);
                                $list_post_author = get_the_author_meta('display_name', (int) get_post_field('post_author', $list_post_id));
                                $list_post_author_url = get_author_posts_url((int) get_post_field('post_author', $list_post_id));
                                $list_post_avatar = get_avatar_url((int) get_post_field('post_author', $list_post_id), array('size' => 50));
                                $list_share_urls = blogar_social_share_urls($list_post_url, $list_post_title);
                                ?>
                            <div class="content-block post-list-view axil-control mt--30">
                                <div class="post-thumbnail">
                                    <a href="<?php echo esc_url($list_post_url); ?>">
                                        <img loading="lazy" decoding="async" width="300" height="169"
                                            src="<?php echo esc_url($list_thumb_url); ?>"
                                            alt="<?php echo esc_attr($list_thumb_alt); ?>">
                                    </a>
                                </div>
                                <div class="post-content">
                                    <div class="post-cat">
                                        <div class="post-cat-list">
                                            <?php echo blogar_post_categories_html($list_post_id, 1); // phpcs:ignore ?>
                                        </div>
                                    </div>
                                    <h4 class="title"><a
                                            href="<?php echo esc_url($list_post_url); ?>"><?php echo esc_html($list_post_title); ?></a>
                                    </h4>
                                    <div class="post-meta-wrapper">
                                        <div class="post-meta">
                                            <div class="post-author-avatar border-rounded">
                                                <img alt="<?php echo esc_attr($list_post_author); ?>"
                                                    src="<?php echo esc_url($list_post_avatar); ?>" width="50"
                                                    height="50">
                                            </div>
                                            <div class="content">
                                                <h6 class="post-author-name">
                                                    <a class="hover-flip-item-wrapper"
                                                        href="<?php echo esc_url($list_post_author_url); ?>">
                                                        <span class="hover-flip-item"><span
                                                                data-text="<?php echo esc_attr($list_post_author); ?>"><?php echo esc_html($list_post_author); ?></span></span>
                                                    </a>
                                                </h6>
                                                <ul class="post-meta-list">
                                                    <li class="post-meta-date"><?php echo esc_html($list_post_date); ?>
                                                    </li>
                                                    <li class="post-meta-reading-time">
                                                        <?php echo esc_html(blogar_reading_time($list_post_id)); ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <ul class="social-share-transparent justify-content-end">
                                            <li><a href="<?php echo esc_url($list_share_urls['facebook']); ?>"
                                                    target="_blank" rel="noopener nofollow"
                                                    aria-label="Facebook"><?php echo $svg_fb; // phpcs:ignore ?></a>
                                            </li>
                                            <li><a href="<?php echo esc_url($list_share_urls['twitter']); ?>"
                                                    target="_blank" rel="noopener nofollow"
                                                    aria-label="Twitter"><?php echo $svg_tw; // phpcs:ignore ?></a></li>
                                            <li><a href="<?php echo esc_url($list_share_urls['linkedin']); ?>"
                                                    target="_blank" rel="noopener nofollow"
                                                    aria-label="LinkedIn"><?php echo $svg_li; // phpcs:ignore ?></a>
                                            </li>
                                            <li><button class="axilcopyLink"
                                                    data-link="<?php echo esc_url($list_post_url); ?>"
                                                    aria-label="Copy link"><?php echo $svg_lk; // phpcs:ignore ?></button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                            <?php else: ?>
                            <div class="content-block post-list-view axil-control mt--30">
                                <div class="post-thumbnail">
                                    <a href="#">
                                        <img loading="lazy" decoding="async" width="300" height="169"
                                            src="<?php echo esc_url(blogar_thumbnail_url(0, 'blogar-list')); ?>"
                                            alt="<?php esc_attr_e('Placeholder image', 'blogar'); ?>">
                                    </a>
                                </div>
                                <div class="post-content">
                                    <h4 class="title">
                                        <?php esc_html_e('No posts available for this section yet.', 'blogar'); ?></h4>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div><!-- .post-list-main -->

                    <!-- Sidebar -->
                    <aside class="widgets-sidebar">

                        <!-- Search widget -->
                        <div class="search-2 widget-sidebar widget widget_search">
                            <div class="widget-title">
                                <h3>Search</h3>
                            </div>
                            <div class="inner">
                                <form action="<?php echo esc_url(home_url('/')); ?>" method="GET" class="blog-search">
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

                        <!-- Recent posts widget -->
                        <div class="blogar_recent_post widget-sidebar widget widget_blogar_recent_post">
                            <div class="widget-title">
                                <h3><?php echo esc_html($post_list_sidebar_data['recent_title']); ?></h3>
                            </div>
                            <?php if ($post_list_sidebar_data['recent_query']->have_posts()): ?>
                            <?php while ($post_list_sidebar_data['recent_query']->have_posts()):
                                $post_list_sidebar_data['recent_query']->the_post();
                                $recent_post_id = get_the_ID();
                                $recent_post_url = get_permalink($recent_post_id);
                                $recent_post_title = get_the_title($recent_post_id);
                                $recent_thumb_url = blogar_thumbnail_url($recent_post_id, 'blogar-thumb');
                                $recent_thumb_alt = blogar_thumbnail_alt($recent_post_id);
                                ?>
                            <div class="content-block post-medium mb--20">
                                <div class="post-thumbnail">
                                    <a href="<?php echo esc_url($recent_post_url); ?>">
                                        <img loading="lazy" decoding="async" width="150" height="150"
                                            src="<?php echo esc_url($recent_thumb_url); ?>"
                                            alt="<?php echo esc_attr($recent_thumb_alt); ?>">
                                    </a>
                                </div>
                                <div class="post-content">
                                    <h6 class="title"><a
                                            href="<?php echo esc_url($recent_post_url); ?>"><?php echo esc_html($recent_post_title); ?></a>
                                    </h6>
                                    <div class="post-meta">
                                        <ul class="post-meta-list">
                                            <li><?php echo esc_html(get_the_date('', $recent_post_id)); ?></li>
                                            <li><?php echo esc_html(blogar_reading_time($recent_post_id)); ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                            <?php else: ?>
                            <div class="content-block post-medium mb--20">
                                <div class="post-thumbnail">
                                    <a href="#">
                                        <img loading="lazy" decoding="async" width="150" height="150"
                                            src="<?php echo esc_url(blogar_thumbnail_url(0, 'blogar-thumb')); ?>"
                                            alt="<?php esc_attr_e('Placeholder image', 'blogar'); ?>">
                                    </a>
                                </div>
                                <div class="post-content">
                                    <h6 class="title"><?php esc_html_e('No recent posts available.', 'blogar'); ?></h6>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Social widget -->
                        <div class="blobar_social_widget widget-sidebar widget">
                            <div class="widget-title">
                                <h3>Stay In Touch</h3>
                            </div>
                            <ul class="social-icon md-size">
                                <li><a href="#" aria-label="Facebook"><?php echo $svg_fb; // phpcs:ignore ?></a></li>
                                <li><a href="#" aria-label="Twitter"><?php echo $svg_tw; // phpcs:ignore ?></a></li>
                                <li><a href="#" aria-label="Instagram"><?php echo $svg_ig; // phpcs:ignore ?></a></li>
                                <li><a href="#" aria-label="Pinterest"><?php echo $svg_pi; // phpcs:ignore ?></a></li>
                                <li><a href="#" aria-label="LinkedIn"><?php echo $svg_li; // phpcs:ignore ?></a></li>
                            </ul>
                        </div>

                        <!-- Gallery widget -->
                        <div class="media_gallery widget-sidebar widget widget_media_gallery">
                            <div class="widget-title">
                                <h3>Gallery</h3>
                            </div>
                            <div class="gallery gallery-columns-3">
                                <?php
                                $gallery_imgs = array(
                                    array('img' => 'demo_image-26-150x150.jpg', 'alt' => 'demo_image-26'),
                                    array('img' => 'post-column-01-13-150x150.jpg', 'alt' => 'post-column-01-13'),
                                    array('img' => 'demo_image-6-150x150.jpg', 'alt' => 'demo_image-6'),
                                    array('img' => 'demo_image-38-1-150x150.jpg', 'alt' => 'demo_image-38-1'),
                                    array('img' => 'post-column-01-4-150x150.jpg', 'alt' => 'post-column-01-4'),
                                    array('img' => 'demo_image-28-150x150.jpg', 'alt' => 'demo_image-28'),
                                );
                                foreach ($gallery_imgs as $gi): ?>
                                <figure class="gallery-item">
                                    <div class="gallery-icon">
                                        <a href="#">
                                            <img loading="lazy" decoding="async" width="150" height="150"
                                                src="<?php echo esc_url($img . $gi['img']); ?>"
                                                alt="<?php echo esc_attr($gi['alt']); ?>">
                                        </a>
                                    </div>
                                </figure>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </aside><!-- .widgets-sidebar -->

                </div><!-- .post-list-layout -->
            </div><!-- .container -->
        </section>


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
                            <a href="<?php echo esc_url($video_big_url); ?>"
                                class="video-post-link">
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
                                            src="<?php echo esc_url($video_big_avatar); ?>"
                                            width="50" height="50">
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
                                                <?php echo esc_html(get_the_date('', $video_big_id)); ?></li>
                                            <li class="post-meta-reading-time">
                                                <?php echo esc_html(blogar_reading_time($video_big_id)); ?></li>
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
                                    <li><button class="axilcopyLink"
                                            data-link="<?php echo esc_url($video_big_url); ?>"
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



        <!-- ================================================================
     SECTION 11 — INSTAGRAM
     ================================================================ -->
        <section class="axil-instagram-area axil-section-gap bg-color-grey">
            <div class="container">
                <div class="section-title">
                    <h2 class="title">Instagram</h2>
                </div>
                <div class="blogar-instagram-header mt--30">
                    <a class="blogar-instagram-profile" href="https://www.instagram.com/axilthemes/" target="_blank"
                        rel="noopener nofollow" aria-label="Instagram axilthemes">
                        <span class="blogar-instagram-profile-icon"
                            aria-hidden="true"><?php echo $svg_ig; // phpcs:ignore ?></span>
                        <span class="blogar-instagram-profile-name">axilthemes</span>
                    </a>
                </div>
                <div class="instagram-post-list blogar-instagram-grid mt--30">
                    <?php
            $grams = array(
                array('img' => 'demo_image-26-300x300.jpg', 'alt' => 'Instagram 1'),
                array('img' => 'post-column-01-13-300x300.jpg', 'alt' => 'Instagram 2'),
                array('img' => 'demo_image-6-300x300.jpg', 'alt' => 'Instagram 3'),
                array('img' => 'demo_image-38-1-300x300.jpg', 'alt' => 'Instagram 4'),
                array('img' => 'post-column-01-4-300x300.jpg', 'alt' => 'Instagram 5'),
                array('img' => 'demo_image-28-300x300.jpg', 'alt' => 'Instagram 6'),
            );
            foreach ($grams as $g): ?>
                    <article class="single-post">
                        <a class="instagram-post-link" href="https://www.instagram.com/axilthemes/" target="_blank"
                            rel="noopener nofollow">
                            <img src="<?php echo esc_url($img . $g['img']); ?>"
                                alt="<?php echo esc_attr($g['alt']); ?>">
                            <span class="instagram-overlay" aria-hidden="true"></span>
                            <span class="instagram-button"
                                aria-hidden="true"><?php echo $svg_ig; // phpcs:ignore ?></span>
                        </a>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>


    </div><!-- .main-wrapper -->
</div><!-- .blogar-front-page-shell -->


<?php get_footer(); ?>
