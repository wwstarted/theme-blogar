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
     ================================================================ -->
<section class="slider-area bg-color-grey axil-section-gap">
    <div class="container">
        <div class="slider-activation-wrap">
            <div class="slider-activation" data-slider>

                <!-- Slide 1 -->
                <div class="content-block">
                    <div class="post-thumbnail">
                        <a href="#">
                            <img loading="lazy" decoding="async" width="1230" height="615"
                                src="<?php echo esc_url($img . 'gallery-post-03-1230x615.jpg'); ?>"
                                alt="gallery-post-03"
                                sizes="(max-width: 1230px) 100vw, 1230px">
                        </a>
                    </div>
                    <div class="post-content">
                        <div class="post-cat">
                            <div class="post-cat-list">
                                <a class="hover-flip-item-wrapper" href="#">
                                    <span class="hover-flip-item"><span data-text="Careers">Careers</span></span>
                                </a>
                            </div>
                        </div>
                        <h1 class="title">
                            <a href="#">iPadOS 14 introduces new designed specifically for iPad</a>
                        </h1>
                        <div class="post-meta-wrapper with-button">
                            <div class="post-meta">
                                <div class="post-author-avatar border-rounded">
                                    <img alt="axilthemes"
                                        src="https://secure.gravatar.com/avatar/1b70c830da30f39d5c6fab323017430c?s=50&d=mm&r=g"
                                        width="50" height="50">
                                </div>
                                <div class="content">
                                    <h6 class="post-author-name">
                                        <a class="hover-flip-item-wrapper" href="#">
                                            <span class="hover-flip-item"><span data-text="axilthemes">axilthemes</span></span>
                                        </a>
                                    </h6>
                                    <ul class="post-meta-list">
                                        <li class="post-meta-date">January 24, 2021</li>
                                        <li class="post-meta-reading-time">4 min read</li>
                                    </ul>
                                </div>
                            </div>
                            <ul class="social-share-transparent">
                                <li><a href="#" target="_blank" class="aw-facebook" aria-label="Share on Facebook"><?php echo $svg_fb; // phpcs:ignore ?></a></li>
                                <li><a href="#" target="_blank" class="aw-twitter" aria-label="Share on Twitter"><?php echo $svg_tw; // phpcs:ignore ?></a></li>
                                <li><a href="#" target="_blank" class="aw-linkdin" aria-label="Share on LinkedIn"><?php echo $svg_li; // phpcs:ignore ?></a></li>
                                <li><button class="axilcopyLink" title="Copy Link" data-link="#" aria-label="Copy link"><?php echo $svg_lk; // phpcs:ignore ?></button></li>
                            </ul>
                            <div class="read-more-button cerchio">
                                <a class="axil-button button-rounded hover-flip-item-wrapper" href="#">
                                    <span class="hover-flip-item"><span data-text="Read Post">Read Post</span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Slide 1 -->

                <!-- Slide 2 -->
                <div class="content-block">
                    <div class="post-thumbnail">
                        <a href="#">
                            <img loading="lazy" decoding="async" width="1230" height="615"
                                src="<?php echo esc_url($img . 'demo_image-41-1230x615.jpg'); ?>"
                                alt="demo_image-41"
                                sizes="(max-width: 1230px) 100vw, 1230px">
                        </a>
                    </div>
                    <div class="post-content">
                        <div class="post-cat">
                            <div class="post-cat-list">
                                <a class="hover-flip-item-wrapper" href="#">
                                    <span class="hover-flip-item"><span data-text="Careers">Careers</span></span>
                                </a>
                            </div>
                        </div>
                        <h2 class="title">
                            <a href="#">4 types of research methods all designers should know</a>
                        </h2>
                        <div class="post-meta-wrapper with-button">
                            <div class="post-meta">
                                <div class="post-author-avatar border-rounded">
                                    <img alt="axilthemes"
                                        src="https://secure.gravatar.com/avatar/1b70c830da30f39d5c6fab323017430c?s=50&d=mm&r=g"
                                        width="50" height="50">
                                </div>
                                <div class="content">
                                    <h6 class="post-author-name">
                                        <a class="hover-flip-item-wrapper" href="#">
                                            <span class="hover-flip-item"><span data-text="axilthemes">axilthemes</span></span>
                                        </a>
                                    </h6>
                                    <ul class="post-meta-list">
                                        <li class="post-meta-date">January 24, 2021</li>
                                        <li class="post-meta-reading-time">4 min read</li>
                                    </ul>
                                </div>
                            </div>
                            <ul class="social-share-transparent">
                                <li><a href="#" target="_blank" class="aw-facebook" aria-label="Share on Facebook"><?php echo $svg_fb; // phpcs:ignore ?></a></li>
                                <li><a href="#" target="_blank" class="aw-twitter" aria-label="Share on Twitter"><?php echo $svg_tw; // phpcs:ignore ?></a></li>
                                <li><a href="#" target="_blank" class="aw-linkdin" aria-label="Share on LinkedIn"><?php echo $svg_li; // phpcs:ignore ?></a></li>
                                <li><button class="axilcopyLink" title="Copy Link" data-link="#" aria-label="Copy link"><?php echo $svg_lk; // phpcs:ignore ?></button></li>
                            </ul>
                            <div class="read-more-button cerchio">
                                <a class="axil-button button-rounded hover-flip-item-wrapper" href="#">
                                    <span class="hover-flip-item"><span data-text="Read Post">Read Post</span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Slide 2 -->

                <!-- Slide 3 -->
                <div class="content-block">
                    <div class="post-thumbnail">
                        <a href="#">
                            <img loading="lazy" decoding="async" width="1230" height="615"
                                src="<?php echo esc_url($img . 'post-column-01-9-1230x615.jpg'); ?>"
                                alt="post-column-01-9"
                                sizes="(max-width: 1230px) 100vw, 1230px">
                        </a>
                    </div>
                    <div class="post-content">
                        <div class="post-cat">
                            <div class="post-cat-list">
                                <a class="hover-flip-item-wrapper" href="#">
                                    <span class="hover-flip-item"><span data-text="Careers">Careers</span></span>
                                </a>
                            </div>
                        </div>
                        <h2 class="title">
                            <a href="#">These 5 tips will help you nail your next design presentation</a>
                        </h2>
                        <div class="post-meta-wrapper with-button">
                            <div class="post-meta">
                                <div class="post-author-avatar border-rounded">
                                    <img alt="axilthemes"
                                        src="https://secure.gravatar.com/avatar/1b70c830da30f39d5c6fab323017430c?s=50&d=mm&r=g"
                                        width="50" height="50">
                                </div>
                                <div class="content">
                                    <h6 class="post-author-name">
                                        <a class="hover-flip-item-wrapper" href="#">
                                            <span class="hover-flip-item"><span data-text="axilthemes">axilthemes</span></span>
                                        </a>
                                    </h6>
                                    <ul class="post-meta-list">
                                        <li class="post-meta-date">January 24, 2021</li>
                                        <li class="post-meta-reading-time">4 min read</li>
                                    </ul>
                                </div>
                            </div>
                            <ul class="social-share-transparent">
                                <li><a href="#" target="_blank" class="aw-facebook" aria-label="Share on Facebook"><?php echo $svg_fb; // phpcs:ignore ?></a></li>
                                <li><a href="#" target="_blank" class="aw-twitter" aria-label="Share on Twitter"><?php echo $svg_tw; // phpcs:ignore ?></a></li>
                                <li><a href="#" target="_blank" class="aw-linkdin" aria-label="Share on LinkedIn"><?php echo $svg_li; // phpcs:ignore ?></a></li>
                                <li><button class="axilcopyLink" title="Copy Link" data-link="#" aria-label="Copy link"><?php echo $svg_lk; // phpcs:ignore ?></button></li>
                            </ul>
                            <div class="read-more-button cerchio">
                                <a class="axil-button button-rounded hover-flip-item-wrapper" href="#">
                                    <span class="hover-flip-item"><span data-text="Read Post">Read Post</span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Slide 3 -->

            </div><!-- .slider-activation -->

            <!-- Prev / Next arrows -->
            <button class="slide-arrow prev-arrow" aria-label="<?php esc_attr_e('Previous slide', 'blogar'); ?>">
                <svg viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            </button>
            <button class="slide-arrow next-arrow" aria-label="<?php esc_attr_e('Next slide', 'blogar'); ?>">
                <svg viewBox="0 0 24 24"><path d="M5 12h14M12 19l7-7-7-7"/></svg>
            </button>
        </div><!-- .slider-activation-wrap -->

        <!-- Dots -->
        <div class="slider-dots" role="tablist" aria-label="<?php esc_attr_e('Slide navigation', 'blogar'); ?>"></div>
    </div><!-- .container -->
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
            <div class="content-block content-direction-column axil-control is-active post-horizontal thumb-border-rounded">
                <div class="post-content">
                    <div class="post-cat">
                        <div class="post-cat-list">
                            <a class="hover-flip-item-wrapper" href="#">
                                <span class="hover-flip-item"><span data-text="Lifestyle">Lifestyle</span></span>
                            </a>
                        </div>
                    </div>
                    <h4 class="title">
                        <a href="#">Fashion portrait of young businessman handsome model man in casual cloth.</a>
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
                                    <span class="hover-flip-item"><span data-text="axilthemes">axilthemes</span></span>
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
                            src="<?php echo esc_url($img . 'demo_image-300x169.jpg'); ?>"
                            alt="demo_image">
                    </a>
                </div>
            </div>
            <!-- End Post 1 -->

            <!-- Post 2 -->
            <div class="content-block content-direction-column axil-control is-active post-horizontal thumb-border-rounded">
                <div class="post-content">
                    <div class="post-cat">
                        <div class="post-cat-list">
                            <a class="hover-flip-item-wrapper" href="#">
                                <span class="hover-flip-item"><span data-text="Design">Design</span></span>
                            </a>
                        </div>
                    </div>
                    <h4 class="title">
                        <a href="#">Security isn&#8217;t just a technology problem it&#8217;s about design, too</a>
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
                                    <span class="hover-flip-item"><span data-text="axilthemes">axilthemes</span></span>
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
                            src="<?php echo esc_url($img . 'demo_image-5-300x169.jpg'); ?>"
                            alt="demo_image-5">
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
            src="<?php echo esc_url($img . 'banner-03.png'); ?>"
            alt="banner-03"
            sizes="(max-width: 1230px) 100vw, 1230px">
    </div>
