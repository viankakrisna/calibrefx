<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @link		http://calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 * 
 *
 * @package CalibreFx
 */
/**
 * Calibrefx Footer Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
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

    if (!$footer_widgets)
        return;

    $all_widgets = wp_get_sidebars_widgets();
    $count_footer_widgets = count($all_widgets['footer-widget']);

    if ($count_footer_widgets == 0)
        return;

    $span = "span" . strval(floor((12 / $count_footer_widgets)));


    $sidebar = $wp_registered_sidebars['footer-widget'];
    $sidebar['before_widget'] = '<div id="%1$s" class="widget ' . $span . ' %2$s"><div class="widget-wrap">';

    unregister_sidebar('footer-widget');
    register_sidebar($sidebar);

    if (is_active_sidebar('footer-widget')) {
        echo '<div id="footer-widget" ' . get_footer_widget_class() . '>';
		calibrefx_put_wrapper('footer-widget');
        dynamic_sidebar('footer-widget');
		calibrefx_put_wrapper('footer-widget','close');
        echo '</div><!--end #footer-widget-->';
    }
}

add_action('calibrefx_footer', 'calibrefx_do_footer_open', 5);

/**
 * Open footer markup
 */
function calibrefx_do_footer_open() {
    echo '<div id="footer" class="row">';
    calibrefx_put_wrapper('footer');
    echo '<div id="footer-wrapper" class="row">';
}

add_action('calibrefx_footer', 'calibrefx_do_footer_close', 15);

/**
 * Close footer markup
 */
function calibrefx_do_footer_close() {
    echo '</div><!-- end #footer-wrapper -->';
    calibrefx_put_wrapper('footer', 'close');
    echo '</div><!-- end #footer -->' . "\n";
}

add_filter('calibrefx_footer_output', 'do_shortcode', 20);
add_action('calibrefx_footer', 'calibrefx_do_footer');

/**
 * Do Header Callback
 */
function calibrefx_do_footer() {
    // Build the filterable text strings. Includes shortcodes.
    $creds_text = apply_filters('calibrefx_footer_credits', sprintf('[footer_copyright before="%1$s "] [footer_theme_link after=" %2$s "] [footer_calibrefx_link after=" %3$s "] [footer_wordpress_link before= " %4$s " after=" %3$s "]', __('Copyright', 'calibrefx'), __('on', 'calibrefx'), '&middot;', __('Powered By', 'calibrefx')));
    $backtotop_text = apply_filters('calibrefx_footer_scrolltop', '[footer_scrolltop]');

    $backtotop = $backtotop_text ? sprintf('<div class="pull-right  scrolltop"><p>%s</p></div>', $backtotop_text) : '';
    $creds = $creds_text ? sprintf('<div class="credits pull-left"><p>%s</p></div>', $creds_text) : '';

    $output = $creds . $backtotop;

    echo apply_filters('calibrefx_footer_output', $output, $backtotop_text, $creds_text);
}

add_action('wp_footer', 'calibrefx_add_socials_script');

/**
 * Add Social javascript after header
 */
function calibrefx_add_socials_script() {
    global $twitteruser;

    $twitteruser = calibrefx_get_option('twitter_username');

    //@TODO: add enable facebook in theme setting
    echo '
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=184690738325056";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, \'script\', \'facebook-jssdk\'));</script>';

    if (!empty($twitteruser)) {
        echo '<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>';
    }
}