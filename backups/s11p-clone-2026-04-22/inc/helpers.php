<?php
/**
 * Blogar Theme Helpers
 * Các helper function dùng chung toàn theme.
 */

if (!defined('ABSPATH')) {
    exit;
}

// ================================================================
// READING TIME
// ================================================================

function blogar_reading_time($post_id = 0, $wpm = 200)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(wp_strip_all_tags($content));
    $minutes = max(1, (int) ceil($word_count / $wpm));
    /* translators: %d: number of minutes */
    return sprintf(_n('%d min read', '%d min read', $minutes, 'blogar'), $minutes);
}


// ================================================================
// HOVER-FLIP HTML HELPERS
// ================================================================

function blogar_hover_flip_link_html($url, $text, $class = '')
{
    $url = esc_url($url);
    $text = wp_strip_all_tags((string) $text);
    if ('' === $url || '' === $text) {
        return '';
    }
    $classes = trim('hover-flip-item-wrapper ' . $class);
    return '<a class="' . esc_attr($classes) . '" href="' . $url . '"><span class="hover-flip-item"><span data-text="' . esc_attr($text) . '">' . esc_html($text) . '</span></span></a>';
}

function blogar_hover_flip_text_html($text, $class = '')
{
    $text = wp_strip_all_tags((string) $text);
    if ('' === $text) {
        return '';
    }
    $classes = trim('hover-flip-item-wrapper ' . $class);
    return '<span class="' . esc_attr($classes) . '"><span class="hover-flip-item"><span data-text="' . esc_attr($text) . '">' . esc_html($text) . '</span></span></span>';
}

/**
 * Render category links for a post.
 */
function blogar_post_categories_html($post_id, $limit = 1)
{
    $cats = get_the_category($post_id);
    if (empty($cats)) {
        return '';
    }
    $output = '';
    $count = 0;
    foreach ($cats as $cat) {
        if ($count >= $limit) {
            break;
        }
        $output .= blogar_hover_flip_link_html(get_category_link($cat->term_id), $cat->name);
        $count++;
    }
    return $output;
}


// ================================================================
// SOCIAL SHARE URLS
// ================================================================

function blogar_social_share_urls($post_url, $post_title = '')
{
    $encoded_url = rawurlencode($post_url);
    $encoded_title = rawurlencode($post_title);
    return array(
        'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url,
        'twitter' => 'https://twitter.com/intent/tweet?url=' . $encoded_url . '&text=' . $encoded_title,
        'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url=' . $encoded_url . '&title=' . $encoded_title,
    );
}


// ================================================================
// FEATURED IMAGE HELPERS
// ================================================================

function blogar_thumbnail_url($post_id, $size = 'full')
{
    $url = get_the_post_thumbnail_url($post_id, $size);
    if ($url) {
        return $url;
    }
    return 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1230 615"%3E%3Crect fill="%23e2e8f0" width="1230" height="615"/%3E%3C/svg%3E';
}

function blogar_thumbnail_alt($post_id)
{
    $thumb_id = get_post_thumbnail_id($post_id);
    if ($thumb_id) {
        $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
        if ($alt) {
            return $alt;
        }
    }
    return get_the_title($post_id);
}


// ================================================================
// QUERY HELPERS — SHARED
// ================================================================

/**
 * Build base WP_get_posts args for a section.
 */
function blogar_build_posts_query_args($count = 4, $cat_id = 0, $sort = 'latest')
{
    $args = array(
        'posts_per_page' => max(1, (int) $count),
        'post_status' => 'publish',
        'ignore_sticky_posts' => true,
    );
    if ($cat_id) {
        $args['cat'] = (int) $cat_id;
    }
    if ($sort === 'popular') {
        $args['orderby'] = 'comment_count';
        $args['order'] = 'DESC';
    } else {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    }
    return $args;
}

/**
 * Resolve a list of configured post slots.
 *
 * Fills each slot with the admin-selected post first, then fills
 * remaining empty slots with the newest posts not already used.
 *
 * @param  int    $count         Total posts needed.
 * @param  int    $cat_id        Optional category filter for fallback.
 * @param  array  $selected_ids  Ordered slot IDs from admin (0 = auto).
 * @param  string $sort          latest|popular
 * @return WP_Post[]
 */
