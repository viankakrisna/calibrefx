<?php defined( 'CALIBREFX_URL' ) OR exit();
/**
 * CalibreFx Framework
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package     CalibreFx
 * @author      CalibreFx Team
 * @authorlink  http://www.calibrefx.com
 * @copyright   Copyright (c) 2012-2013, CalibreWorks. (http://www.calibreworks.com/)
 * @license     GNU GPL v2
 * @link        http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This define the framework constants
 *
 * @package CalibreFx
 */

/**
 * Calibrefx Widget Helper
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 * 
 */

/**
 * This function expedites the widget area registration process by taking
 * common things, before/after_widget, before/after_title, and doing them automatically.
 *
 * @uses wp_parse_args, register_sidebar
 * @since 1.0.1
 * @author Charles Clarkson
 */
function calibrefx_register_sidebar( $args ) {
    $defaults = (array) apply_filters( 'calibrefx_register_sidebar_defaults', array(
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrap">',
                'after_widget'  => "</div></div>\n",
                'before_title'  => '<h4 class="widgettitle">',
                'after_title'   => "</h4>\n"
            ) );

    $args = wp_parse_args( $args, $defaults );

    return register_sidebar( $args );
}

/**
 * Show footer widget css class
 */
function footer_widget_class( $class = '' ) {
    // Separates classes with a single space, collates classes for body element
    echo 'class="' . join( ' ', get_footer_widget_classes( $class ) ) . '"';
}

/**
 * Return footer widget css class
 */
function get_footer_widget_class( $class = '' ) {
    // Separates classes with a single space, collates classes for body element
    return 'class="' . join( ' ', get_footer_widget_classes( $class ) ) . '"';
}

/**
 * Retrieve the classes for the body element as an array.
 */
function get_footer_widget_classes( $class = '' ) {
    $classes = array();

    $classes[] = calibrefx_row_class(); //Always use row class

    if ( !empty( $class ) ) {
        if ( !is_array( $class ) )
            $class = preg_split( '#\s+#', $class );
        $classes = array_merge( $classes, $class );
    } else {
        // Ensure that we always coerce class to being an array.
        $class = array();
    }

    $classes = array_map( 'esc_attr', $classes );

    return apply_filters( 'footer_widget_class', $classes, $class );
}