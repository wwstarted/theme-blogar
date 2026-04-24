<?php

if (!defined('ABSPATH')) {
    exit;
}

/* =============================================================================
   WALKER CLASS
   ============================================================================= */

class Blogar_Mega_Menu_Walker extends Walker_Nav_Menu
{

    /** @var int[] IDs của các mega menu items */
    private $mega_item_ids = array();

    /** @var array<int,object> Toàn bộ nav items, keyed by ID */
    private $all_items = array();

    /**
     * Depth của mega item đang được process (-1 = không trong mega subtree).
     * Dùng để suppress children của mega items đúng cách.
     */
    private $mega_depth = -1;

    /* ------------------------------------------------------------------
       Override walk() để collect toàn bộ items trước khi render.
       Cần thiết để get_nav_children() hoạt động trong start_el().
       ------------------------------------------------------------------ */
    public function walk($elements, $max_depth, ...$args)
    {
        foreach ($elements as $e) {
            if (isset($e->ID)) {
                $this->all_items[(int) $e->ID] = $e;
            }
        }
        return parent::walk($elements, $max_depth, ...$args);
    }

    /**
     * Lấy direct nav children của một item theo parent ID.
     */
    private function get_nav_children($parent_id)
    {
        $children = array();
        foreach ($this->all_items as $item) {
            if ((int) $item->menu_item_parent === (int) $parent_id) {
                $children[] = $item;
            }
        }
        return $children;
    }

    /* ------------------------------------------------------------------
       start_el
       ------------------------------------------------------------------ */
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        $item = $data_object;

        /* Suppress: nếu đang trong mega subtree (child items) → bỏ qua */
        if ($this->mega_depth >= 0 && $depth > $this->mega_depth) {
            return;
        }

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $is_mega1 = in_array('blogar-mega-1', $classes, true);
        $is_mega2 = in_array('blogar-mega-2', $classes, true);

        /* Đánh dấu bắt đầu mega subtree */
        if ($is_mega1 || $is_mega2) {
            $this->mega_item_ids[] = (int) $item->ID;
            $this->mega_depth = $depth;
        }

        /* Gỡ mega class khỏi output HTML */
        $classes = array_values(array_filter($classes, function ($c) {
            return !in_array($c, array('blogar-mega-1', 'blogar-mega-2'), true);
        }));

        if ($is_mega1 || $is_mega2) {
            $classes[] = 'blogar-has-mega';
            $classes[] = $is_mega1 ? 'blogar-mega-type-1' : 'blogar-mega-type-2';
        }

        $class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $li_class = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $li_id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $li_id = $li_id ? ' id="' . esc_attr($li_id) . '"' : '';

        $output .= '<li' . $li_id . $li_class . '>';

        /* ── Link attributes ──────────────────────────────────────── */
        $atts = array(
            'href' => !empty($item->url) ? $item->url : '#',
            'title' => !empty($item->attr_title) ? $item->attr_title : '',
            'target' => !empty($item->target) ? $item->target : '',
            'rel' => !empty($item->xfn) ? $item->xfn : '',
        );

        if ($is_mega1 || $is_mega2) {
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        $attr_string = '';
        foreach ($atts as $attr => $value) {
            if ('' !== $value) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attr_string .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        $before = !empty($args->before) ? $args->before : '';
        $after = !empty($args->after) ? $args->after : '';
        $lb = !empty($args->link_before) ? $args->link_before : '';
        $la = !empty($args->link_after) ? $args->link_after : '';

        $el = $before;
        $el .= '<a' . $attr_string . '>';
        $el .= $lb . $title . $la;

        /* Chevron cho mega items */
        if ($is_mega1 || $is_mega2) {
            $el .= '<svg class="mega-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"'
                . ' stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"'
                . ' aria-hidden="true" width="10" height="10">'
                . '<path d="M6 9l6 6 6-6"/></svg>';
        }

        $el .= '</a>';
        $el .= $after;

        /* ── Inject mega panels ───────────────────────────────────── */
        if ($is_mega1) {
            $nav_children = $this->get_nav_children($item->ID);
            $el .= blogar_mega_mobile_panel($item, $nav_children);
            $el .= blogar_mega_panel_type1($item, $nav_children);
        } elseif ($is_mega2) {
            $nav_children = $this->get_nav_children($item->ID);
            $el .= blogar_mega_mobile_panel($item, $nav_children);
            $el .= blogar_mega_panel_type2($item);
        }

        $output .= apply_filters('walker_nav_menu_start_el', $el, $item, $depth, $args);
    }

    /* ------------------------------------------------------------------
       end_el — reset mega_depth sau khi đóng mega item
       ------------------------------------------------------------------ */
    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        $item = $data_object;

        /* Suppress children của mega */
        if ($this->mega_depth >= 0 && $depth > $this->mega_depth) {
            return;
        }

        /* Reset tracking khi đóng mega item */
        if (
            $this->mega_depth >= 0 &&
            $depth === $this->mega_depth &&
            in_array((int) $item->ID, $this->mega_item_ids, true)
        ) {
            $this->mega_depth = -1;
        }

        parent::end_el($output, $data_object, $depth, $args);
    }

