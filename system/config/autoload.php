<?php
/*
 * Auto-load Libraries
 */

$autoload['libraries'] = array( 'breadcrumb','security','replacer','form', 
							    'walker_nav_menu_edit', 'notification' );

/*
 * Auto-load Helper File
 */

$autoload['helpers'] = array('debug','format', 'image', 'html', 'url', 'widget', 
                             'option', 'layout', 'meta', 'meta_box','nav','post', 
                             'user','script','admin', 'mobile');

/*
 *  Auto-load Config files
 */
$autoload['configs'] = array();

/*
 *  Auto-load Config files
 */
/*$autoload['widgets'] = array( 'Facebook_Comment', 'Facebook_Like', 'Feature_Page_Slider', 
                              'Feature_Page', 'Feature_Post_Slider', 'Feature_Post',
                              'Subscriber', 'Twitter_Timeline', 'Latest_Post', 'Popular_Post', 'Social' );*/

/*
 *  Auto-load Config files
 */
$autoload['models'] = array( 'theme_settings_m' );

/*
 *  Auto-load Config files
 */
$autoload['hooks'] = array( 'module','header', 'script', 'widget','layout', 'menu', 
                          	'user','post','inpost','comments', 'footer',
                          	'upgrade', 'ajax', 
                          	'admin_ajax', 'mobile', 'form_submit', 'admin', 'customizer' );

/*
 *  Auto-load Shortcode files
 */
$autoload['shortcodes'] = array( 'calibrefx', 'header', 'post', 'footer' );