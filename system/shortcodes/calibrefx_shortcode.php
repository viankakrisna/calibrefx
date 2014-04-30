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

global $cfx_shortcode;
 
/* Site URL */
add_shortcode( 'site_url', 'calibrefx_site_url' );

function calibrefx_site_url($atts, $content = null){
    extract(shortcode_atts(array(
                'path' => '',
                'scheme' => null,
                    ), $atts));

    return site_url( $path, $scheme );
}

/* Home URL */
add_shortcode( 'home_url', 'calibrefx_site_url' );

function calibrefx_home_url($atts, $content = null){
    extract(shortcode_atts(array(
                'path' => '',
                'scheme' => null,
                    ), $atts));

    return home_url( $path, $scheme );
}

/**
 * ==============================================================
 * Video Section
 * ==============================================================
 */

/* Youtube */
add_shortcode('youtube', 'calibrefx_youtube');

function calibrefx_youtube($atts, $content = null) {

    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'width' => '',
                'height' => '',
                'title' => '',
                    ), $atts));

    return '<div class="flexible-container youtube"><iframe title="' . $title . '" width="' . $width . '" height="' . $height . '" src="http://www.youtube.com/embed/' . $content . '" frameborder="0" allowfullscreen></iframe></div>';
}

/* Vimeo */
add_shortcode('vimeo', 'calibrefx_vimeo');

function calibrefx_vimeo($atts, $content = null) {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'width' => '',
                'height' => '',
                'title' => '',
                    ), $atts));

    return '<div class="flexible-container vimeo"><iframe title="' . $title . '" width="' . $width . '" height="' . $height . '" src="http://player.vimeo.com/video/' . $content . '" frameborder="0"></iframe></div>';
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_video', CALIBREFX_SHORTCODE_URL . '/form-video.php', 360, 240, __('Video shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/video.png');

/* Youtube Thumbnail */
add_shortcode('youtube_thumbnail', 'calibrefx_youtube_thumbnail');

function calibrefx_youtube_thumbnail($atts, $content = null) {

    extract(shortcode_atts(array(
        'width' => '',
        'height' => '',
        'title' => '',
        'id' => '',
        'class' => 'thumbnail',
        'style' => ''
    ), $atts));

    if(empty($content)) return '<div class="alert alert-error">'.__('Not a valid Youtube video ID. The video cannot be shown.', 'calibrefx').'</div>';

    $url = 'http://www.youtube.com/watch?v='.$content;         

    // get var from v variable
    $video_query = parse_url($url, PHP_URL_QUERY);
    $vars = array();
    parse_str($video_query, $vars);

    // get image url from youtube
    $remote = wp_remote_retrieve_body(wp_remote_request(sprintf("http://gdata.youtube.com/feeds/api/videos/%s?v=2&alt=json", $vars['v']), array('timeout' => 100)));

    $youtube_data = json_decode($remote, true);

    if($youtube_data === NULL) return '<div class="alert alert-error">'.__('The youtube video is currently not available. The video cannot be shown.', 'calibrefx').'</div>';

    $video_title = $youtube_data['entry']['media$group']['media$title']['$t'];
    $video_desc = $youtube_data['entry']['media$group']['media$description']['$t'];

    $title = (!empty($title) ? $title : $video_title);

    $imageurl = $youtube_data['entry']['media$group']['media$thumbnail'][3]['url'];

    if(!empty($height)){
        if($height <= 90){
            $imageurl = $youtube_data['entry']['media$group']['media$thumbnail'][0]['url'];
        }elseif($height <= 180){   
            $imageurl = $youtube_data['entry']['media$group']['media$thumbnail'][1]['url'];
        }elseif($height <= 360){   
            $imageurl = $youtube_data['entry']['media$group']['media$thumbnail'][2]['url'];
        }elseif($height <= 480){   
            $imageurl = $youtube_data['entry']['media$group']['media$thumbnail'][3]['url'];
        }

        $style .= 'height:'.$height.'px;';
    }

    if(!empty($width)){
        $style .= 'width:'.$width.'px;';
    }
    
   
    return '<img class="youtube-thumbnail '.$class.'" id="'.$id.'" style="'.$style.'" src="'.$imageurl.'" alt="'.$title.'" />';
}

/**
 * ==============================================================
 * Typography Section
 * ==============================================================
 */

/* Text */
add_shortcode('text', 'calibrefx_text');

function calibrefx_text($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'color' => '',
                'font' => '',
                'style' => '',
                'weight' => '',
                'type' => 'normal',
                'id' => ''
                    ), $atts));

    $classes = 'text';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($color))
        $classes .= ' ' . $color;
    if (!empty($font))
        $classes .= ' font-' . $font;
    if (!empty($style))
        $classes .= ' font-' . $style;
    if (!empty($weight))
        $classes .= ' font-weight-' . $weight;

    if($type == 'normal')
        $elm = 'span';
    elseif($type == 'paragraph')
        $elm = 'p';
    elseif($type == 'div')
        $elm = 'div';

    $attr = '';
    if(!empty($id)) $attr .= ' id="' . $id . '"';

    return $before . '<'. $elm .' class="' . $classes . '"'.$attr.'>' . do_shortcode($content) . '</' . $elm . '>' . $after;
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_text', CALIBREFX_SHORTCODE_URL . '/form-texts.php', 360, 360, __('Text shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/text.png');

/* Bold */
add_shortcode('bold', 'calibrefx_bold');

function calibrefx_bold($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                    ), $atts));

    return $before . '<strong>' . do_shortcode($content) . '</strong>' . $after;
}

/* Italic */
add_shortcode('italic', 'calibrefx_italic');

function calibrefx_italic($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                    ), $atts));

    return $before . '<i>' . do_shortcode($content) . '</i>' . $after;
}

/* Em */
add_shortcode('em', 'calibrefx_em');

function calibrefx_em($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                    ), $atts));

    return $before . '<em>' . do_shortcode($content) . '</em>' . $after;
}

/* Cite */
add_shortcode('cite', 'calibrefx_cite');

