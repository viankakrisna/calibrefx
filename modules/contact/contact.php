<?php
/**
 * Module Name: Contacts
 * Module Description: Allows you to show company contact info with googlemap.
 * First Introduced: 2.0.3
 * Requires Connection: No
 * Auto Activate: No
 * Sort Order: 5
 * Module Tags: Appearance
 */

! defined( 'CONTACT_URL' ) && define( 'CONTACT_URL', CALIBREFX_MODULE_URL . '/contact' );
! defined( 'CONTACT_URI' ) && define( 'CONTACT_URI', CALIBREFX_MODULE_URI . '/contact' );

include_once CONTACT_URI . '/contact_widget.php';

if ( is_admin() ){
	add_action( 'calibrefx_theme_settings_meta_section', 'contact_meta_sections' );
	add_action( 'calibrefx_theme_settings_meta_box', 'contact_meta_boxes' );
	add_filter( 'calibrefx_theme_settings_defaults', 'contact_theme_settings_default', 10, 1 );
}

add_action( 'calibrefx_meta', 'contact_load_script' );
function contact_load_script(){
	if ( is_active_widget( false, false, 'contact-info-widget' ) ){
		wp_enqueue_script( 'contact-script', CONTACT_URL . '/assets/js/contact.js', array('jquery') );
		wp_enqueue_style( 'contact-style', CONTACT_URL . '/assets/css/contact.css' );
	}
}


function contact_meta_sections(){
	global $calibrefx_target_form;

	calibrefx_add_meta_section( 'contact', __( 'Contact Settings', 'calibrefx' ), $calibrefx_target_form, 20 );
}

function contact_theme_settings_default($default_arr = array()){
	$webfont_default = array(
		'contact_name' => get_bloginfo( 'name' ),
		'contact_email' => get_bloginfo( 'admin_email' ),
		'contact_phone' => '',
		'contact_mobile_phone' => '',
		'contact_address' => '',
	);

	return array_merge( $default_arr, $webfont_default );
}


function contact_meta_boxes(){
	global $calibrefx;

	calibrefx_add_meta_box( 'contact', 'basic', 'contact-settings', __( 'Contact Details', 'calibrefx' ), 'contact_settings', $calibrefx->theme_settings->pagehook, 'main', 'low' );
}

function contact_settings(){
	global $calibrefx;

	calibrefx_add_meta_group( 'contact-info-settings', 'contact-info-settings', __( 'Contact Info', 'calibrefx' ) );

	add_action( 'contact-info-settings_options', function() {
		calibrefx_add_meta_option(
			'contact-info-settings',  // group id
			'contact_name', // field id and option name
			__( 'Contact Name', 'calibrefx' ), // Label
			array(
				'option_type' => 'textinput',
				'option_default' => get_bloginfo( 'name' ),
				'option_filter' => 'safe_text',
				'option_description' => __( 'Fill with your company name', 'calibrefx' ),
			), // Settings config
			5 //Priority
		);

		calibrefx_add_meta_option(
			'contact-info-settings',  // group id
			'contact_email', // field id and option name
			__( 'Contact Email', 'calibrefx' ), // Label
			array(
				'option_type' => 'textinput',
				'option_default' => get_bloginfo( 'admin_email' ),
				'option_filter' => 'safe_text',
				'option_description' => __( 'Fill with your company email', 'calibrefx' ),
			), // Settings config
			10 //Priority
		);

		calibrefx_add_meta_option(
			'contact-info-settings',  // group id
			'contact_phone', // field id and option name
			__( 'Contact Phone Number', 'calibrefx' ), // Label
			array(
				'option_type' => 'textinput',
				'option_default' => '',
				'option_filter' => 'safe_text',
				'option_description' => __( 'Fill with your company phone number', 'calibrefx' ),
			), // Settings config
			15 //Priority
		);

		calibrefx_add_meta_option(
			'contact-info-settings',  // group id
			'contact_mobile_phone', // field id and option name
			__( 'Contact Mobile Number', 'calibrefx' ), // Label
			array(
				'option_type' => 'textinput',
				'option_default' => '',
				'option_filter' => 'safe_text',
				'option_description' => __( 'Fill with your company mobile number', 'calibrefx' ),
			), // Settings config
			20 //Priority
		);

		calibrefx_add_meta_option(
			'contact-info-settings',  // group id
			'contact_address', // field id and option name
			__( 'Contact Address', 'calibrefx' ), // Label
			array(
				'option_type' => 'textarea',
				'option_default' => '',
				'option_filter' => 'safe_html',
				'option_description' => __( 'Fill with your company address', 'calibrefx' ),
			), // Settings config
			25 //Priority
		);

		calibrefx_add_meta_option(
			'contact-info-settings',  // group id
			'contact_map', // field id and option name
			__( 'Contact Map Coordinate', 'calibrefx' ), // Label
			array(
				'option_type' => 'textinput',
				'option_default' => '',
				'option_filter' => 'safe_text',
				'option_description' => sprintf( __( 'Fill with your company map coordinate, format example: -6.163851,106.823506. Please find your coordinate <a target="_blank" href="%s">here</a>', 'calibrefx' ), 'http://www.mapcoordinates.net/en' ),
			), // Settings config
			25 //Priority
		);
	} );

	calibrefx_do_meta_options( $calibrefx->theme_settings, 'contact-info-settings' );
}


/* Contact Shortcode
------------------------------------------------------------ */
add_shortcode( 'map', 'contact_do_gmap' );
function contact_do_gmap( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'id'        => '',
		'x'         => '',
		'y'         => '',
		'title'     => '',
		'height'    => '350',
	), $atts ) );

	if ( empty( $x ) OR empty( $y ) ) { return; }

	$id = ( $id == '' ) ? 'random-googlemap-id-'.rand( 0, 1000 ) : $id ;

	$output = '<div class="gmap-container"><div class="thumbnail" style="height:'.$height.'px;"><div id="'.$id.'"  class="googlemap" style="width:100%; height:'.$height.'px;"></div></div></div>';
	$output .= '<script type="text/javascript">eventMaps.push({id:"'.$id.'", x:"'.$x.'", y:"'.$y.'", title:"'.$title.'"});</script>';

	return $output;
}

function contact_do_map( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'height'    => '300',
		), $atts
	) );

	$contact_map = calibrefx_get_option( 'contact_map' );
	$coordinates = explode( ',', $contact_map );
	$map_x = $coordinates[0];
	$map_y = $coordinates[1];

	$output = '[map x="'.$map_x.'" y="'.$map_y.'" height="'.$height.'"]';

	return do_shortcode( $output );
}
add_shortcode( 'contact_map', 'contact_do_map' );