function blogar_get_configured_posts($count, $cat_id = 0, $selected_ids = array(), $sort = 'latest')
{
    $count = max(1, (int) $count);
    $cat_id = (int) $cat_id;
    $selected_ids = array_values(array_filter(array_map('absint', (array) $selected_ids)));
    $selected_ids = array_values(array_unique($selected_ids));

    $posts = array();
    $used_ids = array();

    // Resolve admin-chosen posts first.
    if (!empty($selected_ids)) {
        $sel_posts = get_posts(array(
            'posts_per_page' => count($selected_ids),
            'post_status' => 'publish',
            'post__in' => $selected_ids,
            'orderby' => 'post__in',
        ));
        foreach ($sel_posts as $p) {
            $posts[] = $p;
            $used_ids[] = (int) $p->ID;
        }
    }

    // Fill remaining slots with fallback posts.
    if (count($posts) < $count) {
        $fallback_args = blogar_build_posts_query_args($count - count($posts), $cat_id, $sort);
        if (!empty($used_ids)) {
            $fallback_args['post__not_in'] = $used_ids;
        }
        $fallback = get_posts($fallback_args);
        $posts = array_merge($posts, $fallback);
    }

    return array_slice($posts, 0, $count);
}

/**
 * Resolve post slots while preserving slot order.
 *
 * Unlike blogar_get_configured_posts(), this helper keeps the exact slot
 * structure: each selected post stays in its original position, and only
 * truly empty slots are auto-filled.
 *
 * @param array  $selected_ids Ordered slot IDs (0 = auto).
 * @param int    $cat_id       Optional category used only for auto-fill.
 * @param string $sort         latest|popular
 * @param array  $exclude_ids  IDs to exclude from auto-fill queries.
 * @return array Ordered array of WP_Post|null matching slot count.
 */
function blogar_get_configured_post_slots($selected_ids, $cat_id = 0, $sort = 'latest', $exclude_ids = array())
{
    $selected_ids = array_map('absint', (array) $selected_ids);
    $slot_count   = count($selected_ids);

    if ($slot_count < 1) {
        return array();
    }

    $slots         = array_fill(0, $slot_count, null);
    $exclude_ids   = array_values(array_filter(array_map('absint', (array) $exclude_ids)));
    $selected_map  = array();
    $selected_only = array_values(array_unique(array_filter($selected_ids)));

    if (!empty($selected_only)) {
        $selected_posts = get_posts(array(
            'posts_per_page' => count($selected_only),
            'post_status'    => 'publish',
            'post__in'       => $selected_only,
            'orderby'        => 'post__in',
        ));

        foreach ($selected_posts as $post) {
            $selected_map[(int) $post->ID] = $post;
        }
    }

    $used_ids = $exclude_ids;

    foreach ($selected_ids as $index => $post_id) {
        if ($post_id && isset($selected_map[$post_id])) {
            $slots[$index] = $selected_map[$post_id];
            $used_ids[]    = (int) $post_id;
        }
    }

    $empty_indexes = array();
    foreach ($slots as $index => $post) {
        if (!$post instanceof WP_Post) {
            $empty_indexes[] = $index;
        }
    }

    if (!empty($empty_indexes)) {
        $fallback_posts = blogar_get_posts_with_exclude(count($empty_indexes), $cat_id, $used_ids, $sort);
        $fallback_i     = 0;

        foreach ($empty_indexes as $index) {
            if (isset($fallback_posts[$fallback_i]) && $fallback_posts[$fallback_i] instanceof WP_Post) {
                $slots[$index] = $fallback_posts[$fallback_i];
                $fallback_i++;
            }
        }
    }

    return $slots;
}

/**
 * Query posts with an exclusion list and a soft fallback for low-content sites.
 *
 * @param int    $count
 * @param int    $cat_id
 * @param array  $exclude_ids
 * @param string $sort
 * @return WP_Post[]
 */
