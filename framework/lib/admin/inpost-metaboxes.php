<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * Handle framework about page
 *
 * @package CalibreFx
 */
 
 add_action( 'admin_menu', 'calibrefx_add_inpost_layout_box' );
/**
 * Register a new meta box to the post / page edit screen, so that the user can
 * set layout options on a per-post or per-page basis.
 *
 * @access public
 * @author Hilaladdiyar <hilal@calibrefx.com>
 * @return void
 *
 */
function calibrefx_add_inpost_layout_box() {
	add_meta_box('calibrefx-custom-theme-layout', __('Calibrefx Custom Layout', 'calibrefx'), 'calibrefx_custom_theme_layout_box', 'post', 'normal', 'high');
}

/**
 * Show default layout box
 */
function calibrefx_custom_theme_layout_box() {
	global $post;
	//wp_nonce_field( plugin_basename( __FILE__ ), CALIBREFX_POST_SETTINGS_FIELD );

	//$layout = calib( '_genesis_layout' );
    ?>
    <p class="calibrefx-layout-selector">
        <?php
        calibrefx_layout_selector(array('name' => CALIBREFX_POST_SETTINGS_FIELD . '[site_layout]', 'selected' => calibrefx_get_custom_post_meta($post->ID,'site_layout')));
        ?>
    </p>

    <br class="clear" />

    <?php
}

add_action( 'save_post', 'calibrefx_custom_theme_layout_save', 1, 2 );
/**
 * Saves the layout options when we save a post / page.
 *
 * It does so by grabbing the array passed in $_POST, looping through it, and
 * saving each key / value pair as a custom field.
 *
 * @access public
 * @author Hilaladdiyar <hilal@calibrefx.com>
 * @return voides
 */
function calibrefx_custom_theme_layout_save( $post_id, $post ) {
	
	/**	Verify the nonce */
	/*if ( ! isset( $_POST[CALIBREFX_POST_SETTINGS_FIELD] ) || ! wp_verify_nonce( $_POST[CALIBREFX_POST_SETTINGS_FIELD], plugin_basename( __FILE__ ) ) )
		return $post_id;*/
		
	/**	Don't try to save the data under autosave, ajax, or future post. */
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		return;
	if ( defined( 'DOING_CRON' ) && DOING_CRON )
		return;

	$calibrefx_post = $_POST['calibrefx-post-settings'];

	if ( $calibrefx_post )
		update_post_meta( $post_id, 'site_layout', $calibrefx_post['site_layout'] );
	else
		delete_post_meta( $post_id, 'site_layout' );

}