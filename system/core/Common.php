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
 * @link		http://www.calibrefx.com
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

// function to replace wp_die if it doesn't exist
if (!function_exists('wp_die')) {

    function wp_die($message = 'wp_die') {
        die($message);
    }

}

// ------------------------------------------------------------------------

if (!function_exists('get_config')) {

    /**
     * Loads the main config.php file
     *
     * This function lets us grab the config file even if the Config class
     * hasn't been instantiated yet
     *
     * @param	array
     * @return	array
     */
    function &get_config($replace = array()) {
        static $_config;

        if (isset($_config)) {
            return $_config[0];
        }

        $file_path = CALIBREFX_CONFIG_URI . '/config.php';
        $found = FALSE;
        if (file_exists($file_path)) {
            $found = TRUE;
            require($file_path);
        }

        // Are any values being dynamically replaced?
        if (count($replace) > 0) {
            foreach ($replace as $key => $val) {
                if (isset($config[$key])) {
                    $config[$key] = $val;
                }
            }
        }

        return $_config[0] = & $config;
    }

}

// ------------------------------------------------------------------------

if (!function_exists('config_item')) {

    /**
     * Returns the specified config item
     *
     * @param	string
     * @return	mixed
     */
    function config_item($item) {
        static $_config_item = array();

        if (!isset($_config_item[$item])) {
            $config = & get_config();

            if (!isset($config[$item])) {
                return FALSE;
            }
            $_config_item[$item] = $config[$item];
        }

        return $_config_item[$item];
    }

}

if (!function_exists('calibrefx_load_class')) {

    /**
     * Class registry
     *
     * This function acts as a singleton. If the requested class does not
     * exist it is instantiated and set to a static variable. If it has
     * previously been instantiated the variable is returned.
     *
     * @param	string	the class name being requested
     * @param	string	the directory where the class should be found
     * @param	string	the class name prefix
     * @return	object
     */
    function &calibrefx_load_class($class, $directory = 'libraries') {
        global $_cfx_classes;
        
        //class name should be uppercase first
        $class = ucfirst($class);
        
        //$temp_name = "CFX_" . $class;
        // Does the class exist? If so, we're done...
        if (isset($_cfx_classes[$class])) {
            return $_cfx_classes[$class];
        }

        $name = FALSE;

        if (file_exists(CALIBREFX_SYS_URI . '/' . $directory . '/' . $class . '.php')) {
            $name = $class;
            if (class_exists($name) === FALSE) {
                require(CALIBREFX_SYS_URI . '/' . $directory . '/' . $class . '.php');
            }
        }
        
        //We give our prefix
        $name = "CFX_" . $name;
        
        //if is abstract class we don't instantiate
        if(calibrefx_is_abstract($name)){
            $_cfx_classes[$class] = $name;
            return;
        }

        $_cfx_classes[$class] = new $name();
        calibrefx_log_message('debug', $name . ' Class Loaded');
        return $_cfx_classes[$class];
    }

}

if (!function_exists('calibrefx_is_abstract')) {
    /**
     * Check if the class is abstract class or not
     *
     * @param	string
     * @return	bool
     */
    function calibrefx_is_abstract($class){
        $class = new ReflectionClass($class);
        return $class->isAbstract();

    }
}

if (!function_exists('calibrefx_is_loaded')) {

    /**
     * Keeps track of which libraries have been loaded. This function is
     * called by the load_class() function above
     *
     * @param	string
     * @return	array
     */
    function &calibrefx_is_loaded($class = '') {
        static $_is_loaded = array();

        if ($class !== '') {
            $_is_loaded[strtolower($class)] = $class;
        }

        return $_is_loaded;
    }

}

if (!function_exists('calibrefx_get_instance')) {

    function &calibrefx_get_instance() {
        return Calibrefx::get_instance();
    }

}

// ------------------------------------------------------------------------

if (!function_exists('calibrefx_log_message')) {

    function calibrefx_log_message($level = 'error', $message = '', $php_error = FALSE) {
        global $_log;
        $_log = & calibrefx_load_class('Logger');
        $_log->write_log($level, $message, $php_error);
    }

}

// ------------------------------------------------------------------------

if (!function_exists('calibrefx_is_really_writable')) {

    /**
     * Tests for file writability
     *
     * is_writable() returns TRUE on Windows servers when you really can't write to
     * the file, based on the read-only attribute. is_writable() is also unreliable
     * on Unix servers if safe_mode is on.
     *
     * @param	string
     * @return	void
     */
    function calibrefx_is_really_writable($file) {
        // If we're on a Unix server with safe_mode off we call is_writable
        if (DIRECTORY_SEPARATOR === '/' && (bool) @ini_get('safe_mode') === FALSE) {
            return is_writable($file);
        }

        /* For Windows servers and safe_mode "on" installations we'll actually
         * write a file then read it. Bah...
         */
        if (is_dir($file)) {
            $file = rtrim($file, '/') . '/' . md5(mt_rand(1, 100) . mt_rand(1, 100));
            if (($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE) {
                return FALSE;
            }

            fclose($fp);
            @chmod($file, DIR_WRITE_MODE);
            @unlink($file);
            return TRUE;
        } elseif (!is_file($file) OR ($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE) {
            return FALSE;
        }

        fclose($fp);
        return TRUE;
    }

}

// ------------------------------------------------------------------------
/**
 * Check the php version
 * 
 * @return bool
 */
if (!function_exists('is_php')) {

    function is_php($version = '5.3.0') {
        static $_is_php;
        $version = (string) $version;

        if (!isset($_is_php[$version])) {
            $_is_php[$version] = (version_compare(PHP_VERSION, $version) >= 0);
        }

        return $_is_php[$version];
    }

}

// ------------------------------------------------------------------------
/**
 * Fire everything and display it.
 */
function calibrefx() {
    get_header();

    do_action('calibrefx_before_content_wrapper');
    ?>
    <div id="content-wrapper" class="row" >
        <?php do_action('calibrefx_before_content'); ?>
        <div id="content" class="<?php echo calibrefx_content_span(); ?>">
            <?php
            do_action('calibrefx_before_loop');
            do_action('calibrefx_loop');
            do_action('calibrefx_after_loop');
            ?>
        </div><!-- end #content -->
        <?php do_action('calibrefx_after_content'); ?>
    </div><!-- end #content-wrapper -->
    <?php
    do_action('calibrefx_after_content_wrapper');

    get_footer();
}