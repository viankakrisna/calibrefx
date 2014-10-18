<?php defined( 'CALIBREFX_URL' ) OR exit();
/**
 * CalibreFx Framework
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package     CalibreFx
 * @author      CalibreFx Team 
 * @copyright   Copyright (c) 2012-2013, Calibreworks. (http://www.calibreworks.com/)
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
 * Calibrefx Navigation Helper
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 */

/**
 * Check if the nav menu is supported by the child themes
 */
function calibrefx_nav_menu_supported( $menu ) {

    if ( !current_theme_supports( 'calibrefx-menus' ) ) {
        return false;
    }

    $menus = get_theme_support( 'calibrefx-menus' );

    if ( array_key_exists( $menu, (array) $menus[0]) ) {
        return true;
    }

    return false;
}