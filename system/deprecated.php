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
    echo get_footer_widget_class( $class );
}

/**
 * Retrieve the classes for the body element as an array.
 * @deprecated 2.0
 */
function get_footer_widget_classes( $class = '' ) {
    $classes = array();

    //always use row class as the base
    $classes[] = calibrefx_row_class(); 

    if ( !empty( $class ) ) {
        if ( !is_array( $class ) )
            $class = preg_split( '#\s+#', $class );
        $classes = array_merge( $classes, $class );
    } else {
        $class = array();
    }

    $classes = array_map( 'esc_attr', $classes );

    return apply_filters( 'footer_widget_class', $classes, $class );
}