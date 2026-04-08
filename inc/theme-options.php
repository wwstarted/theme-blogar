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

    // ── Section 4: Innovation & Tech ─────────────────────────────
    register_setting('blogar_s4_settings', 'blogar_s4_enabled', array('sanitize_callback' => 'absint', 'default' => 1));
    register_setting('blogar_s4_settings', 'blogar_s4_title', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('blogar_s4_settings', 'blogar_s4_post_count', array('sanitize_callback' => 'absint'));

    for ($i = 1; $i <= 3; $i++) {
        register_setting('blogar_s4_settings', "blogar_s4_tab_{$i}_label", array('sanitize_callback' => 'sanitize_text_field'));
        register_setting('blogar_s4_settings', "blogar_s4_tab_{$i}_cat", array('sanitize_callback' => 'absint'));
    }

    add_settings_section('blogar_s4_section', __('Innovation & Tech', 'blogar'), 'blogar_s4_section_cb', 'blogar-s4');

    add_settings_field('blogar_s4_enabled', __('Display section', 'blogar'), 'blogar_section_toggle_field_cb', 'blogar-s4', 'blogar_s4_section', array('option_name' => 'blogar_s4_enabled'));

    add_settings_field('blogar_s4_title', __('Tiêu đề section', 'blogar'), 'blogar_text_field_cb', 'blogar-s4', 'blogar_s4_section', array(
        'option_name' => 'blogar_s4_title',
        'default' => 'Innovation & Tech',
        'placeholder' => 'Innovation & Tech',
    ));

    add_settings_field('blogar_s4_post_count', __('Số bài mỗi tab', 'blogar'), 'blogar_number_field_cb', 'blogar-s4', 'blogar_s4_section', array(
        'option_name' => 'blogar_s4_post_count',
        'default' => 4,
        'min' => 1,
        'max' => 12,
        'description' => __('Số bài viết hiển thị trong mỗi tab carousel (1–12)', 'blogar'),
    ));

    for ($i = 1; $i <= 3; $i++) {
        add_settings_field("blogar_s4_tab_{$i}", sprintf(__('Tab %d', 'blogar'), $i), 'blogar_tab_field_cb', 'blogar-s4', 'blogar_s4_section', array(
            'index' => $i,
            'label_key' => "blogar_s4_tab_{$i}_label",
            'cat_key' => "blogar_s4_tab_{$i}_cat",
            'description' => $i === 1 ? __('Tab đầu tiên — mặc định được chọn khi vào trang', 'blogar') : '',
        ));
    }

    // ── Section 5: Trending Topics ───────────────────────────────
    register_setting('blogar_s5_settings', 'blogar_s5_enabled', array('sanitize_callback' => 'absint', 'default' => 1));
    register_setting('blogar_s5_settings', 'blogar_s5_title', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('blogar_s5_settings', 'blogar_s5_count', array('sanitize_callback' => 'absint'));
    register_setting('blogar_s5_settings', 'blogar_s5_categories', array('sanitize_callback' => 'blogar_sanitize_term_ids'));

    add_settings_section('blogar_s5_section', __('Trending Topics', 'blogar'), 'blogar_s5_section_cb', 'blogar-s5');

    add_settings_field('blogar_s5_enabled', __('Display section', 'blogar'), 'blogar_section_toggle_field_cb', 'blogar-s5', 'blogar_s5_section', array('option_name' => 'blogar_s5_enabled'));

    add_settings_field('blogar_s5_title', __('Section title', 'blogar'), 'blogar_text_field_cb', 'blogar-s5', 'blogar_s5_section', array(
        'option_name' => 'blogar_s5_title',
        'default' => 'Trending Topics',
        'placeholder' => 'Trending Topics',
    ));

    add_settings_field('blogar_s5_count', __('Categories count', 'blogar'), 'blogar_number_field_cb', 'blogar-s5', 'blogar_s5_section', array(
        'option_name' => 'blogar_s5_count',
        'default' => 8,
        'min' => 1,
        'max' => 20,
        'description' => __('Number of categories shown in the carousel (1–20).', 'blogar'),
    ));

    add_settings_field('blogar_s5_categories', __('Select categories', 'blogar'), 'blogar_categories_multiselect_field', 'blogar-s5', 'blogar_s5_section', array(
        'option_name' => 'blogar_s5_categories',
        'description' => __('Choose which categories to render. If left empty, falls back to categories with the most posts.', 'blogar'),
    ));

    // ── Section 10: Featured Video ───────────────────────────────
    register_setting('blogar_s10_settings', 'blogar_s10_enabled', array('sanitize_callback' => 'absint', 'default' => 1));
    register_setting('blogar_s10_settings', 'blogar_s10_title', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('blogar_s10_settings', 'blogar_s10_main_post', array('sanitize_callback' => 'absint'));

    for ($i = 1; $i <= 4; $i++) {
        register_setting('blogar_s10_settings', "blogar_s10_small_post_{$i}", array('sanitize_callback' => 'absint'));
    }

    add_settings_section('blogar_s10_section', __('Featured Video', 'blogar'), 'blogar_s10_section_cb', 'blogar-s10');

    add_settings_field('blogar_s10_enabled', __('Display section', 'blogar'), 'blogar_section_toggle_field_cb', 'blogar-s10', 'blogar_s10_section', array('option_name' => 'blogar_s10_enabled'));

    add_settings_field('blogar_s10_title', __('Section title', 'blogar'), 'blogar_text_field_cb', 'blogar-s10', 'blogar_s10_section', array(
        'option_name' => 'blogar_s10_title',
        'default' => 'Featured Video',
        'placeholder' => 'Featured Video',
    ));

    add_settings_field('blogar_s10_main_post', __('Big post', 'blogar'), 'blogar_post_select_field', 'blogar-s10', 'blogar_s10_section', array(
        'option_name' => 'blogar_s10_main_post',
        'description' => __('Post used for the large card on the left. Falls back to the latest post.', 'blogar'),
    ));

    for ($i = 1; $i <= 4; $i++) {
        add_settings_field("blogar_s10_small_post_{$i}", sprintf(__('Small post %d', 'blogar'), $i), 'blogar_post_select_field', 'blogar-s10', 'blogar_s10_section', array(
            'option_name' => "blogar_s10_small_post_{$i}",
            'description' => $i === 1 ? __('Posts for the 2×2 grid on the right. Empty slots fall back to the latest posts.', 'blogar') : '',
        ));
    }

    // ── Section 11: News Highlight Block ─────────────────────────
    register_setting('blogar_s11_settings', 'blogar_s11_enabled', array('sanitize_callback' => 'absint', 'default' => 1));
    register_setting('blogar_s11_settings', 'blogar_s11_ticker_title', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('blogar_s11_settings', 'blogar_s11_cat', array('sanitize_callback' => 'absint'));
    register_setting('blogar_s11_settings', 'blogar_s11_main_post', array('sanitize_callback' => 'absint'));

    for ($i = 1; $i <= 3; $i++) {
        register_setting('blogar_s11_settings', "blogar_s11_small_post_{$i}", array('sanitize_callback' => 'absint'));
    }

    add_settings_section('blogar_s11_section', __('News Highlight Block', 'blogar'), 'blogar_s11_section_cb', 'blogar-s11');

    add_settings_field('blogar_s11_enabled', __('Display section', 'blogar'), 'blogar_section_toggle_field_cb', 'blogar-s11', 'blogar_s11_section', array('option_name' => 'blogar_s11_enabled'));

    add_settings_field('blogar_s11_ticker_title', __('Ticker label', 'blogar'), 'blogar_text_field_cb', 'blogar-s11', 'blogar_s11_section', array(
        'option_name' => 'blogar_s11_ticker_title',
        'default' => 'News Highlight',
        'placeholder' => 'News Highlight',
    ));

    add_settings_field('blogar_s11_cat', __('Category filter', 'blogar'), 'blogar_category_select_field', 'blogar-s11', 'blogar_s11_section', array(
        'option_name' => 'blogar_s11_cat',
        'description' => __('Filter all posts in this block by category. Leave at "— All categories —" to use latest posts.', 'blogar'),
    ));

    add_settings_field('blogar_s11_main_post', __('Featured post (large)', 'blogar'), 'blogar_post_select_field', 'blogar-s11', 'blogar_s11_section', array(
        'option_name' => 'blogar_s11_main_post',
        'description' => __('The hero post displayed large on the left. Falls back to the latest post.', 'blogar'),
    ));

    for ($i = 1; $i <= 3; $i++) {
        add_settings_field("blogar_s11_small_post_{$i}", sprintf(__('Small post %d', 'blogar'), $i), 'blogar_post_select_field', 'blogar-s11', 'blogar_s11_section', array(
            'option_name' => "blogar_s11_small_post_{$i}",
            'description' => $i === 1 ? __('Three stacked small cards on the right. Empty slots fall back automatically.', 'blogar') : '',
        ));
    }

    // ── Section 12: Featured Grid — This Week (asymmetric fvg) ───
    // Layout: 1 big left | 1 medium top-right + 3 small bottom-right
    register_setting('blogar_s12_settings', 'blogar_s12_enabled', array('sanitize_callback' => 'absint', 'default' => 1));
    register_setting('blogar_s12_settings', 'blogar_s12_title', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('blogar_s12_settings', 'blogar_s12_big_post', array('sanitize_callback' => 'absint'));
    register_setting('blogar_s12_settings', 'blogar_s12_medium_post', array('sanitize_callback' => 'absint'));

    for ($i = 1; $i <= 3; $i++) {
        register_setting('blogar_s12_settings', "blogar_s12_small_post_{$i}", array('sanitize_callback' => 'absint'));
    }

    add_settings_section('blogar_s12_section', __('Featured Grid — This Week', 'blogar'), 'blogar_s12_section_cb', 'blogar-s12');

    add_settings_field('blogar_s12_enabled', __('Display section', 'blogar'), 'blogar_section_toggle_field_cb', 'blogar-s12', 'blogar_s12_section', array('option_name' => 'blogar_s12_enabled'));

    add_settings_field('blogar_s12_title', __('Section title', 'blogar'), 'blogar_text_field_cb', 'blogar-s12', 'blogar_s12_section', array(
        'option_name' => 'blogar_s12_title',
        'default' => 'Featured Videos In This Week',
        'placeholder' => 'Featured Videos In This Week',
    ));

    add_settings_field('blogar_s12_big_post', __('Big post (full-height left)', 'blogar'), 'blogar_post_select_field', 'blogar-s12', 'blogar_s12_section', array(
        'option_name' => 'blogar_s12_big_post',
        'description' => __('The large full-height card on the left column.', 'blogar'),
    ));

    add_settings_field('blogar_s12_medium_post', __('Medium post (top-right)', 'blogar'), 'blogar_post_select_field', 'blogar-s12', 'blogar_s12_section', array(
        'option_name' => 'blogar_s12_medium_post',
        'description' => __('The medium card at the top of the right column.', 'blogar'),
    ));

    for ($i = 1; $i <= 3; $i++) {
        add_settings_field("blogar_s12_small_post_{$i}", sprintf(__('Small post %d (bottom-right)', 'blogar'), $i), 'blogar_post_select_field', 'blogar-s12', 'blogar_s12_section', array(
            'option_name' => "blogar_s12_small_post_{$i}",
            'description' => $i === 1 ? __('Three equal small cards at the bottom of the right column.', 'blogar') : '',
        ));
    }

    // ── Section 13: Featured Grid 2+3 (fvg2 dark) ───────────────
    // Layout: 2 equal top cards | 3 equal bottom cards
    // Can use category filter OR pick individual posts
    register_setting('blogar_s13_settings', 'blogar_s13_enabled', array('sanitize_callback' => 'absint', 'default' => 1));
    register_setting('blogar_s13_settings', 'blogar_s13_title', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('blogar_s13_settings', 'blogar_s13_cat', array('sanitize_callback' => 'absint'));

    for ($i = 1; $i <= 5; $i++) {
        register_setting('blogar_s13_settings', "blogar_s13_post_{$i}", array('sanitize_callback' => 'absint'));
    }

    add_settings_section('blogar_s13_section', __('Featured Grid 2+3 (Dark)', 'blogar'), 'blogar_s13_section_cb', 'blogar-s13');

    add_settings_field('blogar_s13_enabled', __('Display section', 'blogar'), 'blogar_section_toggle_field_cb', 'blogar-s13', 'blogar_s13_section', array('option_name' => 'blogar_s13_enabled'));

    add_settings_field('blogar_s13_title', __('Section title', 'blogar'), 'blogar_text_field_cb', 'blogar-s13', 'blogar_s13_section', array(
        'option_name' => 'blogar_s13_title',
        'default' => 'Top Stories This Week',
        'placeholder' => 'Top Stories This Week',
    ));

    add_settings_field('blogar_s13_cat', __('Category filter (fallback)', 'blogar'), 'blogar_category_select_field', 'blogar-s13', 'blogar_s13_section', array(
        'option_name' => 'blogar_s13_cat',
        'description' => __('Used as fallback when individual posts are not selected. Leave at "All" to use the latest posts.', 'blogar'),
    ));

    for ($i = 1; $i <= 5; $i++) {
        $label = $i <= 2
            ? sprintf(__('Top row — post %d', 'blogar'), $i)
            : sprintf(__('Bottom row — post %d', 'blogar'), $i - 2);

        add_settings_field("blogar_s13_post_{$i}", $label, 'blogar_post_select_field', 'blogar-s13', 'blogar_s13_section', array(
            'option_name' => "blogar_s13_post_{$i}",
            'description' => $i === 1
                ? __('Top row: 2 equal cards. Bottom row: 3 equal cards. Empty slots auto-fill from category or latest posts.', 'blogar')
                : '',
        ));
    }

    // ── Section 14: Latest Posts Grid ────────────────────────────
    // Layout: uniform card grid (4 cols desktop)
    register_setting('blogar_s14_settings', 'blogar_s14_enabled', array('sanitize_callback' => 'absint', 'default' => 1));
    register_setting('blogar_s14_settings', 'blogar_s14_title', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('blogar_s14_settings', 'blogar_s14_count', array('sanitize_callback' => 'absint'));
    register_setting('blogar_s14_settings', 'blogar_s14_cat', array('sanitize_callback' => 'absint'));

    add_settings_section('blogar_s14_section', __('Latest Posts Grid', 'blogar'), 'blogar_s14_section_cb', 'blogar-s14');

    add_settings_field('blogar_s14_enabled', __('Display section', 'blogar'), 'blogar_section_toggle_field_cb', 'blogar-s14', 'blogar_s14_section', array('option_name' => 'blogar_s14_enabled'));

    add_settings_field('blogar_s14_title', __('Section title', 'blogar'), 'blogar_text_field_cb', 'blogar-s14', 'blogar_s14_section', array(
        'option_name' => 'blogar_s14_title',
        'default' => 'Latest Posts',
        'placeholder' => 'Latest Posts',
    ));

    add_settings_field('blogar_s14_count', __('Number of posts', 'blogar'), 'blogar_number_field_cb', 'blogar-s14', 'blogar_s14_section', array(
        'option_name' => 'blogar_s14_count',
        'default' => 8,
        'min' => 4,
        'max' => 24,
        'description' => __('How many posts to show in the grid (4–24). Best results with multiples of 4.', 'blogar'),
    ));

    add_settings_field('blogar_s14_cat', __('Category filter', 'blogar'), 'blogar_category_select_field', 'blogar-s14', 'blogar_s14_section', array(
        'option_name' => 'blogar_s14_cat',
        'description' => __('Show only posts from this category. Leave at "— All categories —" to show the latest posts from all categories.', 'blogar'),
    ));
}
add_action('admin_init', 'blogar_register_settings');


// ================================================================
// SECTION DESCRIPTION CALLBACKS
// ================================================================

function blogar_s4_section_cb()
{
    echo '<p class="description">' . esc_html__('Title, post count and up to 3 tabs for the Innovation & Tech section. Tabs without a category pull the latest posts from all categories.', 'blogar') . '</p>';
}

function blogar_s5_section_cb()
{
    echo '<p class="description">' . esc_html__('Title, category count and which categories appear in the Trending Topics carousel. Category thumbnails use the latest featured image found in each category.', 'blogar') . '</p>';
}

function blogar_s10_section_cb()
{
    echo '<p class="description">' . esc_html__('Title + 1 big post + 4 small posts for the Featured Video area. Empty slots fall back to the latest published posts.', 'blogar') . '</p>';
}

function blogar_s11_section_cb()
{
    echo '<p class="description">' . esc_html__('The headline block at the top of the homepage. Configure the ticker label, an optional category filter, 1 large hero post and 3 stacked small cards.', 'blogar') . '</p>';
}

function blogar_s12_section_cb()
{
    echo '<p class="description">'
        . esc_html__('Asymmetric featured grid: one full-height card on the left, one medium card top-right and three small cards bottom-right. Select each post individually — empty slots auto-fill from the latest posts.', 'blogar')
        . '</p>'
        . '<div style="margin-top:10px;padding:12px 14px;background:#f9f9f9;border:1px solid #ddd;border-radius:6px;font-size:12px;color:#555;line-height:1.6;">'
        . '<strong>' . esc_html__('Layout preview:', 'blogar') . '</strong><br>'
        . '<code style="font-size:11px;">[ Big (left) ] | [ Medium (top-right) ]<br>'
        . '             | [ Small 1 ] [ Small 2 ] [ Small 3 ]</code>'
        . '</div>';
}

function blogar_s13_section_cb()
{
    echo '<p class="description">'
        . esc_html__('Dark-background featured grid with 5 equal posts: 2 in the top row and 3 in the bottom row. Pick posts individually or set a category fallback.', 'blogar')
        . '</p>'
        . '<div style="margin-top:10px;padding:12px 14px;background:#f9f9f9;border:1px solid #ddd;border-radius:6px;font-size:12px;color:#555;line-height:1.6;">'
        . '<strong>' . esc_html__('Layout preview:', 'blogar') . '</strong><br>'
        . '<code style="font-size:11px;">[ Post 1 ] [ Post 2 ]<br>[ Post 3 ] [ Post 4 ] [ Post 5 ]</code>'
        . '</div>';
}

function blogar_s14_section_cb()
{
    echo '<p class="description">' . esc_html__('Uniform card grid showing the latest posts. Control the section title, number of posts and optionally filter by a single category.', 'blogar') . '</p>';
}


// ================================================================
// REUSABLE FIELD CALLBACKS
// ================================================================

/**
 * Section enabled/disabled toggle.
 */
function blogar_section_toggle_field_cb($args)
{
    $option = $args['option_name'];
    $enabled = (bool) get_option($option, 1);
    ?>
    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;font-size:13px;font-weight:500;">
        <input type="hidden" name="<?php echo esc_attr($option); ?>" value="0">
        <input type="checkbox" id="<?php echo esc_attr($option); ?>"
            name="<?php echo esc_attr($option); ?>" value="1"
            <?php checked($enabled, true); ?>>
        <span><?php esc_html_e('Show this section on the homepage', 'blogar'); ?></span>
    </label>
    <?php
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
 * Returns all categories, cached for the current request.
 */
function blogar_get_all_categories_cached()
{
    static $cache = null;
    if ($cache === null) {
        $cache = get_categories(array('hide_empty' => false, 'orderby' => 'name', 'order' => 'ASC'));
    }
    return $cache;
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

    echo '<div>';
    printf(
        '<label for="%s" style="display:block;margin-bottom:4px;font-weight:500">%s</label>',
        esc_attr($cat_key),
        esc_html__('Category', 'blogar')
    );

    $categories = blogar_get_all_categories_cached();

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

    echo '</select></div></div>';

    if ($description) {
        echo '<p class="description" style="margin-top:6px">' . esc_html($description) . '</p>';
    }
}

/**
 * Single category dropdown field.
 */
function blogar_category_select_field($args)
{
    $option_name = $args['option_name'];
    $selected_id = (int) get_option($option_name, 0);
    $description = isset($args['description']) ? $args['description'] : '';

    $categories = blogar_get_all_categories_cached();

    echo '<select name="' . esc_attr($option_name) . '" id="' . esc_attr($option_name) . '" style="min-width:280px;max-width:100%">';
    echo '<option value="0">' . esc_html__('— All categories —', 'blogar') . '</option>';

    foreach ($categories as $cat) {
        printf(
            '<option value="%d" %s>%s (%d posts)</option>',
            $cat->term_id,
            selected($selected_id, $cat->term_id, false),
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
 * Render a post select dropdown.
 */
function blogar_post_select_field($args)
{
    $option_name = $args['option_name'];
    $selected_id = (int) get_option($option_name, 0);
    $description = isset($args['description']) ? $args['description'] : '';

    static $cached_posts = null;
    if ($cached_posts === null) {
        $cached_posts = get_posts(array(
            'numberposts' => 100,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'post_type' => 'post',
        ));
    }
    $posts = $cached_posts;

    // Nếu bài đang được chọn không nằm trong 100 bài mới nhất, thêm vào đầu danh sách.
    if ($selected_id) {
        $ids_in_list = wp_list_pluck($posts, 'ID');
        if (!in_array($selected_id, $ids_in_list, true)) {
            $extra = get_post($selected_id);
            if ($extra && $extra->post_status === 'publish') {
                $posts = array_merge(array($extra), $posts);
            }
        }
    }

    echo '<select name="' . esc_attr($option_name) . '" id="' . esc_attr($option_name) . '" style="min-width:380px;max-width:100%">';
    echo '<option value="0">' . esc_html__('— Auto (latest post) —', 'blogar') . '</option>';

    $current_year = '';
    foreach ($posts as $post) {
        $year = get_the_date('Y', $post->ID);
        if ($year !== $current_year) {
            if ($current_year !== '') {
                echo '</optgroup>';
            }
            echo '<optgroup label="' . esc_attr($year) . '">';
            $current_year = $year;
        }
        $label = esc_html($post->post_title) . ' (' . esc_html(get_the_date('d/m', $post->ID)) . ')';
        echo '<option value="' . esc_attr($post->ID) . '" ' . selected($selected_id, $post->ID, false) . '>'
            . $label . '</option>';
    }
    if ($current_year !== '') {
        echo '</optgroup>';
    }

    echo '</select>';

    if ($description) {
        echo '<p class="description">' . esc_html($description) . '</p>';
    }

    if ($selected_id && has_post_thumbnail($selected_id)) {
        echo '<div style="margin-top:8px">';
        echo get_the_post_thumbnail($selected_id, array(120, 60), array('style' => 'border-radius:4px;object-fit:cover'));
        echo '</div>';
    }
}

/**
 * Multi-select categories field.
 */
function blogar_categories_multiselect_field($args)
{
    $option_name = $args['option_name'];
    $selected_ids = get_option($option_name, array());
    $selected_ids = is_array($selected_ids) ? array_map('absint', $selected_ids) : array();
    $description = isset($args['description']) ? $args['description'] : '';

    $categories = blogar_get_all_categories_cached();

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

/**
 * Sanitize array of term IDs.
 */
function blogar_sanitize_term_ids($value)
{
    if (!is_array($value)) {
        return array();
    }
    return array_values(array_unique(array_filter(array_map('absint', $value))));
}


// ================================================================
// CATEGORY THUMBNAIL FIELDS
// ================================================================

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

function blogar_category_add_thumbnail_field()
{
    ?>
<div class="form-field term-group blogar-category-thumbnail-wrap">
    <label for="blogar-category-image-id"><?php esc_html_e('Thumbnail', 'blogar'); ?></label>
    <input type="hidden" id="blogar-category-image-id" name="blogar_category_image_id" value="">
    <div class="blogar-category-thumbnail-preview" style="margin-bottom:12px"></div>
    <button type="button"
        class="button blogar-category-image-upload"><?php esc_html_e('Upload image', 'blogar'); ?></button>
    <button type="button" class="button blogar-category-image-remove"
        style="display:none"><?php esc_html_e('Remove image', 'blogar'); ?></button>
    <p class="description"><?php esc_html_e('Used for the Trending Topics carousel in Section 5.', 'blogar'); ?></p>
</div>
<?php
}
add_action('category_add_form_fields', 'blogar_category_add_thumbnail_field');

function blogar_category_edit_thumbnail_field($term)
{
    $image_id = (int) get_term_meta($term->term_id, 'blogar_category_image_id', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
    ?>
<tr class="form-field term-group-wrap blogar-category-thumbnail-wrap">
    <th scope="row"><label for="blogar-category-image-id"><?php esc_html_e('Thumbnail', 'blogar'); ?></label></th>
    <td>
        <input type="hidden" id="blogar-category-image-id" name="blogar_category_image_id"
            value="<?php echo esc_attr($image_id); ?>">
        <div class="blogar-category-thumbnail-preview" style="margin-bottom:12px">
            <?php if ($image_url): ?>
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term->name); ?>"
                style="display:block;width:120px;height:120px;object-fit:cover;border-radius:8px">
            <?php endif; ?>
        </div>
        <button type="button"
            class="button blogar-category-image-upload"><?php esc_html_e($image_id ? 'Change image' : 'Upload image', 'blogar'); ?></button>
        <button type="button" class="button blogar-category-image-remove"
            style="<?php echo $image_id ? '' : 'display:none'; ?>"><?php esc_html_e('Remove image', 'blogar'); ?></button>
        <p class="description"><?php esc_html_e('Used for the Trending Topics carousel in Section 5.', 'blogar'); ?>
        </p>
    </td>
</tr>
<?php
}
add_action('category_edit_form_fields', 'blogar_category_edit_thumbnail_field');

function blogar_save_category_thumbnail_field($term_id)
{
    if (!isset($_POST['blogar_category_image_id'])) {
        return;
    }
    $image_id = absint(wp_unslash($_POST['blogar_category_image_id']));
    if ($image_id) {
        update_term_meta($term_id, 'blogar_category_image_id', $image_id);
    } else {
        delete_term_meta($term_id, 'blogar_category_image_id');
    }
}
add_action('created_category', 'blogar_save_category_thumbnail_field');
add_action('edited_category', 'blogar_save_category_thumbnail_field');

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
    if (!wrappers.length || typeof wp === "undefined" || !wp.media) return;
    wrappers.forEach(function(wrapper) {
        var input = wrapper.querySelector("#blogar-category-image-id");
        var preview = wrapper.querySelector(".blogar-category-thumbnail-preview");
        var uploadBtn = wrapper.querySelector(".blogar-category-image-upload");
        var removeBtn = wrapper.querySelector(".blogar-category-image-remove");
        if (!input || !preview || !uploadBtn || !removeBtn) return;
        var frame;

        function renderPreview(attachment) {
            if (!attachment) {
                preview.innerHTML = "";
                removeBtn.style.display = "none";
                return;
            }
            preview.innerHTML = '<img src="' + attachment.url +
                '" alt="" style="display:block;width:120px;height:120px;object-fit:cover;border-radius:8px">';
            removeBtn.style.display = "";
        }
        uploadBtn.addEventListener("click", function(e) {
            e.preventDefault();
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
        removeBtn.addEventListener("click", function(e) {
            e.preventDefault();
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

    // Tab order matches homepage top-to-bottom section order (1 → 7)
    $tabs = array(
        's11_news_highlight' => array(
            'label' => __('① News Highlight', 'blogar'),
            'settings_group' => 'blogar_s11_settings',
            'page_slug' => 'blogar-s11',
        ),
        's5_topics' => array(
            'label' => __('② Trending Topics', 'blogar'),
            'settings_group' => 'blogar_s5_settings',
            'page_slug' => 'blogar-s5',
        ),
        's13_grid_2plus3' => array(
            'label' => __('③ Featured Grid 2+3', 'blogar'),
            'settings_group' => 'blogar_s13_settings',
            'page_slug' => 'blogar-s13',
        ),
        's14_latest_posts' => array(
            'label' => __('④ Latest Posts', 'blogar'),
            'settings_group' => 'blogar_s14_settings',
            'page_slug' => 'blogar-s14',
        ),
        's12_featured_grid' => array(
            'label' => __('⑤ Featured Grid', 'blogar'),
            'settings_group' => 'blogar_s12_settings',
            'page_slug' => 'blogar-s12',
        ),
        's4_innovation' => array(
            'label' => __('⑥ Innovation & Tech', 'blogar'),
            'settings_group' => 'blogar_s4_settings',
            'page_slug' => 'blogar-s4',
        ),
        's10_featured_video' => array(
            'label' => __('⑦ Featured Video', 'blogar'),
            'settings_group' => 'blogar_s10_settings',
            'page_slug' => 'blogar-s10',
        ),
        'layouts' => array(
            'label' => __('⊞ Layout', 'blogar'),
            'custom_render' => 'blogar_render_layout_tab',
        ),
    );

    $default_tab = 's11_news_highlight';
    $active_tab = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : $default_tab;

    if (!isset($tabs[$active_tab])) {
        $active_tab = $default_tab;
    }
    ?>
<div class="wrap">
    <h1><?php esc_html_e('Blogar Settings — Homepage', 'blogar'); ?></h1>
    <p class="description" style="font-size:14px;margin-bottom:20px">
        <?php esc_html_e('Configure content for each homepage section. Tabs are ordered top-to-bottom matching the page layout.', 'blogar'); ?>
    </p>

    <?php settings_errors('blogar_settings_notices'); ?>

    <nav class="nav-tab-wrapper" style="margin-bottom:0">
        <?php foreach ($tabs as $tab_key => $tab_config): ?>
        <a href="<?php echo esc_url(add_query_arg(array('page' => 'blogar-settings', 'tab' => $tab_key), admin_url('themes.php'))); ?>"
            class="nav-tab <?php echo ($active_tab === $tab_key) ? 'nav-tab-active' : ''; ?>">
            <?php echo esc_html($tab_config['label']); ?>
        </a>
        <?php endforeach; ?>
    </nav>

    <div
        style="background:#fff;border:1px solid #c3c4c7;border-top:none;padding:20px 24px 8px;border-radius:0 0 4px 4px">
        <?php if (!empty($tabs[$active_tab]['custom_render'])): ?>
            <?php call_user_func($tabs[$active_tab]['custom_render']); ?>
        <?php else: ?>
        <form method="post" action="options.php">
            <?php
                if (isset($tabs[$active_tab])) {
                    settings_fields($tabs[$active_tab]['settings_group']);
                    do_settings_sections($tabs[$active_tab]['page_slug']);
                }
                submit_button(__('Save Settings', 'blogar'));
                ?>
        </form>
        <?php endif; ?>
    </div>
</div>
<?php
}


// ================================================================
// ARCHIVE LAYOUT SETTING
// ================================================================

add_action('admin_init', 'blogar_register_archive_layout_setting');

function blogar_register_archive_layout_setting()
{
    register_setting('blogar_archive_options_group', 'blogar_archive_layout', array(
        'type' => 'string',
        'sanitize_callback' => 'blogar_sanitize_layout_option',
        'default' => 'sidebar',
    ));
}

function blogar_sanitize_layout_option($value)
{
    return in_array($value, array('sidebar', 'full'), true) ? $value : 'sidebar';
}

function blogar_archive_layout_section_cb()
{
    echo '<p style="color:#666;margin-top:0;">' . esc_html__('Choose how Archive / Category pages display posts.', 'blogar') . '</p>';
}

function blogar_archive_layout_field_cb()
{
    $current = get_option('blogar_archive_layout', 'sidebar');
    $options = array(
        'sidebar' => array(
            'label' => __('With Sidebar', 'blogar'),
            'desc' => __('Post list (col-8) + sticky sidebar (col-4) with Popular Posts, Categories, Newsletter.', 'blogar'),
        ),
        'full' => array(
            'label' => __('Full Width — No Sidebar', 'blogar'),
            'desc' => __('Responsive card grid using the full container width. 3 posts per row on desktop.', 'blogar'),
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
    <label for="blogar_archive_layout_<?php echo esc_attr($value); ?>"
        style="display:flex;flex-direction:column;gap:8px;padding:16px 20px;border:<?php echo $border; ?>;border-radius:8px;background:<?php echo $bg; ?>;cursor:pointer;min-width:220px;max-width:280px;">
        <div style="display:flex;align-items:center;gap:10px;">
            <input type="radio" id="blogar_archive_layout_<?php echo esc_attr($value); ?>" name="blogar_archive_layout"
                value="<?php echo esc_attr($value); ?>" <?php echo $checked; ?>>
            <strong style="font-size:14px;"><?php echo esc_html($opt['label']); ?></strong>
        </div>
        <div style="height:56px;background:#f5f5f5;border-radius:4px;overflow:hidden;display:flex;gap:4px;padding:6px;">
            <?php if ($value === 'sidebar'): ?>
            <div style="flex:2;background:#c0c8f8;border-radius:3px;"></div>
            <div style="flex:1;background:#dde3fb;border-radius:3px;"></div>
            <?php else: ?>
            <div style="flex:1;background:#c0c8f8;border-radius:3px;"></div>
            <div style="flex:1;background:#c0c8f8;border-radius:3px;"></div>
            <?php endif; ?>
        </div>
        <p style="margin:0;font-size:12px;color:#666;line-height:1.5;"><?php echo esc_html($opt['desc']); ?></p>
    </label>
    <?php endforeach; ?>
</div>
<script>
(function() {
    document.querySelectorAll('[name="blogar_archive_layout"]').forEach(function(r) {
        r.addEventListener('change', function() {
            document.querySelectorAll('[name="blogar_archive_layout"]').forEach(function(x) {
                var l = x.closest('label');
                l.style.borderColor = '#ddd';
                l.style.background = '#fff';
            });
            var a = document.querySelector('[name="blogar_archive_layout"]:checked');
            if (a) {
                var l = a.closest('label');
                l.style.borderColor = '#3858f6';
                l.style.background = '#f0f4ff';
            }
        });
    });
})();
</script>
<?php
}

function blogar_render_layout_tab()
{
    ?>
<div style="display:grid;gap:0;">

    <form method="post" action="options.php">
        <?php settings_fields('blogar_archive_options_group'); ?>
        <h2 style="font-size:16px;margin:0 0 4px;"><?php esc_html_e('Archive Page Layout', 'blogar'); ?></h2>
        <?php blogar_archive_layout_section_cb(); ?>
        <?php blogar_archive_layout_field_cb(); ?>
        <?php submit_button(__('Save Archive Layout', 'blogar')); ?>
    </form>

    <div style="border-top:1px solid #e5e5e5;padding-top:24px;margin-top:8px;">
        <form method="post" action="options.php">
            <?php settings_fields('blogar_single_options_group'); ?>
            <h2 style="font-size:16px;margin:0 0 4px;"><?php esc_html_e('Single Post Layout', 'blogar'); ?></h2>
            <?php blogar_single_layout_section_cb(); ?>
            <?php blogar_single_layout_field_cb(); ?>
            <?php submit_button(__('Save Single Layout', 'blogar')); ?>
        </form>
    </div>

</div>
<?php
}


// ================================================================
// SINGLE PAGE LAYOUT SETTING
// ================================================================

add_action('admin_init', 'blogar_register_single_layout_setting');

function blogar_register_single_layout_setting()
{
    register_setting('blogar_single_options_group', 'blogar_single_layout', array(
        'type' => 'string',
        'sanitize_callback' => 'blogar_sanitize_layout_option',
        'default' => 'sidebar',
    ));
}

function blogar_single_layout_section_cb()
{
    echo '<p style="color:#666;margin-top:0;">' . esc_html__('Choose how single post pages display the main article content.', 'blogar') . '</p>';
}

function blogar_single_layout_field_cb()
{
    $current = get_option('blogar_single_layout', 'sidebar');
    $options = array(
        'sidebar' => array(
            'label' => __('With Sidebar', 'blogar'),
            'desc' => __('Main content with sticky sidebar widgets on the right.', 'blogar'),
        ),
        'full' => array(
            'label' => __('No Sidebar', 'blogar'),
            'desc' => __('Centered reading layout. Post content becomes wider on all screen sizes.', 'blogar'),
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
    <label for="blogar_single_layout_<?php echo esc_attr($value); ?>"
        style="display:flex;flex-direction:column;gap:8px;padding:16px 20px;border:<?php echo $border; ?>;border-radius:8px;background:<?php echo $bg; ?>;cursor:pointer;min-width:220px;max-width:320px;">
        <div style="display:flex;align-items:center;gap:10px;">
            <input type="radio" id="blogar_single_layout_<?php echo esc_attr($value); ?>" name="blogar_single_layout"
                value="<?php echo esc_attr($value); ?>" <?php echo $checked; ?>>
            <strong style="font-size:14px;"><?php echo esc_html($opt['label']); ?></strong>
        </div>
        <div style="height:56px;background:#f5f5f5;border-radius:4px;overflow:hidden;display:flex;gap:4px;padding:6px;">
            <?php if ($value === 'sidebar'): ?>
            <div style="flex:2;background:#c0c8f8;border-radius:3px;"></div>
            <div style="flex:1;background:#dde3fb;border-radius:3px;"></div>
            <?php else: ?>
            <div style="flex:1;background:#c0c8f8;border-radius:3px;"></div>
            <?php endif; ?>
        </div>
        <p style="margin:0;font-size:12px;color:#666;line-height:1.5;"><?php echo esc_html($opt['desc']); ?></p>
    </label>
    <?php endforeach; ?>
</div>
<script>
(function() {
    document.querySelectorAll('[name="blogar_single_layout"]').forEach(function(r) {
        r.addEventListener('change', function() {
            document.querySelectorAll('[name="blogar_single_layout"]').forEach(function(x) {
                var l = x.closest('label');
                l.style.borderColor = '#ddd';
                l.style.background = '#fff';
            });
            var a = document.querySelector('[name="blogar_single_layout"]:checked');
            if (a) {
                var l = a.closest('label');
                l.style.borderColor = '#3858f6';
                l.style.background = '#f0f4ff';
            }
        });
    });
})();
</script>
<?php
}

