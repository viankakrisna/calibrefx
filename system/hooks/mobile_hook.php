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

add_action('calibrefx_setup', 'calibrefx_detect_mobile_browser', 15);
function calibrefx_detect_mobile_browser(){
	global $oBrowser,$calibrefx;

	if(is_admin() || !$oBrowser->isMobile() || !calibrefx_get_option('enable_mobile') || !calibrefx_mobile_themes_exist()){
		return;
	}
	
	//@TODO: overwrite themes here
	// add_filter('theme_root', 'calibrefx_set_mobile_themes_folder');
	// add_filter('theme_root_uri', 'calibrefx_set_mobile_themes_uri');
	add_filter('stylesheet', 'calibrefx_get_mobile_theme');
	add_filter('template', 'calibrefx_get_mobile_theme');
	add_filter('calibrefx_site_layout', 'calibrefx_layout_full_width');

	remove_action('calibrefx_after_header', 'calibrefx_do_nav');
	remove_action('calibrefx_after_header', 'calibrefx_do_subnav');
	remove_action('calibrefx_before_loop', 'calibrefx_do_breadcrumbs');
}
