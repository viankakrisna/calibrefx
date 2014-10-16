<?php
/*
 * Deprecated functions come here to die.
 */

/**
 * cfx_is_ajax_request
 * Helper function to check if the request is using Ajax
 *
 * @return boolean
 * @author Ivan Kristianto
 **/
function cfx_is_ajax_request() {
	_deprecated_function( __FUNCTION__, '2.0', 'is_ajax()' );

	return is_ajax();
}