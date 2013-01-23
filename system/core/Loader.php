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
 * @package CalibreFx
 */

/**
 * Loader Class
 *
 * Load Libraries and Helpers
 *
 * @package		calibrefxlib
 * @subpackage          Core
 * @category            Loader
 * @author		CalibreFx Dev Team
 * @link		http://www.CalibreFx.com
 */
// ------------------------------------------------------------------------

class CFX_Loader {

    /**
     * List of paths to load libraries from
     *
     * @var array
     */
    public $_config_paths = array();

    /**
     * List of paths to load libraries from
     *
     * @var array
     */
    public $_library_paths = array();

    /**
     * List of paths to load models from
     *
     * @var array
     */
    public $_model_paths = array();

    /**
     * List of paths to load shortcode from
     *
     * @var array
     */
    public $_shortcode_paths = array();

    /**
     * List of paths to load widget from
     *
     * @var array
     */
    public $_widget_paths = array();

    /**
     * List of paths to load helpers from
     *
     * @var array
     */
    public $_helper_paths = array();

    /**
     * List of paths to load hook from
     *
     * @var array
     */
    public $_hook_paths = array();

    /**
     * List of loaded classes
     *
     * @var array
     */
    protected $_classes = array();

    /**
     * List of loaded files
     *
     * @var array
     */
    protected $_loaded_files = array();

    /**
     * List of loaded models
     *
     * @var array
     */
    protected $_loaded_models = array();

    /**
     * List of loaded widgets
     *
     * @var array
     */
    protected $_loaded_widgets = array();

    /**
     * List of loaded helpers
     *
     * @var array
     */
    protected $_helpers = array();

    /**
     * Constructor
     *
     * Sets the path to the helper and library files
     *
     * @return	void
     */
    public function __construct() {
        $this->_config_paths = array(CALIBREFX_CONFIG_URI);
        $this->_library_paths = array(CALIBREFX_LIBRARY_URI);
        $this->_helper_paths = array(CALIBREFX_HELPER_URI);
        $this->_model_paths = array(CALIBREFX_MODEL_URI);
        $this->_shortcode_paths = array(CALIBREFX_SHORTCODE_URI);
        $this->_widget_paths = array(CALIBREFX_WIDGET_URI);
        $this->_hook_paths = array(CALIBREFX_HOOK_URI);

        $this->initialize();

        calibrefx_log_message('debug', 'Loader Class Initialized');
    }

    // --------------------------------------------------------------------

