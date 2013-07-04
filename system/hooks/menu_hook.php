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
 * Calibrefx Logo Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

// This is the process of checking to check whether to display the logo or not
if( !get_option( 'calibrefx_show_settings' ) ) {
    add_option( 'calibrefx_show_settings', 1);
}

if(get_option('calibrefx_show_settings')){
    add_action('admin_menu', 'calibrefx_register_admin_menu');
    add_action('admin_menu', 'calibrefx_register_admin_sub_menu');
}

// This function adds the top-level menu
function calibrefx_register_admin_menu() {
    global $menu;

    // Disable if programatically disabled
    if (!current_theme_supports('calibrefx-admin-menu'))
        return;

    // Create the new separator
    $menu['58.995'] = array('', 'edit_theme_options', '', '', 'wp-menu-separator');

    $CFX = & calibrefx_get_instance();
    $CFX->load->library('theme_settings');
    
    $CFX->theme_settings->pagehook = add_menu_page(__('Calibre Framework Settings', 'calibrefx'), 'CalibreFx', 'edit_theme_options', 'calibrefx', array(&$CFX->theme_settings, 'dashboard'), CALIBREFX_IMAGES_URL . '/calibrefx.gif', '58.996');
    add_submenu_page('calibrefx', __('Theme Settings', 'calibrefx'), __('Theme Settings', 'calibrefx'), 'edit_theme_options', 'calibrefx', array(&$CFX->theme_settings, 'dashboard'));
}

// This function adds the top-level menu
function calibrefx_register_admin_sub_menu() {
    global $menu, $calibrefx_user_ability;
    
    // Disable if programatically disabled
    if (!current_theme_supports('calibrefx-admin-menu'))
        return;

    // Create the new separator
    $menu['58.995'] = array('', 'edit_theme_options', '', '', 'wp-menu-separator');

    $CFX = & calibrefx_get_instance();
    
    
    if($calibrefx_user_ability === 'professor' && current_theme_supports('calibrefx-seo')){
        // Add "Seo Settings" submenu
        $CFX->load->library('seo_settings');
        $CFX->seo_settings->pagehook = add_submenu_page('calibrefx', __('Seo Settings', 'calibrefx'), __('Seo Settings', 'calibrefx'), 'edit_theme_options', 'calibrefx-seo', array(&$CFX->seo_settings, 'dashboard'));
    }
    
    // Add "About" submenu
    $CFX->load->library('about_settings');
    $CFX->about_settings->pagehook = add_submenu_page('calibrefx', __('About', 'calibrefx'), __('About', 'calibrefx'), 'edit_theme_options', 'calibrefx-about', array(&$CFX->about_settings, 'dashboard'));
    

    // Add "Other" submenu
    $CFX->load->library('other_settings');
    $CFX->other_settings->pagehook = add_submenu_page('calibrefx', __('Other', 'calibrefx'), __('Other', 'calibrefx'), 'edit_theme_options', 'calibrefx-other', array(&$CFX->other_settings, 'dashboard'));
}

add_action('after_setup_theme', 'calibrefx_register_nav_menus');

/**
 * Register CalibreFx menus with WordPress menu
 */
function calibrefx_register_nav_menus() {
    if (!current_theme_supports('calibrefx-menus'))
        return false;

    $menus = get_theme_support('calibrefx-menus');

    foreach ($menus as $menu) {
        register_nav_menus($menu);
    }
}

add_action('calibrefx_after_header', 'calibrefx_do_nav');

/**
 * This function is for displaying the "Primary Navigation" bar.
 */
