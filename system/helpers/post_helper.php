<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @link		http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 * 
 *
 * @package CalibreFx
 */
/**
 * Calibrefx Post Helper
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 * 
 */

/**
 * Helper function used to check that we're targeting a specific Calibrefx admin page.
 *
 */
function calibrefx_is_menu_page($pagehook = '') {

    global $page_hook;

    if (isset($page_hook) && $page_hook == $pagehook)
        return true;

    /* May be too early for $page_hook */
    if (isset($_REQUEST['page']) && $_REQUEST['page'] == $pagehook)
        return true;

    return false;
}

/**
 * Helper function used to get all post meta based on the post ID given.
 */
function calibrefx_get_post_meta_all($post_id) {
    global $wpdb;
    $data = array();
    $wpdb->query("
        SELECT `meta_key`, `meta_value`
        FROM $wpdb->postmeta
        WHERE `post_id` = $post_id
    ");
    foreach ($wpdb->last_result as $k => $v) {
        $data[$v->meta_key] = $v->meta_value;
    };
    return $data;
}

/**
 * Helper function used to get post meta based on the post ID and the meta Key
 */
function calibrefx_get_custom_post_meta($post_id, $meta_key) {
    global $wpdb;

    $result = $wpdb->get_row("
        SELECT `meta_value`
        FROM $wpdb->postmeta
        WHERE `post_id` = $post_id and `meta_key` = '$meta_key'
    ");

    return $result->meta_value;
}

/**
 * Helper function for to display Calibrefx BreadCrumb
 *
 */
function calibrefx_breadcrumb($args = array()) {

    global $_calibrefx_breadcrumb;

    if (!$_calibrefx_breadcrumb) {
        $CFX = & calibrefx_get_instance();
        $CFX->load->library('breadcrumb');
        $_calibrefx_breadcrumb = & $CFX->breadcrumb;
    }

    $_calibrefx_breadcrumb->output($args);
}

/**
 * Echoes post navigation in Older Posts / Newer Posts format.
 */
function calibrefx_older_newer_posts_nav() {

    $older_link = get_next_posts_link(apply_filters('calibrefx_older_link_text', '&larr; ') . __('Older Posts', 'calibrefx'));
    $newer_link = get_previous_posts_link(apply_filters('calibrefx_newer_link_text', __('Newer Posts', 'calibrefx') . ' &rarr;'));

    $older = $older_link ? '<div class="previous">' . $older_link . '</div>' : '';
    $newer = $newer_link ? '<div class="next">' . $newer_link . '</div>' : '';

    $nav = '<div class="navigation pager">' . $older . $newer . '</div><!-- end .navigation -->';

    if ($older || $newer)
        echo $nav;
}

/**
 * Echoes post navigation in Previous Posts / Next Posts format.
 *
 */
function calibrefx_prev_next_posts_nav() {

    $prev_link = get_previous_posts_link(apply_filters('calibrefx_prev_link_text', '&larr; ' . __('Previous Page', 'calibrefx')));
    $next_link = get_next_posts_link(apply_filters('calibrefx_next_link_text', __('Next Page', 'calibrefx') . ' &rarr;'));

    $prev = $prev_link ? '<div class="previous">' . $prev_link . '</div>' : '';
    $next = $next_link ? '<div class="next">' . $next_link . '</div>' : '';

    $nav = '<div class="navigation pager">' . $prev . $next . '</div><!-- end .navigation -->';

    if ($prev || $next)
        echo $nav;
}

/**
 * Echoes post navigation in page numbers format (similar to WP-PageNavi).
 *
 * The links, if needed, are ordered as:
 *   previous page arrow,
 *   first page,
 *   up to two pages before current page,
 *   current page,
 *   up to two pages after the current page,
 *   last page,
 *   next page arrow.
 */
function calibrefx_numeric_posts_nav() {

    if (is_singular())
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if ($wp_query->max_num_pages <= 1)
        return;

    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max = intval($wp_query->max_num_pages);

    /** 	Add current page to the array */
    if ($paged >= 1)
        $links[] = $paged;

    /** 	Add the pages around the current page to the array */
    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if (( $paged + 2 ) <= $max) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="navigation pagination pagination-right"><ul>' . "\n";

    /** 	Previous Post Link */
    if (get_previous_posts_link())
        printf('<li class="previous">%s</li>' . "\n", get_previous_posts_link(apply_filters('calibrefx_prev_link_text', '&laquo; ' . __('Previous Page', 'calibrefx'))));

    /** 	Link to first page, plus ellipses if necessary */
    if (!in_array(1, $links)) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, get_pagenum_link(1), '1');

        if (!in_array(2, $links))
            echo '<li>&hellip;</li>';
    }

    /** 	Link to current page, plus 2 pages in either direction if necessary */
    sort($links);
    foreach ((array) $links as $link) {
        $class = $paged == $link ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, get_pagenum_link($link), $link);
    }

    /** 	Link to last page, plus ellipses if necessary */
    if (!in_array($max, $links)) {
        if (!in_array($max - 1, $links))
            echo '<li>&hellip;</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, get_pagenum_link($max), $max);
    }

    /** 	Next Post Link */
    if (get_next_posts_link())
        printf('<li class="next">%s</li>' . "\n", get_next_posts_link(apply_filters('calibrefx_next_link_text', __('Next Page', 'calibrefx') . ' &raquo;')));

    echo '</ul></div>' . "\n";
}

/**
 * Display links to previous - next post.
 *
 * @return null Returns early if not a post
 */
function calibrefx_prev_next_post_nav() {

    if (!is_singular('post'))
        return;
    ?>
    <div class="navigation">
        <div class="alignleft"><?php previous_post_link(); ?></div>
        <div class="alignright"><?php next_post_link(); ?></div>
    </div>
    <?php
}