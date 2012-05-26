<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * Handle SEO Functions
 *
 * @package CalibreFx
 */
add_filter('calibrefx_do_title', 'calibrefx_seo_title');

/**
 * Generate SEO title based on the format given
 */
function calibrefx_seo_title() {

    $replace_tags = get_replace_title_tags();

    $cfx_replacer = new cfx_replacer($replace_tags);

    if (is_home()) {
        $home_title = calibrefx_get_seo_option('home_title');
        if ($home_title)
            return $home_title;
        else
            return get_bloginfo('name');
    }

    if (is_category()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('category_rewrite_title'));
    }

    if (is_date()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('archive_rewrite_title'));
    }

    if (is_tag()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('tag_rewrite_title'));
    }

    if (is_page()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('page_rewrite_title'));
    }

    if (is_single()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('post_rewrite_title'));
    }

    if (is_author()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('author_rewrite_title'));
    }

    if (is_search()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('search_rewrite_title'));
    }

    if (is_404()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('404_rewrite_title'));
    }
}

add_filter('calibrefx_do_meta_description', 'calibrefx_seo_description');

/**
 * Generate SEO description based on the format given
 */
function calibrefx_seo_description() {
    $replace_tags = get_replace_title_tags();

    $cfx_replacer = new cfx_replacer($replace_tags);

    if (is_home()) {
        $home_description = calibrefx_get_seo_option('home_meta_description');
        if ($home_description)
            return $home_description;
        else
            return get_bloginfo('description');
    }

    if (is_category()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('category_description'));
    }

    if (is_date()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('archive_description'));
    }

    if (is_tag()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('tag_description'));
    }

    if (is_page()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('page_description'));
    }

    if (is_single()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('post_description'));
    }

    if (is_author()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('author_description'));
    }

    if (is_search()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('search_description'));
    }

    if (is_404()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('404_description'));
    }
}

add_filter('calibrefx_do_meta_keywords', 'calibrefx_seo_keywords');

/**
 * Generate SEO keywords based on the format given
 */
function calibrefx_seo_keywords() {
    $replace_tags = get_replace_title_tags();

    $cfx_replacer = new cfx_replacer($replace_tags);

    if (is_home()) {
        return calibrefx_get_seo_option('home_meta_keywords');
    }

    if (is_category()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('category_keywords'));
    }

    if (is_date()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('archive_keywords'));
    }

    if (is_tag()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('tag_keywords'));
    }

    if (is_page()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('page_keywords'));
    }

    if (is_single()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('post_keywords'));
    }

    if (is_author()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('author_keywords'));
    }

    if (is_search()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('search_keywords'));
    }

    if (is_404()) {
        return $cfx_replacer->get(calibrefx_get_seo_option('404_keywords'));
    }
}

add_action('calibrefx_meta', 'calibrefx_do_meta_robot');

/**
 * This function generates the index / follow / noodp / noydir / noarchive code
 * in the document <head>.
 */
