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
$autoload['models'] = array( 'theme_settings_m' );

/*
 *  Auto-load Config files
 */
$autoload['hooks'] = array( 'module','header', 'script', 'widget','layout', 'menu', 
                          	'user','post','inpost','comments', 'footer',
                          	'upgrade', 'ajax', 
                          	'admin_ajax', 'mobile', 'form_submit', 'admin', 'customizer' );