function calibrefx_cite($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                    ), $atts));

    return $before . '<cite>' . do_shortcode($content) . '</cite>' . $after;
}

/* Blockquote */
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
 * Icon Section
 * ==============================================================
 */
add_shortcode('i', 'calibrefx_icon');

function calibrefx_icon($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
				'name' => '',
				'class' => '',
				'style' => '',
                    ), $atts));
					
	$attr = '';
	$classes = 'glyphicon';
	
	if(!empty($name)) $classes .= ' '.$name;
	if(!empty($class)) $classes .= ' '.$class;
	
	if(!empty($style)) $attr .= ' style="'.$style.'"';

    return $before . '<i class="'.$classes.'"'.$attr.'></i>' . $after;
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
                'alt' => '',
                'id' => '',
                    ), $atts));

    $attr = '';
    if(!empty($width)) $attr .= ' width="' . $width . '"';
    if(!empty($height)) $attr .= ' height="' . $height . '"';
    if(!empty($title)) $attr .= ' title="' . $title . '"';
    if(!empty($class)) $attr .= ' width="' . $class . '"';
    if(!empty($alt)) $attr .= ' alt="' . $alt . '"';
    if(!empty($id)) $attr .= ' id="' . $id . '"';

    return $before . '<img src="' . do_shortcode($content) . '"'.$attr.' />' . $after;
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_image', CALIBREFX_SHORTCODE_URL . '/form-image.php', 360, 280, __('Image shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/image.png');

/**
 * ==============================================================
 * User Section
 * ==============================================================
 */

/* Loggedin User First Name */
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

/* Loggedin User Last Name */
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

/* Loggedin User Email Address */
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
                'style' => '',
                'active' => '',
                'disabled' => '',
                'block' => '',
                'id' => '',
                'url' => '#',
                'type' => '',
                'size' => '',
                'rel' => 'nofollow'
                    ), $atts));

    $classes = 'btn';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($type))
        $classes .= ' btn-' . $type;
    if (!empty($size))
        $classes .= ' btn-' . $size;
    if (!empty($active))
        $classes .= ' active';
    if (!empty($disabled))
        $classes .= ' disabled';
    if (!empty($block))
        $classes .= ' btn-block';

    $attr = '';
    if (!empty($style))
        $attr .= ' style="' . $style . '"';
    if (!empty($rel))
        $attr .= ' rel="' . $rel . '"';
    if (!empty($id))
        $attr .= ' id="' . $id . '"';

    return $before . '<a href="' . $url . '" class="' . $classes . '"'.$attr.'>' . do_shortcode($content) . '</a>' . $after;
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_buttons', CALIBREFX_SHORTCODE_URL . '/form-buttons.php', 420, 540, __('Button shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/buttons.png');

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
        'id' => '',
        'position' => 'top',
        'text' => '',
        'url' => '#'
    ), $atts));

    $classes  = ' class="'.$class.'"';
    $ids = ' id="'.$id.'"';

    return $before.'<a href="'.$url.'" data-toggle="tooltip" data-placement="'.$position.'" title="'.$text.'"'.$classes.$ids.'>'.advance_shortcode_unautop($content).'</a>'.$after;
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_tooltips', CALIBREFX_SHORTCODE_URL . '/form-tooltips.php', 360, 380, __('Tooltips shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/tooltips.png');

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

    return $before . '<span class="' . $classes . '">' . do_shortcode($content) . '</span>' . $after;
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_dropcaps', CALIBREFX_SHORTCODE_URL . '/form-dropcaps.php', 360, 280, __('Dropcaps shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/dropcaps.png');

/**
 * ==============================================================
 * List
 * ==============================================================
 */

/* Main List Element */
add_shortcode('list', 'calibrefx_list');

function calibrefx_list($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'style' => ''
                    ), $atts));

    $classes = 'custom-list';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($style))
        $classes .= ' ' . $style;

    return $before . '<div class="' . $classes . '">' . do_shortcode($content) . '</div>' . $after;
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_list', CALIBREFX_SHORTCODE_URL . '/form-list.php', 360, 200, __('List shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/list.png');

/* List Element */
add_shortcode('li', 'calibrefx_list_item');

function calibrefx_list_item($atts, $content = '') {
    extract(shortcode_atts(array(
                'class' => ''
                    ), $atts));

    return '<li class="' . $class . '">' . do_shortcode($content) . '</li>';
}

/**
 * ==============================================================
 * Row
 * ==============================================================
 */

add_shortcode('row', 'calibrefx_row');

function calibrefx_row($atts, $content = '') {
    extract(shortcode_atts(array(
                'class' => '',
                'style' => '',
                'id' => '',
                    ), $atts));

    $attr = '';
    $classes = calibrefx_row_class();
    if (!empty($class)) $classes .= ' ' . $class;
    if (!empty($style)) $attr .= ' style="' . $style . '"';
    if (!empty($id)) $attr .= ' id="' . $id . '"';

    return '<div class="' . $classes . '"'.$attr.'>' . do_shortcode(advance_shortcode_unautop($content)) . '</div>';
}

/**
 * ==============================================================
 * Column
 * ==============================================================
 */
add_shortcode('column', 'calibrefx_column');

function calibrefx_column($atts, $content = '') {
    extract(shortcode_atts(array(
                'class' => '',
                'cols' => '',
                'style' => '',
                'align' => '',
                'last' => 'no',
                'first' => 'no',
                'id' => ''
                    ), $atts));

    $before = '';
    $after = '';
    $classes = '';
    $attr = '';

    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($cols))
        $classes .= ' ' . $cols;
    if (!empty($align))
        $classes .= ' ' . $align;

    if (!empty($first)) {
        if ($first == 'yes') {
            $before = '<div class="'.calibrefx_row_class().'">';
        }
    }
    if (!empty($last)) {
        if ($last == 'yes') {
            $after = '</div>';
        }
    }

    if (!empty($style)) $attr .= ' style="' . $style . '"';
    if (!empty($id)) $attr .= ' id="' . $id . '"';

    return $before . '<div class="' . $classes . '"'.$attr.'>' . do_shortcode(advance_shortcode_unautop($content)) . '</div>' . $after;
}

