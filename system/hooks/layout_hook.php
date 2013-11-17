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
 * Calibrefx Layout Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */
add_action('calibrefx_init', 'calibrefx_setup_layout', 0);

/**
 * Register all the available layout
 *
 * @access public
 * @return void
 */
function calibrefx_setup_layout() {

    calibrefx_register_layout(
            'content-sidebar', array(
        'label' => __('Content Sidebar (default blog)', 'calibrefx'),
        'img' => CALIBREFX_IMAGES_URL . '/layouts/cs.gif',
        'default' => true)
    );
    calibrefx_register_layout(
            'full-width-content', array(
        'label' => __('Full Width Content (minisite)', 'calibrefx'),
        'img' => CALIBREFX_IMAGES_URL . '/layouts/c.gif')
    );
    calibrefx_register_layout(
            'sidebar-content', array(
        'label' => __('Sidebar Content', 'calibrefx'),
        'img' => CALIBREFX_IMAGES_URL . '/layouts/sc.gif')
    );
    calibrefx_register_layout(
            'sidebar-content-sidebar', array(
        'label' => __('Sidebar Content Sidebar', 'calibrefx'),
        'img' => CALIBREFX_IMAGES_URL . '/layouts/scs.gif')
    );
}

add_filter('body_class', 'calibrefx_layout_body_class');

/**
 * This function/filter adds custom body class(es) to the
 * body class array. 
 */
function calibrefx_layout_body_class($classes) {

    $site_layout = calibrefx_site_layout();

    //add css class to the body class array
    if ($site_layout)
        $classes[] = $site_layout;

    if(calibrefx_get_option('calibrefx_layout_wrapper_fixed')){
        $classes[] = 'layout-wrapper-fixed';
    }else{
        $classes[] = 'layout-wrapper-fluid';
    }

    return $classes;
}

add_filter('post_class', 'calibrefx_post_class');

/**
 * Add class row/row-fluid to post
 */
function calibrefx_post_class($classes) {

    $classes[] = calibrefx_row_class();

    $custom_post = calibrefx_get_custom_field('_calibrefx_custom_post_class');
    if (!empty($custom_post)) {
        $classes[] = $custom_post;
    }

    return $classes;
}

add_filter('body_class', 'calibrefx_header_body_classes');

/**
 * This function/filter adds new classes to the <body>
 * so that we can use psuedo-variables in our CSS file,
 * which helps us achieve multiple header layouts with minimal code
 *
 * @since 0.2.2
 */
function calibrefx_header_body_classes($classes) {

    // add header classes to $classes array
    if (!is_active_sidebar('header-right'))
        $classes[] = 'header-full-width';

    if ('image' == calibrefx_get_option('blog_title') || 'blank' == get_header_textcolor())
        $classes[] = 'header-image';
    
    if(current_theme_supports( 'calibrefx-responsive-style' )){
        $classes[] = 'responsive';
    }   
    if(calibrefx_layout_is_fluid()){
        $classes[] = 'fluid';
    }else{
       $classes[] = 'static'; 
    }

    $custom_body = calibrefx_get_custom_field('_calibrefx_custom_body_class');
    if (!empty($custom_body)) {
        $classes[] = $custom_body;
    }
    // return filtered $classes
    return $classes;
}

/**
 * This function/filter adds content span*
 */
function calibrefx_content_span() {
    // get the layout
    $site_layout = calibrefx_site_layout();

    // don't load sidebar on pages that don't need it
    if(current_theme_supports('calibrefx-version-1.0')){
        if ($site_layout == 'full-width-content')
            return apply_filters('calibrefx_content_span', 'span12 first');

        if ($site_layout == 'sidebar-content-sidebar')
            return apply_filters('calibrefx_content_span', 'span6');

        return apply_filters('calibrefx_content_span', 'span8');
    }else{
        if ($site_layout == 'full-width-content')
            return apply_filters('calibrefx_content_span', 'col-lg-12 col-md-12 col-sm-12 col-xs-12 first');

        if ($site_layout == 'sidebar-content-sidebar')
            return apply_filters('calibrefx_content_span', 'col-lg-6 col-md-6 col-sm-12 col-xs-12');

        return apply_filters('calibrefx_content_span', 'col-lg-8 col-md-8 col-sm-12 col-xs-12');
    }
    
}

/**
 * This function/filter adds sidebar span*
 */
function calibrefx_sidebar_span() {
    // get the layout
    $site_layout = calibrefx_site_layout();

    // don't load sidebar on pages that don't need it
    if ($site_layout == 'full-width-content')
        return;

    if(current_theme_supports('calibrefx-version-1.0')){
        if ($site_layout == 'sidebar-content-sidebar')
            return apply_filters('calibrefx_sidebar_span', 'span3');

        return apply_filters('calibrefx_sidebar_span', 'span4');
    }else{
        if ($site_layout == 'sidebar-content-sidebar')
            return apply_filters('calibrefx_sidebar_span', 'col-lg-3 col-md-3 col-sm-12 col-xs-12');

        return apply_filters('calibrefx_sidebar_span', 'col-lg-4 col-md-4 col-sm-12 col-xs-12');
    }
}

add_action('calibrefx_after_content', 'calibrefx_get_sidebar');

/**
 * This function will show sidebar after the content
 */
function calibrefx_get_sidebar() {

    // get the layout
    $site_layout = calibrefx_site_layout();

    // don't load sidebar on pages that don't need it
    if ($site_layout == 'full-width-content')
        return;

    // output the primary sidebar
    get_sidebar();
}

add_action('calibrefx_before_content', 'calibrefx_get_sidebar_alt');

/**
 * This function will show sidebar after the content
 */
function calibrefx_get_sidebar_alt() {

    // get the layout
    $site_layout = calibrefx_site_layout();

    // don't load sidebar on pages that don't need it
    if ($site_layout == 'full-width-content' ||
            $site_layout == 'content-sidebar' ||
            $site_layout == 'sidebar-content')
        return;

    // output the primary sidebar
    get_sidebar('alt');
}

add_action('after_setup_theme', 'calibrefx_custom_background');
/**
 * This function will activate the custom background from WordPress
 *
 * It gets arguments passed through add_theme_support(), defines the constants,
 * and calls calibrefx_custom_background().
 *
 * @return void
 */
function calibrefx_custom_background() {

    $custom_background = get_theme_support('calibrefx-custom-background');

    /** If not active, do nothing */
    if (!$custom_background)
        return;

    $args = apply_filters( 'calibrefx_custom_background_args', array( 'default-color' => 'EDEDEB' ) );
    
    add_theme_support( 'custom-background', $args );
}