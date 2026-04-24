<?php
/**
 * template-parts/sidebar.php — Blogar Theme
 *
 * Shared sidebar for: archive / search / author / single / page / page-contact.
 * Widget order + visibility controlled via Appearance › Blogar Settings › Sidebar.
 *
 * @param array $args {
 *   @type int    $exclude_post_id  Post ID to exclude from Popular Posts (single.php).
 *   @type string $extra_class      Extra CSS class on the <aside> (e.g. 'page-sidebar').
 * }
 */

if (!defined('ABSPATH')) {
    exit;
}

// ── Widget registry ───────────────────────────────────────────────
$_sb_all        = array('popular_posts', 'categories', 'newsletter', 'search', 'tags');
$_sb_default_on = array('popular_posts', 'categories', 'newsletter');

// ── Read + sanitize order ─────────────────────────────────────────
$_raw_order = get_option('blogar_sidebar_widget_order', '');
$_sb_order  = (!empty($_raw_order)) ? (array) json_decode($_raw_order, true) : $_sb_all;

$_sb_order = array_values(array_filter($_sb_order, function ($k) use ($_sb_all) {
    return in_array($k, $_sb_all, true);
}));
foreach ($_sb_all as $_k) {
    if (!in_array($_k, $_sb_order, true)) {
        $_sb_order[] = $_k;
    }
}

// ── Args ──────────────────────────────────────────────────────────
$_exclude_id  = isset($args['exclude_post_id']) ? (int) $args['exclude_post_id'] : 0;
$_extra_class = isset($args['extra_class']) ? ' ' . sanitize_html_class($args['extra_class']) : '';

// ── Settings ──────────────────────────────────────────────────────
$_pp_count   = max(1, (int) get_option('blogar_sidebar_popular_posts_count', 5));
$_cats_count = max(1, (int) get_option('blogar_sidebar_categories_count', 10));

