<?php

/**
 * ==============================================================
 * Header Section
 * ==============================================================
 */
add_shortcode('h1', 'calibrefx_h1');

function calibrefx_h1($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                    ), $atts));

    return $before . "<h1 class='$class'>" . do_shortcode($content) . "</h1>" . $after;
}

add_shortcode('h2', 'calibrefx_h2');

function calibrefx_h2($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                    ), $atts));

    return $before . "<h2 class='$class'>" . do_shortcode($content) . "</h2>" . $after;
}

add_shortcode('h3', 'calibrefx_h3');

function calibrefx_h3($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                    ), $atts));

    return $before . "<h3 class='$class'>" . do_shortcode($content) . "</h3>" . $after;
}

add_shortcode('h4', 'calibrefx_h4');

function calibrefx_h4($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                    ), $atts));

    return $before . "<h4 class='$class'>" . do_shortcode($content) . "</h4>" . $after;
}

add_shortcode('h5', 'calibrefx_h5');

function calibrefx_h5($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                    ), $atts));

    return $before . "<h5 class='$class'>" . do_shortcode($content) . "</h5>" . $after;
}

/**
 * ==============================================================
 * Video Section
 * ==============================================================
 */
add_shortcode('youtube', 'calibrefx_youtube');

function calibrefx_youtube($atts, $content = null) {

    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'width' => '',
                'height' => '',
                'title' => '',
                    ), $atts));

    return '<iframe title="' . $title . '" width="' . $width . '" height="' . $height . '" src="http://www.youtube.com/embed/' . do_shortcode($content) . '" frameborder="0" allowfullscreen></iframe>';
}

add_shortcode('vimeo', 'calibrefx_vimeo');

function calibrefx_vimeo($atts, $content = null) {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'width' => '',
                'height' => '',
                'title' => '',
                    ), $atts));

    return '<iframe title="' . $title . '" width="' . $width . '" height="' . $height . '" src="http://player.vimeo.com/video/' . do_shortcode($content) . '" frameborder="0"></iframe>';
}

/**
 * ==============================================================
 * Typography Section
 * ==============================================================
 */
add_shortcode('font', 'calibrefx_font');

function calibrefx_font($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'family' => '',
                'color' => '',
                'size' => 20,
                'class' => '',
                    ), $atts));

    return $before . '<span class="' . $class . '" style="font-family:' . $family . ';color:' . $color . ';font-size:' . $size . 'px;">	' . do_shortcode($content) . '</span>' . $after;
}

add_shortcode('bold', 'calibrefx_bold');

function calibrefx_bold($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                    ), $atts));

    return $before . '<strong>' . do_shortcode($content) . '</strong>' . $after;
}

add_shortcode('italic', 'calibrefx_italic');

function calibrefx_italic($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                    ), $atts));

    return $before . '<i>' . do_shortcode($content) . '</i>' . $after;
}

add_shortcode('em', 'calibrefx_em');

function calibrefx_em($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                    ), $atts));

    return $before . '<em>' . do_shortcode($content) . '</em>' . $after;
}

add_shortcode('cite', 'calibrefx_cite');

function calibrefx_cite($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                    ), $atts));

    return $before . '<cite>' . do_shortcode($content) . '</cite>' . $after;
}

add_shortcode('blockquote', 'calibrefx_blockquote');

function calibrefx_blockquote($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                    ), $atts));

    return $before . '<blockquote>' . do_shortcode($content) . '</blockquote>' . $after;
}

/**
 * ==============================================================
 * Image Section
 * ==============================================================
 */
add_shortcode('img', 'calibrefx_img');

function calibrefx_img($atts, $content = null) {

    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'width' => '',
                'height' => '',
                'title' => '',
                'class' => '',
                    ), $atts));

    return $before . '<img src="' . $content . '" title="' . $title . '" width="' . $width . '" height="' . $height . '" class="' . $class . '"/>' . $after;
}

/**
 * ==============================================================
 * User Section
 * ==============================================================
 */
add_shortcode('user_firstname', 'calibrefx_user_firstname');

function calibrefx_user_firstname($atts, $content = '') {
    global $current_user;
    get_currentuserinfo();

    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                    ), $atts));

    return $before . $current_user->user_firstname . $after;
}

add_shortcode('user_lastname', 'calibrefx_user_lastname');

function calibrefx_user_lastname($atts, $content = '') {
    global $current_user;
    get_currentuserinfo();

    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                    ), $atts));

    return $before . $current_user->user_lastname . $after;
}

add_shortcode('user_email', 'calibrefx_user_email');

function calibrefx_user_email($atts, $content = '') {
    global $current_user;
    get_currentuserinfo();

    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                    ), $atts));

    return $before . $current_user->user_email . $after;
}

/**
 * ==============================================================
 * Buttons
 * ==============================================================
 */