/* One Half */
add_shortcode('one_half', 'calibrefx_one_half_column');

function calibrefx_one_half_column($atts, $content = '') {
    extract(shortcode_atts(array(
                'class' => '',
                'style' => '',
                'align' => '',
                'last' => 'no',
                'first' => 'no',
                'id' => ''
                    ), $atts));

    $before = '';
    $after = '';
    $classes = '';
    $attr = '';

    $classes .= 'col-lg-6 col-md-6 col-sm-12 col-xs-12';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($align))
        $classes .= ' ' . $align;

    if (!empty($first)) {
        if ($first == 'yes') {
            $before = '<div class="'.calibrefx_row_class().'">';
        }
    }
    if (!empty($last)) {
        if ($last == 'yes') {
            $after = '</div>';
        }
    }

    if (!empty($style)) $attr .= ' style="' . $style . '"';
    if (!empty($id)) $attr .= ' id="' . $id . '"';

    return $before . '<div class="' . $classes . '"'.$attr.'>' . do_shortcode(advance_shortcode_unautop($content)) . '</div>' . $after;
}

/* One Third */
add_shortcode('one_third', 'calibrefx_one_third_column');

function calibrefx_one_third_column($atts, $content = '') {
    extract(shortcode_atts(array(
                'class' => '',
                'style' => '',
                'align' => '',
                'last' => 'no',
                'first' => 'no',
                'id' => ''
                    ), $atts));

    $before = '';
    $after = '';
    $classes = '';
    $attr = '';

    $classes .= 'col-lg-4 col-md-4 col-sm-12 col-xs-12';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($align))
        $classes .= ' ' . $align;

    if (!empty($first)) {
        if ($first == 'yes') {
            $before = '<div class="'.calibrefx_row_class().'">';
        }
    }
    if (!empty($last)) {
        if ($last == 'yes') {
            $after = '</div>';
        }
    }

    if (!empty($style)) $attr .= ' style="' . $style . '"';
    if (!empty($id)) $attr .= ' id="' . $id . '"';

    return $before . '<div class="' . $classes . '"'.$attr.'>' . do_shortcode(advance_shortcode_unautop($content)) . '</div>' . $after;
}

/* Two Third */
add_shortcode('two_third', 'calibrefx_two_third_column');

function calibrefx_two_third_column($atts, $content = '') {
    extract(shortcode_atts(array(
                'class' => '',
                'style' => '',
                'align' => '',
                'last' => 'no',
                'first' => 'no',
                'id' => ''
                    ), $atts));

    $before = '';
    $after = '';
    $classes = '';
    $attr = '';

    $classes .= ' col-lg-8 col-md-8 col-sm-12 col-xs-12';
    if (!empty($class))
        $classes .= ' ' . $class; 
    if (!empty($align))
        $classes .= ' ' . $align;

    if (!empty($first)) {
        if ($first == 'yes') {
            $before = '<div class="'.calibrefx_row_class().'">';
        }
    }
    if (!empty($last)) {
        if ($last == 'yes') {
            $after = '</div>';
        }
    }

    if (!empty($style)) $attr .= ' style="' . $style . '"';
    if (!empty($id)) $attr .= ' id="' . $id . '"';

    return $before . '<div class="' . $classes . '"'.$attr.'>' . do_shortcode(advance_shortcode_unautop($content)) . '</div>' . $after;
}

/* One Fourth */
add_shortcode('one_fourth', 'calibrefx_one_fourth_column');

function calibrefx_one_fourth_column($atts, $content = '') {
    extract(shortcode_atts(array(
                'class' => '',
                'style' => '',
                'align' => '',
                'last' => 'no',
                'first' => 'no',
                'id' => ''
                    ), $atts));

    $before = '';
    $after = '';
    $classes = '';
    $attr = '';

    $classes .= ' col-lg-3 col-md-3 col-sm-12 col-xs-12';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($align))
        $classes .= ' ' . $align;

    if (!empty($first)) {
        if ($first == 'yes') {
            $before = '<div class="'.calibrefx_row_class().'">';
        }
    }
    if (!empty($last)) {
        if ($last == 'yes') {
            $after = '</div>';
        }
    }

    if (!empty($style)) $attr .= ' style="' . $style . '"';
    if (!empty($id)) $attr .= ' id="' . $id . '"';

    return $before . '<div class="' . $classes . '"'.$attr.'>' . do_shortcode(advance_shortcode_unautop($content)) . '</div>' . $after;
}

/* Three Fourth */
add_shortcode('three_fourth', 'calibrefx_three_fourth_column');

function calibrefx_three_fourth_column($atts, $content = '') {
    extract(shortcode_atts(array(
                'class' => '',
                'style' => '',
                'align' => '',
                'last' => 'no',
                'first' => 'no',
                'id' => ''
                    ), $atts));

    $before = '';
    $after = '';
    $classes = '';
    $attr = '';

    $classes .= ' col-lg-9 col-md-9 col-sm-12 col-xs-12';
    if (!empty($class))
        $classes .= ' ' . $class;   
    if (!empty($align))
        $classes .= ' ' . $align;

    if (!empty($first)) {
        if ($first == 'yes') {
            $before = '<div class="'.calibrefx_row_class().'">';
        }
    }
    if (!empty($last)) {
        if ($last == 'yes') {
            $after = '</div>';
        }
    }

    if (!empty($style)) $attr .= ' style="' . $style . '"';
    if (!empty($id)) $attr .= ' id="' . $id . '"';

    return $before . '<div class="' . $classes . '"'.$attr.'>' . do_shortcode(advance_shortcode_unautop($content)) . '</div>' . $after;
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_column', CALIBREFX_SHORTCODE_URL . '/form-cols.php', 360, 220, __('Column shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/cols.png');

add_shortcode("tbel", "calibrefx_tbel");
function calibrefx_tbel( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "id" => "",
        "class" => "",
    ), $atts));
    return "<div id='$id' class='$class'>".do_shortcode(advance_shortcode_unautop($content))."</div>";
}

