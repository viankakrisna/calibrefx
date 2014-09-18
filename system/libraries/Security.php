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
 * Calibrefx Security Class
 *
 * @package		Calibrefx
 * @subpackage          Library
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
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
        '%request_words%',
        '%category_title%',
        '%author_name%',
        '%date%',
        '%tag%',
        '%site_title%',
        '%taxonomy%',
        '%tag%'
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
    public function add_sanitize_filter( $filter, $field, $keys) {
        //Get the persistent filter from database
        $this->options = $this->get_sanitize_filter( $field);
        
        if (is_array( $keys) ) {
            foreach ( $keys as $key) {
                $this->options[$field][$key] = $filter;
            }
        } elseif (is_null( $keys) ) {
            $this->options[$field] = $filter;
        } else {
            $this->options[$field][$keys] = $filter;
        }

        wp_cache_set( $field.'_filters', $this->options );
        update_option( $field.'_filters', $this->options );

        return true;
    }

    public function get_sanitize_filter( $field) {

        //first we get the cache
        $current_filters = wp_cache_get( $field.'_filters' );

        //no cache available try from db
        if( $current_filters === false) {
            $current_filters = get_option( $field.'_filters' );
        }

        //if still no data we initialize it
        if(!$current_filters) $current_filters = array();

        //merge with the current option filter
        $this->options = array_merge( $current_filters, $this->options);

        return $this->options;

    }

    public function do_sanitize_filter( $filter, $new_value) {

        $available_filters = $this->get_available_filters();
        if (!in_array( $filter, array_keys( $available_filters) ))
            return $new_value;
        return call_user_func( $available_filters[$filter], $new_value);
    }

    public function get_available_filters() {
        $default_filters = array(
            'one_zero' => array(&$this, 'one_zero' ),
            'integer' => array(&$this, 'integer' ),
            'no_html' => array(&$this, 'no_html' ),
            'safe_html' => array(&$this, 'safe_html' ),
            'safe_js' => array(&$this, 'safe_js' ),
            'safe_text' => array(&$this, 'safe_text' ),
            'safe_url' => array(&$this, 'safe_url' ),
            'no_filter' => array(&$this, 'no_filter' ),
        );

        return apply_filters( 'calibrefx_available_sanitizer_filters', $default_filters);
    }

    /**
     * Sanitize array of input
     *
     * @param array of input
     * @param string of settings field
     * @return array 
     */
    public function sanitize_input( $field, $new_value) {
        if (!isset( $this->options[$field]) ) {
            return $new_value;
        } elseif (is_string( $this->options[$field]) ) {
            return $this->do_sanitize_filter( $this->options[$field], $new_value, get_option( $option) );
        } elseif (is_array( $this->options[$field]) ) {
            foreach ( $this->options[$field] as $key => $filter) {
                $new_value[$key] = isset( $new_value[$key]) ? $new_value[$key] : '';
                $new_value[$key] = $this->do_sanitize_filter( $filter, $new_value[$key]);
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
    function one_zero( $new_value) {

        return (int) (bool) $new_value;
    }

    /**
     * Returns an absolute integer.
     *
     * @param mixed $new_value 
     * @return integer.
     */
    function integer( $new_value) {

        return absint( $new_value);
    }

    /**
     * Removes HTML tags from string.
     *
     * @param string $new_value String, possibly with HTML in it
     * @return string String without HTML in it.
     */
    function no_html( $new_value) {

        return strip_tags( $new_value);
    }

    /**
     * filter javascript.
     *
     * @param string $new_value String with potentially unsafe HTML in it
     * @return string safe javascript
     */
    function safe_js( $new_value) {

        return esc_js( $new_value);
    }

    /**
     * filter url.
     *
     * @param string $new_value String with potentially unsafe HTML in it
     * @return string safe url
     */
    function safe_url( $new_value) {

        return esc_url( $new_value);
    }

    /**
     * filter safe text.
     *
     * @param string $new_value String with potentially unsafe HTML in it
     * @return string safe text
     */
    function safe_text( $new_value) {
        //If in safe text don't filter
        if (in_array( $new_value, $this->safe_value) ) {
            return $new_value;
        }
        return sanitize_text_field( $new_value);
    }

    /**
     * Removes unsafe HTML tags, via wp_kses_post().
     *
     * @param string $new_value String with potentially unsafe HTML in it
     * @return string String with only safe HTML in it
     */
    function safe_html( $new_value) {

        return wp_kses_post( $new_value);
    }

    /**
     * Do no filter
     *
     * @param string $new_value String with potentially unsafe HTML in it
     * @return string String with only safe HTML in it
     */
    function no_filter( $new_value) {

        return $new_value;
    }

    /**
     * Verify Nonce key
     * 
     * @uses wp_verify_nonce
     * @param string $nonce_key
     */
    public function verify_nonce( $action, $nonce_key) {
        if(!isset( $_POST[$nonce_key]) ) return false;

        return wp_verify_nonce( $_POST[$nonce_key], $action);
    }

}