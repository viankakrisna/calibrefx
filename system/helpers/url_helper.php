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
 * Calibrefx URL Helper
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreWorks Team
 * @link            http://calibrefx.com
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