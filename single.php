<?php
/**
 * single.php — Blogar Theme
 *
 * Template: Single post detail page.
 *
 * SEO    : Exactly 1 <h1> per page — the post title.
 * Data   : Full WordPress loop; sidebar reuses archive.php widgets.
 * CSS    : frontpage.css + archive.css + single.css.
 * JS     : frontpage.js (copy-link) + inline TOC toggle.
 *
 * Improvements v2:
 *  1. Author box  — bio with graceful fallback text.
 *  2. Related     — full-width 4-col section BELOW the 2-col layout.
 *  3. Sidebar     — sticky via .single-sidebar-sticky (CSS position:sticky).
 *  4. TOC         — auto h2/h3, injected after paragraph 3, show/hide toggle.
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
$svg_ig = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5" fill="none" stroke="currentColor" stroke-width="2"/><path fill="none" stroke="currentColor" stroke-width="2" d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>';
$svg_pi = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12c0 4.24 2.65 7.86 6.39 9.29-.09-.78-.17-1.98.04-2.83.18-.77 1.22-5.17 1.22-5.17s-.31-.63-.31-1.56c0-1.46.85-2.55 1.9-2.55.9 0 1.33.67 1.33 1.48 0 .9-.58 2.26-.87 3.52-.25 1.05.52 1.9 1.55 1.9 1.86 0 3.3-1.96 3.3-4.8 0-2.51-1.8-4.26-4.38-4.26-2.98 0-4.73 2.23-4.73 4.54 0 .9.35 1.86.78 2.39.09.1.1.19.07.29-.08.33-.26 1.05-.29 1.19-.05.19-.16.23-.37.14-1.39-.65-2.26-2.68-2.26-4.32 0-3.51 2.55-6.74 7.35-6.74 3.86 0 6.86 2.75 6.86 6.42 0 3.83-2.41 6.9-5.76 6.9-1.13 0-2.19-.59-2.55-1.28l-.69 2.59c-.25.96-.93 2.17-1.38 2.9.04.01.08.01.12.01.96.29 1.97.45 3.02.45 5.52 0 10-4.48 10-10S17.52 2 12 2z"/></svg>';
$svg_search = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>';

$img = get_template_directory_uri() . '/images/frontpage/';

/* ================================================================
   TOC HELPER
   Parse h2/h3 from processed content, stamp id="" on each heading,
   build TOC widget HTML and inject it after the 3rd </p>.
   Returns: array { toc_items, content }
   ================================================================ */
function blogar_process_toc($content)
{
    $toc_items = array();
    $id_counts = array();

    // 1. Add id="" to every h2/h3, collect items
    $modified = preg_replace_callback(
        '/<h([23])([^>]*)>(.*?)<\/h\1>/si',
        function ($m) use (&$toc_items, &$id_counts) {
            $level = (int) $m[1];
            $attrs = $m[2];
            $inner = $m[3];
            $text = wp_strip_all_tags($inner);
            $base_id = sanitize_title($text);

            if (!isset($id_counts[$base_id])) {
                $id_counts[$base_id] = 0;
                $anchor = $base_id;
            } else {
                $id_counts[$base_id]++;
                $anchor = $base_id . '-' . $id_counts[$base_id];
            }

            $toc_items[] = array('level' => $level, 'text' => $text, 'id' => $anchor);

            // strip any old id=""
            $attrs = preg_replace('/\s*id=["\'][^"\']*["\']/', '', $attrs);

            return '<h' . $level . ' id="' . esc_attr($anchor) . '"' . $attrs . '>'
                . $inner . '</h' . $level . '>';
        },
        $content
    );

    // 2. Only inject TOC if 2+ headings
    if (count($toc_items) < 2) {
        return array('toc_items' => $toc_items, 'content' => $modified);
    }

    // 3. Find insertion point: after the 3rd </p>
    $inject_after = 3;
    $pos = 0;
    $found = 0;
    while ($found < $inject_after) {
        $p = strpos($modified, '</p>', $pos);
        if (false === $p) {
            break;
        }
        $pos = $p + 4;
        $found++;
    }
    if (0 === $pos) {
        return array('toc_items' => $toc_items, 'content' => $modified);
    }

    // 4. Build TOC HTML
    $toc = '<div class="single-toc toc-open" id="single-toc"'
        . ' aria-label="' . esc_attr__('Table of Contents', 'blogar') . '">';
    $toc .= '<div class="toc-header">';
    $toc .= '<span class="toc-title">' . esc_html__('Table of Contents', 'blogar') . '</span>';
    $toc .= '<button class="toc-toggle" aria-expanded="true" aria-controls="toc-list">';
    $toc .= '<span class="toc-toggle-label">' . esc_html__('Hide', 'blogar') . '</span>';
    $toc .= '<svg class="toc-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"'
        . ' stroke-width="2.5" aria-hidden="true"><path d="M18 15l-6-6-6 6"/></svg>';
    $toc .= '</button>';
    $toc .= '</div>'; // .toc-header
    $toc .= '<nav id="toc-list" class="toc-list"><ol class="toc-ol">';

    $toc_index = 0;
    foreach ($toc_items as $item) {
        $toc_index++;

        $toc .= '<li class="toc-item toc-level-' . esc_attr($item['level']) . '">';
        $toc .= '<a class="toc-link" href="#' . esc_attr($item['id']) . '">';
        $toc .= '<span class="toc-number" aria-hidden="true"></span>';
        $toc .= '<span class="toc-text">' . esc_html($item['text']) . '</span>';
        $toc .= '</a></li>';
    }

    $toc .= '</ol></nav></div>'; // .toc-list / #single-toc

    $modified = substr($modified, 0, $pos) . $toc . substr($modified, $pos);

    return array('toc_items' => $toc_items, 'content' => $modified);
}
?>

