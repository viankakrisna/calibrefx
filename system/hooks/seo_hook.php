<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @link		http://calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 * 
 *
 * @package CalibreFx
 */
/**
 * Calibrefx SEO Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
 */

add_action('calibrefx_init', 'calibrefx_init_seo_hook');
function calibrefx_init_seo_hook(){
    $CFX = &calibrefx_get_instance();
    //developer can deactivate this from the functions.php
    if(current_theme_supports('calibrefx-seo') && ($CFX->seo_settings_m->get('enable_seo'))){
        init_seo_feature_hook();
    }
}

function init_seo_feature_hook(){
    add_filter('calibrefx_do_title', 'calibrefx_seo_title');
    add_filter('calibrefx_do_meta_description', 'calibrefx_seo_description');
    add_filter('calibrefx_do_meta_keywords', 'calibrefx_seo_keywords');
    add_action('calibrefx_meta', 'calibrefx_do_meta_robot');
    add_action('wp_head', 'calibrefx_canonical', 5);
    add_action('template_redirect', 'calibrefx_custom_redirect', 5);
}


/**
 * Generate SEO title based on the format given
 */
function calibrefx_seo_title() {

    $replace_tags = get_replace_title_tags();

    $CFX = &calibrefx_get_instance();
    
    $cfx_replacer = & $CFX->replacer->set_replace_tag($replace_tags);

    if (is_home() || is_front_page()) {
        $post_seo_title = calibrefx_get_custom_field('_calibrefx_title');    
        $home_title = calibrefx_get_option('home_title', $CFX->seo_settings_m);
        
        if($post_seo_title){
            return $post_seo_title;
        }
        elseif ($home_title){
            return $home_title;
        }
        else{
            return get_bloginfo('name');
        }
    }

    if (is_category()) {
        return $cfx_replacer->get(calibrefx_get_option('category_rewrite_title', $CFX->seo_settings_m));
    }

    if (is_date()) {
        return $cfx_replacer->get(calibrefx_get_option('archive_rewrite_title', $CFX->seo_settings_m));
    }
    
    if (is_tax()) {        
        return $cfx_replacer->get(calibrefx_get_option('taxonomy_rewrite_title', $CFX->seo_settings_m));
    }

    if (is_tag()) {
        return $cfx_replacer->get(calibrefx_get_option('tag_rewrite_title', $CFX->seo_settings_m));
    }

    if (is_page()) {
        return $cfx_replacer->get(calibrefx_get_option('page_rewrite_title', $CFX->seo_settings_m));
    }

    if (is_single()) {
        return $cfx_replacer->get(calibrefx_get_option('post_rewrite_title', $CFX->seo_settings_m));
    }

    if (is_author()) {
        return $cfx_replacer->get(calibrefx_get_option('author_rewrite_title', $CFX->seo_settings_m));
    }

    if (is_search()) {
        return $cfx_replacer->get(calibrefx_get_option('search_rewrite_title', $CFX->seo_settings_m));
    }

    if (is_404()) {
        return $cfx_replacer->get(calibrefx_get_option('404_rewrite_title', $CFX->seo_settings_m));
    }
}

/**
 * Generate SEO description based on the format given
 */
