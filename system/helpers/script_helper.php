<?php defined( 'CALIBREFX_URL' ) OR exit();
/**
 * CalibreFx Framework
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package     CalibreFx
 * @author      CalibreFx Team
 * @authorlink  http://www.calibrefx.com
 * @copyright   Copyright (c) 2012-2013, CalibreWorks. (http://www.calibreworks.com/)
 * @license     GNU GPL v2
 * @link        http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This define the framework constants
 *
 * @package CalibreFx
 */

/**
 * Calibrefx Script Helper
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
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