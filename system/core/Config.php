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
 * Config Class
 *
 * Store config data
 *
 * @package		Core
 * @category    Config
 * @author		CalibreFx Dev Team
 * @link		http://www.CalibreFx.com
 */

// ------------------------------------------------------------------------
class CFX_Config {

    /**
     * List of all loaded config values
     *
     * @var array
     */
    public $config = array();

    /**
     * List of all loaded config files
     *
     * @var array
     */
    public $is_loaded = array();

    /**
     * List of paths to search when trying to load a config file.
     * This must be public as it's used by the Loader class.
     *
     * @var array
     */
    public $_config_paths = array(CALIBREFX_CONFIG_URI);

    /**
     * Constructor
     *
     * Sets the $config data from the primary config.php file as a class variable
     */
    public function __construct() {
        $this->config = get_config();
        calibrefx_log_message( 'debug', 'Config Class Initialized' );
    }

    // --------------------------------------------------------------------

    /**
     * Load Config File
     *
     * @param	string	the config file name
     * @param	bool	if configuration values should be loaded into their own section
     * @param	bool	true if errors should just return false, false if an error message should be displayed
     * @return	bool	if the file was loaded correctly
     */
    public function load( $file = '' ) {
        $file = ( $file === '' ) ? 'config' : str_replace( '.php', '', $file);
        $found = $loaded = FALSE;

        $check_locations = array( $file);

        foreach ( $this->_config_paths as $path) {
            foreach ( $check_locations as $location) {
                $file_path = $path . '/' . $location . '.php';

                if (in_array( $file_path, $this->is_loaded, TRUE) ) {
                    $loaded = TRUE;
                    continue 2;
                }

                if (file_exists( $file_path) ) {
                    $found = TRUE;
                    break;
                }
            }

            if ( $found === FALSE) {
                continue;
            }

            include( $file_path);

            if (!isset( $config) OR !is_array( $config) ) {
                return FALSE;
            }

            $this->config = array_merge( $this->config, $config);

            $this->is_loaded[] = $file_path;
            unset( $config);

            $loaded = TRUE;
            calibrefx_log_message( 'debug', 'Config file loaded: ' . $file_path);
            break;
        }

        if ( $loaded === FALSE) {
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Get a config file item
     *
     * @param	string	the config item name
     * @return	string
     */
    public function get_item( $item) {
        return isset( $this->config[$item]) ? $this->config[$item] : FALSE;
    }
    
    // --------------------------------------------------------------------

    /**
     * Set a config file item
     *
     * @param	string	the config item name
     * @return	void
     */
    public function set_item( $item) {
        $this->config[$item] = $value;
    }

}
