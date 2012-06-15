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
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This file hold all the functions to control breadcrumb
 *
 * @package CalibreFx
 */
 
/**
 * Helper function for to display Calibrefx BreadCrumb
 *
 */
function calibrefx_breadcrumb( $args = array() ) {

	global $_calibrefx_breadcrumb;

	if ( !$_calibrefx_breadcrumb ) {
		$_calibrefx_breadcrumb = new CFX_Breadcrumb;
	}
        
	$_calibrefx_breadcrumb->output( $args );

}

add_action('calibrefx_before_loop', 'calibrefx_do_breadcrumbs');
/**
 * Display Breadcrumbs above the Loop
 * Concedes priority to popular breadcrumb plugins
 *
 * @since 0.1.6
 */
function calibrefx_do_breadcrumbs() {

	// Conditional Checks
	if ( ( is_front_page() || is_home() ) && ! calibrefx_get_option( 'breadcrumb_home' ) ) return;
	if ( is_single() && ! calibrefx_get_option( 'breadcrumb_single' ) ) return;
	if ( is_page() && ! calibrefx_get_option( 'breadcrumb_page' ) ) return;
	if ( ( is_archive() || is_search() ) && ! calibrefx_get_option( 'breadcrumb_archive' ) ) return;
	if ( is_404() && ! calibrefx_get_option( 'breadcrumb_404' ) ) return;

	calibrefx_breadcrumb();

}