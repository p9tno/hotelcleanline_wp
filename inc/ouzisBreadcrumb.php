<?php
/**
 * Universal Breadcrumbs with Microdata (BreadcrumbList)
 * Supports:
 * - Home, Pages (hierarchy)
 * - Blog: /blog/
 * - Categories (hierarchy under /blog/)
 * - Posts (under /blog/{category-path}/{post}/)
 * - CPT single + CPT archive + taxonomy terms
 * - Author archives
 * - Date archives
 * - Search results
 * - Pagination (paged)
 * - 404
 */


                // oasis_breadcrumbs([
                //         'home_label' => 'Home',
                //         'blog_label' => 'Blog',
                //         'separator' => ' / ',
                // ]);

if (!defined('ABSPATH')) exit;

final class Oasis_Breadcrumbs {

    const BLOG_BASE = 'blog'; // must match your blog base

    /**
     * Render breadcrumbs HTML.
     *
     * @param array $args
     *  - 'home_label'  => string
     *  - 'blog_label'  => string
     *  - 'separator'   => string (plain text)
     *  - 'container'   => string tag
     *  - 'container_class' => string
     *  - 'show_current' => bool
     */
    public static function render(array $args = []) {
        $defaults = [
            'home_label'       => __('Home', 'oasis'),
            'blog_label'       => __('Blog', 'oasis'),
            'separator'        => ' / ',
            'container'        => 'nav',
            'container_class'  => 'breadcrumbs',
            'show_current'     => true,
        ];
        $args = array_merge($defaults, $args);

        // Do not output in admin / feeds
        if (is_admin() || is_feed()) return;

        $items = self::build_items($args);
        if (count($items) <= 1) return; // only Home

        $tag = tag_escape($args['container']);
        $class = esc_attr($args['container_class']);

        // Microdata wrapper
        echo '<' . $tag . ' class="' . $class . '" aria-label="Breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">';

        $pos = 1;
        $total = count($items);
        foreach ($items as $i => $item) {
            $is_last = ($i === $total - 1);

            echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';

            if (!empty($item['url']) && !$is_last) {
                echo '<a itemprop="item" href="' . esc_url($item['url']) . '">';
                echo '<span itemprop="name">' . esc_html($item['label']) . '</span>';
                echo '</a>';
            } else {
                // current / last crumb
                echo '<span itemprop="name">' . esc_html($item['label']) . '</span>';
            }

            echo '<meta itemprop="position" content="' . (int)$pos . '">';
            echo '</span>';

            if (!$is_last) {
                echo '<span class="breadcrumbs__sep" aria-hidden="true">' . esc_html($args['separator']) . '</span>';
            }

            $pos++;
        }

        // Pagination hint as plain text suffix (not as schema element)
        $paged = max(1, (int)get_query_var('paged'));
        if ($paged > 1) {
            echo '<span class="breadcrumbs__paged" aria-label="Page">' . esc_html(' (Page ' . $paged . ')') . '</span>';
        }

        echo '</' . $tag . '>';
    }

