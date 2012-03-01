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
 * This file have all calibrefx general functions
 *
 * @package CalibreFx
 */ 
 
/**
 * Helper function to get the url and transform it to www-sitename-com.
 *
 */
function calibrefx_get_site_url() {
	$url = str_replace('.','-',str_replace('http://','',get_bloginfo('url')));
	return $url;
}

/**
 * This function redirects the user to an admin page, and adds query args
 * to the URL string for alerts, etc.
 */
function calibrefx_admin_redirect( $page, $query_args = array() ) {

	if ( ! $page )
		return;

	$url = menu_page_url( $page, false );

	foreach ( (array) $query_args as $key => $value ) {
		if ( isset( $key ) && isset( $value ) ) {
			$url = add_query_arg( $key, $value, $url );
		}
	}

	wp_redirect( esc_url_raw( $url ) );

}

/**
 * Display author box and its contents.
 */
function calibrefx_author_box( $context = '' ) {

	global $authordata;
	
	$authordata    = is_object( $authordata ) ? $authordata : get_userdata( get_query_var( 'author' ) );
	$gravatar_size = apply_filters( 'calibrefx_author_box_gravatar_size', 70, $context );
	$gravatar      = get_avatar( get_the_author_meta( 'email' ), $gravatar_size );
	$title         = apply_filters( 'calibrefx_author_box_title', sprintf( '<strong>%s %s</strong>', __( 'About', 'genesis' ), get_the_author() ), $context );
	$description   = wpautop( get_the_author_meta( 'description' ) );

	/** The author box markup, contextual */
	$pattern = $context == 'single' ? '<div class="author-box well"><div>%s %s<br />%s</div></div><!-- end .authorbox-->' : '<div class="author-box well">%s<h1>%s</h1><div>%s</div></div><!-- end .authorbox-->';
	
	
	echo apply_filters( 'calibrefx_author_box', sprintf( $pattern, $gravatar, $title, $description ), $context, $pattern, $gravatar, $title, $description );

}