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
 * Calibrefx Enqueue Script Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
 */

add_action('init', 'calibrefx_register_scripts');
/**
 * This function register our style and script files
 */
function calibrefx_register_scripts(){   
    wp_register_script('calibrefx-bootstrap', CALIBREFX_JS_URL . '/bootstrap.min.js', array('jquery'), FRAMEWORK_VERSION);
    wp_register_script('modernizr', CALIBREFX_JS_URL . '/modernizr.min.js', false, FRAMEWORK_VERSION);
    wp_register_script('jquery-validate', CALIBREFX_JS_URL . '/jquery.validate.js', array('jquery'), FRAMEWORK_VERSION);
    wp_register_script('jquery-sticky', CALIBREFX_JS_URL . '/jquery.sticky.js', array('jquery'), FRAMEWORK_VERSION);
    wp_register_script('calibrefx-script', CALIBREFX_JS_URL . '/calibrefx.js', array('jquery', 'jquery-validate'), FRAMEWORK_VERSION);
    wp_register_script('jquery.cycle', CALIBREFX_JS_URL . '/jquery.cycle.all.js', array('jquery'), FRAMEWORK_VERSION);
    wp_register_script('jquery-sticky', CALIBREFX_JS_URL . '/jquery.sticky.js', array('jquery'), FRAMEWORK_VERSION);
    wp_register_script('calibrefx-admin-bar', CALIBREFX_JS_URL . '/calibrefx-admin-bar.js', array('jquery'), FRAMEWORK_VERSION);
    
    wp_register_style('calibrefx-bootstrap', CALIBREFX_CSS_URL . '/bootstrap.min.css', FRAMEWORK_VERSION);
    wp_register_style('calibrefx-bootstrap-responsive', CALIBREFX_CSS_URL . '/bootstrap.responsive.min.css', FRAMEWORK_VERSION);
    wp_register_style('calibrefx-style', CALIBREFX_CSS_URL . '/calibrefx.css', FRAMEWORK_VERSION);
    wp_register_style('calibrefx-responsive-style', CALIBREFX_CSS_URL . '/calibrefx.responsive.css', FRAMEWORK_VERSION);
    wp_register_style('nivo-slider', CALIBREFX_CSS_URL . '/nivo-slider.css', FRAMEWORK_VERSION);
}

add_action('wp_enqueue_scripts', 'calibrefx_load_scripts');
/**
 * Load default calibrefx scripts
 * 
 * since @1.0
 */
function calibrefx_load_scripts() {
    wp_enqueue_script('modernizr');
    wp_enqueue_script('calibrefx-script');
    if (calibrefx_get_option('enable_bootstrap')) {
        wp_enqueue_script('calibrefx-bootstrap');
    }
    if (is_singular() && get_option('thread_comments') && comments_open()) {
        wp_enqueue_script('comment-reply');
    }
    wp_enqueue_script('superfish', CALIBREFX_JS_URL . '/superfish.js', array('jquery'), FRAMEWORK_VERSION, true);
    wp_enqueue_script('jquery.cycle');
    wp_localize_script('calibrefx-script', 'cfx_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'calibrefx_load_styles');

/**
 * Load default calibrefx styles
 * 
 * since @1.0
 */
function calibrefx_load_styles() {
    $calibrefx_default_style = get_theme_support('calibrefx-default-styles');

    /** If not active, do nothing */
    if (!$calibrefx_default_style)
        return;

    if (calibrefx_get_option('enable_bootstrap')) {
        wp_enqueue_style('calibrefx-bootstrap');

        if (calibrefx_get_option('enable_responsive')) {
            wp_enqueue_style('calibrefx-bootstrap-responsive');
        }
    }

    wp_enqueue_style('calibrefx-style');
    if (calibrefx_get_option('enable_responsive')) {
        wp_enqueue_style('calibrefx-responsive-style');
    }
}

add_action('admin_init', 'calibrefx_load_admin_scripts');

/**
 * This function loads the admin JS files
 *
 */
function calibrefx_load_admin_scripts() {
    add_thickbox();
    wp_enqueue_script('theme-preview');
    wp_enqueue_script('calibrefx-admin-bar');
    wp_enqueue_script('calibrefx_admin_js', CALIBREFX_JS_URL . '/admin.js', array('jquery', 'jquery-sticky'), FRAMEWORK_VERSION, true);
    $params = array(
        'category_checklist_toggle' => __('Select / Deselect All', 'calibrefx')
    );
    wp_localize_script('calibrefx_admin_js', 'calibrefx', $params);
}

add_action('admin_init', 'calibrefx_load_admin_styles');

function calibrefx_load_admin_styles() {
    wp_enqueue_style('calibrefx-admin-css', CALIBREFX_CSS_URL . '/calibrefx.admin.css', array(), FRAMEWORK_VERSION);
    wp_enqueue_style('admin-bar');
}