<?php
/**
 * 404 Error Page — Blogar
 * Standalone 100vh template — no header/footer nav.
 * Admin settings: Appearance → Blogar Settings → 404 Page
 */

if (!defined('ABSPATH')) {
    exit;
}

// ── Logo ─────────────────────────────────────────────────────────
$logo_id = get_theme_mod('custom_logo');
$logo_dark = $logo_id
    ? wp_get_attachment_image_url($logo_id, 'full')
    : get_template_directory_uri() . '/images/logo/logo.png';
$blog_name = get_bloginfo('name');

// ── 404 copy from admin ─────────────────────────────────────────
$heading = get_option('blogar_404_heading', __('Oops! Trang không tìm thấy', 'blogar'));
$sub = get_option('blogar_404_sub', __('Trang bạn đang tìm có thể đã bị xóa hoặc đường dẫn thay đổi. Hãy thử tìm kiếm hoặc chọn chủ đề bên dưới.', 'blogar'));

// ── CTA categories/pages ─────────────────────────────────────────
// Mỗi slot lưu:
//   0   → Tự động (fallback)
//  -1   → Trang Blog (page_for_posts / home.php)
//  -2   → Trang Chủ (front page)
//  > 0  → term_id category cụ thể

$posts_page_id = (int) get_option('page_for_posts');

$cta_cats = [];

for ($i = 1; $i <= 4; $i++) {
    $slot_val = (int) get_option("blogar_404_cta_{$i}_cat", 0);

    if ($slot_val === -1) {
        // ── Trang Blog ──────────────────────────────────────────
        $label = $posts_page_id
            ? get_the_title($posts_page_id)
            : __('Blog', 'blogar');

        $link = $posts_page_id
            ? get_permalink($posts_page_id)
            : home_url('/');

        // Đếm tổng bài published
        $post_count = (int) wp_count_posts()->publish;

        $cta_cats[] = [
            'id' => -1,
            'name' => $label,
            'link' => $link,
            'count' => $post_count,
        ];

    } elseif ($slot_val === -2) {
        // ── Trang Chủ ───────────────────────────────────────────
        $front_id = (int) get_option('page_on_front');
        $label = $front_id
            ? get_the_title($front_id)
            : get_bloginfo('name');

        $cta_cats[] = [
            'id' => -2,
            'name' => $label,
            'link' => home_url('/'),
            'count' => 0,             // front page không có count bài
        ];

    } elseif ($slot_val > 0) {
        // ── Category cụ thể ────────────────────────────────────
        $cat = get_category($slot_val);
        if ($cat && !is_wp_error($cat)) {
            $cta_cats[] = [
                'id' => $cat->term_id,
                'name' => $cat->name,
                'link' => get_category_link($cat->term_id),
                'count' => $cat->count,
            ];
        }
        // nếu category không tồn tại → bỏ qua, fallback sẽ bù
    }
    // slot_val === 0 → bỏ qua, để fallback bù vào cuối
}

// ── Fallback: bù các slot còn thiếu bằng top categories ──────────
// Chỉ bù nếu chưa đủ 4 slot (không bù nếu admin đã chọn đủ)
if (count($cta_cats) < 4) {
    // Tập hợp các ID đã dùng (category ID dương) để tránh trùng
    $used_cat_ids = array_filter(
        array_column($cta_cats, 'id'),
        function ($id) {
            return $id > 0; }
    );

    $fallback = get_categories([
        'number' => 4,
        'orderby' => 'count',
        'order' => 'DESC',
        'hide_empty' => true,
        'exclude' => array_values($used_cat_ids),
    ]);

    foreach ($fallback as $cat) {
        if (count($cta_cats) >= 4)
            break;
        $cta_cats[] = [
            'id' => $cat->term_id,
            'name' => $cat->name,
            'link' => get_category_link($cat->term_id),
            'count' => $cat->count,
        ];
    }
}