add_shortcode('button', 'calibrefx_button');

function calibrefx_button($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'url' => '',
                'type' => '',
                'color' => '',
                'size' => '',
                'icon' => '',
                    ), $atts));

    $classes = 'button';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($type))
        $classes .= ' ' . $type;
    if (!empty($color))
        $classes .= ' ' . $color;
    if (!empty($size))
        $classes .= ' ' . $size;

    if (!empty($icon)) {
        return $before . '<a href="' . $url . '" class="' . $classes . ' icon"><span class="rightbtn">' . $content . '</span><span class="ico ' . $icon . '"></span></a>' . $after;
    } else {
        return $before . '<a href="' . $url . '" class="' . $classes . '"><span>' . $content . '</span></a>' . $after;
    }
}

/**
 * ==============================================================
 * Tooltip
 * ==============================================================
 */
add_shortcode('tooltip', 'calibrefx_tooltip');

function calibrefx_tooltip($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'color' => '',
                'text' => ''
                    ), $atts));

    $classes = 'ltt-tooltip';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($color))
        $classes .= ' ' . $color;

    return $before . '<span class="' . $classes . '"><span class="tooltip-content"><span class="tooltip-arr"></span>' . $text . '</span>' . $content . '</span>' . $after;
}

/**
 * ==============================================================
 * Dropcap
 * ==============================================================
 */
add_shortcode('dropcap', 'calibrefx_dropcap');

function calibrefx_dropcap($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'color' => '',
                'font' => '',
                'style' => '',
                'size' => ''
                    ), $atts));

    $classes = 'dropcap';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($color))
        $classes .= ' ' . $color;
    if (!empty($font))
        $classes .= ' font-' . $font;
    if (!empty($style))
        $classes .= ' font-' . $style;
    if (!empty($size))
        $classes .= ' size-' . $size;

    return $before . '<span class="' . $classes . '">' . $content . '</span>' . $after;
}

/**
 * ==============================================================
 * List
 * ==============================================================
 */
add_shortcode('list', 'calibrefx_list');

function calibrefx_list($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => ''
                    ), $atts));

    $classes = 'custom';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($style))
        $classes .= ' ' . $style;

    return $before . '<ul class="' . $classes . '">' . $content . '</ul>' . $after;
}

/**
 * ==============================================================
 * Column
 * ==============================================================
 */
add_shortcode('column', 'calibrefx_column');

function calibrefx_column($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => '',
                'align' => '',
                'last' => '',
                    ), $atts));

    $classes = $class;
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($style))
        $classes .= ' ' . $style;
    if (!empty($align))
        $classes .= ' ' . $align;
    if (!empty($last)) {
        if ($last == 'yes') {
            $classes .= ' last';
        }
    }

    return $before . '<div class="' . $classes . '">' . $content . '</div>' . $after;
}

/**
 * ==============================================================
 * Google Maps
 * ==============================================================
 */
 add_shortcode('gmap', 'calibrefx_gmap');
 function calibrefx_gmap($atts, $content = ''){
	extract(shortcode_atts(array(
		'before' => '',
		'after' => '',
		'class' => '',
		'width' => '',
		'height' => '',
		'src' => ''
	), $atts));	
	
	return $before.'<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'&output=embed" class="'.$class.'"></iframe>'.$after;
 }
 
/* tinyMCE class */

/**
 * add_Lizatomic_scbuttons_button
 *  
 * @access public
 */
class calibrefx_add_shortcode_button
{

    var $plugin_name = "calibrefx_shortcode_buttons";

    function calibrefx_add_shortcode_button()
    {        
        add_filter('tiny_mce_version', array(&$this, 'increase_tinymce_version'));        
        add_action('init', array(&$this, 'add_sc_buttons'));
    }

    function add_sc_buttons()
    {
        // len uzivatel s pravom editovat clanky vidi button
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
            return;
        // rich editor
        if (get_user_option('rich_editing') == 'true') {
            // pre wp2.5
            add_filter("mce_external_plugins", array(&$this, "add_calibrefx_scbuttons_plugin"), 5);
            add_filter('mce_buttons_3', array(&$this, 'register_calibrefx_scbuttons_button'), 5);
        }
    }
    
    function register_calibrefx_scbuttons_button($buttons)
    {
        array_push($buttons, "", $this->plugin_name);
        return $buttons;
    }

    function add_calibrefx_scbuttons_plugin($plugin_arr)
    {
        //global $lizatomic_sc;
        $plugin_arr[$this->plugin_name] = CALIBREFX_SHORTCODES_URL . '/assets/admin.shortcode.js';
        return $plugin_arr;
    }
    
    function increase_tinymce_version($version)
    {
        return ++$version;
    }
}

//vytvor instanciu add_Lizatomic_scbuttons_button()
$tinymce_button = new calibrefx_add_shortcode_button();	

