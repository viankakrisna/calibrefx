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

add_shortcode( 'site_url', 'calibrefx_site_url' );

function calibrefx_site_url($atts, $content = null){
    extract(shortcode_atts(array(
                'path' => '',
                'scheme' => null,
                    ), $atts));

    return site_url( $path, $scheme );
}

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

$tinymce_button_video = new CFX_Shortcode();
$tinymce_button_video->calibrefx_add_shortcode_button('calibrefx_shortcode_video', CALIBREFX_SHORTCODE_URL . '/form-video.php', 360, 240, __('Video shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/video.png');

/**
 * ==============================================================
 * Typography Section
 * ==============================================================
 */
add_shortcode('text', 'calibrefx_text');

function calibrefx_text($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'color' => '',
                'font' => '',
                'style' => '',
                'type' => 'normal',
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

    if($type == 'normal')
        $elm = 'span';
	elseif($type == 'paragraph')
        $elm = 'p';
    elseif($type == 'cite')
        $elm = 'cite';
    elseif($type == 'blockquote')
        $elm = 'blockquote';



    return $before . '<'. $elm .' class="' . $classes . '">' . do_shortcode($content) . '</' . $elm . '>' . $after;
}

$tinymce_button_text = new CFX_Shortcode();
$tinymce_button_text->calibrefx_add_shortcode_button('calibrefx_shortcode_text', CALIBREFX_SHORTCODE_URL . '/form-texts.php', 360, 280, __('Text shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/text.png');

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

    return $before . '<img src="' . do_shortcode($content) . '" title="' . $title . '" width="' . $width . '" height="' . $height . '" class="' . $class . '"/>' . $after;
}

$tinymce_button_image = new CFX_Shortcode();
$tinymce_button_image->calibrefx_add_shortcode_button('calibrefx_shortcode_image', CALIBREFX_SHORTCODE_URL . '/form-image.php', 360, 280, __('Image shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/image.png');

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
                'id' => '',
                'url' => '#',
                'type' => '',
                'size' => '',
                'icon' => '',
                'icon_color' => '',
                'rel' => 'nofollow'
                    ), $atts));

    $classes = 'btn';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($type))
        $classes .= ' btn-' . $type;
    if (!empty($size))
        $classes .= ' btn-' . $size;

    if (!empty($icon_color))
        $icon_class .= ' icon-'.$icon_color;

    if (!empty($icon)) {
        return $before . '<a href="' . $url . '" class="' . $classes . '" rel="'.$rel.'"><i class="icon-'.$icon.$icon_class.'"></i>' . do_shortcode($content) . '</a>' . $after;
    } else {
        return $before . '<a href="' . $url . '" class="' . $classes . '" rel="'.$rel.'">' . do_shortcode($content) . '</a>' . $after;
    }
}

$tinymce_button_buttons = new CFX_Shortcode();
$tinymce_button_buttons->calibrefx_add_shortcode_button('calibrefx_shortcode_buttons', CALIBREFX_SHORTCODE_URL . '/form-buttons.php', 360, 420, __('Button shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/buttons.png');

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

    return $before.'<a href="'.$url.'" data-toggle="tooltip" data-placement="'.$position.'" data-original-title="'.$text.'"'.$classes.$ids.'>'.advance_shortcode_unautop($content).'</a>'.$after;
}

$tinymce_button_tooltips = new CFX_Shortcode();
$tinymce_button_tooltips->calibrefx_add_shortcode_button('calibrefx_shortcode_tooltips', CALIBREFX_SHORTCODE_URL . '/form-tooltips.php', 360, 380, __('Tooltips shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/tooltips.png');

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

$tinymce_button_dropcaps = new CFX_Shortcode();
$tinymce_button_dropcaps->calibrefx_add_shortcode_button('calibrefx_shortcode_dropcaps', CALIBREFX_SHORTCODE_URL . '/form-dropcaps.php', 360, 280, __('Dropcaps shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/dropcaps.png');

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

    $classes = 'custom-list';
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($style))
        $classes .= ' ' . $style;

    return $before . '<div class="' . $classes . '">' . do_shortcode($content) . '</div>' . $after;
}

$tinymce_button_list = new CFX_Shortcode();
$tinymce_button_list->calibrefx_add_shortcode_button('calibrefx_shortcode_list', CALIBREFX_SHORTCODE_URL . '/form-list.php', 360, 200, __('List shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/list.png');

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

    if (!empty($class)) $classes .= ' ' . $class;

    return '<div class="' . $class . ' '.calibrefx_row_class().'" style="'.$style.'" id="'.$id.'">' . do_shortcode(advance_shortcode_unautop($content)) . '</div>';
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

    return $before . '<div class="' . $classes . '" style="'.$style.'" id="'.$id.'">' . do_shortcode(advance_shortcode_unautop($content)) . '</div>' . $after;
}

