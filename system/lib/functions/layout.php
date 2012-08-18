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
 * This file have all calibrefx layout functions
 *
 * @package CalibreFx
 */

add_action('calibrefx_init', 'calibrefx_setup_layout', 0);

/**
 * Register all the available layout
 *
 * @access public
 * @return void
 */
function calibrefx_setup_layout() {

    calibrefx_register_layout(
            'content-sidebar', array(
        'label' => __('Content Sidebar (default blog)', 'calibrefx'),
        'img' => CALIBREFX_IMAGES_URL . '/layouts/cs.gif',
        'default' => true)
    );
    calibrefx_register_layout(
            'full-width-content', array(
        'label' => __('Full Width Content (minisite)', 'calibrefx'),
        'img' => CALIBREFX_IMAGES_URL . '/layouts/c.gif')
    );
    calibrefx_register_layout(
            'sidebar-content', array(
        'label' => __('Sidebar Content', 'calibrefx'),
        'img' => CALIBREFX_IMAGES_URL . '/layouts/sc.gif')
    );
    calibrefx_register_layout(
            'sidebar-content-sidebar', array(
        'label' => __('Sidebar Content Sidebar', 'calibrefx'),
        'img' => CALIBREFX_IMAGES_URL . '/layouts/scs.gif')
    );
}

/**
 * Function to check if layout is reponsive or fixed
 * 
 * @return type 
 */
function calibrefx_layout_is_responsive() {
    return calibrefx_get_option('layout_type') == 'fluid';
}

/**
 * Put wrappers into the structure
 *
 * @access public
 * @return string
 */
function calibrefx_put_wrapper($context = '', $output = '<div class="wrap row">', $echo = true) {

    $calibrefx_context_wrappers = get_theme_support('calibrefx-wraps');

    if (!in_array($context, (array) $calibrefx_context_wrappers[0]))
        return '';
    
    if(calibrefx_layout_is_responsive()) return '';

    switch ($output) {
        case 'open':
            $output = '<div class="wrap row">';
            break;
        case 'close':
            $output = '</div><!-- end .wrap -->';
            break;
    }

    if ($echo)
        echo $output;
    else
        return $output;
}