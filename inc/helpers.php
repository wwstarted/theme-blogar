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
        $cat_url = esc_url(get_category_link($cat->term_id));
        $cat_name = esc_html($cat->name);

        $output .= '<a class="hover-flip-item-wrapper" href="' . $cat_url . '">';
        $output .= '<span class="hover-flip-item">';
        $output .= '<span data-text="' . esc_attr($cat->name) . '">' . $cat_name . '</span>';
        $output .= '</span>';
        $output .= '</a>';

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

/**
 * Lấy WP_Query cho Hero Slider.
 * Ưu tiên: bài được chọn trong admin.
 * Fallback: 3 bài mới nhất.
 *
 * @return WP_Query
 */
function blogar_get_hero_posts()
{
    $ids = array(
        (int) get_option('blogar_hero_slide_1', 0),
        (int) get_option('blogar_hero_slide_2', 0),
        (int) get_option('blogar_hero_slide_3', 0),
    );
    // Loại bỏ giá trị 0 (chưa chọn).
    $ids = array_values(array_filter($ids));

    if (!empty($ids)) {
        return new WP_Query(array(
            'post__in' => $ids,
            'orderby' => 'post__in', // giữ đúng thứ tự đã chọn
            'posts_per_page' => count($ids),
            'post_status' => 'publish',
            'ignore_sticky_posts' => true,
        ));
    }

    // Fallback: 3 bài mới nhất.
    return new WP_Query(array(
        'posts_per_page' => 3,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'ignore_sticky_posts' => true,
    ));
}

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

/**
 * Lay data cho Section 6 — Most Popular (numbered list).
 * Cau truc giong pattern Section 4: section title + tabs.
 *
 * @return array { title: string, tabs: array, sort: string }
 */
function blogar_get_most_popular_list_data()
{
    $title = get_option('blogar_s6_title', 'Most Popular');
    $count = max(1, (int) get_option('blogar_s6_post_count', 4));
    $sort = get_option('blogar_s6_sort', 'latest');
    $sort = in_array($sort, array('latest', 'popular'), true) ? $sort : 'latest';

    $tabs = array();

    for ($i = 1; $i <= 4; $i++) {
        $label = get_option("blogar_s6_tab_{$i}_label", '');
        $cat_id = (int) get_option("blogar_s6_tab_{$i}_cat", 0);

        if (!$label && !$cat_id) {
            continue;
        }

        $tabs[] = array(
            'label' => $label ?: sprintf(__('Tab %d', 'blogar'), $i),
            'query' => new WP_Query(blogar_build_posts_query_args($count, $cat_id, $sort)),
        );
    }

    if (empty($tabs)) {
        $categories = get_categories(array(
            'number' => 4,
            'hide_empty' => true,
            'orderby' => $sort === 'popular' ? 'count' : 'name',
            'order' => $sort === 'popular' ? 'DESC' : 'ASC',
        ));

        foreach ($categories as $cat) {
            $tabs[] = array(
                'label' => $cat->name,
                'query' => new WP_Query(blogar_build_posts_query_args($count, $cat->term_id, $sort)),
            );
        }
    }

    return array(
        'title' => $title,
        'tabs' => $tabs,
        'sort' => $sort,
    );
}

// ================================================================
// QUERY HELPERS — SECTION 8: MOST POPULAR (GRID)
// ================================================================

/**
 * Lay data cho Section 8 — Most Popular grid.
 * Moi tab tuong ung 1 category va query 1 big + 2 small posts.
 *
 * @return array { title: string, tabs: array }
 */
function blogar_get_most_popular_grid_data()
{
    $title = get_option('blogar_s8_title', 'Most Popular');
    $count = 3;
    $tab_count = max(1, min(4, (int) get_option('blogar_s8_tab_count', 4)));
    $tabs = array();

    for ($i = 1; $i <= $tab_count; $i++) {
        $label = get_option("blogar_s8_tab_{$i}_label", '');
        $cat_id = (int) get_option("blogar_s8_tab_{$i}_cat", 0);
        $selected_posts = array(
            (int) get_option("blogar_s8_tab_{$i}_post_1", 0),
            (int) get_option("blogar_s8_tab_{$i}_post_2", 0),
            (int) get_option("blogar_s8_tab_{$i}_post_3", 0),
        );

        if (!$label && !$cat_id && !array_filter($selected_posts)) {
            continue;
        }

        $term = $cat_id ? get_term($cat_id, 'category') : null;
        $posts = blogar_get_configured_posts($count, $cat_id, $selected_posts, 'latest');

        if (empty($posts)) {
            continue;
        }

        $tabs[] = array(
            'label' => $label ?: ($term && !is_wp_error($term) ? $term->name : sprintf(__('Tab %d', 'blogar'), $i)),
            'category_id' => $cat_id,
            'posts' => $posts,
        );
    }

    if (empty($tabs)) {
        $fallback_terms = get_categories(array(
            'number' => $tab_count,
            'hide_empty' => true,
            'orderby' => 'count',
            'order' => 'DESC',
        ));

        foreach ($fallback_terms as $term) {
            $posts = blogar_get_configured_posts($count, $term->term_id, array(), 'latest');
            if (empty($posts)) {
                continue;
            }

            $tabs[] = array(
                'label' => $term->name,
                'category_id' => (int) $term->term_id,
                'posts' => $posts,
            );
        }
    }

    return array(
        'title' => $title,
        'tabs' => $tabs,
    );
}

// ================================================================
// QUERY HELPERS — SECTION 9: POST LIST + SIDEBAR
// ================================================================

/**
 * Lay data cho Section 9 — Post List + Sidebar.
 * Gom cau hinh main list + recent posts widget ve mot helper de template chi render.
 *
 * @return array {
 *     @type WP_Query $main_query
 *     @type WP_Query $recent_query
 *     @type string   $recent_title
 * }
 */
function blogar_get_post_list_sidebar_data()
{
    $main_count = max(1, (int) get_option('blogar_s9_post_count', 4));
    $main_cat_id = (int) get_option('blogar_s9_cat', 0);
    $main_sort = get_option('blogar_s9_sort', 'latest');
    $main_sort = in_array($main_sort, array('latest', 'popular'), true) ? $main_sort : 'latest';

    $recent_title = get_option('blogar_s9_recent_title', 'Recent on Blogar');
    $recent_count = max(1, (int) get_option('blogar_s9_recent_count', 3));
    $recent_cat_id = (int) get_option('blogar_s9_recent_cat', 0);

    $main_args = blogar_build_posts_query_args($main_count, $main_cat_id, $main_sort);
    $main_args['no_found_rows'] = true;

    $recent_args = blogar_build_posts_query_args($recent_count, $recent_cat_id, 'latest');
    $recent_args['no_found_rows'] = true;

    return array(
        'main_query' => new WP_Query($main_args),
        'recent_query' => new WP_Query($recent_args),
        'recent_title' => $recent_title,
    );
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
