<?php 
/**
 * Form submit hook
 */

/**
 * Handle form submit from contact form
 */
function form_submit_handler() {
	global $calibrefx;

	if( !$_POST OR !isset( $_POST['action'] ) ) return;

	$action = sanitize_text_field( $_POST['action'] );
	
	switch ( $action ) {
		case 'contact-form':
			$name = sanitize_text_field( $_POST['name'] );
			$email = sanitize_text_field( $_POST['email'] );
			$subject = sanitize_text_field( $_POST['subject'] );
			$message = sanitize_text_field( $_POST['message'] );
			$target = sanitize_text_field( $_POST['target'] );
			$redirect = sanitize_text_field( $_POST['redirect'] );
			$output_message = '';
			$output_message .= 'Name : ' . $name . "\n";
			$output_message .= 'Email : ' . $email . "\n";
			$output_message .= 'Subject : ' . $subject . "\n";
			$output_message .= 'Message : ' . $message . "\r\n";

			if( $target == 'ADMIN_EMAIL' ) $target = get_option( 'admin_email' );
			if( empty( $redirect ) ) $redirect = site_url();

			$headers = 'From: ' . get_option( 'blogname' ).' <' . get_option( 'admin_email' ) . '>' . "\r\n";

			@wp_mail( $target , __( 'Contact Us Form Submitted on ','calibrefx' ) . get_option( 'blogname' ), $output_message, $headers );
			$calibrefx->notification->set_flashmessage( apply_filters( 'calibrefx_contact_form_message', __( 'Your message has been sent. Thank you for submitting your message.', 'calibrefx' ) ), 'success' );

			wp_redirect( $redirect ); exit;

			break;
		default : break;
	}

	do_action( 'form_submit_handler', $action );
}
add_action( 'wp_loaded', 'form_submit_handler', 99 );