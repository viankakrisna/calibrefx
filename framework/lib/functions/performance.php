<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This file contain functions to improve performance and reduce load time
 *
 * @package CalibreFx
 */

add_action('init', 'calibrefx_gzip_compression');

function calibrefx_gzip_compression() {
    // don't use on TinyMCE
    if (stripos($_SERVER['REQUEST_URI'], 'wp-includes/js/tinymce') !== false) {
        return false;
    }
    // can't use zlib.output_compression and ob_gzhandler at the same time
    if (( ini_get('zlib.output_compression') == 'On' || ini_get('zlib.output_compression_level') > 0 ) || ini_get('output_handler') == 'ob_gzhandler') {
        return false;
    }

    if (extension_loaded('zlib')) {
        ob_start('ob_gzhandler');
    }
}

//add_action('calibrefx_post_init', 'test_minify');
//function test_minify(){
//    global $cfx_minify;
//    //debug_var($cfx_minify->clear_cache());exit;
//}

add_filter('print_styles_array', 'minify_styles');
function minify_styles($todo){
    global $cfx_minify, $wp_styles;
    
    if (!current_theme_supports('calibrefx-preformance'))
        return;
    
    $styles = array();
    foreach($todo as $handle){
        $obj = $wp_styles->registered[$handle];
        $styles[] = $obj->src;
    }
    
    wp_enqueue_style('calibrefx-minified', $cfx_minify->minified_css($styles));
    return array('calibrefx-minified');
}

add_filter('print_scripts_array', 'minify_scripts');
function minify_scripts($todo){
    global $cfx_minify, $wp_scripts;
   
    if (!current_theme_supports('calibrefx-preformance'))
        return;
    
    $scripts = array();
    foreach($todo as $handle){
        $obj = $wp_scripts->registered[$handle];
        $scripts[] = $obj->src;
    }
    
    wp_enqueue_script('calibrefx-minified', $cfx_minify->minified_js($styles));
    return array('calibrefx-minified');
}