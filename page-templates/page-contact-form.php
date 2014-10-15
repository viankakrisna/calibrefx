<?php
/* 
 * Template Name: Contact Form Page
 */
//@TODO: Form submit handler for this is removed, need to work on something
function calibrefx_add_contact_form( $content ) {
	$target_email = apply_filters( 'calibrefx_contact_form', get_bloginfo( 'admin_email' ), get_bloginfo( 'admin_email' ) );
	$shortcode = '[contactform target="'.$target_email.'"]';

	return $content . '<div class="contact-form-wrapper">' . do_shortcode( $shortcode) . '</div>';
}
add_filter( 'the_content','calibrefx_add_contact_form' );

calibrefx();