</section>


<!-- ================================================================
     SECTION 4 — INNOVATION & TECH (tabs + 4-column grid)
     ================================================================ -->
<section class="axil-tab-area axil-section-gap bg-color-white">
    <div class="wrapper">
        <div class="container">
            <div class="section-title text-left">
                <h2 class="title">Innovation &amp; Tech</h2>
            </div>

            <ul class="axil-tab-button mt--20" role="tablist">
                <li role="presentation"><a class="tab-link active" data-tab="#tab-inno-1" role="tab" aria-selected="true">Accessibility</a></li>
                <li role="presentation"><a class="tab-link" data-tab="#tab-inno-2" role="tab" aria-selected="false">Android Dev</a></li>
                <li role="presentation"><a class="tab-link" data-tab="#tab-inno-3" role="tab" aria-selected="false">Gadgets</a></li>
            </ul>

            <div class="tab-content">

                <!-- Tab 1: Accessibility -->
                <div class="single-tab-content active" id="tab-inno-1" role="tabpanel">
                    <div class="modern-post-activation">
                        <?php
                        $inno_tab1 = array(
                            array('img' => 'post-column-01-1-390x260.jpg', 'alt' => 'post-column-01-1', 'cat' => 'Innovation', 'title' => 'Some claim lorem ipsum threatens'),
                            array('img' => 'post-column-01-390x260.jpg',   'alt' => 'post-column-01',   'cat' => 'Innovation', 'title' => 'Lightweight, grippable, and ready to go.'),
                            array('img' => 'post-column-01-15-390x260.jpg','alt' => 'post-column-01-15','cat' => 'Innovation', 'title' => 'Bold new experience. Same Mac magic.'),
                            array('img' => 'post-column-01-14-390x260.jpg','alt' => 'post-column-01-14','cat' => 'Innovation', 'title' => 'Creative Game With The New DJI Mavic Air 2'),
                        );
                        foreach ($inno_tab1 as $p) : ?>
                        <div class="slick-single-layout">
                            <div class="content-block modern-post-style text-center content-block-column">
                                <div class="post-content">
                                    <div class="post-cat">
                                        <div class="post-cat-list">
                                            <a class="hover-flip-item-wrapper" href="#">
                                                <span class="hover-flip-item"><span data-text="<?php echo esc_attr($p['cat']); ?>"><?php echo esc_html($p['cat']); ?></span></span>
                                            </a>
                                        </div>
                                    </div>
                                    <h4 class="title"><a href="#"><?php echo esc_html($p['title']); ?></a></h4>
                                </div>
                                <div class="post-thumbnail">
                                    <a href="#">
                                        <img loading="lazy" decoding="async" width="390" height="260"
                                            src="<?php echo esc_url($img . $p['img']); ?>"
                                            alt="<?php echo esc_attr($p['alt']); ?>">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Tab 2: Android Dev -->
                <div class="single-tab-content" id="tab-inno-2" role="tabpanel">
                    <div class="modern-post-activation">
                        <?php
                        $inno_tab2 = array(
                            array('img' => 'demo_image-21-390x260.jpg', 'alt' => 'demo_image-21', 'cat' => 'Mobile', 'title' => 'Oppo Find X2 Pro Review: Supercar Smartphone'),
                            array('img' => 'demo_image-16-390x260.jpg', 'alt' => 'demo_image-16', 'cat' => 'Mobile', 'title' => 'The new Moto G Stylus and G Power are surprisingly adept cameraphones'),
                            array('img' => 'demo_image-17-390x260.jpg', 'alt' => 'demo_image-17', 'cat' => 'Android', 'title' => 'Android 11 brings new controls for smart home devices'),
                            array('img' => 'demo_image-18-390x260.jpg', 'alt' => 'demo_image-18', 'cat' => 'Android', 'title' => 'Google is bringing its Pixel experience to more devices'),
                        );
                        foreach ($inno_tab2 as $p) : ?>
                        <div class="slick-single-layout">
                            <div class="content-block modern-post-style text-center content-block-column">
                                <div class="post-content">
                                    <div class="post-cat">
                                        <div class="post-cat-list">
                                            <a class="hover-flip-item-wrapper" href="#">
                                                <span class="hover-flip-item"><span data-text="<?php echo esc_attr($p['cat']); ?>"><?php echo esc_html($p['cat']); ?></span></span>
                                            </a>
                                        </div>
                                    </div>
                                    <h4 class="title"><a href="#"><?php echo esc_html($p['title']); ?></a></h4>
                                </div>
                                <div class="post-thumbnail">
                                    <a href="#">
                                        <img loading="lazy" decoding="async" width="390" height="260"
                                            src="<?php echo esc_url($img . $p['img']); ?>"
                                            alt="<?php echo esc_attr($p['alt']); ?>">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Tab 3: Gadgets -->
                <div class="single-tab-content" id="tab-inno-3" role="tabpanel">
                    <div class="modern-post-activation">
                        <?php
                        $inno_tab3 = array(
                            array('img' => 'post-column-01-1-390x260.jpg', 'alt' => 'post-column-01', 'cat' => 'Gadgets', 'title' => 'The best smart home gadgets to buy in 2021'),
                            array('img' => 'post-column-01-14-390x260.jpg','alt' => 'post-column-01-14','cat' => 'Gadgets','title' => 'Creative Game With The New DJI Mavic Air 2'),
                            array('img' => 'demo_image-21-390x260.jpg',    'alt' => 'demo_image-21',   'cat' => 'Gadgets', 'title' => 'Oppo Find X2 Pro: The definitive review'),
                            array('img' => 'post-column-01-15-390x260.jpg','alt' => 'post-column-01-15','cat' => 'Gadgets','title' => 'Bold new experience. Same Mac magic.'),
                        );
                        foreach ($inno_tab3 as $p) : ?>
                        <div class="slick-single-layout">
                            <div class="content-block modern-post-style text-center content-block-column">
                                <div class="post-content">
                                    <div class="post-cat">
                                        <div class="post-cat-list">
                                            <a class="hover-flip-item-wrapper" href="#">
                                                <span class="hover-flip-item"><span data-text="<?php echo esc_attr($p['cat']); ?>"><?php echo esc_html($p['cat']); ?></span></span>
                                            </a>
                                        </div>
                                    </div>
                                    <h4 class="title"><a href="#"><?php echo esc_html($p['title']); ?></a></h4>
                                </div>
                                <div class="post-thumbnail">
                                    <a href="#">
                                        <img loading="lazy" decoding="async" width="390" height="260"
                                            src="<?php echo esc_url($img . $p['img']); ?>"
                                            alt="<?php echo esc_attr($p['alt']); ?>">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div><!-- .tab-content -->
        </div><!-- .container -->
    </div><!-- .wrapper -->
