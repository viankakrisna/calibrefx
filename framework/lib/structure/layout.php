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
 * This file hold all the function to control the layout
 *
 * @package CalibreFx
 */
 
add_action('calibrefx_init', 'calibrefx_setup_layout', 0);
/**
 * Register all the available layout
 *
 * @access public
 * @return void
 */
function calibrefx_setup_layout(){
	
	calibrefx_register_layout(
				'content-sidebar', 
				array(
					'label' => __('Content Sidebar (default blog)', 'calibrefx'),
					'img' => CALIBREFX_IMAGES_URL . '/layouts/cs.gif',
					'default' => true)
				);
	calibrefx_register_layout(
				'full-width-content', 
				array(
					'label' => __('Full Width Content (minisite)', 'calibrefx'),
					'img' => CALIBREFX_IMAGES_URL . '/layouts/c.gif')
				);
	calibrefx_register_layout(
				'sidebar-content', 
				array(
					'label' => __('Sidebar Content', 'calibrefx'),
					'img' => CALIBREFX_IMAGES_URL . '/layouts/sc.gif')
				);
	calibrefx_register_layout(
				'sidebar-content-sidebar', 
				array(
					'label' => __('Sidebar Content Sidebar', 'calibrefx'),
					'img' => CALIBREFX_IMAGES_URL . '/layouts/scs.gif')
				);
	
}

add_filter('body_class', 'caibrefx_layout_body_class');
/**
 * This function/filter adds custom body class(es) to the
 * body class array. 
 */
function caibrefx_layout_body_class( $classes ) {

	$site_layout = calibrefx_site_layout();

	//add css class to the body class array
	if($site_layout) $classes[] = $site_layout;
	
	return $classes;
}

add_filter( 'post_class', 'calibrefx_post_class' );
/**
 * Add class row/row-fluid to post
 */
function calibrefx_post_class($classes){
	
	$classes[] = $row_class = "row";
	
	return $classes;
}


add_filter('body_class', 'calibrefx_header_body_classes');
/**
 * This function/filter adds new classes to the <body>
 * so that we can use psuedo-variables in our CSS file,
 * which helps us achieve multiple header layouts with minimal code
 *
 * @since 0.2.2
 */
function calibrefx_header_body_classes($classes) {

	// add header classes to $classes array
	if ( ! is_active_sidebar( 'header-right' ) )
		$classes[] = 'header-full-width';

	if ( 'image' == calibrefx_get_option('blog_title') || 'blank' == get_header_textcolor() )
		$classes[] = 'header-image';
		
	if( calibrefx_layout_is_responsive() )
		$classes[] = 'responsive';
	else
		$classes[] = 'fixed';

	// return filtered $classes
	return $classes;

}

/**
 * This function/filter adds layout type static/fluid
 */
/*function calibrefx_layout_type(){
	
	$layout_type = calibrefx_get_option('layout_type');
	if($layout_type == 'fluid') $layout_type = '-fluid';
	else $layout_type = '';
	
	return apply_filters('calibrefx_layout_type', $layout_type);
}*/

function calibrefx_layout_is_responsive(){
	return calibrefx_get_option('layout_type') == 'fluid';
}

/**
 * This function/filter adds content span*
 */
function calibrefx_content_span(){
	// get the layout
	$site_layout = calibrefx_site_layout();
	
	// don't load sidebar on pages that don't need it
	if ( $site_layout == 'full-width-content' ) return apply_filters('calibrefx_content_span', 'span12');
	
	if ( $site_layout == 'sidebar-content-sidebar' ) return apply_filters('calibrefx_content_span', 'span6');
	
	return apply_filters('calibrefx_content_span', 'span8');
}

/**
 * This function/filter adds sidebar span*
 */
function calibrefx_sidebar_span(){
	// get the layout
	$site_layout = calibrefx_site_layout();
	
	// don't load sidebar on pages that don't need it
	if ( $site_layout == 'full-width-content' ) return;
	
	if ( $site_layout == 'sidebar-content-sidebar' ) return apply_filters('calibrefx_sidebar_span', 'span3');
	
	return apply_filters('calibrefx_sidebar_span', 'span4');
}

/**
 * Register a layout
 *
 * @access public
 * @param $id the id of the layout
 * @paramg $args, layout configurations such as label, image, and value
 * @return void
 */
function calibrefx_register_layout($id, $args=array()){
	global $_calibrefx_layouts;
	
	if ( !is_array( $_calibrefx_layouts ) )
		$_calibrefx_layouts = array();
		
	$defaults = array(
		'label' => __( 'No Label Selected', 'calibrefx' ),
		'img' => CALIBREFX_IMAGES_URL . '/layouts/none.gif',
	);
		
	//don't allow duplicate id
	if(isset($_calibrefx_layouts[$id])) return;
	
	//parse the arguments
	$args = wp_parse_args($args, $defaults);
	
	$_calibrefx_layouts[$id] = $args;
}

