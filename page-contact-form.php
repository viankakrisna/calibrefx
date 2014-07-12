<?php
/* Template Name: Contact Form Page
 *
 * CalibreFx Framework
 *
 * WordPress Themes by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @authorlink  http://www.calibrefx.com
 * @copyright   Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		GNU/GPL v2
 * @link		http://www.calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * CalibreFx Page file
 *
 * @package CalibreFx
 */

if( file_exists( CHILD_URI . '/page-contact.php' ) AND ( CHILD_URI != CALIBREFX_URI ) ) {
    include CHILD_URI . '/page-contact.php';
    exit;
}

function calibrefx_add_contact_form( $content) {
	$target_email = apply_filters( 'calibrefx_contact_form', get_bloginfo( 'admin_email' ), get_bloginfo( 'admin_email' ) );
	$shortcode = '[contactform target="'.$target_email.'"]';

	return $content . '<div class="contact-form-wrapper">' .do_shortcode( $shortcode) . '</div>';
}
add_filter( 'the_content','calibrefx_add_contact_form' );

calibrefx();