</section>


<!-- ================================================================
     SECTION 5 — TRENDING TOPICS
     ================================================================ -->
<section class="axil-categories-list axil-section-gap bg-color-grey">
    <div class="container">
        <div class="categories-section-header">
            <div class="section-title text-left">
                <h2 class="title">Trending Topics</h2>
            </div>
            <div class="see-all-topics">
                <a class="axil-link-button" href="#">See All Topics</a>
            </div>
        </div>

        <div class="list-categories">
            <?php
            $cats = array(
                array('img' => 'bg-image-2-300x300.jpg',         'alt' => 'bg-image-2',         'label' => 'Travel'),
                array('img' => 'demo_image-30-300x300.jpg',      'alt' => 'demo_image-30',      'label' => 'Travel'),
                array('img' => 'demo_image-300x300.jpg',         'alt' => 'demo_image',         'label' => 'Red Dress'),
                array('img' => 'demo_image-28-300x300.jpg',      'alt' => 'demo_image-28',      'label' => 'Product Updates'),
                array('img' => 'demo_image-31-300x300.jpg',      'alt' => 'demo_image-31',      'label' => 'Lifestyle'),
                array('img' => 'demo_image-3-300x300.jpg',       'alt' => 'demo_image-3',       'label' => 'Food'),
                array('img' => 'post-column-01-4-300x300.jpg',   'alt' => 'post-column-01-4',   'label' => 'Food'),
                array('img' => 'demo_image-34-300x300.jpg',      'alt' => 'demo_image-34',      'label' => 'Accessibility'),
            );
            foreach ($cats as $cat) : ?>
            <div class="single-cat">
                <div class="inner">
                    <a href="#">
                        <div class="thumbnail">
                            <img loading="lazy" decoding="async" width="180" height="180"
                                src="<?php echo esc_url($img . $cat['img']); ?>"
                                alt="<?php echo esc_attr($cat['alt']); ?>">
                        </div>
                        <div class="content">
                            <h5 class="title"><?php echo esc_html($cat['label']); ?></h5>
                        </div>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div><!-- .list-categories -->
    </div><!-- .container -->
