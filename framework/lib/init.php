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
 * This is the magic file that fire everything.
 *
 * @package CalibreFx
 */
 
 /** Run the calibrefx_pre Hook */
do_action( 'calibrefx_pre' );

add_action( 'calibrefx_init', 'calibrefx_theme_support' );
/**
 * This function activates default theme features
 */
function calibrefx_theme_support() {

	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'calibrefx-admin-menu' );
	add_theme_support( 'calibrefx-custom-header' );
        add_theme_support( 'calibrefx-default-styles' );
	
	if ( ! current_theme_supports( 'calibrefx-menus' ) ) {
		add_theme_support( 'calibrefx-menus', 
			array( 
				'primary' => __( 'Primary Navigation Menu', 'calibrefx' ), 
				'secondary' => __( 'Secondary Navigation Menu', 'calibrefx' ) 
			) 
		);
	}
}

add_action( 'calibrefx_init', 'calibrefx_constants', 5 );
/**
 * This function defines the CalibreFx constants
 *
 */
function calibrefx_constants() {

	/** Define Theme Info Constants */
	define( 'FRAMEWORK_NAME', 'CalibreFx' );
	define( 'FRAMEWORK_CODENAME', 'Pink Gibbon' );
	define( 'FRAMEWORK_VERSION', '1.0' );
	define( 'FRAMEWORK_DB_VERSION', '1000' );
	define( 'FRAMEWORK_URL', 'http://www.calibrefx.com' );
	define( 'FRAMEWORK_RELEASE_DATE', date_i18n( 'F j, Y', '1327922947' ) );
        //define( 'FRAMEWORK_BRANCH', 'Development Branch'); //i just want to test how git works

	/** Define CALIBREFX Root Directory Constant */
	define( 'CALIBREFX_DIR', get_template_directory() );
	define( 'CALIBREFX_LIB_DIR', CALIBREFX_DIR . '/framework/lib' );
	
	/** Define Directory Location Constants */
	define( 'CALIBREFX_IMAGES_DIR', CALIBREFX_DIR . '/assets/img' );
	define( 'CALIBREFX_JS_DIR', CALIBREFX_DIR . '/assets/js' );
	define( 'CALIBREFX_CSS_DIR', CALIBREFX_DIR . '/assets/css' );
	
	define( 'CALIBREFX_ADMIN_DIR', CALIBREFX_LIB_DIR . '/admin' );
	define( 'CALIBREFX_CLASSES_DIR', CALIBREFX_LIB_DIR . '/classes' );
	define( 'CALIBREFX_FUNCTIONS_DIR', CALIBREFX_LIB_DIR . '/functions' );
	define( 'CALIBREFX_SHORTCODES_DIR', CALIBREFX_LIB_DIR . '/shortcodes' );
	define( 'CALIBREFX_STRUCTURE_DIR', CALIBREFX_LIB_DIR . '/structure' );
	define( 'CALIBREFX_WIDGETS_DIR', CALIBREFX_LIB_DIR . '/widgets' );

	/** Define CALIBREFX Root URL Constant */
	define( 'CALIBREFX_URL', get_template_directory_uri() );
	define( 'CALIBREFX_LIB_URL', CALIBREFX_URL . '/framework/lib' );
	
	/** Define URL Location Constants */
	define( 'CALIBREFX_IMAGES_URL', CALIBREFX_URL . '/assets/img' );
	define( 'CALIBREFX_JS_URL', CALIBREFX_URL . '/assets/js' );
	define( 'CALIBREFX_CSS_URL', CALIBREFX_URL . '/assets/css' );
	
	define( 'CALIBREFX_ADMIN_URL', CALIBREFX_LIB_URL . '/admin' );
	define( 'CALIBREFX_ADMIN_IMAGES_URL', CALIBREFX_LIB_URL . '/admin/img' );
	define( 'CALIBREFX_CLASSES_URL', CALIBREFX_LIB_URL . '/classes' );
	define( 'CALIBREFX_FUNCTIONS_URL', CALIBREFX_LIB_URL . '/functions' );
	define( 'CALIBREFX_SHORTCODES_URL', CALIBREFX_LIB_URL . '/shortcodes' );
	define( 'CALIBREFX_STRUCTURE_URL', CALIBREFX_LIB_URL . '/structure' );
	define( 'CALIBREFX_WIDGETS_URL', CALIBREFX_LIB_URL . '/widgets' );
	
	/** Define Settings Field Constants (for DB storage) */
	define( 'CALIBREFX_SETTINGS_FIELD', apply_filters( 'calibrefx_settings_field', 'calibrefx-settings' ) );
	
	/** Define CALIBREFX Child Directory Constant */
	define( 'CHILD_DIR', get_stylesheet_directory() );
	define( 'CHILD_CACHE_DIR', CHILD_DIR . '/cache' );
	define( 'CHILD_IMAGES_DIR', CHILD_DIR . '/assets/img' );
	define( 'CHILD_JS_DIR', CHILD_DIR . '/assets/js' );
	define( 'CHILD_CSS_DIR', CHILD_DIR . '/assets/css' );
	
	/** Define CALIBREFX Child URL Location Constant */
	define( 'CHILD_URL', get_stylesheet_directory_uri() );
	define( 'CHILD_CACHE_URL', CHILD_URL . '/cache' );
	define( 'CHILD_IMAGES_URL', CHILD_URL . '/assets/img' );
	define( 'CHILD_JS_URL', CHILD_URL . '/assets/js' );
	define( 'CHILD_CSS_URL', CHILD_URL . '/assets/css' );
}

