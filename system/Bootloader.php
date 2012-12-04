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
 * This will initialize everything
 */

!defined('CALIBREFX_URI') && define('CALIBREFX_URI', get_template_directory());
!defined('CALIBREFX_URL') && define('CALIBREFX_URL', get_template_directory_uri());

/** Run the calibrefx_pre Hook */
do_action('calibrefx_pre');

/** Define Theme Info Constants */
define('FRAMEWORK_NAME', 'CalibreFx');
define('FRAMEWORK_CODENAME', 'Pink Gibbon');
define('FRAMEWORK_VERSION', '1.0.6');
define('FRAMEWORK_DB_VERSION', '1000');
define('FRAMEWORK_URL', 'http://www.calibrefx.com');
define('FRAMEWORK_RELEASE_DATE', date_i18n('F j, Y', '1327922947'));

/*
 * ------------------------------------------------------
 *  Load the global functions
 * ------------------------------------------------------
 */
require_once( CALIBREFX_URI . '/system/config/constants.php');
require_once( CALIBREFX_URI . '/system/core/Common.php' );

/*
 * ------------------------------------------------------
 *  Load Core Class
 * ------------------------------------------------------
 */
require_once( CALIBREFX_URI . '/system/core/Calibrefx.php' );

global $calibrefx;
$calibrefx = &calibrefx_get_instance();

/** Run the calibrefx_pre_init hook */
do_action('calibrefx_pre_init');

/** Run the calibrefx_init hook */
do_action('calibrefx_init');

/** Run the calibrefx_post_init hook */
do_action('calibrefx_post_init');

/** Run the calibrefx_setup hook */
do_action('calibrefx_setup');

calibrefx_log_message('debug', '--- Output Send to Browser ---');

/* End of file calibrefx.php */
/* Location: ./calibrefx/calibrefx.php */