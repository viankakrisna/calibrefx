<?php
/**
 * CalibreFx Framework
 *
 * WordPress Themes by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @authorlink  http://www.calibrefx.com
 * @copyright   Copyright (c) 2012-2013, CalibreWorks. (http://www.calibreworks.com/)
 * @license		Commercial
 * @link		http://www.calibrefx.com
 * @filesource 
 *
 * The WordPress functions.php file. initialize CalibreFx framework and themes.
 *
 */

/**
 * Include CalibreFx WordPress Themes Framework
 */
require_once(TEMPLATEPATH.'/system/Bootloader.php');
global $calibrefx;
$calibrefx->load->library('email'); //we need load the email libraries here

//we need load the autoresponder libraries here
define('MAILVENTURE_URL', $calibrefx->other_settings_m->get('autoreponder_mailventure_url'));
define('MAILVENTURE_API_KEY', $calibrefx->other_settings_m->get('autoreponder_mailventure_api'));
require_once(CHILD_URI.'/system/libraries/third-party/MailVenture.class.php');