function blogar_get_posts_with_exclude($count, $cat_id = 0, $exclude_ids = array(), $sort = 'latest')
{
    $count       = max(1, (int) $count);
    $cat_id      = (int) $cat_id;
    $exclude_ids = array_values(array_unique(array_filter(array_map('absint', (array) $exclude_ids))));

    $args                  = blogar_build_posts_query_args($count, $cat_id, $sort);
    $args['no_found_rows'] = true;
    if (!empty($exclude_ids)) {
        $args['post__not_in'] = $exclude_ids;
    }

    $posts = get_posts($args);

    if (count($posts) < $count) {
        $fallback_args                  = blogar_build_posts_query_args($count, $cat_id, $sort);
        $fallback_args['no_found_rows'] = true;
        $posts = array_merge($posts, get_posts($fallback_args));
    }

    $unique_posts = array();
    foreach ($posts as $post) {
        if (!$post instanceof WP_Post) {
            continue;
        }
        $unique_posts[(int) $post->ID] = $post;
    }

    return array_slice(array_values($unique_posts), 0, $count);
}


// ================================================================
// QUERY HELPERS — SECTION 4: INNOVATION & TECH
// ================================================================

function blogar_get_innovation_data()
{
    $title     = get_option('blogar_s4_title', 'Innovation & Tech');
    $subtitle  = get_option('blogar_s4_subtitle', '');
    $count     = max(1, (int) get_option('blogar_s4_post_count', 4));
    $tab_count = max(1, min(6, (int) get_option('blogar_s4_tab_count', 3)));
    $tabs      = array();

    for ($i = 1; $i <= $tab_count; $i++) {
        $label        = get_option("blogar_s4_tab_{$i}_label", '');
        $render_type  = get_option("blogar_s4_tab_{$i}_render_type", 'category');
        $cat_id       = (int) get_option("blogar_s4_tab_{$i}_cat", 0);
        $post_ids_raw = get_option("blogar_s4_tab_{$i}_post_ids", '');

        if (!$label && !$cat_id && !$post_ids_raw) {
            continue;
        }

        $args = array(
            'numberposts'        => $count,
            'post_status'        => 'publish',
            'ignore_sticky_posts' => true,
            'orderby'            => 'date',
            'order'              => 'DESC',
        );

        if ($render_type === 'posts' && $post_ids_raw) {
            $ids = array_filter(array_map('intval', explode(',', $post_ids_raw)));
            if (!empty($ids)) {
                $args['post__in']    = $ids;
                $args['orderby']     = 'post__in';
                $args['numberposts'] = count($ids);
            }
        } elseif ($cat_id) {
            $args['cat'] = $cat_id;
        }

        $tabs[] = array(
            'label' => $label ?: sprintf(__('Tab %d', 'blogar'), $i),
            'posts' => get_posts($args),
        );
    }

    // Fallback: 3 most popular categories.
    if (empty($tabs)) {
        $categories = get_categories(array('number' => 3, 'hide_empty' => true, 'orderby' => 'count', 'order' => 'DESC'));
        foreach ($categories as $cat) {
            $tabs[] = array(
                'label' => $cat->name,
                'posts' => get_posts(array('numberposts' => 4, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'cat' => $cat->term_id)),
            );
        }
    }

    return array('title' => $title, 'subtitle' => $subtitle, 'tabs' => $tabs);
}


// ================================================================
// QUERY HELPERS — SECTION 5: TRENDING TOPICS
// ================================================================

function blogar_get_category_thumbnail_data($term_id, $size = 'blogar-cat')
{
    $term_id = (int) $term_id;
    $term = get_term($term_id, 'category');

    if (!$term || is_wp_error($term)) {
        return array(
            'url' => 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300"%3E%3Crect fill="%23e2e8f0" width="300" height="300"/%3E%3C/svg%3E',
            'alt' => '',
        );
    }

    $term_image_id = (int) get_term_meta($term_id, 'blogar_category_image_id', true);
    if ($term_image_id) {
        $image_url = wp_get_attachment_image_url($term_image_id, $size);
        if ($image_url) {
            return array(
                'url' => $image_url,
                'alt' => get_post_meta($term_image_id, '_wp_attachment_image_alt', true) ?: $term->name,
            );
        }
    }

    $posts = get_posts(array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
        'cat' => $term_id,
        'meta_key' => '_thumbnail_id',
        'fields' => 'ids',
    ));

    if (!empty($posts)) {
        $post_id = (int) $posts[0];
        return array(
            'url' => blogar_thumbnail_url($post_id, $size),
            'alt' => blogar_thumbnail_alt($post_id),
        );
    }

    return array(
        'url' => 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300"%3E%3Crect fill="%23e2e8f0" width="300" height="300"/%3E%3C/svg%3E',
        'alt' => $term->name,
    );
}

