<?php
/**
 * Calibrefx URL Helper
 *
 */

/**
 * This function redirects the user to an admin page, and adds query args
 * to the URL string for alerts, etc.
 */
function calibrefx_admin_redirect( $page, $query_args = array() ) {
	if ( ! $page ) {
		return;
	}

	$url = menu_page_url( $page, false );
	foreach ( (array) $query_args as $key => $value ) {
		if ( isset( $key ) && isset( $value ) ) {
			$url = add_query_arg( $key, $value, $url );
		}
	}

	wp_redirect( esc_url_raw( $url ) );
}

/**
 * Get the current url
 */
if ( ! function_exists( 'get_current_url' ) ) :
	function get_current_url() {
		global $wp;
		$current_url = home_url( $wp->request );
		return $current_url;
	}
endif;