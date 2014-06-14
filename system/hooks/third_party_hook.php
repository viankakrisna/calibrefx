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
 * Calibrefx Third Party Hooks
 *
 * @package		Calibrefx
 * @subpackage  Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

global $cfxgenerator;

$cfxgenerator->calibrefx_setup = array(
	array('function' => 'calibrefx_init_third_party', 'priority' => 0)
);

/********************
 * FUNCTIONS BELOW  *
 ********************/

/**
 * After frameworks is initialized we initialize other third party module
 */
function calibrefx_init_third_party(){
    global $oBrowser, $calibrefx;
	    
    $calibrefx->load->file(CALIBREFX_LIBRARY_URI . '/third-party/mobiledetector/mobiledetector.php');
    $oBrowser = new mobileDetector();
}