function calibrefx_seo_description() {
    $replace_tags = get_replace_title_tags();

    $CFX = &calibrefx_get_instance();
    $cfx_replacer = & $CFX->replacer->set_replace_tag($replace_tags);

    if (is_home() || is_front_page()) {
        $post_seo_description = calibrefx_get_custom_field('_calibrefx_description');  
        $home_description = calibrefx_get_option('home_meta_description', $CFX->seo_settings_m);
        
        if($post_seo_description)
            return $post_seo_description;
        elseif ($home_description)
            return $home_description;
        else
            return get_bloginfo('description');
    }

    if (is_category()) {
        return $cfx_replacer->get(calibrefx_get_option('category_description', $CFX->seo_settings_m));
    }

    if (is_date()) {
        return $cfx_replacer->get(calibrefx_get_option('archive_description', $CFX->seo_settings_m));
    }

    if (is_tag()) {
        return $cfx_replacer->get(calibrefx_get_option('tag_description', $CFX->seo_settings_m));
    }

    if (is_page()) {
        return $cfx_replacer->get(calibrefx_get_option('page_description', $CFX->seo_settings_m));
    }

    if (is_single()) {
        return $cfx_replacer->get(calibrefx_get_option('post_description', $CFX->seo_settings_m));
    }

    if (is_author()) {
        return $cfx_replacer->get(calibrefx_get_option('author_description', $CFX->seo_settings_m));
    }

    if (is_search()) {
        return $cfx_replacer->get(calibrefx_get_option('search_description', $CFX->seo_settings_m));
    }

    if (is_404()) {
        return $cfx_replacer->get(calibrefx_get_option('404_description', $CFX->seo_settings_m));
    }
}

/**
 * Generate SEO keywords based on the format given
 */
