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

/**
 * Tính thời gian đọc bài viết.
 *
 * @param  int    $post_id  Post ID. Mặc định là post hiện tại.
 * @param  int    $wpm      Số từ đọc mỗi phút. Mặc định 200.
 * @return string           VD: "4 min read"
 */
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
// CATEGORIES
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
 * Render danh sách category của một post dưới dạng hover-flip links.
 *
 * @param  int  $post_id  Post ID.
 * @param  int  $limit    Số category tối đa hiển thị.
 * @return string         HTML output.
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

/**
 * Tạo mảng các URL social share cho một bài viết.
 *
 * @param  string $post_url    Permalink của bài viết.
 * @param  string $post_title  Tiêu đề bài viết.
 * @return array {
 *     @type string $facebook
 *     @type string $twitter
 *     @type string $linkedin
 * }
 */
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

/**
 * Lấy URL featured image của post, có fallback về placeholder.
 *
 * @param  int    $post_id  Post ID.
 * @param  string $size     Image size. Mặc định 'full'.
 * @return string           URL của ảnh.
 */
function blogar_thumbnail_url($post_id, $size = 'full')
{
    $url = get_the_post_thumbnail_url($post_id, $size);
    if ($url) {
        return $url;
    }
    // Fallback placeholder (1x1 gray SVG encoded)
    return 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1230 615"%3E%3Crect fill="%23e2e8f0" width="1230" height="615"/%3E%3C/svg%3E';
}

/**
 * Lấy alt text của featured image.
 * Ưu tiên: alt tag > post title.
 *
 * @param  int $post_id  Post ID.
 * @return string
 */
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
// QUERY HELPERS — HOMEPAGE SECTIONS
// ================================================================

// ================================================================
// QUERY HELPERS — SECTION 4: INNOVATION & TECH
// ================================================================

/**
 * Lấy data cho Section 4 — Innovation & Tech.
 * Trả về title + mảng tabs, mỗi tab có label + WP_Query.
 * Fallback: lấy 3 category đầu tiên có bài viết.
 *
 * @return array { title: string, tabs: array }
 */
