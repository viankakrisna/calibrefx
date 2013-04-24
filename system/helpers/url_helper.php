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
 * Calibrefx URL Helper
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 * 
 */

/**
 * Helper function to get the url and transform it to www-sitename-com.
 *
 */
function calibrefx_get_site_url() {
    $url = str_replace('.', '-', str_replace('http://', '', get_bloginfo('url')));
    return $url;
}

/**
 * This function redirects the user to an admin page, and adds query args
 * to the URL string for alerts, etc.
 */
function calibrefx_admin_redirect($page, $query_args = array()) {

    if (!$page)
        return;

    $url = menu_page_url($page, false);
    foreach ((array) $query_args as $key => $value) {
        if (isset($key) && isset($value)) {
            $url = add_query_arg($key, $value, $url);
        }
    }

    wp_redirect(esc_url_raw($url));
}

/**
 * Get the current url
 */
if ( !function_exists( 'get_current_url' ) ) :
function get_current_url(){
    global $wp;
    $current_url = home_url( $wp->request );
    return $current_url;
}
endif;