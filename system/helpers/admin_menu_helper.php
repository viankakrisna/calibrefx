<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This file handles meta box in admin settings
 *
 * @package CalibreFx
 */

function calibrefx_clear_admin_menu() {
    global $calibrefx_admin_menu;
    unset($calibrefx_admin_menu);

    if (!isset($calibrefx_admin_menu))
        $calibrefx_admin_menu = array();
}

/**
 * calibrefx_add_admin_menu
 * 
 * Add menu in top admin menu
 * 
 * @param type $menu_title
 * @param type $capability
 * @param type $menu_slug
 * @param type $url
 */
function calibrefx_add_admin_menu($menu_title, $capability, $menu_slug, $url) {
    global $calibrefx_admin_menu;
    
    $calibrefx_admin_menu[$menu_slug] = array(
        'slug' => $menu_slug,
        'capability' => $capability,
        'title' => $menu_title,
        'url' => $url,
        'submenu' => array(),
    );
}

/**
 * calibrefx_add_admin_submenu
 * 
 * Add submenu in top menu admin menu
 * 
 * @param type $parent_slug
 * @param type $menu_title
 * @param type $capability
 * @param type $menu_slug
 * @param type $url
 */
function calibrefx_add_admin_submenu($parent_slug, $menu_title, $capability, $menu_slug, $url) {
    global $calibrefx_admin_menu;
    
    $calibrefx_admin_menu[$parent_slug]["submenu"][$menu_slug] = array(
        'slug' => $menu_slug,
        'capability' => $capability,
        'title' => $menu_title,
        'url' => $url,
    );
}