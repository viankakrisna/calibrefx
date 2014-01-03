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
 * Calibrefx Search Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

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
            <div class="input-group">
                <input type="text" value="'. $search_text .'" name="s" class="s form-control"'. $onfocus . $onblur .' />
                <span class="input-group-btn">
                    <input type="submit" class="searchsubmit form-control btn btn-primary" value="'. $button_text .'" />
                </span>
            </div>
        </form>
    ';
    
    return apply_filters('calibrefx_search_form', $form, $search_text, $button_text);
}
add_filter('get_search_form', 'calibrefx_search_form');