</section>


<!-- ================================================================
     SECTION 6 — MOST POPULAR (numbered list)
     ================================================================ -->
<section class="axil-trending-post-area axil-section-gap bg-color-white">
    <div class="wrapper">
        <div class="container">
            <div class="section-title text-left">
                <h2 class="title">Most Popular</h2>
            </div>

            <ul class="axil-tab-button mt--20" role="tablist">
                <li role="presentation"><a class="tab-link active" data-tab="#tab-trend-1" role="tab" aria-selected="true">Accessibility</a></li>
                <li role="presentation"><a class="tab-link" data-tab="#tab-trend-2" role="tab" aria-selected="false">Android Dev</a></li>
                <li role="presentation"><a class="tab-link" data-tab="#tab-trend-3" role="tab" aria-selected="false">Blockchain</a></li>
                <li role="presentation"><a class="tab-link" data-tab="#tab-trend-4" role="tab" aria-selected="false">Gadgets</a></li>
            </ul>

            <div class="tab-content">
                <?php
                $trend_tabs = array(
                    'tab-trend-1' => array(
                        array('img' => 'post-column-01-12-390x260.jpg', 'alt' => 'post-column-01-12', 'cats' => array('Creative', 'Digital'), 'title' => 'Lightweight, grippable, and ready to go.', 'author' => 'axilthemes', 'date' => 'January 24, 2021'),
                        array('img' => 'post-column-01-390x260.jpg',    'alt' => 'post-column-01',    'cats' => array('Creative', 'Digital'), 'title' => 'The 1 tool that helps remote teams collaborate better', 'author' => 'axilthemes', 'date' => 'January 24, 2021'),
                        array('img' => 'post-column-01-1-390x260.jpg',  'alt' => 'post-column-01-1',  'cats' => array('Creative', 'Digital'), 'title' => 'Lightweight, grippable, and ready to go.', 'author' => 'axilthemes', 'date' => 'January 22, 2021'),
                        array('img' => 'demo_image-27-1-390x260.jpg',   'alt' => 'demo_image-27',     'cats' => array('Creative', 'Design'),  'title' => 'Traditional design won\'t save us in the COVID-19 era', 'author' => 'axilthemes', 'date' => 'January 24, 2021'),
                    ),
                    'tab-trend-2' => array(
                        array('img' => 'demo_image-21-390x260.jpg', 'alt' => 'demo_image-21', 'cats' => array('Mobile', 'Review'), 'title' => 'Oppo Find X2 Pro Review: Supercar Smartphone', 'author' => 'axilthemes', 'date' => 'January 20, 2021'),
                        array('img' => 'demo_image-16-390x260.jpg', 'alt' => 'demo_image-16', 'cats' => array('Mobile'),           'title' => 'The new Moto G Stylus and G Power are surprisingly adept cameraphones', 'author' => 'axilthemes', 'date' => 'January 19, 2021'),
                        array('img' => 'post-column-01-1-390x260.jpg','alt' => 'post-column-01-1','cats' => array('Innovation'),  'title' => 'Some claim lorem ipsum threatens', 'author' => 'axilthemes', 'date' => 'January 18, 2021'),
                        array('img' => 'post-column-01-15-390x260.jpg','alt' => 'post-column-01-15','cats' => array('Innovation'),'title' => 'Bold new experience. Same Mac magic.', 'author' => 'axilthemes', 'date' => 'January 17, 2021'),
                    ),
                    'tab-trend-3' => array(
                        array('img' => 'post-column-01-12-390x260.jpg','alt' => 'post-column-01-12','cats' => array('Blockchain'), 'title' => 'Lightweight, grippable, and ready to go.', 'author' => 'axilthemes', 'date' => 'January 24, 2021'),
                        array('img' => 'demo_image-4-390x260.jpg',     'alt' => 'demo_image-4',    'cats' => array('Blockchain'), 'title' => 'The underrated design book that transformed the', 'author' => 'axilthemes', 'date' => 'January 23, 2021'),
                        array('img' => 'post-column-01-390x260.jpg',   'alt' => 'post-column-01',  'cats' => array('Blockchain'), 'title' => 'Lightweight, grippable, and ready to go.', 'author' => 'axilthemes', 'date' => 'January 22, 2021'),
                        array('img' => 'demo_image-27-1-390x260.jpg',  'alt' => 'demo_image-27',   'cats' => array('Blockchain'), 'title' => 'Traditional design won\'t save us in the COVID-19 era', 'author' => 'axilthemes', 'date' => 'January 24, 2021'),
                    ),
                    'tab-trend-4' => array(
                        array('img' => 'post-column-01-14-390x260.jpg','alt' => 'post-column-01-14','cats' => array('Gadgets'),   'title' => 'Creative Game With The New DJI Mavic Air 2', 'author' => 'axilthemes', 'date' => 'January 24, 2021'),
                        array('img' => 'demo_image-21-390x260.jpg',    'alt' => 'demo_image-21',    'cats' => array('Gadgets'),   'title' => 'Oppo Find X2 Pro Review: Supercar Smartphone', 'author' => 'axilthemes', 'date' => 'January 20, 2021'),
                        array('img' => 'post-column-01-15-390x260.jpg','alt' => 'post-column-01-15','cats' => array('Gadgets'),   'title' => 'Bold new experience. Same Mac magic.', 'author' => 'axilthemes', 'date' => 'January 17, 2021'),
                        array('img' => 'post-column-01-1-390x260.jpg', 'alt' => 'post-column-01-1', 'cats' => array('Gadgets'),   'title' => 'Some claim lorem ipsum threatens', 'author' => 'axilthemes', 'date' => 'January 16, 2021'),
                    ),
                );
                $tab_is_first = true;
                foreach ($trend_tabs as $tab_id => $posts) :
                    $active = $tab_is_first ? ' active' : '';
                    $tab_is_first = false;
                ?>
                <div class="trend-tab-content<?php echo esc_attr($active); ?>" id="<?php echo esc_attr($tab_id); ?>" role="tabpanel">
                    <div class="trend-posts-full">
                        <?php $num = 1; foreach ($posts as $p) : ?>
                        <div class="content-block trend-post post-order-list axil-control">
                            <div class="post-inner">
                                <span class="post-order-number"><?php echo sprintf('%02d', $num); ?></span>
                                <div class="post-content">
                                    <div class="post-cat">
                                        <div class="post-cat-list">
                                            <?php foreach ($p['cats'] as $cat) : ?>
                                            <a class="hover-flip-item-wrapper" href="#">
                                                <span class="hover-flip-item"><span data-text="<?php echo esc_attr($cat); ?>"><?php echo esc_html($cat); ?></span></span>
                                            </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <h3 class="title"><a href="#"><?php echo esc_html($p['title']); ?></a></h3>
                                    <div class="post-meta-wrapper">
                                        <div class="post-meta">
                                            <div class="content">
                                                <h6 class="post-author-name">
                                                    <a class="hover-flip-item-wrapper" href="#">
                                                        <span class="hover-flip-item"><span data-text="<?php echo esc_attr($p['author']); ?>"><?php echo esc_html($p['author']); ?></span></span>
                                                    </a>
                                                </h6>
                                                <ul class="post-meta-list">
                                                    <li class="post-meta-date"><?php echo esc_html($p['date']); ?></li>
                                                    <li class="post-meta-reading-time">4 min read</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <ul class="social-share-transparent">
                                            <li><a href="#" target="_blank" class="aw-facebook" aria-label="Share on Facebook"><?php echo $svg_fb; // phpcs:ignore ?></a></li>
                                            <li><a href="#" target="_blank" class="aw-twitter" aria-label="Share on Twitter"><?php echo $svg_tw; // phpcs:ignore ?></a></li>
                                            <li><a href="#" target="_blank" class="aw-linkdin" aria-label="Share on LinkedIn"><?php echo $svg_li; // phpcs:ignore ?></a></li>
                                            <li><button class="axilcopyLink" title="Copy Link" data-link="#" aria-label="Copy link"><?php echo $svg_lk; // phpcs:ignore ?></button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="post-thumbnail">
                                <a href="#">
                                    <img loading="lazy" decoding="async" width="390" height="260"
                                        src="<?php echo esc_url($img . $p['img']); ?>"
                                        alt="<?php echo esc_attr($p['alt']); ?>">
                                </a>
                            </div>
                        </div>
                        <?php $num++; endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div><!-- .tab-content -->
        </div><!-- .container -->
    </div><!-- .wrapper -->