    /**
     * Build breadcrumb items array: [ ['label'=>..., 'url'=>...], ... ]
     */
    private static function build_items(array $args) {
        $items = [];

        // Home
        $items[] = ['label' => $args['home_label'], 'url' => home_url('/')];

        // Front page: stop
        if (is_front_page()) return $items;

        // Blog base page: try to resolve actual page assigned to posts (Settings -> Reading)
        $blog_page_id = (int)get_option('page_for_posts');
        $blog_url = $blog_page_id ? get_permalink($blog_page_id) : home_url('/' . self::BLOG_BASE . '/');
        $blog_label = $blog_page_id ? get_the_title($blog_page_id) : $args['blog_label'];

        // 404
        if (is_404()) {
            $items[] = ['label' => __('404 Not Found', 'oasis'), 'url' => ''];
            return $items;
        }

        // Search
        if (is_search()) {
            $items[] = ['label' => sprintf(__('Search: %s', 'oasis'), get_search_query()), 'url' => ''];
            return $items;
        }

        // Author
        if (is_author()) {
            $author = get_queried_object();
            $items[] = ['label' => __('Authors', 'oasis'), 'url' => home_url('/author/')]; // optional landing
            $items[] = ['label' => $author ? $author->display_name : __('Author', 'oasis'), 'url' => ''];
            return $items;
        }

        // Date archives
        if (is_date()) {
            $year  = get_query_var('year');
            $month = get_query_var('monthnum');
            $day   = get_query_var('day');

            $items[] = ['label' => __('Archives', 'oasis'), 'url' => home_url('/archives/')]; // optional landing

            if ($year) {
                $items[] = ['label' => (string)$year, 'url' => get_year_link($year)];
            }
            if ($month) {
                $items[] = ['label' => date_i18n('F', mktime(0,0,0,$month,1,(int)$year)), 'url' => get_month_link($year, $month)];
            }
            if ($day) {
                $items[] = ['label' => (string)$day, 'url' => ''];
            }
            return $items;
        }

        // Taxonomy archives (category, tag, custom tax)
        if (is_category() || is_tag() || is_tax()) {
            $term = get_queried_object();

            if ($term && !is_wp_error($term)) {

                // Blog categories: Home / Blog / (parents) / Category
                if ($term->taxonomy === 'category') {
                    $items[] = ['label' => $blog_label, 'url' => $blog_url];
                    $items = array_merge($items, self::term_ancestors($term, true));
                    $items[] = ['label' => single_term_title('', false), 'url' => ''];
                    return $items;
                }

                // Projects taxonomy: Home / Projects(Page) / (parents) / Term
                if ($term->taxonomy === 'project-category') {
                    $projects_page_id = 6739;
                    $projects_url = get_permalink($projects_page_id);
                    $projects_label =  'Projects'; //get_the_title($projects_page_id) ?:

                    $items[] = ['label' => $projects_label, 'url' => $projects_url];
                    $items = array_merge($items, self::term_ancestors($term, true));
                    $items[] = ['label' => SCF::get_term_meta( $term->term_id, 'project-category', 'projects_category_h1' ) , 'url' => ''];
                    return $items;
                }

                // ADU plans taxonomy: Home / Adu plans(Page) / (parents) / Term
                if ($term->taxonomy === 'adu-plans-cat') {
                    $adu_page_id = 6741;
                    $adu_url = get_permalink($adu_page_id);
                    $adu_label = get_the_title($adu_page_id) ?: 'Adu plans';

                    $items[] = ['label' => $adu_label, 'url' => $adu_url];
                    $items = array_merge($items, self::term_ancestors($term, true));
                    $items[] = ['label' => single_term_title('', false), 'url' => ''];
                    return $items;
                }

                // Other taxonomies: try to infer context by attached CPT archive, then (parents) / Term
                $items = array_merge($items, self::taxonomy_context_chain($term));
                $items[] = ['label' => single_term_title('', false), 'url' => ''];
            }

            return $items;
        }

        // Posts index (blog base)
        if (is_home()) {
            $items[] = ['label' => $blog_label, 'url' => ''];
            return $items;
        }

        // Singular (page, post, cpt)
        if (is_singular()) {
            $post = get_queried_object();
            if (!$post) return $items;

            $ptype = get_post_type($post);
            $ptype_obj = get_post_type_object($ptype);

            // Pages: include parent hierarchy
            if ($ptype === 'page') {
                $items = array_merge($items, self::page_ancestors($post->ID));



                // change blog page label
                if($post->ID === 145) {
                    $items[] = ['label' => 'Blog', 'url' => ''];
                }
                elseif ($post->ID === 6739){
                    $items[] = ['label' => 'Projects', 'url' => ''];
                }else{

                    // default page label
                    $items[] = ['label' => get_the_title($post), 'url' => ''];
                }

                return $items;
            }

            // Standard blog posts: Home -> Blog -> Category chain -> Post
            if ($ptype === 'post') {
                $items[] = ['label' => $blog_label, 'url' => $blog_url];

                $primary_cat = self::post_primary_category($post->ID);
                if ($primary_cat) {
                    $items = array_merge($items, self::term_ancestors($primary_cat, true));
                    $items[] = ['label' => $primary_cat->name, 'url' => get_category_link($primary_cat)];
                }

                $items[] = ['label' => get_the_title($post), 'url' => ''];
                return $items;
            }

            // CPT: Home -> CPT archive (if exists) -> term chain (main taxonomy if any) -> single
            // CPT / Custom post types
            if ($ptype_obj) {

                /**
                 * 1) Projects single: Home / Projects(Page) / project-category chain / Post
                 * NOTE: post_type name must match your real CPT name in WP.
                 * If your CPT name differs, replace 'projects' accordingly.
                 */
                if ($ptype === 'projects') {
                    $projects_page_id = 6739;
                    $projects_url   = get_permalink($projects_page_id);
                    $projects_label =  'Projects'; //get_the_title($projects_page_id) ?:

                    $items[] = ['label' => $projects_label, 'url' => $projects_url];

                    // term chain from project-category (full hierarchy)
                    $terms = get_the_terms($post->ID, 'project-category');
                    if (!empty($terms) && !is_wp_error($terms)) {
                        // choose deepest term (most specific)
                        $best = null; $best_depth = -1;
                        foreach ($terms as $t) {
                            $depth = count(get_ancestors($t->term_id, 'project-category'));
                            if ($depth > $best_depth) { $best = $t; $best_depth = $depth; }
                        }
                        if ($best) {
                            $items = array_merge($items, self::term_ancestors($best, true));
                            $items[] = ['label' =>  SCF::get_term_meta( $terms[0]->term_id, 'project-category', 'projects_category_h1' ), 'url' => get_term_link($best)];
                        }
                    }

                    $items[] = ['label' => wp_strip_all_tags(get_the_title($post)), 'url' => ''];
                    return $items;
                }

                /**
                 * 2) Adu plans single: Home / Adu plans(Page) / adu-plans-cat chain / Post
                 * Replace 'adu-plans' with your real CPT name if different.
                 */
                if ($ptype === 'adu-plans') {
                    $adu_page_id = 6741;
                    $adu_url   = get_permalink($adu_page_id);
                    $adu_label = get_the_title($adu_page_id) ?: 'Adu plans';

                    $items[] = ['label' => $adu_label, 'url' => $adu_url];

                    // term chain from adu-plans-cat (full hierarchy)
                    $terms = get_the_terms($post->ID, 'adu-plans-cat');
                    if (!empty($terms) && !is_wp_error($terms)) {
                        // choose deepest term (most specific)
                        $best = null; $best_depth = -1;
                        foreach ($terms as $t) {
                            $depth = count(get_ancestors($t->term_id, 'adu-plans-cat'));
                            if ($depth > $best_depth) { $best = $t; $best_depth = $depth; }
                        }
                        if ($best) {
                            $items = array_merge($items, self::term_ancestors($best, true));
                            $items[] = ['label' => $best->name, 'url' => get_term_link($best)];
                        }
                    }

                    $items[] = ['label' => get_the_title($post), 'url' => ''];
                    return $items;
                }

                /**
                 * 3) Default fallback (unchanged):
                 * Home -> CPT archive (if exists) -> best-effort term chain -> single
                 */
                if (!empty($ptype_obj->has_archive)) {
                    $items[] = ['label' => $ptype_obj->labels->name, 'url' => get_post_type_archive_link($ptype)];
                } else {
                    $items[] = ['label' => $ptype_obj->labels->name, 'url' => ''];
                }

                $tax_chain = self::cpt_term_chain($post->ID, $ptype);
                if ($tax_chain) {
                    $items = array_merge($items, $tax_chain);
                }

                $items[] = ['label' => get_the_title($post), 'url' => ''];
                return $items;
            }
        }

        // Post type archive
        if (is_post_type_archive()) {
            $ptype = get_query_var('post_type');
            if (is_array($ptype)) $ptype = reset($ptype);
            $obj = $ptype ? get_post_type_object($ptype) : null;
            if ($obj) {
                $items[] = ['label' => $obj->labels->name, 'url' => ''];
            }
            return $items;
        }

        // Fallback: title
        $items[] = ['label' => wp_get_document_title(), 'url' => ''];
        return $items;
    }