function blogar_get_trending_topics_data()
{
    $title = get_option('blogar_s5_title', 'Trending Topics');
    $count = max(1, (int) get_option('blogar_s5_count', 8));
    $selected_ids = get_option('blogar_s5_categories', array());
    $selected_ids = is_array($selected_ids) ? array_values(array_filter(array_map('absint', $selected_ids))) : array();

    $terms = array();
    if (!empty($selected_ids)) {
        $terms = get_terms(array('taxonomy' => 'category', 'hide_empty' => false, 'include' => $selected_ids, 'orderby' => 'include'));
    }
    if (empty($terms) || is_wp_error($terms)) {
        $terms = get_categories(array('number' => $count, 'hide_empty' => true, 'orderby' => 'count', 'order' => 'DESC'));
    }
    if (empty($terms) || is_wp_error($terms)) {
        $terms = array();
    }

    $terms = array_slice($terms, 0, $count);
    $categories = array();

    foreach ($terms as $term) {
        $thumb = blogar_get_category_thumbnail_data($term->term_id, 'blogar-cat');
        $categories[] = array(
            'term_id' => (int) $term->term_id,
            'name' => $term->name,
            'url' => get_category_link($term->term_id),
            'thumb_url' => $thumb['url'],
            'thumb_alt' => $thumb['alt'],
        );
    }

    $posts_page_id = (int) get_option('page_for_posts');
    $archive_url = $posts_page_id ? get_permalink($posts_page_id) : home_url('/');

    return array('title' => $title, 'archive_url' => $archive_url, 'categories' => $categories);
}


// ================================================================
// QUERY HELPERS — SECTION 10: FEATURED VIDEO
// ================================================================

function blogar_get_featured_video_data()
{
    $title = get_option('blogar_s10_title', 'Featured Video');
    $selected_ids = array(
        (int) get_option('blogar_s10_main_post', 0),
        (int) get_option('blogar_s10_small_post_1', 0),
        (int) get_option('blogar_s10_small_post_2', 0),
        (int) get_option('blogar_s10_small_post_3', 0),
        (int) get_option('blogar_s10_small_post_4', 0),
    );

    $posts = blogar_get_configured_posts(5, 0, $selected_ids, 'latest');
    $big_post = !empty($posts) ? $posts[0] : null;
    $small_posts = array_slice($posts, 1, 4);

    while (count($small_posts) < 4) {
        $small_posts[] = null;
    }

    return array('title' => $title, 'big_post' => $big_post, 'small_posts' => $small_posts);
}


// ================================================================
// QUERY HELPERS — SECTION 11: NEWS HIGHLIGHT BLOCK
// ================================================================

function blogar_get_news_highlight_block_data()
{
    $ticker_title = get_option('blogar_s11_ticker_title', 'Trending Now');
    $cat_id       = (int) get_option('blogar_s11_cat', 0);

    // [v2] grid: [0] = big hero, [1] = middle card 1, [2] = middle card 2
    $selected_ids = array(
        (int) get_option('blogar_s11_main_post', 0),
        (int) get_option('blogar_s11_small_post_1', 0),
        (int) get_option('blogar_s11_small_post_2', 0),
    );

    $grid_posts    = blogar_get_configured_posts(3, $cat_id, $selected_ids, 'latest');
    $grid_used_ids = array();

    foreach ($grid_posts as $p) {
        if ($p instanceof WP_Post) {
            $grid_used_ids[] = (int) $p->ID;
        }
    }

    // Trending text list — latest 6 not in grid
    $ticker_args                  = blogar_build_posts_query_args(6, $cat_id, 'latest');
    $ticker_args['no_found_rows'] = true;
    if (!empty($grid_used_ids)) {
        $ticker_args['post__not_in'] = $grid_used_ids;
    }
    $ticker_posts = get_posts($ticker_args);
    if (empty($ticker_posts)) {
        $ticker_posts = blogar_get_configured_posts(6, $cat_id, array(), 'latest');
    }

    // Recent posts for small horizontal cards (4 left bottom + 3 right side)
    $ticker_ids = array_map(function ($p) { return $p instanceof WP_Post ? (int) $p->ID : 0; }, $ticker_posts);
    $all_used   = array_filter(array_merge($grid_used_ids, $ticker_ids));
    $recent_args                  = blogar_build_posts_query_args(7, $cat_id, 'latest');
    $recent_args['no_found_rows'] = true;
    if (!empty($all_used)) {
        $recent_args['post__not_in'] = array_values($all_used);
    }
    $recent_posts = get_posts($recent_args);

    while (count($grid_posts) < 3) {
        $grid_posts[] = null;
    }

    return array(
        'ticker_title' => $ticker_title,
        'ticker_posts' => $ticker_posts,
        'grid_posts'   => $grid_posts,
        'recent_posts' => $recent_posts,
    );
}


