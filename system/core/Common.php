<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @license		Commercial
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This file calls the init.php file to initialize the framework
 *
 * @package CalibreFx
 */

/*
 * ------------------------------------------------------
 *  Load the framework constants
 * ------------------------------------------------------
 */

require(CALIBREFX_URI.'/system/config/constants.php');
 
 // function to replace wp_die if it doesn't exist
if (!function_exists('wp_die')) {
    function wp_die($message = 'wp_die') {
        die($message);
    }
}