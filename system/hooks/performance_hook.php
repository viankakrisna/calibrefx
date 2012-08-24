<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @link		http://calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 * 
 *
 * @package CalibreFx
 */
/**
 * Calibrefx Performance Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
 */

add_action('init', 'calibrefx_gzip_compression');
/**
 * Enable GZip Compression
 */
function calibrefx_gzip_compression() {
     if (!current_theme_supports('calibrefx-preformance'))
         return false;
     
    // don't use on TinyMCE
    if (stripos($_SERVER['REQUEST_URI'], 'wp-includes/js/tinymce') !== false) {
        return false;
    }
    // can't use zlib.output_compression and ob_gzhandler at the same time
    if (( ini_get('zlib.output_compression') == 'On' || ini_get('zlib.output_compression_level') > 0 ) || ini_get('output_handler') == 'ob_gzhandler') {
        return false;
    }

    if (extension_loaded('zlib')) {
        ob_end_clean();
        ob_start('ob_gzhandler');
    }
}

add_filter('print_styles_array', 'minify_styles');
/**
 * Minify Styles and cache it
 */
function minify_styles($todo){
    global $cfx_minify, $wp_styles;
    
    if (!current_theme_supports('calibrefx-preformance'))
        return $todo;
    
    //Disable it in admin area
    if(is_admin() || calibrefx_get_script() == 'wp-login.php') 
        return $todo;
    
    
    
    $styles = array();
    foreach($todo as $handle){
        $obj = $wp_styles->registered[$handle];
        $styles[] = $obj->src;
    }
    
    wp_enqueue_style('calibrefx-minified', $cfx_minify->minified_css($styles));
    return array('calibrefx-minified');
}

add_filter('print_scripts_array', 'minify_scripts');
/**
 * Minify Scripts and cache it
 */
function minify_scripts($todo){
    global $cfx_minify, $wp_scripts;
    
    
    //Disable it in admin area
    if(is_admin() || calibrefx_get_script() == 'wp-login.php') 
        return $todo;
    
    if (!current_theme_supports('calibrefx-preformance'))
        return $todo;
    
    $scripts = array();
    foreach($todo as $handle){
        $obj = $wp_scripts->registered[$handle];
        $scripts[] = $obj->src;
    }
    
    wp_enqueue_script('calibrefx-minified', $cfx_minify->minified_js($styles));
    return array('calibrefx-minified');
}