// ================================================================
// QUERY HELPERS — SECTION s11p: PENCI FEATURED (clone)
// ================================================================

function blogar_get_s11p_data()
{
    $trending_label = get_option('blogar_s11p_trending_label', 'Trending Now');
    $fallback_cat   = (int) get_option('blogar_s11p_cat', 0);
    $trending_cat   = (int) get_option('blogar_s11p_trending_cat', 0);
    $slider_count   = max(1, min(6, (int) get_option('blogar_s11p_slider_count', 3)));

    $slider_selected = array((int) get_option('blogar_s11p_hero', 0));
    for ($i = 2; $i <= 6; $i++) {
        $slider_selected[] = (int) get_option("blogar_s11p_slider_post_{$i}", 0);
    }
    $slider_slots = blogar_get_configured_post_slots(array_slice($slider_selected, 0, $slider_count), $fallback_cat, 'latest');
    $slider       = array_values(array_filter($slider_slots, function ($post) {
        return $post instanceof WP_Post;
    }));

    $used_ids = array_map(function ($post) {
        return $post instanceof WP_Post ? (int) $post->ID : 0;
    }, $slider);
    $used_ids = array_values(array_filter($used_ids));

    $mid1_slot = blogar_get_configured_post_slots(array((int) get_option('blogar_s11p_mid1', 0)), $fallback_cat, 'latest', $used_ids);
    $mid1      = (!empty($mid1_slot[0]) && $mid1_slot[0] instanceof WP_Post) ? $mid1_slot[0] : null;
    if ($mid1 instanceof WP_Post) {
        $used_ids[] = (int) $mid1->ID;
    }

    $mid2_slot = blogar_get_configured_post_slots(array((int) get_option('blogar_s11p_mid2', 0)), $fallback_cat, 'latest', $used_ids);
    $mid2      = (!empty($mid2_slot[0]) && $mid2_slot[0] instanceof WP_Post) ? $mid2_slot[0] : null;
    if ($mid2 instanceof WP_Post) {
        $used_ids[] = (int) $mid2->ID;
    }

    $left_small_selected = array();
    for ($i = 1; $i <= 4; $i++) {
        $left_small_selected[] = (int) get_option("blogar_s11p_left_small_{$i}", 0);
    }
    $left_small_slots = blogar_get_configured_post_slots($left_small_selected, $fallback_cat, 'latest', $used_ids);
    $left_small       = array_values(array_filter($left_small_slots, function ($post) {
        return $post instanceof WP_Post;
    }));
    foreach ($left_small as $post) {
        $used_ids[] = (int) $post->ID;
    }

    $right_small_selected = array();
    for ($i = 1; $i <= 3; $i++) {
        $right_small_selected[] = (int) get_option("blogar_s11p_right_small_{$i}", 0);
    }
    $right_small_slots = blogar_get_configured_post_slots($right_small_selected, $fallback_cat, 'latest', $used_ids);
    $right_small       = array_values(array_filter($right_small_slots, function ($post) {
        return $post instanceof WP_Post;
    }));
    foreach ($right_small as $post) {
        $used_ids[] = (int) $post->ID;
    }

    $trending_source_cat = $trending_cat ? $trending_cat : $fallback_cat;
    $trending            = blogar_get_posts_with_exclude(6, $trending_source_cat, $used_ids, 'latest');

    return array(
        'trending_label' => $trending_label,
        'trending'       => $trending,
        'slider'         => $slider,
        'hero'           => !empty($slider[0]) ? $slider[0] : null,
        'mid1'           => $mid1,
        'mid2'           => $mid2,
        'left_small'     => $left_small,
        'right_small'    => $right_small,
    );
}


