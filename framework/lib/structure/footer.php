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
 * This file hold all the function to handle the footers
 *
 * @package CalibreFx
 */
 
 
add_action( 'wp_footer', 'calibrefx_footer_scripts' );
/**
 * Display the footer scripts, defined in Theme Settings.
 */
function calibrefx_footer_scripts() {
	echo apply_filters('calibrefx_footer_scripts', calibrefx_option('footer_scripts'));
	
	// If singular, echo scripts from custom field
	if ( is_singular() ) {
		calibrefx_custom_field( '_calibrefx_footer_scripts' );
	}
}

add_action('calibrefx_before_footer', 'calibrefx_do_footer_widgets');
/**
 * Display the footer widget if the footer widget are active.
 */
function calibrefx_do_footer_widgets(){
	global $wp_registered_sidebars;
	
	$footer_widgets = get_theme_support( 'calibrefx-footer-widgets' );

	if ( ! $footer_widgets )
		return;
	
	$all_widgets = wp_get_sidebars_widgets();
	$count_footer_widgets = count($all_widgets['footer-widget']);
	$span = "span". strval(floor((12/$count_footer_widgets)));
	
	
	$sidebar = $wp_registered_sidebars['footer-widget'];
	$sidebar['before_widget'] = '<div id="%1$s" class="widget '.$span.' %2$s"><div class="widget-wrap">';

	unregister_sidebar('footer-widget');
	register_sidebar($sidebar);
	
	if ( is_active_sidebar( 'footer-widget' ) ) {
		echo '<div id="footer-widget" class="row">';
		dynamic_sidebar( 'footer-widget' );
		echo '</div><!--end #footer-widget-->';
	}	
}

add_action( 'calibrefx_footer', 'calibrefx_do_footer_open', 5 );
/**
 * Open footer markup
 */
function calibrefx_do_footer_open() {

	echo '<div id="footer" class="row">';
}

add_action( 'calibrefx_footer', 'calibrefx_do_footer_close', 15 );
/**
 * Close footer markup
 */
function calibrefx_do_footer_close() {
	echo '</div><!-- end #footer -->' . "\n";
}

add_filter( 'calibrefx_footer_output', 'do_shortcode', 20 );
add_action('calibrefx_footer', 'calibrefx_do_footer');
/**
 * Do Header Callback
 */
function calibrefx_do_footer(){
	// Build the filterable text strings. Includes shortcodes.
	$creds_text = apply_filters( 'calibrefx_footer_credits', sprintf( '[footer_copyright before="%1$s "] [footer_theme_link after=" %2$s "] [footer_calibrefx_link after=" %3$s "] [footer_wordpress_link before= " %4$s " after=" %3$s "]', __( 'Copyright', 'calibrefx' ), __( 'on', 'calibrefx' ), '&middot;', __( 'Powered By', 'calibrefx' )) );
	$backtotop_text = apply_filters( 'calibrefx_footer_scrolltop', '[footer_scrolltop]' );
	
	$backtotop = $backtotop_text ? sprintf( '<div class="pull-right  scrolltop"><p>%s</p></div>', $backtotop_text ) : '';
	$creds = $creds_text ? sprintf( '<div class="credits pull-left"><p>%s</p></div>', $creds_text ) : '';

	$output = $creds . $backtotop;

	echo apply_filters( 'calibrefx_footer_output', $output, $backtotop_text, $creds_text );
}