add_shortcode("tbcontainer", "calibrefx_tbcontainer");
function calibrefx_tbcontainer( $atts, $content = null ) {
    return "<div class='container'>".do_shortcode(advance_shortcode_unautop($content))."</div>";
}

add_shortcode("tbrow", "calibrefx_tbrow");
function calibrefx_tbrow( $atts, $content = null ) {
    return "<div class='row'>".do_shortcode(advance_shortcode_unautop($content))."</div>";
}

add_shortcode("tbcol", "calibrefx_tbcol");
function calibrefx_tbcol( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "col" => "1",
        "offset" => "",
    ), $atts));

    $offset_class = "";
    if($offset != ""){
        $offset_class = " ". col_offset_class(explode(',',$offset));
    }

    return "<div class='". col_class(explode(',',$col)) ."$offset_class'>".do_shortcode(advance_shortcode_unautop($content))."</div>";
}

/**
 * ==============================================================
 * Separator
 * ==============================================================
 */

add_shortcode('separator', 'calibrefx_separator');

function calibrefx_separator($atts, $content = '') {
    extract(shortcode_atts(array(
                'class' => '',
                'style' => '',
                    ), $atts));

    $classes = " separator ";
    if (!empty($class))
        $classes .= ' '.$class;

    $attr = '';
    if (!empty($style)) $attr .= ' style="' . $style . '"';
    return '<div class="' . $classes . '" style="'.$style.'">' . do_shortcode(advance_shortcode_unautop($content)) . '</div>';
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_separator', CALIBREFX_SHORTCODE_URL . '/form-separator.php', 360, 200, __('Separator shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/separator.png');

add_shortcode('clear', 'calibrefx_clear');
function calibrefx_clear() {
    return '<div class="clearfix"></div>';
}

/**
 * ==============================================================
 * HEADLINE
 * ==============================================================
 */

add_shortcode('headline', 'calibrefx_headline');

function calibrefx_headline($atts, $content = '') {
    extract(shortcode_atts(array(
        'class' => '',
        'id' => '',
        'style' => '',
        'top_separator' => 0,
        'bottom_separator' => 0,
    ), $atts));

    $attr = '';
    if (!empty($id)) $attr .= ' id="' . $id . '"';
    if (!empty($style)) $attr .= ' style="' . $style . '"';

    $classes = 'headline';
    if (!empty($class)) $classes .= ' ' . $class;

    $html = '';
    $html .= '<div class="'.$class.'"'.$attr.'>';
    if($top_separator) $html .= '<div class="headline-separator top"></div>';
    $html .= '<div class="headline-content">';
    $html .= advance_shortcode_unautop($content);
    $html .= '</div>';
    if($bottom_separator) $html .= '<div class="headline-separator bottom"></div>';
    $html .= '</div>';

    return $html;
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_headline', CALIBREFX_SHORTCODE_URL . '/form-headline.php', 360, 200, __('Headline shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/headline.png');

/**
 * ==============================================================
 * SOCIAL LINK
 * ==============================================================
 */

add_shortcode( 'gplus_url', 'calibrefx_gplus_url' );
function calibrefx_gplus_url(){
    $gplus_page = calibrefx_get_option('gplus_page');
    
    return $gplus_page;  
}

add_shortcode( 'facebook_url', 'calibrefx_facebook_url' );
function calibrefx_facebook_url(){
    $facebook_fanpage = calibrefx_get_option('facebook_fanpage');
    
    return $facebook_fanpage;  
}

add_shortcode( 'twitter_url', 'calibrefx_twitter_url' );
function calibrefx_twitter_url(){
    $twitter_profile = calibrefx_get_option('twitter_profile');
    
    return $twitter_profile;  
}

add_shortcode( 'youtube_url', 'calibrefx_youtube_url' );
function calibrefx_youtube_url(){
    $youtube_channel = calibrefx_get_option('youtube_channel');
    
    return $youtube_channel;  
}

add_shortcode( 'linkedin_url', 'calibrefx_linkedin_url' );
function calibrefx_linkedin_url(){
    $linkedin_profile = calibrefx_get_option('linkedin_profile');
    
    return $linkedin_profile;  
}

add_shortcode( 'pinterest_url', 'calibrefx_pinterest_url' );
function calibrefx_pinterest_url(){
    $pinterest_profile = calibrefx_get_option('pinterest_profile');
    
    return $pinterest_profile;  
}

add_shortcode( 'feed_url', 'calibrefx_feed_url' );
function calibrefx_feed_url(){
    $feed_uri = calibrefx_get_option('feed_uri');
    
    return $feed_uri;  
}

/**
 * ==============================================================
 * Google Maps
 * ==============================================================
 */
add_shortcode('gmap', 'calibrefx_gmap');

function calibrefx_gmap($atts, $content = '') {
    extract(shortcode_atts(array(
        'before' => '',
        'after' => '',
        'class' => ''
    ), $atts));

    return $before . '<div class="flexible-container gmaps">' . $content . '</div>' . $after;
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_gmaps', CALIBREFX_SHORTCODE_URL . '/form-gmaps.php', 470, 260, __('Google map shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/googlemaps.png');

/**
 * ==============================================================
 * Slider
 * ==============================================================
 */
add_shortcode('slider', 'calibrefx_slider');

function calibrefx_slider($atts, $content = '') {
    extract(shortcode_atts(array(
        'before' => '',
        'after' => '',
        'id' => '',
        'class' => '',
        'interval' => '3000',
        'speed' => 800,
        'fx' => 'fade',
        'pager' => 0,
        'next_prev' => 0,
        'slide_elm' => '> div',
        'auto_height' => 0,
        'height' => '',
        'width' => '',
		'caption' => 0,
        'carousel_visible' => '',
        'carousel_fluid' => '',
        'wrap' => '',
		'attr' => '',
        'loader' => 'wait'
    ), $atts));

    if(!empty($class)) $class = ' '.$class;
    $pager_class = '';$style='';
    if($pager || $next_prev){
        // Create custom ID for pager
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < 8; $i++) {
            $pager_class .= $chars[rand(0, $size - 1)];
        }
    }

    $style_item = '';
    if(!empty($width)) $style_item .= 'width:'.$width.';';
    if(!empty($height)) $style_item .= 'height:'.$height.';';
    
    if(!empty($width) || !empty($height)) $style .= ' style="'.$style_item.'"';

    $data_cycle = '';
    $data_cycle .= ' data-cycle-fx="'.$fx.'"';
    $data_cycle .= ' data-cycle-timeout="'.$interval.'"';
    if(!empty($speed)) $data_cycle .= ' data-cycle-speed="'.$speed.'"';
    if(!empty($slide_elm)){
		if($caption){
			$data_cycle .= ' data-cycle-slides="'.$slide_elm.':not(.cycle-overlay)"';
			$data_cycle .= ' data-cycle-overlay-fx-sel="div.cycle-overlay"';
		}else{
			$data_cycle .= ' data-cycle-slides="'.$slide_elm.'"';
		}
	}
    if($pager) $data_cycle .= ' data-cycle-pager="#'.$pager_class.'" data-cycle-pager-template=\'<a href="#" class="slider-pager-item">{{slideNum}}</a>\'';
    if($next_prev) $data_cycle .= ' data-cycle-prev="#slider-prev-'.$pager_class.'" data-cycle-next="#slider-next-'.$pager_class.'"';
    if($auto_height !== 0) $data_cycle .= ' data-cycle-auto-height="'.$auto_height.'"';
	if($caption) $data_cycle .= ' data-cycle-caption-plugin=caption2';
    if(!empty($carousel_visible)) $data_cycle .= ' data-cycle-carousel-visible="'.$carousel_visible.'"';
    if(!empty($carousel_fluid)) $data_cycle .= ' data-cycle-carousel-fluid="'.$carousel_fluid.'"';
    if(!empty($wrap)) $data_cycle .= ' data-allow-wrap="'.$wrap.'"';
    if(!empty($loader)) $data_cycle .= ' data-allow-loader="'.$loader.'"';
	
    $data_cycle .= ' data-cycle-pause-on-hover="true"';

    $attr = '';
    if(!empty($id)) $attr .= ' id="'.$id.'"';

    $html = '';
    $html .= '<div class="slider-container'.$class.'"'.$attr.'>';
    $html .= '<div class="slider-wrapper">';
    $html .= '<div class="slider cycle-slideshow"'.$data_cycle.$style.'>';
	if($caption) $html .= '<div class="cycle-overlay"></div>';
    $html .= advance_shortcode_unautop($content);
    $html .= '</div><!-- end .slider -->';
    if($pager) $html  .= '<div id="'.$pager_class.'" class="slider-pager"></div><!-- end .slider-pager -->';
    if($next_prev) $html  .= '<a href="#" class="slider-nav slider-prev" id="slider-prev-'.$pager_class.'">&laquo; prev</a><a href="#" class="slider-nav slider-next" id="slider-next-'.$pager_class.'">next &raquo;</a>';
    $html .= '</div><!-- end .slider-wrapper -->';
    $html .= '</div><!-- end .slider-container -->';

    return $before.$html.$after;
}

add_shortcode('slider_item', 'calibrefx_slider_item');

function calibrefx_slider_item($atts, $content = '') {
    extract(shortcode_atts(array(
        'before' => '',
        'after' => '',
        'class' => '',
        'src' => '',
        'url' => '',
        'title' => '',
		'desc' => ''
    ), $atts));
	
	if(!empty($url) && $url != '#'){
		return '<div class="item ' . $class . '" data-cycle-title=\'<a href="'.$url.'">'.$title.'</a>\' data-cycle-desc="'.$desc.'">' . $before . '<a href="'.$url.'" title="'.$title.'"><img src="' . $src . '" alt="'.$title.'" /></a>'  . $after . '</div>';
	}else{
		return '<div class="item ' . $class . '" data-cycle-title="'.$title.'" data-cycle-desc="'.$desc.'">' . $before . '<img src="' . $src . '" alt="'.$title.'" />'  . $after . '</div>';
	}
}

add_shortcode('slider_caption', 'calibrefx_slider_caption');

function calibrefx_slider_caption($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                    ), $atts));

    return '<div class="carousel-caption ' . $class . '">' . $before . advance_shortcode_unautop($content) . $after . '</div>';
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_slider', CALIBREFX_SHORTCODE_URL . '/form-slider.php', 400, 460, __('Slider shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/nivo.png');

