<?php
if (!defined('ABSPATH')) {
    exit;
}

// ================================================================
// THEME INCLUDES
// ================================================================

require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/theme-options.php';
require_once get_template_directory() . '/inc/mega-menu-walker.php';


// ================================================================
// THEME SETUP
// ================================================================

function blogar_theme_setup()
{
    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'blogar'),
            'footer-col2' => __('Footer: Category Menu', 'blogar'),
            'footer-col3' => __('Footer: Pages Menu', 'blogar'),
        )
    );

    add_theme_support(
        'custom-logo',
        array(
            'height' => 37,
            'width' => 158,
            'flex-height' => true,
            'flex-width' => true,
        )
    );

    // Cho phép WordPress (và plugin SEO như Rank Math) quản lý thẻ <title>.
    add_theme_support('title-tag');

    // Hỗ trợ featured image cho posts.
    add_theme_support('post-thumbnails');

    // ── Custom image sizes ─────────────────────────────────────
    // Hero slider: 1230x615 (ratio 2:1)
    add_image_size('blogar-hero', 1230, 615, true);

    // Featured posts / grid cards
    add_image_size('blogar-featured', 300, 169, true);

    // Tab carousel cards
    add_image_size('blogar-card', 390, 260, true);

    // Big grid post
    add_image_size('blogar-grid-big', 705, 660, true);

    // Small grid post
    add_image_size('blogar-grid-small', 495, 300, true);

    // Post list view
    add_image_size('blogar-list', 300, 169, true);

    // Sidebar recent posts / thumbnail round
    add_image_size('blogar-thumb', 150, 150, true);

    // Category carousel (square)
    add_image_size('blogar-cat', 300, 300, true);

    // Video section small cards
    add_image_size('blogar-video-small', 285, 190, true);

    // Video section big card
    add_image_size('blogar-featured-video-big', 600, 500, true);
}
add_action('after_setup_theme', 'blogar_theme_setup');


// ================================================================
// ASSET VERSIONING
// ================================================================

function blogar_asset_version($relative_path)
{
    $path = get_template_directory() . '/' . ltrim($relative_path, '/');

    if (file_exists($path)) {
        return (string) filemtime($path);
    }

    return wp_get_theme()->get('Version');
}


// ================================================================
// ENQUEUE ASSETS
// ================================================================

function blogar_enqueue_assets()
{
    wp_enqueue_style(
        'blogar-fonts',
        'https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;700;900&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'blogar-global',
        get_template_directory_uri() . '/css/style.css',
        array('blogar-fonts'),
        blogar_asset_version('css/style.css')
    );

    wp_enqueue_style(
        'blogar-header',
        get_template_directory_uri() . '/css/header.css',
        array('blogar-global'),
        blogar_asset_version('css/header.css')
    );

    wp_enqueue_style(
        'blogar-footer',
        get_template_directory_uri() . '/css/footer.css',
        array('blogar-global'),
        blogar_asset_version('css/footer.css')
    );

    if (is_front_page() || is_archive() || is_search() || is_single() || is_page() || (is_home() && !is_front_page())) {
        wp_enqueue_style(
            'blogar-frontpage',
            get_template_directory_uri() . '/css/frontpage.css',
            array('blogar-global'),
            blogar_asset_version('css/frontpage.css')
        );
    }

    wp_enqueue_script(
        'blogar-header',
        get_template_directory_uri() . '/js/header.js',
        array(),
        blogar_asset_version('js/header.js'),
        true
    );

    wp_enqueue_script(
        'blogar-footer',
        get_template_directory_uri() . '/js/footer.js',
        array(),
        blogar_asset_version('js/footer.js'),
        true
    );

    if (is_front_page() || is_archive() || is_search() || is_single() || is_page() || (is_home() && !is_front_page())) {
        wp_enqueue_script(
            'blogar-frontpage',
            get_template_directory_uri() . '/js/frontpage.js',
            array(),
            blogar_asset_version('js/frontpage.js'),
            true
        );
    }

    if (is_archive() || is_search() || is_single() || is_page() || (is_home() && !is_front_page())) {
        wp_enqueue_style(
            'blogar-archive',
            get_template_directory_uri() . '/css/archive.css',
            array('blogar-frontpage'),
            blogar_asset_version('css/archive.css')
        );
    }

    if (is_home() && !is_front_page()) {
        wp_enqueue_style(
            'blogar-home',
            get_template_directory_uri() . '/css/home.css',
            array('blogar-archive'),
            blogar_asset_version('css/home.css')
        );
    }

    if (is_single() || is_page()) {
        wp_enqueue_style(
            'blogar-single',
            get_template_directory_uri() . '/css/single.css',
            array('blogar-frontpage', 'blogar-archive'),
            blogar_asset_version('css/single.css')
        );
    }

    if (is_page()) {
        wp_enqueue_style(
            'blogar-page',
            get_template_directory_uri() . '/css/page.css',
            array('blogar-archive', 'blogar-single'),
            blogar_asset_version('css/page.css')
        );
    }

    if (is_author()) {
        wp_enqueue_style(
            'blogar-author',                                        // handle
            get_template_directory_uri() . '/css/author.css',
            array('blogar-archive'),                             // depends on archive.css
            wp_get_theme()->get('Version')
        );
    }

    if (is_page_template('page-contact.php')) {
        wp_enqueue_style(
            'blogar-page-contact',
            get_template_directory_uri() . '/css/page-contact.css',
            array('blogar-page'),
            blogar_asset_version('css/page-contact.css')
        );
    }

    if (is_404()) {
        wp_enqueue_style(
            'blogar-404',
            get_template_directory_uri() . '/css/404.css',
            array('blogar-global'),
            blogar_asset_version('css/404.css')
        );
    }

    // Mega menu — load trên tất cả page (header xuất hiện ở mọi nơi)
    wp_enqueue_style(
        'blogar-mega-menu',
        get_template_directory_uri() . '/css/mega-menu.css',
        array('blogar-header'),          // load sau header.css
        blogar_asset_version('css/mega-menu.css')
    );

    wp_enqueue_script(
        'blogar-mega-menu',
        get_template_directory_uri() . '/js/mega-menu.js',
        array(),
        blogar_asset_version('js/mega-menu.js'),
        true                              // load ở footer
    );
}
add_action('wp_enqueue_scripts', 'blogar_enqueue_assets');


