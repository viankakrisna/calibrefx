<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This file to handle cache mechanism
 *
 * @package CalibreFx
 */

/**
 * Calibrefx Security Class
 *
 * @package		Calibrefx
 * @subpackage          Library
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
 * @uses                WP_Cache
 */
class CFX_Security {

    /**
     * Hold our filter options
     *
     * @var	array
     */
    protected $options = array();
    
    /**
     * Safe value for text
     *
     * @var	array
     */
    protected $safe_value = array(
        '%description%',
        '%post_title%',
        '%page_title%',
        '%keywords%',
    );

    /**
     * Constructor
     */
    function __construct() {
        
    }

    /**
     * Add our sanitazion filter to the input
     *
     * 
     * @param string $filter Sanitization filter type
     * @param string $option Option key
     * @param array $keys Optional
     * @return boolean Returns true when complete
     */
    public function add_sanitize_filter($filter, $field, $keys) {

        if (is_array($keys)) {
            foreach ($keys as $key) {
                $this->options[$field][$key] = $filter;
            }
        } elseif (is_null($keys)) {
            $this->options[$field] = $filter;
        } else {
            $this->options[$field][$keys] = $filter;
        }

        //add_filter('sanitize_option_' . $field, array(&$this, 'sanitize_input'), 10, 2);

        return true;
    }

    public function do_sanitize_filter($filter, $new_value) {

        $available_filters = $this->get_available_filters();

        if (!in_array($filter, array_keys($available_filters)))
            return $new_value;
        
        return call_user_func($available_filters[$filter], $new_value);
    }

    public function get_available_filters() {
        $default_filters = array(
            'one_zero' => array(&$this, 'one_zero'),
            'integer' => array(&$this, 'integer'),
            'no_html' => array(&$this, 'no_html'),
            'safe_html' => array(&$this, 'safe_html'),
            'safe_js' => array(&$this, 'safe_js'),
            'safe_text' => array(&$this, 'safe_text'),
            'safe_url' => array(&$this, 'safe_url'),
        );

        return apply_filters('calibrefx_available_sanitizer_filters', $default_filters);
    }

    /**
     * Sanitize array of input
     *
     * @param array of input
     * @param string of settings field
     * @return array 
     */
    public function sanitize_input($field, $new_value) {
        if (!isset($this->options[$field])) {
            return $new_value;
        } elseif (is_string($this->options[$field])) {
            return $this->do_sanitize_filter($this->options[$field], $new_value, get_option($option));
        } elseif (is_array($this->options[$field])) {            
            foreach ($this->options[$field] as $key => $filter) {
                $new_value[$key] = isset($new_value[$key]) ? $new_value[$key] : '';
                $new_value[$key] = $this->do_sanitize_filter($filter, $new_value[$key]);
            }
            return $new_value;
        } else {
            return $new_value;
        }
    }

    /**
     * Returns a 1 or 0, for all truthy / falsy values.
     *
     * @param mixed $new_value Should ideally be a 1 or 0 integer passed in
     * @return integer 1 or 0.
     */
    function one_zero($new_value) {

        return (int) (bool) $new_value;
    }

    /**
     * Returns an absolute integer.
     *
     * @param mixed $new_value 
     * @return integer.
     */
    function integer($new_value) {

        return absint($new_value);
    }

    /**
     * Removes HTML tags from string.
     *
     * @param string $new_value String, possibly with HTML in it
     * @return string String without HTML in it.
     */
    function no_html($new_value) {

        return strip_tags($new_value);
    }

    /**
     * filter javascript.
     *
     * @param string $new_value String with potentially unsafe HTML in it
     * @return string safe javascript
     */
    function safe_js($new_value) {

        return esc_js($new_value);
    }

    /**
     * filter url.
     *
     * @param string $new_value String with potentially unsafe HTML in it
     * @return string safe url
     */
    function safe_url($new_value) {

        return esc_url($new_value);
    }

    /**
     * filter safe text.
     *
     * @param string $new_value String with potentially unsafe HTML in it
     * @return string safe text
     */
    function safe_text($new_value) {
        //If in safe text don't filter
        if(in_array($new_value, $this->safe_value)){
            return $new_value;
        }
        return sanitize_text_field($new_value);
    }

    /**
     * Removes unsafe HTML tags, via wp_kses_post().
     *
     * @param string $new_value String with potentially unsafe HTML in it
     * @return string String with only safe HTML in it
     */
    function safe_html($new_value) {

        return wp_kses_post($new_value);
    }

    /**
     * Verify Nonce key
     * 
     * @uses wp_verify_nonce
     * @param string $nonce_key
     */
    public function verify_nonce($action, $nonce_key){
        return (isset($_POST[$nonce_key]) || wp_verify_nonce($_POST[$nonce_key], $action));
    }
}