/**
 * ==============================================================
 * Tabbed Content
 * ==============================================================
 */
add_shortcode('tabs', 'calibrefx_tabs');

function calibrefx_tabs($atts, $content = null) {
    global $tab_elm_id;

    extract(shortcode_atts(array(
        'before' => '',
        'after' => '',
        'id' => 'entry-tab',
        'tab' => 'tab1|tab2|tab3',
        'class' => 'entry-tab',
        'headings' => 'Tab1|Tab2|Tab3'), 
    $atts));

    $tabs_headings = explode('|', $headings);
    $tabs_elements = explode('|', $tab);

    $classes = "";$ids="";
    if(!empty($class)) $classes .= ' '.$class;
    if(!empty($id)){ 
        $ids .= ' id="'.$id.'"';
    }else{
        // Create custom ID for tabs
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < 8; $i++) {
            $id .= $chars[rand(0, $size - 1)];
        }

        $ids .= ' id="'.$id.'"';
    }

    $tab_elm_id = $id;

    $output = '<ul class="nav nav-tabs'.$classes.'"'.$ids.'>';

    $i = 0;
    //iterate through tabs headings 
    foreach ($tabs_headings as $tab_heading) {
        $tab_id = '#'.$id.'-'.$tabs_elements[$i];
        $output .= '<li>';
        $output .= '<a href="'.$tab_id.'" data-toggle="tab">';
        $output .= $tab_heading;
        $output .= '</a>';
        $output .= '</li>';
        $i++;
    }

    $output .= '</ul>';

    $output .= '<div class="tab-content">'.advance_shortcode_unautop($content).'</div>';
    $output .= '<script type="text/javascript">jQuery(function(){ jQuery("#'.$id.' a:first").tab("show"); });</script>';

    return $before.$output.$after;
}

