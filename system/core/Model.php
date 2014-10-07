<?php 
/**
 * Calibrefx Model Class
 *
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
     * @return  void
     */
    public function __construct($setting_field = '') {
        $this->_setting_field = $setting_field;
    }
    
    public function get_settings_field(){
        return $this->_setting_field;
    }

    public function get($key) {
        $this->_cfx = calibrefx_get_instance();

        if (!isset($this->_cfx->cache)) {
            $this->_cfx->cache = calibrefx_load_class('cache', 'libraries');
        }

        $options = $this->_cfx->cache->cache_get($this->_setting_field, $this->_setting_field);

        if ($options AND isset($options[$key])) {
			if(is_array($options[$key])) return $options[$key];
            else return stripslashes($options[$key]);
        }

        $options = apply_filters('calibrefx_options', get_option($this->_setting_field), $this->_setting_field);

        $this->_cfx->cache->cache_set($this->_setting_field, $options, $this->_setting_field);

        if(!isset($options[$key])) return false;
        
        return stripslashes($options[$key]);
    }

    public function get_all(){
        $options = apply_filters('calibrefx_options', get_option($this->_setting_field), $this->_setting_field);
        return $options;
    }

    public function save($value){
        return update_option($this->_setting_field, $value);
    }

}