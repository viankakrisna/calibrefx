<?php
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
 * This will initialize everything
 */

!defined('CALIBREFX_URI') && define('CALIBREFX_URI', get_template_directory());
!defined('CALIBREFX_URL') && define('CALIBREFX_URL', get_template_directory_uri());

/** Run the calibrefx_pre Hook */
do_action('calibrefx_pre');

/** Define Theme Info Constants */
define('FRAMEWORK_NAME', 'Calibrefx');
define('FRAMEWORK_CODENAME', 'Pink Gibbon');
define('FRAMEWORK_VERSION', '1.0.18');
define('FRAMEWORK_DB_VERSION', '1000');
define('FRAMEWORK_URL', 'http://www.calibrefx.com');
define('FRAMEWORK_RELEASE_DATE', date_i18n('F j, Y', '1380875819'));
// wp_cache_flush();
/*
 * ------------------------------------------------------
 *  Load the global functions
 * ------------------------------------------------------
 */
require_once( CALIBREFX_URI . '/system/config/constants.php');
require_once( CALIBREFX_URI . '/system/core/Common.php' );
require_once( CALIBREFX_URI . '/system/core/Model.php' );
require_once( CALIBREFX_URI . '/system/core/Generator.php' );
global $calibrefx, $cfxgenerator;
$cfxgenerator = CFX_Generator::get_instance();
// var_dump($cfxgenerator);exit;
/*
 * ------------------------------------------------------
 *  Load Core Class
 * ------------------------------------------------------
 */
require_once( CALIBREFX_URI . '/system/core/Calibrefx.php' );

//Initialize calibrefx instance
$calibrefx = calibrefx_get_instance();

add_action( 'after_setup_theme', function(){
	global $calibrefx, $cfxgenerator;
	$calibrefx->load->do_autoload();
	$cfxgenerator->run_hook();
	$calibrefx->run();
},0);

add_action( 'wp', function(){
	global $calibrefx, $cfxgenerator;
	wp_cache_set( 'calibrefx', $calibrefx );
	wp_cache_set( 'cfxgenerator', $cfxgenerator );
} );


/** Run the calibrefx_pre_init hook */
// do_action('calibrefx_pre_init');

/** Run the calibrefx_init hook */
// do_action('calibrefx_init');

/** Run the calibrefx_post_init hook */
// do_action('calibrefx_post_init');

/** Run the calibrefx_setup hook */
// do_action('calibrefx_setup');

/* End of file calibrefx.php */
/* Location: ./calibrefx/calibrefx.php */