<?php
/**
 * Calibrefx Model Class
 *
 */
class Calibrefx_Model {

	/**
	 * Initialize Calibrefx_Model Class
	 *
	 * @return  void
	 */
	public function __construct( ) {

	}

	public function get( $key, $group = 'calibrefx-settings' ) {
		$options = $this->get_all( $group );

		if ( $options AND isset( $options[$key] ) ) {
			if ( is_array( $options[$key] ) ) {
				return $options[$key];
			} else {
				return stripslashes( $options[$key] );
			}
		}

		return false;
	}

	public function get_all( $group = 'calibrefx-settings' ) {
		$options = wp_cache_get( $group, $group );

		if ( ! $options ){
			$options = apply_filters( $group, get_option( $group ), $group );
			wp_cache_set( $group, $options, $group );
		}

		return $options;
	}

	public function save( $value, $group = 'calibrefx-settings' ) {
		return update_option( $group, $value );
	}

}