    /**
     * Initialize the Loader
     *
     * This method is called once.
     *
     * @return 	object
     */
    public function initialize() {
        $this->_classes = array();
        $this->_loaded_files = array();
        $this->_helpers = array();
        $this->_loaded_models = array();

        $this->do_autoload();

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Do Autoload Files
     *
     * A utility function to load all autoload files and libraries
     *
     * @return 	void
     */
    public function do_autoload($autoload_file = '') {
        if (file_exists(CALIBREFX_CONFIG_URI . '/autoload.php')) {
            include(CALIBREFX_CONFIG_URI . '/autoload.php');
        }

        if (!empty($autoload_file) && file_exists($autoload_file)) {
            include($autoload_file);
        }

        if (!isset($autoload)) {
            return FALSE;
        }

        // Load Configs
        if (isset($autoload['configs']) && count($autoload['configs']) > 0) {
            $this->config($autoload['configs']);
        }
        
        // Autoload models
        if (isset($autoload['models'])) {
            $this->model($autoload['models']);
        }

        // Load Helpers
        if (isset($autoload['helpers']) && count($autoload['helpers']) > 0) {
            $this->helper($autoload['helpers']);
        }

        // Load libraries
        if (isset($autoload['libraries']) && count($autoload['libraries']) > 0) {
            foreach ($autoload['libraries'] as $item) {
                $this->library($item);
            }
        }

        // Load Hooks
        if (isset($autoload['hooks']) && count($autoload['hooks']) > 0) {
            $this->hook($autoload['hooks']);
        }

        // Load Widgets
        if (isset($autoload['widgets']) && count($autoload['widgets']) > 0) {
            $this->widget($autoload['widgets']);
        }

        // Load Hooks
        if (isset($autoload['shortcodes']) && count($autoload['shortcodes']) > 0) {
            $this->shortcodes($autoload['shortcodes']);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Is Loaded
     *
     * A utility function to test if a class is in the self::$_classes array.
     * This function returns the object name if the class tested for is loaded,
     * and returns FALSE if it isn't.
     *
     * @param 	string	class being checked for
     * @return 	mixed	class object name on the CI SuperObject or FALSE
     */
    public function is_loaded($class) {
        return isset($this->_classes[$class]) ? $this->_classes[$class] : FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * Load Hook
     *
     * This function loads the specified hook file.
     *
     * @param	mixed
     * @return	void
     */
    public function config($configs = array()) {
        foreach ($configs as $config) {
            // Try to load the helper
            foreach ($this->_config_paths as $path) {
                $filepath = $path . '/' . $config . '.php';

                if (isset($this->_loaded_files[$filepath])) {
                    //File loaded
                    return;
                }

                if (file_exists($filepath)) {
                    include_once($filepath);

                    $this->_loaded_files[] = $filepath;
                    calibrefx_log_message('debug', 'Config loaded: ' . $config);
                    break;
                }
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Model Loader
     *
     * This function lets users load and instantiate models.
     *
     * @param	string	the name of the class
     * @param	string	name for the model
     * @return	void
     */
    public function model($model, $name = '') {
        if (is_array($model)) {
            foreach ($model as $class) {
                $this->model($class);
            }
            return;
        }

        if ($model === '') {
            return;
        }

        $path = '';

        // Is the model in a sub-folder? If so, parse out the filename and path.
        if (($last_slash = strrpos($model, '/')) !== FALSE) {
            // The path is in front of the last slash
            $path = substr($model, 0, ++$last_slash);

            // And the model name behind it
            $model = substr($model, $last_slash);
        }

        if (empty($name)) {
            $name = $model;
        }

        if (in_array($name, $this->_loaded_models, TRUE)) {
            return;
        }

        $CFX = & calibrefx_get_instance();
        if (isset($CI->$name)) {
            calibrefx_log_message('error', 'The model name you are loading is the name of a resource that is already being used: ' . $name);
            //show_error('The model name you are loading is the name of a resource that is already being used: ' . $name);
            return;
        }

        $model = strtolower($model);
        $model = ucfirst($model);
        foreach ($this->_model_paths as $mod_path) {
            if (!file_exists($mod_path . '/' . $path . $model . '.php')) {
                continue;
            }

            if (!isset($CFX->Model)) {
                $CFX->Model = & calibrefx_load_class('Model', 'core');
            }

            require_once($mod_path . '/' . $path . $model . '.php');

            $CFX->$name = new $model();
            $this->_loaded_models[] = $name;
            calibrefx_log_message('debug', 'Model loaded: ' . $name);
            return;
        }

        // couldn't find the model
        calibrefx_log_message('error', 'Unable to locate the model you have specified: ' . $model);
    }

    // --------------------------------------------------------------------

    /**
     * Load Helper
     *
     * This function loads the specified helper file.
     *
     * @param	mixed
     * @return	void
     */
    public function helper($helpers = array()) {
        foreach ($this->_prep_filename($helpers, '_helper') as $helper) {
            if (isset($this->_helpers[$helper])) {
                continue;
            }

            // Try to load the helper
            foreach ($this->_helper_paths as $path) {
                if (file_exists($path . '/' . $helper . '.php')) {
                    include_once($path . '/' . $helper . '.php');

                    $this->_helpers[$helper] = TRUE;
                    calibrefx_log_message('debug', 'Helper loaded: ' . $helper);
                    break;
                }
            }

            // unable to load the helper
            if (!isset($this->_helpers[$helper])) {
                calibrefx_log_message('error', 'Cannot load helper: ' . $helper);
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Load Widget
     *
     * This function loads the specified widget file.
     *
     * @param	mixed
     * @return	void
     */
    public function widget($widgets = array()) {
        foreach ($widgets as $widget) {
            $widget_name = 'CFX_' . $widget . '_Widget';
            if (isset($this->_loaded_widgets[$widget_name])) {
                continue;
            }

            foreach ($this->_widget_paths as $path) {
                $filepath = $path . '/' . strtolower($widget). '_widget' . '.php';
                if (file_exists($filepath)) {
                    
                    include_once($filepath);

                    $this->_loaded_widgets[] = $widget_name;
                    register_widget($widget_name);
                    calibrefx_log_message('debug', 'Widget loaded: ' . $widget_name);
                    break;
                }
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Load Hook
     *
     * This function loads the specified hook file.
     *
     * @param	mixed
     * @return	void
     */
    public function hook($hooks = array()) {
        foreach ($this->_prep_filename($hooks, '_hook') as $hook) {
            // Try to load the helper
            foreach ($this->_hook_paths as $path) {
                $filepath = $path . '/' . $hook . '.php';

                if (isset($this->_loaded_files[$filepath])) {
                    //File loaded
                    return;
                }

                if (file_exists($filepath)) {
                    include_once($filepath);

                    $this->_loaded_files[] = $filepath;
                    calibrefx_log_message('debug', 'Hook loaded: ' . $hook);
                    break;
                }
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Load Shortcodes
     *
     * This function loads the specified array of shortcode files.
     *
     * @param	mixed
     * @return	void
     */
    public function shortcodes($shortcodes = array()) {
        foreach ($this->_prep_filename($shortcodes, '_shortcode') as $shortcode) {
            $this->shortcode($shortcode);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Load Shortcode
     *
     * This function loads the specified shortcode file.
     *
     * @param	mixed
     * @return	void
     */
    public function shortcode($shortcode) {
        if (!isset($shortcode))
            return;
        if (strpos($shortcode, '_shortcode') === FALSE) {
            $shortcode = $this->_prep_filename($shortcode, '_shortcode');
        }

        foreach ($this->_shortcode_paths as $path) {
            $filepath = $path . '/' . $shortcode . '.php';

            if (isset($this->_loaded_files[$filepath])) {
                //File loaded
                return;
            }

            if (file_exists($filepath)) {
                include_once($filepath);

                $this->_loaded_files[] = $filepath;
                calibrefx_log_message('debug', 'Shortcode loaded: ' . $shortcode);
                break;
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Load Files
     *
     * This function loads the specified array of files.
     *
     * @param	mixed
     * @return	void
     */
    public function files($files = array()) {
        foreach ($files as $file) {
            $this->file($file);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Load Files
     *
     * This function loads the specified array of files.
     *
     * @param	mixed
     * @return	void
     */
    public function file($file) {
        if (!isset($file))
            return;

        if (isset($this->_loaded_files[$file])) {
            //File loaded
            return;
        }
        if (file_exists($file)) {
            include_once($file);

            $this->_loaded_files[] = $file;
            calibrefx_log_message('debug', 'File loaded: ' . $file);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Driver Loader
     *
     * This function lets users load and instantiate driver.
     *
     * @param	string	the name of the class
     * @param	mixed	the optional parameters
     * @param	string	an optional object name
     * @return	void
     */
    public function driver($library = '', $params = NULL) {
        if (is_array($library)) {
            foreach ($library as $driver) {
                $this->driver($driver);
            }
            return FALSE;
        }

        if ($library === '') {
            return FALSE;
        }

        // Drivers always in a subfolder,
        // and typically identically named to the library
        if (!strpos($library, '/')) {
            $library = ucfirst($library) . '/' . $library;
        }

        return $this->library($library, $params);
    }

    // --------------------------------------------------------------------

    /**
     * Class Loader
     *
     * This function lets users load and instantiate classes.
     * It is designed to be called from a user's app controllers.
     *
     * @param	string	the name of the class
     * @param	mixed	the optional parameters
     * @param	string	an optional object name
     * @return	void
     */
    public function library($library = '', $params = NULL) {
        if (is_array($library)) {
            foreach ($library as $class) {
                $this->library($class, $params);
            }

            return;
        }

        if ($library === '') {
            return FALSE;
        }

        if (!is_null($params) && !is_array($params)) {
            $params = NULL;
        }

        $this->_load_class($library, $params);
    }

    // --------------------------------------------------------------------

    /**
     * Load class
     *
     * This function loads the requested class.
     *
     * @param	string	the item that is being loaded
     * @param	mixed	any additional parameters
     * @param	string	an optional object name
     * @return	void
     */
    protected function _load_class($class, $params = NULL) {
        // We clean the $class to get the filename
        $class = str_replace('.php', '', trim($class, '/'));

        // We look for a slash to determine subfolder
        $subdir = '';
        if (($last_slash = strrpos($class, '/')) !== FALSE) {
            // Extract the path
            $subdir = substr($class, 0, ++$last_slash);

            // Get the filename from the path
            $class = substr($class, $last_slash);
        }

        // We'll test for both lowercase and capitalized versions of the file name
        foreach (array(ucfirst($class), strtolower($class)) as $class) {
            // Lets search for the requested library file and load it.
            $is_duplicate = FALSE;
            foreach ($this->_library_paths as $path) {
                if ($subdir === '')
                    $filepath = $path . '/' . $class . '.php';
                else
                    $filepath = $path . '/' . $subdir . $class . '.php';

                // Does the file exist? No? Bummer...
                if (!file_exists($filepath)) {
                    continue;
                }

                include_once($filepath);
                $this->_loaded_files[] = $filepath;
                return $this->_init_class($class, 'CFX_', $params, $object_name);
            }
        } // END FOREACH
        // If we got this far we were unable to find the requested class.
        // We do not issue errors if the load call failed due to a duplicate request
        if ($is_duplicate === FALSE) {
            calibrefx_log_message('error', 'Unable to load the requested class: ' . $class);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Instantiates a class
     *
     * @param	string
     * @param	string
     * @param	bool
     * @param	string	an optional object name
     * @return	void
     */
    protected function _init_class($class, $prefix = '', $config = FALSE, $object_name = NULL) {
        $name = $prefix . $class;

        // Is the class name valid?
        if (!class_exists($name)) {
            calibrefx_log_message('error', 'Non-existent class: ' . $name);
            //show_error('Non-existent class: '.$class);
        }

        $classvar = strtolower($class);

        // Save the class name and object name
        $this->_classes[$class] = $classvar;

        // Instantiate the class
        $CFX = & calibrefx_get_instance();
        if ($config !== NULL) {
            $CFX->$classvar = new $name($config);
        } else {
            $CFX->$classvar = new $name();
        }

        calibrefx_log_message('debug', 'Class loaded: ' . $name);
    }

    // --------------------------------------------------------------------

    /**
     * Child Package Path
     *
     * Add child package path
     *
     * @return	void
     */
    public function add_child_path($path) {
        $CFX = & calibrefx_get_instance();
        $CFX->config->_config_paths[] = $path . '/config';
        $this->_config_paths[] = $path . '/config';
        $this->_library_paths[] = $path . '/libraries';
        $this->_helper_paths[] = $path . '/helpers';
        $this->_model_paths[] = $path . '/models';
        $this->_shortcode_paths[] = $path . '/shortcodes';
        $this->_widget_paths[] = $path . '/widgets';
        $this->_hook_paths[] = $path . '/hooks';
    }

    // --------------------------------------------------------------------

    /**
     * Prep filename
     *
     * This function preps the name of various items to make loading them more reliable.
     *
     * @param	mixed
     * @param 	string
     * @return	array
     */
    protected function _prep_filename($filename, $extension) {
        if (!is_array($filename)) {
            return array(strtolower(str_replace(array($extension, '.php'), '', $filename) . $extension));
        } else {
            foreach ($filename as $key => $val) {
                $filename[$key] = strtolower(str_replace(array($extension, '.php'), '', $val) . $extension);
            }

            return $filename;
        }
    }

}