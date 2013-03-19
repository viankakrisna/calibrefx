<?php
defined('CALIBREFX_URL') OR exit();
/**
 * CalibreFx Framework
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @authorlink  http://www.calibrefx.com
 * @copyright   Copyright (c) 2012-2013, CalibreWorks. (http://www.calibreworks.com/)
 * @license		GNU GPL v2
 * @link		http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This define the framework constants
 *
 * @package CalibreFx
 */

/*
 * Auto-load Libraries
 */

$autoload['libraries'] = array('cache','breadcrumb','security','replacer','form');

/*
 * Auto-load Helper File
 */

$autoload['helpers'] = array('debug','format', 'image', 'html', 'url', 'widget', 
                             'option', 'layout', 'meta_box','nav','post','seo', 
                             'user','script','admin_menu');

/*
 *  Auto-load Config files
 */
$autoload['configs'] = array();

/*
 *  Auto-load Config files
 */
$autoload['widgets'] = array('Facebook_Comment', 'Facebook_Like', 'Feature_Page_Slider', 
                            'Feature_Page', 'Feature_Post_Slider', 'Feature_Post',
                            'Latest_Tweets', 'Subscriber', 'Twitter');

/*
 *  Auto-load Config files
 */
$autoload['models'] = array('theme_settings_m', 'seo_settings_m', 'other_settings_m');

/*
 *  Auto-load Config files
 */
$autoload['hooks'] = array('header', 'logo', 'script', 'widget','layout', 'menu', 
                          'login','user','admin_bar','post','inpost','comments', 'footer',
                          'sidebar','seo','performance','search','third_party','upgrade', 'ajax', 
                          'admin_ajax', 'mobile');

/*
 *  Auto-load Shortcode files
 */
$autoload['shortcodes'] = array('calibrefx','header','post','footer');