// slides
add_shortcode('tab', 'calibrefx_tabs_item');

function calibrefx_tabs_item($atts, $content = null) {
    global $tab_elm_id;

    extract(shortcode_atts(array('id' => ''),$atts));

    return '<div class="tab-pane" id="'.$tab_elm_id.'-'.$id.'">'.advance_shortcode_unautop($content).'</div>';
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_tabs', CALIBREFX_SHORTCODE_URL . '/form-tabs.php', 360, 340, __('Tabs shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/tabs.png');

/**
 * ==============================================================
 * Togglebox
 * ==============================================================
 */
add_shortcode('togglebox', 'calibrefx_togglebox');

function calibrefx_togglebox($atts, $content = null) {
    global $togglebox_id;

    extract(shortcode_atts(array(
        'before' => '',
        'after' => '',
        'id' => '',
        'class' => '',
    ), $atts));

    if(empty($id)){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < 8; $i++) {
            $id .= $chars[rand(0, $size - 1)];
        }
    }

    $togglebox_id = $id;

    if(!empty($class)) $class = ' '.$class;

    return $before . '<div class="panel-group'.$class.'" id="'.$id.'">' . advance_shortcode_unautop($content) . '</div>' . $after;
}

add_shortcode('togglebox_item', 'calibrefx_togglebox_item');
function calibrefx_togglebox_item($atts, $content = null){
    global $togglebox_id;

    extract(shortcode_atts(array(
        'title' => '',
        'id' => '',
        'in' => 0
    ), $atts));

    $class = '';
    if($in) $class = ' in';

    $output = '<div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#'.$togglebox_id.'" href="#'.$togglebox_id.'-'.$id.'">
                    '.$title.'
                </a>
            </h4>
        </div>
        <div id="'.$togglebox_id.'-'.$id.'" class="panel-collapse collapse'.$class.'">
            <div class="panel-body">
                '.advance_shortcode_unautop($content).'
            </div>
        </div>
    </div>';

    return $output;
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_togglebox', CALIBREFX_SHORTCODE_URL . '/form-togglebox.php', 360, 200, __('Togglebox shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/togglebox.png');

/**
 * ==============================================================
 * alert Shortcode
 * ==============================================================
 */

add_shortcode('alert', 'calibrefx_alert');
function calibrefx_alert($atts, $content = null){
    extract(shortcode_atts(array(        
        'close_button' => 1,
        'class' => '',
        'type' => '',
        'option' => '',
        'style' => '',
        'id' => ''
    ), $atts));
    
    $output = '';

    $classes = 'alert alert-dismissable';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($type))
        $classes .= ' alert-' . $type;
    if (!empty($option))
        $classes .= ' alert-' . $option;

    $attr = '';
    if (!empty($style))
        $attr .= ' style="' . $style . '"';
    if (!empty($id))
        $attr .= ' id="' . $id . '"';

    $output .= '<div class="' . $classes . '"' . $attr . '>';

    if($close_button)
        $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';

    $output .= do_shortcode($content);
              
    $output .= '</div>';

    return $output;
}

/**
 * ==============================================================
 * bar Shortcode
 * ==============================================================
 */

add_shortcode('bar', 'calibrefx_bar');
function calibrefx_bar($atts, $content = null){
    extract(shortcode_atts(array(        
        'active' => 0,
        'class' => '',
        'option' => '',
        'style' => '',
        'id' => '',
    ), $atts));

    $output = '';

    $classes = 'progress';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($option))
        $classes .= ' progress-' . $option;
    if (!empty($active) && $active == '1')
        $classes .= ' active';

    $attr = '';
    if (!empty($style))
        $attr .= ' style="' . $style . '"';
    if (!empty($id))
        $attr .= ' id="' . $id . '"';

    $output .= '<div class="'. $classes .'"' . $attr . '>';    

    $output .= do_shortcode( advance_shortcode_unautop($content) );
              
    $output .= '</div>';

    return $output;
}

/**
 * ==============================================================
 * bar item Shortcode
 * ==============================================================
 */

add_shortcode('bar_item', 'cronos_bar_item');
function cronos_bar_item($atts, $content = null){
    extract(shortcode_atts(array(        
        'length' => '10%',
        'title' => '',
        'class' => '',
        'type' => '',
        'style' => '',
    ), $atts));

    $output = '';

    $classes = 'progress-bar';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($type))
        $classes .= ' progress-bar-' . $type;

    $styles = '';
    if (!empty($length))
        $styles .= 'width:' . $length . ';';
    if (!empty($style))
        $styles .= $style;

    $output .= '<div class="'. $classes .'" style="'. $styles .'">'; 
    $output .= $title;          
    $output .= '</div>';

    return $output;
}

/**
 * ==============================================================
 * Social Icon Shortcode
 * ==============================================================
 */
add_shortcode('digg', 'calibrefx_digg');

function calibrefx_digg($atts, $content = null) {
    $output = '<span class="social-bookmark digg-button"><a class="DiggThisButton DiggMedium"></a></span>';

    wp_enqueue_script( 'digg-button-script', 'http://widgets.digg.com/buttons.js', '', false, true );

    return $output;
}

add_shortcode('stumble', 'calibrefx_stumble');

function calibrefx_stumble($atts, $content = null) {
    $output = '<span class="social-bookmark stumbleupon-badge"><su:badge layout="5"></su:badge></span>';

    wp_enqueue_script( 'stumbleupon-badge-script', 'http://platform.stumbleupon.com/1/widgets.js', '', false, true );

    return $output;
}

add_shortcode('fblike', 'calibrefx_fblike');