function calibrefx_do_meta_robot() {

    global $wp_query, $post;

    /*
     * If the blog is private, then following logic is unnecessary as WP will
     * insert noindex and nofollow
     */
    if (0 == get_option('blog_public'))
        return;

    $meta = array(
        'noindex' => '',
        'nofollow' => '',
        'noarchive' => calibrefx_get_seo_option('noarchive') ? 'noarchive' : '',
        'noodp' => calibrefx_get_seo_option('site_noodp') ? 'noodp' : '',
        'noydir' => calibrefx_get_seo_option('site_noydir') ? 'noydir' : '',
    );

    /** Check home page SEO settings, set noindex, nofollow and noarchive */
    if (is_front_page()) {
        $meta['noindex'] = calibrefx_get_seo_option('home_noindex') ? 'noindex' : $meta['noindex'];
        $meta['nofollow'] = calibrefx_get_seo_option('home_nofollow') ? 'nofollow' : $meta['nofollow'];
        $meta['noarchive'] = calibrefx_get_seo_option('home_noarchive') ? 'noarchive' : $meta['noarchive'];
    }

    if (is_category()) {
        $term = $wp_query->get_queried_object();

        $meta['noindex'] = $term->meta['noindex'] ? 'noindex' : $meta['noindex'];
        $meta['nofollow'] = $term->meta['nofollow'] ? 'nofollow' : $meta['nofollow'];
        $meta['noarchive'] = $term->meta['noarchive'] ? 'noarchive' : $meta['noarchive'];

        $meta['noindex'] = calibrefx_get_seo_option('category_noindex') ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_seo_option('category_noarchive') ? 'noarchive' : $meta['noarchive'];

        /** 	noindex paged archives, if canonical archives is off */
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $meta['noindex'] = $paged > 1 && !calibrefx_get_seo_option('archive_canonical') ? 'noindex' : $meta['noindex'];
    }

    if (is_tag()) {
        $term = $wp_query->get_queried_object();

        $meta['noindex'] = $term->meta['noindex'] ? 'noindex' : $meta['noindex'];
        $meta['nofollow'] = $term->meta['nofollow'] ? 'nofollow' : $meta['nofollow'];
        $meta['noarchive'] = $term->meta['noarchive'] ? 'noarchive' : $meta['noarchive'];

        $meta['noindex'] = calibrefx_get_seo_option('tag_noindex') ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_seo_option('tag_noarchive') ? 'noarchive' : $meta['noarchive'];

        /** 	noindex paged archives, if canonical archives is off */
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $meta['noindex'] = $paged > 1 && !calibrefx_get_seo_option('archive_canonical') ? 'noindex' : $meta['noindex'];
    }

    if (is_tax()) {
        $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

        $meta['noindex'] = $term->meta['noindex'] ? 'noindex' : $meta['noindex'];
        $meta['nofollow'] = $term->meta['nofollow'] ? 'nofollow' : $meta['nofollow'];
        $meta['noarchive'] = $term->meta['noarchive'] ? 'noarchive' : $meta['noarchive'];

        /** noindex paged archives, if canonical archives is off */
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $meta['noindex'] = $paged > 1 && !calibrefx_get_seo_option('archive_canonical') ? 'noindex' : $meta['noindex'];
    }

    if (is_author()) {
        $meta['noindex'] = get_the_author_meta('noindex', (int) get_query_var('author')) ? 'noindex' : $meta['noindex'];
        $meta['nofollow'] = get_the_author_meta('nofollow', (int) get_query_var('author')) ? 'nofollow' : $meta['nofollow'];
        $meta['noarchive'] = get_the_author_meta('noarchive', (int) get_query_var('author')) ? 'noarchive' : $meta['noarchive'];

        $meta['noindex'] = calibrefx_get_seo_option('author_noindex') ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_seo_option('author_noarchive') ? 'noarchive' : $meta['noarchive'];

        /** 	noindex paged archives, if canonical archives is off */
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $meta['noindex'] = $paged > 1 && !calibrefx_get_seo_option('archive_canonical') ? 'noindex' : $meta['noindex'];
    }

    if (is_date()) {
        $meta['noindex'] = calibrefx_get_seo_option('date_noindex') ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_seo_option('date_noarchive') ? 'noarchive' : $meta['noarchive'];
    }

    if (is_search()) {
        $meta['noindex'] = calibrefx_get_seo_option('search_noindex') ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_seo_option('search_noarchive') ? 'noarchive' : $meta['noarchive'];
    }

    if (is_singular()) {
        $meta['noindex'] = calibrefx_get_custom_field('_calibrefx_noindex') ? 'noindex' : $meta['noindex'];
        $meta['nofollow'] = calibrefx_get_custom_field('_calibrefx_nofollow') ? 'nofollow' : $meta['nofollow'];
        $meta['noarchive'] = calibrefx_get_custom_field('_calibrefx_noarchive') ? 'noarchive' : $meta['noarchive'];
    }

    /** Strip empty array items */
    $meta = array_filter($meta);

    /** Add meta if any exist */
    if ($meta)
        printf('<meta name="robots" content="%s" />' . "\n", implode(',', $meta));
}

