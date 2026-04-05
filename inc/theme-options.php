<?php
/**
 * Blogar Theme Options
 * Admin settings page — chọn posts và cấu hình từng section homepage.
 */

if (!defined('ABSPATH')) {
    exit;
}

// ================================================================
// ADMIN MENU
// ================================================================

function blogar_add_options_page()
{
    add_theme_page(
        __('Blogar Settings', 'blogar'),
        __('Blogar Settings', 'blogar'),
        'manage_options',
        'blogar-settings',
        'blogar_render_options_page'
    );
}
add_action('admin_menu', 'blogar_add_options_page');


// ================================================================
// REGISTER SETTINGS
// ================================================================

function blogar_register_settings()
{

    // ── Hero Slider ──────────────────────────────────────────────
    register_setting('blogar_hero_settings', 'blogar_hero_slide_1', array('sanitize_callback' => 'absint'));
    register_setting('blogar_hero_settings', 'blogar_hero_slide_2', array('sanitize_callback' => 'absint'));
    register_setting('blogar_hero_settings', 'blogar_hero_slide_3', array('sanitize_callback' => 'absint'));

    add_settings_section(
        'blogar_hero_section',
        __('Chọn bài viết cho Hero Slider', 'blogar'),
        'blogar_hero_section_cb',
        'blogar-hero'
    );

    add_settings_field(
        'blogar_hero_slide_1',
        __('Slide 1', 'blogar'),
        'blogar_post_select_field',
        'blogar-hero',
        'blogar_hero_section',
        array(
            'option_name' => 'blogar_hero_slide_1',
            'description' => __('Bài viết chính (h1) — hiển thị đầu tiên', 'blogar'),
        )
    );

    add_settings_field(
        'blogar_hero_slide_2',
        __('Slide 2', 'blogar'),
        'blogar_post_select_field',
        'blogar-hero',
        'blogar_hero_section',
        array(
            'option_name' => 'blogar_hero_slide_2',
            'description' => __('Bài viết thứ 2', 'blogar'),
        )
    );

    add_settings_field(
        'blogar_hero_slide_3',
        __('Slide 3', 'blogar'),
        'blogar_post_select_field',
        'blogar-hero',
        'blogar_hero_section',
        array(
            'option_name' => 'blogar_hero_slide_3',
            'description' => __('Bài viết thứ 3', 'blogar'),
        )
    );

    // ── Section 4: Innovation & Tech ────────────────────────────
    register_setting('blogar_s4_settings', 'blogar_s4_title', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    register_setting('blogar_s4_settings', 'blogar_s4_post_count', array(
        'sanitize_callback' => 'absint',
    ));

    for ($i = 1; $i <= 3; $i++) {
        register_setting('blogar_s4_settings', "blogar_s4_tab_{$i}_label", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));
        register_setting('blogar_s4_settings', "blogar_s4_tab_{$i}_cat", array(
            'sanitize_callback' => 'absint',
        ));
    }

    add_settings_section(
        'blogar_s4_section',
        __('Cấu hình Section 4 — Innovation & Tech', 'blogar'),
        'blogar_s4_section_cb',
        'blogar-s4'
    );

    add_settings_field(
        'blogar_s4_title',
        __('Tiêu đề section', 'blogar'),
        'blogar_text_field_cb',
        'blogar-s4',
        'blogar_s4_section',
        array(
            'option_name' => 'blogar_s4_title',
            'default' => 'Innovation & Tech',
            'placeholder' => 'Innovation & Tech',
        )
    );

    add_settings_field(
        'blogar_s4_post_count',
        __('Số bài mỗi tab', 'blogar'),
        'blogar_number_field_cb',
        'blogar-s4',
        'blogar_s4_section',
        array(
            'option_name' => 'blogar_s4_post_count',
            'default' => 4,
            'min' => 1,
            'max' => 12,
            'description' => __('Số bài viết hiển thị trong mỗi tab carousel (1–12)', 'blogar'),
        )
    );

    for ($i = 1; $i <= 3; $i++) {
        add_settings_field(
            "blogar_s4_tab_{$i}",
            sprintf(__('Tab %d', 'blogar'), $i),
            'blogar_tab_field_cb',
            'blogar-s4',
            'blogar_s4_section',
            array(
                'index' => $i,
                'label_key' => "blogar_s4_tab_{$i}_label",
                'cat_key' => "blogar_s4_tab_{$i}_cat",
                'description' => $i === 1
                    ? __('Tab đầu tiên — mặc định được chọn khi vào trang', 'blogar')
                    : '',
            )
        );
    }

    // Section 5: Trending Topics
    register_setting('blogar_s5_settings', 'blogar_s5_title', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    register_setting('blogar_s5_settings', 'blogar_s5_count', array(
        'sanitize_callback' => 'absint',
    ));
    register_setting('blogar_s5_settings', 'blogar_s5_categories', array(
        'sanitize_callback' => 'blogar_sanitize_term_ids',
    ));

    add_settings_section(
        'blogar_s5_section',
        __('Trending Topics', 'blogar'),
        'blogar_s5_section_cb',
        'blogar-s5'
    );

    add_settings_field(
        'blogar_s5_title',
        __('Section title', 'blogar'),
        'blogar_text_field_cb',
        'blogar-s5',
        'blogar_s5_section',
        array(
            'option_name' => 'blogar_s5_title',
            'default' => 'Trending Topics',
            'placeholder' => 'Trending Topics',
        )
    );

    add_settings_field(
        'blogar_s5_count',
        __('Categories count', 'blogar'),
        'blogar_number_field_cb',
        'blogar-s5',
        'blogar_s5_section',
        array(
            'option_name' => 'blogar_s5_count',
            'default' => 8,
            'min' => 1,
            'max' => 20,
            'description' => __('Number of categories shown in the carousel (1-20).', 'blogar'),
        )
    );

    add_settings_field(
        'blogar_s5_categories',
        __('Select categories', 'blogar'),
        'blogar_categories_multiselect_field',
        'blogar-s5',
        'blogar_s5_section',
        array(
            'option_name' => 'blogar_s5_categories',
            'description' => __('Choose which categories should render. If left empty, the section falls back to the categories with the most posts.', 'blogar'),
        )
    );

    // Section 6: Most Popular (numbered list)
    register_setting('blogar_s6_settings', 'blogar_s6_title', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    register_setting('blogar_s6_settings', 'blogar_s6_post_count', array(
        'sanitize_callback' => 'absint',
    ));
    register_setting('blogar_s6_settings', 'blogar_s6_sort', array(
        'sanitize_callback' => 'blogar_sanitize_sort_option',
    ));

    for ($i = 1; $i <= 4; $i++) {
        register_setting('blogar_s6_settings', "blogar_s6_tab_{$i}_label", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));
        register_setting('blogar_s6_settings', "blogar_s6_tab_{$i}_cat", array(
            'sanitize_callback' => 'absint',
        ));
    }

    add_settings_section(
        'blogar_s6_section',
        __('Most Popular Numbered List', 'blogar'),
        'blogar_s6_section_cb',
        'blogar-s6'
    );

    add_settings_field(
        'blogar_s6_title',
        __('Section title', 'blogar'),
        'blogar_text_field_cb',
        'blogar-s6',
        'blogar_s6_section',
        array(
            'option_name' => 'blogar_s6_title',
            'default' => 'Most Popular',
            'placeholder' => 'Most Popular',
        )
    );

    add_settings_field(
        'blogar_s6_post_count',
        __('Posts per tab', 'blogar'),
        'blogar_number_field_cb',
        'blogar-s6',
        'blogar_s6_section',
        array(
            'option_name' => 'blogar_s6_post_count',
            'default' => 4,
            'min' => 1,
            'max' => 12,
            'description' => __('Number of posts shown in each numbered list tab (1-12).', 'blogar'),
        )
    );

    add_settings_field(
        'blogar_s6_sort',
        __('Sort posts by', 'blogar'),
        'blogar_select_field_cb',
        'blogar-s6',
        'blogar_s6_section',
        array(
            'option_name' => 'blogar_s6_sort',
            'default' => 'latest',
            'options' => array(
                'latest' => __('Latest posts', 'blogar'),
                'popular' => __('Popular posts', 'blogar'),
            ),
            'description' => __('Popular mode uses WordPress comment count when no custom view-count logic exists.', 'blogar'),
        )
    );

    for ($i = 1; $i <= 4; $i++) {
        add_settings_field(
            "blogar_s6_tab_{$i}",
            sprintf(__('Tab %d', 'blogar'), $i),
            'blogar_tab_field_cb',
            'blogar-s6',
            'blogar_s6_section',
            array(
                'index' => $i,
                'label_key' => "blogar_s6_tab_{$i}_label",
                'cat_key' => "blogar_s6_tab_{$i}_cat",
                'description' => $i === 1
                    ? __('First tab is active by default when the page loads.', 'blogar')
                    : '',
            )
        );
    }

    // Section 8: Most Popular (grid)
    register_setting('blogar_s8_settings', 'blogar_s8_title', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    register_setting('blogar_s8_settings', 'blogar_s8_post_count', array(
        'sanitize_callback' => 'absint',
    ));
    register_setting('blogar_s8_settings', 'blogar_s8_tab_count', array(
        'sanitize_callback' => 'absint',
    ));

    for ($i = 1; $i <= 4; $i++) {
        register_setting('blogar_s8_settings', "blogar_s8_tab_{$i}_label", array(
            'sanitize_callback' => 'sanitize_text_field',
        ));
        register_setting('blogar_s8_settings', "blogar_s8_tab_{$i}_cat", array(
            'sanitize_callback' => 'absint',
        ));
        register_setting('blogar_s8_settings', "blogar_s8_tab_{$i}_post_1", array(
            'sanitize_callback' => 'absint',
        ));
        register_setting('blogar_s8_settings', "blogar_s8_tab_{$i}_post_2", array(
            'sanitize_callback' => 'absint',
        ));
        register_setting('blogar_s8_settings', "blogar_s8_tab_{$i}_post_3", array(
            'sanitize_callback' => 'absint',
        ));
    }

    add_settings_section(
        'blogar_s8_section',
        __('Most Popular Grid', 'blogar'),
        'blogar_s8_section_cb',
        'blogar-s8'
    );

    add_settings_field(
        'blogar_s8_title',
        __('Section title', 'blogar'),
        'blogar_text_field_cb',
        'blogar-s8',
        'blogar_s8_section',
        array(
            'option_name' => 'blogar_s8_title',
            'default' => 'Most Popular',
            'placeholder' => 'Most Popular',
        )
    );

    add_settings_field(
        'blogar_s8_post_count',
        __('Posts per tab', 'blogar'),
        'blogar_number_field_cb',
        'blogar-s8',
        'blogar_s8_section',
        array(
            'option_name' => 'blogar_s8_post_count',
            'default' => 3,
            'min' => 3,
            'max' => 3,
            'description' => __('This layout uses exactly 3 posts per tab: position 1 = big card, positions 2 and 3 = small cards.', 'blogar'),
        )
    );

    add_settings_field(
        'blogar_s8_tab_count',
        __('Number of tabs', 'blogar'),
        'blogar_number_field_cb',
        'blogar-s8',
        'blogar_s8_section',
        array(
            'option_name' => 'blogar_s8_tab_count',
            'default' => 4,
            'min' => 1,
            'max' => 4,
            'description' => __('How many category tabs should render in this section (1-4).', 'blogar'),
        )
    );

    for ($i = 1; $i <= 4; $i++) {
        add_settings_field(
            "blogar_s8_tab_{$i}",
            sprintf(__('Tab %d', 'blogar'), $i),
            'blogar_s8_grid_tab_field_cb',
            'blogar-s8',
            'blogar_s8_section',
            array(
                'index' => $i,
                'label_key' => "blogar_s8_tab_{$i}_label",
                'cat_key' => "blogar_s8_tab_{$i}_cat",
                'post_keys' => array(
                    "blogar_s8_tab_{$i}_post_1",
                    "blogar_s8_tab_{$i}_post_2",
                    "blogar_s8_tab_{$i}_post_3",
                ),
                'description' => __('Choose category and optional posts for positions 1, 2, 3. Empty slots fall back to latest posts from the selected category.', 'blogar'),
            )
        );
    }

    // Section 9: Post List + Sidebar
    register_setting('blogar_s9_settings', 'blogar_s9_post_count', array(
        'sanitize_callback' => 'absint',
    ));
    register_setting('blogar_s9_settings', 'blogar_s9_cat', array(
        'sanitize_callback' => 'absint',
    ));
    register_setting('blogar_s9_settings', 'blogar_s9_sort', array(
        'sanitize_callback' => 'blogar_sanitize_sort_option',
    ));
    register_setting('blogar_s9_settings', 'blogar_s9_recent_title', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    register_setting('blogar_s9_settings', 'blogar_s9_recent_count', array(
        'sanitize_callback' => 'absint',
    ));
    register_setting('blogar_s9_settings', 'blogar_s9_recent_cat', array(
        'sanitize_callback' => 'absint',
    ));

    add_settings_section(
        'blogar_s9_section',
        __('Post List + Sidebar', 'blogar'),
        'blogar_s9_section_cb',
        'blogar-s9'
    );

    add_settings_field(
        'blogar_s9_post_count',
        __('Main posts count', 'blogar'),
        'blogar_number_field_cb',
        'blogar-s9',
        'blogar_s9_section',
        array(
            'option_name' => 'blogar_s9_post_count',
            'default' => 4,
            'min' => 1,
            'max' => 12,
            'description' => __('Number of posts shown in the main post list (1-12).', 'blogar'),
        )
    );

    add_settings_field(
        'blogar_s9_cat',
        __('Main category filter', 'blogar'),
        'blogar_category_select_field_cb',
        'blogar-s9',
        'blogar_s9_section',
        array(
            'option_name' => 'blogar_s9_cat',
            'default' => 0,
            'all_label' => __('— All posts —', 'blogar'),
            'description' => __('Optional category filter for the main post list.', 'blogar'),
        )
    );

    add_settings_field(
        'blogar_s9_sort',
        __('Main posts sort', 'blogar'),
        'blogar_select_field_cb',
        'blogar-s9',
        'blogar_s9_section',
        array(
            'option_name' => 'blogar_s9_sort',
            'default' => 'latest',
            'options' => array(
                'latest' => __('Latest posts', 'blogar'),
                'popular' => __('Popular posts', 'blogar'),
            ),
            'description' => __('Popular mode uses WordPress comment count when no custom view-count logic exists.', 'blogar'),
        )
    );

    add_settings_field(
        'blogar_s9_recent_title',
        __('Recent widget title', 'blogar'),
        'blogar_text_field_cb',
        'blogar-s9',
        'blogar_s9_section',
        array(
            'option_name' => 'blogar_s9_recent_title',
            'default' => 'Recent on Blogar',
            'placeholder' => 'Recent on Blogar',
        )
    );

    add_settings_field(
        'blogar_s9_recent_count',
        __('Recent widget count', 'blogar'),
        'blogar_number_field_cb',
        'blogar-s9',
        'blogar_s9_section',
        array(
            'option_name' => 'blogar_s9_recent_count',
            'default' => 3,
            'min' => 1,
            'max' => 8,
            'description' => __('Number of recent posts shown in the sidebar widget (1-8).', 'blogar'),
        )
    );

    add_settings_field(
        'blogar_s9_recent_cat',
        __('Recent widget category filter', 'blogar'),
        'blogar_category_select_field_cb',
        'blogar-s9',
        'blogar_s9_section',
        array(
            'option_name' => 'blogar_s9_recent_cat',
            'default' => 0,
            'all_label' => __('— All posts —', 'blogar'),
            'description' => __('Optional category filter for the sidebar recent posts widget.', 'blogar'),
        )
    );

    // Section 10: Featured Video
    register_setting('blogar_s10_settings', 'blogar_s10_title', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    register_setting('blogar_s10_settings', 'blogar_s10_main_post', array(
        'sanitize_callback' => 'absint',
    ));

    for ($i = 1; $i <= 4; $i++) {
        register_setting('blogar_s10_settings', "blogar_s10_small_post_{$i}", array(
            'sanitize_callback' => 'absint',
        ));
    }

    add_settings_section(
        'blogar_s10_section',
        __('Featured Video', 'blogar'),
        'blogar_s10_section_cb',
        'blogar-s10'
    );

    add_settings_field(
        'blogar_s10_title',
        __('Section title', 'blogar'),
        'blogar_text_field_cb',
        'blogar-s10',
        'blogar_s10_section',
        array(
            'option_name' => 'blogar_s10_title',
            'default' => 'Featured Video',
            'placeholder' => 'Featured Video',
        )
    );

    add_settings_field(
        'blogar_s10_main_post',
        __('Big post', 'blogar'),
        'blogar_post_select_field',
        'blogar-s10',
        'blogar_s10_section',
        array(
            'option_name' => 'blogar_s10_main_post',
            'description' => __('Post used for the large card on the left. If empty, the section falls back to the latest published post.', 'blogar'),
        )
    );

    for ($i = 1; $i <= 4; $i++) {
        add_settings_field(
            "blogar_s10_small_post_{$i}",
            sprintf(__('Small post %d', 'blogar'), $i),
            'blogar_post_select_field',
            'blogar-s10',
            'blogar_s10_section',
            array(
                'option_name' => "blogar_s10_small_post_{$i}",
                'description' => $i === 1
                    ? __('Posts used for the 2x2 grid on the right. Empty slots fall back to the latest remaining posts.', 'blogar')
                    : '',
            )
        );
    }
}
add_action('admin_init', 'blogar_register_settings');


// ── Section description callbacks ──────────────────────────────

function blogar_hero_section_cb()
{
    echo '<p class="description">'
        . esc_html__('Chọn tối đa 3 bài viết hiển thị trong Hero Slider. Nếu không chọn, hệ thống tự động lấy 3 bài mới nhất.', 'blogar')
        . '</p>';
}

// ── Section 4 callbacks ─────────────────────────────────────────

function blogar_s4_section_cb()
{
    echo '<p class="description">'
        . esc_html__('Cấu hình tiêu đề, số bài và tối đa 3 tab cho section Innovation & Tech. Nếu chưa chọn category, fallback sẽ tự lấy 3 category có nhiều bài nhất.', 'blogar')
        . '</p>';
}

function blogar_s5_section_cb()
{
    echo '<p class="description">'
        . esc_html__('Configure the title, category count, and selected categories for the Trending Topics carousel. Category thumbnails use the latest featured image found in each category, with a safe fallback if needed.', 'blogar')
        . '</p>';
}

function blogar_s6_section_cb()
{
    echo '<p class="description">'
        . esc_html__('Configure the title, sort mode, post count, and up to 4 category tabs for the Most Popular numbered list section.', 'blogar')
        . '</p>';
}

function blogar_s8_section_cb()
{
    echo '<p class="description">'
        . esc_html__('Configure the title, total tabs, and each tab layout for the Most Popular grid section. Each tab can define its category and the posts used in positions 1, 2, 3.', 'blogar')
        . '</p>';
}

function blogar_s9_section_cb()
{
    echo '<p class="description">'
        . esc_html__('Configure the dynamic post list and recent-post sidebar widget for Section 9. The frontend keeps the original layout while thumbnails are normalized to prevent uneven cards.', 'blogar')
        . '</p>';
}

function blogar_s10_section_cb()
{
    echo '<p class="description">'
        . esc_html__('Configure the section title plus 1 big post and 4 small posts for the Featured Video area. Empty slots fall back to the latest published posts while keeping the original layout.', 'blogar')
        . '</p>';
}

/**
 * Generic text input field.
 */
function blogar_text_field_cb($args)
{
    $option = $args['option_name'];
    $default = isset($args['default']) ? $args['default'] : '';
    $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
    $value = get_option($option, $default);

    printf(
        '<input type="text" id="%1$s" name="%1$s" value="%2$s" placeholder="%3$s" style="min-width:360px;max-width:100%%" />',
        esc_attr($option),
        esc_attr($value),
        esc_attr($placeholder)
    );
}

/**
 * Generic number input field.
 */
function blogar_number_field_cb($args)
{
    $option = $args['option_name'];
    $default = isset($args['default']) ? (int) $args['default'] : 4;
    $min = isset($args['min']) ? (int) $args['min'] : 1;
    $max = isset($args['max']) ? (int) $args['max'] : 20;
    $description = isset($args['description']) ? $args['description'] : '';
    $value = (int) get_option($option, $default);

    printf(
        '<input type="number" id="%1$s" name="%1$s" value="%2$d" min="%3$d" max="%4$d" style="width:80px" />',
        esc_attr($option),
        $value,
        $min,
        $max
    );

    if ($description) {
        echo '<p class="description">' . esc_html($description) . '</p>';
    }
}

/**
 * Generic select field.
 */
function blogar_select_field_cb($args)
{
    $option = $args['option_name'];
    $default = isset($args['default']) ? $args['default'] : '';
    $options = isset($args['options']) ? $args['options'] : array();
    $description = isset($args['description']) ? $args['description'] : '';
    $value = get_option($option, $default);

    echo '<select id="' . esc_attr($option) . '" name="' . esc_attr($option) . '" style="min-width:220px">';

    foreach ($options as $key => $label) {
        printf(
            '<option value="%s" %s>%s</option>',
            esc_attr($key),
            selected($value, $key, false),
            esc_html($label)
        );
    }

    echo '</select>';

    if ($description) {
        echo '<p class="description">' . esc_html($description) . '</p>';
    }
}

/**
 * Generic category select field.
 */
function blogar_category_select_field_cb($args)
{
    $option = $args['option_name'];
    $default = isset($args['default']) ? (int) $args['default'] : 0;
    $description = isset($args['description']) ? $args['description'] : '';
    $all_label = isset($args['all_label']) ? $args['all_label'] : __('— All categories —', 'blogar');
    $value = (int) get_option($option, $default);

    $categories = get_categories(array(
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC',
    ));

    echo '<select id="' . esc_attr($option) . '" name="' . esc_attr($option) . '" style="min-width:220px">';
    echo '<option value="0">' . esc_html($all_label) . '</option>';

    foreach ($categories as $cat) {
        printf(
            '<option value="%d" %s>%s (%d)</option>',
            $cat->term_id,
            selected($value, $cat->term_id, false),
            esc_html($cat->name),
            $cat->count
        );
    }

    echo '</select>';

    if ($description) {
        echo '<p class="description">' . esc_html($description) . '</p>';
    }
}

/**
 * Tab field: text label + category dropdown.
 */
function blogar_tab_field_cb($args)
{
    $label_key = $args['label_key'];
    $cat_key = $args['cat_key'];
    $description = isset($args['description']) ? $args['description'] : '';
    $label_val = get_option($label_key, '');
    $cat_val = (int) get_option($cat_key, 0);

    // Text input cho label
    echo '<div style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-start">';

    printf(
        '<div><label style="display:block;margin-bottom:4px;font-weight:500">%s</label>'
        . '<input type="text" id="%s" name="%s" value="%s" placeholder="%s" style="width:200px" /></div>',
        esc_html__('Tên tab', 'blogar'),
        esc_attr($label_key),
        esc_attr($label_key),
        esc_attr($label_val),
        esc_attr__('VD: Accessibility', 'blogar')
    );

    // Category dropdown
    echo '<div>';
    printf(
        '<label for="%s" style="display:block;margin-bottom:4px;font-weight:500">%s</label>',
        esc_attr($cat_key),
        esc_html__('Category', 'blogar')
    );

    $categories = get_categories(array('hide_empty' => false, 'orderby' => 'name'));

    echo '<select id="' . esc_attr($cat_key) . '" name="' . esc_attr($cat_key) . '" style="min-width:220px">';
    echo '<option value="0">' . esc_html__('— Tất cả bài viết —', 'blogar') . '</option>';

    foreach ($categories as $cat) {
        printf(
            '<option value="%d" %s>%s (%d)</option>',
            $cat->term_id,
            selected($cat_val, $cat->term_id, false),
            esc_html($cat->name),
            $cat->count
        );
    }

    echo '</select>';
    echo '</div>';
    echo '</div>';

    if ($description) {
        echo '<p class="description" style="margin-top:6px">' . esc_html($description) . '</p>';
    }
}

/**
 * Grid tab field for Section 8: category + post slots 1/2/3.
 */
function blogar_s8_grid_tab_field_cb($args)
{
    $label_key = $args['label_key'];
    $cat_key = $args['cat_key'];
    $post_keys = isset($args['post_keys']) ? (array) $args['post_keys'] : array();
    $description = isset($args['description']) ? $args['description'] : '';
    $label_val = get_option($label_key, '');
    $cat_val = (int) get_option($cat_key, 0);

    $categories = get_categories(array(
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC',
    ));

    $posts = get_posts(array(
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'post_type' => 'post',
    ));

    echo '<div style="display:flex;flex-direction:column;gap:12px">';
    echo '<div style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-start">';

    printf(
        '<div><label style="display:block;margin-bottom:4px;font-weight:500">%s</label><input type="text" id="%s" name="%s" value="%s" placeholder="%s" style="width:200px" /></div>',
        esc_html__('Tab label', 'blogar'),
        esc_attr($label_key),
        esc_attr($label_key),
        esc_attr($label_val),
        esc_attr__('Example: Accessibility', 'blogar')
    );

    echo '<div>';
    printf(
        '<label for="%s" style="display:block;margin-bottom:4px;font-weight:500">%s</label>',
        esc_attr($cat_key),
        esc_html__('Category', 'blogar')
    );
    echo '<select id="' . esc_attr($cat_key) . '" name="' . esc_attr($cat_key) . '" style="min-width:220px">';
    echo '<option value="0">' . esc_html__('— Select category —', 'blogar') . '</option>';

    foreach ($categories as $cat) {
        printf(
            '<option value="%d" %s>%s (%d)</option>',
            $cat->term_id,
            selected($cat_val, $cat->term_id, false),
            esc_html($cat->name),
            $cat->count
        );
    }

    echo '</select>';
    echo '</div>';
    echo '</div>';

    echo '<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px">';

    foreach ($post_keys as $slot_index => $post_key) {
        $selected_post = (int) get_option($post_key, 0);

        echo '<div>';
        printf(
            '<label for="%s" style="display:block;margin-bottom:4px;font-weight:500">%s</label>',
            esc_attr($post_key),
            esc_html(sprintf(__('Position %d', 'blogar'), $slot_index + 1))
        );

        echo '<select id="' . esc_attr($post_key) . '" name="' . esc_attr($post_key) . '" style="width:100%">';
        echo '<option value="0">' . esc_html__('— Auto from selected category —', 'blogar') . '</option>';

        foreach ($posts as $post) {
            $label = esc_html($post->post_title) . ' (' . esc_html(get_the_date('d/m/Y', $post->ID)) . ')';

            echo '<option value="' . esc_attr($post->ID) . '" '
                . selected($selected_post, $post->ID, false) . '>'
                . $label
                . '</option>';
        }

        echo '</select>';
        echo '</div>';
    }

    echo '</div>';
    echo '</div>';

    if ($description) {
        echo '<p class="description" style="margin-top:6px">' . esc_html($description) . '</p>';
    }
}

/**
 * Sanitize array term IDs.
 *
 * @param  mixed $value Raw option value.
 * @return array
 */
function blogar_sanitize_term_ids($value)
{
    if (!is_array($value)) {
        return array();
    }

    $value = array_map('absint', $value);
    $value = array_values(array_filter($value));

    return array_values(array_unique($value));
}

/**
 * Sanitize sort option for homepage post sections.
 *
 * @param  string $value Raw option value.
 * @return string
 */
function blogar_sanitize_sort_option($value)
{
    return in_array($value, array('latest', 'popular'), true) ? $value : 'latest';
}


// ================================================================
// REUSABLE FIELD CALLBACKS
// ================================================================

/**
 * Render một <select> dropdown để chọn post.
 *
 * @param array $args {
 *     @type string $option_name  Option key lưu vào wp_options.
 *     @type string $description  Mô tả hiển thị bên dưới field.
 * }
 */
function blogar_post_select_field($args)
{
    $option_name = $args['option_name'];
    $selected_id = (int) get_option($option_name, 0);
    $description = isset($args['description']) ? $args['description'] : '';

    // Lấy tất cả published posts để hiển thị trong dropdown.
    $posts = get_posts(array(
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'post_type' => 'post',
    ));

    echo '<select name="' . esc_attr($option_name) . '" id="' . esc_attr($option_name) . '" style="min-width:380px;max-width:100%">';
    echo '<option value="0">' . esc_html__('— Chọn bài viết —', 'blogar') . '</option>';

    foreach ($posts as $post) {
        $label = esc_html($post->post_title);
        // Thêm ngày để dễ phân biệt bài trùng tên.
        $label .= ' (' . esc_html(get_the_date('d/m/Y', $post->ID)) . ')';

        echo '<option value="' . esc_attr($post->ID) . '" '
            . selected($selected_id, $post->ID, false) . '>'
            . $label
            . '</option>';
    }

    echo '</select>';

    if ($description) {
        echo '<p class="description">' . esc_html($description) . '</p>';
    }

    // Preview thumbnail nhỏ nếu đã chọn bài.
    if ($selected_id && has_post_thumbnail($selected_id)) {
        echo '<div style="margin-top:8px">';
        echo get_the_post_thumbnail($selected_id, array(120, 60), array('style' => 'border-radius:4px;object-fit:cover'));
        echo '</div>';
    }
}

/**
 * Render a multi-select dropdown to choose categories.
 *
 * @param array $args {
 *     @type string $option_name  Option key saved in wp_options.
 *     @type string $description  Description displayed below the field.
 * }
 */
function blogar_categories_multiselect_field($args)
{
    $option_name = $args['option_name'];
    $selected_ids = get_option($option_name, array());
    $selected_ids = is_array($selected_ids) ? array_map('absint', $selected_ids) : array();
    $description = isset($args['description']) ? $args['description'] : '';

    $categories = get_categories(array(
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC',
    ));

    echo '<input type="hidden" name="' . esc_attr($option_name) . '[]" value="" />';
    echo '<select name="' . esc_attr($option_name) . '[]" id="' . esc_attr($option_name) . '" multiple size="10" style="min-width:380px;max-width:100%">';

    foreach ($categories as $cat) {
        printf(
            '<option value="%d" %s>%s (%d)</option>',
            $cat->term_id,
            selected(in_array((int) $cat->term_id, $selected_ids, true), true, false),
            esc_html($cat->name),
            $cat->count
        );
    }

    echo '</select>';

    if ($description) {
        echo '<p class="description">' . esc_html($description) . '</p>';
    }
}

// ================================================================
// CATEGORY THUMBNAIL FIELDS
// ================================================================

/**
 * Enqueue media uploader on category admin screens.
 *
 * @param string $hook_suffix Current admin page hook.
 * @return void
 */
function blogar_enqueue_category_media($hook_suffix)
{
    if ($hook_suffix !== 'edit-tags.php' && $hook_suffix !== 'term.php') {
        return;
    }

    $screen = get_current_screen();
    if (!$screen || $screen->taxonomy !== 'category') {
        return;
    }

    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'blogar_enqueue_category_media');

/**
 * Render category thumbnail field on add form.
 *
 * @return void
 */
function blogar_category_add_thumbnail_field()
{
    ?>
<div class="form-field term-group blogar-category-thumbnail-wrap">
    <label for="blogar-category-image-id"><?php esc_html_e('Thumbnail', 'blogar'); ?></label>
    <input type="hidden" id="blogar-category-image-id" name="blogar_category_image_id" value="">
    <div class="blogar-category-thumbnail-preview" style="margin-bottom:12px"></div>
    <button type="button" class="button blogar-category-image-upload">
        <?php esc_html_e('Upload image', 'blogar'); ?>
    </button>
    <button type="button" class="button blogar-category-image-remove" style="display:none">
        <?php esc_html_e('Remove image', 'blogar'); ?>
    </button>
    <p class="description">
        <?php esc_html_e('This image is used first for the Trending Topics carousel in Section 5.', 'blogar'); ?>
    </p>
</div>
<?php
}
add_action('category_add_form_fields', 'blogar_category_add_thumbnail_field');

/**
 * Render category thumbnail field on edit form.
 *
 * @param WP_Term $term Category term object.
 * @return void
 */
function blogar_category_edit_thumbnail_field($term)
{
    $image_id = (int) get_term_meta($term->term_id, 'blogar_category_image_id', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
    ?>
<tr class="form-field term-group-wrap blogar-category-thumbnail-wrap">
    <th scope="row">
        <label for="blogar-category-image-id"><?php esc_html_e('Thumbnail', 'blogar'); ?></label>
    </th>
    <td>
        <input type="hidden" id="blogar-category-image-id" name="blogar_category_image_id"
            value="<?php echo esc_attr($image_id); ?>">
        <div class="blogar-category-thumbnail-preview" style="margin-bottom:12px">
            <?php if ($image_url): ?>
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term->name); ?>"
                style="display:block;width:120px;height:120px;object-fit:cover;border-radius:8px">
            <?php endif; ?>
        </div>
        <button type="button" class="button blogar-category-image-upload">
            <?php esc_html_e($image_id ? 'Change image' : 'Upload image', 'blogar'); ?>
        </button>
        <button type="button" class="button blogar-category-image-remove"
            style="<?php echo $image_id ? '' : 'display:none'; ?>">
            <?php esc_html_e('Remove image', 'blogar'); ?>
        </button>
        <p class="description">
            <?php esc_html_e('This image is used first for the Trending Topics carousel in Section 5.', 'blogar'); ?>
        </p>
    </td>
</tr>
<?php
}
add_action('category_edit_form_fields', 'blogar_category_edit_thumbnail_field');

/**
 * Save category thumbnail term meta.
 *
 * @param int $term_id Category term ID.
 * @return void
 */
function blogar_save_category_thumbnail_field($term_id)
{
    if (!isset($_POST['blogar_category_image_id'])) {
        return;
    }

    $image_id = absint(wp_unslash($_POST['blogar_category_image_id']));

    if ($image_id) {
        update_term_meta($term_id, 'blogar_category_image_id', $image_id);
        return;
    }

    delete_term_meta($term_id, 'blogar_category_image_id');
}
add_action('created_category', 'blogar_save_category_thumbnail_field');
add_action('edited_category', 'blogar_save_category_thumbnail_field');

/**
 * Print media uploader logic for category thumbnail fields.
 *
 * @return void
 */
function blogar_category_thumbnail_admin_js()
{
    $screen = get_current_screen();
    if (!$screen || $screen->taxonomy !== 'category') {
        return;
    }
    ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var wrappers = document.querySelectorAll(".blogar-category-thumbnail-wrap");
    if (!wrappers.length || typeof wp === "undefined" || !wp.media) {
        return;
    }

    wrappers.forEach(function(wrapper) {
        var input = wrapper.querySelector("#blogar-category-image-id");
        var preview = wrapper.querySelector(".blogar-category-thumbnail-preview");
        var uploadBtn = wrapper.querySelector(".blogar-category-image-upload");
        var removeBtn = wrapper.querySelector(".blogar-category-image-remove");

        if (!input || !preview || !uploadBtn || !removeBtn) {
            return;
        }

        var frame;

        function renderPreview(attachment) {
            if (!attachment) {
                preview.innerHTML = "";
                removeBtn.style.display = "none";
                return;
            }

            preview.innerHTML =
                '<img src="' + attachment.url +
                '" alt="" style="display:block;width:120px;height:120px;object-fit:cover;border-radius:8px">';
            removeBtn.style.display = "";
        }

        uploadBtn.addEventListener("click", function(event) {
            event.preventDefault();

            if (frame) {
                frame.open();
                return;
            }

            frame = wp.media({
                title: "Select category thumbnail",
                button: {
                    text: "Use image"
                },
                multiple: false
            });

            frame.on("select", function() {
                var attachment = frame.state().get("selection").first().toJSON();
                input.value = attachment.id || "";
                renderPreview(attachment);
            });

            frame.open();
        });

        removeBtn.addEventListener("click", function(event) {
            event.preventDefault();
            input.value = "";
            renderPreview(null);
        });
    });
});
</script>
<?php
}
add_action('admin_footer-edit-tags.php', 'blogar_category_thumbnail_admin_js');
add_action('admin_footer-term.php', 'blogar_category_thumbnail_admin_js');


// ================================================================
// RENDER ADMIN PAGE
// ================================================================

function blogar_render_options_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    // Xác định tab hiện tại.
    $active_tab = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : 'hero';

    $tabs = array(
        'hero' => __('① Hero Slider', 'blogar'),
        's4_innovation' => __('④ Innovation & Tech', 'blogar'),
        's5_topics' => __('⑤ Trending Topics', 'blogar'),
        's6_numbered_list' => __('⑥ Most Popular List', 'blogar'),
        's8_grid' => __('⑧ Most Popular Grid', 'blogar'),
        's9_post_list' => __('⑨ Post List + Sidebar', 'blogar'),
        's10_featured_video' => __('⑩ Featured Video', 'blogar'),
    );

    ?>
<div class="wrap">
    <h1><?php esc_html_e('Blogar Settings — Homepage', 'blogar'); ?></h1>
    <p class="description" style="font-size:14px;margin-bottom:20px">
        <?php esc_html_e('Cấu hình nội dung hiển thị trên từng section của trang chủ.', 'blogar'); ?>
    </p>

    <?php settings_errors('blogar_settings_notices'); ?>

    <nav class="nav-tab-wrapper" style="margin-bottom:0">
        <?php foreach ($tabs as $tab_key => $tab_label): ?>
        <a href="<?php echo esc_url(add_query_arg(array('page' => 'blogar-settings', 'tab' => $tab_key), admin_url('themes.php'))); ?>"
            class="nav-tab <?php echo ($active_tab === $tab_key) ? 'nav-tab-active' : ''; ?>">
            <?php echo esc_html($tab_label); ?>
        </a>
        <?php endforeach; ?>
    </nav>

    <div
        style="background:#fff;border:1px solid #c3c4c7;border-top:none;padding:20px 24px 8px;border-radius:0 0 4px 4px">
        <form method="post" action="options.php">
            <?php
                if ($active_tab === 'hero') {
                    settings_fields('blogar_hero_settings');
                    do_settings_sections('blogar-hero');
                } elseif ($active_tab === 's4_innovation') {
                    settings_fields('blogar_s4_settings');
                    do_settings_sections('blogar-s4');
                } elseif ($active_tab === 's5_topics') {
                    settings_fields('blogar_s5_settings');
                    do_settings_sections('blogar-s5');
                } elseif ($active_tab === 's6_numbered_list') {
                    settings_fields('blogar_s6_settings');
                    do_settings_sections('blogar-s6');
                } elseif ($active_tab === 's8_grid') {
                    settings_fields('blogar_s8_settings');
                    do_settings_sections('blogar-s8');
                } elseif ($active_tab === 's9_post_list') {
                    settings_fields('blogar_s9_settings');
                    do_settings_sections('blogar-s9');
                } elseif ($active_tab === 's10_featured_video') {
                    settings_fields('blogar_s10_settings');
                    do_settings_sections('blogar-s10');
                }
                submit_button(__('Lưu cài đặt', 'blogar'));
                ?>

        </form>
        <?php do_action('blogar_settings_page_extra_sections'); ?>
    </div>
</div>
<?php
}


/**
 * ARCHIVE LAYOUT SETTINGS
 * ─────────────────────────────────────────────────────────────────
 * Thêm đoạn code này vào file inc/theme-options.php của bạn.
 *
 * Nó đăng ký:
 *  - 1 settings section "Archive Layout" trong trang Blogar Settings
 *  - 1 field radio: "With Sidebar" | "Full Width (no sidebar)"
 *  - Option key: blogar_archive_layout  ('sidebar' | 'full')
 *
 * Cách đọc option trong template:
 *   $layout = get_option( 'blogar_archive_layout', 'sidebar' );
 * ─────────────────────────────────────────────────────────────────
 */

// ── 1. Register setting + section + field ─────────────────────────
add_action('admin_init', 'blogar_register_archive_layout_setting');

function blogar_register_archive_layout_setting()
{

    register_setting(
        'blogar_archive_options_group',   // option group (dùng cho settings_fields())
        'blogar_archive_layout',          // option name
        array(
            'type' => 'string',
            'sanitize_callback' => 'blogar_sanitize_archive_layout',
            'default' => 'sidebar',
        )
    );

    add_settings_section(
        'blogar_archive_layout_section',          // section id
        __('Archive Page Layout', 'blogar'),    // title
        'blogar_archive_layout_section_cb',       // callback
        'blogar-settings'                         // page slug — khớp với page slug của Blogar Settings
    );

    add_settings_field(
        'blogar_archive_layout_field',            // field id
        __('Select Layout', 'blogar'),          // label
        'blogar_archive_layout_field_cb',         // callback
        'blogar-settings',                        // page slug
        'blogar_archive_layout_section'           // section id
    );
}

// ── 2. Sanitize ───────────────────────────────────────────────────
function blogar_sanitize_archive_layout($value)
{
    $allowed = array('sidebar', 'full');
    return in_array($value, $allowed, true) ? $value : 'sidebar';
}

// ── 3. Section description ────────────────────────────────────────
function blogar_archive_layout_section_cb()
{
    echo '<p style="color:#666;margin-top:0;">'
        . esc_html__('Choose how the Archive / Category pages display posts.', 'blogar')
        . '</p>';
}

// ── 4. Field markup ───────────────────────────────────────────────
function blogar_archive_layout_field_cb()
{
    $current = get_option('blogar_archive_layout', 'sidebar');
    $options = array(
        'sidebar' => array(
            'label' => __('With Sidebar', 'blogar'),
            'desc' => __('Post list (col-8) + sticky sidebar (col-4) with Popular Posts, Categories, Newsletter.', 'blogar'),
            'icon' => '⬜⬜⬛',  // visual hint
        ),
        'full' => array(
            'label' => __('Full Width — No Sidebar', 'blogar'),
            'desc' => __('Responsive card grid using the full container width. Desktop shows 3 posts per row, then 2 on tablet and 1 on mobile.', 'blogar'),
            'icon' => '⬜⬜⬜⬜',
        ),
    );
    ?>
<div style="display:flex;gap:24px;flex-wrap:wrap;">
    <?php foreach ($options as $value => $opt):
            $checked = checked($current, $value, false);
            $is_active = ($current === $value);
            $border = $is_active ? '2px solid #3858f6' : '2px solid #ddd';
            $bg = $is_active ? '#f0f4ff' : '#fff';
            ?>
    <label for="blogar_archive_layout_<?php echo esc_attr($value); ?>" style="display:flex;flex-direction:column;gap:8px;padding:16px 20px;
                      border:<?php echo $border; ?>;border-radius:8px;background:<?php echo $bg; ?>;
                      cursor:pointer;min-width:220px;max-width:280px;transition:border-color .2s;">
        <div style="display:flex;align-items:center;gap:10px;">
            <input type="radio" id="blogar_archive_layout_<?php echo esc_attr($value); ?>" name="blogar_archive_layout"
                value="<?php echo esc_attr($value); ?>" <?php echo $checked; ?>>
            <strong style="font-size:14px;color:#1a1a1a;"><?php echo esc_html($opt['label']); ?></strong>
        </div>
        <!-- Mini preview -->
        <div style="height:56px;background:#f5f5f5;border-radius:4px;overflow:hidden;display:flex;gap:4px;padding:6px;">
            <?php if ($value === 'sidebar'): ?>
            <div style="flex:2;background:#c0c8f8;border-radius:3px;"></div>
            <div style="flex:1;background:#dde3fb;border-radius:3px;"></div>
            <?php else: ?>
            <div style="flex:1;background:#c0c8f8;border-radius:3px;"></div>
            <div style="flex:1;background:#c0c8f8;border-radius:3px;"></div>
            <?php endif; ?>
        </div>
        <p style="margin:0;font-size:12px;color:#666;line-height:1.5;">
            <?php echo esc_html($opt['desc']); ?>
        </p>
    </label>
    <?php endforeach; ?>
</div>

<?php
    // Live border highlight on change (pure JS, no dependency)
    ?>
<script>
(function() {
    document.querySelectorAll('[name="blogar_archive_layout"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.querySelectorAll('[name="blogar_archive_layout"]').forEach(function(r) {
                var lbl = r.closest('label');
                lbl.style.borderColor = '#ddd';
                lbl.style.background = '#fff';
            });
            var active = document.querySelector('[name="blogar_archive_layout"]:checked');
            if (active) {
                var lbl = active.closest('label');
                lbl.style.borderColor = '#3858f6';
                lbl.style.background = '#f0f4ff';
            }
        });
    });
})();
</script>
<?php
}