    /* ------------------------------------------------------------------
       start_lvl / end_lvl — suppress <ul> wrapper của mega subtree
       $depth = depth của parent item (không phải children)
       ------------------------------------------------------------------ */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        /* Nếu đang ở trong mega subtree (parent là mega) → suppress */
        if ($this->mega_depth >= 0 && $depth >= $this->mega_depth) {
            return;
        }
        parent::start_lvl($output, $depth, $args);
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        if ($this->mega_depth >= 0 && $depth >= $this->mega_depth) {
            return;
        }
        parent::end_lvl($output, $depth, $args);
    }
}

/* =============================================================================
   MOBILE PANEL
   Flat accordion cho off-canvas.
   FIX 4: Nhận $nav_children để handle Custom Link parent.
   ============================================================================= */

function blogar_mega_mobile_panel($item, $nav_children = array())
{
    $links = array();

    if ($item->object === 'category') {
        $cat_id = (int) $item->object_id;
        $links[] = array(
            'url' => get_category_link($cat_id),
            'label' => sprintf(__('All %s', 'blogar'), esc_html($item->title)),
            'is_all' => true,
        );
        $children = get_categories(array(
            'parent' => $cat_id,
            'hide_empty' => true,
            'number' => 8,
            'orderby' => 'name',
            'order' => 'ASC',
        ));
        foreach ($children as $c) {
            $links[] = array(
                'url' => get_category_link($c->term_id),
                'label' => $c->name,
                'is_all' => false,
            );
        }
    } else {
        /* Custom Link: dùng nav_children */
        foreach ($nav_children as $nc) {
            if ($nc->object === 'category') {
                $links[] = array(
                    'url' => get_category_link((int) $nc->object_id),
                    'label' => $nc->title,
                    'is_all' => false,
                );
            } elseif (!empty($nc->url) && $nc->url !== '#') {
                $links[] = array(
                    'url' => $nc->url,
                    'label' => $nc->title,
                    'is_all' => false,
                );
            }
        }
    }

    if (empty($links)) {
        return '';
    }

    ob_start();
    ?>
<button class="mega-mobile-toggle" type="button" aria-expanded="false"
    aria-label="<?php echo esc_attr(sprintf(__('Mở rộng %s', 'blogar'), $item->title)); ?>">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
        stroke-linejoin="round" aria-hidden="true" width="12" height="12">
        <path d="M6 9l6 6 6-6" />
    </svg>
</button>
<div class="mega-mobile-panel">
    <?php foreach ($links as $link): ?>
    <a class="mega-mobile-link<?php echo $link['is_all'] ? ' mega-mobile-all' : ''; ?>"
        href="<?php echo esc_url($link['url']); ?>">
        <?php echo esc_html($link['label']); ?>
    </a>
    <?php endforeach; ?>
</div>
<?php
    return ob_get_clean();
}

/* =============================================================================
   TYPE 1 PANEL
   FIX 4: Hỗ trợ cả hai trường hợp:
     A) item->object = 'category' → lấy child categories từ WP taxonomy
     B) item->object = 'custom'   → dùng $nav_children (child menu items) làm tabs
   ============================================================================= */

