<?php 
/**
 * Calibrefx Model Class
 *
 */
class Calibrefx_Model {

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
    public function __construct( $setting_field = 'calibrefx-settings' ) {
        $this->_setting_field = $setting_field;
        $this->_cfx = calibrefx_get_instance();
    }
    
    public function get_settings_field() {
        return $this->_setting_field;
    }

    public function get( $key ) {
       
        $options = wp_cache_get( $this->_setting_field, $this->_setting_field );

        if( !$options OR !is_array( $options ) ){
            $options = apply_filters( 'calibrefx_options', get_option( $this->_setting_field ), $this->_setting_field );
            wp_cache_set( $this->_setting_field, $options, $this->_setting_field );
        }

        if ( $options AND isset( $options[$key] ) ) {
            if( is_array( $options[$key] ) ) {
                return $options[$key];
            } else {
                return stripslashes( $options[$key] );
            }
        }

        return FALSE;
    }

    public function get_all() {
        $options = apply_filters( 'calibrefx_options', get_option( $this->_setting_field ), $this->_setting_field );
        return $options;
    }

    public function save( $value ) {
        return update_option( $this->_setting_field, $value );
    }

}