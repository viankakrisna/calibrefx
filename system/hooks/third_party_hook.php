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
 * Calibrefx Third Party Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
 */

add_action('calibrefx_setup', 'calibrefx_init_third_party');
/**
 * After frameworks is initialized we initialize other third party module
 */
function calibrefx_init_third_party(){
    global $oBrowser;
    
    $CFX = & calibrefx_get_instance();
    $CFX->load->file(CALIBREFX_LIBRARY_URI . '/third-party/browserdetector/clsBrowser.php');
    $oBrowser = new clsBrowser();
    $oBrowser->Detect();
}