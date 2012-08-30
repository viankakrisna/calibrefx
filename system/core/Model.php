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
 * Calibrefx Model Class
 *
 * @package		Calibrefx
 * @subpackage          Core
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
 */
class CFX_Model {

    /**
     * Settings field key to save data in wp-options
     *
     * @var string
     */
    protected $_setting_field = '';

    /**
     * Calibrefx object
     *
     * @var object
     */
    protected $_cfx = null;

    /**
     * Initialize CFX_Model Class
     *
     * @return	void
     */
    public function __construct($setting_field = '') {
        $this->_setting_field = $setting_field;
    }
    
    public function get_settings_field(){
        return $this->_setting_field;
    }

    public function get($key) {
        $this->_cfx = & calibrefx_get_instance();

        if (!isset($this->_cfx->cache)) {
            $this->_cfx->cache = & calibrefx_load_class('cache', 'libraries');
        }

        $options = $this->_cfx->cache->cache_get($this->_setting_field, $this->_setting_field);

        if ($options && isset($options[$key])) {
            return $options[$key];
        }

        $options = apply_filters('calibrefx_options', get_option($this->_setting_field), $this->_setting_field);

        $this->_cfx->cache->cache_set($setting, $options, $setting);

        return $options[$key];
    }

}