<!-- ================================================================
     BREADCRUMB — h1 lives here (post title in breadcrumb trail)
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
                            <?php
                            $bc_cats = get_the_category();
                            if ($bc_cats):
                                $bc_cat = $bc_cats[0];
                                ?>
                            <li class="item-cat">
                                <a class="bread-link bread-cat"
                                    href="<?php echo esc_url(get_category_link($bc_cat->term_id)); ?>">
                                    <?php echo esc_html($bc_cat->name); ?>
                                </a>
                            </li>
                            <li class="separator" aria-hidden="true">&nbsp;</li>
                            <?php endif; ?>
                            <li class="item-current" aria-current="page">
                                <span class="bread-current"><?php the_title(); ?></span>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ================================================================
     MAIN 2-COL: content col-lg-8  +  sticky sidebar col-lg-4
     ================================================================ -->
<div class="main-wrapper">
    <div class="axil-blog-area axil-section-gap bg-color-white">
        <div class="container">
            <div class="row row--40">

                <!-- ── POST CONTENT col-lg-8 ───────────────────── -->
                <div class="col-lg-8 col-md-12 col-12 order-1 order-lg-1">

                    <?php
                    // Grab these before wp_reset_postdata for related query below
                    $current_post_id = 0;
                    $current_post_cats = array();

                    while (have_posts()):
                        the_post();

                        $current_post_id = get_the_ID();
                        $current_post_cats = wp_get_post_categories($current_post_id);

                        $post_url = get_permalink();
                        $post_title = get_the_title();
                        $post_date = get_the_date('F j, Y');
                        $read_time = blogar_reading_time($current_post_id);
                        $author_id = (int) get_the_author_meta('ID');
                        $author_name = get_the_author();
                        $author_url = get_author_posts_url($author_id);
                        $author_avatar = get_avatar_url($author_id, array('size' => 80));
                        $author_bio = get_the_author_meta('description', $author_id);
                        $thumb_url = blogar_thumbnail_url($current_post_id, 'blogar-hero');
                        $thumb_alt = blogar_thumbnail_alt($current_post_id);
                        $share_urls = blogar_social_share_urls($post_url, $post_title);

                        // Process content: stamp heading IDs + inject TOC
                        $raw_content = apply_filters('the_content', get_the_content());
                        $toc_result = blogar_process_toc($raw_content);
                        ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-article'); ?>>

                        <!-- Featured Image -->
                        <div class="single-post-thumbnail">
                            <img fetchpriority="high" loading="eager" decoding="async"
                                src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($thumb_alt); ?>">
                        </div>

                        <!-- Post Header: category + h1 + meta -->
                        <div class="single-post-header mt--30">

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

                            <!-- *** ONE h1 per page *** -->
                            <h1 class="single-post-title"><?php the_title(); ?></h1>

                            <div class="single-post-meta post-meta-wrapper">
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
                                                    <span data-text="<?php echo esc_attr($author_name); ?>">
                                                        <?php echo esc_html($author_name); ?>
                                                    </span>
                                                </span>
                                            </a>
                                        </h6>
                                        <ul class="post-meta-list">
                                            <li class="post-meta-date"><?php echo esc_html($post_date); ?></li>
                                            <li class="post-meta-reading-time"><?php echo esc_html($read_time); ?></li>
                                        </ul>
                                    </div>
                                </div>
                                <ul class="social-share-transparent justify-content-end">
                                    <li>
                                        <a href="<?php echo esc_url($share_urls['facebook']); ?>" target="_blank"
                                            rel="noopener nofollow" class="aw-facebook"
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
                                        <a href="<?php echo esc_url($share_urls['linkedin']); ?>" target="_blank"
                                            rel="noopener nofollow" class="aw-linkdin"
                                            aria-label="<?php esc_attr_e('Share on LinkedIn', 'blogar'); ?>">
                                            <?php echo $svg_li; // phpcs:ignore ?>
                                        </a>
                                    </li>
                                    <li>
                                        <button class="axilcopyLink" title="<?php esc_attr_e('Copy Link', 'blogar'); ?>"
                                            data-link="<?php echo esc_url($post_url); ?>"
                                            aria-label="<?php esc_attr_e('Copy link', 'blogar'); ?>">
                                            <?php echo $svg_lk; // phpcs:ignore ?>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .single-post-header -->

                        <!-- Post Content (TOC injected by blogar_process_toc) -->
                        <div class="single-post-content entry-content">
                            <?php echo $toc_result['content']; // phpcs:ignore ?>
                        </div>

                        <!-- Tags -->
                        <?php $tags = get_the_tags();
                            if ($tags): ?>
                        <div class="single-post-tags">
                            <span class="tags-label"><?php esc_html_e('Tags:', 'blogar'); ?></span>
                            <div class="tagcloud">
                                <?php foreach ($tags as $tag): ?>
                                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                                    <?php echo esc_html($tag->name); ?>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Bottom Share Bar -->
                        <div class="single-post-share-footer">
                            <span class="share-label"><?php esc_html_e('Share This Post:', 'blogar'); ?></span>
                            <ul class="social-share-transparent">
                                <li><a href="<?php echo esc_url($share_urls['facebook']); ?>" target="_blank"
                                        rel="noopener nofollow" class="aw-facebook" aria-label="Facebook">
                                        <?php echo $svg_fb; // phpcs:ignore ?></a></li>
                                <li><a href="<?php echo esc_url($share_urls['twitter']); ?>" target="_blank"
                                        rel="noopener nofollow" class="aw-twitter" aria-label="Twitter">
                                        <?php echo $svg_tw; // phpcs:ignore ?></a></li>
                                <li><a href="<?php echo esc_url($share_urls['linkedin']); ?>" target="_blank"
                                        rel="noopener nofollow" class="aw-linkdin" aria-label="LinkedIn">
                                        <?php echo $svg_li; // phpcs:ignore ?></a></li>
                                <li><button class="axilcopyLink" data-link="<?php echo esc_url($post_url); ?>"
                                        aria-label="<?php esc_attr_e('Copy link', 'blogar'); ?>">
                                        <?php echo $svg_lk; // phpcs:ignore ?></button></li>
                            </ul>
                        </div>

                        <!-- ============================================================
                             AUTHOR BOX — bio with fallback
                             ============================================================ -->
                        <div class="single-author-box">
                            <div class="author-avatar">
                                <a href="<?php echo esc_url($author_url); ?>">
                                    <img src="<?php echo esc_url($author_avatar); ?>"
                                        alt="<?php echo esc_attr($author_name); ?>" width="80" height="80">
                                </a>
                            </div>
                            <div class="author-info">
                                <span class="author-label">
                                    <?php esc_html_e('Written By', 'blogar'); ?>
                                </span>
                                <h5 class="author-name">
                                    <a class="hover-flip-item-wrapper" href="<?php echo esc_url($author_url); ?>">
                                        <span class="hover-flip-item">
                                            <span data-text="<?php echo esc_attr($author_name); ?>">
                                                <?php echo esc_html($author_name); ?>
                                            </span>
                                        </span>
                                    </a>
                                </h5>
                                <!-- Description: real bio or friendly fallback -->
                                <p class="author-bio">
                                    <?php
                                        if (!empty(trim($author_bio))) {
                                            echo esc_html($author_bio);
                                        } else {
                                            printf(
                                                /* translators: %s author display name */
                                                esc_html__('%s is a passionate writer and content creator who loves sharing knowledge and inspiring readers with fresh perspectives.', 'blogar'),
                                                '<strong>' . esc_html($author_name) . '</strong>'
                                            );
                                        }
                                        ?>
                                </p>
                                <a class="author-more-link hover-flip-item-wrapper"
                                    href="<?php echo esc_url($author_url); ?>">
                                    <span class="hover-flip-item">
                                        <span data-text="<?php esc_attr_e('View All Posts', 'blogar'); ?>">
                                            <?php esc_html_e('View All Posts', 'blogar'); ?>
                                        </span>
                                    </span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        aria-hidden="true" width="14" height="14">
                                        <path d="M5 12h14M12 19l7-7-7-7" />
                                    </svg>
                                </a>
                            </div>
                        </div><!-- .single-author-box -->

                        <!-- Post Navigation Prev / Next -->
                        <nav class="single-post-navigation"
                            aria-label="<?php esc_attr_e('Post navigation', 'blogar'); ?>">
                            <?php
                                $prev_post = get_previous_post();
                                $next_post = get_next_post();
                                ?>
                            <?php if ($prev_post):
                                    $prev_thumb = blogar_thumbnail_url($prev_post->ID, 'blogar-thumb');
                                    $prev_alt = blogar_thumbnail_alt($prev_post->ID);
                                    ?>
                            <div class="nav-item nav-previous">
                                <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="nav-link">
                                    <div class="nav-thumbnail">
                                        <img loading="lazy" src="<?php echo esc_url($prev_thumb); ?>"
                                            alt="<?php echo esc_attr($prev_alt); ?>" width="80" height="80">
                                    </div>
                                    <div class="nav-content">
                                        <span class="nav-direction">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                aria-hidden="true">
                                                <path d="M19 12H5M12 5l-7 7 7 7" />
                                            </svg>
                                            <?php esc_html_e('Previous Post', 'blogar'); ?>
                                        </span>
                                        <span class="nav-title">
                                            <?php echo esc_html(wp_trim_words($prev_post->post_title, 7)); ?>
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>
                            <?php if ($next_post):
                                    $next_thumb = blogar_thumbnail_url($next_post->ID, 'blogar-thumb');
                                    $next_alt = blogar_thumbnail_alt($next_post->ID);
                                    ?>
                            <div class="nav-item nav-next">
                                <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>"
                                    class="nav-link nav-link-next">
                                    <div class="nav-content text-right">
                                        <span class="nav-direction">
                                            <?php esc_html_e('Next Post', 'blogar'); ?>
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                aria-hidden="true">
                                                <path d="M5 12h14M12 19l7-7-7-7" />
                                            </svg>
                                        </span>
                                        <span class="nav-title">
                                            <?php echo esc_html(wp_trim_words($next_post->post_title, 7)); ?>
                                        </span>
                                    </div>
                                    <div class="nav-thumbnail">
                                        <img loading="lazy" src="<?php echo esc_url($next_thumb); ?>"
                                            alt="<?php echo esc_attr($next_alt); ?>" width="80" height="80">
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>
                        </nav>

                        <!-- Comments -->
                        <?php if (comments_open() || get_comments_number()): ?>
                        <div class="single-post-comments mt--40">
                            <?php comments_template(); ?>
                        </div>
                        <?php endif; ?>

                    </article>

                    <?php endwhile; ?>

                </div><!-- .col-lg-8 -->


                <!-- ── STICKY SIDEBAR col-lg-4 ─────────────────── -->
                <aside class="col-lg-4 col-md-12 col-12 order-2 order-lg-2 single-sidebar archive-sidebar"
                    aria-label="<?php esc_attr_e('Sidebar', 'blogar'); ?>">

                    <!-- .single-sidebar-sticky receives position:sticky via CSS -->
                    <div class="single-sidebar-sticky">

                        <!-- ① Search -->
                        <div class="search-1 axil-single-widget widget_search">
                            <h5 class="widget-title"><?php esc_html_e('Search', 'blogar'); ?></h5>
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

                        <!-- ② Recent Posts -->
                        <div class="blogar_recent_post-1 axil-single-widget widget_blogar_recent_post mt--30">
                            <h5 class="widget-title"><?php esc_html_e('Recent Post', 'blogar'); ?></h5>
                            <?php
                            $recent_posts = get_posts(array(
                                'numberposts' => 3,
                                'post_status' => 'publish',
                                'post__not_in' => array($current_post_id),
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
                                            <li><?php echo esc_html(get_the_date('', $rp->ID)); ?></li>
                                            <li><?php echo esc_html(blogar_reading_time($rp->ID)); ?></li>
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
                                <h4 class="title mb--15"><?php esc_html_e('Never Miss A Post!', 'blogar'); ?></h4>
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
                                            <span><?php esc_html_e('Subscribe', 'blogar'); ?></span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- ④ Stay In Touch -->
                        <div class="blogar_social_widget-1 axil-single-widget mt--30">
                            <h5 class="widget-title"><?php esc_html_e('Stay In Touch', 'blogar'); ?></h5>
                            <ul class="social-icon md-size justify-content-center">
                                <li><a href="#" aria-label="Facebook"><?php echo $svg_fb; // phpcs:ignore ?></a></li>
                                <li><a href="#" aria-label="Twitter"><?php echo $svg_tw; // phpcs:ignore ?></a></li>
                                <li><a href="#" aria-label="Instagram"><?php echo $svg_ig; // phpcs:ignore ?></a></li>
                                <li><a href="#" aria-label="Pinterest"><?php echo $svg_pi; // phpcs:ignore ?></a></li>
                                <li><a href="#" aria-label="LinkedIn"><?php echo $svg_li; // phpcs:ignore ?></a></li>
                            </ul>
                        </div>

                        <!-- ⑤ Gallery -->
                        <div class="media_gallery-1 axil-single-widget widget_media_gallery mt--30">
                            <h5 class="widget-title"><?php esc_html_e('Gallery', 'blogar'); ?></h5>
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
                            <h5 class="widget-title"><?php esc_html_e('Featured Videos', 'blogar'); ?></h5>
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
                            <h5 class="widget-title"><?php esc_html_e('All Tags', 'blogar'); ?></h5>
                            <div class="tagcloud">
                                <?php
                                wp_tag_cloud(array(
                                    'smallest' => 8,
                                    'largest' => 14,
                                    'unit' => 'pt',
                                    'number' => 10,
                                    'format' => 'flat',
                                ));
                                ?>
                            </div>
                        </div>

                        <!-- ⑧ Ad Banner -->
                        <div class="media_image-1 axil-single-widget widget_media_image mt--30">
                            <a href="<?php echo esc_url(home_url('/')); ?>">
                                <img loading="lazy" decoding="async"
                                    src="<?php echo esc_url($img . 'banner-03.png'); ?>"
                                    alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                                    style="max-width:100%;height:auto;">
                            </a>
                        </div>

                    </div><!-- .single-sidebar-sticky -->
                </aside><!-- .single-sidebar -->

            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .axil-blog-area -->
</div><!-- .main-wrapper -->


<!-- ================================================================
     RELATED POSTS — full-width section, 4-col grid, bg-color-grey
     Placed outside the 2-col layout so it spans the full container.
     ================================================================ -->
<?php
$related_args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'post__not_in' => array($current_post_id),
    'orderby' => 'rand',
);
if (!empty($current_post_cats)) {
    $related_args['category__in'] = $current_post_cats;
}
$related_query = new WP_Query($related_args);
?>

<?php if ($related_query->have_posts()): ?>
<section class="single-related-section axil-section-gap bg-color-grey">
    <div class="container">
        <div class="section-title text-left mb--30">
            <h2 class="title"><?php esc_html_e('Related Posts', 'blogar'); ?></h2>
        </div>

        <div class="related-posts-grid-4">
            <?php while ($related_query->have_posts()):
                    $related_query->the_post();
                    $rel_id = get_the_ID();
                    $rel_url = get_permalink();
                    $rel_title = get_the_title();
                    $rel_date = get_the_date('F j, Y');
                    $rel_thumb_url = blogar_thumbnail_url($rel_id, 'blogar-card');
                    $rel_thumb_alt = blogar_thumbnail_alt($rel_id);
                    $rel_read_time = blogar_reading_time($rel_id);
                    ?>
            <div class="content-block image-rounded related-post-card">
                <div class="post-thumbnail">
                    <a href="<?php echo esc_url($rel_url); ?>">
                        <img loading="lazy" decoding="async" width="390" height="260"
                            src="<?php echo esc_url($rel_thumb_url); ?>" alt="<?php echo esc_attr($rel_thumb_alt); ?>">
                    </a>
                </div>
                <div class="post-content mt--20">
                    <div class="post-cat">
                        <div class="post-cat-list">
                            <?php echo blogar_post_categories_html($rel_id, 1); // phpcs:ignore ?>
                        </div>
                    </div>
                    <h5 class="title">
                        <a href="<?php echo esc_url($rel_url); ?>">
                            <?php echo esc_html($rel_title); ?>
                        </a>
                    </h5>
                    <div class="post-meta mt--10">
                        <ul class="post-meta-list">
                            <li class="post-meta-date"><?php echo esc_html($rel_date); ?></li>
                            <li class="post-meta-reading-time"><?php echo esc_html($rel_read_time); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endwhile;
                wp_reset_postdata(); ?>
        </div><!-- .related-posts-grid-4 -->
    </div><!-- .container -->
</section>
<?php endif; ?>


<!-- ================================================================
     TOC TOGGLE + SMOOTH SCROLL (vanilla JS — no dependency)
     ================================================================ -->
<script>
(function() {
    'use strict';

    /* ── TOC collapse / expand ─────────────────────────────── */
    var toc = document.getElementById('single-toc');
    var list = document.getElementById('toc-list');
    var toggles = document.querySelectorAll('.toc-toggle');

    if (toc && list && toggles.length) {
        // Initialise: open state — set real height so transition works
        list.style.maxHeight = list.scrollHeight + 'px';

        toggles.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var isOpen = btn.getAttribute('aria-expanded') === 'true';
                var chevron = btn.querySelector('.toc-chevron');
                var label = btn.querySelector('.toc-toggle-label');

                if (isOpen) {
                    // Snapshot real height then animate to 0
                    list.style.maxHeight = list.scrollHeight + 'px';
                    requestAnimationFrame(function() {
                        list.style.maxHeight = '0';
                        list.style.overflow = 'hidden';
                    });
                    btn.setAttribute('aria-expanded', 'false');
                    if (label) label.textContent = '<?php echo esc_js(__('Show', 'blogar')); ?>';
                    if (chevron) chevron.classList.add('toc-chevron-down');
                    toc.classList.remove('toc-open');
                } else {
                    list.style.maxHeight = list.scrollHeight + 'px';
                    btn.setAttribute('aria-expanded', 'true');
                    if (label) label.textContent = '<?php echo esc_js(__('Hide', 'blogar')); ?>';
                    if (chevron) chevron.classList.remove('toc-chevron-down');
                    toc.classList.add('toc-open');
                    // Let height go natural after animation
                    list.addEventListener('transitionend', function cleanup() {
                        if (btn.getAttribute('aria-expanded') === 'true') {
                            list.style.maxHeight = 'none';
                            list.style.overflow = '';
                        }
                        list.removeEventListener('transitionend', cleanup);
                    });
                }
            });
        });
    }

    /* ── Smooth scroll for TOC links ───────────────────────── */
    document.querySelectorAll('.toc-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            var target = document.querySelector(link.getAttribute('href'));
            if (!target) return;
            e.preventDefault();
            var hdr = document.querySelector('.axil-header.sticky');
            var offset = hdr ? hdr.offsetHeight + 16 : 96;
            var top = target.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({
                top: top,
                behavior: 'smooth'
            });
            // Update URL hash without jump
            history.replaceState(null, '', link.getAttribute('href'));
        });
    });

})();
</script>

<?php get_footer(); ?>
