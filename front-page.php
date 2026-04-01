<?php
/**
 * Blogar — front-page.php
 * Homepage template
 *
 * Sections:
 *   1. Hero Slider (Slick) — 3 latest posts, 1 H1
 *   2. Sidebar Grid — 1 large + 2 small horizontal posts
 *   3. Ad Banner
 *   4. Innovation & Tech — Tab + Slick slider
 *   5. Trending Topics — Category slider
 *   6. Trending Posts + Sidebar
 *   7. Social Bar
 *   8. Most Popular — Tab grid
 *   9. Lifestyle — Post grid
 */

get_header();
?>

<main id="blg-main" role="main">

    <!-- ============================================================
         SECTION 1 — HERO SLIDER
         Rule: The ONLY <h1> on this page lives here (first slide title)
    ============================================================ -->
    <section class="slider-area bg-color-grey slider-activation-with-slick"
        aria-label="<?php esc_attr_e('Featured Posts', 'blogar'); ?>">
        <div class="axil-slide slider-style-1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="slider-activation axil-slick-arrow" id="blg-hero-slider">

                            <?php
                            $hero_query = new WP_Query([
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'posts_per_page' => 5,
                                'orderby' => 'date',
                                'order' => 'DESC',
                                'no_found_rows' => true,
                            ]);

                            $slide_index = 0;

                            if ($hero_query->have_posts()):
                                while ($hero_query->have_posts()):
                                    $hero_query->the_post();
                                    $post_id = get_the_ID();
                                    $cats = get_the_category($post_id);
                                    $img_url = get_the_post_thumbnail_url($post_id, 'blg-slider');
                                    $author_id = get_the_author_meta('ID');
                                    $read_time = blg_reading_time($post_id);
                                    ?>

                                    <!-- Slide -->
                                    <div class="content-block">

                                        <!-- Thumbnail -->
                                        <div class="post-thumbnail">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php if ($img_url): ?>
                                                    <img <?php echo $slide_index === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?>
                                                        src="<?php echo esc_url($img_url); ?>"
                                                        alt="<?php the_title_attribute(); ?>" decoding="async">
                                                <?php else: ?>
                                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/images/placeholder.jpg'); ?>"
                                                        alt="<?php the_title_attribute(); ?>">
                                                <?php endif; ?>
                                            </a>
                                        </div>

                                        <!-- Post content overlay -->
                                        <div class="post-content">

                                            <!-- Category -->
                                            <?php if (!empty($cats)): ?>
                                                <div class="post-cat">
                                                    <div class="post-cat-list">
                                                        <?php foreach (array_slice($cats, 0, 2) as $cat): ?>
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

                                            <!-- Title: H1 on first slide, H2 on rest -->
                                            <?php if ($slide_index === 0): ?>
                                                <h1 class="title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h1>
                                            <?php else: ?>
                                                <h2 class="title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h2>
                                            <?php endif; ?>

                                            <!-- Meta -->
                                            <div class="post-meta-wrapper with-button">
                                                <div class="post-meta">
                                                    <div class="post-author-avatar border-rounded">
                                                        <?php echo get_avatar($author_id, 50); ?>
                                                    </div>
                                                    <div class="content">
                                                        <h6 class="post-author-name">
                                                            <a class="hover-flip-item-wrapper"
                                                                href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                                                                <span class="hover-flip-item">
                                                                    <span
                                                                        data-text="<?php echo esc_attr(get_the_author()); ?>">
                                                                        <?php the_author(); ?>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </h6>
                                                        <ul class="post-meta-list">
                                                            <li class="post-meta-date"><?php echo esc_html(get_the_date()); ?>
                                                            </li>
                                                            <li class="post-meta-reading-time">
                                                                <?php echo esc_html($read_time); ?>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <a class="axil-button" href="<?php the_permalink(); ?>">
                                                    <?php esc_html_e('Read More', 'blogar'); ?>
                                                    <i class="fal fa-arrow-right"></i>
                                                </a>
                                            </div>

                                        </div><!-- /.post-content -->
                                    </div><!-- /.content-block (slide) -->

                                    <?php
                                    $slide_index++;
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>

                        </div><!-- /#blg-hero-slider -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero Slider -->


    <!-- ============================================================
         SECTION 2 — POST GRID ONE UPDATE
         Layout: 1 large featured (left) | 2 horizontal small (right)
    ============================================================ -->
    <section class="post-grid-one-update axil-section-gap bg-color-white">
        <div class="blg-container">
            <div class="row">

                <?php
                $grid_query = new WP_Query([
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'offset' => 5, // Skip the hero posts
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'no_found_rows' => true,
                ]);

                $grid_posts = [];
                if ($grid_query->have_posts()) {
                    while ($grid_query->have_posts()) {
                        $grid_query->the_post();
                        $grid_posts[] = get_post();
                    }
                    wp_reset_postdata();
                }
                ?>

                <!-- Large Featured Post (Left) -->
                <?php if (!empty($grid_posts[0])):
                    $fp = $grid_posts[0];
                    $fp_id = $fp->ID;
                    $fp_cats = get_the_category($fp_id);
                    $fp_img = get_the_post_thumbnail_url($fp_id, 'blg-hero-thumb');
                    $fp_auth = get_post_field('post_author', $fp_id);
                    ?>
                    <div class="col-lg-6 col-md-12 mb--30">
                        <div class="content-block image-rounded axil-featured">
                            <div class="post-thumbnail">
                                <a href="<?php echo esc_url(get_permalink($fp_id)); ?>">
                                    <?php if ($fp_img): ?>
                                        <img loading="lazy" src="<?php echo esc_url($fp_img); ?>"
                                            alt="<?php echo esc_attr(get_the_title($fp_id)); ?>" decoding="async">
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="post-content">
                                <?php if (!empty($fp_cats)): ?>
                                    <div class="post-cat">
                                        <div class="post-cat-list">
                                            <?php foreach (array_slice($fp_cats, 0, 2) as $cat): ?>
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
                                    <a href="<?php echo esc_url(get_permalink($fp_id)); ?>">
                                        <?php echo esc_html(get_the_title($fp_id)); ?>
                                    </a>
                                </h3>
                                <div class="post-meta">
                                    <div class="post-author-avatar border-rounded">
                                        <?php echo get_avatar($fp_auth, 50); ?>
                                    </div>
                                    <div class="content">
                                        <h6 class="post-author-name">
                                            <a href="<?php echo esc_url(get_author_posts_url($fp_auth)); ?>">
                                                <?php echo esc_html(get_the_author_meta('display_name', $fp_auth)); ?>
                                            </a>
                                        </h6>
                                        <ul class="post-meta-list">
                                            <li class="post-meta-date"><?php echo esc_html(get_the_date('', $fp_id)); ?>
                                            </li>
                                            <li class="post-meta-reading-time">
                                                <?php echo esc_html(blg_reading_time($fp_id)); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Right: 2 horizontal posts stacked -->
                <div class="col-lg-6 col-md-12">
                    <?php foreach ([1, 2] as $idx):
                        if (empty($grid_posts[$idx]))
                            continue;
                        $sp = $grid_posts[$idx];
                        $sp_id = $sp->ID;
                        $sp_cats = get_the_category($sp_id);
                        $sp_img = get_the_post_thumbnail_url($sp_id, 'blg-medium');
                        $sp_auth = get_post_field('post_author', $sp_id);
                        ?>
                        <div class="col-lg-6 col-xl-6 col-md-12 col-12 mt--30">
                            <div
                                class="content-block content-direction-column axil-control is-active post-horizontal thumb-border-rounded">
                                <div class="post-content">
                                    <?php if (!empty($sp_cats)): ?>
                                        <div class="post-cat">
                                            <div class="post-cat-list">
                                                <?php foreach (array_slice($sp_cats, 0, 1) as $cat): ?>
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
                                    <h4 class="title">
                                        <a href="<?php echo esc_url(get_permalink($sp_id)); ?>">
                                            <?php echo esc_html(get_the_title($sp_id)); ?>
                                        </a>
                                    </h4>
                                    <div class="post-meta">
                                        <div class="post-author-avatar border-rounded">
                                            <?php echo get_avatar($sp_auth, 50); ?>
                                        </div>
                                        <div class="content">
                                            <h6 class="post-author-name">
                                                <a href="<?php echo esc_url(get_author_posts_url($sp_auth)); ?>">
                                                    <?php echo esc_html(get_the_author_meta('display_name', $sp_auth)); ?>
                                                </a>
                                            </h6>
                                            <ul class="post-meta-list">
                                                <li class="post-meta-date">
                                                    <?php echo esc_html(get_the_date('', $sp_id)); ?>
                                                </li>
                                                <li class="post-meta-reading-time">
                                                    <?php echo esc_html(blg_reading_time($sp_id)); ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($sp_img): ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php echo esc_url(get_permalink($sp_id)); ?>">
                                            <img loading="lazy" src="<?php echo esc_url($sp_img); ?>"
                                                alt="<?php echo esc_attr(get_the_title($sp_id)); ?>" decoding="async">
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div><!-- /.row -->
        </div>
    </section>
    <!-- End Section 2 -->


    <!-- ============================================================
         SECTION 3 — AD BANNER
    ============================================================ -->
    <?php $banner_img = get_theme_mod('blg_home_ad_banner', ''); ?>
    <?php if ($banner_img): ?>
        <section class="blg-ad-banner bg-color-white" aria-label="<?php esc_attr_e('Advertisement', 'blogar'); ?>">
            <div class="blg-container">
                <img loading="lazy" src="<?php echo esc_url($banner_img); ?>"
                    alt="<?php esc_attr_e('Advertisement Banner', 'blogar'); ?>">
            </div>
        </section>
    <?php endif; ?>


    <!-- ============================================================
         SECTION 4 — INNOVATION & TECH (Tab + Slider)
    ============================================================ -->
    <?php
    // Define tabs: label => category slug
    $tech_tabs = apply_filters('blg_tech_tabs', [
        'tab1' => ['label' => __('Accessibility', 'blogar'), 'slug' => 'accessibility'],
        'tab2' => ['label' => __('Android Dev', 'blogar'), 'slug' => 'android-dev'],
        'tab3' => ['label' => __('Gadgets', 'blogar'), 'slug' => 'gadgets'],
    ]);

    $tech_section_title = get_theme_mod('blg_tech_section_title', __('Innovation &amp; Tech', 'blogar'));
    ?>
    <section class="axil-tab-area axil-section-gap bg-color-white" id="blg-tech-section">
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title text-left">
                            <h2 class="title"><?php echo wp_kses_post($tech_section_title); ?></h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <!-- Tab Buttons -->
                        <ul class="axil-tab-button nav nav-tabs mt--20" id="blg-tech-tabs" role="tablist">
                            <?php foreach ($tech_tabs as $tab_id => $tab):
                                $is_first = ($tab_id === array_key_first($tech_tabs));
                                ?>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link <?php echo $is_first ? 'active' : ''; ?>" data-toggle="tab"
                                        href="#blg-tech-<?php echo esc_attr($tab_id); ?>" role="tab"
                                        aria-selected="<?php echo $is_first ? 'true' : 'false'; ?>">
                                        <?php echo esc_html($tab['label']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <!-- End Tab Buttons -->

                        <!-- Tab Content -->
                        <div class="tab-content mt--30" id="blg-tech-tab-content">
                            <?php foreach ($tech_tabs as $tab_id => $tab):
                                $is_first = ($tab_id === array_key_first($tech_tabs));

                                $tab_query = new WP_Query([
                                    'post_type' => 'post',
                                    'post_status' => 'publish',
                                    'posts_per_page' => 6,
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                    'no_found_rows' => true,
                                    'category_name' => $tab['slug'],
                                ]);
                                ?>

                                <div class="single-tab-content tab-pane fade <?php echo $is_first ? 'show active' : ''; ?>"
                                    id="blg-tech-<?php echo esc_attr($tab_id); ?>" role="tabpanel">

                                    <div
                                        class="modern-post-activation slick-layout-wrapper axil-slick-arrow arrow-between-side">
                                        <?php
                                        if ($tab_query->have_posts()):
                                            while ($tab_query->have_posts()):
                                                $tab_query->the_post();
                                                $t_cats = get_the_category();
                                                $t_img = get_the_post_thumbnail_url(null, 'blg-tab-thumb');
                                                ?>

                                                <div class="slick-single-layout">
                                                    <div class="content-block modern-post-style text-center content-block-column">
                                                        <div class="post-content">
                                                            <?php if (!empty($t_cats)): ?>
                                                                <div class="post-cat">
                                                                    <div class="post-cat-list">
                                                                        <?php foreach (array_slice($t_cats, 0, 2) as $cat): ?>
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
                                                            <h4 class="title">
                                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                            </h4>
                                                        </div>
                                                        <?php if ($t_img): ?>
                                                            <div class="post-thumbnail">
                                                                <a href="<?php the_permalink(); ?>">
                                                                    <img loading="lazy" src="<?php echo esc_url($t_img); ?>"
                                                                        alt="<?php the_title_attribute(); ?>" decoding="async">
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                            <?php endwhile;
                                            wp_reset_postdata();
                                        endif;
                                        ?>
                                    </div><!-- /.modern-post-activation -->

                                </div><!-- /.tab-pane -->

                            <?php endforeach; ?>
                        </div><!-- /.tab-content -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Section 4 -->


    <!-- ============================================================
         SECTION 5 — TRENDING TOPICS (Category Slider)
    ============================================================ -->
    <?php
    $trending_cats = get_terms([
        'taxonomy' => 'category',
        'hide_empty' => true,
        'number' => 12,
        'exclude' => get_option('default_category'),
    ]);
    ?>
    <?php if (!is_wp_error($trending_cats) && !empty($trending_cats)): ?>
        <section class="axil-categories-list axil-section-gap bg-color-grey" id="blg-trending-categories">
            <div class="blg-container">

                <div class="row align-items-center mb--30">
                    <div class="col-lg-6 col-md-8 col-sm-8 col-12">
                        <div class="section-title text-left">
                            <h2 class="title"><?php esc_html_e('Trending Topics', 'blogar'); ?></h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-4 col-12">
                        <div class="see-all-topics text-left text-sm-right mt_mobile--20">
                            <a class="axil-link-button"
                                href="<?php echo esc_url(get_page_by_path('category') ? get_post_type_archive_link('post') : home_url('/')); ?>">
                                <?php esc_html_e('See All Topics', 'blogar'); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="list-categories categories-activation axil-slick-arrow arrow-between-side"
                            id="blg-categories-slider">
                            <?php foreach ($trending_cats as $cat):
                                $cat_img_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                                $cat_img_url = $cat_img_id
                                    ? wp_get_attachment_image_url($cat_img_id, 'blg-category-icon')
                                    : get_template_directory_uri() . '/images/category-placeholder.jpg';
                                ?>
                                <div class="single-cat">
                                    <div class="inner">
                                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
                                            <div class="thumbnail">
                                                <img loading="lazy" width="180" height="180"
                                                    src="<?php echo esc_url($cat_img_url); ?>" class="img-responsive"
                                                    alt="<?php echo esc_attr($cat->name); ?>" decoding="async">
                                            </div>
                                            <div class="content">
                                                <h5 class="title"><?php echo esc_html($cat->name); ?></h5>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    <?php endif; ?>
    <!-- End Section 5 -->


    <!-- ============================================================
         SECTION 6 — TRENDING POSTS + SIDEBAR
    ============================================================ -->
    <?php
    $trending_tabs = apply_filters('blg_trending_tabs', [
        'tt1' => ['label' => __('Accessibility', 'blogar'), 'slug' => 'accessibility'],
        'tt2' => ['label' => __('Android Dev', 'blogar'), 'slug' => 'android-dev'],
        'tt3' => ['label' => __('Tech & Review', 'blogar'), 'slug' => 'review'],
        'tt4' => ['label' => __('Gadgets', 'blogar'), 'slug' => 'gadgets'],
    ]);
    ?>
    <section class="axil-post-grid-area axil-section-gap bg-color-grey" id="blg-trending-section">
        <div class="blg-container">
            <div class="row">

                <!-- Main: Trending Tab List -->
                <div class="col-lg-8 col-md-12">
                    <div class="section-title text-left mb--20">
                        <h2 class="title"><?php esc_html_e('Trending Posts', 'blogar'); ?></h2>
                    </div>

                    <!-- Tab Buttons -->
                    <ul class="axil-tab-button nav nav-tabs mt--20" id="blg-trend-tabs" role="tablist">
                        <?php foreach ($trending_tabs as $tt_id => $tt):
                            $is_first = ($tt_id === array_key_first($trending_tabs));
                            ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link <?php echo $is_first ? 'active' : ''; ?>" data-toggle="tab"
                                    href="#blg-trend-<?php echo esc_attr($tt_id); ?>" role="tab"
                                    aria-selected="<?php echo $is_first ? 'true' : 'false'; ?>">
                                    <?php echo esc_html($tt['label']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- Tab Content -->
                    <div class="grid-tab-content tab-content mt--10">
                        <?php
                        $trend_num = 0;
                        foreach ($trending_tabs as $tt_id => $tt):
                            $is_first = ($tt_id === array_key_first($trending_tabs));

                            $trend_query = new WP_Query([
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'posts_per_page' => 4,
                                'orderby' => 'comment_count',
                                'order' => 'DESC',
                                'no_found_rows' => true,
                                'category_name' => $tt['slug'],
                            ]);
                            ?>
                            <div class="row trend-tab-content tab-pane fade <?php echo $is_first ? 'show active' : ''; ?>"
                                id="blg-trend-<?php echo esc_attr($tt_id); ?>" role="tabpanel">
                                <div class="col-lg-8">
                                    <?php
                                    $order = 1;
                                    if ($trend_query->have_posts()):
                                        while ($trend_query->have_posts()):
                                            $trend_query->the_post();
                                            $tr_id = get_the_ID();
                                            $tr_cats = get_the_category();
                                            $tr_img = get_the_post_thumbnail_url($tr_id, 'blg-tab-thumb');
                                            $tr_auth = get_the_author_meta('ID');
                                            ?>

                                            <div class="content-block trend-post post-order-list axil-control">
                                                <div class="post-inner">
                                                    <span
                                                        class="post-order-list"><?php echo esc_html(str_pad($order, 2, '0', STR_PAD_LEFT)); ?></span>
                                                    <div class="post-content">
                                                        <?php if (!empty($tr_cats)): ?>
                                                            <div class="post-cat">
                                                                <div class="post-cat-list">
                                                                    <?php foreach (array_slice($tr_cats, 0, 2) as $cat): ?>
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

                                                        <div class="post-meta-wrapper">
                                                            <div class="post-meta">
                                                                <div class="content">
                                                                    <h6 class="post-author-name">
                                                                        <a class="hover-flip-item-wrapper"
                                                                            href="<?php echo esc_url(get_author_posts_url($tr_auth)); ?>">
                                                                            <span class="hover-flip-item">
                                                                                <span
                                                                                    data-text="<?php echo esc_attr(get_the_author()); ?>">
                                                                                    <?php the_author(); ?>
                                                                                </span>
                                                                            </span>
                                                                        </a>
                                                                    </h6>
                                                                    <ul class="post-meta-list">
                                                                        <li class="post-meta-date">
                                                                            <?php echo esc_html(get_the_date()); ?>
                                                                        </li>
                                                                        <li class="post-meta-reading-time">
                                                                            <?php echo esc_html(blg_reading_time($tr_id)); ?>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <!-- Social share -->
                                                            <ul class="social-share-transparent justify-content-end">
                                                                <li>
                                                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode(get_permalink()); ?>"
                                                                        target="_blank" rel="noopener" class="aw-facebook"
                                                                        aria-label="Facebook">
                                                                        <i class="fab fa-facebook-f"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="https://twitter.com/share?url=<?php echo rawurlencode(get_permalink()); ?>&text=<?php echo rawurlencode(get_the_title()); ?>"
                                                                        target="_blank" rel="noopener" class="aw-twitter"
                                                                        aria-label="Twitter">
                                                                        <i class="fab fa-twitter"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="https://www.linkedin.com/shareArticle?url=<?php echo rawurlencode(get_permalink()); ?>&title=<?php echo rawurlencode(get_the_title()); ?>"
                                                                        target="_blank" rel="noopener" class="aw-linkdin"
                                                                        aria-label="LinkedIn">
                                                                        <i class="fab fa-linkedin-in"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>

                                                        </div><!-- /.post-meta-wrapper -->
                                                    </div><!-- /.post-content -->

                                                    <?php if ($tr_img): ?>
                                                        <div class="post-thumbnail">
                                                            <a href="<?php the_permalink(); ?>">
                                                                <img loading="lazy" src="<?php echo esc_url($tr_img); ?>"
                                                                    alt="<?php the_title_attribute(); ?>" decoding="async">
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>

                                                </div><!-- /.post-inner -->
                                            </div><!-- /.content-block.trend-post -->

                                            <?php
                                            $order++;
                                        endwhile;
                                        wp_reset_postdata();
                                    endif;
                                    ?>
                                </div><!-- /.col-lg-8 -->
                            </div><!-- /.trend-tab-content -->

                        <?php endforeach; ?>
                    </div><!-- /.grid-tab-content -->

                </div><!-- /.col-lg-8 -->


                <!-- Sidebar (Right) -->
                <div class="col-lg-4 col-md-12">
                    <?php if (is_active_sidebar('blg-home-sidebar')):
                        dynamic_sidebar('blg-home-sidebar');
                    else: ?>

                        <!-- Fallback: Latest Posts widget -->
                        <div class="widget-sidebar widget">
                            <div class="widget-title">
                                <h3><?php esc_html_e('Latest Posts', 'blogar'); ?></h3>
                            </div>
                            <?php
                            $latest = new WP_Query([
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'posts_per_page' => 4,
                                'no_found_rows' => true,
                            ]);
                            if ($latest->have_posts()):
                                while ($latest->have_posts()):
                                    $latest->the_post();
                                    $lt_img = get_the_post_thumbnail_url(null, 'blg-thumbnail');
                                    ?>
                                    <div class="content-block post-medium mb--20">
                                        <?php if ($lt_img): ?>
                                            <div class="post-thumbnail">
                                                <a href="<?php the_permalink(); ?>">
                                                    <img loading="lazy" src="<?php echo esc_url($lt_img); ?>"
                                                        alt="<?php the_title_attribute(); ?>" decoding="async">
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="post-content">
                                            <h6 class="title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h6>
                                            <div class="post-meta">
                                                <ul class="post-meta-list">
                                                    <li><?php echo esc_html(get_the_date()); ?></li>
                                                    <li><?php echo esc_html(blg_reading_time()); ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>

                    <?php endif; ?>
                </div><!-- /.col-lg-4 (sidebar) -->

            </div><!-- /.row -->
        </div>
    </section>
    <!-- End Section 6 -->


    <!-- ============================================================
         SECTION 7 — SOCIAL NETWORKS BAR
    ============================================================ -->
    <section class="axil-post-grid-area bg-color-grey" style="padding: 30px 0;">
        <div class="blg-container">
            <div class="axil-social-wrapper bg-color-white radius">
                <ul class="social-with-text">
                    <?php
                    $socials = apply_filters('blg_social_links', [
                        'twitter' => ['icon' => 'fab fa-twitter', 'label' => 'Twitter', 'class' => 'twitter'],
                        'facebook' => ['icon' => 'fab fa-facebook-f', 'label' => 'Facebook', 'class' => 'facebook'],
                        'youtube' => ['icon' => 'fab fa-youtube', 'label' => 'Youtube', 'class' => 'youtube'],
                        'dribbble' => ['icon' => 'fab fa-dribbble', 'label' => 'Dribbble', 'class' => 'dribbble'],
                        'behance' => ['icon' => 'fab fa-behance', 'label' => 'Behance', 'class' => 'behance'],
                        'linkedin' => ['icon' => 'fab fa-linkedin-in', 'label' => 'Linkedin', 'class' => 'linkedin'],
                    ]);

                    foreach ($socials as $key => $s):
                        $url = get_theme_mod('blg_social_' . $key, '#');
                        ?>
                        <li class="<?php echo esc_attr($s['class']); ?>">
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener nofollow"
                                aria-label="<?php echo esc_attr($s['label']); ?>">
                                <i class="<?php echo esc_attr($s['icon']); ?>"></i>
                                <span><?php echo esc_html($s['label']); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>
    <!-- End Section 7 -->


    <!-- ============================================================
         SECTION 8 — MOST POPULAR (Tab Grid: left col-8 + right sidebar)
    ============================================================ -->
    <?php
    $popular_tabs = apply_filters('blg_popular_tabs', [
        'pt1' => ['label' => __('Accessibility', 'blogar'), 'slug' => 'accessibility'],
        'pt2' => ['label' => __('Android Dev', 'blogar'), 'slug' => 'android-dev'],
        'pt3' => ['label' => __('Blockchain', 'blogar'), 'slug' => 'blockchain'],
        'pt4' => ['label' => __('Gadgets', 'blogar'), 'slug' => 'gadgets'],
    ]);
    ?>
    <section class="blg-most-popular-section axil-section-gap bg-color-grey" id="blg-popular-section">
        <div class="blg-container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-left">
                        <h2 class="title"><?php esc_html_e('Most Popular', 'blogar'); ?></h2>
                    </div>
                    <!-- Tab Buttons -->
                    <ul class="axil-tab-button nav nav-tabs mt--20" role="tablist">
                        <?php foreach ($popular_tabs as $pt_id => $pt):
                            $is_first = ($pt_id === array_key_first($popular_tabs));
                            ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link <?php echo $is_first ? 'active' : ''; ?>" data-toggle="tab"
                                    href="#blg-popular-<?php echo esc_attr($pt_id); ?>" role="tab">
                                    <?php echo esc_html($pt['label']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- Tab Content -->
                    <div class="grid-tab-content tab-content mt--10">
                        <?php foreach ($popular_tabs as $pt_id => $pt):
                            $is_first = ($pt_id === array_key_first($popular_tabs));

                            $pop_query = new WP_Query([
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'posts_per_page' => 4,
                                'meta_key' => 'post_views_count',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                                'no_found_rows' => true,
                                'category_name' => $pt['slug'],
                            ]);
                            ?>

                            <div class="trend-tab-content tab-pane fade <?php echo $is_first ? 'show active' : ''; ?>"
                                id="blg-popular-<?php echo esc_attr($pt_id); ?>" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <?php
                                        $pop_order = 1;
                                        if ($pop_query->have_posts()):
                                            while ($pop_query->have_posts()):
                                                $pop_query->the_post();
                                                $pp_cats = get_the_category();
                                                $pp_img = get_the_post_thumbnail_url(null, 'blg-tab-thumb');
                                                $pp_auth = get_the_author_meta('ID');
                                                ?>

                                                <div class="content-block trend-post post-order-list axil-control">
                                                    <div class="post-inner">
                                                        <span
                                                            class="post-order-list"><?php echo esc_html(str_pad($pop_order, 2, '0', STR_PAD_LEFT)); ?></span>
                                                        <div class="post-content">
                                                            <?php if (!empty($pp_cats)): ?>
                                                                <div class="post-cat">
                                                                    <div class="post-cat-list">
                                                                        <?php foreach (array_slice($pp_cats, 0, 2) as $cat): ?>
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
                                                            <div class="post-meta-wrapper">
                                                                <div class="post-meta">
                                                                    <div class="content">
                                                                        <h6 class="post-author-name">
                                                                            <a
                                                                                href="<?php echo esc_url(get_author_posts_url($pp_auth)); ?>">
                                                                                <?php the_author(); ?>
                                                                            </a>
                                                                        </h6>
                                                                        <ul class="post-meta-list">
                                                                            <li class="post-meta-date">
                                                                                <?php echo esc_html(get_the_date()); ?>
                                                                            </li>
                                                                            <li class="post-meta-reading-time">
                                                                                <?php echo esc_html(blg_reading_time()); ?>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if ($pp_img): ?>
                                                            <div class="post-thumbnail">
                                                                <a href="<?php the_permalink(); ?>">
                                                                    <img loading="lazy" src="<?php echo esc_url($pp_img); ?>"
                                                                        alt="<?php the_title_attribute(); ?>" decoding="async">
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <?php
                                                $pop_order++;
                                            endwhile;
                                            wp_reset_postdata();
                                        endif;
                                        ?>
                                    </div><!-- /.col-lg-8 -->

                                    <!-- Right sidebar col -->
                                    <div class="col-lg-4 blg-sidebar-widgets">
                                        <?php if (is_active_sidebar('blg-home-sidebar')):
                                            dynamic_sidebar('blg-home-sidebar');
                                        endif; ?>
                                    </div>

                                </div><!-- /.row -->
                            </div><!-- /.trend-tab-content -->

                        <?php endforeach; ?>
                    </div><!-- /.grid-tab-content -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Section 8 -->


    <!-- ============================================================
         SECTION 9 — LIFESTYLE (Post grid)
    ============================================================ -->
    <?php
    $lifestyle_query = new WP_Query([
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 6,
        'orderby' => 'date',
        'order' => 'DESC',
        'no_found_rows' => true,
        'category_name' => 'lifestyle',
    ]);

    $lifestyle_title = get_theme_mod('blg_lifestyle_section_title', __('Lifestyle', 'blogar'));
    ?>
    <?php if ($lifestyle_query->have_posts()): ?>
        <section class="axil-video-post-area axil-section-gap bg-color-white" id="blg-lifestyle-section">
            <div class="blg-container">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title text-left mb--30">
                            <h2 class="title"><?php echo esc_html($lifestyle_title); ?></h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php
                    $ls_index = 0;
                    while ($lifestyle_query->have_posts()):
                        $lifestyle_query->the_post();
                        $ls_id = get_the_ID();
                        $ls_cats = get_the_category();
                        $ls_img = get_the_post_thumbnail_url($ls_id, $ls_index === 0 ? 'blg-hero-thumb' : 'blg-grid-small');
                        $ls_fmt = get_post_format();
                        $ls_class = ($ls_index === 0) ? 'col-lg-6 col-md-6 col-sm-12 col-12' : 'col-lg-6 col-md-6 col-sm-6 col-12';
                        ?>

                        <div class="<?php echo esc_attr($ls_class); ?>">
                            <div
                                class="content-block post-default image-rounded mt--30 <?php echo $ls_index === 0 ? '' : 'axil-small-post-image'; ?>">
                                <?php if ($ls_img): ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <img loading="lazy" src="<?php echo esc_url($ls_img); ?>"
                                                alt="<?php the_title_attribute(); ?>" decoding="async">
                                        </a>
                                        <?php if ($ls_fmt === 'video'): ?>
                                            <a class="video-popup size-medium position-top-center" href="<?php the_permalink(); ?>">
                                                <span class="play-icon"></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="post-content">
                                    <?php if (!empty($ls_cats)): ?>
                                        <div class="post-cat">
                                            <div class="post-cat-list">
                                                <?php foreach (array_slice($ls_cats, 0, 1) as $cat): ?>
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
                                    <h5 class="title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <?php $ls_index++; endwhile;
                    wp_reset_postdata(); ?>
                </div><!-- /.row -->

            </div>
        </section>
    <?php endif; ?>
    <!-- End Section 9 -->

</main>

<?php get_footer(); ?>