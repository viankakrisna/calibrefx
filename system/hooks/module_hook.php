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
 * Calibrefx Module Hooks
 *
 * @package		Calibrefx
 * @subpackage  Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

add_action( 'calibrefx_post_init','calibrefx_initialize_module' );
function calibrefx_initialize_module(){
	foreach (calibrefx_get_active_modules() as $module) {
		include_once( $module );
	}
}

/**
 * Add module to the available module directory
 */
function calibrefx_add_module($module_path){

}

function calibrefx_activate_module($module_path){
	$active_modules = calibrefx_get_active_modules();

	if(!in_array($module_path, $active_modules)){
		$active_modules[] = $module_path;
		update_option( 'calibrefx_active_modules', $active_modules );
	}	
}

function calibrefx_deactivate_module($module_path){
	$active_modules = calibrefx_get_active_modules();
	if(in_array($module_path, $active_modules)){
		$key = array_search($module_path, $active_modules);
		unset($active_modules[$key]);
		update_option( 'calibrefx_active_modules', $active_modules );
	}	
}