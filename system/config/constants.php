<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @license		Commercial
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This define the framework constants
 *
 * @package CalibreFx
 */

/** Define CALIBREFX Root Directory Constant */
!defined('CALIBREFX_CACHE_DIR') && define('CALIBREFX_CACHE_DIR', CALIBREFX_DIR . '/cache');
!defined('CALIBREFX_LOG_DIR') && define('CALIBREFX_LOG_DIR', CALIBREFX_DIR . '/log');
!defined('CALIBREFX_SYS_DIR') && define('CALIBREFX_SYS_DIR', CALIBREFX_DIR . '/system');

/** Define Assets Directory Constants */
!defined('CALIBREFX_IMAGES_DIR') && define('CALIBREFX_IMAGES_DIR', CALIBREFX_DIR . '/assets/img');
!defined('CALIBREFX_JS_DIR') && define('CALIBREFX_JS_DIR', CALIBREFX_DIR . '/assets/js');
!defined('CALIBREFX_CSS_DIR') && define('CALIBREFX_CSS_DIR', CALIBREFX_DIR . '/assets/css');

/*define('CALIBREFX_ADMIN_DIR', CALIBREFX_SYS_DIR . '/admin');
define('CALIBREFX_LIB_DIR', CALIBREFX_SYS_DIR . '/libraries');
define('CALIBREFX_SHORTCODES_DIR', CALIBREFX_SYS_DIR . '/shortcodes');
define('CALIBREFX_STRUCTURE_DIR', CALIBREFX_SYS_DIR . '/structure');
define('CALIBREFX_WIDGETS_DIR', CALIBREFX_SYS_DIR . '/widgets');*/


/** File and Directory Modes */
!defined('FILE_READ_MODE') && define('FILE_READ_MODE', 0644);
!defined('FILE_WRITE_MODE') && define('FILE_WRITE_MODE', 0666);
!defined('DIR_READ_MODE') && define('DIR_READ_MODE', 0755);
!defined('DIR_WRITE_MODE') && define('DIR_WRITE_MODE', 0777);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */
!defined('FOPEN_READ') && define('FOPEN_READ', 'rb');
!defined('FOPEN_READ_WRITE') && define('FOPEN_READ_WRITE', 'r+b');
!defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') && define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb');
!defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') && define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b');
!defined('FOPEN_WRITE_CREATE') && define('FOPEN_WRITE_CREATE', 'ab');
!defined('FOPEN_READ_WRITE_CREATE') && define('FOPEN_READ_WRITE_CREATE', 'a+b');
!defined('FOPEN_READ_WRITE_CREATE') && define('FOPEN_READ_WRITE_CREATE', 'a+b');
!defined('FOPEN_WRITE_CREATE_STRICT') && define('FOPEN_WRITE_CREATE_STRICT', 'xb');
!defined('FOPEN_READ_WRITE_CREATE_STRICT') && define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');