<?php defined('CALIBREFX_URL') OR exit();
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
 * Calibrefx Shortcode Class
 *
 * @package		Calibrefx
 * @subpackage          Library
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
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
    var $form_url = "";
    var $width = "";
    var $height = "";
    var $title = "";
    var $img_url = "";

    public function calibrefx_add_shortcode_button($plugin_name = '', $form_url = '', $width = '320', $height = '460', $title = '', $img_url = '') {
        $this->plugin_name = $plugin_name;
        $this->form_url = $form_url;
        $this->width = $width;
        $this->height = $height;
        $this->title = $title;
        $this->img_url = $img_url;

        add_filter('tiny_mce_version', array(&$this, 'increase_tinymce_version'));
        add_action('init', array(&$this, 'add_sc_buttons'));
    }

    public function add_sc_buttons() {
        // Check that current user can edit post
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
            return;

        // Check that rich editing is enable
        if (get_user_option('rich_editing') == 'true') {
            add_filter("mce_external_plugins", array(&$this, "calibrefx_add_scbuttons_plugin"), 5);
            add_filter('mce_buttons_3', array(&$this, 'calibrefx_register_scbuttons_plugin'), 5);
        }
    }

    public function calibrefx_register_scbuttons_plugin($buttons) {
        array_push($buttons, "", $this->plugin_name);
        return $buttons;
    }

    public function calibrefx_add_scbuttons_plugin($plugin_arr) {
        $plugin_arr[$this->plugin_name] = CALIBREFX_SHORTCODE_URL . '/calibrefx_tinymce_add_plugin.php?plugin_name='.$this->plugin_name.'&form_url='.urlencode($this->form_url).'&width='.$this->width.'&height='.$this->height.'&title='.urlencode($this->title).'&img_url='.urlencode($this->img_url);
        return $plugin_arr;
    }

    public function increase_tinymce_version($version) {
        return++$version;
    }
}