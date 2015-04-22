<?php
/**
 * Handle Calibrefx Framework Update
 */

/**
 * This function calibrefx_update_check is to ...
 */
function calibrefx_update_check() {
	global $wp_version;

	/** Get time of last update check */
	$calibrefx_update = get_transient( 'calibrefx-update' );

	/** If it has expired, do an update check */
	if ( ! $calibrefx_update ) {
		$url = 'http://api.calibrefx.com/themes-update/';
		$options = apply_filters(
			'calibrefx_update_remote_post_options',
			array(
				'body' => array(
					'theme_name' => 'calibrefx',
					'theme_version' => FRAMEWORK_VERSION,
					'url' => home_url( ),
					'wp_version' => $wp_version,
					'php_version' => phpversion(),
					'user-agent' => "WordPress/$wp_version;",
				),
			)
		);

		$response = wp_remote_post( $url, $options );
		$calibrefx_update = wp_remote_retrieve_body( $response );
		/** If an error occurred, return FALSE, store for 48 hour */
		if ( 'error' == $calibrefx_update || is_wp_error( $calibrefx_update ) || ! is_serialized( $calibrefx_update ) ) {
			set_transient( 'calibrefx-update', array( 'new_version' => FRAMEWORK_VERSION ), 60 * 60 * 48 );
			return false;
		}

		/** Else, unserialize */
		$calibrefx_update = maybe_unserialize( $calibrefx_update );

		/** And store in transient for 48 hours */
		set_transient( 'calibrefx-update', $calibrefx_update, 60 * 60 * 48 );
	}

	/** If we're already using the latest version, return false */
	if ( version_compare( FRAMEWORK_VERSION, $calibrefx_update['new_version'], '>=' ) ) {
		return false;
	}

	return $calibrefx_update;
}

/**
 * Iteratively update calibreFx to the latest version
 */
function calibrefx_upgrade() {

	$calibrefx_db_version = calibrefx_get_option( 'calibrefx_db_version' );

	//Avoid infinited loop
	if ( empty( $calibrefx_db_version ) ){
		calibrefx_set_option( 'calibrefx_db_version', FRAMEWORK_DB_VERSION );
	}
	
	calibrefx_set_option( 'calibrefx_version', FRAMEWORK_VERSION );
	wp_cache_flush(); //refresh option caches

	if ( $calibrefx_db_version >= FRAMEWORK_DB_VERSION ) {
		return;
	}
	do_action( 'calibrefx_upgraded' );
}
add_action( 'admin_init', 'calibrefx_upgrade', 25 );


/**
 * Redirects the user back to the theme settings page
 */
function calibrefx_upgrade_redirect() {
	if ( ! is_admin() ) {
		return;
	}

	//this will prevent redirect loop
	if( empty( esc_attr( $_GET[ 'upgraded' ] ) ) ){
		calibrefx_admin_redirect( 'themes.php', 
			array( 	'page' 		=> 'calibrefx', 
					'section' 	=> 'system', 
					'upgraded' 	=> 'true' 
				) );
		exit;
	}
}
add_action( 'calibrefx_upgraded', 'calibrefx_upgrade_redirect', 99 );


/**
 * Displays the notice that the theme settings were successfully updated to the
 * latest version.
 */
function calibrefx_upgraded_notice() {

	if ( ! calibrefx_is_menu_page( 'calibrefx' ) ) {
		return;
	}

	if ( isset( $_REQUEST['upgraded'] ) AND 'true' == $_REQUEST['upgraded'] ) {
		echo '<div id="message" class="updated highlight" id="message"><p>' . sprintf( __( 'Congratulations! You are now using the latest version of Calibrefx v%s', 'calibrefx' ), FRAMEWORK_VERSION ) . '</p></div>';
	}
}
add_action( 'admin_notices', 'calibrefx_upgraded_notice' );


/**
 * Filters the action links at the end of an update.
 */
function calibrefx_update_action_links( $actions, $theme ) {
	if ( 'calibrefx' != $theme ) {
		return $actions;
	}

	return sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=calibrefx-other' ), __( 'Click here to complete the upgrade', 'calibrefx' ) );
}
add_filter( 'update_theme_complete_actions', 'calibrefx_update_action_links', 10, 2 );


/**
 *  Displays the update notification at the top of the dashboard if there is a Calibrefx
 *  update available.
 */
function calibrefx_update_notification() {

	$calibrefx_update = calibrefx_update_check();

	if ( ! is_super_admin() || ! $calibrefx_update ) {
		return false;
	}

	echo '<div id="update-nag">';
	printf(
		__( 'Calibrefx %s is available. <a href="%s" class="thickbox thickbox-preview">Check out what\'s new</a> or <a href="%s" onclick="return calibrefx_confirm(\'%s\' );">update now</a>.', 'calibrefx' ), esc_html( $calibrefx_update['new_version'] ), esc_url( $calibrefx_update['changelog_url'] ), wp_nonce_url( 'update.php?action=upgrade-theme&amp;theme=calibrefx', 'upgrade-theme_calibrefx' ), esc_js( __( 'Upgrading Calibrefx will overwrite the current installed version of Calibrefx. Are you sure you want to upgrade?. "Cancel" to stop, "OK" to upgrade.', 'calibrefx' ) )
	);
	echo '</div>';
}
add_action( 'admin_notices', 'calibrefx_update_notification' );


/**
 * Push Calibrefx update check to WordPress update checks.
 *
 * This function filters the value that is returned when WordPress tries to pull
 * theme update transient data.
 */
function calibrefx_update_push( $value ) {

	$calibrefx_update = calibrefx_update_check();

	if ( $calibrefx_update ) {
		$value->response['calibrefx'] = $calibrefx_update;
	}

	return $value;
}
add_filter( 'site_transient_update_themes', 'calibrefx_update_push' );
add_filter( 'transient_update_themes', 'calibrefx_update_push' );

/**
 * Delete Calibrefx update transient after updates.
 */
function calibrefx_clear_update_transient() {

	delete_transient( 'calibrefx-update' );
	remove_action( 'admin_notices', 'calibrefx_update_notification' );
}
add_action( 'load-update-core.php', 'calibrefx_clear_update_transient' );
add_action( 'load-themes.php', 'calibrefx_clear_update_transient' );


function calibrefx_db_upgrade_1001(){
	calibrefx_set_option( 'feature_image_layout', 'full' );
	calibrefx_set_option( 'calibrefx_db_version', '1001' );
}
add_action( 'calibrefx_upgrade', 'calibrefx_db_upgrade_1001' );