$tinymce_button_row = new CFX_Shortcode();
$tinymce_button_row->calibrefx_add_shortcode_button('calibrefx_shortcode_column', CALIBREFX_SHORTCODE_URL . '/form-cols.php', 360, 220, __('Column shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/cols.png');

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

    $classes = " separator ".calibrefx_row_class();
    if (!empty($class))
        $classes .= ' '.$class;

    return '<div class="' . $classes . ' separator" style="'.$style.'">' . do_shortcode(advance_shortcode_unautop($content)) . '</div>';
}

$tinymce_button_separator = new CFX_Shortcode();
$tinymce_button_separator->calibrefx_add_shortcode_button('calibrefx_shortcode_separator', CALIBREFX_SHORTCODE_URL . '/form-separator.php', 360, 200, __('Separator shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/separator.png');

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

    $html = '';
    $html .= '<div class="headline '.$class.'" id="'.$id.'">';
    if($top_separator) $html .= '<div class="headline-separator top"></div>';
    $html .= '<div class="headline-content '.calibrefx_row_class().'">';
    $html .= advance_shortcode_unautop($content);
    $html .= '</div>';
    if($bottom_separator) $html .= '<div class="headline-separator bottom"></div>';
    $html .= '</div>';

    return $html;
}

$tinymce_button_headline = new CFX_Shortcode();
$tinymce_button_headline->calibrefx_add_shortcode_button('calibrefx_shortcode_headline', CALIBREFX_SHORTCODE_URL . '/form-headline.php', 360, 200, __('Headline shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/headline.png');

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
add_shortcode('gmaps', 'calibrefx_gmap');

function calibrefx_gmap($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'width' => '',
                'height' => '',
                'src' => ''
                    ), $atts));

    return $before . '<div class="flexible-container gmaps"><iframe width="' . $width . '" height="' . $height . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="' . html_entity_decode($src) . '&output=embed" class="' . $class . '"></iframe></div>' . $after;
}

$tinymce_button_gmaps = new CFX_Shortcode();
$tinymce_button_gmaps->calibrefx_add_shortcode_button('calibrefx_shortcode_gmaps', CALIBREFX_SHORTCODE_URL . '/form-gmaps.php', 470, 240, __('Google map shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/googlemaps.png');

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
        'interval' => 3000,
        'speed' => 800,
        'fx' => 'fade',
        'pager' => 0,
        'next_prev' => 0,
        'slide_elm' => '> div',
        'auto_height' => 0,
        'height' => '',
        'width' => ''
    ), $atts));

    if(!empty($class)) $class = ' '.$class;

    if($pager || $next_prev){
        // Create custom ID for pager
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < 8; $i++) {
            $pager_class .= $chars[rand(0, $size - 1)];
        }
    }

    if(!empty($width)) $style_item .= 'width:'.$width.';';
    if(!empty($height)) $style_item .= 'height:'.$height.';';
    
    if(!empty($width) || !empty($height)) $style .= ' style="'.$style_item.'"';

    $data_cycle = '';
    if(!empty($fx)) $data_cycle .= ' data-cycle-fx="'.$fx.'"';
    if(!empty($interval)) $data_cycle .= ' data-cycle-timeout="'.$interval.'"';
    if(!empty($speed)) $data_cycle .= ' data-cycle-speed="'.$speed.'"';
    if(!empty($slide_elm)) $data_cycle .= ' data-cycle-slides="'.$slide_elm.'"';
    if($pager) $data_cycle .= ' data-cycle-pager="#'.$pager_class.'" data-cycle-pager-template=\'<a href="#" class="slider-pager-item">{{slideNum}}</a>\'';
    if($next_prev) $data_cycle .= ' data-cycle-prev="#slider-prev-'.$pager_class.'" data-cycle-next="#slider-next-'.$pager_class.'"';
    if($auto_height !== 0) $data_cycle .= ' data-cycle-auto-height="'.$auto_height.'"';
    $data_cycle .= ' data-cycle-pause-on-hover="true"';

    $html = '';
    $html .= '<div id="'.$id.'" class="slider-container'.$class.'">';
    $html .= '<div class="slider-wrapper">';
    $html .= '<div class="slider cycle-slideshow"'.$data_cycle.$style.'>';
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
        'title' => ''
    ), $atts));

    if(!empty($url) && $url != '#'){
        return '<div class="item ' . $class . '">' . $before . '<a href="'.$url.'" title="'.$title.'"><img src="' . $src . '" alt="'.$title.'" /></a>'  . $after . '</div>';
    }else{
        return '<div class="item ' . $class . '">' . $before . '<img src="' . $src . '" alt="'.$title.'" />'  . $after . '</div>';
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

$tinymce_button_slider = new CFX_Shortcode();
$tinymce_button_slider->calibrefx_add_shortcode_button('calibrefx_shortcode_slider', CALIBREFX_SHORTCODE_URL . '/form-slider.php', 400, 460, __('Slider shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/nivo.png');

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
        'id' => '',
        'tab' => 'tab1|tab2|tab3',
        'class' => '',
        'headings' => 'Tab1|Tab2|Tab3'), 
    $atts));

    $tabs_headings = explode('|', $headings);
    $tabs_elements = explode('|', $tab);

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

