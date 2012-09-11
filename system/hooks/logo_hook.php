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
 * Calibrefx Logo Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
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
        'textcolor' => '333333',
        'no_header_text' => false,
        'header_image' => '%s/header.png',
        'header_callback' => 'calibrefx_custom_header_style',
        'admin_header_callback' => 'calibrefx_custom_header_admin_style'
            ));

    /** Define all the constants */
    if (!defined('HEADER_IMAGE_WIDTH') && is_numeric($args['width']))
        define('HEADER_IMAGE_WIDTH', $args['width']);

    if (!defined('HEADER_IMAGE_HEIGHT') && is_numeric($args['height']))
        define('HEADER_IMAGE_HEIGHT', $args['height']);

    if (!defined('HEADER_TEXTCOLOR') && $args['textcolor'])
        define('HEADER_TEXTCOLOR', $args['textcolor']);

    if (!defined('NO_HEADER_TEXT') && $args['no_header_text'])
        define('NO_HEADER_TEXT', $args['no_header_text']);

    if (!defined('HEADER_IMAGE') && $args['header_image'])
        define('HEADER_IMAGE', sprintf($args['header_image'], apply_filters('calibrefx_images_url', CALIBREFX_IMAGES_URL)));

    /** Activate Custom Header */
    add_custom_image_header($args['header_callback'], $args['admin_header_callback']);
}

/**
 * Header callback. It outputs special CSS to the document
 * head, modifying the look of the header based on user input.
 *
 */
function calibrefx_custom_header_style() {
    /** If no options set, don't waste the output. Do nothing. */
    if (HEADER_TEXTCOLOR == get_header_textcolor() && HEADER_IMAGE == get_header_image())
        return;

	if( calibrefx_get_option( 'enable_responsive' )){
		$header = sprintf('@media (min-width:961px){#header-title { background: url(%1$s) no-repeat left center; width:%2$s; height: %3$dpx}} @media (max-width:960px){#header-title {background: url(%1$s) no-repeat left center; width:%4$s; height: %3$dpx}}', esc_url(get_header_image()), HEADER_IMAGE_WIDTH . 'px', HEADER_IMAGE_HEIGHT, '100%');
	}else{
		$header = sprintf('#header-title { background: url(%1$s) no-repeat left center; width:%2$s; height: %3$dpx}', esc_url(get_header_image()), HEADER_IMAGE_WIDTH . 'px', HEADER_IMAGE_HEIGHT);
	}
	
    $text = sprintf('#title, #title a, #title a:hover{ display: block; margin: 0; overflow: hidden; padding: 0;text-indent: -9999px; color: #%s; width:%dpx; height: %dpx }', esc_html(get_header_textcolor()), HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT);
    $header_ie = sprintf('#header-title { background: url(%1$s) no-repeat left center; width:%2$s; height: %3$dpx}', esc_url(get_header_image()), HEADER_IMAGE_WIDTH . 'px', HEADER_IMAGE_HEIGHT);
	
    printf('<style type="text/css">%1$s %2$s</style>'."\n", $header, $text);
	printf('<!--[if lt IE 9]><style type="text/css">%1$s</style><![endif]-->'."\n", $header_ie);
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