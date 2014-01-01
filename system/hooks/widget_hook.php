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
 * Calibrefx Widget Hooks
 *
 * @package		Calibrefx
 * @subpackage  Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

global $cfxgenerator;

$cfxgenerator->calibrefx_setup = array('calibrefx_register_default_widget');
$cfxgenerator->init = array('calibrefx_register_additional_widget');

/********************
 * FUNCTIONS BELOW  *
 ********************/

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
// add_action('after_setup_theme', 'calibrefx_register_additional_widget');