function calibrefx_fblike($atts, $content = null) {
    extract(shortcode_atts(array(
        'href' => '',
        'send' => 'false',
        'width' => '450',
        'faces' => 'false',
        'layout' => 'box_count',
        'color' => '',
        'action' => '',
    ), $atts));

    $attr = '';

    if(!empty($href)) $attr .=' data-href="'.$href.'"';
    else $attr .=' data-href="'.get_permalink().'"';

    $attr .=' data-send="'.$send.'"';
    $attr .=' data-width="'.$width.'"';
    $attr .=' data-show-faces="'.$faces.'"';

    if(!empty($layout)) $attr .=' data-layout="'.$layout.'"';
    if(!empty($color)) $attr .=' data-colorscheme="'.$color.'"';
    if(!empty($action)) $attr .=' data-action="'.$action.'"';

    $output = '<span class="social-bookmark facebook-like"><span class="fb-like"'.$attr.'></span></span>';

    return $output;
}

add_shortcode('tweet', 'calibrefx_tweet');
function calibrefx_tweet($atts, $content = null) {
    global $post;

    extract(shortcode_atts(array(
        'url' => get_permalink(),
        'count' => 'vertical',
        'size' => 'medium',
        'text' => '',
		'related' => '',
		'via' => '',
		'lang' => '',
		'hashtags' => '',
		'dnt' => ''
    ), $atts));
    
    $attr = '';

    if(!empty($url)) $attr .=' data-url="'.$url.'"';
    if(!empty($count)) $attr .=' data-count="'.$count.'"';
    if(!empty($size)) $attr .=' data-size="'.$size.'"';
    if(!empty($text)) $attr .= ' data-text="'.$text.'"';
	if(!empty($related)) $attr .=' data-related="'.$related.'"';
    if(!empty($via)) $attr .=' data-via="'.$via.'"';
    if(!empty($lang)) $attr .=' data-lang="'.$lang.'"';
    if(!empty($hashtags)) $attr .= ' data-hashtags="'.$hashtags.'"';
	if(!empty($dnt)) $attr .= ' data-dnt="'.$dnt.'"';

    $output = '<span class="social-bookmark tweet-share"><a href="https://twitter.com/share" class="twitter-share-button"'.$attr.'>Tweet</a></span>';

    return $output;
}

add_shortcode('gplus', 'calibrefx_gplus');

function calibrefx_gplus($atts, $content = null) {
    extract(shortcode_atts(array(
        'width' => 300,
        'size' => 'tall',
        'annotation' => 'bubble',
        'url' => get_permalink(),
    ), $atts));
    
    $attr = '';

    if(!empty($width)) $attr .=' data-width="'.$width.'"';
    if(!empty($url)) $attr .=' data-href="'.$url.'"';
    if(!empty($size)) $attr .=' data-size="'.$size.'"';
    if(!empty($annotation)) $attr .=' data-annotation="'.$annotation.'"';

    $output = '<span class="social-bookmark gplus-button"><span class="g-plusone"'.$attr.'></span></span>';

    wp_enqueue_script( 'calibrefx-gplus-widget', 'https://apis.google.com/js/plusone.js', array(), false, true);

    return $output;
}

add_shortcode('pinterest', 'calibrefx_pinterest');
function calibrefx_pinterest($atts, $content = null) {
    global $post;

    extract(shortcode_atts(array(
        'count' => 'above',
        'url' => get_permalink(),
        'media' => '',
    ), $atts));

    if(empty($media)){
        $image_id = get_post_thumbnail_id( $post->ID );

        $img_url = calibrefx_get_image(array('format' => 'url', 'id' => $image_id));
        if(!empty($img_url)) $media = $img_url;
    }

    $output = '<span class="social-bookmark pinterest-button"><a data-pin-config="'.$count.'" href="http://pinterest.com/pin/create/button/?url='.urlencode($url).'&media='.urlencode($media).'&description='.urlencode($content).'" data-pin-do="buttonPin" ><img src="http://assets.pinterest.com/images/pidgets/pin_it_button.png" /></a></span>';

    wp_enqueue_script( 'calibrefx-pinterest-widget', 'http://assets.pinterest.com/js/pinit.js', array(), false, true);

    return $output;
}

add_shortcode('linkedin', 'calibrefx_linkedin');

function calibrefx_linkedin($atts, $content = null){
    global $post;

    extract(shortcode_atts(array(
        'counter' => 'right',
        'url' => get_permalink()
    ), $atts));

	$attr = '';
	
    if(!empty($width)) $attr .=' data-counter="'.$counter.'"';
    if(!empty($url)) $attr .=' data-url="'.$url.'"';

    $output = '<span class="social-bookmark linkedin-button"><script type="IN/Share"'.$attr.'></script></span>';

	wp_enqueue_script( 'calibrefx-linkedin-widget', 'http://platform.linkedin.com/in.js', array(), false, true);
	
    return $output;
}


add_shortcode('feedburner', 'calibrefx_feedburner');

function calibrefx_feedburner($atts, $content = null) {
    $calibrefx_feedburner = get_option('calibrefx_feedburner');
    extract(shortcode_atts(array(
                "name" => 'name'
                    ), $atts));
    if ($calibrefx_feedburner)
        $output = "<a href='http://feeds.feedburner.com/{$calibrefx_feedburner}'><img src='http://feeds.feedburner.com/~fc/{$calibrefx_feedburner}?bg=99CCFF&amp;fg=444444&amp;anim=0' height='26' width='88' style='border:0' alt='' />
</a>";
    return $output;
}

add_shortcode('facebook_comment', 'fb_comment_box');

function fb_comment_box($atts, $content = null) {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'width' => 470,
                'numberpost' => 10,
                'url' => get_current_url(),
                    ), $atts));
    $output = '<div class="fb-comments" data-href="'.$url.'" data-width="'.$width.'" data-num-posts="'.$numberpost.'"></div>';

    return $before . $output . $after;
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_social', CALIBREFX_SHORTCODE_URL . '/form-social.php', 360, 200, __('Social shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/social.png');

/**
 * ==============================================================
 * Post
 * ==============================================================
 */

