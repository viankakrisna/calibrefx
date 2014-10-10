<?php 
/**
 * Calibrefx Script Helper
 * 
 */
/**
 * Get current script run by the server
 */
function calibrefx_get_script() {
    $file = $_SERVER["SCRIPT_NAME"];
    $break = explode( '/', $file);
    $pfile = $break[count( $break ) - 1];
    return $pfile;
}

/**
 * cfx_is_ajax_request
 * Helper function to check if the request is using Ajax
 *
 * @return boolean
 * @author Ivan Kristianto
 **/
function cfx_is_ajax_request() {
	return ( !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 
		strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest' );
}