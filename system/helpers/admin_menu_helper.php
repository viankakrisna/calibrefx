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

function calibrefx_add_admin_menu_separator($position) {
  global $menu;
  $index = 0;
  foreach($menu as $offset => $section) {
    if (substr($section[2],0,9)=='separator')
      $index++;
    if ($offset>=$position) {
      $menu[$position] = array('','read',"separator{$index}",'','wp-menu-separator');
      break;
    }
  }
  ksort( $menu );
}