    /** Ancestors for pages */
    private static function page_ancestors($page_id) {
        $crumbs = [];
        $parents = array_reverse(get_post_ancestors($page_id));
        foreach ($parents as $pid) {
            $crumbs[] = ['label' => get_the_title($pid), 'url' => get_permalink($pid)];
        }
        return $crumbs;
    }

    /**
     * Term ancestors chain.
     * @param WP_Term $term
     * @param bool $include_links Whether to include urls for ancestors
     */
    private static function term_ancestors($term, $include_links = true) {
        $crumbs = [];
        if (!$term || is_wp_error($term)) return $crumbs;

        $anc = array_reverse(get_ancestors($term->term_id, $term->taxonomy));
        foreach ($anc as $aid) {
            $t = get_term($aid, $term->taxonomy);
            if ($t && !is_wp_error($t)) {
                $crumbs[] = [
                    'label' => $t->name,
                    'url'   => $include_links ? get_term_link($t) : ''
                ];
            }
        }
        return $crumbs;
    }

    /** Best-effort: CPT taxonomy context */
    private static function taxonomy_context_chain($term) {
        $crumbs = [];
        // If taxonomy bound to some post types that have archive: include first
        $tax = get_taxonomy($term->taxonomy);
        if ($tax && !empty($tax->object_type) && is_array($tax->object_type)) {
            foreach ($tax->object_type as $ptype) {
                $obj = get_post_type_object($ptype);
                if ($obj && !empty($obj->has_archive)) {
                    $crumbs[] = ['label' => $obj->labels->name, 'url' => get_post_type_archive_link($ptype)];
                    break;
                }
            }
        }
        // add ancestors for hierarchical tax
        if ($tax && $tax->hierarchical) {
            $crumbs = array_merge($crumbs, self::term_ancestors($term, true));
        }
        return $crumbs;
    }

