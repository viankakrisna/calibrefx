<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @link		http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 * 
 * @package CalibreFx
 */

/**
 * Calibrefx Adapter Class
 *
 * @package		Calibrefx
 * @subpackage          Core
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */
class CFX_Adapter {

    protected $valid_adapters = array();
    protected static $lib_name;
    protected $_adapter;
    
    public $driver_paths = array();

    function __get($child) {
        if (!isset($this->lib_name)) {
            $this->lib_name = get_class($this);
        }
		
        // The class will be prefixed with the parent lib
        $child_class = $this->lib_name . '_' . $child;
		
		
        $lib_name = ucfirst(strtolower(str_replace('CFX_', '', $this->lib_name)));
        $adapter_name = strtolower(str_replace('CFX_', '', $child_class));
		
        if (in_array($adapter_name, array_map('strtolower', $this->valid_adapters))) {
            // check and see if the adapter is in a separate file
            if (!class_exists($child_class)) {
                foreach ($this->driver_paths as $path) {
                    foreach (array(ucfirst($adapter_name), $adapter_name) as $class) {
                        $filepath = $path . '/' . $lib_name . '/Adapters/' . $child . '.php';
						
                        if (file_exists($filepath)) {
                            include_once $filepath;
                            break;
                        }
                    }
                }
				
                // it's a valid adapter, but the file simply can't be found
                if (!class_exists($child_class)) {
                    calibrefx_log_message('error', "Unable to load the requested adapter: " . $child_class);
                    return null;
                }
            }
			
            $obj = new $child_class;
            $obj->decorate($this);
            $this->$child = $obj;
            return $this->$child;
        }

        // The requested adapter isn't valid!
        calibrefx_log_message('error', "Invalid adapter requested: " . $child_class);
        return null;
    }
    
    /**
     * load Function
     *
     * Load the specified driver.
     * @access public
     * @author Ivan Kristianto (ivan@ivankristianto.com)
     * @param string $driver
     * @return bool
     */
    public function load($adapter, $driver='') {
		$lib_name = ucfirst(strtolower(str_replace('CFX_', '', get_class($this))));
        if (!in_array($lib_name . '_' .ucfirst($adapter), $this->valid_adapters))
            return FALSE;
		
        $this->_adapter = ucfirst($adapter);
        return TRUE;
    }

}