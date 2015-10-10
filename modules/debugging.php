<?php

/**
 * Module Name: Debugging
 * Module Description: Provide debugging tools. This module only for development only.
 * First Introduced: 2.0
 * Requires Connection: No
 * Auto Activate: No
 * Sort Order: 99
 * Module Tags: Appearance
 */

/**
 * debug_var function
 * Dump a variable with human readable format
 *
 */
if ( ! function_exists( 'debug_var' ) ) {

	function debug_var( $var ) {
		$before = '<div style="padding:10px 20px 10px 20px; background-color:#fbe6f2; border:1px solid #d893a1; color: #000; font-size: 12px;>' . "\n";
		$before .= '<h5 style="font-family:verdana,sans-serif; font-weight:bold; font-size:18px;">Debug Helper Output</h5>' . "\n";
		$before .= '<pre>' . "\n";

		echo $before;
		var_dump( $var );
		$after = '</pre>' . "\n";
		$after .= '</div>' . "\n";

		echo $after;
	}

}

/**
 * debug_var_log function
 * Dump a variable with human readable format into a log file
 *
 */
if ( ! function_exists( 'debug_var_log' ) ) {

	function debug_var_log( $var ) {
		ob_start(); //Start buffering
		var_dump( $var ); //print the result
		$output = ob_get_contents(); //get the result from buffer
		ob_end_clean(); //close buffer
	}

}

/**
 * die_dump function
 * Dump a variable and stop the process.
 *
 */
if ( ! function_exists( 'die_dump' ) ) {

	function die_dump() {
		list( $callee ) = debug_backtrace();
		$arguments = func_get_args();
		$total_arguments = count( $arguments );
		echo '<fieldset style="background: #fefefe !important; border:2px red solid; padding:5px">';
		echo '<legend style="background:lightgrey; padding:5px;">' . $callee['file'] . ' @ line: ' . $callee['line'] . '</legend><pre>';

		$i = 0;
		foreach ( $arguments as $argument ) {
			echo '<br/><strong>Debug #' . (++$i) . ' of ' . $total_arguments . '</strong>: ';
			var_dump( $argument );
		}

		echo '</pre>';
		echo '</fieldset>';
		die();
	}

}

/**
 * debug_file function
 * Dump a variable into a file. Suitable for rececive Post back by thirdparty such as PayPal IPN.
 *
 */
if ( ! function_exists( 'debug_file' ) ) {

	function debug_file( $var = '', $filename = 'debug.txt', $path = CHILD_URI ) {

		$output = '';

		if ( is_array( $var ) ) {
			$output = print_r( $var, true );
		} elseif ( is_object( $var ) ) {
			ob_start(); //Start buffering
			var_dump( $var ); //print the result
			$output = ob_get_contents(); //get the result from buffer
			ob_end_clean(); //close buffer
		} else {
			ob_start(); //Start buffering
			var_dump( $var ); //print the result
			$output = ob_get_contents(); //get the result from buffer
			ob_end_clean(); //close buffer
		}

		global $wp_filesystem;
		$filepath = $path . '/' . $filename;
		$creds = request_filesystem_credentials(site_url() . '/wp-admin/', '', false, false, array());
		if ( ! WP_Filesystem($creds) ) {
			/* any problems and we exit */
			return false;
		}	
		$wp_filesystem->put_contents(
			$filepath,
			$output,
			FOPEN_READ_WRITE_CREATE // predefined mode settings for WP files
		);
	}

}

/**
 * list_hooks function
 * get all hooks
 *
 */
if ( ! function_exists( 'list_hooks' ) ) {
	function list_hooks( $filter = false ) {
		global $wp_filter;

		$hooks = $wp_filter;
		ksort( $hooks );

		foreach ( $hooks as $tag => $hook ){
			if ( false === $filter || false !== strpos( $tag, $filter ) ){
				dump_hook( $tag, $hook );
			}
		}
	}
}

/**
 * list_live_hooks function
 * get all hooks that currently running
 *
 */
if ( ! function_exists( 'list_live_hooks' ) ) {
	function list_live_hooks( $hook = false ) {
		if ( false === $hook ){
			$hook = 'all';
		}

		add_action( $hook, 'list_hook_details', -1 );
	}
}

/**
 * list_hook_details function
 * get all hooks with the detail
 *
 */
if ( ! function_exists( 'list_hook_details' ) ) {
	function list_hook_details( $input = null ) {
		global $wp_filter;

		$tag = current_filter();
		if ( isset( $wp_filter[$tag] ) ) {
			dump_hook( $tag, $wp_filter[$tag] );
		}

		return $input;
	}
}

/**
 * dump_hook function
 * dump all the hooks with nice presentation
 *
 */
if ( ! function_exists( 'dump_hook' ) ) {
	function dump_hook( $tag, $hook ) {
		ksort( $hook );

		echo "<pre>&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";

		foreach ( $hook as $priority => $functions ) {

			echo $priority;

			foreach ( $functions as $function ) {
				if ( 'list_hook_details' != $function[ 'function' ] ) {

					echo "\t";

					if ( is_string( $function[ 'function' ] ) ) {
						echo $function[ 'function' ];
					} else {
						print_r( $function );
					}

					echo ' ( ' . $function[ 'accepted_args' ] . ' ) <br />';
				}
			}
		}

		echo '</pre>';
	}
}