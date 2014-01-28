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

global $cfxgenerator;

$cfxgenerator->wp_loaded = array(
	array(
		'function' => 'form_submit_handler',
		'priority'	=> 15
	),
);

$cfxgenerator->calibrefx_after_wrapper = array(
	array(
		'function' => 'form_submit_notification_handler',
		'priority'	=> 20
	)
);


/********************
 * FUNCTIONS BELOW  *
 ********************/
/**
 * Handle form submit from contact form
 */
function form_submit_handler(){
	if ('POST' == $_SERVER['REQUEST_METHOD']){
		if(!isset($_REQUEST['action'])) return;
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

				wp_redirect( $redirect.'?submitted=true&type=contactform' ); exit;

				break;
			default : break;
		}
	}
}
// add_action('wp_loaded', 'form_submit_handler', 15);

function form_submit_notification_handler(){
	if(isset($_REQUEST['submitted'])){
		$submitted = $_REQUEST['submitted'];
		if(!$submitted) return;
	}else{
		return;
	}

	$message = ''; $error = false;
	switch ($_GET['type']) {
		case 'contactform':
			$message = apply_filters('calibrefx_contact_form_message', __('Your message has been sent. Thank you for submitting your message.', 'calibrefx'));
			break;
		
		case 'autoresponder':
			$message = apply_filters('calibrefx_autoresponder_message', __('Your detail has been submitted. Please check your inbox, and confirm your subscription.', 'calibrefx'));
			break;

		default:
			$message = apply_filters('calibrefx_other_form_submit_message', __('Your message has been submitted.'));
			$error = apply_filters('calibrefx_other_form_submit_status', false);
			break;
	}

	if($error) $alert_success = ' alert-error';
	else $alert_success = ' alert-success';

	echo '
		<div class="modal hide fade" id="submit-notice">
			<div class="modal-body">
			    <div class="alert'.$alert_success.'">
				  	<button type="button" class="close" data-dismiss="modal">&times;</button>
					'.$message.'
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$("#submit-notice").modal(\'show\');
			});
		</script>
	';	
}
// add_action('calibrefx_after_wrapper', 'form_submit_notification_handler', 20);