// ── 5. Render section inside existing Blogar Settings page ────────
/**
 * QUAN TRỌNG: Trang Blogar Settings của bạn trong theme-options.php
 * cần gọi thêm 2 dòng này trong form để section này hiển thị:
 *
 *   settings_fields( 'blogar_archive_options_group' );
 *   do_settings_sections( 'blogar-settings' );
 *
 * Nếu trang Settings của bạn dùng một options group khác (ví dụ
 * 'blogar_options_group'), hãy thay 'blogar_archive_options_group'
 * ở register_setting() phía trên bằng group đó.
 *
 * Nếu Blogar Settings page của bạn tự render field riêng (không qua
 * do_settings_sections), thêm hook sau:
 */
add_action('blogar_settings_page_extra_sections', 'blogar_render_archive_layout_standalone');

function blogar_render_archive_layout_standalone()
{
    ?>
<div class="blogar-settings-section" style="margin-top:30px;padding-top:24px;border-top:1px solid #e5e5e5;">
    <form method="post" action="options.php">
        <?php
        // options.php only processes one settings group per submit, so this
        // standalone section needs its own nonce and option_page payload.
        settings_fields('blogar_archive_options_group');
        ?>
        <h2 style="font-size:16px;margin:0 0 4px;"><?php esc_html_e('Archive Page Layout', 'blogar'); ?></h2>
        <?php blogar_archive_layout_section_cb(); ?>
        <?php blogar_archive_layout_field_cb(); ?>
        <?php submit_button(__('Save Archive Layout', 'blogar')); ?>
    </form>
</div>
<?php
}


