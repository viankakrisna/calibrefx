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
 * This is contain function and register wordpress menu
 *
 * @package CalibreFx
 */
 
add_action('after_setup_theme', calibrefx_register_nav_menus);
/**
 * Register CalibreFx menus with WordPress menu
 */
function calibrefx_register_nav_menus(){
	if ( ! current_theme_supports( 'calibrefx-menus' ) )
		return false;
		
	$menus = get_theme_support( 'calibrefx-menus' );
	
	foreach($menus as $menu){
		register_nav_menus( $menu );
	}
}

/**
 * Check if the nav menu is supported by the child themes
 */
function calibrefx_nav_menu_supported( $menu ) {

	if ( ! current_theme_supports( 'calibrefx-menus' ) )
		return false;

	$menus = get_theme_support( 'calibrefx-menus' );

	if ( array_key_exists( $menu, (array) $menus[0] ) )
		return true;

	return false;

}

add_action('calibrefx_after_header', 'calibrefx_do_nav');
/**
 * This function is for displaying the "Primary Navigation" bar.
 */
function calibrefx_do_nav() {
	/** Do nothing if menu not supported */
	if ( ! calibrefx_nav_menu_supported( 'primary' ) )
		return;
		
	if ( calibrefx_get_option('nav') ) {
		if ( has_nav_menu( 'primary' ) ) {

			$args = array(
				'theme_location' => 'primary',
				'container' => '',
				'menu_class' => calibrefx_get_option('nav_fixed_top') ? 'navbar navbar-fixed-top menu-primary menu superfish sf-js-enabled' : 'superfish sf-js-enabled nav menu-primary menu',
				'echo' => 0,
				'walker' => new CalibreFx_Walker_Nav_menu(),
			);
			$nav = wp_nav_menu( $args );
		}

		$nav_output = sprintf( '
			<div id="nav" class="navbar row">
				<div class="navbar-inner">
					<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="brand" href="#">Project name</a>
					<div class="nav-collapse">%1$s</div></div></div></div>', $nav);

		echo apply_filters( 'calibrefx_do_nav', $nav_output, $nav, $args );

	}
}

add_action( 'calibrefx_after_header', 'calibrefx_do_subnav' );
/**
 * This function is for displaying the "Secondary Navigation" bar.
 */
function calibrefx_do_subnav() {

	/** Do nothing if menu not supported */
	if ( ! calibrefx_nav_menu_supported( 'secondary' ) )
		return;

	if ( calibrefx_get_option( 'subnav' ) ) {
		if ( has_nav_menu( 'secondary' ) ) {
			$args = array(
				'theme_location' => 'secondary',
				'container'      => '',
				'menu_class' 	 => 'nav nav-pills menu-secondary menu superfish sf-js-enabled',
				'echo'           => 0,
				'walker' => new CalibreFx_Walker_Nav_menu(),
			);

			$subnav = wp_nav_menu( $args );
		}

		$subnav_output = sprintf( '
			<div id="subnav" class="subnav row">
				%1$s
			</div>', $subnav);

		echo apply_filters( 'calibrefx_do_subnav', $subnav_output, $subnav, $args );
	}
}

add_filter('nav_menu_css_class' , 'calibrefx_nav_menu_css_class' , 10 , 2);
/**
 * Add .active class when the current menu is active, not override the current-page-item
 * from WordPress
 */
function calibrefx_nav_menu_css_class($classes, $item){
	 if(in_array("current-menu-item", $item->classes) || in_array("current-menu-parent", $item->classes) || in_array("current-menu-acestor", $item->classes)){
             $classes[] = "active";
     }
     return $classes;
}