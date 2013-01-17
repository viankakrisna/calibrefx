<?php

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

    return '<iframe title="' . $title . '" width="' . $width . '" height="' . $height . '" src="http://www.youtube.com/embed/' . $content . '" frameborder="0" allowfullscreen></iframe>';
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

    return '<iframe title="' . $title . '" width="' . $width . '" height="' . $height . '" src="http://player.vimeo.com/video/' . $content . '" frameborder="0"></iframe>';
}

$tinymce_button = new calibrefx_add_shortcode_button('calibrefx_shortcode_video');

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

    return $before . '<img src="' . do_shortcode($content) . '" title="' . $title . '" width="' . $width . '" height="' . $height . '" class="' . $class . '"/>' . $after;
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
        return $before . '<a href="' . $url . '" class="' . $classes . ' icon"><span class="rightbtn">' . do_shortcode($content) . '</span><span class="ico ' . $icon . '"></span></a>' . $after;
    } else {
        return $before . '<a href="' . $url . '" class="' . $classes . '"><span>' . do_shortcode($content) . '</span></a>' . $after;
    }
}

$tinymce_button = new calibrefx_add_shortcode_button('calibrefx_shortcode_buttons');

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

    return $before . '<span class="' . $classes . '"><span class="tooltip-content"><span class="tooltip-arr"></span>' . $text . '</span>' . do_shortcode($content) . '</span>' . $after;
}

$tinymce_button = new calibrefx_add_shortcode_button('calibrefx_shortcode_tooltips');

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

$tinymce_button = new calibrefx_add_shortcode_button('calibrefx_shortcode_dropcaps');

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

    return $before . '<ul class="' . $classes . '">' . do_shortcode($content) . '</ul>' . $after;
}

$tinymce_button = new calibrefx_add_shortcode_button('calibrefx_shortcode_list');

add_shortcode('li', 'calibrefx_list_item');

function calibrefx_list_item($atts, $content = '') {
    extract(shortcode_atts(array(
                'class' => ''
                    ), $atts));

    return '<li class="' . $class . '">' . do_shortcode($content) . '</li>';
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
                'last' => '',
                'first' => '',
                    ), $atts));

    $classes = $class;
    if (!empty($class))
        $classes .= ' ' . $class;
    if (!empty($cols))
        $classes .= ' ' . $cols;
    if (!empty($align))
        $classes .= ' ' . $align;
    if (!empty($first)) {
        if ($first == 'yes') {
            $before = '<div class="row">';
        }
    }
    if (!empty($last)) {
        if ($last == 'yes') {
            $after = '</div>';
        }
    }

    return $before . '<div class="' . $classes . '" style="'.$style.'">' . do_shortcode(advance_shortcode_unautop($content)) . '</div>' . $after;
}

$tinymce_button = new calibrefx_add_shortcode_button('calibrefx_shortcode_column');

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

    return $before . '<iframe width="' . $width . '" height="' . $height . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="' . html_entity_decode($src) . '&output=embed" class="' . $class . '"></iframe>' . $after;
}

$tinymce_button = new calibrefx_add_shortcode_button('calibrefx_shortcode_gmaps');

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
                'class' => '',
                'interval' => '',
                    ), $atts));

    $is_bootstrap_enabled = calibrefx_get_option('enable_bootstrap');

    if ($is_bootstrap_enabled) {
        //Create Random ID
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < 8; $i++) {
            $id .= $chars[rand(0, $size - 1)];
        }

        return $before . '<div id="' . $id . '" class="carousel slide ' . $class . '">
	  <!-- Carousel items -->
	  <div class="carousel-inner">
		' . do_shortcode($content) . '
	  </div>
	  <!-- Carousel nav -->
	  <a class="carousel-control left" href="#' . $id . '" data-slide="prev">&lsaquo;</a>
	  <a class="carousel-control right" href="#' . $id . '" data-slide="next">&rsaquo;</a>
	</div>
	<script>jQuery("#' . $id . '").carousel({ interval: ' . $interval . ' });</script>' . $after;
    } else {
        return '<div class="alert alert-error">Bootstrap must be enabled to use the slider.</div>';
    }
}

add_shortcode('slider_item', 'calibrefx_slider_item');

function calibrefx_slider_item($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                'src' => ''
                    ), $atts));

    return '<div class="item ' . $class . '">' . $before . '<img src="' . $src . '" />.' . do_shortcode($content) . $after . '</div>';
}

add_shortcode('slider_caption', 'calibrefx_slider_caption');

function calibrefx_slider_caption($atts, $content = '') {
    extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => '',
                    ), $atts));

    return '<div class="carousel-caption ' . $class . '">' . $before . do_shortcode($content) . $after . '</div>';
}

