<?php defined('CALIBREFX_URL') OR exit();
/**
 * CalibreFx Framework
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package     CalibreFx
 * @author      CalibreFx Team
 * @authorlink  http://www.calibrefx.com
 * @copyright   Copyright (c) 2012-2013, CalibreWorks. (http://www.calibreworks.com/)
 * @license     GNU GPL v2
 * @link        http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This define the framework constants
 *
 * @package CalibreFx
 */
/**
 * Calibrefx Breadcrumb Class
 *
 * @package		Calibrefx
 * @subpackage          Library
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

class CFX_Breadcrumb {

    /**
     * Settings array, a merge of provided values and defaults. Private.
     *
     * @var array
     */
    var $args = array();

    /**
     * Cache get_option call. Private.
     *
     * @var string
     */
    var $on_front;

    /**
     * Constructor. Set up cacheable values and settings.
     *
     * @param array $args
     */
    function __construct() {
        $this->on_front = get_option('show_on_front');

        /** Default arguments * */
        $this->args = array(
            'home' => __('Home', 'calibrefx'),
            'sep' => '',
            'list_sep' => '',
            'container_open' => '<div class="breadcrumb-container" xmlns:v="http://rdf.data-vocabulary.org/#">',
            'container_close' => '</div>',
            'prefix' => '<ol class="breadcrumb" itemprop="breadcrumb">',
            'suffix' => '</ol>',
            'heirarchial_attachments' => true,
            'heirarchial_categories' => true,
            'display' => true,
            'labels' => array(
                'prefix' => __('You are here: ', 'calibrefx'),
                'author' => __('Archives for ', 'calibrefx'),
                'category' => __('Archives for ', 'calibrefx'),
                'tag' => __('Archives for ', 'calibrefx'),
                'date' => __('Archives for ', 'calibrefx'),
                'search' => __('Search for ', 'calibrefx'),
                'tax' => __('Archives for ', 'calibrefx'),
                'post_type' => __('Archives for ', 'calibrefx'),
                '404' => __('Not found: ', 'calibrefx')
            )
        );
    }

    /**
     * Return the final completed breadcrumb in markup wrapper. Public.
     *
     * @return string HTML markup
     */
    function get_output($args = array()) {
        
        /** Merge and Filter user and default arguments * */
        $this->args = apply_filters('calibrefx_breadcrumb_args', wp_parse_args($args, $this->args));
        
        return $this->args['container_open'] . '<span class="breadcrumb-label">' . $this->args['labels']['prefix'] . '</span>' . $this->args['prefix'] . $this->build_crumbs() . $this->args['suffix'] . $this->args['container_close'];
    }

    /**
     * Echo the final completed breadcrumb in markup wrapper. Public.
     *
     * @return string HTML markup
     */
    function output($args = array()) {

        echo $this->get_output($args);
    }

    /**
     * Return home breadcrumb. Private.
     *
     * Default is Home, linked on all occasions except when is_home() is true.
     *
     * @return string HTML markup
     */
    function get_home_crumb() {

        $url = 'page' == $this->on_front ? get_permalink(get_option('page_on_front')) : trailingslashit(home_url());
        $crumb = ( is_home() && is_front_page() ) ? $this->args['home'] : $this->get_breadcrumb_link($url, sprintf(__('View %s', 'calibrefx'), $this->args['home']), $this->args['home']);

        return apply_filters('calibrefx_home_crumb', '<li typeof="v:Breadcrumb">'.$crumb.'</li>', $this->args);
    }

    /**
     * Return blog posts page breadcrumb. Private.
     *
     * Defaults to the home crumb (later removed as a duplicate). If using a
     * static front page, then the title of the Page is returned.
     *
     * @return string HTML markup
     */
    function get_blog_crumb() {

        $crumb = $this->get_home_crumb();
        if ('page' == $this->on_front)
            $crumb = '<li typeof="v:Breadcrumb">'.get_the_title(get_option('page_for_posts')).'</li>';

        return apply_filters('calibrefx_blog_crumb', $crumb, $this->args);
    }

    /**
     * Return search results page breadcrumb. Private.
     *
     * @return string HTML markup
     */
    function get_search_crumb() {

        $crumb = $this->args['labels']['search'] . '"' . esc_html(apply_filters('the_search_query', get_search_query())) . '"';

        return apply_filters('calibrefx_search_crumb', '<li typeof="v:Breadcrumb">'.$crumb.'</li>', $this->args);
    }

    /**
     * Return 404 (page not found) breadcrumb. Private.
     *
     * @return string HTML markup
     */
    function get_404_crumb() {

        global $wp_query;

        $crumb = $this->args['labels']['404'];

        return apply_filters('calibrefx_404_crumb', $crumb, $this->args);
    }

    /**
     * Return content page breadcrumb. Private.
     *
     * @global mixed $wp_query
     * @return string HTML markup
     */
    function get_page_crumb() {

        global $wp_query;

        if ('page' == $this->on_front && is_front_page()) {
            // Don't do anything - we're on the front page and we've already dealt with that elsewhere.
            $crumb = $this->get_home_crumb();
        } else {
            $post = $wp_query->get_queried_object();

            // If this is a top level Page, it's simple to output the breadcrumb
            if (0 == $post->post_parent) {
                $crumb = '<li typeof="v:Breadcrumb">'.get_the_title().'</li>';
            } else {
                if (isset($post->ancestors)) {
                    if (is_array($post->ancestors))
                        $ancestors = array_values($post->ancestors);
                    else
                        $ancestors = array($post->ancestors);
                } else {
                    $ancestors = array($post->post_parent);
                }

                $crumbs = array();
                foreach ($ancestors as $ancestor) {
                    $anchestor_link = $this->get_breadcrumb_link(
                                    get_permalink($ancestor), sprintf(__('View %s', 'calibrefx'), get_the_title($ancestor)), get_the_title($ancestor)
                            );
                    $anchestor_link = '<li typeof="v:Breadcrumb">'.$anchestor_link.'</li>';

                    array_unshift($crumbs, $anchestor_link);
                }

                // Add the current page title
                $crumbs[] = '<li typeof="v:Breadcrumb">'.get_the_title($post->ID).'</li>';

                $crumb = join($this->args['sep'], $crumbs);
            }
        }

        return apply_filters('calibrefx_page_crumb', $crumb, $this->args);
    }

    /**
     * Return archive breadcrumb. Private
     *
     * @global mixed $wp_query The page query object
     * @global mixed $wp_locale The locale object, used for getting the
     * auto-translated name of the month for month or day archives
     * @return string HTML markup
     * @todo Heirarchial, and multiple, cats and taxonomies
     * @todo redirect taxonomies to plural pages.
     */
    function get_archive_crumb() {

        global $wp_query, $wp_locale;

        if (is_category()) {
            $crumb = $this->args['labels']['category'] . $this->get_term_parents(get_query_var('cat'), 'category');
        } elseif (is_tag()) {
            $crumb = $this->args['labels']['tag'] . single_term_title('', false);
        } elseif (is_tax()) {
            $term = $wp_query->get_queried_object();
            $crumb = $this->args['labels']['tax'] . $this->get_term_parents($term->term_id, $term->taxonomy);
        } elseif (is_year()) {
            $crumb = $this->args['labels']['date'] . get_query_var('year');
        } elseif (is_month()) {
            $crumb = $this->get_breadcrumb_link(
                    get_year_link(get_query_var('year')), sprintf(__('View archives for %s', 'calibrefx'), get_query_var('year')), get_query_var('year'), $this->args['sep']
            );
            $crumb .= '<li typeof="v:Breadcrumb">' . $this->args['labels']['date'] . single_month_title('', false) . '</li>';
        } elseif (is_day()) {
            $crumb = $this->get_breadcrumb_link(
                    get_year_link(get_query_var('year')), sprintf(__('View archives for %s', 'calibrefx'), get_query_var('year')), get_query_var('year'), $this->args['sep']
            );
            $crumb .= '<li typeof="v:Breadcrumb">' . $this->get_breadcrumb_link(
                    get_month_link(get_query_var('year'), get_query_var('monthnum')), sprintf(__('View archives for %s %s', 'calibrefx'), $wp_locale->get_month(get_query_var('monthnum')), get_query_var('year')), $wp_locale->get_month(get_query_var('monthnum')), $this->args['sep']
            ) . '</li>';
            $crumb .= '<li typeof="v:Breadcrumb">' . $this->args['labels']['date'] . get_query_var('day') . date('S', mktime(0, 0, 0, 1, get_query_var('day'))) . '</li>';
        } elseif (is_author()) {
            $crumb = $this->args['labels']['author'] . esc_html($wp_query->queried_object->display_name);
        } elseif (is_post_type_archive()) {
            $crumb = $this->args['labels']['post_type'] . esc_html(post_type_archive_title('', false));
        }

        return apply_filters('calibrefx_archive_crumb', '<li typeof="v:Breadcrumb">'.$crumb.'</li>', $this->args);
    }

    /**
     * Get single breadcrumb, including any parent crumbs. Private.
     *
     * @global mixed $post Current post object
     * @return string HTML markup
     */
    function get_single_crumb() {

        global $post;

        if (is_attachment()) {
            $crumb = '';
            if ($this->args['heirarchial_attachments']) { // if showing attachment parent
                $attachment_parent = get_post($post->post_parent);
                $crumb = $this->get_breadcrumb_link(
                        get_permalink($post->post_parent), sprintf(__('View %s', 'calibrefx'), $attachment_parent->post_title), $attachment_parent->post_title
                );

                $crumb = '<li typeof="v:Breadcrumb">'.$crumb.'</li>'.$this->args['sep'];
            }
            $crumb .= '<li typeof="v:Breadcrumb">'.single_post_title('', false).'</li>';
        } elseif (is_singular('post')) {
            $categories = get_the_category($post->ID);

            if (1 == count($categories)) { // if in single category, show it, and any parent categories
                $crumb = '<li typeof="v:Breadcrumb">'.$this->get_term_parents($categories[0]->cat_ID, 'category', true).'</li>'. $this->args['sep'];
            }
            if (count($categories) > 1) {
                if (!$this->args['heirarchial_categories']) { // Don't show parent categories (unless the post happen to be explicitely in them)
                    foreach ($categories as $category) {
                        $crumbs[] = $this->get_breadcrumb_link(
                                get_category_link($category->term_id), sprintf(__('View all posts in %s', 'calibrefx'), $category->name), $category->name
                        );
                    }
                    $crumb = '<li typeof="v:Breadcrumb">'.(join($this->args['list_sep'], $crumbs)).'</li>'. $this->args['sep'];
                } else { // Show parent categories - see if one is marked as primary and try to use that.
                    $primary_category_id = get_post_meta($post->ID, '_category_permalink', true); // Support for sCategory Permalink plugin
                    if ($primary_category_id) {
                        $crumb = '<li typeof="v:Breadcrumb">'.$this->get_term_parents($primary_category_id, 'category', true).'</li>'. $this->args['sep'];
                    } else {
                        $crumb = '<li typeof="v:Breadcrumb">'.$this->get_term_parents($categories[0]->cat_ID, 'category', true).'</li>'. $this->args['sep'];
                    }
                }
            }
            $crumb .= '<li typeof="v:Breadcrumb">'.single_post_title('', false).'</li>';
        } else {
            $post_type = get_query_var('post_type');
            $post_type_object = get_post_type_object($post_type);

            $crumb = $this->get_breadcrumb_link(get_post_type_archive_link($post_type), sprintf(__('View all %s', 'calibrefx'), $post_type_object->labels->name), $post_type_object->labels->name);

            $crumb .= $this->args['sep'] . '<li typeof="v:Breadcrumb">'.single_post_title('', false).'</li>';
        }

        return apply_filters('calibrefx_single_crumb', $crumb, $this->args);
    }

    /**
     * Return the correct crumbs for this query, combined together. Private.
     *
     * @return string HTML markup
     */
    function build_crumbs() {

        $crumbs[] = $this->get_home_crumb();

        if (is_home())
            $crumbs[] = $this->get_blog_crumb();
        elseif (is_search())
            $crumbs[] = $this->get_search_crumb();
        elseif (is_404())
            $crumbs[] = $this->get_404_crumb();
        elseif (is_page())
            $crumbs[] = $this->get_page_crumb();
        elseif (is_archive())
            $crumbs[] = $this->get_archive_crumb();
        elseif (is_singular())
            $crumbs[] = $this->get_single_crumb();

        return join($this->args['sep'], array_filter(array_unique($crumbs)));
    }

    /**
     * Return recursive linked crumbs of category, tag or custom taxonomy parents. Private.
     *
     * @param int $parent_id Initial ID of object to get parents of
     * @param string $taxonomy Name of the taxnomy. May be 'category', 'post_tag' or something custom
     * @param boolean $link. Whether to link last item in chain. Default false
     * @param array $visited Array of IDs already included in the chain
     * @return string HTML markup of crumbs
     */
    function get_term_parents($parent_id, $taxonomy, $link = false, $visited = array()) {

        $parent = get_term((int) $parent_id, $taxonomy);

        if (is_wp_error($parent))
            return array();

        if ($parent->parent && ( $parent->parent != $parent->term_id ) && !in_array($parent->parent, $visited)) {
            $visited[] = $parent->parent;
            $chain[] = $this->get_term_parents($parent->parent, $taxonomy, true, $visited);
        }

        if ($link && !is_wp_error(get_term_link(get_term($parent->term_id, $taxonomy), $taxonomy))) {
            $chain[] = $this->get_breadcrumb_link(get_term_link(get_term($parent->term_id, $taxonomy), $taxonomy), sprintf(__('View all items in %s', 'calibrefx'), $parent->name), $parent->name);
        } else {
            $chain[] = $parent->name;
        }

        return join($this->args['sep'], $chain);
    }

    /**
     * Return anchor link for a single crumb. Private.
     *
     * @param string $url URL for href attribute
     * @param string $title title attribute
     * @param string $content linked content
     * @param type $sep Separator
     * @return type HTML markup for anchor link and optional separator
     */
    function get_breadcrumb_link($url, $title, $content, $sep = false) {

        $link = sprintf('<a href="%s" title="%s" rel="v:url" property="v:title">%s</a>', esc_attr($url), esc_attr($title), esc_html($content));

        if ($sep)
            $link .= $sep;

        return $link;
    }

}