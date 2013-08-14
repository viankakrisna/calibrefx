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
			case 'submit-autoresponder':
				$autoresponder_type = $CFX->other_settings_m->get('autoresponder_type');

				$success = false;

				$name = sanitize_text_field($_POST['name']);
				$email = sanitize_text_field($_POST['email']);
				$redirect = sanitize_text_field($_POST['redirect']);

				$redirect = (!empty($redirect) ? $redirect : site_url());

				// Checking for the value of name 
				if(empty($name)){
					wp_redirect($redirect."/?submitted=1&error=1&type=autoresponder");
					exit;
				}

				// Checking for the value of email
				if(empty($email)){
					wp_redirect($redirect."/?submitted=1&error=2&type=autoresponder");
					exit;
				}

				// Checking validity for the email
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					wp_redirect($redirect."/?submitted=1&error=3&type=autoresponder");
					exit;
				}

				$parts = explode("@", $email);
				$user_login = $parts[0];

				if($autoresponder_type == 'mailventure'){
					$list_id = $CFX->other_settings_m->get('autoreponder_mailventure_campaign');
					$form_id = $CFX->other_settings_m->get('autoreponder_mailventure_form');

					$ac = new MailVenture(MAILVENTURE_URL, MAILVENTURE_API_KEY); //die_dump($ac);
					
					// TO DO: error credentials
					if (!$ac->credentials_test()) {
						calibrefx_log_message('debug','Invalid credentials (URL and API Key).');
						wp_redirect($redirect."/?submitted=1&error=4&type=autoresponder");
						exit;
					}

					// CHECK IF THEY EXIST FIRST.
					$subscriber_exists = $ac->api("subscriber/view?email=$email");

					if($_SERVER['REMOTE_ADDR'] != '::1'){ // if the IP is not from local IP
						$subscriber = array(
							"email" => $email,
							"first_name" => $name,
							"p[{$list_id}]" => $list_id,
							"status[{$list_id}]" => '1', // add as "Unsubscribed",
							"form"=> $form_id,
							"ip4"=> $_SERVER['REMOTE_ADDR'],
							"sdate[{$list_id}]"=> date('Y-m-d')
						);
					}else{ // it's form local IP
						$subscriber = array(
							"email" => $email,
							"first_name" => $name,
							"p[{$list_id}]" => $list_id,
							"status[{$list_id}]" => '1', // add as "Unsubscribed",
							"form"=> $form_id,
							"ip4"=> '127.0.0.1',
							"sdate[{$list_id}]"=> date('Y-m-d')
						);
					}

					$subscriber_add = $ac->api("subscriber/add", $subscriber);

					$subscriber_id = $subscriber_add->subscriber_id;
					calibrefx_log_message('debug','Subscription success. Subscriber id: '.$subscriber_id);

					if($subscriber_id){
						$success = true;
					}
				}elseif($autoresponder_type == 'aweber'){
					$form = stripslashes($CFX->other_settings_m->get('autoreponder_aweber'));

					if(calibrefx_submit_aweber($form, $name, $email )){
						$success = true;
					}
				}elseif($autoresponder_type == 'getresponse'){
					$api_key = $CFX->other_settings_m->get('autoreponder_getresponse_api');
					$campaign_name = $CFX->other_settings_m->get('autoreponder_getresponse_campaign');

					if(calibrefx_submit_getresponse_api($name, $email, $api_key, $campaign_name)){
						$success = true;
					}
				}

				if($success){
					wp_redirect($redirect."?submitted=1&success=1&type=autoresponder");
					exit;
				}else{
					wp_redirect($redirect."?submitted=1&success=0&type=autoresponder");
					exit;
				}

				break;
			default : break;
		}
	}
}

add_action('calibrefx_after_wrapper', 'form_submit_notification_handler', 20);
function form_submit_notification_handler(){
	$CFX = & calibrefx_get_instance();

	if(!isset($_REQUEST['submitted']) && $_REQUEST['submitted'] != 'true') return;

	$message = ''; $error = false;
	switch ($_REQUEST['type']) {
		case 'contactform':
			$message = apply_filters('calibrefx_contact_form_message', __('Your message has been sent. Thank you for submitting your message.', 'calibrefx'));
			break;
		
		case 'autoresponder':
			# code...
			break;

		default:
			# code...
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