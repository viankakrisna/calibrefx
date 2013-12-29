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
 * Calibrefx Seo Module
 *
 * @package		Calibrefx
 * @subpackage  Module
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

add_theme_support('calibrefx-seo');

add_action( 'init', 'init_calibrefx_seo' );
function init_calibrefx_seo(){
	global $calibrefx;
	if(current_theme_supports( 'calibrefx-seo' )){
		$calibrefx->load->file(__DIR__.'/Seo_settings.php');
		$calibrefx->load->file(__DIR__.'/Seo_settings_m.php');
	    $calibrefx->load->file(__DIR__.'/seo_helper.php');
		$calibrefx->load->file(__DIR__.'/seo_hook.php');

		$calibrefx->seo_settings_m = new Seo_settings_m();
	    $calibrefx->seo_settings = new CFX_Seo_Settings();

	    //Add submenu to calibrefx menu
		add_action('calibrefx_add_submenu_page', 'calibrefx_add_seo_settings',10);

		//Fire up
		do_action( 'calibrefx_seo' );
	}
}


function calibrefx_add_seo_settings(){
    global $menu, $calibrefx, $calibrefx_user_ability;

    // Disable if programatically disabled
    if (!current_theme_supports('calibrefx-admin-menu'))
        return;

    if( $calibrefx_user_ability !== 'professor' OR !current_theme_supports('calibrefx-seo') ){
        return;
    }

    // $calibrefx->load->library('seo_settings');
    
    $calibrefx->seo_settings->pagehook = add_submenu_page('calibrefx', __('Seo Settings', 'calibrefx'), __('Seo Settings', 'calibrefx'), 'edit_theme_options', 'calibrefx-seo', array($calibrefx->seo_settings, 'dashboard'));
}