function blogar_mega_panel_type1($item, $nav_children = array())
{
    $tabs = array();

    if ($item->object === 'category') {
        /* ── Case A: Category parent ─────────────────────────────── */
        $cat_id = (int) $item->object_id;
        $parent_cat = get_category($cat_id);
        if (!$parent_cat || is_wp_error($parent_cat)) {
            return '';
        }

        $child_cats = get_categories(array(
            'parent' => $cat_id,
            'hide_empty' => true,
            'number' => 6,
            'orderby' => 'name',
            'order' => 'ASC',
        ));

        /* Tab "All": query posts từ parent category */
        $tabs[] = array(
            'label' => __('All', 'blogar'),
            'url' => get_category_link($cat_id),
            'panel_id' => 'bmeg-all-' . $cat_id . '-' . $item->ID,
            'query' => array('category' => $cat_id),
            'active' => true,
        );

        foreach ($child_cats as $cc) {
            $tabs[] = array(
                'label' => $cc->name,
                'url' => get_category_link($cc->term_id),
                'panel_id' => 'bmeg-cat-' . $cc->term_id . '-' . $item->ID,
                'query' => array('category' => $cc->term_id),
                'active' => false,
            );
        }

    } else {
        /* ── Case B: Custom Link parent, dùng nav_children làm tabs ─
           Ví dụ: Life Style (Custom Link) → Samsung, Product, Creative (Category)
        */
        if (empty($nav_children)) {
            return '';
        }

        $all_cat_ids = array();
        $child_tabs = array();

        foreach ($nav_children as $nc) {
            if ($nc->object !== 'category') {
                continue;
            }
            $nc_cat_id = (int) $nc->object_id;
            $nc_cat = get_category($nc_cat_id);
            if (!$nc_cat || is_wp_error($nc_cat)) {
                continue;
            }
            $all_cat_ids[] = $nc_cat_id;
            $child_tabs[] = array(
                'label' => $nc_cat->name,
                'url' => get_category_link($nc_cat_id),
                'panel_id' => 'bmeg-cat-' . $nc_cat_id . '-' . $item->ID,
                'query' => array('category' => $nc_cat_id),
                'active' => false,
            );
        }

        if (empty($child_tabs)) {
            return '';
        }

        /* Tab "All": posts từ tất cả child categories */
        $all_url = (!empty($item->url) && $item->url !== '#')
            ? $item->url
            : $child_tabs[0]['url'];

        $tabs[] = array(
            'label' => __('All', 'blogar'),
            'url' => $all_url,
            'panel_id' => 'bmeg-all-' . $item->ID,
            'query' => array('category__in' => $all_cat_ids),
            'active' => true,
        );

        foreach ($child_tabs as $ct) {
            $tabs[] = $ct;
        }
    }

    if (empty($tabs)) {
        return '';
    }

    /* ── Render panel ─────────────────────────────────────────── */
    ob_start();
    ?>
<div class="blogar-mega-panel mega-panel-type-1" role="region"
    aria-label="<?php echo esc_attr($item->title . ' ' . __('mega menu', 'blogar')); ?>">
    <div class="mega-panel-inner">

        <!-- LEFT: tab list -->
        <nav class="mega-cats-sidebar" aria-label="<?php esc_attr_e('Lọc theo danh mục', 'blogar'); ?>">
            <?php foreach ($tabs as $tab): ?>
            <a class="mega-cat-tab<?php echo $tab['active'] ? ' is-active' : ''; ?>"
                href="<?php echo esc_url($tab['url']); ?>" data-mega-panel="<?php echo esc_attr($tab['panel_id']); ?>">
                <?php echo esc_html($tab['label']); ?>
            </a>
            <?php endforeach; ?>
        </nav>

        <!-- RIGHT: post panels -->
        <div class="mega-posts-area">
            <?php foreach ($tabs as $tab):
                    $q = array_merge(
                        array(
                            'numberposts' => 4,
                            'post_status' => 'publish',
                            'meta_key' => '_thumbnail_id',
                            'no_found_rows' => true,
                            'update_post_meta_cache' => false,
                            'update_post_term_cache' => true,
                        ),
                        $tab['query']
                    );
                    $posts = get_posts($q);
                    ?>
            <div class="mega-posts-panel<?php echo $tab['active'] ? ' is-active' : ''; ?>"
                id="<?php echo esc_attr($tab['panel_id']); ?>">
                <?php
                        foreach ($posts as $p) {
                            blogar_mega_post_card($p);
                        }
                        wp_reset_postdata();
                        ?>
            </div>
            <?php endforeach; ?>
        </div>

    </div><!-- .mega-panel-inner -->
</div><!-- .blogar-mega-panel.mega-panel-type-1 -->
<?php
    return ob_get_clean();
}

/* =============================================================================
   TYPE 2 PANEL
   Post grid 4 cột, không sidebar.
   ============================================================================= */

function blogar_mega_panel_type2($item)
{
    $cat_id = ($item->object === 'category') ? (int) $item->object_id : 0;

    $query_args = array(
        'numberposts' => 4,
        'post_status' => 'publish',
        'meta_key' => '_thumbnail_id',
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => true,
    );

    if ($cat_id) {
        $query_args['category'] = $cat_id;
    }

    $posts = get_posts($query_args);
    if (empty($posts)) {
        return '';
    }

    ob_start();
    ?>
<div class="blogar-mega-panel mega-panel-type-2" role="region">
    <div class="mega-panel-inner">
        <div class="mega-posts-grid">
            <?php
                foreach ($posts as $p) {
                    blogar_mega_post_card($p);
                }
                wp_reset_postdata();
                ?>
        </div>
    </div>
</div>
<?php
    return ob_get_clean();
}

/* =============================================================================
   POST CARD (dùng chung cho cả hai type)
   ============================================================================= */

function blogar_mega_post_card($post)
{
    $id = $post->ID;
    $url = get_permalink($id);
    $title = wp_trim_words(get_the_title($id), 7, '…');
    $date = get_the_date('M j, Y', $id);
    $thumb = blogar_thumbnail_url($id, 'blogar-featured');
    $alt = blogar_thumbnail_alt($id);
    $cats = get_the_category($id);
    ?>
<div class="mega-post-card">

    <a class="mega-post-thumb-link" href="<?php echo esc_url($url); ?>">
        <?php if (!empty($cats)): ?>
        <span class="mega-post-cat-badge">
            <?php echo esc_html($cats[0]->name); ?>
        </span>
        <?php endif; ?>
        <img loading="lazy" decoding="async" width="263" height="175" src="<?php echo esc_url($thumb); ?>"
            alt="<?php echo esc_attr($alt); ?>">
    </a>

    <div class="mega-post-body">
        <p class="mega-post-title">
            <a href="<?php echo esc_url($url); ?>"><?php echo esc_html($title); ?></a>
        </p>
        <time class="mega-post-date" datetime="<?php echo esc_attr(get_the_date('c', $id)); ?>">
            <?php echo esc_html($date); ?>
        </time>
    </div>

</div>
<?php
}