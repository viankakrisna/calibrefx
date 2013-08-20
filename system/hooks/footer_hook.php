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
 * Calibrefx Footer Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

add_action('wp_footer', 'calibrefx_footer_scripts');

/**
 * Display the footer scripts, defined in Theme Settings.
 */
function calibrefx_footer_scripts() {
    $footer_scripts = stripslashes(calibrefx_get_option('footer_scripts'));

    echo apply_filters('calibrefx_footer_scripts', $footer_scripts);

    // If singular, echo scripts from custom field
    if (is_singular()) {
        calibrefx_custom_field('_calibrefx_scripts');
    }
}

add_action('calibrefx_before_footer', 'calibrefx_do_footer_widgets');

/**
 * Display the footer widget if the footer widget are active.
 */
function calibrefx_do_footer_widgets() {
    global $wp_registered_sidebars;

    $footer_widgets = get_theme_support('calibrefx-footer-widgets');

    $all_widgets = wp_get_sidebars_widgets();

    if (!$footer_widgets || !isset($all_widgets['footer-widget']))
        return;

    $count_footer_widgets = count($all_widgets['footer-widget']);

    if ($count_footer_widgets == 0)
        return;

    $span = "span" . strval(floor((12 / $count_footer_widgets)));


    $sidebar = $wp_registered_sidebars['footer-widget'];
    $sidebar['before_widget'] = '<div id="%1$s" class="widget ' . $span . ' %2$s"><div class="widget-wrap">';
	$sidebar['after_widget'] = '</div></div>';

    unregister_sidebar('footer-widget');
    register_sidebar($sidebar);

    if (is_active_sidebar('footer-widget')) {
        do_action('calibrefx_before_footer_widget');
        dynamic_sidebar('footer-widget');
		do_action('calibrefx_after_footer_widget');
    }
}

add_action('calibrefx_before_footer_widget', 'calibrefx_do_footer_widget_open');

/**
 * Open footer widget markup
 */
function calibrefx_do_footer_widget_open(){
    echo '<div id="footer-widget" ' . get_footer_widget_class() . '>';
    calibrefx_put_wrapper('footer-widget', 'open'); 
}

add_action('calibrefx_before_footer_widget', 'calibrefx_do_footer_widget_wrapper_open');

/**
 * Open footer widget wrapper markup
 */
function calibrefx_do_footer_widget_wrapper_open(){
    $footer_widget_wrapper_class = apply_filters( 'footer_widget_wrapper_class', calibrefx_row_class() );
    echo '<div class="footer-widget-wrapper"><div class="'.$footer_widget_wrapper_class.'">';
}

add_action('calibrefx_after_footer_widget', 'calibrefx_do_footer_widget_wrapper_close');

/**
 * Open footer widget markup
 */
function calibrefx_do_footer_widget_wrapper_close(){
    echo '</div></div><!--end .footer-widget-wrapper -->';
}

add_action('calibrefx_after_footer_widget', 'calibrefx_do_footer_widget_close');

/**
 * Open footer widget markup
 */
function calibrefx_do_footer_widget_close(){
    calibrefx_put_wrapper('footer-widget','close');
    echo '</div><!--end #footer-widget-->';
}

add_action('calibrefx_footer', 'calibrefx_do_footer_open', 5);

/**
 * Open footer markup
 */
function calibrefx_do_footer_open() {
    $footer_class = apply_filters( 'footer_class', calibrefx_row_class() );
    echo '<div id="footer" class="'.$footer_class.'">';
}

add_action('calibrefx_footer', 'calibrefx_do_footer_wrapper_row_open', 7);

/**
 * Open footer wrapper row markup
 */
function calibrefx_do_footer_wrapper_row_open() {
    calibrefx_put_wrapper('footer', 'open');
}

add_action('calibrefx_footer', 'calibrefx_do_footer_wrapper_open', 9);

/**
 * Open footer wrapper markup
 */
function calibrefx_do_footer_wrapper_open() {
    echo '<div id="footer-wrapper">';
}

add_action('calibrefx_footer', 'calibrefx_do_footer_wrapper_close', 12);

/**
 * Close footer wrapper markup
 */
function calibrefx_do_footer_wrapper_close() {
    echo '</div><!-- end #footer-wrapper -->';
}

add_action('calibrefx_footer', 'calibrefx_do_footer_wrapper_row_close', 15);

/**
 * Close footer wrapper row markup
 */
function calibrefx_do_footer_wrapper_row_close() {
    calibrefx_put_wrapper('footer', 'close');
}

add_action('calibrefx_footer', 'calibrefx_do_footer_close', 20);

/**
 * Close footer markup
 */
function calibrefx_do_footer_close() {
    echo '</div><!-- end #footer -->' . "\n";
}

add_filter('calibrefx_footer_output', 'do_shortcode', 20);
add_action('calibrefx_footer', 'calibrefx_do_footer');

/**
 * Do Header Callback
 */
function calibrefx_do_footer() {
    // Build the filterable text strings. Includes shortcodes.
    $creds_text = apply_filters('calibrefx_footer_credits', sprintf('[footer_copyright before="%1$s "] [footer_theme_link after=" %2$s "] [footer_calibrefx_link after=" %3$s "] [footer_wordpress_link before= " %3$s "]', __('Copyright', 'calibrefx'), __('on', 'calibrefx'),  __('Powered By', 'calibrefx')));
    $backtotop_text = apply_filters('calibrefx_footer_scrolltop', '[footer_scrolltop]');

    $backtotop = $backtotop_text ? sprintf('<div class="pull-right scrolltop"><p>%s</p></div>', $backtotop_text) : '';
    $creds = $creds_text ? sprintf('<div class="credits pull-left"><p>%s</p></div>', $creds_text) : '';

    $output = $creds . $backtotop;

    echo apply_filters('calibrefx_footer_output', $output, $backtotop_text, $creds_text);
}

add_action('wp_footer', 'calibrefx_add_socials_script');

/**
 * Add Social javascript in footer
 */
function calibrefx_add_socials_script() {
    global $twitteruser;

    $twitteruser = calibrefx_get_option('twitter_username');

    //@TODO: add enable facebook in theme setting
    echo 
'<div id="fb-root"></div>
<script>
(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=184690738325056";
fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));
</script>'."\n";

    //@TODO : add enable twitter in theme setting
    echo 
'<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
</script>'."\n";

    if (!empty($twitteruser) && is_active_widget( false, false, 'twitter-widget' )) {
        echo 
'<script src="http://widgets.twimg.com/j/2/widget.js"></script>'."\n";
    }
}

add_action('wp_footer', 'calibrefx_add_google_analytics');

/**
 * Add google analytics settings
 */
function calibrefx_add_google_analytics() {

    $analytic_id = calibrefx_get_option('analytic_id');

    if(!empty($analytic_id)){
        echo "
<script type='text/javascript'>
    var _gaq = _gaq || [];
     _gaq.push(['_setAccount', '$analytic_id']);
     _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
        ";
    }
}