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
 * Calibrefx Debug Helper
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 * 
 */
if (!function_exists('debug_var')) {

    function debug_var($var) {
        $before = '<div style="padding:10px 20px 10px 20px; background-color:#fbe6f2; border:1px solid #d893a1; color: #000; font-size: 12px;>' . "\n";
        $before .= '<h5 style="font-family:verdana,sans-serif; font-weight:bold; font-size:18px;">Debug Helper Output</h5>' . "\n";
        $before .= '<pre>' . "\n";

        echo $before;
        var_dump($var);
        $after = '</pre>' . "\n";
        $after .= '</div>' . "\n";

        echo $after;
    }

}

if (!function_exists('debug_var_log')) {

    function debug_var_log($var) {
        ob_start(); //Start buffering
        var_dump($var); //print the result
        $output = ob_get_contents(); //get the result from buffer
        ob_end_clean(); //close buffer

        calibrefx_log_message('debug', 'Debug Var: '. $output);
    }

}

if (!function_exists('fire_debug')) {

    function fire_debug($var) {
        $CFX = & calibrefx_get_instance();
        $CFX->load->file(CALIBREFX_LIBRARY_URI . '/third-party/firephp/FirePHP.class.php');
        $firephp = FirePHP::getInstance(true);
        $firephp->log($var);
    }

}

if (!function_exists('die_dump')) {

    function die_dump() {
        list($callee) = debug_backtrace();
        $arguments = func_get_args();
        $total_arguments = count($arguments);
        echo '<fieldset style="background: #fefefe !important; border:2px red solid; padding:5px">';
        echo '<legend style="background:lightgrey; padding:5px;">' . $callee['file'] . ' @ line: ' . $callee['line'] . '</legend><pre>';

        $i = 0;
        foreach ($arguments as $argument) {
            echo '<br/><strong>Debug #' . (++$i) . ' of ' . $total_arguments . '</strong>: ';
            var_dump($argument);
        }

        echo "</pre>";
        echo "</fieldset>";
        die();
    }

}

if (!function_exists('debug_file')) {

    function debug_file($var = '', $filename = 'debug.txt') {

        $output = "";

        if (is_array($var)) {
            $output = print_r($var, TRUE);
        } elseif (is_object($var)) {
            ob_start(); //Start buffering
            var_dump($var); //print the result
            $output = ob_get_contents(); //get the result from buffer
            ob_end_clean(); //close buffer
        } else {
            ob_start(); //Start buffering
            var_dump($var); //print the result
            $output = ob_get_contents(); //get the result from buffer
            ob_end_clean(); //close buffer
        }

        $filepath = CALIBREFX_LOG_URI . '/' . $filename;
        $h = fopen($filepath, 'a+'); //open a file
        fwrite($h, $output); //write the output text
        fclose($h); //close file
    }

}