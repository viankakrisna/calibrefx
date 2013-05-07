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
 * Calibrefx Option Helper
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 */

/**
 * Get option value based on option key
 *
 * @access public
 * @param string option key
 * @param object CFX_Model, default null
 * @return void
 */
function calibrefx_get_option($key, $model = null) {
    $CFX = & calibrefx_get_instance();
    
    if(null === $model){
        if(!isset($CFX->theme_settings_m)){
            $CFX->load->model('theme_settings_m');
        }
        //we load default model
        $model = $CFX->theme_settings_m;  
    }
    
    return $model->get($key);
}

function calibrefx_option($key, $model = null) {
    echo calibrefx_get_option($key, $model);
}

/**
 * These functions can be used to easily and efficiently pull data from a
 * post/page custom field. Returns FALSE if field is blank or not set.
 *
 * @param string $field used to indicate the custom field key
 */
function calibrefx_custom_field($field) {
    echo calibrefx_get_custom_field($field);
}

function calibrefx_get_custom_field($field) {

    global $id, $post;

    if (null === $id && null === $post) {
        return false;
    }

    $post_id = null === $id ? $post->ID : $id;

    $custom_field = get_post_meta($post_id, $field, true);

    if ($custom_field) {
        if(!is_array($custom_field)){
            /** sanitize and return the value of the custom field */
            return stripslashes(wp_kses_decode_entities($custom_field));
        }
        return $custom_field;
    } else {
        /** return false if custom field is empty */
        return false;
    }
}

function calibrefx_get_usermeta($user_id, $key, $single = true) {
    //@TODO: user cache mechanism here

    $options = apply_filters('calibrefx_usermeta', get_user_meta($user_id, $key, $single));

    return $options;
}

function calibrefx_usermeta($user_id, $key) {
    return calibrefx_get_usermeta($user_id, $key);
}