// ================================================================
// FALLBACK MENU
// ================================================================

function blogar_primary_menu_fallback($args)
{
    $menu_class = isset($args['menu_class']) ? $args['menu_class'] : 'mainmenu';

    $items = array(
        array(
            'label' => __('Home', 'blogar'),
            'url' => home_url('/'),
            'current' => is_front_page() || is_home(),
            'children' => array(
                array(
                    'label' => __('Home Default', 'blogar'),
                    'url' => home_url('/'),
                    'current' => is_front_page() || is_home(),
                ),
            ),
        ),
        array(
            'label' => __('Posts', 'blogar'),
            'url' => home_url('/'),
            'children' => array(
                array(
                    'label' => __('Latest Posts', 'blogar'),
                    'url' => home_url('/'),
                ),
            ),
        ),
        array(
            'label' => __('Pages', 'blogar'),
            'url' => '#',
            'children' => array(
                array(
                    'label' => __('About Us', 'blogar'),
                    'url' => '#',
                ),
                array(
                    'label' => __('Contact Us', 'blogar'),
                    'url' => '#',
                ),
            ),
        ),
        array(
            'label' => __('Lifestyle', 'blogar'),
            'url' => '#',
        ),
        array(
            'label' => __('Technology', 'blogar'),
            'url' => '#',
        ),
        array(
            'label' => __('Shop', 'blogar'),
            'url' => '#',
            'children' => array(
                array(
                    'label' => __('Shop', 'blogar'),
                    'url' => '#',
                ),
                array(
                    'label' => __('Cart', 'blogar'),
                    'url' => '#',
                ),
                array(
                    'label' => __('Checkout', 'blogar'),
                    'url' => '#',
                ),
            ),
        ),
    );

    $output = '<ul class="' . esc_attr($menu_class) . '">';

    foreach ($items as $item) {
        $classes = array('menu-item');

        if (!empty($item['children'])) {
            $classes[] = 'menu-item-has-children';
        }

        if (!empty($item['current'])) {
            $classes[] = 'current-menu-item';
            $classes[] = 'current_page_item';
        }

        $output .= '<li class="' . esc_attr(implode(' ', $classes)) . '">';
        $output .= '<a href="' . esc_url($item['url']) . '"' . (!empty($item['current']) ? ' aria-current="page"' : '') . '>' . esc_html($item['label']) . '</a>';

        if (!empty($item['children'])) {
            $output .= '<ul class="sub-menu">';

            foreach ($item['children'] as $child) {
                $child_classes = array('menu-item');

                if (!empty($child['current'])) {
                    $child_classes[] = 'current-menu-item';
                    $child_classes[] = 'current_page_item';
                }

                $output .= '<li class="' . esc_attr(implode(' ', $child_classes)) . '">';
                $output .= '<a href="' . esc_url($child['url']) . '"' . (!empty($child['current']) ? ' aria-current="page"' : '') . '>' . esc_html($child['label']) . '</a>';
                $output .= '</li>';
            }

            $output .= '</ul>';
        }

        $output .= '</li>';
    }

    $output .= '</ul>';

    if (!empty($args['echo'])) {
        echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    return $output;
}


// ================================================================
// AI1WM EXPORT EXCLUSIONS
// ================================================================

// Loại bỏ .git khỏi export All-in-One WP Migration (tránh file wpress bị phình to)
add_filter('ai1wm_exclude_files_from_export', function ($excludes) {
    $excludes[] = '.git';
    return $excludes;
});


// ================================================================
// NEWSLETTER FORM HANDLER
// ================================================================

add_action('admin_post_nopriv_blogar_newsletter', 'blogar_handle_newsletter');
add_action('admin_post_blogar_newsletter', 'blogar_handle_newsletter');

function blogar_handle_newsletter()
{
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])), 'blogar_newsletter_nonce')) {
        wp_die(esc_html__('Security check failed.', 'blogar'));
    }

    $email = isset($_POST['blogar_nl_email']) ? sanitize_email(wp_unslash($_POST['blogar_nl_email'])) : '';

    $referer = wp_get_referer() ?: home_url('/');

    if (!is_email($email)) {
        wp_safe_redirect(add_query_arg('newsletter', 'invalid', $referer));
        exit;
    }

    $admin_email = get_option('admin_email');
    $subject = sprintf('[%s] New Newsletter Subscription', get_bloginfo('name'));
    $message = "New subscription request:\n\nEmail: {$email}\n\nSent from: " . home_url('/');
    wp_mail($admin_email, $subject, $message);

    wp_safe_redirect(add_query_arg('newsletter', 'success', $referer));
    exit;
}


