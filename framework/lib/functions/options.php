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
 * This file hold all the function to manage options
 *
 * @package CalibreFx
 */
 
/**
 * Get option value based on option key
 *
 * @access public
 * @param string option key
 * @param string setting key, default null
 * @return void
 */
function calibrefx_get_option($key, $setting = null) {
	global	$_calibrefx_cache;

	if ( !$_calibrefx_cache ) {
		$_calibrefx_cache = new cfx_cache;
	}
	
	//If setting is null then use the default CalibreFX Setting field
	$setting = $setting ? $setting : CALIBREFX_SETTINGS_FIELD;
	
	$options = $_calibrefx_cache->cache_get($setting, $setting);
	
	if($options && isset($options[$key])){
		return $options[$key];
	}
	
	$options = apply_filters('calibrefx_options', get_option($setting), $setting);
	$_calibrefx_cache->cache_set($setting, $options);
	
	return $options[$key];
}

function calibrefx_option($key, $setting = null) {
	echo calibrefx_get_option($key, $setting);
}

/**
 * These functions can be used to easily and efficiently pull data from a
 * post/page custom field. Returns FALSE if field is blank or not set.
 *
 * @param string $field used to indicate the custom field key
 */
function calibrefx_custom_field($field) {
	echo calibrefx_get_custom_field($field);
}
function calibrefx_get_custom_field($field) {

	global $id, $post;

	if ( null === $id && null === $post ) {
		return false;
	}

	$post_id = null === $id ? $post->ID : $id;

	$custom_field = get_post_meta( $post_id, $field, true );

	if ( $custom_field ) {
		/** sanitize and return the value of the custom field */
		return stripslashes( wp_kses_decode_entities( $custom_field ) );
	}
	else {
		/** return false if custom field is empty */
		return false;
	}

}