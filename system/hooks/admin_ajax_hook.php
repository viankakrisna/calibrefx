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
 * Calibrefx Admin Ajax Hooks
 *
 * @package		Calibrefx
 * @subpackage  Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

add_action( 'wp_ajax_calibrefx_test_send_mail', 'calibrefx_test_send_mail' );
function calibrefx_test_send_mail() {
	global $calibrefx;
	$calibrefx->load->library( 'email' );
	$email = sanitize_text_field( $_POST['data']	);
		
	$calibrefx->email->set_protocol( $calibrefx->theme_settings_m->get( 'email_protocol' ) );
	$calibrefx->email->set_mailtype( 'html' );
	$calibrefx->email->from(get_bloginfo( 'admin_email' ), 'CalibreFx Test Email' );
	$calibrefx->email->to( $email);
	$calibrefx->email->subject( 'Test Email' );
	$calibrefx->email->message( 'Test Body Message' );
	$result = $calibrefx->email->send();

	if( $result) {
		$return_data = array(
			"status" => 'success',
			"message" => 'Result: Email Sent Succesfully.'
		);
	}else{
		$return_data = array(
			"status" => 'failed',
			"message" => 'Result: Failed to send email. Please check your settings.'
		);
	}

	echo json_encode( $return_data);exit;
}

add_action( 'wp_ajax_create-legal-page', 'calibrefx_create_legal_page' );
function calibrefx_create_legal_page() {
	global $calibrefx;
	
	check_ajax_referer( 'cfx_create-legal-page_' . $_POST['param'] );

	if ( ! current_user_can( 'edit_posts' ) )
		die( __( 'ERROR: You lack permissions to create posts.', 'calibrefx' ) );

	if ( empty( $_POST['action'] ) OR empty( $_POST['param'] ) )
		die( __( 'ERROR: No slug was passed to the AJAX callback.', 'calibrefx' ) );

	$name = $_POST['name'];
    $url = $_POST['url'];
    $info = $_POST['info'];

    $response = wp_remote_post( 'http://www.calibreworks.com/tosgen/api.php', array(
            'method' => 'POST',
            'timeout' => 60,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => array( 
                'company_name' => $_POST['name'], 
                'company_url' => $_POST['url'],
                'company_info' => $_POST['info'],
                ),
            'cookies' => array(),
        )
    );

    $json = json_decode( $response['body']);

    $asp = $json->data->asp;
    $cn = $json->data->cn;
    $disclaimer = $json->data->disclaimer;
    $dmca = $json->data->dmca;
    $federal = $json->data->federal;
    $privacy = $json->data->privacy;
    $social = $json->data->social;
    $terms = $json->data->terms;

    global $user_ID;

    switch ( $_POST['param']) {
    	case 'asp':
    		$new_post = array(
				'post_title' => 'Anti-Spam Policy',
				'post_content' => $asp,
				'post_status' => 'publish',
				'post_date' => date( 'Y-m-d H:i:s' ),
				'post_author' => $user_ID,
				'post_type' => 'page',
				'post_category' => array(0)
			);
    		break;
    	case 'cn':
    		$new_post = array(
				'post_title' => 'Copyright Notice',
				'post_content' => $cn,
				'post_status' => 'publish',
				'post_date' => date( 'Y-m-d H:i:s' ),
				'post_author' => $user_ID,
				'post_type' => 'page',
				'post_category' => array(0)
			);
    		break;
		case 'disclaimer':
    		$new_post = array(
				'post_title' => 'Disclaimer',
				'post_content' => $disclaimer,
				'post_status' => 'publish',
				'post_date' => date( 'Y-m-d H:i:s' ),
				'post_author' => $user_ID,
				'post_type' => 'page',
				'post_category' => array(0)
			);
    		break;
    	case 'dmca':
    		$new_post = array(
				'post_title' => 'DMCA Compliance',
				'post_content' => $dmca,
				'post_status' => 'publish',
				'post_date' => date( 'Y-m-d H:i:s' ),
				'post_author' => $user_ID,
				'post_type' => 'page',
				'post_category' => array(0)
			);
    		break;
    	case 'federal':
    		$new_post = array(
				'post_title' => 'Federal Trade Commission Compliance',
				'post_content' => $federal,
				'post_status' => 'publish',
				'post_date' => date( 'Y-m-d H:i:s' ),
				'post_author' => $user_ID,
				'post_type' => 'page',
				'post_category' => array(0)
			);
    		break;
    	case 'privacy':
    		$new_post = array(
				'post_title' => 'Privacy Policy',
				'post_content' => $privacy,
				'post_status' => 'publish',
				'post_date' => date( 'Y-m-d H:i:s' ),
				'post_author' => $user_ID,
				'post_type' => 'page',
				'post_category' => array(0)
			);
    		break;
    	case 'social':
    		$new_post = array(
				'post_title' => 'Social Media Disclosure',
				'post_content' => $social,
				'post_status' => 'publish',
				'post_date' => date( 'Y-m-d H:i:s' ),
				'post_author' => $user_ID,
				'post_type' => 'page',
				'post_category' => array(0)
			);
		case 'tos':
    		$new_post = array(
				'post_title' => 'Terms Of Service & Conditions Of Use',
				'post_content' => $tos,
				'post_status' => 'publish',
				'post_date' => date( 'Y-m-d H:i:s' ),
				'post_author' => $user_ID,
				'post_type' => 'page',
				'post_category' => array(0)
			);
    		break;
    	default:
    		echo 0;die;
    		break;
    }
	
	$post_id = wp_insert_post( $new_post);

	echo 1;
	exit;
}