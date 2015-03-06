<?php
/**
 * Calibrefx Option Helper
 */

/**
 * Get option value based on option key
 *
 * @access public
 * @param string option key
 * @param object CFX_Model, default null
 * @return mix
 */
function calibrefx_get_option( $key, $group = 'calibrefx-settings' ) {
	global $calibrefx;

	return $calibrefx->model->get( $key, $group );
}

/**
 * Echo option if exist
 * @access public
 * @uses calibrefx_get_option
 * @param string option key
 * @param object CFX_Model, default null
 * @return void
 */
function calibrefx_option( $key, $group = null ) {
	echo calibrefx_get_option( $key, $group );
}

/**
 * Set option value based on option key
 *
 * @access public
 * @param string option key
 * @param object CFX_Model, default null
 * @return mix
 */
function calibrefx_set_option( $key, $value, $group = 'calibrefx-settings' ) {
	global $calibrefx;

	$options = $calibrefx->model->get_all( $group );

	if ( empty( $options ) ) { return false; }

	$options[ $key ] = $value;

	return $calibrefx->model->save( $options, $group );
}

/**
 * These functions can be used to easily and efficiently pull data from a
 * post/page custom field. Returns FALSE if field is blank or not set.
 *
 * @param string $field used to indicate the custom field key
 */
function calibrefx_custom_field( $field ) {
	echo calibrefx_get_custom_field( $field );
}

function calibrefx_get_custom_field( $field ) {
	global $post;

	if ( null === $post ) {
		return false;
	}

	$custom_field = get_post_meta( $post->ID, $field, true );

	if ( $custom_field ) {
		if ( ! is_array( $custom_field ) ) {
			/** sanitize and return the value of the custom field */
			return stripslashes( wp_kses_decode_entities( $custom_field ) );
		}
		return $custom_field;
	} else {
		/** return false if custom field is empty */
		return false;
	}
}

function calibrefx_get_usermeta( $user_id, $key, $single = true ) {
	$options = apply_filters( 'calibrefx_usermeta', get_user_meta( $user_id, $key, $single ) );
	return $options;
}

function calibrefx_usermeta( $user_id, $key ) {
	return calibrefx_get_usermeta( $user_id, $key );
}