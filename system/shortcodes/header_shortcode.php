<?php defined( 'CALIBREFX_URL' ) OR exit();
/**
 * CalibreFx Framework
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package     CalibreFx
 * @author      CalibreFx Team
 
 * @copyright   Copyright (c) 2012-2013, Calibreworks. (http://www.calibreworks.com/)
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
 * Calibrefx Header Shortcode
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

function calibrefx_h1( $atts, $content = '' ) {
    extract( shortcode_atts( array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => '',
                'color' => '',
                'font' => '',
                'font_style' => ''
    ), $atts ) );

    $classes = 'heading';
    if ( !empty( $class ) )
        $classes .= ' ' . $class;
    if ( !empty( $color ) )
        $classes .= ' ' . $color;
    if ( !empty( $font ) )
        $classes .= ' font-' . $font;
    if ( !empty( $font_style ) )
        $classes .= ' font-' . $font_style;

    return $before . "<h1 class='$classes' style='$style'>" . do_shortcode( $content ) . "</h1>" . $after;
}
add_shortcode( 'h1', 'calibrefx_h1' );

function calibrefx_h2( $atts, $content = '' ) {
    extract( shortcode_atts( array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => '',
                'color' => '',
                'font' => '',
                'font_style' => ''
    ), $atts ) );

    $classes = 'heading';
    if ( !empty( $class ) )
        $classes .= ' ' . $class;
    if ( !empty( $color ) )
        $classes .= ' ' . $color;
    if ( !empty( $font ) )
        $classes .= ' font-' . $font;
    if ( !empty( $font_style ) )
        $classes .= ' font-' . $font_style;

    return $before . "<h2 class='$classes' style='$style'>" . do_shortcode( $content ) . "</h2>" . $after;
}
add_shortcode( 'h2', 'calibrefx_h2' );


function calibrefx_h3( $atts, $content = '' ) {
    extract( shortcode_atts( array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => '',
                'color' => '',
                'font' => '',
                'font_style' => ''
    ), $atts ) );

    $classes = 'heading';
    if ( !empty( $class ) )
        $classes .= ' ' . $class;
    if ( !empty( $color ) )
        $classes .= ' ' . $color;
    if ( !empty( $font ) )
        $classes .= ' font-' . $font;
    if ( !empty( $font_style ) )
        $classes .= ' font-' . $font_style;

    return $before . "<h3 class='$classes' style='$style'>" . do_shortcode( $content ) . "</h3>" . $after;
}
add_shortcode( 'h3', 'calibrefx_h3' );

function calibrefx_h4( $atts, $content = '' ) {
    extract( shortcode_atts( array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => '',
                'color' => '',
                'font' => '',
                'font_style' => ''
    ), $atts ) );

    $classes = 'heading';
    if ( !empty( $class ) )
        $classes .= ' ' . $class;
    if ( !empty( $color ) )
        $classes .= ' ' . $color;
    if ( !empty( $font ) )
        $classes .= ' font-' . $font;
    if ( !empty( $font_style ) )
        $classes .= ' font-' . $font_style;

    return $before . "<h4 class='$classes' style='$style'>" . do_shortcode( $content ) . "</h4>" . $after;
}
add_shortcode( 'h4', 'calibrefx_h4' );

function calibrefx_h5( $atts, $content = '' ) {
    extract( shortcode_atts( array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => '',
                'color' => '',
                'font' => '',
                'font_style' => ''
    ), $atts ) );

    $classes = 'heading';
    if ( !empty( $class ) )
        $classes .= ' ' . $class;
    if ( !empty( $color ) )
        $classes .= ' ' . $color;
    if ( !empty( $font ) )
        $classes .= ' font-' . $font;
    if ( !empty( $font_style ) )
        $classes .= ' font-' . $font_style;

    return $before . "<h5 class='$classes' style='$style'>" . do_shortcode( $content ) . "</h5>" . $after;
}
add_shortcode( 'h5', 'calibrefx_h5' );

function calibrefx_h6( $atts, $content = '' ) {
    extract( shortcode_atts( array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => '',
                'color' => '',
                'font' => '',
                'font_style' => ''
    ), $atts ) );

    $classes = 'heading';
    if ( !empty( $class ) )
        $classes .= ' ' . $class;
    if ( !empty( $color ) )
        $classes .= ' ' . $color;
    if ( !empty( $font ) )
        $classes .= ' font-' . $font;
    if ( !empty( $font_style ) )
        $classes .= ' font-' . $font_style;

    return $before . "<h6 class='$classes' style='$style'>" . do_shortcode( $content ) . "</h6>" . $after;
}
add_shortcode( 'h6', 'calibrefx_h6' );