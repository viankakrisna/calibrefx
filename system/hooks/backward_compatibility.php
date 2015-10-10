<?php
/**
 * Calibrefx backward compatibility
 *
 */

global $calibrefx, $wp_version;

if ( version_compare( $wp_version, "4.3.0", '<' ) ) {
	//Only run this if wp_version less then 4.3.0
	//since in 4.3.0 site_icon launch
	$calibrefx->hooks->calibrefx_meta = array(
		array( 'function' => 'calibrefx_print_favicon', 'priority' => 10 ),
	);
}


/**
 * Print outs favicon
 */
function calibrefx_print_favicon() {

	if ( file_exists( CALIBREFX_IMAGES_URI . '/ico/favicon.ico' ) ) {
		$favicon = CALIBREFX_IMAGES_URL . '/ico/favicon.ico';
	} else {
		$favicon = CALIBREFX_IMAGES_URL . '/favicon.ico';
	}

	//Check if child themes have the favicon.ico
	if ( file_exists( CHILD_URI . '/favicon.ico' ) ) {
		$favicon = CHILD_URL . '/favicon.ico';
	}

	if ( file_exists( CHILD_IMAGES_URI . '/favicon.ico' ) ) {
		$favicon = CHILD_IMAGES_URL . '/favicon.ico';
	}

	if( calibrefx_get_option( 'favicon' ) ){
		$favicon = calibrefx_get_option( 'favicon' );
	}

	$favicon = apply_filters( 'calibrefx_favicon_url', $favicon );

	if ( $favicon ) {
		echo '<link rel="Shortcut Icon" href="' . esc_url( $favicon ) . '" type="image/x-icon" />' . "\n"; }
}

if( is_admin() ){
	//Only run this if wp_version less then 4.3.0
	if ( version_compare( $wp_version, "4.3.0", '<' ) ) {
		add_action( 'calibrefx_theme_settings_meta_box', 'calibrefx_meta_boxes' );
	}
}
function calibrefx_meta_boxes(){
	global $calibrefx;
	
	calibrefx_add_meta_box( 'general', 'basic', 'calibrefx-theme-settings-brand', __( 'Brand Settings', 'calibrefx' ), 'calibrefx_branding_box', $calibrefx->theme_settings->pagehook, 'main', 'high' );
}

//Meta Boxes Sections
function calibrefx_branding_box(){
	global $calibrefx;

	calibrefx_add_meta_group( 'themebranding-settings', 'branding-settings', __( 'Brand Settings', 'calibrefx' ) );

	add_action( 'themebranding-settings_options', function() {
		calibrefx_add_meta_option(
			'branding-settings',  // group id
			'header_logo_desc', // field id and option name
			__( 'Set logo', 'calibrefx' ),
			array(
				'option_type' => 'blank',
				'option_description' => __( 'You can upload configure your logo using from the Appereance > Header.', 'calibrefx' ),
			), // Settings config
			1 //Priority
		);

		calibrefx_add_meta_option(
			'branding-settings',  // group id
			'favicon', // field id and option name
			__( 'Set Favicon', 'calibrefx' ),
			array(
				'option_type' => 'upload',
				'option_default' => '',
				'option_filter' => 'safe_url',
				'option_description' => __( 'You can upload your favicon. Best size 32x32px in .ico format', 'calibrefx' ),
			), // Settings config
			5 //Priority
		);
	});

	calibrefx_do_meta_options( $calibrefx->theme_settings, 'themebranding-settings' );
}