$tinymce_button_tabs = new CFX_Shortcode();
$tinymce_button_tabs->calibrefx_add_shortcode_button('calibrefx_shortcode_tabs', CALIBREFX_SHORTCODE_URL . '/form-tabs.php', 360, 340, __('Tabs shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/tabs.png');

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

    return $before . '<div class="accordion'.$class.'" id="'.$id.'">' . advance_shortcode_unautop($content) . '</div>' . $after;
}

add_shortcode('togglebox_item', 'calibrefx_togglebox_item');
function calibrefx_togglebox_item($atts, $content = null){
    global $togglebox_id;

    extract(shortcode_atts(array(
        'title' => '',
        'id' => '',
        'in' => 0
    ), $atts));

    if($in) $class = ' in';

    $output = '<div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#'.$togglebox_id.'" href="#'.$togglebox_id.'-'.$id.'">
                '.$title.'
            </a>
        </div>
        <div id="'.$togglebox_id.'-'.$id.'" class="accordion-body collapse'.$class.'">
            <div class="accordion-inner">
                '.advance_shortcode_unautop($content).'
            </div>
        </div>
    </div>';

    return $output;
}

$tinymce_button_togglebox = new CFX_Shortcode();
$tinymce_button_togglebox->calibrefx_add_shortcode_button('calibrefx_shortcode_togglebox', CALIBREFX_SHORTCODE_URL . '/form-togglebox.php', 360, 200, __('Togglebox shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/togglebox.png');

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

add_shortcode('twitter', 'calibrefx_twitter');

function calibrefx_twitter($atts, $content = null) {
    $calibrefx_twitter = calibrefx_get_option('calibrefx_twitter');
    if ($calibrefx_twitter)
        $output = "<script type='text/javascript' src='http://twittercounter.com/embed/{$calibrefx_twitter}/ffffff/111111'></script>";
    return $output;
}

add_shortcode('tweet', 'calibrefx_tweet');

function calibrefx_tweet($atts, $content = null) {
    extract(shortcode_atts(array(
        'url' => get_permalink(),
        'count' => 'vertical',
        'size' => 'medium',
    ), $atts));

    if(!empty($url)) $attr .=' data-url="'.$url.'"';
    if(!empty($count)) $attr .=' data-count="'.$count.'"';
    if(!empty($size)) $attr .=' data-size="'.$size.'"';

   $output = '<span class="social-bookmark tweet-share"><a href="https://twitter.com/share" class="twitter-share-button"'.$attr.'>Tweet</a></span>';

    return $before . $output . $after;
}

add_shortcode('gplus', 'calibrefx_gplus');

function calibrefx_gplus($atts, $content = null) {
    extract(shortcode_atts(array(
        'width' => 300,
        'size' => 'tall',
        'annotation' => 'bubble',
        'url' => get_permalink(),
    ), $atts));

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

$tinymce_button_social = new CFX_Shortcode();
$tinymce_button_social->calibrefx_add_shortcode_button('calibrefx_shortcode_social', CALIBREFX_SHORTCODE_URL . '/form-social.php', 360, 200, __('Social shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/social.png');

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
    //debug_var($html);

    return do_shortcode( $html );
}

/**
 * ==============================================================
 * Contact Form
 * ==============================================================
 */

add_shortcode('contact_form', 'calibrefx_contact_form');

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
        'content' => $calibrefx->form->textinput('name', ''),
    );

    $rows[] = array(
        'id' => 'email',
        'label' => __('Email','calibrefx'),
        'desc' => __('Fill with your email','calibrefx'),
        'tooltip' => __('Your email','calibrefx'),
        'content' => $calibrefx->form->textinput('email', ''),
    );

    $rows[] = array(
        'id' => 'subject',
        'label' => __('Subject','calibrefx'),
        'desc' => __('Your subject','calibrefx'),
        'tooltip' => __('Your subject','calibrefx'),
        'content' => $calibrefx->form->textinput('subject', ''),
    );

    $rows[] = array(
        'id' => 'message',
        'label' => __('Message','calibrefx'),
        'desc' => __('Your message','calibrefx'),
        'tooltip' => __('Your message','calibrefx'),
        'content' => $calibrefx->form->textarea('message', ''),
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
        'content' => $calibrefx->form->save_button('Send'),
    );

    return $calibrefx->form->open('calibrefx_contact_form', get_permalink( $post->ID ) )->build($rows);
}

$tinymce_button_contact = new CFX_Shortcode();
$tinymce_button_contact->calibrefx_add_shortcode_button('calibrefx_shortcode_contact', CALIBREFX_SHORTCODE_URL . '/form-contact.php', 360, 200, __('Contact Form shortcode', 'calibrefx'), CALIBREFX_IMAGES_URL . '/shortcode/form/contact.png');

/**
 * remove unnecessary paragraf tag
 *  
 * @access public
 * @author Hilaladdiyar Muhammad Nur
 *
 */
function advance_shortcode_unautop($content) {
    $content = do_shortcode( shortcode_unautop($content) );
    $content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
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