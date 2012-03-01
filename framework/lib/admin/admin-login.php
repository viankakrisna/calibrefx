<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibreworks.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * Handle admin login process and styles
 *
 * @package CalibreFx
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
		div#login h1 a { width:291px !important; height: 90px !important; background-image: url('.CALIBREFX_IMAGES_URL.'/CalibreWorks_logo.png) !important; background-repeat:no-repeat; }
		div#login form { -moz-box-shadow: 1px 1px 5px #EEEEEE, -1px -1px 5px #EEEEEE !important; -webkit-box-shadow: 1px 1px 5px #EEEEEE, -1px -1px 5px #EEEEEE !important; box-shadow: 1px 1px 5px #EEEEEE, -1px -1px 5px #EEEEEE !important; }
		div#login form label { cursor:pointer; }
		div#login form p.submit { margin-bottom: 0 !important; }
		div#login form input[type="submit"], div#login form input[type="submit"]:hover, div#login form input[type="submit"]:active, div#login form input[type="submit"]:focus { color: #666666 !important; text-shadow: 2px 2px 5px #EEEEEE !important; border: 1px solid #999999 !important; background: #FBFBFB !important; padding: 5px !important; -moz-border-radius: 3px !important; -webkit-border-radius: 3px !important; border-radius: 3px !important; }
		div#login form input[type="submit"]:hover, div#login form input[type="submit"]:active, div#login form input[type="submit"]:focus { color: #000000 !important; text-shadow: 2px 2px 5px #CCCCCC !important; border-color: #000000 !important; }
		div#login form#lostpasswordform { padding-bottom: 16px !important; } div#login form#lostpasswordform p.submit { float: none !important; } div#login form#lostpasswordform input[type="submit"] { width: 100% !important; }
		div#login form#registerform { padding-bottom: 16px !important; } div#login form#registerform p.submit { float: none !important; margin-top: -10px !important; } div#login form#registerform input[type="submit"] { width: 100% !important; }
		div#login form#registerform p#reg_passmail { font-style: italic !important; }

		</style>';
}

add_action('login_head', 'calibrefx_login_logo');

function calibrefx_wp_login_url() {
	echo apply_filters('calibrefx_wp_login_url', FRAMEWORK_URL);
}
add_filter('login_headerurl', calibrefx_wp_login_url);

function calibrefx_wp_login_title() {
	echo apply_filters('calibrefx_wp_login_title', _e('Powered By ') . FRAMEWORK_NAME . ' ' . FRAMEWORK_VERSION);
}
add_filter('login_headertitle', calibrefx_wp_login_title);