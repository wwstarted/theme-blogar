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
    register_setting('blogar_s4_settings', 'blogar_s4_enabled',   array('sanitize_callback' => 'absint', 'default' => 1));
    register_setting('blogar_s4_settings', 'blogar_s4_title',     array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('blogar_s4_settings', 'blogar_s4_subtitle',  array('sanitize_callback' => 'sanitize_textarea_field'));
    register_setting('blogar_s4_settings', 'blogar_s4_post_count', array('sanitize_callback' => 'absint'));
    register_setting('blogar_s4_settings', 'blogar_s4_tab_count', array('sanitize_callback' => 'absint'));

    for ($i = 1; $i <= 6; $i++) {
        register_setting('blogar_s4_settings', "blogar_s4_tab_{$i}_label",       array('sanitize_callback' => 'sanitize_text_field'));
        register_setting('blogar_s4_settings', "blogar_s4_tab_{$i}_render_type", array('sanitize_callback' => 'sanitize_text_field'));
        register_setting('blogar_s4_settings', "blogar_s4_tab_{$i}_cat",         array('sanitize_callback' => 'absint'));
        register_setting('blogar_s4_settings', "blogar_s4_tab_{$i}_post_ids",    array('sanitize_callback' => 'sanitize_text_field'));
    }

    add_settings_section('blogar_s4_section', __('Innovation & Tech', 'blogar'), 'blogar_s4_section_cb', 'blogar-s4');

    add_settings_field('blogar_s4_enabled', __('Display section', 'blogar'), 'blogar_section_toggle_field_cb', 'blogar-s4', 'blogar_s4_section', array('option_name' => 'blogar_s4_enabled'));

    add_settings_field('blogar_s4_title', __('Tiêu đề section', 'blogar'), 'blogar_text_field_cb', 'blogar-s4', 'blogar_s4_section', array(
        'option_name' => 'blogar_s4_title',
        'default'     => 'Innovation & Tech',
        'placeholder' => 'Innovation & Tech',
    ));

    add_settings_field('blogar_s4_subtitle', __('Mô tả section', 'blogar'), 'blogar_textarea_field_cb', 'blogar-s4', 'blogar_s4_section', array(
        'option_name' => 'blogar_s4_subtitle',
        'placeholder' => __('Explore the latest innovations and ideas shaping the world.', 'blogar'),
    ));

    add_settings_field('blogar_s4_post_count', __('Số bài mỗi tab', 'blogar'), 'blogar_number_field_cb', 'blogar-s4', 'blogar_s4_section', array(
        'option_name' => 'blogar_s4_post_count',
        'default'     => 4,
        'min'         => 1,
        'max'         => 12,
        'description' => __('Số bài viết hiển thị trong mỗi tab carousel (1–12)', 'blogar'),
    ));

    add_settings_field('blogar_s4_tab_count', __('Số lượng tab', 'blogar'), 'blogar_number_field_cb', 'blogar-s4', 'blogar_s4_section', array(
        'option_name' => 'blogar_s4_tab_count',
        'default'     => 3,
        'min'         => 1,
        'max'         => 6,
        'description' => __('Số tab hiển thị (1–6). Chỉ những tab có tên sẽ được render.', 'blogar'),
    ));

    for ($i = 1; $i <= 6; $i++) {
        add_settings_field("blogar_s4_tab_{$i}", sprintf(__('Tab %d', 'blogar'), $i), 'blogar_tab_field_cb', 'blogar-s4', 'blogar_s4_section', array(
            'index'           => $i,
            'label_key'       => "blogar_s4_tab_{$i}_label",
            'render_type_key' => "blogar_s4_tab_{$i}_render_type",
            'cat_key'         => "blogar_s4_tab_{$i}_cat",
            'post_ids_key'    => "blogar_s4_tab_{$i}_post_ids",
            'description'     => $i === 1 ? __('Tab đầu tiên — mặc định được chọn khi vào trang', 'blogar') : '',
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
    echo '<p class="description">' . esc_html__('Title, subtitle, post count and up to 6 configurable tabs. Each tab can pull posts by category or by specific post IDs.', 'blogar') . '</p>';
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
    <input type="checkbox" id="<?php echo esc_attr($option); ?>" name="<?php echo esc_attr($option); ?>" value="1"
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
 * Tab field: label + render type (category | posts) + category dropdown + post IDs.
 */
function blogar_tab_field_cb($args)
{
    static $js_printed = false;

    $label_key       = $args['label_key'];
    $render_type_key = isset($args['render_type_key']) ? $args['render_type_key'] : '';
    $cat_key         = $args['cat_key'];
    $post_ids_key    = isset($args['post_ids_key']) ? $args['post_ids_key'] : '';
    $description     = isset($args['description']) ? $args['description'] : '';

    $label_val       = get_option($label_key, '');
    $render_type_val = $render_type_key ? get_option($render_type_key, 'category') : 'category';
    $cat_val         = (int) get_option($cat_key, 0);
    $post_ids_val    = $post_ids_key ? get_option($post_ids_key, '') : '';

    // uid: derive from label_key (e.g. blogar_s4_tab_1_label → s4tab1)
    $uid = 'blogar-tab-' . esc_attr($label_key);

    // Output toggle JS once
    if (!$js_printed) {
        $js_printed = true;
        echo '<script>function blogarTabToggle(uid,val){'
            . 'var c=document.getElementById(uid+"-cat");var p=document.getElementById(uid+"-ids");'
            . 'if(c)c.style.display=val==="posts"?"none":"";'
            . 'if(p)p.style.display=val==="posts"?"":"none";'
            . '}</script>';
    }

    echo '<div style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-start">';

    // Tab label
    printf(
        '<div><label style="display:block;margin-bottom:4px;font-weight:500">%s</label>'
        . '<input type="text" id="%s" name="%s" value="%s" placeholder="%s" style="width:180px" /></div>',
        esc_html__('Tên tab', 'blogar'),
        esc_attr($label_key),
        esc_attr($label_key),
        esc_attr($label_val),
        esc_attr__('VD: Best VPN', 'blogar')
    );

    // Render type radio
    if ($render_type_key) {
        $uid_js = esc_js($uid);
        echo '<div><span style="display:block;margin-bottom:6px;font-weight:500">' . esc_html__('Render theo', 'blogar') . '</span>';
        echo '<label style="margin-right:14px">'
            . '<input type="radio" name="' . esc_attr($render_type_key) . '" value="category"'
            . checked($render_type_val, 'category', false)
            . ' onchange="blogarTabToggle(\'' . $uid_js . '\',this.value)"> '
            . esc_html__('Category', 'blogar') . '</label>';
        echo '<label>'
            . '<input type="radio" name="' . esc_attr($render_type_key) . '" value="posts"'
            . checked($render_type_val, 'posts', false)
            . ' onchange="blogarTabToggle(\'' . $uid_js . '\',this.value)"> '
            . esc_html__('Selected Posts', 'blogar') . '</label>';
        echo '</div>';
    }

    // Category dropdown
    $cat_style = ($render_type_val === 'posts') ? 'display:none' : '';
    echo '<div id="' . esc_attr($uid) . '-cat" style="' . esc_attr($cat_style) . '">';
    printf(
        '<label for="%s" style="display:block;margin-bottom:4px;font-weight:500">%s</label>',
        esc_attr($cat_key),
        esc_html__('Category', 'blogar')
    );
    $categories = blogar_get_all_categories_cached();
    echo '<select id="' . esc_attr($cat_key) . '" name="' . esc_attr($cat_key) . '" style="min-width:200px">';
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
    echo '</select></div>';

    // Post IDs input
    if ($post_ids_key) {
        $ids_style = ($render_type_val !== 'posts') ? 'display:none' : '';
        printf(
            '<div id="%s-ids" style="%s">'
            . '<label style="display:block;margin-bottom:4px;font-weight:500">%s</label>'
            . '<input type="text" name="%s" value="%s" placeholder="%s" style="width:260px" />'
            . '<p class="description" style="margin-top:4px">%s</p></div>',
            esc_attr($uid),
            esc_attr($ids_style),
            esc_html__('Post IDs', 'blogar'),
            esc_attr($post_ids_key),
            esc_attr($post_ids_val),
            '12,34,56',
            esc_html__('Nhập ID bài viết cách nhau bởi dấu phẩy.', 'blogar')
        );
    }

    echo '</div>';

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
        'order' => array(
            'label'         => __('⟺ Sắp xếp', 'blogar'),
            'custom_render' => 'blogar_render_order_tab',
        ),
        'footer' => array(
            'label'          => __('⊟ Footer', 'blogar'),
            'settings_group' => 'blogar_footer_settings',
            'page_slug'      => 'blogar-footer',
        ),
        'sidebar' => array(
            'label'         => __('⋮ Sidebar', 'blogar'),
            'custom_render' => 'blogar_render_sidebar_tab',
        ),
        '404_page' => array(
            'label'         => __('⚠ 404 Page', 'blogar'),
            'custom_render' => 'blogar_render_404_tab',
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
// HOME PAGE LAYOUT SETTING
// ================================================================

add_action('admin_init', 'blogar_register_home_layout_setting');

function blogar_register_home_layout_setting()
{
    register_setting('blogar_home_options_group', 'blogar_home_layout', array(
        'type'              => 'string',
        'sanitize_callback' => 'blogar_sanitize_layout_option',
        'default'           => 'sidebar',
    ));
}

function blogar_home_layout_section_cb()
{
    echo '<p style="color:#666;margin-top:0;">' . esc_html__('Choose how the Blog / Posts page displays all articles.', 'blogar') . '</p>';
}

function blogar_home_layout_field_cb()
{
    $current = get_option('blogar_home_layout', 'sidebar');
    $options = array(
        'sidebar' => array(
            'label' => __('With Sidebar', 'blogar'),
            'desc'  => __('Post list (col-8) + sticky sidebar (col-4) with Popular Posts, Categories, Newsletter.', 'blogar'),
        ),
        'full'    => array(
            'label' => __('Full Width — No Sidebar', 'blogar'),
            'desc'  => __('Responsive 3-column card grid using the full container width.', 'blogar'),
        ),
    );
    ?>
<div style="display:flex;gap:24px;flex-wrap:wrap;">
    <?php foreach ($options as $value => $opt):
        $checked   = checked($current, $value, false);
        $is_active = ($current === $value);
        $border    = $is_active ? '2px solid #3858f6' : '2px solid #ddd';
        $bg        = $is_active ? '#f0f4ff' : '#fff';
        ?>
    <label for="blogar_home_layout_<?php echo esc_attr($value); ?>"
        style="display:flex;flex-direction:column;gap:8px;padding:16px 20px;border:<?php echo $border; ?>;border-radius:8px;background:<?php echo $bg; ?>;cursor:pointer;min-width:220px;max-width:280px;">
        <div style="display:flex;align-items:center;gap:10px;">
            <input type="radio" id="blogar_home_layout_<?php echo esc_attr($value); ?>" name="blogar_home_layout"
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
            <div style="flex:1;background:#c0c8f8;border-radius:3px;"></div>
            <?php endif; ?>
        </div>
        <p style="margin:0;font-size:12px;color:#666;line-height:1.5;"><?php echo esc_html($opt['desc']); ?></p>
    </label>
    <?php endforeach; ?>
</div>
<script>
(function() {
    document.querySelectorAll('[name="blogar_home_layout"]').forEach(function(r) {
        r.addEventListener('change', function() {
            document.querySelectorAll('[name="blogar_home_layout"]').forEach(function(x) {
                var l = x.closest('label');
                l.style.borderColor = '#ddd';
                l.style.background = '#fff';
            });
            var a = document.querySelector('[name="blogar_home_layout"]:checked');
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
        <?php settings_fields('blogar_home_options_group'); ?>
        <h2 style="font-size:16px;margin:0 0 4px;"><?php esc_html_e('Home / Blog Page Layout', 'blogar'); ?></h2>
        <?php blogar_home_layout_section_cb(); ?>
        <?php blogar_home_layout_field_cb(); ?>
        <?php submit_button(__('Save Home Layout', 'blogar')); ?>
    </form>

    <div style="border-top:1px solid #e5e5e5;padding-top:24px;margin-top:8px;">
        <form method="post" action="options.php">
            <?php settings_fields('blogar_archive_options_group'); ?>
            <h2 style="font-size:16px;margin:0 0 4px;"><?php esc_html_e('Archive Page Layout', 'blogar'); ?></h2>
            <?php blogar_archive_layout_section_cb(); ?>
            <?php blogar_archive_layout_field_cb(); ?>
            <?php submit_button(__('Save Archive Layout', 'blogar')); ?>
        </form>
    </div>

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


// ================================================================
// SECTION ORDER SETTING
// ================================================================

add_action('admin_init', 'blogar_register_section_order_setting');

function blogar_register_section_order_setting()
{
    register_setting('blogar_section_order_group', 'blogar_section_order', array(
        'sanitize_callback' => 'blogar_sanitize_section_order',
    ));
}

function blogar_sanitize_section_order($value)
{
    $allowed = array('s11', 's5', 's13', 's14', 's12', 's4', 's10');
    $order   = json_decode($value, true);
    if (!is_array($order)) {
        return '';
    }
    $filtered = array_values(array_intersect($order, $allowed));
    foreach ($allowed as $k) {
        if (!in_array($k, $filtered, true)) {
            $filtered[] = $k;
        }
    }
    return wp_json_encode($filtered);
}

function blogar_render_order_tab()
{
    $sections_meta = array(
        's11' => array('label' => __('① News Highlight',    'blogar'), 'desc' => __('Ticker headlines + featured grid block', 'blogar')),
        's5'  => array('label' => __('② Trending Topics',   'blogar'), 'desc' => __('Category carousel with thumbnails', 'blogar')),
        's13' => array('label' => __('③ Featured Grid 2+3', 'blogar'), 'desc' => __('Dark section: 2 top posts + 3 bottom posts', 'blogar')),
        's14' => array('label' => __('④ Latest Posts',      'blogar'), 'desc' => __('Uniform card grid, configurable count', 'blogar')),
        's12' => array('label' => __('⑤ Featured Grid',     'blogar'), 'desc' => __('Asymmetric big + small post grid', 'blogar')),
        's4'  => array('label' => __('⑥ Innovation & Tech', 'blogar'), 'desc' => __('Tab carousel with category filters', 'blogar')),
        's10' => array('label' => __('⑦ Featured Video',    'blogar'), 'desc' => __('Video posts with thumbnail gallery', 'blogar')),
    );

    $default_order = array('s11', 's5', 's13', 's14', 's12', 's4', 's10');
    $raw           = get_option('blogar_section_order', '');
    $current_order = (!empty($raw)) ? (array) json_decode($raw, true) : array();
    if (count($current_order) < 7) {
        $current_order = $default_order;
    }
    $current_order = array_values(array_filter($current_order, function ($k) use ($sections_meta) {
        return isset($sections_meta[$k]);
    }));
    foreach ($default_order as $k) {
        if (!in_array($k, $current_order, true)) {
            $current_order[] = $k;
        }
    }
    ?>
<form method="post" action="options.php" style="max-width:580px">
    <?php settings_fields('blogar_section_order_group'); ?>

    <p style="color:#555;margin:0 0 18px;font-size:13px;line-height:1.6">
        <?php esc_html_e('Kéo thả để sắp xếp thứ tự hiển thị các section trên trang chủ. Nhấn Save để áp dụng.', 'blogar'); ?>
    </p>

    <input type="hidden" name="blogar_section_order" id="blogar_sorder_input"
        value="<?php echo esc_attr(wp_json_encode($current_order)); ?>">

    <ul id="blogar-sorter" style="margin:0;padding:0;list-style:none;display:flex;flex-direction:column;gap:6px">
        <?php foreach ($current_order as $key):
            if (!isset($sections_meta[$key])) continue;
            $meta    = $sections_meta[$key];
            $enabled = (bool) get_option('blogar_' . $key . '_enabled', 1);
        ?>
        <li data-key="<?php echo esc_attr($key); ?>" draggable="true"
            style="display:flex;align-items:center;gap:14px;padding:13px 16px;background:#fff;border:1.5px solid #ddd;border-radius:6px;cursor:grab;user-select:none;transition:box-shadow 0.15s,border-color 0.15s">
            <span class="sorter-handle" style="font-size:18px;color:#bbb;line-height:1;flex-shrink:0"
                title="<?php esc_attr_e('Drag to reorder', 'blogar'); ?>">⠿</span>
            <span class="sorter-pos"
                style="font-size:12px;font-weight:700;color:#999;width:22px;flex-shrink:0;text-align:center"></span>
            <div style="flex:1;min-width:0">
                <strong
                    style="font-size:13px;display:block;color:#1e1e1e"><?php echo esc_html($meta['label']); ?></strong>
                <span style="font-size:12px;color:#888"><?php echo esc_html($meta['desc']); ?></span>
            </div>
            <?php if (!$enabled): ?>
            <span
                style="font-size:11px;color:#999;background:#f5f5f5;border:1px solid #ddd;padding:2px 8px;border-radius:3px;flex-shrink:0">
                <?php esc_html_e('Ẩn', 'blogar'); ?>
            </span>
            <?php else: ?>
            <span
                style="font-size:11px;color:#0a7d3e;background:#ecfdf5;border:1px solid #a7f3d0;padding:2px 8px;border-radius:3px;flex-shrink:0">
                <?php esc_html_e('Hiện', 'blogar'); ?>
            </span>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>

    <div style="margin-top:20px;display:flex;align-items:center;gap:10px;flex-wrap:wrap">
        <?php submit_button(__('Lưu thứ tự', 'blogar'), 'primary', 'submit', false); ?>
        <button type="button" id="blogar-reset-order" class="button button-secondary">
            <?php esc_html_e('Reset về mặc định', 'blogar'); ?>
        </button>
    </div>
</form>

<script>
(function() {
    var list = document.getElementById('blogar-sorter');
    var input = document.getElementById('blogar_sorder_input');
    var resetBtn = document.getElementById('blogar-reset-order');
    if (!list || !input) return;

    var defaultOrder = <?php echo wp_json_encode($default_order); ?>;
    var dragging = null;

    function updatePositions() {
        list.querySelectorAll('li').forEach(function(li, i) {
            var pos = li.querySelector('.sorter-pos');
            if (pos) pos.textContent = '#' + (i + 1);
        });
    }

    function updateInput() {
        var keys = [];
        list.querySelectorAll('li').forEach(function(li) {
            keys.push(li.dataset.key);
        });
        input.value = JSON.stringify(keys);
        updatePositions();
    }

    list.addEventListener('dragstart', function(e) {
        dragging = e.target.closest('li');
        if (!dragging) return;
        setTimeout(function() {
            dragging.style.opacity = '0.4';
        }, 0);
        e.dataTransfer.effectAllowed = 'move';
    });

    list.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        var target = e.target.closest('li');
        if (!target || target === dragging) return;
        list.querySelectorAll('li').forEach(function(li) {
            li.style.boxShadow = '';
            li.style.borderColor = '#ddd';
        });
        var rect = target.getBoundingClientRect();
        var isAbove = e.clientY < rect.top + rect.height / 2;
        target.style.boxShadow = isAbove ? 'inset 0 3px 0 0 #2271b1' : 'inset 0 -3px 0 0 #2271b1';
        target.style.borderColor = '#2271b1';
    });

    list.addEventListener('drop', function(e) {
        e.preventDefault();
        var target = e.target.closest('li');
        list.querySelectorAll('li').forEach(function(li) {
            li.style.boxShadow = '';
            li.style.borderColor = '#ddd';
        });
        if (!target || !dragging || target === dragging) return;
        var rect = target.getBoundingClientRect();
        if (e.clientY < rect.top + rect.height / 2) {
            list.insertBefore(dragging, target);
        } else {
            list.insertBefore(dragging, target.nextSibling);
        }
        updateInput();
    });

    list.addEventListener('dragend', function() {
        list.querySelectorAll('li').forEach(function(li) {
            li.style.opacity = '';
            li.style.boxShadow = '';
            li.style.borderColor = '#ddd';
        });
        dragging = null;
        updateInput();
    });

    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            var items = {};
            list.querySelectorAll('li').forEach(function(li) {
                items[li.dataset.key] = li;
            });
            defaultOrder.forEach(function(key) {
                if (items[key]) list.appendChild(items[key]);
            });
            updateInput();
        });
    }

    updatePositions();
})();
</script>
<?php
}


// ================================================================
// FOOTER SETTINGS
// ================================================================

add_action('admin_init', 'blogar_register_footer_settings');

function blogar_register_footer_settings()
{
    // ── Colors ───────────────────────────────────────────────────
    register_setting('blogar_footer_settings', 'blogar_footer_bg_color',   array('sanitize_callback' => 'sanitize_hex_color', 'default' => '#0f1c1e'));
    register_setting('blogar_footer_settings', 'blogar_footer_text_color', array('sanitize_callback' => 'sanitize_hex_color', 'default' => '#a8bfc2'));

    add_settings_section('blogar_footer_colors', __('Màu nền & chữ', 'blogar'), 'blogar_footer_colors_cb', 'blogar-footer');
    add_settings_field('blogar_footer_bg_color',   __('Màu nền footer', 'blogar'),  'blogar_color_field_cb', 'blogar-footer', 'blogar_footer_colors', array('option_name' => 'blogar_footer_bg_color',   'default' => '#0f1c1e'));
    add_settings_field('blogar_footer_text_color', __('Màu chữ footer', 'blogar'), 'blogar_color_field_cb', 'blogar-footer', 'blogar_footer_colors', array('option_name' => 'blogar_footer_text_color', 'default' => '#a8bfc2'));

    // ── Col 1: Brand ─────────────────────────────────────────────
    register_setting('blogar_footer_settings', 'blogar_footer_desc',    array('sanitize_callback' => 'sanitize_textarea_field'));
    register_setting('blogar_footer_settings', 'blogar_footer_phone',   array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('blogar_footer_settings', 'blogar_footer_email',   array('sanitize_callback' => 'sanitize_email'));
    register_setting('blogar_footer_settings', 'blogar_footer_address', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_section('blogar_footer_brand', __('Cột 1 — Thông tin thương hiệu', 'blogar'), 'blogar_footer_brand_cb', 'blogar-footer');
    add_settings_field('blogar_footer_desc',    __('Mô tả / Tagline', 'blogar'),  'blogar_textarea_field_cb', 'blogar-footer', 'blogar_footer_brand', array('option_name' => 'blogar_footer_desc',    'placeholder' => 'Brief description of your site...'));
    add_settings_field('blogar_footer_phone',   __('Số điện thoại', 'blogar'),    'blogar_text_field_cb',     'blogar-footer', 'blogar_footer_brand', array('option_name' => 'blogar_footer_phone',   'placeholder' => '+84 123 456 789'));
    add_settings_field('blogar_footer_email',   __('Email liên hệ', 'blogar'),    'blogar_text_field_cb',     'blogar-footer', 'blogar_footer_brand', array('option_name' => 'blogar_footer_email',   'placeholder' => 'hello@example.com'));
    add_settings_field('blogar_footer_address', __('Địa chỉ', 'blogar'),          'blogar_text_field_cb',     'blogar-footer', 'blogar_footer_brand', array('option_name' => 'blogar_footer_address', 'placeholder' => '123 Main Street, City'));

    // ── Col 2: Category menu ─────────────────────────────────────
    register_setting('blogar_footer_settings', 'blogar_footer_col2_title', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_section('blogar_footer_col2', __('Cột 2 — Menu danh mục', 'blogar'), 'blogar_footer_col2_cb', 'blogar-footer');
    add_settings_field('blogar_footer_col2_title', __('Tiêu đề cột', 'blogar'), 'blogar_text_field_cb', 'blogar-footer', 'blogar_footer_col2', array('option_name' => 'blogar_footer_col2_title', 'default' => 'Quick Links', 'placeholder' => 'Quick Links'));

    // ── Col 3: Pages menu ────────────────────────────────────────
    register_setting('blogar_footer_settings', 'blogar_footer_col3_title', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_section('blogar_footer_col3', __('Cột 3 — Menu trang', 'blogar'), 'blogar_footer_col3_cb', 'blogar-footer');
    add_settings_field('blogar_footer_col3_title', __('Tiêu đề cột', 'blogar'), 'blogar_text_field_cb', 'blogar-footer', 'blogar_footer_col3', array('option_name' => 'blogar_footer_col3_title', 'default' => 'Our Pages', 'placeholder' => 'Our Pages'));

    // ── Col 4: Newsletter / Social ───────────────────────────────
    register_setting('blogar_footer_settings', 'blogar_footer_col4_type',  array('sanitize_callback' => 'blogar_sanitize_footer_col4_type', 'default' => 'newsletter'));
    register_setting('blogar_footer_settings', 'blogar_footer_col4_title', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('blogar_footer_settings', 'blogar_footer_col4_desc',  array('sanitize_callback' => 'sanitize_textarea_field'));
    register_setting('blogar_footer_settings', 'blogar_footer_fb_url',     array('sanitize_callback' => 'esc_url_raw'));
    register_setting('blogar_footer_settings', 'blogar_footer_tw_url',     array('sanitize_callback' => 'esc_url_raw'));
    register_setting('blogar_footer_settings', 'blogar_footer_li_url',     array('sanitize_callback' => 'esc_url_raw'));
    register_setting('blogar_footer_settings', 'blogar_footer_ig_url',     array('sanitize_callback' => 'esc_url_raw'));
    register_setting('blogar_footer_settings', 'blogar_footer_yt_url',     array('sanitize_callback' => 'esc_url_raw'));

    add_settings_section('blogar_footer_col4', __('Cột 4 — Newsletter / Social', 'blogar'), 'blogar_footer_col4_cb', 'blogar-footer');
    add_settings_field('blogar_footer_col4_type',  __('Loại cột 4', 'blogar'),  'blogar_footer_col4_type_field_cb', 'blogar-footer', 'blogar_footer_col4');
    add_settings_field('blogar_footer_col4_title', __('Tiêu đề cột', 'blogar'), 'blogar_text_field_cb',             'blogar-footer', 'blogar_footer_col4', array('option_name' => 'blogar_footer_col4_title', 'placeholder' => 'Newsletter'));
    add_settings_field('blogar_footer_col4_desc',  __('Mô tả ngắn', 'blogar'),  'blogar_textarea_field_cb',         'blogar-footer', 'blogar_footer_col4', array('option_name' => 'blogar_footer_col4_desc',  'placeholder' => 'Stay updated with our latest news...'));
    add_settings_field('blogar_footer_fb_url',     'Facebook',                   'blogar_url_field_cb',              'blogar-footer', 'blogar_footer_col4', array('option_name' => 'blogar_footer_fb_url',     'placeholder' => 'https://facebook.com/yourpage'));
    add_settings_field('blogar_footer_tw_url',     'Twitter / X',                'blogar_url_field_cb',              'blogar-footer', 'blogar_footer_col4', array('option_name' => 'blogar_footer_tw_url',     'placeholder' => 'https://twitter.com/yourhandle'));
    add_settings_field('blogar_footer_li_url',     'LinkedIn',                   'blogar_url_field_cb',              'blogar-footer', 'blogar_footer_col4', array('option_name' => 'blogar_footer_li_url',     'placeholder' => 'https://linkedin.com/in/yourprofile'));
    add_settings_field('blogar_footer_ig_url',     'Instagram',                  'blogar_url_field_cb',              'blogar-footer', 'blogar_footer_col4', array('option_name' => 'blogar_footer_ig_url',     'placeholder' => 'https://instagram.com/yourhandle'));
    add_settings_field('blogar_footer_yt_url',     'YouTube',                    'blogar_url_field_cb',              'blogar-footer', 'blogar_footer_col4', array('option_name' => 'blogar_footer_yt_url',     'placeholder' => 'https://youtube.com/@yourchannel'));

    // ── Copyright ────────────────────────────────────────────────
    register_setting('blogar_footer_settings', 'blogar_footer_copyright', array('sanitize_callback' => 'wp_kses_post'));

    add_settings_section('blogar_footer_copyright_section', __('Copyright', 'blogar'), 'blogar_footer_copyright_section_cb', 'blogar-footer');
    add_settings_field('blogar_footer_copyright', __('Nội dung copyright', 'blogar'), 'blogar_text_field_cb', 'blogar-footer', 'blogar_footer_copyright_section', array(
        'option_name' => 'blogar_footer_copyright',
        'placeholder' => '© ' . gmdate('Y') . ' ' . get_bloginfo('name') . '. All rights reserved.',
    ));
}

function blogar_sanitize_footer_col4_type($value)
{
    return in_array($value, array('newsletter', 'social'), true) ? $value : 'newsletter';
}

function blogar_footer_brand_cb()
{
    echo '<p class="description">' . esc_html__('Thông tin hiển thị ở cột đầu tiên bên trái footer.', 'blogar') . '</p>';
}

function blogar_footer_col2_cb()
{
    $url = admin_url('nav-menus.php');
    echo '<p class="description">' . wp_kses(
        sprintf(
            /* translators: %s: Menus admin URL */
            __('Gán menu tại <a href="%s">Appearance › Menus</a> → location <strong>Footer: Category Menu</strong>.', 'blogar'),
            esc_url($url)
        ),
        array('a' => array('href' => array()), 'strong' => array())
    ) . '</p>';
}

function blogar_footer_col3_cb()
{
    $url = admin_url('nav-menus.php');
    echo '<p class="description">' . wp_kses(
        sprintf(
            /* translators: %s: Menus admin URL */
            __('Gán menu tại <a href="%s">Appearance › Menus</a> → location <strong>Footer: Pages Menu</strong>.', 'blogar'),
            esc_url($url)
        ),
        array('a' => array('href' => array()), 'strong' => array())
    ) . '</p>';
}

function blogar_footer_col4_cb()
{
    echo '<p class="description">' . esc_html__('Chọn kiểu cột 4: form đăng ký newsletter hoặc social icons. Ô URL nào để trống sẽ bị ẩn tự động.', 'blogar') . '</p>';
}

function blogar_footer_copyright_section_cb()
{
    echo '<p class="description">' . esc_html__('Nội dung dòng copyright ở cuối footer. Để trống sẽ dùng tên site + năm hiện tại.', 'blogar') . '</p>';
}

function blogar_textarea_field_cb($args)
{
    $option      = $args['option_name'];
    $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
    $value       = get_option($option, '');
    printf(
        '<textarea id="%1$s" name="%1$s" rows="3" placeholder="%3$s" style="min-width:360px;max-width:100%%;display:block">%2$s</textarea>',
        esc_attr($option),
        esc_textarea($value),
        esc_attr($placeholder)
    );
}

function blogar_url_field_cb($args)
{
    $option      = $args['option_name'];
    $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
    $value       = get_option($option, '');
    printf(
        '<input type="url" id="%1$s" name="%1$s" value="%2$s" placeholder="%3$s" style="min-width:360px;max-width:100%%" />',
        esc_attr($option),
        esc_attr($value),
        esc_attr($placeholder)
    );
}

function blogar_footer_col4_type_field_cb()
{
    $current = get_option('blogar_footer_col4_type', 'newsletter');
    $options = array(
        'newsletter' => __('Form đăng ký Newsletter (email input + nút gửi)', 'blogar'),
        'social'     => __('Social Icons (Facebook, Twitter, LinkedIn, Instagram, YouTube)', 'blogar'),
    );
    echo '<select id="blogar_footer_col4_type" name="blogar_footer_col4_type" style="min-width:360px">';
    foreach ($options as $value => $label) {
        printf(
            '<option value="%s"%s>%s</option>',
            esc_attr($value),
            selected($current, $value, false),
            esc_html($label)
        );
    }
    echo '</select>';
    echo '<p class="description">' . esc_html__('Lưu ý: Social icons luôn hiển thị bên dưới form newsletter nếu có URL.', 'blogar') . '</p>';
}

function blogar_footer_colors_cb()
{
    echo '<p class="description">' . esc_html__('Màu nền và màu chữ phần body footer. Tiêu đề cột luôn là màu trắng.', 'blogar') . '</p>';
}

function blogar_color_field_cb($args)
{
    $option  = $args['option_name'];
    $default = isset($args['default']) ? $args['default'] : '#000000';
    $value   = get_option($option, $default);
    printf(
        '<div style="display:flex;align-items:center;gap:10px">'
            . '<input type="color" id="%1$s" name="%1$s" value="%2$s"'
            . ' style="width:52px;height:34px;padding:2px 3px;border:1px solid #ddd;border-radius:4px;cursor:pointer" />'
            . '<code id="%1$s_val">%2$s</code>'
        . '</div>'
        . '<script>(function(){var i=document.getElementById("%1$s"),c=document.getElementById("%1$s_val");if(i&&c)i.addEventListener("input",function(){c.textContent=i.value;});})()</script>',
        esc_attr($option),
        esc_attr($value)
    );
}


// ================================================================
// SIDEBAR SETTINGS
// ================================================================

add_action('admin_init', 'blogar_register_sidebar_settings');

function blogar_register_sidebar_settings()
{
    register_setting('blogar_sidebar_settings', 'blogar_sidebar_widget_order', array(
        'type'              => 'string',
        'sanitize_callback' => 'blogar_sanitize_sidebar_widget_order',
        'default'           => '',
    ));

    $widgets_defaults = array(
        'popular_posts' => 1,
        'categories'    => 1,
        'newsletter'    => 1,
        'search'        => 0,
        'tags'          => 0,
    );
    foreach ($widgets_defaults as $key => $default) {
        register_setting('blogar_sidebar_settings', 'blogar_sidebar_' . $key . '_enabled', array(
            'type'              => 'integer',
            'sanitize_callback' => 'absint',
            'default'           => $default,
        ));
    }

    register_setting('blogar_sidebar_settings', 'blogar_sidebar_popular_posts_count', array(
        'type'              => 'integer',
        'sanitize_callback' => 'absint',
        'default'           => 5,
    ));
    register_setting('blogar_sidebar_settings', 'blogar_sidebar_categories_count', array(
        'type'              => 'integer',
        'sanitize_callback' => 'absint',
        'default'           => 10,
    ));
}

function blogar_sanitize_sidebar_widget_order($value)
{
    $valid   = array('popular_posts', 'categories', 'newsletter', 'search', 'tags');
    $decoded = json_decode(wp_unslash($value), true);
    if (!is_array($decoded)) {
        return '';
    }
    $filtered = array_values(array_filter($decoded, function ($k) use ($valid) {
        return in_array($k, $valid, true);
    }));
    return wp_json_encode($filtered);
}

function blogar_render_sidebar_tab()
{
    $widgets_meta = array(
        'popular_posts' => array(
            'label'         => __('Popular Posts', 'blogar'),
            'desc'          => __('Posts ranked by comments, with thumbnail', 'blogar'),
            'count_key'     => 'blogar_sidebar_popular_posts_count',
            'count_default' => 5,
            'count_label'   => __('Số bài', 'blogar'),
        ),
        'categories' => array(
            'label'         => __('Categories', 'blogar'),
            'desc'          => __('Category list with post count badge', 'blogar'),
            'count_key'     => 'blogar_sidebar_categories_count',
            'count_default' => 10,
            'count_label'   => __('Số danh mục', 'blogar'),
        ),
        'newsletter' => array(
            'label' => __('Subscribe Newsletter', 'blogar'),
            'desc'  => __('Email subscription form (wired to footer handler)', 'blogar'),
        ),
        'search' => array(
            'label' => __('Search', 'blogar'),
            'desc'  => __('Search box', 'blogar'),
        ),
        'tags' => array(
            'label' => __('All Tags', 'blogar'),
            'desc'  => __('Tag cloud — top 20 by count', 'blogar'),
        ),
    );

    $all_keys      = array_keys($widgets_meta);
    $default_order = array('popular_posts', 'categories', 'newsletter', 'search', 'tags');
    $default_on    = array('popular_posts', 'categories', 'newsletter');

    $raw           = get_option('blogar_sidebar_widget_order', '');
    $current_order = (!empty($raw)) ? (array) json_decode($raw, true) : $default_order;
    $current_order = array_values(array_filter($current_order, function ($k) use ($all_keys) {
        return in_array($k, $all_keys, true);
    }));
    foreach ($default_order as $k) {
        if (!in_array($k, $current_order, true)) {
            $current_order[] = $k;
        }
    }
    ?>
<form method="post" action="options.php" style="max-width:620px">
    <?php settings_fields('blogar_sidebar_settings'); ?>

    <p style="color:#555;margin:0 0 18px;font-size:13px;line-height:1.6">
        <?php esc_html_e('Kéo thả để sắp xếp thứ tự. Tick checkbox để bật widget. Nhấn Save để áp dụng.', 'blogar'); ?>
    </p>

    <input type="hidden" name="blogar_sidebar_widget_order" id="blogar_sborder_input"
        value="<?php echo esc_attr(wp_json_encode($current_order)); ?>">

    <ul id="blogar-sb-sorter" style="margin:0;padding:0;list-style:none;display:flex;flex-direction:column;gap:6px">
        <?php foreach ($current_order as $key):
            if (!isset($widgets_meta[$key])) continue;
            $meta    = $widgets_meta[$key];
            $enabled = (bool) get_option(
                'blogar_sidebar_' . $key . '_enabled',
                in_array($key, $default_on, true) ? 1 : 0
            );
        ?>
        <li data-key="<?php echo esc_attr($key); ?>" draggable="true"
            style="display:flex;align-items:center;gap:12px;padding:12px 16px;background:#fff;border:1.5px solid #ddd;border-radius:6px;cursor:grab;user-select:none;transition:box-shadow 0.15s,border-color 0.15s">

            <span style="font-size:18px;color:#bbb;line-height:1;flex-shrink:0"
                title="<?php esc_attr_e('Drag to reorder', 'blogar'); ?>">⠿</span>

            <span class="sb-sorter-pos"
                style="font-size:12px;font-weight:700;color:#999;width:22px;flex-shrink:0;text-align:center"></span>

            <div style="flex:1;min-width:0">
                <strong
                    style="font-size:13px;display:block;color:#1e1e1e"><?php echo esc_html($meta['label']); ?></strong>
                <span style="font-size:12px;color:#888"><?php echo esc_html($meta['desc']); ?></span>
            </div>

            <?php if (!empty($meta['count_key'])): ?>
            <label
                style="display:inline-flex;align-items:center;gap:5px;font-size:12px;color:#555;flex-shrink:0;cursor:default">
                <?php echo esc_html($meta['count_label']); ?>:
                <input type="number" name="<?php echo esc_attr($meta['count_key']); ?>"
                    value="<?php echo (int) get_option($meta['count_key'], $meta['count_default']); ?>" min="1" max="20"
                    style="width:50px;padding:3px 6px;font-size:12px;border:1px solid #ddd;border-radius:4px">
            </label>
            <?php endif; ?>

            <label
                style="display:inline-flex;align-items:center;gap:5px;font-size:12px;color:#555;flex-shrink:0;cursor:pointer"
                title="<?php esc_attr_e('Bật / Tắt widget này', 'blogar'); ?>">
                <input type="checkbox" name="blogar_sidebar_<?php echo esc_attr($key); ?>_enabled" value="1"
                    <?php checked($enabled); ?>>
                <?php esc_html_e('Hiện', 'blogar'); ?>
            </label>

        </li>
        <?php endforeach; ?>
    </ul>

    <div style="margin-top:20px;display:flex;align-items:center;gap:10px;flex-wrap:wrap">
        <?php submit_button(__('Lưu cài đặt', 'blogar'), 'primary', 'submit', false); ?>
        <button type="button" id="blogar-sb-reset" class="button button-secondary">
            <?php esc_html_e('Reset về mặc định', 'blogar'); ?>
        </button>
    </div>
</form>

<script>
(function() {
    var list = document.getElementById('blogar-sb-sorter');
    var input = document.getElementById('blogar_sborder_input');
    var resetBtn = document.getElementById('blogar-sb-reset');
    if (!list || !input) return;

    var defaultOrder = <?php echo wp_json_encode($default_order); ?>;
    var dragging = null;

    function updatePositions() {
        list.querySelectorAll('li').forEach(function(li, i) {
            var pos = li.querySelector('.sb-sorter-pos');
            if (pos) pos.textContent = '#' + (i + 1);
        });
    }

    function updateInput() {
        var keys = [];
        list.querySelectorAll('li').forEach(function(li) {
            keys.push(li.dataset.key);
        });
        input.value = JSON.stringify(keys);
        updatePositions();
    }

    list.addEventListener('dragstart', function(e) {
        dragging = e.target.closest('li');
        if (!dragging) return;
        setTimeout(function() {
            dragging.style.opacity = '0.4';
        }, 0);
        e.dataTransfer.effectAllowed = 'move';
    });

    list.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        var target = e.target.closest('li');
        if (!target || target === dragging) return;
        list.querySelectorAll('li').forEach(function(li) {
            li.style.boxShadow = '';
            li.style.borderColor = '#ddd';
        });
        var rect = target.getBoundingClientRect();
        var isAbove = e.clientY < rect.top + rect.height / 2;
        target.style.boxShadow = isAbove ? 'inset 0 3px 0 0 #2271b1' : 'inset 0 -3px 0 0 #2271b1';
        target.style.borderColor = '#2271b1';
    });

    list.addEventListener('drop', function(e) {
        e.preventDefault();
        var target = e.target.closest('li');
        list.querySelectorAll('li').forEach(function(li) {
            li.style.boxShadow = '';
            li.style.borderColor = '#ddd';
        });
        if (!target || !dragging || target === dragging) return;
        var rect = target.getBoundingClientRect();
        if (e.clientY < rect.top + rect.height / 2) {
            list.insertBefore(dragging, target);
        } else {
            list.insertBefore(dragging, target.nextSibling);
        }
        updateInput();
    });

    list.addEventListener('dragend', function() {
        list.querySelectorAll('li').forEach(function(li) {
            li.style.opacity = '';
            li.style.boxShadow = '';
            li.style.borderColor = '#ddd';
        });
        dragging = null;
        updateInput();
    });

    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            var items = {};
            list.querySelectorAll('li').forEach(function(li) {
                items[li.dataset.key] = li;
            });
            defaultOrder.forEach(function(key) {
                if (items[key]) list.appendChild(items[key]);
            });
            updateInput();
        });
    }

    updatePositions();
})();
</script>
<?php
}





// ================================================================
// 404 PAGE SETTINGS
// ================================================================
function blogar_register_404_settings()
{
    register_setting('blogar_404_settings', 'blogar_404_heading',   array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('blogar_404_settings', 'blogar_404_sub',       array('sanitize_callback' => 'sanitize_textarea_field'));
    // Dùng custom sanitizer thay vì absint để chấp nhận -1, -2
    register_setting('blogar_404_settings', 'blogar_404_cta_1_cat', array('sanitize_callback' => 'blogar_sanitize_404_cta_cat'));
    register_setting('blogar_404_settings', 'blogar_404_cta_2_cat', array('sanitize_callback' => 'blogar_sanitize_404_cta_cat'));
    register_setting('blogar_404_settings', 'blogar_404_cta_3_cat', array('sanitize_callback' => 'blogar_sanitize_404_cta_cat'));
    register_setting('blogar_404_settings', 'blogar_404_cta_4_cat', array('sanitize_callback' => 'blogar_sanitize_404_cta_cat'));
}
add_action('admin_init', 'blogar_register_404_settings');
 

function blogar_sanitize_404_cta_cat( $value ) {
    $int = (int) $value;
    if ( in_array( $int, array( -1, -2 ), true ) ) {
        return $int;
    }
    return absint( $int ); // 0 hoặc ID dương
}
 
 
function blogar_render_404_tab()
{
    // ── Handle save ────────────────────────────────────────────────
    if (isset($_POST['blogar_404_nonce']) && wp_verify_nonce(sanitize_key($_POST['blogar_404_nonce']), 'blogar_save_404')) {
        update_option('blogar_404_heading',   sanitize_text_field(wp_unslash($_POST['blogar_404_heading'] ?? '')));
        update_option('blogar_404_sub',       sanitize_textarea_field(wp_unslash($_POST['blogar_404_sub'] ?? '')));
        // Dùng custom sanitizer để -1, -2 không bị absint() chuyển thành 0
        update_option('blogar_404_cta_1_cat', blogar_sanitize_404_cta_cat( $_POST['blogar_404_cta_1_cat'] ?? 0 ));
        update_option('blogar_404_cta_2_cat', blogar_sanitize_404_cta_cat( $_POST['blogar_404_cta_2_cat'] ?? 0 ));
        update_option('blogar_404_cta_3_cat', blogar_sanitize_404_cta_cat( $_POST['blogar_404_cta_3_cat'] ?? 0 ));
        update_option('blogar_404_cta_4_cat', blogar_sanitize_404_cta_cat( $_POST['blogar_404_cta_4_cat'] ?? 0 ));
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Đã lưu cài đặt trang 404.', 'blogar') . '</p></div>';
    }
 
    // ── Current values ─────────────────────────────────────────────
    $heading = get_option('blogar_404_heading', '');
    $sub     = get_option('blogar_404_sub',     '');
    $sel     = array();
    for ($i = 1; $i <= 4; $i++) {
        $sel[$i] = (int) get_option("blogar_404_cta_{$i}_cat", 0);
    }
 
    // ── Categories for dropdown ────────────────────────────────────
    $cats = get_categories(array('hide_empty' => false, 'orderby' => 'name', 'order' => 'ASC'));
 
    // ── Blog page info (dùng cho option -1) ────────────────────────
    $posts_page_id    = (int) get_option('page_for_posts');
    $posts_page_title = $posts_page_id
        ? get_the_title($posts_page_id)
        : __('Trang Blog', 'blogar');
 
    $page_url = add_query_arg(array('page' => 'blogar-settings', 'tab' => '404_page'), admin_url('themes.php'));
    ?>
<form method="post" action="<?php echo esc_url($page_url); ?>">
    <?php wp_nonce_field('blogar_save_404', 'blogar_404_nonce'); ?>

    <table class="form-table" role="presentation">

        <!-- Heading -->
        <tr>
            <th scope="row">
                <label for="blogar_404_heading"><?php esc_html_e('Tiêu đề trang 404', 'blogar'); ?></label>
            </th>
            <td>
                <input type="text" id="blogar_404_heading" name="blogar_404_heading"
                    value="<?php echo esc_attr($heading); ?>"
                    placeholder="<?php esc_attr_e('Oops! Trang không tìm thấy', 'blogar'); ?>"
                    style="min-width:400px;max-width:100%">
                <p class="description">
                    <?php esc_html_e('Tiêu đề lớn hiển thị trên trang 404. Để trống dùng mặc định.', 'blogar'); ?></p>
            </td>
        </tr>

        <!-- Subtitle -->
        <tr>
            <th scope="row">
                <label for="blogar_404_sub"><?php esc_html_e('Mô tả / phụ đề', 'blogar'); ?></label>
            </th>
            <td>
                <textarea id="blogar_404_sub" name="blogar_404_sub" rows="3" style="min-width:400px;max-width:100%"
                    placeholder="<?php esc_attr_e('Trang bạn đang tìm có thể đã bị xóa hoặc đường dẫn thay đổi.', 'blogar'); ?>"><?php echo esc_textarea($sub); ?></textarea>
                <p class="description"><?php esc_html_e('Dòng mô tả nhỏ bên dưới tiêu đề.', 'blogar'); ?></p>
            </td>
        </tr>

        <!-- Divider -->
        <tr>
            <td colspan="2">
                <hr style="margin:8px 0 4px;border-color:#ddd">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <h3 style="margin:0 0 4px;font-size:14px;color:#1d2327">
                    <?php esc_html_e('4 nút CTA — chọn đích đến', 'blogar'); ?>
                </h3>
                <p class="description" style="margin-bottom:12px">
                    <?php esc_html_e('Mỗi slot có thể trỏ đến một category, trang Blog, trang Chủ, hoặc để "Tự động" (hệ thống tự lấy top categories).', 'blogar'); ?>
                </p>
            </td>
        </tr>

        <?php
            $card_labels = array(
                1 => __('CTA 1 — màu xanh dương', 'blogar'),
                2 => __('CTA 2 — màu đỏ',         'blogar'),
                3 => __('CTA 3 — màu xanh lá',    'blogar'),
                4 => __('CTA 4 — màu cam',         'blogar'),
            );
 
            for ($i = 1; $i <= 4; $i++) :
                $field_id = "blogar_404_cta_{$i}_cat";
            ?>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr($field_id); ?>">
                    <?php echo esc_html($card_labels[$i]); ?>
                </label>
            </th>
            <td>
                <select id="<?php echo esc_attr($field_id); ?>" name="<?php echo esc_attr($field_id); ?>"
                    style="min-width:300px">

                    <!-- Tự động -->
                    <option value="0" <?php selected($sel[$i], 0); ?>>
                        <?php esc_html_e('— Tự động (top categories) —', 'blogar'); ?>
                    </option>

                    <!-- Trang đặc biệt -->
                    <optgroup label="<?php esc_attr_e('── Trang đặc biệt', 'blogar'); ?>">

                        <option value="-1" <?php selected($sel[$i], -1); ?>>
                            📰 <?php
                                    printf(
                                        '%s %s',
                                        esc_html($posts_page_title),
                                        esc_html__('(tất cả bài viết)', 'blogar')
                                    );
                                ?>
                        </option>

                        <option value="-2" <?php selected($sel[$i], -2); ?>>
                            🏠 <?php esc_html_e('Trang Chủ (front page)', 'blogar'); ?>
                        </option>

                    </optgroup>

                    <!-- Danh mục -->
                    <?php if (!empty($cats)) : ?>
                    <optgroup label="<?php esc_attr_e('── Danh mục', 'blogar'); ?>">
                        <?php foreach ($cats as $cat) : ?>
                        <option value="<?php echo absint($cat->term_id); ?>"
                            <?php selected($sel[$i], $cat->term_id); ?>>
                            <?php
                                    printf(
                                        '%s (%d %s)',
                                        esc_html($cat->name),
                                        absint($cat->count),
                                        esc_html__('bài', 'blogar')
                                    );
                                ?>
                        </option>
                        <?php endforeach; ?>
                    </optgroup>
                    <?php endif; ?>

                </select>
            </td>
        </tr>
        <?php endfor; ?>

    </table>

    <?php submit_button(__('Lưu cài đặt 404', 'blogar')); ?>
</form>

<!-- Live preview link -->
<div
    style="margin-top:8px;padding:12px 16px;background:#f8f4f8;border-left:4px solid #3858f6;border-radius:0 4px 4px 0;font-size:13px;color:#1d2327">
    <strong><?php esc_html_e('Xem trước:', 'blogar'); ?></strong>&nbsp;
    <a href="<?php echo esc_url(home_url('/blogar-404-preview-xyz')); ?>" target="_blank" rel="noopener noreferrer">
        <?php esc_html_e('Mở trang 404 trong tab mới', 'blogar'); ?> &rarr;
    </a>
    <span style="color:#878787;margin-left:6px">
        (<?php esc_html_e('hoặc nhập bất kỳ URL không tồn tại để xem live', 'blogar'); ?>)
    </span>
</div>

<?php
}
 