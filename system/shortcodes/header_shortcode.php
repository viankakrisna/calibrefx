<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @link		http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 * 
 *
 * @package CalibreFx
 */
/**
 * Calibrefx Header Shortcode
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

add_shortcode('h1', 'calibrefx_h1');

function calibrefx_h1($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => '',
                    ), $atts));

    return $before . "<h1 class='$class' style='$style'>" . do_shortcode($content) . "</h1>" . $after;
}

add_shortcode('h2', 'calibrefx_h2');

function calibrefx_h2($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => '',
                    ), $atts));

    return $before . "<h2 class='$class' style='$style'>" . do_shortcode($content) . "</h2>" . $after;
}

add_shortcode('h3', 'calibrefx_h3');

function calibrefx_h3($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => '',
                    ), $atts));

    return $before . "<h3 class='$class' style='$style'>" . do_shortcode($content) . "</h3>" . $after;
}

add_shortcode('h4', 'calibrefx_h4');

function calibrefx_h4($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => '',
                    ), $atts));

    return $before . "<h4 class='$class' style='$style'>" . do_shortcode($content) . "</h4>" . $after;
}

add_shortcode('h5', 'calibrefx_h5');

function calibrefx_h5($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => '',
                    ), $atts));

    return $before . "<h5 class='$class' style='$style'>" . do_shortcode($content) . "</h5>" . $after;
}

add_shortcode('h6', 'calibrefx_h6');

function calibrefx_h6($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => '',
                    ), $atts));

    return $before . "<h6 class='$class' style='$style'>" . do_shortcode($content) . "</h6>" . $after;
}