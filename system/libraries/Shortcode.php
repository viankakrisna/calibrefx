<?php

/**
 * Calibre Showcase
 *
 * Showcase Theme by Calibrefx Team
 *
 * @package		cfxShowcase
 * @author		Calibrefx Team
 * @copyright           Copyright (c) 2012, Suntech Inti Perkasa.
 * @link		http://www.calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * @package cfxShowcase
 */
/**
 * Calibrefx Shortcode Class
 *
 * @package		Calibrefx
 * @subpackage          Library
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
 */

/**
 * add shortcode buttons to editor
 *  
 * @access public
 * @author Hilaladdiyar Muhammad Nur
 *
 */
class CFX_Shortcode {

    var $plugin_name = "";

    function add_shortcode_button($plugin_name = '') {
        $this->plugin_name = $plugin_name;
        add_filter('tiny_mce_version', array(&$this, 'increase_tinymce_version'));
        add_action('init', array(&$this, 'add_sc_buttons'));
    }

    function add_sc_buttons() {
        // Check that current user can edit post
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
            return;

        // Check that rich editing is enable
        if (get_user_option('rich_editing') == 'true') {
            add_filter("mce_external_plugins", array(&$this, "calibrefx_add_scbuttons_plugin"), 5);
            add_filter('mce_buttons_3', array(&$this, 'calibrefx_register_scbuttons_plugin'), 5);
        }
    }

    function calibrefx_register_scbuttons_plugin($buttons) {
        array_push($buttons, "", $this->plugin_name);
        return $buttons;
    }

    function calibrefx_add_scbuttons_plugin($plugin_arr) {
        $plugin_arr[$this->plugin_name] = CALIBREFX_JS_URL . '/calibrefx-admin-shortcode.js';
        return $plugin_arr;
    }

    function increase_tinymce_version($version) {
        return++$version;
    }

}