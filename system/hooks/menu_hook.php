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
 * Calibrefx Logo Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */
add_action('admin_menu', 'calibrefx_register_admin_menu');

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

add_action('admin_menu', 'calibrefx_register_admin_sub_menu');

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

        $nav_output = sprintf('
            <div id="nav" class="navbar row">
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
            </div>', $nav, calibrefx_put_wrapper('nav', 'open', false), calibrefx_put_wrapper('nav', 'close', false));

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

        $subnav_output = sprintf('
			<div id="subnav" class="subnav row">
                                %2$s
				%1$s
                                %3$s
			</div>', $subnav, calibrefx_put_wrapper('subnav', 'open', false), calibrefx_put_wrapper('subnav', 'close', false));

        echo apply_filters('calibrefx_do_subnav', $subnav_output, $subnav, $args);
    }
}

add_filter('nav_menu_css_class', 'calibrefx_nav_menu_css_class', 10, 2);

/**
 * Add .active class when the current menu is active, not override the current-page-item
 * from WordPress
 */
function calibrefx_nav_menu_css_class($classes, $item) {
    if (in_array("current-menu-item", $item->classes) || in_array("current-menu-parent", $item->classes) || in_array("current-menu-acestor", $item->classes)) {
        $classes[] = "active";
    }
    return $classes;
}