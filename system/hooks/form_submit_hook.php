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

add_action('wp_loaded', 'form_submit_handler', 15);
function form_submit_handler(){
	$CFX = & calibrefx_get_instance();

	if ('POST' == $_SERVER['REQUEST_METHOD']){
		$action = sanitize_text_field($_REQUEST['action']);

		if (!$action)
			return; //no action, do nothing

		switch ($action) {
			case 'contact-form':

				$name = sanitize_text_field( $_POST['name'] );
				$email = sanitize_text_field( $_POST['email'] );
				$subject = sanitize_text_field( $_POST['subject'] );
				$message = sanitize_text_field( $_POST['message'] );
				$target = sanitize_text_field( $_POST['target'] );
				$redirect = sanitize_text_field( $_POST['redirect'] );

				$output_message = '';
				$output_message .= 'Name : '.$name."\n";
				$output_message .= 'Email : '.$email."\n";
				$output_message .= 'Subject : '.$subject."\n";
				$output_message .= 'Message : '.$message."\r\n";

				if($target == 'ADMIN_EMAIL') $target = get_option('admin_email');
				if(empty($redirect)) $redirect = site_url();

				$headers = 'From: '.get_option('blogname').' <'.get_option('admin_email').'>' . "\r\n";

				@wp_mail( $target , __('Contact Us Form Submitted on ','calibrefx').get_option('blogname'), $output_message, $headers);

				wp_redirect( $redirect.'?submitted=true' ); exit;

			break;

			default : break;
		}
	}
}