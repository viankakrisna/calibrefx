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
 * This file control default widgets
 *
 * @package CalibreFx
 */

/**
 * This function expedites the widget area registration process by taking
 * common things, before/after_widget, before/after_title, and doing them automatically.
 *
 * @uses wp_parse_args, register_sidebar
 * @since 1.0.1
 * @author Charles Clarkson
 */
function calibrefx_register_sidebar($args) {
	$defaults = (array) apply_filters( 'calibrefx_register_sidebar_defaults', array(
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrap">',
		'after_widget'  => "</div></div>\n",
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => "</h4>\n"
	) );

	$args = wp_parse_args($args, $defaults);

	return register_sidebar($args);
}

add_action( 'calibrefx_setup', 'calibrefx_register_default_widget' );
/**
 * This function registers all the default CalibreFx widget.
 *
 */
function calibrefx_register_default_widget() {

	calibrefx_register_sidebar(array(
		'name' => __('Header Right', 'calibrefx'),
		'description' => __('This is the right side of the header', 'calibrefx'),
		'id' => 'header-right'
	));

	calibrefx_register_sidebar(array(
		'name' => __('Primary Sidebar', 'calibrefx'),
		'description' => __('This is the primary sidebar if you are using a 2 or 3 column site layout option', 'calibrefx'),
		'id' => 'sidebar'
	));

	calibrefx_register_sidebar(array(
		'name' => __('Secondary Sidebar', 'calibrefx'),
		'description' => __('This is the secondary sidebar if you are using a 3 column site layout option', 'calibrefx'),
		'id' => 'sidebar-alt'
	));
	
	calibrefx_register_sidebar(array(
		'name' => __('Footer Widget', 'calibrefx'),
		'description' => __('This is the footer widget', 'calibrefx'),
		'id' => 'footer-widget',
	));
}
