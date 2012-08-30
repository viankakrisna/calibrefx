<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @link		http://calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 * 
 *
 * @package CalibreFx
 */

/**
 * Calibrefx Navigation Helper
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreWorks Team
 * @link            http://calibrefx.com
 */

/**
 * Check if the nav menu is supported by the child themes
 */
function calibrefx_nav_menu_supported($menu) {

    if (!current_theme_supports('calibrefx-menus'))
        return false;

    $menus = get_theme_support('calibrefx-menus');

    if (array_key_exists($menu, (array) $menus[0]))
        return true;

    return false;
}