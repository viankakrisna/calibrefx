<?php
/**
 * CalibreFx Framework
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @copyright   Copyright (c) 2012-2015, Calibreworks. (http://www.calibreworks.com/)
 * @license		GNU/GPL v2
 * @link		http://www.calibrefx.com
 *
 * The WordPress functions.php file. initialize CalibreFx framework and themes.
 *
 */

! defined( 'CALIBREFX_URI' ) && define( 'CALIBREFX_URI', get_template_directory() );
! defined( 'CALIBREFX_URL' ) && define( 'CALIBREFX_URL', get_template_directory_uri() );

/** Define Theme Info Constants */
$cfx_theme_data = wp_get_theme( 'calibrefx' );
define( 'FRAMEWORK_NAME', $cfx_theme_data->get( 'Name' ) );
define( 'FRAMEWORK_CODENAME', 'Blue Koala' );
define( 'FRAMEWORK_VERSION', $cfx_theme_data->get( 'Version' ) );
define( 'FRAMEWORK__MINIMUM_WP_VERSION', '4.1' );
define( 'FRAMEWORK_DB_VERSION', '1001' );
define( 'FRAMEWORK_URL', $cfx_theme_data->get( 'ThemeURI' ) );
define( 'FRAMEWORK_RELEASE_DATE', date_i18n( 'F j, Y', '1427392553' ) );

/** Run the calibrefx_pre Hook */
do_action( 'calibrefx_pre' );

/*
 * ------------------------------------------------------
 *  Load the global functions
 * ------------------------------------------------------
 */
require_once( CALIBREFX_URI . '/system/constants.php' );
require_once( CALIBREFX_URI . '/system/common.php' );

require_once( CALIBREFX_URI . '/system/class.calibrefx.php' );
require_once( CALIBREFX_URI . '/system/class.calibrefx-loader.php' );
require_once( CALIBREFX_URI . '/system/class.calibrefx-admin.php' );
require_once( CALIBREFX_URI . '/system/class.calibrefx-model.php' );
require_once( CALIBREFX_URI . '/system/class.calibrefx-generator.php' );

//Load deprecated functions
require_once( CALIBREFX_URI . '/system/deprecated.php' );

if ( is_admin() ){
	require_once( CALIBREFX_URI . '/system/class.calibrefx-modules-list-table.php' );
}

if ( ! isset( $content_width ) ) {
	$content_width = apply_filters( 'calibrefx_content_width', 550 );
}

/**
 * Run the Engine
 */
function calibrefx_initializing() {
	global $calibrefx;
	$calibrefx = Calibrefx::get_instance();

	// Add theme support
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
	add_theme_support( 'menus' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	if ( is_child_theme() ) {
		add_filter( 'calibrefx_helpers_to_include', 'childfx_load_helpers' );
		add_filter( 'calibrefx_shortcodes_to_include', 'childfx_load_shortcodes' );
		add_filter( 'calibrefx_hooks_to_include', 'childfx_load_hooks' );
		add_filter( 'calibrefx_widgets_to_include', 'childfx_load_widgets' );
	}

	//Load every active module
	Calibrefx::load_modules();

	// Run the engine
	$calibrefx->run();

	/** Run the calibrefx_post_init hook */
	do_action( 'calibrefx_post_init' );

}
add_action( 'after_setup_theme', 'calibrefx_initializing', 0 );

function calibrefx_initialize_other() {
	if( is_woocommerce_activated() ) {
		// Support for Woocoomerce
		add_theme_support( 'woocommerce' );

		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}

	//remove unneccesary headers
	remove_action( 'wp_head', 'wp_generator' );
}
add_action( 'after_setup_theme', 'calibrefx_initialize_other', 99 );

/**
 * Load helpers from child themes
 * @param  array $helpers_include
 * @return array
 */
function childfx_load_helpers( $helpers_include ){
	$childfx_helpers = array();

	foreach ( Calibrefx::glob_php( CHILD_URI . '/' . CHILD_APP_DIR . '/' . 'helpers' ) as $file ) {
		$childfx_helpers[] = $file;
	}

	return array_merge( $helpers_include, $childfx_helpers );
}

/**
 * Load shortcodes from child themes
 * @param  array $shortcodes_include
 * @return array
 */
function childfx_load_shortcodes( $shortcodes_include ){
	$childfx_shortcodes = array();

	foreach ( Calibrefx::glob_php( CHILD_URI . '/' . CHILD_APP_DIR . '/' . 'shortcodes' ) as $file ) {
		$childfx_shortcodes[] = $file;
	}

	return array_merge( $shortcodes_include, $childfx_shortcodes );
}

/**
 * Load hooks from child themes
 * @param  array $hooks_include
 * @return array
 */
function childfx_load_hooks( $hooks_include ){
	$childfx_hooks = array();

	foreach ( Calibrefx::glob_php( CHILD_URI . '/' . CHILD_APP_DIR . '/' . 'hooks' ) as $file ) {
		$childfx_hooks[] = $file;
	}

	return array_merge( $hooks_include, $childfx_hooks );
}

/**
 * Load widgets from child themes
 * @param  array $hooks_include
 * @return array
 */
function childfx_load_widgets( $widgets_include ){
	$childfx_widgets = array();

	foreach ( Calibrefx::glob_php( CHILD_URI . '/' . CHILD_APP_DIR . '/' . 'widgets' ) as $file ) {
		$childfx_widgets[] = $file;
	}

	return array_merge( $widgets_include, $childfx_widgets );
}


/**
 * Enable GZip Compression
 */
function calibrefx_gzip_compression() {
	if ( ! current_theme_supports( 'calibrefx-preformance' ) ){
		return false;
	}

	// can't use zlib.output_compression and ob_gzhandler at the same time
	if ( ( 'On' == ini_get( 'zlib.output_compression' ) || ini_get( 'zlib.output_compression_level' ) > 0 ) OR 'ob_gzhandler' == ini_get( 'output_handler' ) ) {
		return false;
	}

	if ( extension_loaded( 'zlib' ) ) {
		ob_end_clean();
		ob_start( 'ob_gzhandler' );
	}
}
add_action( 'init', 'calibrefx_gzip_compression' );