    /** Pick primary category for post (Yoast if present; else deepest) */
    private static function post_primary_category($post_id) {
        // Yoast primary term support
        if (class_exists('WPSEO_Primary_Term')) {
            $primary = new WPSEO_Primary_Term('category', $post_id);
            $primary_id = (int)$primary->get_primary_term();
            if ($primary_id) {
                $t = get_term($primary_id, 'category');
                if ($t && !is_wp_error($t)) return $t;
            }
        }

        $terms = get_the_category($post_id);
        if (empty($terms) || is_wp_error($terms)) return null;

        // choose deepest by ancestor count
        $best = null;
        $best_depth = -1;
        foreach ($terms as $t) {
            $depth = count(get_ancestors($t->term_id, 'category'));
            if ($depth > $best_depth) {
                $best = $t;
                $best_depth = $depth;
            }
        }
        return $best;
    }

    /**
     * CPT term chain (best effort):
     * - prefer hierarchical taxonomy
     * - choose deepest term
     */
    private static function cpt_term_chain($post_id, $post_type) {
        $taxes = get_object_taxonomies($post_type, 'objects');
        if (empty($taxes)) return [];

        // pick first hierarchical taxonomy
        $hier = null;
        foreach ($taxes as $tx) {
            if (!empty($tx->hierarchical)) { $hier = $tx; break; }
        }
        if (!$hier) return [];

        $terms = get_the_terms($post_id, $hier->name);
        if (empty($terms) || is_wp_error($terms)) return [];

        // choose deepest
        $best = null;
        $best_depth = -1;
        foreach ($terms as $t) {
            $depth = count(get_ancestors($t->term_id, $hier->name));
            if ($depth > $best_depth) { $best = $t; $best_depth = $depth; }
        }
        if (!$best) return [];

        $crumbs = [];
        $crumbs = array_merge($crumbs, self::term_ancestors($best, true));
        $crumbs[] = ['label' => $best->name, 'url' => get_term_link($best)];
        return $crumbs;
    }
}

/**
 * Template helper.
 * Usage: <?php oasis_breadcrumbs(); ?>
 */
function oasis_breadcrumbs($args = []) {
    Oasis_Breadcrumbs::render($args);
}
