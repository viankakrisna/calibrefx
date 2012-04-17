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
 * @since		Version 1.0
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
        'blog_title' => 'text',
        'header_right' => 0,
        'nav' => 1,
        'layout_type' => 'fluid',
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

/**
 * This function registers the default values for Calibrefx theme settings
 */
function calibrefx_seo_settings_defaults() {
    $defaults = array(// define our defaults
        'update' => 1,
    );
    
    return apply_filters('calibrefx_seo_settings_defaults', $defaults);
}