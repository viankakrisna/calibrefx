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
 * This class is to handle input sanitizing
 *
 * @package CalibreFx
 */

/**
 * CalibreFx Sanitizer Class
 *
 * Tags Replacer by CalibreFX
 *
 * @author		Ivan Kristianto
 * @version		1.0
 */
class CFX_Sanitizer {

    /**
     * Hold instance of self methods can be accessed staticly.
     *
     * @since 1.0
     *
     * @var CFX_Sanitizer
     */
    static $instance;

    /**
     * Constructor
     */
    function __construct() {
        self::$instance = & $this;

        do_action_ref_array('calibrefx_sanitizer_init', array(&$this));
    }

    /**
     * Add sanitization filters to options.
     *
     * Associates a sanitization filter to each option (or sub options if they
     * exist) before adding a reference to run the option through that
     * sanitizer at the right time.
     *
     * @since 1.0
     *
     * @param string $filter Sanitization filter type
     * @param string $option Option key
     * @param array $suboption Optional. Suboption key
     * @return boolean Returns true when complete
     */
    function add_filter($filter, $option, $suboption = null) {

        if (is_array($suboption)) {
            foreach ($suboption as $so) {
                $this->options[$option][$so] = $filter;
            }
        } elseif (is_null($suboption)) {
            $this->options[$option] = $filter;
        } else {
            $this->options[$option][$suboption] = $filter;
        }
        
        add_filter('sanitize_option_' . $option, array($this, 'sanitize'), 10, 2);

        return true;
    }

    /**
     * Checks sanitization filter exists, and if so, passes the value through it.
     *
     * @since 1.0
     *
     * @param string $filter Sanitization filter type
     * @param string $new_value New value
     * @param string $old_value Previous value
     * @return mixed Returns filtered value, or submitted value if value is
     * unfiltered.
     */
    function do_filter($filter, $new_value, $old_value) {

        
        $available_filters = $this->get_available_filters();
        
        if (!in_array($filter, array_keys($available_filters)))
            return $new_value;
        
//        if($old_value != 1 && !empty($old_value)){
//            wp_die(var_dump($new_value, $old_value));
//        }
        return call_user_func($available_filters[$filter], $new_value, $old_value);
    }

    /**
     * Return array of known sanitization filter types.
     *
     * Array can be filtered via 'calibrefx_available_sanitizer_filters' to let
     * child themes and plugins add their own sanitization filters.
     *
     * @since 1.0
     *
     * @return array Array with keys of sanitization types, and values of the
     * filter function name as a callback
     */
    function get_available_filters() {

        $default_filters = array(
            'one_zero' => array($this, 'one_zero'),
            'no_html' => array($this, 'no_html'),
            'safe_html' => array($this, 'safe_html'),
            'requires_unfiltered_html' => array($this, 'requires_unfiltered_html'),
        );

        return apply_filters('calibrefx_available_sanitizer_filters', $default_filters);
    }

    /**
     * Sanitize a value, via the sanitization filter type associated with an
     * option.
     *
     * @since 1.0
     *
     * @param mixed $new_value New value
     * @param string $option Name of the option
     * @return mixed Filtered, or unfiltered value
     */
    function sanitize($new_value, $option) {

        if (!isset($this->options[$option])) {
            /** We are not filtering this option at all */
            return $new_value;
        } elseif (is_string($this->options[$option])) {
            /** Single option value */
            return $this->do_filter($this->options[$option], $new_value, get_option($option));
        } elseif (is_array($this->options[$option])) {
            
            /** Array of suboption values to loop through */
            $old_value = get_option($option);
            foreach ($this->options[$option] as $suboption => $filter) {
                $old_value[$suboption] = isset($old_value[$suboption]) ? $old_value[$suboption] : '';
                $new_value[$suboption] = isset($new_value[$suboption]) ? $new_value[$suboption] : '';
                $new_value[$suboption] = $this->do_filter($filter, $new_value[$suboption], $old_value[$suboption]);
            }
           
            return $new_value;
        } else {
            return $new_value;
        }
    }

    /**
     * Returns a 1 or 0, for all truthy / falsy values.
     *
     * Uses double casting. First, we cast to bool, then to integer.
     *
     * @since 1.0
     *
     * @param mixed $new_value Should ideally be a 1 or 0 integer passed in
     * @return integer 1 or 0.
     */
    function one_zero($new_value) {
        
        return (int) (bool) $new_value;
    }

    /**
     * Removes HTML tags from string.
     *
     * @since 1.0
     *
     * @param string $new_value String, possibly with HTML in it
     * @return string String without HTML in it.
     */
    function no_html($new_value) {

        return strip_tags($new_value);
    }

    /**
     * Removes unsafe HTML tags, via wp_kses_post().
     *
     * @since 1.0
     *
     * @param string $new_value String with potentially unsafe HTML in it
     * @return string String with only safe HTML in it
     */
    function safe_html($new_value) {

        return wp_kses_post($new_value);
    }

    /**
     * Keeps the option from being updated if the user lacks unfiltered_html
     * capability.
     *
     * @since 1.0
     *
     * @param string $new_value New value
     * @param string $old_value Previous value
     * @return string New or previous value, depending if user has correct
     * capability or not.
     */
    function requires_unfiltered_html($new_value, $old_value) {

        if (current_user_can('unfiltered_html'))
            return $new_value;
        else
            return $old_value;
    }

}

/**
 * Registers an option sanitization filter.
 *
 * If the option is an "array" option type with "suboptions", you have to use the third param to specify the
 * suboption or suboptions you want the filter to apply to. DO NOT call this without the third parameter on an option
 * that is an array option, because in that case it will apply that filter to the array(), not each member.
 *
 * @since 1.0
 *
 * @uses CFX_Sanitizer::add_filter()
 *
 * @param string $filter The filter to call (see CFX_Sanitizer::$available_filters for options)
 * @param string $option The WordPress option name
 * @param string|array $suboption Optional. The suboption or suboptions you want to filter
 *
 * @return true
 */
function calibrefx_add_option_filter($filter, $option, $suboption = null) {

    return CFX_Sanitizer::$instance->add_filter($filter, $option, $suboption);
}

add_action('init', 'calibrefx_sanitizer_init');

/**
 * Instantiate the Sanitizer.
 *
 * @since 1.0
 */
function calibrefx_sanitizer_init() {

    new CFX_Sanitizer;
}