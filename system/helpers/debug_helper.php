<?php defined( 'CALIBREFX_URL' ) OR exit();
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
 * debug_var function
 * Dump a variable with human readable format
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 * 
 */
if (!function_exists( 'debug_var' ) ) {

    function debug_var( $var) {
        $before = '<div style="padding:10px 20px 10px 20px; background-color:#fbe6f2; border:1px solid #d893a1; color: #000; font-size: 12px;>' . "\n";
        $before .= '<h5 style="font-family:verdana,sans-serif; font-weight:bold; font-size:18px;">Debug Helper Output</h5>' . "\n";
        $before .= '<pre>' . "\n";

        echo $before;
        var_dump( $var);
        $after = '</pre>' . "\n";
        $after .= '</div>' . "\n";

        echo $after;
    }

}

/**
 * debug_var_log function
 * Dump a variable with human readable format into a log file
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 * 
 */
if (!function_exists( 'debug_var_log' ) ) {

    function debug_var_log( $var) {
        ob_start(); //Start buffering
        var_dump( $var); //print the result
        $output = ob_get_contents(); //get the result from buffer
        ob_end_clean(); //close buffer

        calibrefx_log_message( 'debug', 'Debug Var: '. $output);
    }

}

/**
 * fire_debug function
 * Dump a variable and send it to FirePHP console, suitable to debug ajax output.
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 * 
 */
if (!function_exists( 'fire_debug' ) ) {

    function fire_debug( $var) {
        global $calibrefx;
        $calibrefx->load->file(CALIBREFX_LIBRARY_URI . '/third-party/firephp/FirePHP.class.php' );
        $firephp = FirePHP::getInstance(true);
        $firephp->log( $var);
    }

}

/**
 * die_dump function
 * Dump a variable and stop the process.
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 * 
 */
if (!function_exists( 'die_dump' ) ) {

    function die_dump() {
        list( $callee) = debug_backtrace();
        $arguments = func_get_args();
        $total_arguments = count( $arguments);
        echo '<fieldset style="background: #fefefe !important; border:2px red solid; padding:5px">';
        echo '<legend style="background:lightgrey; padding:5px;">' . $callee['file'] . ' @ line: ' . $callee['line'] . '</legend><pre>';

        $i = 0;
        foreach ( $arguments as $argument) {
            echo '<br/><strong>Debug #' . (++$i) . ' of ' . $total_arguments . '</strong>: ';
            var_dump( $argument);
        }

        echo "</pre>";
        echo "</fieldset>";
        die();
    }

}

/**
 * debug_file function
 * Dump a variable into a file. Suitable for rececive Post back by thirdparty such as PayPal IPN.
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 * 
 */
if (!function_exists( 'debug_file' ) ) {

    function debug_file( $var = '', $filename = 'debug.txt' ) {

        $output = "";

        if (is_array( $var) ) {
            $output = print_r( $var, TRUE);
        } elseif (is_object( $var) ) {
            ob_start(); //Start buffering
            var_dump( $var); //print the result
            $output = ob_get_contents(); //get the result from buffer
            ob_end_clean(); //close buffer
        } else {
            ob_start(); //Start buffering
            var_dump( $var); //print the result
            $output = ob_get_contents(); //get the result from buffer
            ob_end_clean(); //close buffer
        }

        global $wp_filesystem;
        $filepath = CALIBREFX_LOG_URI . '/' . $filename;
        $wp_filesystem->put_contents(
          $filepath,
          $output,
          FOPEN_READ_WRITE_CREATE // predefined mode settings for WP files
        );
        /*$h = fopen( $filepath, 'a+' ); //open a file
        fwrite( $h, $output); //write the output text
        fclose( $h); //close file*/
    }

}

if (!function_exists( 'list_hooks' ) ) {
    function list_hooks( $filter = false ) {
        global $wp_filter;
        
        $hooks = $wp_filter;
        ksort( $hooks );

        foreach( $hooks as $tag => $hook )
            if ( false === $filter || false !== strpos( $tag, $filter ) )
                dump_hook( $tag, $hook);
    }
}

if (!function_exists( 'list_live_hooks' ) ) {
    function list_live_hooks( $hook = false ) {
        if ( false === $hook )
            $hook = 'all';

        add_action( $hook, 'list_hook_details', -1 );
    }
}

if (!function_exists( 'list_hook_details' ) ) {
    function list_hook_details( $input = NULL ) {
        global $wp_filter;
        
        $tag = current_filter();
        if( isset( $wp_filter[$tag] ) )
            dump_hook( $tag, $wp_filter[$tag] );

        return $input;
    }
}

if (!function_exists( 'dump_hook' ) ) {
    function dump_hook( $tag, $hook ) {
        ksort( $hook);

        echo "<pre>&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";
        
        foreach( $hook as $priority => $functions ) {

        echo $priority;

        foreach( $functions as $function )
            if( $function['function'] != 'list_hook_details' ) {
            
            echo "\t";

            if( is_string( $function['function'] ) )
                echo $function['function'];

            // elseif( is_string( $function['function']()[0] ) )
            //      echo $function['function'][0] . ' -> ' . $function['function'][1];

            // elseif( is_object( $function['function']()[0] ) )
            //     echo "(object) " . get_class( $function['function'][0] ) . ' -> ' . $function['function'][1];

            else
                print_r( $function);

            echo ' ( ' . $function['accepted_args'] . ' ) <br />';
            }
        }

        echo '</pre>';
    }
}