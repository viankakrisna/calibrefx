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
 * Contain function to register the widgets
 *
 * @package CalibreFx
 */
 
/** Include widget class files */
require_once( CALIBREFX_WIDGETS_DIR . '/subscriber-widget.php' );
require_once( CALIBREFX_WIDGETS_DIR . '/feature-page-widget.php' );
require_once( CALIBREFX_WIDGETS_DIR . '/latest-tweets-widget.php' );

//Hook all widgets to WordPress 'widgets_init'
add_action( 'widgets_init', 'calibrefx_register_widgets' );
/**
 * Register our widgets.
 */
function calibrefx_register_widgets() {
	register_widget( 'Calibrefx_Subscriber_Widget' );
	register_widget( 'Calibrefx_Feature_Page_Widget' );
	register_widget( 'Calibrefx_Latest_Tweets_Widget' );
}