</section>


<!-- ================================================================
     SECTION 7 — SOCIAL NETWORKS
     ================================================================ -->
<section class="axil-post-grid-area bg-color-grey">
    <div class="container">
        <div class="axil-social-wrapper bg-color-white radius">
            <ul class="social-with-text">
                <li class="twitter"><a href="#" target="_blank" rel="nofollow"><?php echo $svg_tw; // phpcs:ignore ?><span>Twitter</span></a></li>
                <li class="facebook"><a href="#" target="_blank" rel="nofollow"><?php echo $svg_fb; // phpcs:ignore ?><span>Facebook</span></a></li>
                <li class="youtube"><a href="#" target="_blank" rel="nofollow"><?php echo $svg_yt; // phpcs:ignore ?><span>Youtube</span></a></li>
                <li class="dribbble"><a href="#" target="_blank" rel="nofollow"><?php echo $svg_db; // phpcs:ignore ?><span>Dribbble</span></a></li>
                <li class="behance"><a href="#" target="_blank" rel="nofollow"><?php echo $svg_be; // phpcs:ignore ?><span>Behance</span></a></li>
                <li class="linkedin"><a href="#" target="_blank" rel="nofollow"><?php echo $svg_li; // phpcs:ignore ?><span>Linkedin</span></a></li>
            </ul>
        </div>
    </div>
</section>


<!-- ================================================================
     SECTION 8 — MOST POPULAR (grid)
     ================================================================ -->