add_action( 'calibrefx_init', 'calibrefx_post_type_support' );
/**
 * Initialize post type support for Calibrefx features such as layout selector & seo setting.
 */
function calibrefx_post_type_support() {
	add_post_type_support( 'post', array( 'calibrefx-seo', 'calibrefx-layouts' ) );
	add_post_type_support( 'page', array( 'calibrefx-seo', 'calibrefx-layouts' ) );
}


//We need to run this after all the init
add_action( 'calibrefx_init', 'calibrefx_load_framework' );
/**
 * This function loads all the framework files and features
 */
function calibrefx_load_framework() {
	/** Run the calibrefx_pre_framework Hook */
	do_action( 'calibrefx_pre_framework' );
	
	//Core Functions
	require_once( CALIBREFX_FUNCTIONS_DIR . '/debug.php' );
	
	/** Load Scripts and Styles */
	require_once( CALIBREFX_FUNCTIONS_DIR . '/load.php' );
	
	/** Load Classes */
	require_once( CALIBREFX_CLASSES_DIR . '/cache.php' );
	require_once( CALIBREFX_CLASSES_DIR . '/breadcrumb.php' );
	require_once( CALIBREFX_CLASSES_DIR . '/menu.php' );
	require_once( CALIBREFX_CLASSES_DIR . '/admin-bar.php' );
	
	/** Load Functions */
	
	require_once( CALIBREFX_FUNCTIONS_DIR . '/general.php' );
	require_once( CALIBREFX_FUNCTIONS_DIR . '/options.php' );
	require_once( CALIBREFX_FUNCTIONS_DIR . '/widgets.php' );
	require_once( CALIBREFX_FUNCTIONS_DIR . '/format.php' );
	require_once( CALIBREFX_FUNCTIONS_DIR . '/images.php' );
	require_once( CALIBREFX_FUNCTIONS_DIR . '/upgrade.php' );
	
	/** Load Shortcodes */
	require_once( CALIBREFX_SHORTCODES_DIR . '/footer.php' );
	require_once( CALIBREFX_SHORTCODES_DIR . '/content.php' );
	
	/** Load Structure */
	require_once( CALIBREFX_STRUCTURE_DIR . '/header.php' );
	require_once( CALIBREFX_STRUCTURE_DIR . '/footer.php' );
	require_once( CALIBREFX_STRUCTURE_DIR . '/layout.php' );
	require_once( CALIBREFX_STRUCTURE_DIR . '/sidebar.php' );
	require_once( CALIBREFX_STRUCTURE_DIR . '/content.php' );
	require_once( CALIBREFX_STRUCTURE_DIR . '/comments.php' );
	require_once( CALIBREFX_STRUCTURE_DIR . '/menu.php' );
	require_once( CALIBREFX_STRUCTURE_DIR . '/search.php' );
	require_once( CALIBREFX_STRUCTURE_DIR . '/breadcrumb.php' );
	require_once( CALIBREFX_STRUCTURE_DIR . '/navigation.php' );
	
	/** Load Admin */
	if ( is_admin() ) :
	require_once( CALIBREFX_ADMIN_DIR . '/default-settings.php' );
	require_once( CALIBREFX_ADMIN_DIR . '/menu.php' );
	require_once( CALIBREFX_ADMIN_DIR . '/theme-settings.php' );
	require_once( CALIBREFX_ADMIN_DIR . '/about-page.php' );
	endif;
	require_once( CALIBREFX_ADMIN_DIR . '/admin-bar.php' );
	require_once( CALIBREFX_ADMIN_DIR . '/admin-login.php' );
	require_once( CALIBREFX_ADMIN_DIR . '/user-meta.php' );

	/** Load Widgets */	
	require_once( CALIBREFX_WIDGETS_DIR . '/widgets.php' );
	
	/** Run the calibrefx_post_framework Hook */
	do_action( 'calibrefx_post_framework' );
}

/** Run the calibrefx_pre_init hook */
do_action('calibrefx_pre_init');

/** Run the calibrefx_init hook */
do_action('calibrefx_init');

/** Run the calibrefx_post_init hook */
do_action('calibrefx_post_init');

/** Run the calibrefx_setup hook */
do_action('calibrefx_setup');

/* End of file init.php */
/* Location: ./calibrefx/lib/init.php */