/**
 * Remove a layout as the id given
 *
 * @access public
 * @param $id the id of the layout
 * @return bool, true if success
 */
function calibrefx_unregister_layout($id){
	global $_calibrefx_layouts;
	
	//check if the id available, if not do nothing
	if(!isset($_calibrefx_layouts[$id])) return;
	
	//remove from array
	unset($_calibrefx_layouts[$id]);
	
	return true;
}
 
/**
 * Return the default layout settings: content-sidebar
 *
 * @access public
 * @return string
 */
function calibrefx_get_default_layout(){
	//For now just return content-sidebar as default
	//@TODO: make the option from the theme settings
	global $_calibrefx_layouts;

	$default = '';

	foreach ( (array)$_calibrefx_layouts as $key => $value ) {
		if ( isset( $value['default'] ) && $value['default'] ) {
			$default = $key; break;
		}
	}

	// return default layout, if exists
	if ( $default ) {
		return $default;
	}
	
	
	//if no default layout exist, then return the first key in array
	return key($_calibrefx_layouts);
}

/**
 * Helper to get the global layouts
 *
 * @access public
 * @return array
 */
function calibrefx_get_layouts(){
	global $_calibrefx_layouts;
	
	if(!is_array($_calibrefx_layouts))
		$_calibrefx_layouts = array();
	
	return $_calibrefx_layouts;
	
}

/**
 * Get the layout based on the context given
 *
 * @access public
 * @return string
 */
function calibrefx_get_layout($context){
	$layouts = calibrefx_get_layouts();
	
	if(!isset($layouts[$context])) return;
	
	return $layouts[$context];	
}

/**
 * This function will get the custom layout from the specific post
 * if none, then will return default layout
 *
 * @access public
 * @return string
 */
function calibrefx_site_layout() {

	$site_layout = calibrefx_get_option( 'site_layout' );

	// Use default layout as a fallback, if necessary
	if ( !calibrefx_get_layout( $site_layout ) ) {
		$site_layout = calibrefx_get_default_layout();
	}

	return esc_attr( apply_filters( 'calibrefx_site_layout', $site_layout ) );

}

/**
 * html helper function to output layout setting
 *
 */
function calibrefx_layout_selector( $args = array() ) {

	/** Merge defaults with user args */
	$args = wp_parse_args( $args, array(
		'name'     => '',
		'selected' => '',
		'echo'     => true
	) );

	$output = '';
	
	foreach ( calibrefx_get_layouts() as $id => $data ) {

		$class = $id == $args['selected'] ? 'selected' : '';

		$output .= sprintf( '<label title="%1$s" class="box %2$s"><img src="%3$s" alt="%1$s" /><br /> <input type="radio" name="%4$s" id="%5$s" value="%5$s" %6$s /></label>',
				esc_attr( $data['label'] ),
				esc_attr( $class ),
				esc_url( $data['img'] ),
				esc_attr( $args['name'] ),
				esc_attr( $id ),
				checked( $id, $args['selected'], false )
		);

	}
	
	/** Echo or Return output */
	if ( $args['echo'] )
		echo $output;
	else
		return $output;

}

add_action('calibrefx_after_content', 'calibrefx_get_sidebar');
/**
 * This function will show sidebar after the content
 */
function calibrefx_get_sidebar() {

	// get the layout
	$site_layout = calibrefx_site_layout();

	// don't load sidebar on pages that don't need it
	if ( $site_layout == 'full-width-content' ) return;

	// output the primary sidebar
	get_sidebar();
}

add_action('calibrefx_before_content_wrapper', 'calibrefx_get_sidebar_alt');
/**
 * This function will show sidebar after the content
 */
function calibrefx_get_sidebar_alt() {

	// get the layout
	$site_layout = calibrefx_site_layout();

	// don't load sidebar on pages that don't need it
	if ( $site_layout == 'full-width-content' ||
		$site_layout == 'content-sidebar' ||
		$site_layout == 'sidebar-content') return;

	// output the primary sidebar
	get_sidebar('alt');
}

/**
 * Put wrappers into the structure
 *
 * @access public
 * @return string
 */
function calibrefx_put_wrapper($context = '',  $output = '<div class="wrap">', $echo = true){
	
	$calibrefx_context_wrappers = get_theme_support( 'calibrefx-context-wrappers' );

	if ( ! in_array( $context, (array) $calibrefx_context_wrappers[0] ) )
		return '';

	switch( $output ) {
		case 'open':
			$output = '<div class="wrap">';
			break;
		case 'close':
			$output = '</div><!-- end .wrap -->';
			break;
	}

	if ( $echo )
		echo $output;
	else
		return $output;
}