<section class="axil-post-grid-area axil-section-gap bg-color-grey">
    <div class="wrapper">
        <div class="container">
            <div class="section-title text-left">
                <h2 class="title">Most Popular</h2>
            </div>

            <ul class="axil-tab-button mt--20" role="tablist">
                <li role="presentation"><a class="tab-link active" data-tab="#tab-grid-1" role="tab" aria-selected="true">Accessibility</a></li>
                <li role="presentation"><a class="tab-link" data-tab="#tab-grid-2" role="tab" aria-selected="false">Android Dev</a></li>
                <li role="presentation"><a class="tab-link" data-tab="#tab-grid-3" role="tab" aria-selected="false">Blockchain</a></li>
                <li role="presentation"><a class="tab-link" data-tab="#tab-grid-4" role="tab" aria-selected="false">Gadgets</a></li>
            </ul>

            <div class="grid-tab-content tab-content mt--10">

                <?php
                $grid_tabs = array(
                    'tab-grid-1' => array(
                        'big'   => array('img' => 'demo_image-9-705x660.jpg',  'alt' => 'demo_image-9',  'cat' => 'iPhone',  'title' => 'Apple reimagines the iPhone experience with iOS 14', 'size' => 'axil-big-post-image', 'date' => 'January 24, 2021'),
                        'small' => array(
                            array('img' => 'demo_image-4-495x300.jpg',  'alt' => 'demo_image-4',  'cat' => 'iPhone', 'title' => 'The underrated design book that transformed the'),
                            array('img' => 'demo_image-24-495x300.jpg', 'alt' => 'demo_image-24', 'cat' => 'iPhone', 'title' => 'iPadOS 14 new designed specifically for iPad'),
                        ),
                    ),
                    'tab-grid-2' => array(
                        'big'   => array('img' => 'demo_image-21-705x660.jpg', 'alt' => 'demo_image-21', 'cat' => 'Mobile',  'title' => 'Oppo Find X2 Pro Review: Supercar Smartphone', 'size' => 'axil-big-post-image', 'date' => 'January 20, 2021'),
                        'small' => array(
                            array('img' => 'demo_image-16-495x300.jpg', 'alt' => 'demo_image-16', 'cat' => 'Mobile', 'title' => 'The new Moto G Stylus and G Power are surprisingly adept cameraphones'),
                            array('img' => 'demo_image-9-495x300.jpg',  'alt' => 'demo_image-9',  'cat' => 'iPhone', 'title' => 'Apple reimagines the iPhone experience with iOS 14'),
                        ),
                    ),
                    'tab-grid-3' => array(
                        'big'   => array('img' => 'post-column-01-12-705x660.jpg', 'alt' => 'post-column-01-12', 'cat' => 'Creative', 'title' => 'Lightweight, grippable, and ready to go.', 'size' => 'axil-big-post-image', 'date' => 'January 22, 2021'),
                        'small' => array(
                            array('img' => 'demo_image-4-495x300.jpg',  'alt' => 'demo_image-4',  'cat' => 'Design',  'title' => 'The underrated design book that transformed the'),
                            array('img' => 'demo_image-27-1-495x300.jpg','alt' => 'demo_image-27','cat' => 'Creative','title' => 'Traditional design won\'t save us in the COVID-19 era'),
                        ),
                    ),
                    'tab-grid-4' => array(
                        'big'   => array('img' => 'post-column-01-14-705x660.jpg', 'alt' => 'post-column-01-14', 'cat' => 'Gadgets', 'title' => 'Creative Game With The New DJI Mavic Air 2', 'size' => 'axil-big-post-image', 'date' => 'January 21, 2021'),
                        'small' => array(
                            array('img' => 'demo_image-21-495x300.jpg', 'alt' => 'demo_image-21', 'cat' => 'Gadgets', 'title' => 'Oppo Find X2 Pro: The definitive review'),
                            array('img' => 'post-column-01-1-495x300.jpg','alt' => 'post-column-01-1','cat' => 'Gadgets','title' => 'Some claim lorem ipsum threatens'),
                        ),
                    ),
                );
                $grid_first = true;
                foreach ($grid_tabs as $tab_id => $tab) :
                    $active = $grid_first ? ' active' : '';
                    $grid_first = false;
                    $big   = $tab['big'];
                    $smalls = $tab['small'];
                ?>
                <div class="trend-tab-content<?php echo esc_attr($active); ?>" id="<?php echo esc_attr($tab_id); ?>" role="tabpanel">
                    <div class="post-grid-layout">
                        <!-- Big post (left) -->
                        <div class="post-grid-main">
                            <div class="content-block post-grid post-grid-large mt--30 <?php echo esc_attr($big['size']); ?>">
                                <div class="post-thumbnail">
                                    <a href="#">
                                        <img loading="lazy" decoding="async"
                                            src="<?php echo esc_url($img . $big['img']); ?>"
                                            alt="<?php echo esc_attr($big['alt']); ?>">
                                    </a>
                                </div>
                                <div class="post-grid-content">
                                    <div class="post-content">
                                        <div class="post-cat">
                                            <div class="post-cat-list">
                                                <a class="hover-flip-item-wrapper" href="#">
                                                    <span class="hover-flip-item"><span data-text="<?php echo esc_attr($big['cat']); ?>"><?php echo esc_html($big['cat']); ?></span></span>
                                                </a>
                                            </div>
                                        </div>
                                        <h3 class="title"><a href="#"><?php echo esc_html($big['title']); ?></a></h3>
                                        <div class="post-meta-wrapper">
                                            <div class="post-meta">
                                                <div class="post-author-avatar border-rounded">
                                                    <img alt="axilthemes"
                                                        src="https://secure.gravatar.com/avatar/1b70c830da30f39d5c6fab323017430c?s=50&d=mm&r=g"
                                                        width="50" height="50">
                                                </div>
                                                <div class="content">
                                                    <h6 class="post-author-name"><a href="#">axilthemes</a></h6>
                                                    <ul class="post-meta-list">
                                                        <li class="post-meta-date"><?php echo esc_html($big['date']); ?></li>
                                                        <li class="post-meta-reading-time">4 min read</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <ul class="social-share-transparent">
                                                <li><a href="#" target="_blank" aria-label="Facebook"><?php echo $svg_fb; // phpcs:ignore ?></a></li>
                                                <li><a href="#" target="_blank" aria-label="Twitter"><?php echo $svg_tw; // phpcs:ignore ?></a></li>
                                                <li><a href="#" target="_blank" aria-label="LinkedIn"><?php echo $svg_li; // phpcs:ignore ?></a></li>
                                                <li><button class="axilcopyLink" data-link="#" aria-label="Copy link"><?php echo $svg_lk; // phpcs:ignore ?></button></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Small posts (right) -->
                        <div class="post-grid-right">
                            <?php foreach ($smalls as $s) : ?>
                            <div class="content-block post-grid post-grid-large mt--30 axil-small-post-image">
                                <div class="post-thumbnail">
                                    <a href="#">
                                        <img loading="lazy" decoding="async"
                                            src="<?php echo esc_url($img . $s['img']); ?>"
                                            alt="<?php echo esc_attr($s['alt']); ?>">
                                    </a>
                                </div>
                                <div class="post-grid-content">
                                    <div class="post-content">
                                        <div class="post-cat">
                                            <div class="post-cat-list">
                                                <a class="hover-flip-item-wrapper" href="#">
                                                    <span class="hover-flip-item"><span data-text="<?php echo esc_attr($s['cat']); ?>"><?php echo esc_html($s['cat']); ?></span></span>
                                                </a>
                                            </div>
                                        </div>
                                        <h3 class="title"><a href="#"><?php echo esc_html($s['title']); ?></a></h3>
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


<!-- ================================================================
     SECTION 9 — POST LIST + SIDEBAR
     ================================================================ -->