// ── Card design (color + bg + icon cycling) ──────────────────────
$card_colors = ['#3858f6', '#d93e40', '#16a34a', '#ea7516'];
$card_bgs = [
    'rgba(56,88,246,0.08)',
    'rgba(217,62,64,0.08)',
    'rgba(22,163,74,0.08)',
    'rgba(234,117,22,0.08)',
];
$card_icons = [
    // Book / reading
    '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>',
    // Globe / world
    '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
    // Trending / chart
    '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>',
    // Video / media
    '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>',
];

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php esc_html_e('Page Not Found', 'blogar'); ?> — <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class('blogar-404-page'); ?>>
    <?php wp_body_open(); ?>

    <div class="b404-wrap">

        <!-- ── Top bar ──────────────────────────────────────────────── -->
        <header class="b404-bar">
            <a class="b404-logo" href="<?php echo esc_url(home_url('/')); ?>"
                aria-label="<?php echo esc_attr($blog_name); ?>">
                <img src="<?php echo esc_url($logo_dark); ?>" alt="<?php echo esc_attr($blog_name); ?>"
                    class="b404-logo__img">
            </a>
            <a class="b404-home-link" href="<?php echo esc_url(home_url('/')); ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                <span><?php esc_html_e('Trang chủ', 'blogar'); ?></span>
            </a>
        </header>

        <!-- ── Main ─────────────────────────────────────────────────── -->
        <main class="b404-main" role="main">

            <!-- Decorative background number -->
            <span class="b404-deco" aria-hidden="true">404</span>

            <div class="b404-content">

                <!-- Copy -->
                <h1 class="b404-heading"><?php echo esc_html($heading); ?></h1>
                <p class="b404-sub"><?php echo esc_html($sub); ?></p>

                <!-- Search -->
                <div class="b404-search-wrap">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>"
                        class="b404-search-form">
                        <label for="b404-s" class="screen-reader-text">
                            <?php esc_html_e('Tìm kiếm bài viết', 'blogar'); ?>
                        </label>
                        <div class="b404-search-inner">
                            <span class="b404-search-ico" aria-hidden="true">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                            </span>
                            <input id="b404-s" type="search" name="s"
                                placeholder="<?php esc_attr_e('Tìm kiếm bài viết...', 'blogar'); ?>"
                                value="<?php echo get_search_query(); ?>" autocomplete="off" autocorrect="off"
                                spellcheck="false">
                            <button type="submit" class="b404-search-btn">
                                <?php esc_html_e('Tìm kiếm', 'blogar'); ?>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- CTA Cards -->
                <?php if (!empty($cta_cats)): ?>
                    <p class="b404-cta-label"><?php esc_html_e('Khám phá theo chủ đề', 'blogar'); ?></p>
                    <div class="b404-cta-grid">
                        <?php foreach (array_slice($cta_cats, 0, 4) as $idx => $item):
                            $color = $card_colors[$idx % 4];
                            $bg = $card_bgs[$idx % 4];
                            $icon = $card_icons[$idx % 4];
                            ?>
                            <a href="<?php echo esc_url($item['link']); ?>" class="b404-cta-card"
                                style="--cta-color:<?php echo esc_attr($color); ?>;--cta-bg:<?php echo esc_attr($bg); ?>">
                                <span class="b404-cta-icon"><?php echo $icon; // SVG — safe, server-generated ?></span>
                                <span class="b404-cta-name"><?php echo esc_html($item['name']); ?></span>
                                <?php if ($item['count'] > 0): ?>
                                    <span class="b404-cta-count">
                                        <?php echo absint($item['count']); ?>             <?php esc_html_e('bài viết', 'blogar'); ?>
                                    </span>
                                <?php endif; ?>
                                <span class="b404-cta-arrow" aria-hidden="true">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12" />
                                        <polyline points="12 5 19 12 12 19" />
                                    </svg>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div><!-- .b404-content -->
        </main>

    </div><!-- .b404-wrap -->

    <?php wp_footer(); ?>
</body>

</html>