// ================================================================
// QUERY HELPERS — SECTION 12: FEATURED GRID THIS WEEK (fvg)
// ================================================================
// Layout: 1 big left | 1 medium top-right | 3 small bottom-right
// Each of the 5 slots is independently configurable.

function blogar_get_featured_grid_this_week_data()
{
    $title = get_option('blogar_s12_title', 'Featured Videos In This Week');
    $selected_ids = array(
        (int) get_option('blogar_s12_big_post', 0),       // slot 0 → big
        (int) get_option('blogar_s12_medium_post', 0),    // slot 1 → medium
        (int) get_option('blogar_s12_small_post_1', 0),   // slot 2 → small 1
        (int) get_option('blogar_s12_small_post_2', 0),   // slot 3 → small 2
        (int) get_option('blogar_s12_small_post_3', 0),   // slot 4 → small 3
    );

    $posts = blogar_get_configured_posts(5, 0, $selected_ids, 'latest');

    // Pad to exactly 5 with null so template can safely access indices.
    while (count($posts) < 5) {
        $posts[] = null;
    }

    return array(
        'title' => $title,
        'big' => $posts[0] ?? null,
        'medium' => $posts[1] ?? null,
        'smalls' => array_slice($posts, 2, 3),
    );
}


// ================================================================
// QUERY HELPERS — SECTION 13: FEATURED GRID 2+3 (fvg2 dark)
// ================================================================
// Layout: 2 equal top cards | 3 equal bottom cards
// Admin can pick individual posts; category used as fallback pool.

function blogar_get_featured_grid_2plus3_data()
{
    $title = get_option('blogar_s13_title', 'Top Stories This Week');
    $cat_id = (int) get_option('blogar_s13_cat', 0);
    $selected_ids = array(
        (int) get_option('blogar_s13_post_1', 0),  // top row post 1
        (int) get_option('blogar_s13_post_2', 0),  // top row post 2
        (int) get_option('blogar_s13_post_3', 0),  // bottom row post 1
        (int) get_option('blogar_s13_post_4', 0),  // bottom row post 2
        (int) get_option('blogar_s13_post_5', 0),  // bottom row post 3
    );

    $posts = blogar_get_configured_posts(5, $cat_id, $selected_ids, 'latest');

    while (count($posts) < 5) {
        $posts[] = null;
    }

    return array(
        'title' => $title,
        'top_posts' => array_slice($posts, 0, 2),
        'bottom_posts' => array_slice($posts, 2, 3),
    );
}


// ================================================================
// QUERY HELPERS — SECTION 14: LATEST POSTS GRID (lp)
// ================================================================

function blogar_get_latest_posts_data()
{
    $title = get_option('blogar_s14_title', 'Latest Posts');
    $count = max(4, min(24, (int) get_option('blogar_s14_count', 8)));
    $cat_id = (int) get_option('blogar_s14_cat', 0);

    $args = array(
        'numberposts' => $count,
        'post_status' => 'publish',
        'meta_key' => '_thumbnail_id',
        'orderby' => 'date',
        'order' => 'DESC',
        'ignore_sticky_posts' => true,
    );

    if ($cat_id) {
        $args['cat'] = $cat_id;
    }

    $posts = get_posts($args);

    // Fallback: no thumbnail filter if count is too low.
    if (count($posts) < 4) {
        $fallback = $args;
        unset($fallback['meta_key']);
        $posts = get_posts($fallback);
    }

    $posts_page_id = (int) get_option('page_for_posts');
    $more_url = $posts_page_id ? get_permalink($posts_page_id) : home_url('/');

    if ($cat_id) {
        $more_url = get_category_link($cat_id);
    }

    return array(
        'title' => $title,
        'posts' => $posts,
        'more_url' => $more_url,
    );
}
