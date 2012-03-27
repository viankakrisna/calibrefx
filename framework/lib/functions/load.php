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
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This file will enqueue javascript to header
 *
 * @package CalibreFx
 */
 
add_action( 'get_header', 'calibrefx_load_scripts' );
/**
 * This function loads front-end JS files
 *
 */
function calibrefx_load_scripts() {
	wp_register_script( 'jquery-validate', CALIBREFX_JS_URL . '/jquery.validate.js', array('jquery'), FRAMEWORK_VERSION );
	wp_register_script( 'jquery-sticky', CALIBREFX_JS_URL . '/jquery.sticky.js', array('jquery'), FRAMEWORK_VERSION );
	
	wp_enqueue_script('calibrefx_bootstrap',CALIBREFX_JS_URL . '/bootstrap.min.js', array('jquery'), FRAMEWORK_VERSION);
	wp_enqueue_script('calibrefx_script',CALIBREFX_JS_URL . '/calibrefx.js', array('jquery','jquery-validate'), FRAMEWORK_VERSION);
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() )
		wp_enqueue_script( 'comment-reply' );
		
	wp_enqueue_script( 'superfish', CALIBREFX_JS_URL . '/superfish.js', array( 'jquery' ), FRAMEWORK_VERSION, true );
}

//We load calibrefx default styles as earlier as possible, so it can be override
add_action('calibrefx_meta', 'calibrefx_load_styles', 5); 
/**
 * Load default calibrefx styles
 * 
 * since @1.0
 */
function calibrefx_load_styles() {
    $calibrefx_default_style = get_theme_support( 'calibrefx-default-styles' );
    
    wp_register_style( 'calibrefx-style', CALIBREFX_CSS_URL . '/calibrefx.css', FRAMEWORK_VERSION );
    
    /** If not active, do nothing */
    if ( ! $calibrefx_default_style )
            return;
    wp_enqueue_style('calibrefx-style');
    
}

add_action( 'admin_init', 'calibrefx_load_admin_scripts' );
/**
 * This function loads the admin JS files
 *
 */
function calibrefx_load_admin_scripts() {
	wp_register_script( 'jquery-sticky', CALIBREFX_JS_URL . '/jquery.sticky.js', array('jquery'), FRAMEWORK_VERSION );
	wp_register_script( 'calibrefx-admin-bar', CALIBREFX_JS_URL . '/calibrefx-admin-bar.js', array('jquery'), FRAMEWORK_VERSION );
	
	add_thickbox();
	wp_enqueue_script( 'theme-preview' );
	wp_enqueue_script( 'calibrefx-admin-bar' );
	wp_enqueue_script( 'calibrefx_admin_js', CALIBREFX_JS_URL . '/admin.js', array( 'jquery','jquery-sticky' ), FRAMEWORK_VERSION, true );
	$params = array(
		'category_checklist_toggle' => __( 'Select / Deselect All', 'genesis' )
	);
	wp_localize_script( 'calibrefx_admin_js', 'calibrefx', $params );
}

add_action( 'admin_init', 'calibrefx_load_admin_styles' );
function calibrefx_load_admin_styles() {
	wp_enqueue_style( 'calibrefx-admin-css', CALIBREFX_CSS_URL . '/calibrefx.admin.css', array(), FRAMEWORK_VERSION );
	wp_enqueue_style('admin-bar');
}

