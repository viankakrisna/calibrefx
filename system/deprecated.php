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

/**
 * Helper to get the global layouts
 *
 * @access public
 * @return array
 */
function calibrefx_get_layouts() {
	_deprecated_function( __FUNCTION__, '2.0', 'is_ajax()' );

	return calibrefx_get_all_layouts();
}

/**
 * Return footer widget css class
 * @deprecated 2.0
 */
function get_footer_widget_class( $class = '' ) {
	// Separates classes with a single space, collates classes for body element
	return 'class="' . join( ' ', get_footer_widget_classes( $class ) ) . '"';
}

/**
 * Show footer widget css class
 * @deprecated 2.0
 */
function footer_widget_class( $class = '' ) {
	echo esc_attr( get_footer_widget_class( $class ) );
}

/**
 * Retrieve the classes for the body element as an array.
 * @deprecated 2.0
 */
function get_footer_widget_classes( $class = '' ) {
	$classes = array();

	//always use row class as the base
	$classes[] = calibrefx_row_class();

	if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class ); }
		$classes = array_merge( $classes, $class );
	} else {
		$class = array();
	}

	$classes = array_map( 'esc_attr', $classes );

	return apply_filters( 'footer_widget_class', $classes, $class );
}

/**
 * Helper function to get the url and transform it to www-sitename-com.
 * @deprecated 2.0
 */
function calibrefx_get_site_url() {
	$url = str_replace( '.', '-', str_replace( 'http://', '', home_url() ) );
	return $url;
}

/**
 * Display author box and its contents.
 * @deprecated 2.0.2 Use get_template_part( 'author-bio' ) instead.
 */
function calibrefx_author_box( $context = '' ) {
	_deprecated_function( __FUNCTION__, '2.0.2', 'get_template_part( \'author-bio\' )' );
	global $authordata;

	// $authordata = is_object( $authordata ) ? $authordata : get_userdata( get_query_var( 'author' ) );
	$gravatar_size = apply_filters( 'calibrefx_author_box_gravatar_size', 70, $context );
	$gravatar = get_avatar( get_the_author_meta( 'email' ), $gravatar_size );
	$title = apply_filters( 'calibrefx_author_box_title', sprintf( '<strong>%s %s</strong>', __( 'About', 'calibrefx' ), get_the_author() ), $context );
	$description = wpautop( get_the_author_meta( 'description' ) );

	$pattern = ( $context == 'single' ) ? '<div class="author-box well"><div>%s %s<br />%s</div></div><!-- end .authorbox-->' : '<div class="author-box well">%s<h1>%s</h1><div>%s</div></div><!-- end .authorbox-->';

	echo apply_filters( 'calibrefx_author_box', sprintf( $pattern, $gravatar, $title, $description ), $context, $pattern, $gravatar, $title, $description );
}