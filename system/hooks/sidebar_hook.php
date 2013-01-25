<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @link		http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 * 
 *
 * @package CalibreFx
 */
/**
 * Calibrefx Sidebar Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */
add_action('calibrefx_sidebar', 'calibrefx_do_sidebar');

/**
 * Primary Sidebar Content
 */
function calibrefx_do_sidebar() {

    if (!dynamic_sidebar('sidebar')) {

        $output = '<div class="widget widget_text"><div class="widget-wrap">';
        $output .= '<h4 class="widgettitle">';
        $output .= __('Primary Sidebar Widget Area', 'calibrefx');
        $output .= '</h4>';
        $output .= '<div class="textwidget"><p>';
        $output .= sprintf(__('This is the Primary Sidebar Widget Area. You can add content to this area by visiting your <a href="%s">Widgets Panel</a> and adding new widgets to this area.', 'calibrefx'), admin_url('widgets.php'));
        $output .= '</p></div>';
        $output .= '</div></div>';
        
        echo apply_filters('calibrefx_sidebar_default', $output);
    }
}

add_action('calibrefx_sidebar_alt', 'calibrefx_do_sidebar_alt');

/**
 * Alternate Sidebar Content
 */
function calibrefx_do_sidebar_alt() {

    if (!dynamic_sidebar('sidebar-alt')) {

        $output = '<div class="widget widget_text"><div class="widget-wrap">';
        $output .=  '<h4 class="widgettitle">';
        $output .= __('Secondary Sidebar Widget Area', 'calibrefx');
        $output .=  '</h4>';
        $output .=  '<div class="textwidget"><p>';
        $output .= sprintf(__('This is the Secondary Sidebar Widget Area. You can add content to this area by visiting your <a href="%s">Widgets Panel</a> and adding new widgets to this area.', 'calibrefx'), admin_url('widgets.php'));
        $output .=  '</p></div>';
        $output .=  '</div></div>';
        
        echo apply_filters('calibrefx_sidebar_alt_default', $output);
    }
}