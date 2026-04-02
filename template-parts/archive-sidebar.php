<?php
/**
 * Shared sidebar UI for archive/search/single.
 *
 * @package blogar
 */

if (!defined('ABSPATH')) {
    exit;
}

$svg_fb = isset($args['svg_fb']) ? $args['svg_fb'] : '';
$svg_tw = isset($args['svg_tw']) ? $args['svg_tw'] : '';
$svg_li = isset($args['svg_li']) ? $args['svg_li'] : '';
$svg_ig = isset($args['svg_ig']) ? $args['svg_ig'] : '';
$svg_pi = isset($args['svg_pi']) ? $args['svg_pi'] : '';
$svg_search = isset($args['svg_search']) ? $args['svg_search'] : '';
$img = isset($args['img']) ? $args['img'] : (get_template_directory_uri() . '/images/frontpage/');
?>
<aside class="col-lg-4 col-md-12 col-12 order-2 order-lg-2 archive-sidebar"
    aria-label="<?php esc_attr_e('Sidebar', 'blogar'); ?>">

    <div class="search-1 axil-single-widget widget_search mt--30">
        <h5 class="widget-title"><?php esc_html_e('Search', 'blogar'); ?></h5>
        <div class="inner">
            <form action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search" class="blog-search">
                <div class="axil-search form-group">
                    <button type="submit" class="search-button"
                        aria-label="<?php esc_attr_e('Search', 'blogar'); ?>">
                        <?php echo $svg_search; // phpcs:ignore WordPress.Security.EscapeOutput ?>
                    </button>
                    <input type="search" name="s" placeholder="<?php echo esc_attr__('Search ...', 'blogar'); ?>"
                        value="<?php echo esc_attr(get_search_query()); ?>">
                </div>
            </form>
        </div>
    </div>

    <div class="blogar_recent_post-1 axil-single-widget widget_blogar_recent_post mt--30">
        <h5 class="widget-title"><?php esc_html_e('Recent Post', 'blogar'); ?></h5>
        <?php
        $recent_posts = get_posts(
            array(
                'numberposts' => 3,
                'post_status' => 'publish',
            )
        );
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
        <?php endforeach; ?>
    </div>

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

    <div class="blogar_social_widget-1 axil-single-widget mt--30">
        <h5 class="widget-title"><?php esc_html_e('Stay In Touch', 'blogar'); ?></h5>
        <ul class="social-icon md-size justify-content-center">
            <li><a href="#" aria-label="<?php esc_attr_e('Facebook', 'blogar'); ?>"><?php echo $svg_fb; // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>
            <li><a href="#" aria-label="<?php esc_attr_e('Twitter', 'blogar'); ?>"><?php echo $svg_tw; // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>
            <li><a href="#" aria-label="<?php esc_attr_e('Instagram', 'blogar'); ?>"><?php echo $svg_ig; // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>
            <li><a href="#" aria-label="<?php esc_attr_e('Pinterest', 'blogar'); ?>"><?php echo $svg_pi; // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>
            <li><a href="#" aria-label="<?php esc_attr_e('LinkedIn', 'blogar'); ?>"><?php echo $svg_li; // phpcs:ignore WordPress.Security.EscapeOutput ?></a></li>
        </ul>
    </div>

    <div class="media_gallery-1 axil-single-widget widget_media_gallery mt--30">
        <h5 class="widget-title"><?php esc_html_e('Gallery', 'blogar'); ?></h5>
        <?php
        $gallery_posts = get_posts(
            array(
                'numberposts' => 6,
                'post_status' => 'publish',
                'meta_key' => '_thumbnail_id',
            )
        );
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
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="blogar_featured_posts-1 axil-single-widget widget_blogar_featured_posts mt--30">
        <h5 class="widget-title"><?php esc_html_e('Featured Videos', 'blogar'); ?></h5>
        <div class="video-post-wrapper">
            <?php
            $featured_posts = get_posts(
                array(
                    'numberposts' => 2,
                    'post_status' => 'publish',
                    'meta_key' => '_thumbnail_id',
                    'offset' => 3,
                )
            );
            foreach ($featured_posts as $fp):
                $fp_thumb = get_the_post_thumbnail_url($fp->ID, 'axil-tab-post-thumb');
                ?>
            <div class="content-block image-rounded mt--20">
                <div class="post-content">
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
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="tag_cloud-1 axil-single-widget widget_tag_cloud mt--30">
        <h5 class="widget-title"><?php esc_html_e('All Tags', 'blogar'); ?></h5>
        <div class="tagcloud">
            <?php
            wp_tag_cloud(
                array(
                    'smallest' => 8,
                    'largest' => 14,
                    'unit' => 'pt',
                    'number' => 10,
                    'format' => 'flat',
                )
            );
            ?>
        </div>
    </div>

    <div class="media_image-1 axil-single-widget widget_media_image mt--30">
        <a href="<?php echo esc_url(home_url('/')); ?>">
            <img loading="lazy" decoding="async" src="<?php echo esc_url($img . 'banner-03.png'); ?>"
                alt="<?php echo esc_attr(get_bloginfo('name')); ?>" style="max-width:100%;height:auto;">
        </a>
    </div>

</aside>
