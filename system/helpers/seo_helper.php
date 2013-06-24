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
 * Calibrefx SEO Helper
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 * 
 */

/**
 * Generate SEO title tags
 */
function get_replace_title_tags() {
    global $post, $s, $paged, $wp_locale, $wp_query;
	
	if(is_404()) return; 

    $m = get_query_var('m');
    $year = get_query_var('year');
    $monthnum = get_query_var('monthnum');
    $day = get_query_var('day');

    $categories = get_the_category();
    $category = '';
    if (count($categories) > 0) {
        $category = $categories[0]->cat_name;
    }

	if(is_author() && !$post){
		$author = get_user_by('slug', get_query_var('author_name'));
	}else{
		$author = get_userdata($post->post_author);
	}
    
    $taxonomies = get_the_taxonomies();
    $taxonomy = strip_tags(array_shift(array_values($taxonomies)), '');
    if(empty($taxonomy)) $taxonomy = post_type_archive_title('',false);
    
    $site_title = calibrefx_capitalize(get_bloginfo('name'));
    $site_description = get_bloginfo('description');
    $post_title = calibrefx_capitalize(calibrefx_get_title());
    $page_title = calibrefx_capitalize(calibrefx_get_title());
    $post_author_name = $author->display_name;
    $description = calibrefx_truncate_phrase(calibrefx_get_description(), 160);
    $search = calibrefx_capitalize(esc_html(stripcslashes($s), true));
	
    $keywords = calibrefx_get_keywords();

    if (!empty($m)) {
        $my_year = substr($m, 0, 4);
        $my_month = $wp_locale->get_month(substr($m, 4, 2));
        $date = calibrefx_capitalize($my_year . ' ' . $my_month);
    } else {
        $date = calibrefx_capitalize($year);
    }


    $page = $paged;
    $request_word = calibrefx_capitalize(calibrefx_request_as_words($_SERVER['REQUEST_URI']));

    $replace_arr = array(
        'site_title' => $site_title,
        'site_description' => $site_description,
        'post_title' => $post_title,
        'category_title' => $category,
        'page_title' => $page_title,
        'description' => $description,
        'post_author_name' => $post_author_name,
        'author_name' => $post_author_name,
        'date' => $date,
        'search' => $search,
        'page' => $page,
        'request_words' => $request_word,
        'keywords' => $keywords,
        'taxonomy' => $taxonomy,
    );

    return apply_filters('calibrefx_title_tags', $replace_arr);
}

/**
 * @return User-readable nice words for a given request.
 */
function calibrefx_request_as_words($request) {
    $request = htmlspecialchars($request);
    $request = str_replace('.html', ' ', $request);
    $request = str_replace('.htm', ' ', $request);
    $request = str_replace('.', ' ', $request);
    $request = str_replace('/', ' ', $request);
    $request_a = explode(' ', $request);
    $request_new = array();
    foreach ($request_a as $token) {
        $request_new[] = ucwords(trim($token));
    }
    $request = implode(' ', $request_new);
    return $request;
}

function calibrefx_capitalize($s) {
    $s = trim($s);
    $tokens = explode(' ', $s);
    while (list($key, $val) = each($tokens)) {
        $tokens[$key] = trim($tokens[$key]);
        $tokens[$key] = strtoupper(substr($tokens[$key], 0, 1)) . substr($tokens[$key], 1);
    }
    $s = implode(' ', $tokens);
    return $s;
}

function calibrefx_get_title() {
    global $post;
	if(!$post) return;
    $custom_title = calibrefx_get_custom_field('_calibrefx_title');
    return empty($custom_title) ? $post->post_title : $custom_title;
}

function calibrefx_get_description() {
    global $post;
	if(!$post) return;
    $custom_description = calibrefx_get_custom_field('_calibrefx_description');
    return empty($custom_description) ? $post->post_title : $custom_description;
}

function calibrefx_get_keywords() {
    global $post;
	if(!$post) return;
    $custom_keywords = calibrefx_get_custom_field('_calibrefx_keywords');
    $original_keywords = calibrefx_filter_keywords(wp_get_post_terms($post->ID, 'post_tag', array("fields" => "names")));
    return empty($custom_keywords) ? $original_keywords : $custom_keywords;
}

/**
 * Filter duplicate keywords 
 * 
 * @param type $keywords
 * @return type 
 */
function calibrefx_filter_keywords($keywords) {
    $small_keywords = array();
    foreach ($keywords as $word) {
        if (function_exists('mb_strtolower'))
            $small_keywords[] = mb_strtolower($word, get_bloginfo('charset'));
        else
            $small_keywords[] = $this->strtolower($word);
    }
    $keywords_ar = array_unique($small_keywords);
    return implode(',', $keywords_ar);
}