// Single page layout setting: with sidebar | no sidebar
add_action('admin_init', 'blogar_register_single_layout_setting');

function blogar_register_single_layout_setting()
{
    register_setting(
        'blogar_single_options_group',
        'blogar_single_layout',
        array(
            'type' => 'string',
            'sanitize_callback' => 'blogar_sanitize_archive_layout',
            'default' => 'sidebar',
        )
    );
}

function blogar_single_layout_section_cb()
{
    echo '<p style="color:#666;margin-top:0;">'
        . esc_html__('Choose how single post pages display the main article content.', 'blogar')
        . '</p>';
}

function blogar_single_layout_field_cb()
{
    $current = get_option('blogar_single_layout', 'sidebar');
    $options = array(
        'sidebar' => array(
            'label' => __('With Sidebar', 'blogar'),
            'desc' => __('Main content with the existing sticky sidebar widgets on the right.', 'blogar'),
        ),
        'full' => array(
            'label' => __('No Sidebar', 'blogar'),
            'desc' => __('Centered reading layout without sidebar. The post content becomes wider while staying comfortable to read on desktop, tablet, and mobile.', 'blogar'),
        ),
    );
    ?>
<div style="display:flex;gap:24px;flex-wrap:wrap;">
    <?php foreach ($options as $value => $opt):
        $checked = checked($current, $value, false);
        $is_active = ($current === $value);
        $border = $is_active ? '2px solid #3858f6' : '2px solid #ddd';
        $bg = $is_active ? '#f0f4ff' : '#fff';
        ?>
    <label for="blogar_single_layout_<?php echo esc_attr($value); ?>" style="display:flex;flex-direction:column;gap:8px;padding:16px 20px;
                      border:<?php echo $border; ?>;border-radius:8px;background:<?php echo $bg; ?>;
                      cursor:pointer;min-width:220px;max-width:320px;transition:border-color .2s;">
        <div style="display:flex;align-items:center;gap:10px;">
            <input type="radio" id="blogar_single_layout_<?php echo esc_attr($value); ?>" name="blogar_single_layout"
                value="<?php echo esc_attr($value); ?>" <?php echo $checked; ?>>
            <strong style="font-size:14px;color:#1a1a1a;"><?php echo esc_html($opt['label']); ?></strong>
        </div>
        <div style="height:56px;background:#f5f5f5;border-radius:4px;overflow:hidden;display:flex;gap:4px;padding:6px;">
            <?php if ($value === 'sidebar'): ?>
            <div style="flex:2;background:#c0c8f8;border-radius:3px;"></div>
            <div style="flex:1;background:#dde3fb;border-radius:3px;"></div>
            <?php else: ?>
            <div style="flex:1;background:#c0c8f8;border-radius:3px;"></div>
            <?php endif; ?>
        </div>
        <p style="margin:0;font-size:12px;color:#666;line-height:1.5;">
            <?php echo esc_html($opt['desc']); ?>
        </p>
    </label>
    <?php endforeach; ?>
</div>

<script>
(function() {
    document.querySelectorAll('[name="blogar_single_layout"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.querySelectorAll('[name="blogar_single_layout"]').forEach(function(r) {
                var lbl = r.closest('label');
                lbl.style.borderColor = '#ddd';
                lbl.style.background = '#fff';
            });
            var active = document.querySelector('[name="blogar_single_layout"]:checked');
            if (active) {
                var lbl = active.closest('label');
                lbl.style.borderColor = '#3858f6';
                lbl.style.background = '#f0f4ff';
            }
        });
    });
})();
</script>
<?php
}

add_action('blogar_settings_page_extra_sections', 'blogar_render_single_layout_standalone');

function blogar_render_single_layout_standalone()
{
    ?>
<div class="blogar-settings-section" style="margin-top:30px;padding-top:24px;border-top:1px solid #e5e5e5;">
    <form method="post" action="options.php">
        <?php settings_fields('blogar_single_options_group'); ?>
        <h2 style="font-size:16px;margin:0 0 4px;"><?php esc_html_e('Single Page Layout', 'blogar'); ?></h2>
        <?php blogar_single_layout_section_cb(); ?>
        <?php blogar_single_layout_field_cb(); ?>
        <?php submit_button(__('Save Single Layout', 'blogar')); ?>
    </form>
</div>
<?php
}
