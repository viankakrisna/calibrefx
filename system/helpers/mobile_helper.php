<?php 
/**
 * Calibrefx Mobile Helper
 * 
 */

/**
 * calibrefx_mobile_themes_exist
 * Check if the mobile theme exist in Child themes
 *
 * @return boolean
 * @author Ivan Kristianto
 **/
function calibrefx_mobile_themes_exist() {
	return file_exists( CHILD_MOBILE_URI );
}


/**
 * calibrefx_get_mobile_template
 * this function will return the mobile folder from the child themes folder
 * this will use in add_filter 'template_directory'
 *
 * @return string
 * @author Hilaladdiyar
 **/
function calibrefx_get_mobile_template( $template ) {
	$mobile_template = str_replace( CHILD_URI, CHILD_MOBILE_URI, $template );

	if ( file_exists( $mobile_template ) ) {
		return $mobile_template;
	} else {
		return $template;	
	}
}

/**
 * Check if responsive features is enabled
 * @return boolean true if responsive enabled
 */
function calibrefx_is_responsive_enabled(){
	return (get_theme_support( 'calibrefx-responsive-style' ) && !calibrefx_get_option( 'responsive_disabled' ));
}