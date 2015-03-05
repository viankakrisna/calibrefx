<?php
/**
 * Calibrefx Script Helper
 *
 */
/**
 * Get current script run by the server
 */
function calibrefx_get_script() {
	$file = '';
	if ( isset( $_SERVER['SCRIPT_NAME'] ) ) {
		$file = esc_attr( $_SERVER['SCRIPT_NAME'] );
	}
	$break	= explode( '/', $file );
	$pfile	= $break[ count( $break ) - 1 ];
	return $pfile;
}

if ( ! function_exists( 'is_ajax' ) ) {
	/**
	 * is_ajax
	 * Helper function to check if the request is using Ajax
	 *
	 * @return boolean
	 * @author Ivan Kristianto
	 **/
	function is_ajax() {
		return (defined( 'DOING_AJAX' ) && DOING_AJAX);
	}

}

