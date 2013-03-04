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
 * Calibrefx Logo Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

/**
 * 
 * Make custom login box
 *
 * List all licenses
 * @access public
 */
function calibrefx_login_logo() {
    echo '<style type="text/css">
            html, body { border: 0 !important; background: none !important; }
            body, .login { background: #F5F5F5 !important; }

            div#login { width: 440px !important; }
            div#login h1 a { width:291px !important; background-size: 260px 76px; padding-bottom: 0; height: 90px !important; background-image: url(' . CALIBREFX_IMAGES_URL . '/CalibreFX_logo.png) !important; background-repeat:no-repeat; }
            div#login form { -moz-box-shadow: 1px 1px 5px #EEEEEE, -1px -1px 5px #EEEEEE !important; -webkit-box-shadow: 1px 1px 5px #EEEEEE, -1px -1px 5px #EEEEEE !important; box-shadow: 1px 1px 5px #EEEEEE, -1px -1px 5px #EEEEEE !important; }
            div#login form label { cursor:pointer; }
            div#login form p.submit { margin-bottom: 0 !important; }
            div#login form#lostpasswordform { padding-bottom: 16px !important; } div#login form#lostpasswordform p.submit { float: none !important; } div#login form#lostpasswordform input[type="submit"] { width: 100% !important; }
            div#login form#registerform { padding-bottom: 16px !important; } div#login form#registerform p.submit { float: none !important; margin-top: -10px !important; } div#login form#registerform input[type="submit"] { width: 100% !important; }
            div#login form#registerform p#reg_passmail { font-style: italic !important; }
            div#login p.submit::after{ clear: both; }
            div#login p.submit::before, div#login p.submit::after{ display: table; content: \'\';  }
        </style>';
}

add_action('login_head', 'calibrefx_login_logo');

function calibrefx_wp_login_url() {
    return apply_filters('calibrefx_wp_login_url', FRAMEWORK_URL);
}

add_filter('login_headerurl', calibrefx_wp_login_url);

function calibrefx_wp_login_title() {
    return apply_filters('calibrefx_wp_login_title', __('Powered By ') . FRAMEWORK_NAME . ' ' . FRAMEWORK_VERSION);
}

add_filter('login_headertitle', calibrefx_wp_login_title);