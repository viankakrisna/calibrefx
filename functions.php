<?php
/**
 * CalibreFx Framework
 *
 * WordPress Themes by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @copyright   Copyright (c) 2012-2014, Calibreworks. (http://www.calibreworks.com/)
 * @license		GNU/GPL v2
 * @link		http://www.calibrefx.com
 * @filesource 
 *
 * The WordPress functions.php file. initialize CalibreFx framework and themes.
 *
 */

!defined('CALIBREFX_URI') && define('CALIBREFX_URI', get_template_directory());
!defined('CALIBREFX_URL') && define('CALIBREFX_URL', get_template_directory_uri());

/** Define Theme Info Constants */
define('FRAMEWORK_NAME', 'Calibrefx');
define('FRAMEWORK_CODENAME', 'Red Penguin');
define('FRAMEWORK_VERSION', '2.0a');
define('FRAMEWORK_DB_VERSION', '1000');
define('FRAMEWORK_URL', 'http://www.calibrefx.com');
define('FRAMEWORK_RELEASE_DATE', date_i18n('F j, Y', '1400033811'));

/** Run the calibrefx_pre Hook */
do_action('calibrefx_pre');

/*
 * ------------------------------------------------------
 *  Load the global functions
 * ------------------------------------------------------
 */
require_once( CALIBREFX_URI . '/system/config/constants.php');
require_once( CALIBREFX_URI . '/system/core/Common.php' );
require_once( CALIBREFX_URI . '/system/core/Model.php' );
require_once( CALIBREFX_URI . '/system/core/Generator.php' );
require_once( CALIBREFX_URI . '/system/core/Calibrefx.php' );

// Our global variables
global $calibrefx, $cfxgenerator;

//Initialize cfxgenerator instance
$cfxgenerator = CFX_Generator::get_instance();

//Initialize calibrefx instance
$calibrefx = calibrefx_get_instance();

if ( ! isset( $content_width ) ) {
    $content_width = apply_filters( 'calibrefx_content_width', 550 );
}


add_action( 'after_setup_theme', function(){
	global $calibrefx, $cfxgenerator;
	
	// Add theme support
	add_theme_support('html5', array( 'comment-list', 'comment-form', 'search-form' ));
    add_theme_support('menus');
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	//remove unneccesary headers 
	remove_action('wp_head', 'wp_generator');

	// Run the engine 
	$calibrefx->load->do_autoload();
	$cfxgenerator->run_hook();
	$calibrefx->run();
	
	if( is_child_theme() ) {
		$calibrefx->load->add_child_path(CHILD_URI . '/app');
		$calibrefx->load->do_autoload(CHILD_URI . '/app/config/autoload.php');
	}
}, 0 );

/*add_action( 'wp', function(){
	global $calibrefx, $cfxgenerator;
	wp_cache_set( 'calibrefx', $calibrefx );
	wp_cache_set( 'cfxgenerator', $cfxgenerator );
} );*/