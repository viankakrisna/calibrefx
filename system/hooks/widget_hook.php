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
 * @package CalibreFx
 */

/**
 * Calibrefx Widget Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
 */

add_action('calibrefx_setup', 'calibrefx_register_default_widget');

/**
 * This function registers all the default CalibreFx widget.
 */
function calibrefx_register_default_widget() {

    calibrefx_register_sidebar(array(
        'name' => __('Primary Sidebar', 'calibrefx'),
        'description' => __('This is the primary sidebar if you are using a 2 or 3 column site layout option', 'calibrefx'),
        'id' => 'sidebar'
    ));

    calibrefx_register_sidebar(array(
        'name' => __('Secondary Sidebar', 'calibrefx'),
        'description' => __('This is the secondary sidebar if you are using a 3 column site layout option', 'calibrefx'),
        'id' => 'sidebar-alt'
    ));
}

add_action('after_setup_theme', 'calibrefx_register_additional_widget');

/**
 * This function registers additional CalibreFx widget.
 */
function calibrefx_register_additional_widget() {
    $header_right_widget = current_theme_supports('calibrefx-header-right-widgets');

    if ($header_right_widget) {
        calibrefx_register_sidebar(array(
            'name' => __('Header Right', 'calibrefx'),
            'description' => __('This is the right side of the header', 'calibrefx'),
            'id' => 'header-right'
        ));
    }

    $footer_widget = current_theme_supports('calibrefx-footer-widgets');

    if ($footer_widget) {
        calibrefx_register_sidebar(array(
            'name' => __('Footer Widget', 'calibrefx'),
            'description' => __('This is the footer widget', 'calibrefx'),
            'id' => 'footer-widget',
        ));
    }
}