<section class="axil-post-list-area post-listview-visible-color bg-color-white">
    <div class="container">
        <div class="post-list-layout">

            <!-- Main content -->
            <div class="post-list-main">
                <img loading="lazy" decoding="async" width="810" height="210"
                    src="<?php echo esc_url($img . 'banner-01.png'); ?>"
                    alt="banner-01">

                <div class="axil-post-list-area mt--30">
                    <?php
                    $list_posts = array(
                        array('img' => 'demo_image-36-300x169.jpg', 'alt' => 'demo_image-36', 'cat' => 'Food',   'title' => 'I saw few die of hunger; of eating, a hundred thousand.', 'date' => 'January 17, 2021'),
                        array('img' => 'demo_image-38-300x169.jpg', 'alt' => 'demo_image-38', 'cat' => 'Design', 'title' => 'New Freehand Templates, built for the whole team', 'date' => 'January 15, 2021'),
                        array('img' => 'demo_image-300x169.jpg',    'alt' => 'demo_image',    'cat' => 'Design', 'title' => 'Security isn\'t just a technology problem it\'s about design, too', 'date' => 'January 14, 2021'),
                    );
                    foreach ($list_posts as $p) : ?>
                    <div class="content-block post-list-view axil-control mt--30">
                        <div class="post-thumbnail">
                            <a href="#">
                                <img loading="lazy" decoding="async" width="300" height="169"
                                    src="<?php echo esc_url($img . $p['img']); ?>"
                                    alt="<?php echo esc_attr($p['alt']); ?>">
                            </a>
                        </div>
                        <div class="post-content">
                            <div class="post-cat">
                                <div class="post-cat-list">
                                    <a class="hover-flip-item-wrapper" href="#">
                                        <span class="hover-flip-item"><span data-text="<?php echo esc_attr($p['cat']); ?>"><?php echo esc_html($p['cat']); ?></span></span>
                                    </a>
                                </div>
                            </div>
                            <h4 class="title"><a href="#"><?php echo esc_html($p['title']); ?></a></h4>
                            <div class="post-meta-wrapper">
                                <div class="post-meta">
                                    <div class="post-author-avatar border-rounded">
                                        <img alt="axilthemes"
                                            src="https://secure.gravatar.com/avatar/1b70c830da30f39d5c6fab323017430c?s=50&d=mm&r=g"
                                            width="50" height="50">
                                    </div>
                                    <div class="content">
                                        <h6 class="post-author-name"><a href="#">axilthemes</a></h6>
                                        <ul class="post-meta-list">
                                            <li class="post-meta-date"><?php echo esc_html($p['date']); ?></li>
                                            <li class="post-meta-reading-time">4 min read</li>
                                        </ul>
                                    </div>
                                </div>
                                <ul class="social-share-transparent">
                                    <li><a href="#" target="_blank" aria-label="Facebook"><?php echo $svg_fb; // phpcs:ignore ?></a></li>
                                    <li><a href="#" target="_blank" aria-label="Twitter"><?php echo $svg_tw; // phpcs:ignore ?></a></li>
                                    <li><a href="#" target="_blank" aria-label="LinkedIn"><?php echo $svg_li; // phpcs:ignore ?></a></li>
                                    <li><button class="axilcopyLink" data-link="#" aria-label="Copy link"><?php echo $svg_lk; // phpcs:ignore ?></button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div><!-- .post-list-main -->

            <!-- Sidebar -->
            <aside class="widgets-sidebar">

                <!-- Search widget -->
                <div class="search-2 widget-sidebar widget widget_search">
                    <div class="widget-title"><h3>Search</h3></div>
                    <div class="inner">
                        <form action="<?php echo esc_url(home_url('/')); ?>" method="GET" class="blog-search">
                            <div class="axil-search form-group">
                                <button type="submit" class="search-button" aria-label="<?php esc_attr_e('Search', 'blogar'); ?>">
                                    <?php echo $svg_search; // phpcs:ignore ?>
                                </button>
                                <input type="search" name="s" placeholder="<?php echo esc_attr__('Search ...', 'blogar'); ?>" value="<?php echo esc_attr(get_search_query()); ?>">
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Recent posts widget -->
                <div class="blogar_recent_post widget-sidebar widget widget_blogar_recent_post">
                    <div class="widget-title"><h3>Recent on Blogar</h3></div>
                    <?php
                    $recent = array(
                        array('img' => 'gallery-post-03-150x150.jpg',  'alt' => 'gallery-post-03',   'title' => 'iPadOS 14 introduces new designed specifically for',  'date' => 'January 24, 2021'),
                        array('img' => 'demo_image-41-150x150.jpg',    'alt' => 'demo_image-41',     'title' => '4 types of research methods all designers should know', 'date' => 'January 24, 2021'),
                        array('img' => 'post-column-01-9-150x150.jpg', 'alt' => 'post-column-01-9',  'title' => 'These 5 tips will help you nail your next design presentation', 'date' => 'January 24, 2021'),
                    );
                    foreach ($recent as $r) : ?>
                    <div class="content-block post-medium mb--20">
                        <div class="post-thumbnail">
                            <a href="#">
                                <img loading="lazy" decoding="async" width="150" height="150"
                                    src="<?php echo esc_url($img . $r['img']); ?>"
                                    alt="<?php echo esc_attr($r['alt']); ?>">
                            </a>
                        </div>
                        <div class="post-content">
                            <h6 class="title"><a href="#"><?php echo esc_html($r['title']); ?></a></h6>
                            <div class="post-meta">
                                <ul class="post-meta-list">
                                    <li><?php echo esc_html($r['date']); ?></li>
                                    <li>4 min read</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Social widget -->
                <div class="blobar_social_widget widget-sidebar widget">
                    <div class="widget-title"><h3>Stay In Touch</h3></div>
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
                    <div class="widget-title"><h3>Gallery</h3></div>
                    <div class="gallery gallery-columns-3">
                        <?php
                        $gallery_imgs = array(
                            array('img' => 'demo_image-26-150x150.jpg',       'alt' => 'demo_image-26'),
                            array('img' => 'post-column-01-13-150x150.jpg',   'alt' => 'post-column-01-13'),
                            array('img' => 'demo_image-6-150x150.jpg',        'alt' => 'demo_image-6'),
                            array('img' => 'demo_image-38-1-150x150.jpg',     'alt' => 'demo_image-38-1'),
                            array('img' => 'post-column-01-4-150x150.jpg',    'alt' => 'post-column-01-4'),
                            array('img' => 'demo_image-28-150x150.jpg',       'alt' => 'demo_image-28'),
                        );
                        foreach ($gallery_imgs as $gi) : ?>
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
<section class="axil-video-post-area axil-section-gap bg-color-black">
    <div class="container">
        <div class="section-title text-left">
            <h2 class="title">Featured Video</h2>
        </div>

        <div class="video-posts-grid">
            <!-- Big video post -->
            <div class="content-block post-default image-rounded mt--30 axil-big-post-image">
                <div class="post-thumbnail">
                    <a href="#">
                        <img loading="lazy" decoding="async" width="600" height="500"
                            src="<?php echo esc_url($img . 'demo_image-5-600x500.jpg'); ?>"
                            alt="demo_image-5">
                    </a>
                    <a class="video-popup position-top-center" href="#" aria-label="Play video">
                        <span class="play-icon"></span>
                    </a>
                </div>
                <div class="post-content">
                    <div class="post-cat">
                        <div class="post-cat-list">
                            <a class="hover-flip-item-wrapper" href="#">
                                <span class="hover-flip-item"><span data-text="Design">Design</span></span>
                            </a>
                        </div>
                    </div>
                    <h4 class="title"><a href="#">Security isn&#8217;t just a technology problem it&#8217;s about design, too</a></h4>
                    <div class="post-meta-wrapper">
                        <div class="post-meta">
                            <div class="post-author-avatar border-rounded">
                                <img alt="axilthemes"
                                    src="https://secure.gravatar.com/avatar/1b70c830da30f39d5c6fab323017430c?s=50&d=mm&r=g"
                                    width="50" height="50">
                            </div>
                            <div class="content">
                                <h6 class="post-author-name"><a href="#">axilthemes</a></h6>
                                <ul class="post-meta-list">
                                    <li class="post-meta-date">January 20, 2021</li>
                                    <li class="post-meta-reading-time">4 min read</li>
                                </ul>
                            </div>
                        </div>
                        <ul class="social-share-transparent">
                            <li><a href="#" target="_blank" aria-label="Facebook"><?php echo $svg_fb; // phpcs:ignore ?></a></li>
                            <li><a href="#" target="_blank" aria-label="Twitter"><?php echo $svg_tw; // phpcs:ignore ?></a></li>
                            <li><a href="#" target="_blank" aria-label="LinkedIn"><?php echo $svg_li; // phpcs:ignore ?></a></li>
                            <li><button class="axilcopyLink" data-link="#" aria-label="Copy link"><?php echo $svg_lk; // phpcs:ignore ?></button></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Small video posts (2x2 grid) -->
            <div class="video-posts-right">
                <?php
                $video_small = array(
                    array('img' => 'demo_image-32-285x190.jpg', 'alt' => 'demo_image-32', 'cat' => 'Product Updates', 'title' => 'Traditional design won\'t save us in the Covid-19 era'),
                    array('img' => 'demo_image-7-285x190.jpg',  'alt' => 'demo_image-7',  'cat' => 'Product Updates', 'title' => 'New: Freehand Templates, built for the whole team'),
                    array('img' => 'demo_image-7-285x190.jpg',  'alt' => 'demo_image-7',  'cat' => 'Product Updates', 'title' => 'The 1 tool that helps remote teams collaborate better'),
                    array('img' => 'demo_image-34-285x190.jpg', 'alt' => 'demo_image-34', 'cat' => 'Lifestyle',       'title' => 'A lifestyle you always being the focal point is innately unhealthy.'),
                );
                foreach ($video_small as $v) : ?>
                <div class="content-block post-default image-rounded mt--30 axil-small-post-image">
                    <div class="post-thumbnail">
                        <a href="#">
                            <img loading="lazy" decoding="async" width="285" height="190"
                                src="<?php echo esc_url($img . $v['img']); ?>"
                                alt="<?php echo esc_attr($v['alt']); ?>">
                        </a>
                        <a class="video-popup size-medium position-top-center" href="#" aria-label="Play video">
                            <span class="play-icon"></span>
                        </a>
                    </div>
                    <div class="post-content">
                        <div class="post-cat">
                            <div class="post-cat-list">
                                <a class="hover-flip-item-wrapper" href="#">
                                    <span class="hover-flip-item"><span data-text="<?php echo esc_attr($v['cat']); ?>"><?php echo esc_html($v['cat']); ?></span></span>
                                </a>
                            </div>
                        </div>
                        <h5 class="title"><a href="#"><?php echo esc_html($v['title']); ?></a></h5>
                    </div>
                </div>
                <?php endforeach; ?>
            </div><!-- .video-posts-right -->
        </div><!-- .video-posts-grid -->
    </div><!-- .container -->
