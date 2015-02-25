<?php 
/**
 * Calibrefx Shortcode Hooks
 */

global $calibrefx;

$calibrefx->hooks->calibrefx_meta = array(
    array( 'function' => 'calibrefx_shortcode_scripts', 'priority' => 10 ),
    array( 'function' => 'calibrefx_shortcode_styles', 'priority' => 10 ),
);

function calibrefx_shortcode_scripts(){
	wp_enqueue_script( 'calibrefx-shortcodes' );
    wp_enqueue_script( 'jquery-appear' );
    wp_enqueue_script( 'jquery-easing' );
    wp_enqueue_script( 'jquery-transition' );
    wp_enqueue_script( 'jquery-lightbox' );
    wp_enqueue_script( 'googlemap', 'http://maps.google.com/maps/api/js?sensor=false&ver=4.1');
    wp_enqueue_script( 'infobox');
    wp_enqueue_script( 'jquery-googlemap' );
}

function calibrefx_shortcode_styles(){
	wp_enqueue_style( 'calibrefx-shortcodes' );
}