function calibrefx_do_nav() {
    /** Do nothing if menu not supported */
    if (!calibrefx_nav_menu_supported('primary'))
        return;
    
    $CFX = &calibrefx_get_instance();
    $CFX->load->library('walker_nav_menu');

    $nav = '';
    $args = '';

    if (calibrefx_get_option('nav')) {
        if (has_nav_menu('primary')) {

            $args = array(
                'theme_location' => 'primary',
                'container' => '',
                'menu_class' => calibrefx_get_option('nav_fixed_top') ? 'navbar navbar-fixed-top menu-primary menu superfish sf-js-enabled' : 'superfish sf-js-enabled nav menu-primary menu',
                'echo' => 0,
                'walker' => $CFX->walker_nav_menu,
            );
            $nav = wp_nav_menu($args);
        }
        else{
            $nav = '<ul id="menu-primary-i" class="superfish sf-js-enabled nav menu-primary menu">
            <li id="menu-item-812" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-800 current_page_item menu-item-812"><a href="#"><i class="icon-home"></i>&nbsp;&nbsp;Homepage</a></li>
            <li id="menu-item-813" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-813"><a href="#"><i class="icon-comment"></i>&nbsp;&nbsp;About Us</a></li>
            <li id="menu-item-817" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-817"><a href="#"><i class="icon-envelope-alt"></i>&nbsp;&nbsp;Contact Page</a></li>
        </ul>';
        }

        $nav_class = apply_filters( 'nav_class', calibrefx_row_class() );
        $nav_output = sprintf('
            <div id="nav" class="navbar %4$s">
                %2$s
                <div class="navbar-inner">
                    <div class="container">
                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                    <div class="nav-collapse">%1$s</div>
                    </div>
                %3$s
                </div>
            </div>
            <!-- end #nav -->', $nav, calibrefx_put_wrapper('nav', 'open', false), calibrefx_put_wrapper('nav', 'close', false), $nav_class);
        
        echo apply_filters('calibrefx_do_nav', $nav_output, $nav, $args);
    }
}

add_action('calibrefx_after_header', 'calibrefx_do_subnav');

/**
 * This function is for displaying the "Secondary Navigation" bar.
 */
function calibrefx_do_subnav() {

    /** Do nothing if menu not supported */
    if (!calibrefx_nav_menu_supported('secondary'))
        return;

    $subnav = '';
    $args = '';

    if (calibrefx_get_option('subnav')) {
        if (has_nav_menu('secondary')) {
            $args = array(
                'theme_location' => 'secondary',
                'container' => '',
                'menu_class' => 'nav nav-pills menu-secondary menu superfish sf-js-enabled',
                'echo' => 0,
                'walker' => new CFX_Walker_Nav_menu(),
            );

            $subnav = wp_nav_menu($args);
        }

        $subnav_class = apply_filters( 'subnav_class', calibrefx_row_class() ) ;
        $subnav_output = sprintf('
			<div id="subnav" class="subnav %4$s">
                %2$s
				%1$s
                %3$s
			</div>
            <!-- end #subnav -->', $subnav, calibrefx_put_wrapper('subnav', 'open', false), calibrefx_put_wrapper('subnav', 'close', false), $subnav_class);

        echo apply_filters('calibrefx_do_subnav', $subnav_output, $subnav, $args);
    }
}

add_filter('nav_menu_css_class', 'calibrefx_nav_menu_css_class', 10, 2);

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

/**
 * Add custom fields to $item nav object
 * in order to be used in custom Walker to add an icon in nav menu
 *
 * @since       1.0.15 
 * @author      Hilaladdiyar Muhammad Nur (hilal@calibrefx.com)
*/
add_filter( 'wp_setup_nav_menu_item','calibrefx_custom_nav_icon' );
function calibrefx_custom_nav_icon($menu_item) {
    $menu_item->custom_icon = get_post_meta( $menu_item->ID, '_menu_item_custom_icon', true );
    return $menu_item;
}

add_action( 'wp_update_nav_menu_item', 'calibrefx_update_custom_nav_fields', 10, 3 );
function calibrefx_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
    // Check if element is properly sent
    if ( is_array( $_REQUEST['menu-item-icon']) ) {
        $icon_menu = $_REQUEST['menu-item-icon'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, '_menu_item_custom_icon', $icon_menu );
    }
}

add_filter( 'wp_edit_nav_menu_walker', 'calibrefx_edit_walker', 10, 2);
function calibrefx_edit_walker($walker,$menu_id) {
    return 'CFX_Walker_Nav_Menu_Edit';
}
