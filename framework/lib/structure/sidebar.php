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
 * This file hold all the functions to control sidebar
 *
 * @package CalibreFx
 */
 
add_action('calibrefx_sidebar', 'calibrefx_do_sidebar');
/**
 * Primary Sidebar Content
 */
function calibrefx_do_sidebar() {

	if ( !dynamic_sidebar('sidebar') ) {

		echo '<div class="widget widget_text"><div class="widget-wrap">';
			echo '<h4 class="widgettitle">';
				_e('Primary Sidebar Widget Area', 'calibrefx');
			echo '</h4>';
			echo '<div class="textwidget"><p>';
				printf(__('This is the Primary Sidebar Widget Area. You can add content to this area by visiting your <a href="%s">Widgets Panel</a> and adding new widgets to this area.', 'calibrefx'), admin_url('widgets.php'));
			echo '</p></div>';
		echo '</div></div>';

	}

}

add_action('calibrefx_sidebar_alt', 'calibrefx_do_sidebar_alt');
/**
 * Alternate Sidebar Content
 */
function calibrefx_do_sidebar_alt() {

	if ( !dynamic_sidebar('sidebar-alt') ) {

		echo '<div class="widget widget_text"><div class="widget-wrap">';
			echo '<h4 class="widgettitle">';
				_e('Secondary Sidebar Widget Area', 'genesis');
			echo '</h4>';
			echo '<div class="textwidget"><p>';
				printf(__('This is the Secondary Sidebar Widget Area. You can add content to this area by visiting your <a href="%s">Widgets Panel</a> and adding new widgets to this area.', 'genesis'), admin_url('widgets.php'));
			echo '</p></div>';
		echo '</div></div>';

	}

}