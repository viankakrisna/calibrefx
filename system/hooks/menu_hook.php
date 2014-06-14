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
 * Calibrefx menu Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */


global $cfxgenerator;
$cfxgenerator->calibrefx_after_header = array(
    array('function' => 'calibrefx_do_nav', 'priority' => 10),
    array('function' => 'calibrefx_do_subnav', 'priority' => 15)
);

/********************
 * FUNCTIONS BELOW  *
 ********************/

/**
 * This function is for displaying the "Primary Navigation" bar.
 */
function calibrefx_do_nav() {
    global $calibrefx;
    /** Do nothing if menu not supported */
    if (!calibrefx_nav_menu_supported('primary'))
        return;
    
    $calibrefx->load->library('walker_nav_menu');

    $nav = '';
    $args = '';

    $superfish_class = apply_filters( 'nav_superfish', ' superfish');

    if (calibrefx_get_option('nav')){
        if (has_nav_menu('primary')){
            $args = array(
                'theme_location' => 'primary',
                'container' => '',
                'menu_class' => 'nav navbar-nav menu-primary menu'.$superfish_class,
                'echo' => 0,
                'walker' => $calibrefx->walker_nav_menu,
            );
            
            $nav = wp_nav_menu($args);
        }else{
            $nav = '<ul id="menu-primary-i" class="nav navbar-nav menu-primary menu'. $superfish_class .'">
                    <li id="menu-item-812" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-800 current_page_item menu-item-812"><a href="#"><i class="fa fa-home"></i>&nbsp;&nbsp;Homepage</a></li>
                    <li id="menu-item-813" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-813"><a href="#"><i class="fa fa-comment"></i>&nbsp;&nbsp;About Us</a></li>
                    <li id="menu-item-817" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-817"><a href="#"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;Contact Page</a></li>
                </ul>';
        }

        $nav_class = apply_filters( 'nav_class', calibrefx_row_class() );

        if( current_theme_supports('calibrefx-responsive-style') ){
            $nav_output = sprintf('
                <div id="nav" class="navbar navbar-default">
                    %2$s
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="navbar-brand">%4$s</span>                            
                            <span class="menu-toggle-icon">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" role="navigation">%1$s</div>  
                    %3$s
                </div>
                <!-- end #nav -->', $nav, calibrefx_put_wrapper('nav', 'open', false), calibrefx_put_wrapper('nav', 'close', false), __('MENU', 'calibrefx'));
        }else{
            $nav_output = sprintf('
                <div id="nav" class="navbar navbar-default">
                    %2$s
                    %1$s
                    %3$s
                </div>
                <!-- end #nav -->', $nav, calibrefx_put_wrapper('nav', 'open', false), calibrefx_put_wrapper('nav', 'close', false));
        }

        echo apply_filters('calibrefx_do_nav', $nav_output, $nav, $args);
    }
}

/**
 * This function is for displaying the "Secondary Navigation" bar.
 */
function calibrefx_do_subnav() {
    global $calibrefx;
    /** Do nothing if menu not supported */
    if (!calibrefx_nav_menu_supported('secondary'))
        return;

    $calibrefx->load->library('walker_nav_menu');

    $subnav = '';
    $args = '';

    if (calibrefx_get_option('subnav')) {
        if (has_nav_menu('secondary')) {
            $args = array(
                'theme_location' => 'secondary',
                'container' => '',
                'menu_class' => 'nav nav-pills menu-secondary menu superfish',
                'echo' => 0,
                'walker' => new CFX_Walker_Nav_menu(),
            );

            $subnav = wp_nav_menu($args);
        }

        $subnav_output = sprintf('
			<div id="subnav">
                %2$s
				%1$s
                %3$s
			</div>
            <!-- end #subnav -->', $subnav, calibrefx_put_wrapper('subnav', 'open', false), calibrefx_put_wrapper('subnav', 'close', false));

        echo apply_filters('calibrefx_do_subnav', $subnav_output, $subnav, $args);
    }
}

/**
 * Add .active class when the current menu is active, not override the current-page-item
 * from WordPress
 */
function calibrefx_nav_menu_css_class($classes, $item) {
    if(!is_array($item->classes)) return $classes;
    
    if (in_array("current-menu-item", $item->classes) || in_array("current-menu-parent", $item->classes) || in_array("current-menu-acestor", $item->classes)) {
        $classes[] = "active";
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'calibrefx_nav_menu_css_class', 10, 2);

/**
 * Add custom fields to $item nav object
 * in order to be used in custom Walker to add an icon in nav menu
 *
 * @since       1.0.15 
 * @author      Hilaladdiyar Muhammad Nur (hilal@calibrefx.com)
*/
function calibrefx_custom_nav_icon($menu_item) {
    $menu_item->custom_icon = get_post_meta( $menu_item->ID, '_menu_item_custom_icon', true );
    return $menu_item;
}
add_filter( 'wp_setup_nav_menu_item','calibrefx_custom_nav_icon' );

function calibrefx_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
    // Check if element is properly sent
    if ( isset($_REQUEST['menu-item-icon']) && is_array( $_REQUEST['menu-item-icon']) ) {
        $icon_menu = $_REQUEST['menu-item-icon'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, '_menu_item_custom_icon', $icon_menu );
    }
}
add_action( 'wp_update_nav_menu_item', 'calibrefx_update_custom_nav_fields', 10, 3 );

function calibrefx_edit_walker($walker,$menu_id) {
    return 'CFX_Walker_Nav_Menu_Edit';
}
add_filter( 'wp_edit_nav_menu_walker', 'calibrefx_edit_walker', 10, 2);