// Newsletter feedback (reuses footer handler: ?newsletter=success/invalid)
$_nl_status = isset($_GET['newsletter']) ? sanitize_key($_GET['newsletter']) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>
<aside class="col-lg-4 col-md-12 col-12 order-2 order-lg-2 archive-sidebar<?php echo esc_attr($_extra_class); ?>"
    aria-label="<?php esc_attr_e('Sidebar', 'blogar'); ?>">

    <div class="archive-sidebar-inner">

        <?php foreach ($_sb_order as $_wk):
            $_on = (bool) get_option(
                'blogar_sidebar_' . $_wk . '_enabled',
                in_array($_wk, $_sb_default_on, true) ? 1 : 0
            );
            if (!$_on) continue;
        ?>

        <?php if ('popular_posts' === $_wk): ?>
        <!-- ① Popular Posts -->
        <div class="blogar-widget widget-popular-posts mt--30">
            <div class="widget-title"><?php esc_html_e('Popular Posts', 'blogar'); ?></div>
            <?php
            $_pp_query = array(
                'numberposts'         => $_pp_count,
                'post_status'         => 'publish',
                'orderby'             => 'comment_count',
                'order'               => 'DESC',
                'ignore_sticky_posts' => true,
            );
            if ($_exclude_id) {
                $_pp_query['post__not_in'] = array($_exclude_id);
            }
            $popular_posts = get_posts($_pp_query);
            foreach ($popular_posts as $pp):
                $pp_url   = get_permalink($pp->ID);
                $pp_thumb = blogar_thumbnail_url($pp->ID, 'blogar-thumb');
                $pp_alt   = blogar_thumbnail_alt($pp->ID);
                $pp_title = wp_trim_words($pp->post_title, 9, '...');
            ?>
            <div class="popular-post-item">
                <div class="popular-post-inner">
                    <div class="popular-post-thumb">
                        <a href="<?php echo esc_url($pp_url); ?>">
                            <img loading="lazy" decoding="async" width="104" height="83"
                                src="<?php echo esc_url($pp_thumb); ?>"
                                alt="<?php echo esc_attr($pp_alt); ?>">
                        </a>
                    </div>
                    <div class="popular-post-text">
                        <div class="popular-post-title">
                            <a href="<?php echo esc_url($pp_url); ?>"><?php echo esc_html($pp_title); ?></a>
                        </div>
                        <div class="popular-post-meta">
                            <time datetime="<?php echo esc_attr(get_the_date('c', $pp->ID)); ?>">
                                <?php echo esc_html(get_the_date('', $pp->ID)); ?>
                            </time>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>

        <?php elseif ('categories' === $_wk): ?>
        <!-- ② Categories -->
        <div class="blogar-widget widget-sidebar-cats mt--30">
            <div class="widget-title"><?php esc_html_e('Categories', 'blogar'); ?></div>
            <?php
            $sidebar_cats = get_categories(array(
                'hide_empty' => true,
                'orderby'    => 'count',
                'order'      => 'DESC',
                'number'     => $_cats_count,
            ));
            if ($sidebar_cats): ?>
            <ul class="sidebar-cat-list">
                <?php foreach ($sidebar_cats as $sc): ?>
                <li>
                    <a href="<?php echo esc_url(get_category_link($sc->term_id)); ?>">
                        <?php echo esc_html($sc->name); ?>
                    </a>
                    <span class="sidebar-cat-count"><?php echo (int) $sc->count; ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <?php elseif ('newsletter' === $_wk): ?>
        <!-- ③ Subscribe Newsletter -->
        <div class="blogar-widget widget-sidebar-newsletter mt--30">
            <div class="widget-title"><?php esc_html_e('Subscribe Newsletter', 'blogar'); ?></div>
            <div class="sidebar-newsletter-inner">
                <?php if ('success' === $_nl_status): ?>
                <div class="sidebar-nl-notice sidebar-nl-notice--ok" role="alert">
                    <?php esc_html_e('Thank you for subscribing!', 'blogar'); ?>
                </div>
                <?php elseif ('invalid' === $_nl_status): ?>
                <div class="sidebar-nl-notice sidebar-nl-notice--err" role="alert">
                    <?php esc_html_e('Please enter a valid email address.', 'blogar'); ?>
                </div>
                <?php endif; ?>
                <p class="sidebar-newsletter-desc">
                    <?php esc_html_e("Subscribe our newsletter for latest news & updates. Let's stay updated!", 'blogar'); ?>
                </p>
                <form class="sidebar-newsletter-form"
                    action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                    <?php wp_nonce_field('blogar_newsletter_nonce', '_wpnonce'); ?>
                    <input type="hidden" name="action" value="blogar_newsletter">
                    <div class="form-group">
                        <input type="text" name="FNAME"
                            placeholder="<?php esc_attr_e('Your name...', 'blogar'); ?>">
                    </div>
                    <div class="form-group">
                        <input type="email" name="blogar_nl_email"
                            placeholder="<?php esc_attr_e('Your email...', 'blogar'); ?>" required>
                    </div>
                    <div class="form-submit">
                        <button type="submit" class="sidebar-newsletter-btn">
                            <?php esc_html_e('Subscribe', 'blogar'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <?php elseif ('search' === $_wk): ?>
        <!-- ④ Search -->
        <div class="blogar-widget widget-sidebar-search mt--30">
            <div class="widget-title"><?php esc_html_e('Search', 'blogar'); ?></div>
            <form action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search"
                class="sidebar-search-form">
                <div class="sidebar-search-inner">
                    <input type="search" name="s"
                        placeholder="<?php esc_attr_e('Search...', 'blogar'); ?>"
                        value="<?php echo esc_attr(get_search_query()); ?>"
                        aria-label="<?php esc_attr_e('Search', 'blogar'); ?>">
                    <button type="submit" aria-label="<?php esc_attr_e('Submit search', 'blogar'); ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="M21 21l-4.35-4.35"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <?php elseif ('tags' === $_wk): ?>
        <!-- ⑤ Tags -->
        <div class="blogar-widget widget-sidebar-tags mt--30">
            <div class="widget-title"><?php esc_html_e('All Tags', 'blogar'); ?></div>
            <div class="sidebar-tagcloud">
                <?php
                wp_tag_cloud(array(
                    'smallest' => 13,
                    'largest'  => 13,
                    'unit'     => 'px',
                    'number'   => 20,
                    'format'   => 'flat',
                    'orderby'  => 'count',
                    'order'    => 'DESC',
                ));
                ?>
            </div>
        </div>

        <?php endif; ?>

        <?php endforeach; ?>

    </div><!-- .archive-sidebar-inner -->

</aside>