function blogar_get_innovation_data()
{
    $title = get_option('blogar_s4_title', 'Innovation & Tech');
    $count = max(1, (int) get_option('blogar_s4_post_count', 4));

    $tabs = array();

    for ($i = 1; $i <= 3; $i++) {
        $label = get_option("blogar_s4_tab_{$i}_label", '');
        $cat_id = (int) get_option("blogar_s4_tab_{$i}_cat", 0);

        // Bỏ qua tab chưa cấu hình.
        if (!$label && !$cat_id) {
            continue;
        }

        $query_args = array(
            'posts_per_page' => $count,
            'post_status' => 'publish',
            'ignore_sticky_posts' => true,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        if ($cat_id) {
            $query_args['cat'] = $cat_id;
        }

        $tabs[] = array(
            'label' => $label ?: sprintf(__('Tab %d', 'blogar'), $i),
            'query' => new WP_Query($query_args),
        );
    }

    // Fallback: chưa cấu hình → lấy 3 category đầu tiên có bài.
    if (empty($tabs)) {
        $categories = get_categories(array(
            'number' => 3,
            'hide_empty' => true,
            'orderby' => 'count',
            'order' => 'DESC',
        ));

        foreach ($categories as $cat) {
            $tabs[] = array(
                'label' => $cat->name,
                'query' => new WP_Query(array(
                    'posts_per_page' => 4,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'cat' => $cat->term_id,
                )),
            );
        }
    }

    return array(
        'title' => $title,
        'tabs' => $tabs,
    );
}

// ================================================================
// QUERY HELPERS — SECTION 5: TRENDING TOPICS
// ================================================================

/**
 * Lay thumbnail dai dien cho category.
 * Uu tien:
 * 1. Term meta `blogar_category_image_id` neu co
 * 2. Featured image moi nhat cua post trong category
 * 3. Placeholder SVG
 *
 * @param  int    $term_id  Category term ID.
 * @param  string $size     Image size.
 * @return array {
 *     @type string $url
 *     @type string $alt
 * }
 */
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
            $image_alt = get_post_meta($term_image_id, '_wp_attachment_image_alt', true);

            return array(
                'url' => $image_url,
                'alt' => $image_alt ? $image_alt : $term->name,
            );
        }
    }

    $posts = get_posts(array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
        'ignore_sticky_posts' => true,
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

/**
 * Lay data cho Section 5 — Trending Topics.
 * Render tu categories da chon trong admin settings.
 * Fallback: lay category co nhieu bai viet nhat.
 *
 * @return array {
 *     @type string $title
 *     @type string $archive_url
 *     @type array  $categories
 * }
 */
function blogar_get_trending_topics_data()
{
    $title = get_option('blogar_s5_title', 'Trending Topics');
    $count = max(1, (int) get_option('blogar_s5_count', 8));
    $selected_ids = get_option('blogar_s5_categories', array());
    $selected_ids = is_array($selected_ids) ? array_values(array_filter(array_map('absint', $selected_ids))) : array();

    $terms = array();

    if (!empty($selected_ids)) {
        $terms = get_terms(array(
            'taxonomy' => 'category',
            'hide_empty' => false,
            'include' => $selected_ids,
            'orderby' => 'include',
        ));
    }

    if (empty($terms) || is_wp_error($terms)) {
        $terms = get_categories(array(
            'number' => $count,
            'hide_empty' => true,
            'orderby' => 'count',
            'order' => 'DESC',
        ));
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

    return array(
        'title' => $title,
        'archive_url' => $archive_url,
        'categories' => $categories,
    );
}

// ================================================================
// QUERY HELPERS — SECTION 6: MOST POPULAR (NUMBERED LIST)
// ================================================================

/**
 * Build query args for homepage list/grid sections with configurable sorting.
 *
 * @param  int $count  Number of posts.
 * @param  int $cat_id Category term ID, optional.
 * @param  string $sort latest|popular
 * @return array
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
 * Lay danh sach post cho section co slot thu tu co cau hinh san.
 * Uu tien:
 * 1. Post duoc admin chon dung slot
 * 2. Post fallback tu query cung category
 *
 * @param  int    $count         So post can lay.
 * @param  int    $cat_id        Category ID.
 * @param  array  $selected_ids  Post IDs da chon theo thu tu slot.
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

    if (!empty($selected_ids)) {
        $selected_args = blogar_build_posts_query_args(count($selected_ids), $cat_id, $sort);
        $selected_args['post__in'] = $selected_ids;
        $selected_args['orderby'] = 'post__in';
        $selected_args['posts_per_page'] = count($selected_ids);

        $selected_posts = get_posts($selected_args);

        foreach ($selected_posts as $post) {
            $posts[] = $post;
            $used_ids[] = (int) $post->ID;
        }
    }

    if (count($posts) < $count) {
        $fallback_args = blogar_build_posts_query_args($count - count($posts), $cat_id, $sort);
        if (!empty($used_ids)) {
            $fallback_args['post__not_in'] = $used_ids;
        }

        $fallback_posts = get_posts($fallback_args);
        $posts = array_merge($posts, $fallback_posts);
    }

    return array_slice($posts, 0, $count);
}

// ================================================================
// QUERY HELPERS — SECTION 10: FEATURED VIDEO
// ================================================================

/**
 * Lay data cho Section 10 — Featured Video.
 * Admin chon 1 post lon + 4 post nho. Slot trong se fallback ve bai moi nhat con lai.
 *
 * @return array {
 *     @type string   $title
 *     @type WP_Post|null $big_post
 *     @type array    $small_posts
 * }
 */
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

    return array(
        'title' => $title,
        'big_post' => $big_post,
        'small_posts' => $small_posts,
    );
}

// ================================================================
// QUERY HELPERS â€” SECTION 11: NEWS HIGHLIGHT BLOCK
// ================================================================

/**
 * Lay data cho Section 11 â€” News Highlight block.
 * Layout gom:
 * - 1 headline ticker o phia tren
 * - 1 big post ben trai
 * - 3 small posts xep doc ben phai
 *
 * @return array {
 *     @type string $ticker_title
 *     @type array  $ticker_posts
 *     @type array  $grid_posts
 * }
 */
function blogar_get_news_highlight_block_data()
{
    $ticker_title = get_option('blogar_s11_ticker_title', 'News Highlight');
    $cat_id = (int) get_option('blogar_s11_cat', 0);
    $selected_ids = array(
        (int) get_option('blogar_s11_main_post', 0),
        (int) get_option('blogar_s11_small_post_1', 0),
        (int) get_option('blogar_s11_small_post_2', 0),
        (int) get_option('blogar_s11_small_post_3', 0),
    );

    $grid_posts = blogar_get_configured_posts(4, $cat_id, $selected_ids, 'latest');
    $grid_used_ids = array();

    foreach ($grid_posts as $grid_post) {
        if ($grid_post instanceof WP_Post) {
            $grid_used_ids[] = (int) $grid_post->ID;
        }
    }

    $ticker_args = blogar_build_posts_query_args(6, $cat_id, 'latest');
    $ticker_args['no_found_rows'] = true;

    if (!empty($grid_used_ids)) {
        $ticker_args['post__not_in'] = $grid_used_ids;
    }

    $ticker_posts = get_posts($ticker_args);

    if (empty($ticker_posts)) {
        $ticker_posts = blogar_get_configured_posts(6, $cat_id, array(), 'latest');
    }

    while (count($grid_posts) < 4) {
        $grid_posts[] = null;
    }

    return array(
        'ticker_title' => $ticker_title,
        'ticker_posts' => $ticker_posts,
        'grid_posts' => $grid_posts,
    );
}

