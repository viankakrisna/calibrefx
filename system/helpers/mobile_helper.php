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
 * Calibrefx Mobile Helper
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 * 
 */

/**
 * calibrefx_mobile_themes_exist
 * Check if the mobile theme exist in Child themes
 *
 * @return boolean
 * @author Ivan Kristianto
 **/
function calibrefx_mobile_themes_exist(){
	return file_exists(CHILD_URI . '/mobile');
}


/**
 * calibrefx_get_mobile_theme
 * this function will return the mobile folder from the child themes folder
 * this will use in add_filter 'template' & 'stylesheet'
 *
 * @return string
 * @author Ivan Kristianto
 **/
function calibrefx_get_mobile_theme(){
	return 'mobile';
}