add_action('wp_head', 'calibrefx_canonical', 5);

/**
 * Echo custom canonical link tag.
 *
 * Remove the default WordPress canonical tag, and use our custom
 * one. Gives us more flexibility and effectiveness.
 *
 */
function calibrefx_canonical() {

    /** Remove the WordPress canonical */
    remove_action('wp_head', 'rel_canonical');

    global $wp_query;

    $canonical = '';

    if (is_front_page())
        $canonical = trailingslashit(home_url());

    if (is_singular()) {
        if (!$id = $wp_query->get_queried_object_id())
            return;

        $cf = calibrefx_get_custom_field('_calibrefx_canonical_uri');

        $canonical = $cf ? $cf : get_permalink($id);
    }

    if (is_category() || is_tag() || is_tax()) {
        if (!$id = $wp_query->get_queried_object_id())
            return;

        $taxonomy = $wp_query->queried_object->taxonomy;

        $canonical = calibrefx_get_seo_option('archive_canonical') ? get_term_link((int) $id, $taxonomy) : 0;
    }

    if (is_author()) {
        if (!$id = $wp_query->get_queried_object_id())
            return;

        $canonical = calibrefx_get_seo_option('archive_canonical') ? get_author_posts_url($id) : 0;
    }

    if ($canonical)
        printf('<link rel="canonical" href="%s" />' . "\n", esc_url(apply_filters('calibrefx_canonical', $canonical)));
}

add_action('template_redirect', 'calibrefx_custom_redirect', 5);
/**
 * Redirect to another post with permanent redirect 
 */
function calibrefx_custom_redirect(){
    $cf = calibrefx_get_custom_field('_calibrefx_redirect_url');
    
    if(!empty($cf)){
        wp_redirect( $cf, 301 );
        exit;
    }
}

/**
 * Generate SEO title tags
 */
function get_replace_title_tags() {
    global $post, $s, $paged, $wp_locale;

    $m = get_query_var('m');
    $year = get_query_var('year');
    $monthnum = get_query_var('monthnum');
    $day = get_query_var('day');

    $categories = get_the_category();
    $author = get_userdata($post->post_author);
    $category = '';
    if (count($categories) > 0) {
        $category = $categories[0]->cat_name;
    }

    $site_title = calibrefx_capitalize(get_bloginfo('name'));
    $site_description = get_bloginfo('description');
    $post_title = calibrefx_capitalize(calibrefx_get_title());
    $page_title = calibrefx_capitalize(calibrefx_get_title());
    $post_author_name = $author->display_name;
    $description = calibrefx_truncate_phrase(calibrefx_get_description(), 160);
    $search = calibrefx_capitalize(wp_specialchars(stripcslashes($s), true));

    $keywords = calibrefx_get_keywords();

    if (!empty($m)) {
        $my_year = substr($m, 0, 4);
        $my_month = $wp_locale->get_month(substr($m, 4, 2));
        $date = calibrefx_capitalize($my_year . ' ' . $my_month);
    } else {
        $date = calibrefx_capitalize($year . ' ' . $wp_locale->get_month($monthnum));
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
        'date' => $date,
        'search' => $search,
        'page' => $page,
        'request_words' => $request_word,
        'keywords' => $keywords,
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
    $custom_title = calibrefx_get_custom_field('_calibrefx_title');
    return empty($custom_title) ? $post->post_title : $custom_title;
}

function calibrefx_get_description() {
    global $post;
    $custom_description = calibrefx_get_custom_field('_calibrefx_description');
    return empty($custom_description) ? $post->post_title : $custom_description;
}

function calibrefx_get_keywords() {
    global $post;
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