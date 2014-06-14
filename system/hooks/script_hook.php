<?php defined('CALIBREFX_URL') OR exit();
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
 * Calibrefx Enqueue Script Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

global $cfxgenerator;

$cfxgenerator->init = array('calibrefx_register_scripts');
$cfxgenerator->calibrefx_meta = array(
    array('function' => 'calibrefx_load_scripts', 'priority' => 0), 
    array('function' => 'calibrefx_load_styles', 'priority' => 0),
);

/********************
 * FUNCTIONS BELOW  *
 ********************/

/**
 * This function register our style and script files
 */
function calibrefx_register_scripts(){   
    wp_register_style('calibrefx-bootstrap', CALIBREFX_CSS_URL . '/bootstrap.min.css');
    wp_register_style('calibrefx-bootstrap-theme', CALIBREFX_CSS_URL . '/bootstrap-theme.min.css');
    wp_register_style('calibrefx-style', CALIBREFX_CSS_URL . '/calibrefx.css');
    wp_register_style('font-awesome', CALIBREFX_CSS_URL . '/font-awesome.min.css');
    wp_register_style('jquery-superfish', CALIBREFX_CSS_URL . '/superfish.css');
    wp_register_style('calibrefx-template-style', CALIBREFX_URL . '/style.css');
    
    wp_register_script('calibrefx-bootstrap', CALIBREFX_JS_URL . '/bootstrap.min.js', array('jquery'));
    wp_register_script('modernizr', CALIBREFX_JS_URL . '/modernizr.min.js', false);
    wp_register_script('jquery-validate', CALIBREFX_JS_URL . '/jquery.validate.js', array('jquery'));
    wp_register_script('jquery-sticky', CALIBREFX_JS_URL . '/jquery.sticky.js', array('jquery'));
    wp_register_script('calibrefx-script', CALIBREFX_JS_URL . '/calibrefx.js', array('jquery', 'jquery-validate'));
    wp_register_script('jquery.cycle2', CALIBREFX_JS_URL . '/jquery.cycle2.js', array('jquery'));
    wp_register_script('jquery.cycle2.optional', CALIBREFX_JS_URL . '/jquery.cycle2.optional.js', array('jquery'));
    wp_register_script('jquery-sticky', CALIBREFX_JS_URL . '/jquery.sticky.js', array('jquery'));
    wp_register_script('calibrefx-admin-bar', CALIBREFX_JS_URL . '/calibrefx-admin-bar.js', array('jquery'));
}

/**
 * Load default calibrefx scripts
 * 
 * since @1.0
 */
function calibrefx_load_scripts() {
    wp_enqueue_script('modernizr');
    wp_enqueue_script('calibrefx-script');
    wp_enqueue_script('calibrefx-bootstrap');
    
    if (is_singular() && get_option('thread_comments') && comments_open()) {
        wp_enqueue_script('comment-reply');
    }
    wp_enqueue_script('superfish', CALIBREFX_JS_URL . '/superfish.js', array('jquery'), '', true);
    wp_enqueue_script('jquery.cycle2');
    wp_enqueue_script('jquery.cycle2.optional');
    wp_localize_script('calibrefx-script', 'cfx_ajax', array('ajaxurl' => admin_url('admin-ajax.php'), 'ajax_action' => 'cfx_ajax', '_ajax_nonce' => wp_create_nonce( 'calibrefx_ajax_nonce')));
}

/**
 * Load default calibrefx styles
 * 
 * since @1.0
 */
function calibrefx_load_styles() {
    global $wp_styles;

    $calibrefx_default_style = get_theme_support('calibrefx-default-styles');

    /** If not active, do nothing */
    if (!$calibrefx_default_style)
        return;

    wp_enqueue_style('calibrefx-bootstrap');
    wp_enqueue_style('calibrefx-style');
    wp_enqueue_style('font-awesome');
    wp_enqueue_style('jquery-superfish');
    
    /** Check for the active theme */
    $theme = wp_get_theme();
    if($theme->stylesheet != 'calibrefx'){
        $calibrefx_template_style = get_theme_support('calibrefx-template-styles');

        if ($calibrefx_template_style)
            wp_enqueue_style('calibrefx-template-style');
    }
}

/**
 * This function loads the admin JS files
 *
 */
function calibrefx_load_admin_scripts() {
    add_thickbox();
    wp_enqueue_script('theme-preview');
    wp_enqueue_script('calibrefx-admin-bar');
    wp_enqueue_script('calibrefx_admin_js', CALIBREFX_JS_URL . '/admin.js', array('jquery', 'jquery-sticky', 'wp-color-picker'), '');
    $params = array(
        'category_checklist_toggle' => __('Select / Deselect All', 'calibrefx'),
        'shortcode_url' => CALIBREFX_SHORTCODE_URL,
        'assets_img_url' => CALIBREFX_IMAGES_URL
    );
    wp_localize_script('calibrefx_admin_js', 'calibrefx_local', $params);
}
add_action('admin_init', 'calibrefx_load_admin_scripts');


function calibrefx_load_admin_styles() {
    wp_enqueue_style('calibrefx-admin-css', CALIBREFX_CSS_URL . '/calibrefx.admin.css', array());
    wp_enqueue_style('admin-bar');
    if (current_theme_supports('calibrefx-admin-bar')) {
        wp_enqueue_style('calibrefx-admin-bar-css', CALIBREFX_CSS_URL . '/calibrefx.admin.bar.css', array());
    }
    wp_enqueue_style( 'wp-color-picker' );
}
add_action('admin_init', 'calibrefx_load_admin_styles');

function calibrefx_remove_script_version( $src ){
	$parts = explode( '?', $src );
    if(strpos($src, $_SERVER['HTTP_HOST']) !== FALSE)
	   return $parts[0];

    return $src;
}
add_filter( 'script_loader_src', 'calibrefx_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'calibrefx_remove_script_version', 15, 1 );
