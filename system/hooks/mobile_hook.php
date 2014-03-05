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
 * Calibrefx Mobile Hooks
 *
 * @package		Calibrefx
 * @subpackage  Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

global $cfxgenerator;

$cfxgenerator->calibrefx_setup = array(
    array(
        'function' => 'calibrefx_detect_mobile_browser',
        'priority' => 15,
    )
);

/********************
 * FUNCTIONS BELOW  *
 ********************/

/**
 * If mobile site is enable and there is a mobile template, then display mobile layout on mobile
 */
function calibrefx_detect_mobile_browser(){
	global $oBrowser,$calibrefx; 

	if(is_admin() || !$oBrowser->isMobile() || !get_theme_support('mobile-site') || !calibrefx_mobile_themes_exist()){
		return;
	}

	add_filter('template_include', 'calibrefx_get_mobile_template');

	if(file_exists(CHILD_MOBILE_URI . '/mobile.php')){
		include_once CHILD_MOBILE_URI . '/mobile.php';
	}
}