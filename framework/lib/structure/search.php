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
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This file control search box
 *
 * @package CalibreFx
 */


add_filter('get_search_form', 'calibrefx_search_form');
/**
 * Using a filter, we're replacing the default search form structure
 */
function calibrefx_search_form() {

	$search_text = get_search_query() ? esc_attr( apply_filters( 'the_search_query', get_search_query() ) ) : apply_filters( 'calibrefx_search_text', sprintf( esc_attr__('Search this website %s', 'calibrefx'), '&hellip;') );

	$button_text = apply_filters( 'calibrefx_search_button_text', esc_attr__( 'Search', 'calibrefx' ) );

	$onfocus = " onfocus=\"if (this.value == '$search_text') {this.value = '';}\"";
	$onblur = " onblur=\"if (this.value == '') {this.value = '$search_text';}\"";

	$form = '
		<form method="get" class="searchform" action="' . home_url() . '/" >
			<input type="text" value="'. $search_text .'" name="s" class="s"'. $onfocus . $onblur .' />
			<input type="submit" class="searchsubmit" value="'. $button_text .'" />
		</form>
	';

	return apply_filters('calibrefx_search_form', $form, $search_text, $button_text);
}