$tinymce_button = new calibrefx_add_shortcode_button('calibrefx_shortcode_slider');

/**
 * ==============================================================
 * Tabbed Content
 * ==============================================================
 */
add_shortcode('tabs', 'calibrefx_tabs');

function calibrefx_tabs($atts, $content = null) {
    global $tabid, $headings;

    extract(shortcode_atts(array(
                'tabid' => 'tabID1',
                'type' => 'vertical',
                'effect' => 'fade',
                'timeout' => '0',
                'headings' => 'Tab1|Tab2|Tab3'), $atts));

    if ($type == 'vertical') {
        $output .= '<div class="ltt-slider-ver"><ul id="ltt-pager-' . $tabid . '" class="ltt-slider-ver-nav">';
    } else if ($type == 'horizontal') {
        $output .= '<div class="ltt-slider-hor"><ul id="ltt-pager-' . $tabid . '" class="ltt-slider-hor-nav">';
    }

    $ltt_tabs = explode('|', $headings);

    $i = 0;
    //iterate through tabs headings 
    foreach ($ltt_tabs as $ltt_tab) {
        $output .= '<li>';
        $output .= '<a id="' . $tabid . '-goto' . $i . '" class="tabvertnav" href="#">';
        $output .= '<span>';
        $output .= $ltt_tab;
        $output .= '</span>';
        $output .= '</a>';
        $output .= '</li>';
        $i++;
    }

    $output .= '</ul>';

    if ($type == 'vertical') {
        $output .= '<div id="' . $tabid . '" class="ltt-slider-ver-content">';
    } else if ($type == 'horizontal') {
        $output .= '<div class="clear"></div><div id="' . $tabid . '" class="ltt-slider-hor-content">';
    }

    echo "\n" . '<script type="text/javascript">' . "\n";
    echo '<!--' . "\n";
    echo 'jQuery(function(jQuery) {' . "\n";
    echo 'jQuery("#' . $tabid . '").cycle({ ' . "\n";
    echo '  timeout: ' . $timeout . ',' . "\n";
    echo '  speed: 600,' . "\n";
    echo '  startingSlide: 0,' . "\n";
    echo '  pager:  "#ltt-pager-' . $tabid . '",' . "\n";
    echo '  fx: "' . $effect . '" ' . "\n";
    echo '}); ' . "\n";
    echo ' jQuery("ul#ltt-pager-' . $tabid . ' a").not(".tabvertnav").remove();' . "\n";

    $ltt_tabs = explode('|', $headings);
    $i = 0;
    //iterate through tabs headings 
    foreach ($ltt_tabs as $ltt_tab) {
        echo 'jQuery("#' . $tabid . '-goto' . $i . '").click(function() { ' . "\n";
        echo '	jQuery("#' . $tabid . '").cycle(' . $i . ');    ' . "\n";
        echo '	return false; ' . "\n";
        echo '});' . "\n";
        $i++;
    }

    echo '			' . "\n";
    echo '		});' . "\n";
    echo 'jQuery(".ltt-slider-hor-content div").css("filter", "none")' . "\n";
    ;
    echo '// -->' . "\n";
    echo '  </script>' . "\n";

    return $output . do_shortcode($content) . '</div><div class="clear"></div></div>';
}

add_shortcode('tabs', 'calibrefx_tabs');

global $tabid, $headings;
// slides
add_shortcode('tab', 'calibrefx_tabs_slide');

function calibrefx_tabs_slide($atts, $content = null) {
    return '<div>' . do_shortcode($content) . '<div class=""clear"></div></div>';
}

function add_tabs_js() {
    add_action('wp_footer', 'tabs_js');
}

//tabs js
function tabs_js() {
    global $tabid, $headings;

    echo "\n" . '<script type="text/javascript">' . "\n";
    echo 'jQuery(function() {' . "\n";
    echo 'jQuery("#' . $tabid . '").cycle({ ' . "\n";
    echo '  timeout: ' . $timeout . ',' . "\n";
    echo '  speed: 300,' . "\n";
    echo '  startingSlide: 0,' . "\n";
    echo '  pager:  "#ltt-pager-' . $tabid . '",' . "\n";
    echo '  fx: "fade" ' . "\n";
    echo '}); ' . "\n";
    echo ' jQuery("ul#ltt-pager-' . $tabid . ' a").not(".tabvertnav").remove();' . "\n";

    $ltt_tabs = explode('|', $headings);
    $i = 0;
    //iterate through tabs headings 
    foreach ($ltt_tabs as $ltt_tab) {
        echo 'jQuery("#' . $tabid . '-goto' . $i . '").click(function() { ' . "\n";
        echo '  jQuery("#' . $tabid . '").cycle(' . $i . ');    ' . "\n";
        echo '	return false; ' . "\n";
        echo '});' . "\n";
        $i++;
    }

    echo "\n";
    echo '});' . "\n";
    echo ' </script>' . "\n";
}

