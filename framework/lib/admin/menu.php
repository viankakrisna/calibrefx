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
 * @link		http://calibreworks.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This file will handle CalibreFx Themes Menu
 *
 * @package CalibreFx
 */
 
add_action('admin_menu', 'calibrefx_add_admin_menu');
//	This function adds the top-level menu
function calibrefx_add_admin_menu() {

	global $menu;

	// Disable if programatically disabled
	if ( !current_theme_supports('calibrefx-admin-menu') ) return;

	// Create the new separator
	$menu['58.995'] = array( '', 'edit_theme_options', '', '', 'wp-menu-separator' );

	// Create the new top-level Menu
	add_menu_page(__('Calibre Framework Settings','calibrefx'), 'CalibreFx', 'edit_theme_options', 'calibrefx', 'calibrefx_theme_settings_admin', CALIBREFX_IMAGES_URL.'/calibrefx.gif', '58.996');
}

add_action('admin_menu', 'calibrefx_add_admin_submenus');
// This function adds the submenus
function calibrefx_add_admin_submenus() {

	global	$_calibrefx_theme_settings_pagehook, 
			$_calibrefx_about_pagehook;

	if( !current_theme_supports('calibrefx-admin-menu') ) return;

	$user = wp_get_current_user();

	// Add "Theme Settings" submenu
	$_calibrefx_theme_settings_pagehook = add_submenu_page('calibrefx', __('Theme Settings','calibrefx'), __('Theme Settings','calibrefx'), 'edit_theme_options', 'calibrefx', 'calibrefx_theme_settings_admin');

	// Add "About" submenu
	$_calibrefx_about_pagehook = add_submenu_page('calibrefx', __('About','calibrefx'), __('About','calibrefx'), 'edit_theme_options', 'calibrefx-about', 'calibrefx_about_page');
}