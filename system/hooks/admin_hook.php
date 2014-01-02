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

// This function adds the top-level menu
function calibrefx_register_admin_menu() {
    global $menu, $calibrefx;

    // Disable if programatically disabled
    if (!current_theme_supports('calibrefx-admin-menu'))
        return;

    // Create the new separator
    $menu['58.995'] = array('', 'edit_theme_options', '', '', 'wp-menu-separator');

    $theme = wp_get_theme();
    $theme_name = $theme->Name;
        
    $admin_menu_icon = CALIBREFX_IMAGES_URL . '/calibrefx.gif';
    if (file_exists( CHILD_IMAGES_URI . '/calibrefx.gif' )) $admin_menu_icon = CHILD_IMAGES_URL . '/calibrefx.gif';

    $calibrefx->load->library('theme_settings');
    
    $calibrefx->theme_settings->pagehook = add_menu_page(__('Calibre Framework Settings', 'calibrefx'), $theme_name, 'edit_theme_options', 'calibrefx', array($calibrefx->theme_settings, 'dashboard'), apply_filters('admin-menu-icon', $admin_menu_icon), '58.996');
    add_submenu_page('calibrefx', __('Settings', 'calibrefx'), __('Settings', 'calibrefx'), 'edit_theme_options', 'calibrefx', array($calibrefx->theme_settings, 'dashboard'));

    do_action( 'calibrefx_add_submenu_page' );
}
add_action('admin_menu', 'calibrefx_register_admin_menu');

function calibrefx_add_module_settings(){
    global $menu, $calibrefx, $calibrefx_user_ability;

    // Disable if programatically disabled
    if (!current_theme_supports('calibrefx-admin-menu'))
        return;

    $calibrefx->load->library('module_settings');
    $calibrefx->module_settings->pagehook = add_submenu_page('calibrefx', __('Modules', 'calibrefx'), __('Modules', 'calibrefx'), 'edit_theme_options', 'calibrefx-module', array($calibrefx->module_settings, 'dashboard'));
    $calibrefx->load->library('list_module_table', array('screen' => $calibrefx->module_settings->pagehook));
}
add_action('calibrefx_add_submenu_page', 'calibrefx_add_module_settings',20);

function calibrefx_add_about_settings(){
    global $menu, $calibrefx, $calibrefx_user_ability;

    // Disable if programatically disabled
    if (!current_theme_supports('calibrefx-admin-menu'))
        return;

    $calibrefx->load->library('about_settings');
    $calibrefx->about_settings->pagehook = add_submenu_page('calibrefx', __('About', 'calibrefx'), __('About', 'calibrefx'), 'edit_theme_options', 'calibrefx-about', array($calibrefx->about_settings, 'dashboard'));
}
add_action('calibrefx_add_submenu_page', 'calibrefx_add_about_settings',25);


function calibrefx_add_extra_settings(){
    global $menu, $calibrefx, $calibrefx_user_ability;

    // Disable if programatically disabled
    if (!current_theme_supports('calibrefx-admin-menu'))
        return;

    $calibrefx->load->library('other_settings');
    $calibrefx->other_settings->pagehook = add_submenu_page('calibrefx', __('Extras', 'calibrefx'), __('Extras', 'calibrefx'), 'edit_theme_options', 'calibrefx-other', array($calibrefx->other_settings, 'dashboard'));
}
add_action('calibrefx_add_submenu_page', 'calibrefx_add_extra_settings',30);

/**
 * 
 * Make custom login box
 *
 * @access public
 */
function calibrefx_login_logo() {
    /**
     * Add filter to change login logo
     * @author Hilaladdiyar Muhammad Nur (hilal@calibrefx.com)
     */
    $background_image = apply_filters( 'calibrefx_login_logo_url', CALIBREFX_IMAGES_URL . '/CalibreFX_logo.png' );

    echo '<style type="text/css">
            html, body { border: 0 !important; background: none !important; }
            body, .login { background: #F5F5F5 !important; }

            div#login { width: 440px !important; }
            div#login h1 a { width:291px !important; background-size: 260px 76px; padding-bottom: 0; height: 90px !important; background-image: url('.$background_image.') !important; background-repeat:no-repeat; }
            div#login form { -moz-box-shadow: 1px 1px 5px #EEEEEE, -1px -1px 5px #EEEEEE !important; -webkit-box-shadow: 1px 1px 5px #EEEEEE, -1px -1px 5px #EEEEEE !important; box-shadow: 1px 1px 5px #EEEEEE, -1px -1px 5px #EEEEEE !important; }
            div#login form label { cursor:pointer; }
            div#login form p.submit { margin-bottom: 0 !important; }
            div#login form#lostpasswordform { padding-bottom: 16px !important; } div#login form#lostpasswordform p.submit { float: none !important; } div#login form#lostpasswordform input[type="submit"] { width: 100% !important; }
            div#login form#registerform { padding-bottom: 16px !important; } div#login form#registerform p.submit { float: none !important; margin-top: -10px !important; } div#login form#registerform input[type="submit"] { width: 100% !important; }
            div#login form#registerform p#reg_passmail { font-style: italic !important; }
            div#login p.submit::after{ clear: both; }
            div#login p.submit::before, div#login p.submit::after{ display: table; content: \'\';  }
        </style>';
}
add_action('login_head', 'calibrefx_login_logo');

/**
 * Change url in logo login
 */
function calibrefx_wp_login_url() {
    return apply_filters('calibrefx_wp_login_url', FRAMEWORK_URL);
}
add_filter('login_headerurl', 'calibrefx_wp_login_url');

/**
 * Change the logo title in login page
 */
function calibrefx_wp_login_title() {
    return apply_filters('calibrefx_wp_login_title', __('Powered By ', 'calibrefx') . FRAMEWORK_NAME . ' ' . FRAMEWORK_VERSION);
}
add_filter('login_headertitle', 'calibrefx_wp_login_title');