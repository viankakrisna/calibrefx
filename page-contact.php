<?php
/* Template Name: Contact
 *
 * CalibreFx Framework
 *
 * WordPress Themes by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @authorlink  http://www.calibrefx.com
 * @copyright   Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://www.calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * CalibreFx Page file
 *
 * @package CalibreFx
 */

if(file_exists(CHILD_DIR . '/page-contact.php')){
    include CHILD_DIR . '/page-contact.php';
    exit;
}

remove_action('calibrefx_post_content', 'calibrefx_do_post_content');
add_action('calibrefx_post_content', 'calibrefx_do_contact_content');


/**
 * CalibreFx Loop for contact bage
 *
 * It's just like the default loop except it is used for displaying blog post category
 *
 */
function calibrefx_do_contact_content() { 
	$target_email = apply_filters('calibrefx_contact_form', get_bloginfo('admin_email'), get_bloginfo('admin_email'));
	$shortcode = '[contact_form target="'.$target_email.'"]';
	echo do_shortcode($shortcode);
	the_content( do_shortcode($shortcode) . __('[Read more...]', 'calibrefx'));
}

calibrefx();