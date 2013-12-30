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
 * Calibrefx Logo Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

add_action('after_setup_theme', 'calibrefx_custom_header');

/**
 * This function will activate the custom header image from WordPress
 *
 * It gets arguments passed through add_theme_support(), defines the constants,
 * and calls add_custom_image_header().
 *
 * @return void
 */
function calibrefx_custom_header() {

    $custom_header = get_theme_support('calibrefx-custom-header');
    /** If not active, do nothing */
    if (!$custom_header)
        return;

    /** Blog title option is obsolete when custom header is active */
    add_filter('calibrefx_pre_get_option_blog_title', '__return_empty_array');

    /** Cast, if necessary */
    $custom_header = isset($custom_header[0]) && is_array($custom_header[0]) ? $custom_header[0] : array();

    /** Merge defaults with passed arguments */
    $args = wp_parse_args($custom_header, array(
        'width' => 260,
        'height' => 100,
        'default-text-color' => '333333',
        'default-image' => CALIBREFX_IMAGES_URL . '/header.png',
        'header-text' => true,
        'wp-head-callback' => 'calibrefx_custom_header_style',
        'admin-head-callback' => 'calibrefx_custom_header_admin_style'
            ));

    /** Define all the constants */
    if (!defined('HEADER_IMAGE_WIDTH') && is_numeric($args['width']))
        define('HEADER_IMAGE_WIDTH', apply_filters('calibrefx_header_logo_width', $args['width']));

    if (!defined('HEADER_IMAGE_HEIGHT') && is_numeric($args['height']))
        define('HEADER_IMAGE_HEIGHT', apply_filters('calibrefx_header_logo_height', $args['height']));

    if (!defined('HEADER_TEXTCOLOR') && $args['default-text-color'])
        define('HEADER_TEXTCOLOR', apply_filters('calibrefx_header_text_color', $args['default-text-color']));

    if (!defined('HEADER_TEXT') && $args['header-text'])
        define('HEADER_TEXT', apply_filters('calibrefx_header_text', $args['header-text']));

    if (!defined('HEADER_IMAGE') && $args['default-image'])
        define('HEADER_IMAGE', apply_filters('calibrefx_header_logo_url', $args['default-image']));
		
	$custom_header_args = array(
		'width' => HEADER_IMAGE_WIDTH,
        'height' => HEADER_IMAGE_HEIGHT,
        'default-text-color' => HEADER_TEXTCOLOR,
        'default-image' => HEADER_IMAGE,
        'header-text' => HEADER_TEXT,
        'wp-head-callback' => 'calibrefx_custom_header_style',
        'admin-head-callback' => 'calibrefx_custom_header_admin_style'
	);

    /** Activate Custom Header */
    add_theme_support( 'custom-header', $custom_header_args );
}

/**
 * Header callback. It outputs special CSS to the document
 * head, modifying the look of the header based on user input.
 *
 */
function calibrefx_custom_header_style() {
    $header = '';
    $text = '';

    /** If no options set, don't waste the output. Do nothing. */
    if((HEADER_IMAGE == '' && get_header_image() == '') || (HEADER_TEXTCOLOR != 'blank' && get_header_textcolor() != 'blank') || (HEADER_TEXT && display_header_text())){
	   $text = sprintf('
#title, #title a{ 
    color: %s
}'."\n", get_header_textcolor());
    }else{
        $header = sprintf('
#header-title { 
    background: url(%1$s) no-repeat left center; 
    width: %2$spx; 
    height: %3$dpx
}', esc_url(get_header_image()), HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT);
    
        $text = sprintf('
#title, #title a, #title a:hover{ 
    display: block; 
    margin: 0; 
    overflow: hidden; 
    padding: 0;
    text-indent: -9999px; 
    width: %dpx; 
    height: %dpx 
}'."\n", HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT);
    }

    printf('<style type="text/css">%1$s %2$s</style>'."\n", $header, $text);
}

/**
 * Header admin callback. It outputs special CSS to the admin
 * document head, modifying the look of the header area based on user input.
 *
 * Will probably need to be overridden in the child theme with a custom callback.
 */
function calibrefx_custom_header_admin_style() {

    $headimg = sprintf('.appearance_page_custom-header #headimg { background: url(%s) no-repeat; min-height: %spx; }', get_header_image(), HEADER_IMAGE_HEIGHT);
    $h1 = sprintf('#headimg h1, #headimg h1 a { color: #%s; font-size: 24px; font-weight: normal; line-height: 30px; margin: 20px 0 0; text-decoration: none; }', esc_html(get_header_textcolor()));
    $desc = sprintf('#headimg #desc { color: #%s; font-size: 12px; font-style: italic; line-height: 1; margin: 0; }', esc_html(get_header_textcolor()));

    printf('<style type="text/css">%1$s %2$s %3$s</style>', $headimg, $h1, $desc);
}