add_shortcode('post', 'calibrefx_post_item');

function calibrefx_post_item($atts, $content = null) {
    extract(shortcode_atts(array(
        "post_type" => 'post',
        "post_id" => '',
        "limit" => 0,
        "limit_text" => 'Read More',
        "show_title" => 1,
        "is_title_link" => 0,
        "show_featured_image" => 0,
        "before" => '',
        "after" => '',
        "class" => '',
        "id" => '',
        "style" => '',
    ), $atts)); 

    if(empty($post_id)) return;

    $args = array();

    if($post_type != 'post'){
        $args['post_type'] = $post_type;

        if(!empty($post_id)){
            $args['page_id'] = $post_id;
        }
    }else{
        if(!empty($post_id)){
            $args['p'] = $post_id;
        }
    }

    $args['posts_per_page'] = 1;

    $query = new WP_Query($args);

    $html = '';

    if($query->have_posts()) :
        $post_class ='';
        foreach(get_post_class() as $class_item => $val){
            $post_class .= ' '.$val;
        }

        $html .= '<div class="post-item'.$post_class.' '.$class.'">';

        while($query->have_posts()) : $query->the_post();
            if($show_title){
                if($is_title_link){
                    $html .= '<h2 class="post-item-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
                }else{
                    $html .= '<h2 class="post-item-title">'.get_the_title().'</h2>';
                }
            } 

            if($show_featured_image){
                $post_img = calibrefx_get_image(array('format' => 'html', 'size' => ''));

                $html .= $post_img;
            }

            if($limit){
                $html .= get_the_content_limit($limit, $limit_text);
            }else{
                $html .= wpautop( get_the_content(), true );
            }
        endwhile;

        $html .= '</div><!-- end .post-item -->';
    endif;

    wp_reset_query();
    wp_reset_postdata();
    //debug_var($query);

    return do_shortcode( $html );
}

/**
 * ==============================================================
 * Contact Form
 * ==============================================================
 */

add_shortcode('contactform', 'calibrefx_contact_form');

function calibrefx_contact_form($atts, $content = null) {
    global $calibrefx, $post;
    extract(shortcode_atts(array(
                "target" => "",
                "redirect" => ""
            ), $atts));

    if(empty($target)) $target = 'ADMIN_EMAIL';
    if(empty($redirect)) $redirect = get_permalink( $post->ID );

    //General Settings
    $rows = array();

    $rows[] = array(
        'id' => 'name',
        'label' => __('Name','calibrefx'),
        'desc' => __('Fill with your name','calibrefx'),
        'tooltip' => __('Your name','calibrefx'),
        'content' => $calibrefx->form->textinput('name', '', '', 'required'),
    );

    $rows[] = array(
        'id' => 'email',
        'label' => __('Email','calibrefx'),
        'desc' => __('Fill with your email','calibrefx'),
        'tooltip' => __('Your email','calibrefx'),
        'content' => $calibrefx->form->textinput('email', '', '', 'required email'),
    );

    $rows[] = array(
        'id' => 'subject',
        'label' => __('Subject','calibrefx'),
        'desc' => __('Your subject','calibrefx'),
        'tooltip' => __('Your subject','calibrefx'),
        'content' => $calibrefx->form->textinput('subject', '', '', 'required'),
    );

    $rows[] = array(
        'id' => 'message',
        'label' => __('Message','calibrefx'),
        'desc' => __('Your message','calibrefx'),
        'tooltip' => __('Your message','calibrefx'),
        'content' => $calibrefx->form->textarea('message', '', '', 'required'),
    );

    $rows[] = array(
        'id' => 'action',
        'label' => '',
        'desc' => '',
        'tooltip' => '',
        'content' => $calibrefx->form->hidden('action', 'contact-form'),
    );

    $rows[] = array(
        'id' => 'target',
        'label' => '',
        'desc' => '',
        'tooltip' => '',
        'content' => $calibrefx->form->hidden('target', $target),
    );

    $rows[] = array(
        'id' => 'redirect',
        'label' => '',
        'desc' => '',
        'tooltip' => '',
        'content' => $calibrefx->form->hidden('redirect', $redirect),
    );

    $rows[] = array(
        'id' => 'submit',
        'label' => '',
        'desc' => '',
        'tooltip' => '',
        'content' => $calibrefx->form->save_button('Submit'),
    );

    return $calibrefx->form->open('calibrefx_contact_form', get_permalink( $post->ID ), 'post', false )->build($rows);
}

$cfx_shortcode->calibrefx_add_shortcode_button('calibrefx_shortcode_contact', CALIBREFX_SHORTCODE_URL . '/form-contact.php', 360, 200, __('Contact Form shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/contact.png');

/**
 * remove unnecessary paragraf tag
 *  
 * @access public
 * @author Hilaladdiyar Muhammad Nur
 *
 */
function advance_shortcode_unautop($content) {
    $content = trim( do_shortcode( shortcode_unautop( $content ) ) );

    /* Remove '' from the start of the string. */
    if ( substr( $content, 0, 4 ) == '' )
        $content = substr( $content, 4 );

    /* Remove '' from the end of the string. */
    if ( substr( $content, -3, 3 ) == '' )
        $content = substr( $content, 0, -3 );

    //debug_var($content);
    $content = preg_replace( '#^<\/p>|^<br \/>|^<br>|<p>$#', '', $content );

    $content = str_replace( array( '<p></p>', '<p>  </p>', '<p> </p>' ), '', $content );
    $content = str_replace( array( '<br/>', '<br>', '<br />' ), '', $content );
    //debug_var($content);
    return $content;
}

/**
 * make text widget to be able to run shortcode
 *  
 * @access public
 * @author Hilaladdiyar Muhammad Nur
 *
 */
add_filter('widget_text', 'do_shortcode');

add_action('after_setup_theme', 'calibrefx_shortode_tinymce_init');
function calibrefx_shortode_tinymce_init(){
	global $cfx_shortcode;
	
	$cfx_shortcode->calibrefx_shortcode_button_init();
}