</section>


    </div><!-- .main-wrapper -->
</div><!-- .blogar-front-page-shell -->


<!-- ================================================================
     SECTION 11 — INSTAGRAM
     ================================================================ -->
<section class="axil-instagram-area axil-section-gap bg-color-grey">
    <div class="container">
        <div class="section-title">
            <h2 class="title">Instagram</h2>
        </div>
        <div class="instagram-post-list blogar-instagram-grid mt--30">
            <?php
            $grams = array(
                array('img' => 'demo_image-26-300x300.jpg',        'alt' => 'Instagram 1'),
                array('img' => 'post-column-01-13-300x300.jpg',    'alt' => 'Instagram 2'),
                array('img' => 'demo_image-6-300x300.jpg',         'alt' => 'Instagram 3'),
                array('img' => 'demo_image-38-1-300x300.jpg',      'alt' => 'Instagram 4'),
                array('img' => 'post-column-01-4-300x300.jpg',     'alt' => 'Instagram 5'),
                array('img' => 'demo_image-28-300x300.jpg',        'alt' => 'Instagram 6'),
            );
            foreach ($grams as $g) : ?>
            <div class="single-post">
                <a href="#">
                    <img src="<?php echo esc_url($img . $g['img']); ?>" alt="<?php echo esc_attr($g['alt']); ?>">
                    <span class="instagram-button">View</span>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
