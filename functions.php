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
define( 'FRAMEWORK_RELEASE_DATE', date_i18n( 'F j, Y', '1430537640' ) );

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
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array(
		'aside', 'status', 'image', 'video', 'audio', 'quote', 'link', 'gallery', 'chat'
	) );

	if ( is_child_theme() ) {
		add_filter( 'calibrefx_helpers_to_include', 'childfx_load_extension', 10, 2 );
		add_filter( 'calibrefx_shortcodes_to_include', 'childfx_load_extension', 15, 2 );
		add_filter( 'calibrefx_hooks_to_include', 'childfx_load_extension', 20, 2 );
		add_filter( 'calibrefx_widgets_to_include', 'childfx_load_extension', 25, 2 );
		add_filter( 'calibrefx_library_path', 'childfx_load_library' );
	}

	//Load every active module
	Calibrefx::load_modules();

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'assets/css/editor-style.css', 'assets/css/cfxicons.css', 'assets/css/font-awesome.css', 'assets/css/genericons.css', calibrefx_fonts_url() ) );

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
 * Load extension: helpers, hooks, widgets, and shortcodes
 * @param  string $type: helpers, hooks, widgets, and shortcodes
 * @param  array $hooks_include
 * @return array
 */
function childfx_load_extension( $files_included, $type ){
	$allowed_types = array( 'helpers', 'hooks', 'widgets', 'shortcodes' );

	if( !in_array( $type, $allowed_types ) ) return false;
	$local_files = array();

	foreach ( Calibrefx::glob_php( CHILD_URI . '/' . CHILD_APP_DIR . '/' . $type ) as $file ) {
		$local_files[] = $file;
	}

	return array_merge( $files_included, $local_files );
}

/**
 * Load library from child themes
 * @param  array $library_path
 * @return array
 */
function childfx_load_library( $library_path ){
	
	if( file_exists( CHILD_LIBRARY_URI ) ){
		$library_path[] = CHILD_LIBRARY_URI;
	}

	return $library_path;
}



/**
 * Enable GZip Compression
 */
function calibrefx_gzip_compression() {
	if ( ! current_theme_supports( 'calibrefx-preformance' ) OR is_admin() ){
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

if ( ! function_exists( 'calibrefx_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Fifteen.
 *
 * @since Twenty Fifteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function calibrefx_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Titillium Web font: on or off', 'calibrefx' ) ) {
		$fonts[] = 'Titillium Web:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Serif, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'calibrefx' ) ) {
		$fonts[] = 'Roboto:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Inconsolata, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'calibrefx' ) ) {
		$fonts[] = 'Inconsolata:400,700';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'calibrefx' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( ! empty( $fonts ) ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
	}

	return  apply_filters( 'calibrefx_fonts_url', $fonts_url );
}
endif;