function calibrefx_seo_keywords() {
    $replace_tags = get_replace_title_tags();

    $CFX = &calibrefx_get_instance();
    $cfx_replacer = & $CFX->replacer->set_replace_tag($replace_tags);

    if (is_home()) {
        return calibrefx_get_option('home_meta_keywords', $CFX->seo_settings_m);
    }

    if (is_category()) {
        return $cfx_replacer->get(calibrefx_get_option('category_keywords', $CFX->seo_settings_m));
    }

    if (is_date()) {
        return $cfx_replacer->get(calibrefx_get_option('archive_keywords', $CFX->seo_settings_m));
    }

    if (is_tag()) {
        return $cfx_replacer->get(calibrefx_get_option('tag_keywords', $CFX->seo_settings_m));
    }

    if (is_page()) {
        return $cfx_replacer->get(calibrefx_get_option('page_keywords', $CFX->seo_settings_m));
    }

    if (is_single()) {
        return $cfx_replacer->get(calibrefx_get_option('post_keywords', $CFX->seo_settings_m));
    }

    if (is_author()) {
        return $cfx_replacer->get(calibrefx_get_option('author_keywords', $CFX->seo_settings_m));
    }

    if (is_search()) {
        return $cfx_replacer->get(calibrefx_get_option('search_keywords', $CFX->seo_settings_m));
    }

    if (is_404()) {
        return $cfx_replacer->get(calibrefx_get_option('404_keywords', $CFX->seo_settings_m));
    }
}

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
        'noarchive' => calibrefx_get_option('noarchive', $CFX->seo_settings_m) ? 'noarchive' : '',
        'noodp' => calibrefx_get_option('site_noodp', $CFX->seo_settings_m) ? 'noodp' : '',
        'noydir' => calibrefx_get_option('site_noydir', $CFX->seo_settings_m) ? 'noydir' : '',
    );

    /** Check home page SEO settings, set noindex, nofollow and noarchive */
    if (is_front_page()) {
        $meta['noindex'] = calibrefx_get_option('home_noindex', $CFX->seo_settings_m) ? 'noindex' : $meta['noindex'];
        $meta['nofollow'] = calibrefx_get_option('home_nofollow', $CFX->seo_settings_m) ? 'nofollow' : $meta['nofollow'];
        $meta['noarchive'] = calibrefx_get_option('home_noarchive', $CFX->seo_settings_m) ? 'noarchive' : $meta['noarchive'];
    }

    if (is_category()) {
        $term = $wp_query->get_queried_object();

        $meta['noindex'] = $term->meta['noindex'] ? 'noindex' : $meta['noindex'];
        $meta['nofollow'] = $term->meta['nofollow'] ? 'nofollow' : $meta['nofollow'];
        $meta['noarchive'] = $term->meta['noarchive'] ? 'noarchive' : $meta['noarchive'];

        $meta['noindex'] = calibrefx_get_option('category_noindex', $CFX->seo_settings_m) ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_option('category_noarchive', $CFX->seo_settings_m) ? 'noarchive' : $meta['noarchive'];

        /** 	noindex paged archives, if canonical archives is off */
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $meta['noindex'] = $paged > 1 && !calibrefx_get_option('archive_canonical', $CFX->seo_settings_m) ? 'noindex' : $meta['noindex'];
    }

    if (is_tag()) {
        $term = $wp_query->get_queried_object();

        $meta['noindex'] = $term->meta['noindex'] ? 'noindex' : $meta['noindex'];
        $meta['nofollow'] = $term->meta['nofollow'] ? 'nofollow' : $meta['nofollow'];
        $meta['noarchive'] = $term->meta['noarchive'] ? 'noarchive' : $meta['noarchive'];

        $meta['noindex'] = calibrefx_get_option('tag_noindex', $CFX->seo_settings_m) ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_option('tag_noarchive', $CFX->seo_settings_m) ? 'noarchive' : $meta['noarchive'];

        /** 	noindex paged archives, if canonical archives is off */
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $meta['noindex'] = $paged > 1 && !calibrefx_get_option('archive_canonical', $CFX->seo_settings_m) ? 'noindex' : $meta['noindex'];
    }

    if (is_tax()) {
        $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

        $meta['noindex'] = $term->meta['noindex'] ? 'noindex' : $meta['noindex'];
        $meta['nofollow'] = $term->meta['nofollow'] ? 'nofollow' : $meta['nofollow'];
        $meta['noarchive'] = $term->meta['noarchive'] ? 'noarchive' : $meta['noarchive'];

        /** noindex paged archives, if canonical archives is off */
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $meta['noindex'] = $paged > 1 && !calibrefx_get_option('archive_canonical', $CFX->seo_settings_m) ? 'noindex' : $meta['noindex'];
    }

    if (is_author()) {
        $meta['noindex'] = get_the_author_meta('noindex', (int) get_query_var('author')) ? 'noindex' : $meta['noindex'];
        $meta['nofollow'] = get_the_author_meta('nofollow', (int) get_query_var('author')) ? 'nofollow' : $meta['nofollow'];
        $meta['noarchive'] = get_the_author_meta('noarchive', (int) get_query_var('author')) ? 'noarchive' : $meta['noarchive'];

        $meta['noindex'] = calibrefx_get_option('author_noindex', $CFX->seo_settings_m) ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_option('author_noarchive', $CFX->seo_settings_m) ? 'noarchive' : $meta['noarchive'];

        /** 	noindex paged archives, if canonical archives is off */
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $meta['noindex'] = $paged > 1 && !calibrefx_get_option('archive_canonical', $CFX->seo_settings_m) ? 'noindex' : $meta['noindex'];
    }

    if (is_date()) {
        $meta['noindex'] = calibrefx_get_option('date_noindex', $CFX->seo_settings_m) ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_option('date_noarchive', $CFX->seo_settings_m) ? 'noarchive' : $meta['noarchive'];
    }

    if (is_search()) {
        $meta['noindex'] = calibrefx_get_option('search_noindex', $CFX->seo_settings_m) ? 'noindex' : $meta['noindex'];
        $meta['noarchive'] = calibrefx_get_option('search_noarchive', $CFX->seo_settings_m) ? 'noarchive' : $meta['noarchive'];
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

        $canonical = calibrefx_get_option('archive_canonical', $CFX->seo_settings_m) ? get_term_link((int) $id, $taxonomy) : 0;
    }

    if (is_author()) {
        if (!$id = $wp_query->get_queried_object_id())
            return;

        $canonical = calibrefx_get_option('archive_canonical', $CFX->seo_settings_m) ? get_author_posts_url($id) : 0;
    }

    if ($canonical)
        printf('<link rel="canonical" href="%s" />' . "\n", esc_url(apply_filters('calibrefx_canonical', $canonical)));
}

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