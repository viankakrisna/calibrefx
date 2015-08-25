<?php
/**
 * Calibrefx backward compatibility
 *
 */

global $calibrefx;
global $wp_version;

if ( version_compare( "4.3.0", $wp_version, '>' ) ) {
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