$tinymce_button = new calibrefx_add_shortcode_button('calibrefx_shortcode_tabs');

/**
 * ==============================================================
 * Togglebox
 * ==============================================================
 */
add_shortcode('togglebox', 'calibrefx_togglebox');

function calibrefx_togglebox($atts, $content = null) {
    extract(shortcode_atts(array('state' => 'open',
                'head' => 'Togglebox header'), $atts));

    return '<div class="ltt-toggler ' . $state . '"><h2 class="ltt-trigger"><a href="#">' . $head . '</a></h2>
            <div class="ltt-toggle-container">' . do_shortcode($content) . '</div>
            </div>';
}

$tinymce_button = new calibrefx_add_shortcode_button('calibrefx_shortcode_togglebox');

/**
 * ==============================================================
 * Social Icon Shortcode
 * ==============================================================
 */
add_shortcode('digg', 'calibrefx_digg');

function calibrefx_digg($atts, $content = null) {
    $output = "<script type='text/javascript'>
(function() {
var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
s.type = 'text/javascript';
s.async = true;
s.src = 'http://widgets.digg.com/buttons.js';
s1.parentNode.insertBefore(s, s1);
})();
</script>
<!-- Medium Button -->
<a class='DiggThisButton DiggMedium'></a>";

    return $output;
}

add_shortcode('stumble', 'calibrefx_stumble');

function calibrefx_stumble($atts, $content = null) {
    $output = "<script src='http://www.stumbleupon.com/hostedbadge.php?s=5'></script>";
    return $output;
}

add_shortcode('facebook', 'calibrefx_facebook');

function calibrefx_facebook($atts, $content = null) {
    $output = "<a name='fb_share' type='button_count' href='http://www.facebook.com/sharer.php'></a><script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>";
    return $output;
}

add_shortcode('buzz', 'calibrefx_buzz');

function calibrefx_buzz($atts, $content = null) {
    $output = "<a title='Post to Google Buzz' class='google-buzz-button' href='http://www.google.com/buzz/post' data-button-style='normal-count'></a>
<script type='text/javascript' src='http://www.google.com/buzz/api/button.js'></script>";
    return $output;
}

add_shortcode('twitter', 'calibrefx_twitter');

function calibrefx_twitter($atts, $content = null) {
    $calibrefx_twitter = get_option('calibrefx_twitter');
    if ($calibrefx_twitter)
        $output = "<script type='text/javascript' src='http://twittercounter.com/embed/{$calibrefx_twitter}/ffffff/111111'></script>";
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

add_shortcode('retweet', 'calibrefx_retweet');

function calibrefx_retweet($atts, $content = null) {
    $output = "<a href='http://twitter.com/share' class='twitter-share-button' data-count='vertical'>Tweet</a><script type='text/javascript' src='http://platform.twitter.com/widgets.js'></script>";
    return $output;
}

$tinymce_button = new calibrefx_add_shortcode_button('calibrefx_shortcode_social');

/**
 * add shortcode buttons to editor
 *  
 * @access public
 * @author Hilaladdiyar Muhammad Nur
 *
 */
class calibrefx_add_shortcode_button {

    var $plugin_name = "";

    function calibrefx_add_shortcode_button($plugin_name = '') {
        $this->plugin_name = $plugin_name;
        add_filter('tiny_mce_version', array(&$this, 'increase_tinymce_version'));
        add_action('init', array(&$this, 'add_sc_buttons'));
    }

    function add_sc_buttons() {
        // Check that current user can edit post
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
            return;

        // Check that rich editing is enable
        if (get_user_option('rich_editing') == 'true') {
            add_filter("mce_external_plugins", array(&$this, "calibrefx_add_scbuttons_plugin"), 5);
            add_filter('mce_buttons_3', array(&$this, 'calibrefx_register_scbuttons_plugin'), 5);
        }
    }

    function calibrefx_register_scbuttons_plugin($buttons) {
        array_push($buttons, "", $this->plugin_name);
        return $buttons;
    }

    function calibrefx_add_scbuttons_plugin($plugin_arr) {
        $plugin_arr[$this->plugin_name] = CALIBREFX_JS_URL . '/calibrefx-admin-shortcode.js';
        return $plugin_arr;
    }

    function increase_tinymce_version($version) {
        return++$version;
    }

}

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

