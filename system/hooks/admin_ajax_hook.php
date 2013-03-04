<?php defined('CALIBREFX_URL') OR exit();
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
 * Calibrefx Admin Ajax Hooks
 *
 * @package		Calibrefx
 * @subpackage  Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

add_action('wp_ajax_calibrefx_test_send_mail', 'calibrefx_test_send_mail');
function calibrefx_test_send_mail(){
	global $calibrefx;
	$calibrefx->load->library('email');
	
	/*$calibrefx->email->set_protocol($calibrefx->theme_settings_m->get('email_protocol'));
	$calibrefx->email->from(get_bloginfo('admin_email'));
	$calibrefx->email->to($_POST('email'));
	$calibrefx->email->subject('Test Email');
	$calibrefx->email->message('Test Body Message');
	$result = $calibrefx->email->send();*/

	$result = wp_mail('ivan@ivankristianto.com', 'Test Email','Test Body Message');

	$return_data = array(
		"status" => 'success',
		"message" => 'Result: '.$result
	);

	echo json_encode($return_data);exit;
}