// ================================================================
// WOOCOMMERCE CART COUNT
// ================================================================

function blogar_get_cart_count()
{
    if (class_exists('WooCommerce') && function_exists('WC') && WC()->cart) {
        return WC()->cart->get_cart_contents_count();
    }

    return 0;
}


// ================================================================
// HOME PAGE — DESCRIPTION META BOX (trên edit screen của Posts Page)
// ================================================================

/**
 * Chỉ thêm meta box khi đang edit đúng page được set làm "Posts page".
 * Hook add_meta_boxes_page truyền $post object vào callback.
 */
add_action('add_meta_boxes_page', 'blogar_add_home_desc_meta_box');

function blogar_add_home_desc_meta_box($post)
{
    $posts_page_id = (int) get_option('page_for_posts');
    if (!$posts_page_id || $post->ID !== $posts_page_id) {
        return;
    }
    add_meta_box(
        'blogar_home_desc',
        __('Blog Page Description', 'blogar'),
        'blogar_home_desc_meta_box_cb',
        'page',
        'normal',
        'high'
    );
}

function blogar_home_desc_meta_box_cb($post)
{
    wp_nonce_field('blogar_home_desc_save', 'blogar_home_desc_nonce');
    $desc = get_post_meta($post->ID, 'blogar_home_description', true);
    ?>
    <p style="color:#666;margin:0 0 8px;font-size:13px;line-height:1.5;">
        <?php esc_html_e('Mô tả hiển thị trong vùng tiêu đề của trang Blog. Dùng làm fallback khi category được filter không có description riêng.', 'blogar'); ?>
    </p>
    <textarea name="blogar_home_description" rows="4"
        style="width:100%;box-sizing:border-box;font-size:14px;line-height:1.6;padding:8px 10px;border:1px solid #ddd;border-radius:4px;resize:vertical;"
        placeholder="<?php esc_attr_e('Nhập mô tả cho trang Blog...', 'blogar'); ?>"><?php echo esc_textarea($desc); ?></textarea>
    <?php
}

add_action('save_post_page', 'blogar_save_home_desc_meta');

function blogar_save_home_desc_meta($post_id)
{
    if (
        !isset($_POST['blogar_home_desc_nonce']) ||
        !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['blogar_home_desc_nonce'])), 'blogar_home_desc_save')
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // Chỉ lưu nếu đây là Posts Page
    if ((int) get_option('page_for_posts') !== $post_id) {
        return;
    }

    $desc = isset($_POST['blogar_home_description'])
        ? sanitize_textarea_field(wp_unslash($_POST['blogar_home_description']))
        : '';

    if (!empty($desc)) {
        update_post_meta($post_id, 'blogar_home_description', $desc);
    } else {
        delete_post_meta($post_id, 'blogar_home_description');
    }
}


// ================================================================
// HOME PAGE — CATEGORY FILTER (pre_get_posts)
// Cho phép ?cat=ID hoạt động trên trang Posts Page (is_home).
// ================================================================

add_action('pre_get_posts', 'blogar_home_category_filter');

function blogar_home_category_filter($query)
{
    if (is_admin() || !$query->is_main_query() || !$query->is_home()) {
        return;
    }

    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $cat_id = isset($_GET['cat']) ? absint($_GET['cat']) : 0;

    if ($cat_id > 0) {
        $query->set('cat', $cat_id);
    }
}


// ================================================================
// CONTENT FILTER — RESPONSIVE TABLE WRAPPER
// Wraps every <table> in the_content() with a scrollable div so
// wide tables don't overflow the content column on narrow screens.
// ================================================================

add_filter('the_content', 'blogar_wrap_tables');

function blogar_wrap_tables($content)
{
    if (!is_single() && !is_page()) {
        return $content;
    }

    $content = preg_replace(
        '/(<table[\s>])/i',
        '<div class="table-responsive">$1',
        $content
    );
    $content = str_replace('</table>', '</table></div>', $content);

    return $content;
}


// ================================================================
// SEO — COMMENT FORM: replace <h3> reply title with <div>
// WordPress default: <h3 id="reply-title" class="comment-reply-title">
// ================================================================

add_filter('comment_form_defaults', 'blogar_comment_form_heading_fix');

function blogar_comment_form_heading_fix($defaults)
{
    $defaults['title_reply_before'] = '<div id="reply-title" class="comment-reply-title">';
    $defaults['title_reply_after'] = '</div>';
    return $defaults;
}