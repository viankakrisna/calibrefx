<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibreworks.com
 * @since   		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This file handle calibrefx default settings
 *
 * @package CalibreFx
 */

/**
 * This function registers the default values for Calibrefx theme settings
 */
function calibrefx_theme_settings_defaults() {
    $defaults = array(// define our defaults
        'update' => 1,
        'enable_bootstrap' => 1,
        'blog_title' => 'text',
        'header_right' => 0,
        'nav' => 1,
        'layout_type' => 'fluid',
        'calibrefx_layout_width' => 960,
        'site_layout' => calibrefx_get_default_layout(),
        'subnav' => 0,
        'breadcrumb_home' => 1,
        'breadcrumb_single' => 1,
        'breadcrumb_page' => 1,
        'breadcrumb_archive' => 1,
        'breadcrumb_404' => 1,
        'comments_pages' => 0,
        'comments_posts' => 1,
        'trackbacks_pages' => 0,
        'trackbacks_posts' => 1,
        'custom_css' => '',
        'content_archive' => 'full',
        'content_archive_limit' => 250,
        'posts_nav' => 'older-newer',
        'header_scripts' => '',
        'footer_scripts' => '',
        'calibrefx_version' => FRAMEWORK_VERSION,
        'calibrefx_db_version' => FRAMEWORK_DB_VERSION,
    );

    return apply_filters('calibrefx_theme_settings_defaults', $defaults);
}

add_action('calibrefx_sanitizer_init', 'settings_sanitizer_filters');

function settings_sanitizer_filters() {
    calibrefx_add_option_filter(
        'one_zero', CALIBREFX_SETTINGS_FIELD, array(
            'update',
            'enable_bootstrap',
            'header_right',
            'nav',
            'subnav',
            'breadcrumb_home',
            'breadcrumb_single',
            'breadcrumb_page',
            'breadcrumb_archive',
            'breadcrumb_404',
            'breadcrumb_attachment',
            'comments_posts',
            'comments_pages',
            'trackbacks_posts',
            'trackbacks_pages',
            'content_archive_thumbnail',
        )
    );
    
    calibrefx_add_option_filter(
        'no_html', CALIBREFX_SETTINGS_FIELD, array(
            'site_layout',
            'layout_type',
            'blog_title',
            'content_archive',
            'post_nav',
            'custom_css'
        )
    );
    
    calibrefx_add_option_filter(
        'requires_unfiltered_html', CALIBREFX_SETTINGS_FIELD, array(
            'header_scripts',
            'footer_scripts',
        )
    );
    
}

/**
 * This function registers the default values for Calibrefx theme settings
 */
function calibrefx_seo_settings_defaults() {
    $defaults = array(// define our defaults
        'doc_canonical_url' => 1,
        'doc_enable_rewrite_title' => 1,
        'post_rewrite_title' => '%post_title%',
        'page_rewrite_title' => '%page_title%',
        'author_rewrite_title' => '%author_name% Profile &raquo; %site_title%',
        'category_rewrite_title' => '%category_title% &raquo; %site_title%',
        'archive_rewrite_title' => 'Archive: %date% &raquo; %site_title%',
        'tag_rewrite_title' => 'Tags: %tag% &raquo; %site_title%',
        'search_rewrite_title' => '%search% &raquo; %site_title%',
        '404_rewrite_title' => 'Nothing found for %request_words% &raquo; %site_title%',
        'post_description' => '%description%',
        'page_description' => '%description%',
        'author_description' => 'Profile Author: %author_name% in %site_title%',
        'search_description' => 'Search Result %search% in %site_title%',
        'category_description' => 'Page Category %category_title% for %site_title%',
        'archive_description' => 'Website Archive %date% for %site_title%',
        'tag_description' => 'Website Tag %tag% for %site_title%',
        '404_description' => 'Nothing found for %request_words%',
        'post_keywords' => '%keywords%',
        'page_keywords' => '%keywords%',
        'author_keywords' => '%author_name%',
        'search_keywords' => '%search%, article %search%, review %search%',
        'category_keywords' => '%category_title%, %category_title% articles, %category_title% list',
        'archive_keywords' => '%site_title% archive, %site_title% %date% archive ',
        'tag_keywords' => '%tag%, article %tag%, review %tag%',
        '404_keywords' => '%request_words% 404, %request_words% not found, %request_words% not available',
        'home_title' => '',
        'home_meta_description' => '',
        'home_meta_keywords' => '',
        'home_noindex' => 0,
        'home_nofollow' => 0,
        'home_noarchive' => 0,
        'category_noindex' => 0,
        'tag_noindex' => 0,
        'author_noindex' => 0,
        'date_noindex' => 0,
        'search_noindex' => 0,
        'category_noarchive' => 0,
        'tag_noarchive' => 0,
        'author_noarchive' => 0,
        'date_noarchive' => 0,
        'search_noarchive' => 0,
        'site_noarchive' => 0,
        'site_noodp' => 1,
        'site_noydir' => 1,
        'archive_canonical' => 1,
    );

    return apply_filters('calibrefx_seo_settings_defaults', $defaults);
}