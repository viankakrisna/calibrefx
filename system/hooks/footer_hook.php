<?php 
/**
 * Calibrefx Footer Hooks
 *
 */

global $calibrefx;

$calibrefx->hooks->calibrefx_before_footer = array(
    array( 'function' => 'calibrefx_do_footer_widgets', 'priority' => 10 )
);

$calibrefx->hooks->calibrefx_footer = array(
    array( 'function' => 'calibrefx_footer_area', 'priority' => 10 )
);

$calibrefx->hooks->calibrefx_footer_content = array(
    array( 'function' => 'calibrefx_do_footer', 'priority' => 10 )
);

/**
 * Display the footer widget if the footer widget are active.
 */
function calibrefx_do_footer_widgets() {
    global $wp_registered_sidebars;

    $footer_widgets = get_theme_support( 'calibrefx-footer-widgets' );

    $all_widgets = wp_get_sidebars_widgets();

    //Check if footer widget theme support is activated or is there any widget inside
    if ( !$footer_widgets OR !isset( $all_widgets['footer-widget'] ) ){
        return;
    }

    $count_footer_widgets = count( $all_widgets['footer-widget'] );

    if ( 0 == $count_footer_widgets ){
        return;
    }

    if( current_theme_supports( 'calibrefx-responsive-style' ) ){
        $span = "col-lg-" . strval( floor( ( 12 / $count_footer_widgets) ) ) . " col-md-" . strval(floor((12 / $count_footer_widgets))) . " col-sm-12 col-xs-12";
    } else {
        $span = "col-xs-" . strval( floor( (12 / $count_footer_widgets) ) );
    }

    $sidebar = $wp_registered_sidebars['footer-widget'];

    $footer_widget_column = apply_filters( 'calibrefx_footer_widget_column_span', $span ); 

    $sidebar['before_widget'] = '<div id="%1$s" class="widget ' . $span . ' %2$s"><div class="widget-wrap">';
    $sidebar['after_widget'] = '</div></div>';

    unregister_sidebar( 'footer-widget' );
    register_sidebar( $sidebar );

    if ( is_active_sidebar( 'footer-widget' ) ) {
        echo '<div id="footer-widget">';
        calibrefx_put_wrapper( 'footer-widget', 'open' ); 
        $footer_widget_wrapper_class = apply_filters( 'footer_widget_wrapper_class', calibrefx_row_class() );
        echo '<div class="footer-widget-wrapper"><div class="' . $footer_widget_wrapper_class . '">';

        dynamic_sidebar( 'footer-widget' );

        echo '</div></div><!--end .footer-widget-wrapper -->';
        calibrefx_put_wrapper( 'footer-widget','close' );
        echo '</div><!--end #footer-widget-->';
    }
}

/**
 * Display Footer area
 */
function calibrefx_footer_area() {
    echo '<div id="footer">';
    calibrefx_put_wrapper( 'footer', 'open' );
    echo '<div id="footer-wrapper" class="clearfix">';
    do_action( 'calibrefx_footer_content' );
    echo '</div><!-- end #footer-wrapper -->';
    calibrefx_put_wrapper( 'footer', 'close' );
    echo '</div><!-- end #footer -->' . "\n";
}

/**
 * Do Header Callback
 */
function calibrefx_do_footer() {
    // Build the filterable text strings. Includes shortcodes.
    $creds_text = apply_filters( 'calibrefx_footer_credits', sprintf( '[footer_copyright before="%1$s "] [footer_theme_link after=" %2$s "] [footer_calibrefx_link after=" &middot; %3$s "] [footer_wordpress_link]', __( 'Copyright', 'calibrefx' ), __( 'built on', 'calibrefx' ),  __( 'Powered By', 'calibrefx' ) ) );
    $backtotop_text = apply_filters( 'calibrefx_footer_scrolltop', '[footer_scrolltop]' );

    $backtotop = $backtotop_text ? sprintf( '<div class="pull-right scrolltop"><p>%s</p></div>', $backtotop_text ) : '';
    $creds = $creds_text ? sprintf( '<div class="credits pull-left"><p>%s</p></div>', $creds_text ) : '';

    $output = $creds . $backtotop;

    echo apply_filters( 'calibrefx_footer_output', $output, $backtotop_text, $creds_text );
}
add_filter('calibrefx_footer_output', 'do_shortcode', 20);

/**
 * Display the footer scripts, defined in Theme Settings.
 */
function calibrefx_footer_scripts() {
    $footer_scripts = stripslashes(calibrefx_get_option('footer_scripts'));

    echo apply_filters('calibrefx_footer_scripts', $footer_scripts);

    // If singular, echo scripts from custom field
    if ( is_singular() ) {
        calibrefx_custom_field('_calibrefx_scripts');
    }
}
add_action( 'wp_footer', 'calibrefx_footer_scripts' );

/**
 * Add Social javascript in footer
 */
function calibrefx_add_socials_script() {

    if( is_active_widget( false, false, 'facebook-comment' ) OR 
        is_active_widget( false, false, 'facebook-like' ) ) {

        echo 
            '<div id="fb-root"></div>
            <script>
            (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id) ) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=184690738325056";
            fjs.parentNode.insertBefore(js, fjs);
            }(document, \'script\', \'facebook-jssdk\' ) );
            </script>'."\n";
    }

    if( is_active_widget( false, false, 'twitter-timeline-widget' ) ) {
        echo 
            '<script>
            window.twttr = (function (d,s,id) {
            var t, js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id) ) return; js=d.createElement(s); js.id=id;
            js.src="https://platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
            return window.twttr || (t = { _e: [], ready: function(f) { t._e.push(f) } });
            }(document, "script", "twitter-wjs") );
            </script>'."\n";
    }
    
    if( has_shortcode( get_the_content( ), 'gplus') ){
        echo 
            '<script type="text/javascript">
              (function() {
                var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
                po.src = \'https://apis.google.com/js/plusone.js?onload=onLoadCallback\';
                var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
              })();
            </script>'."\n";
    }
    
}
add_action( 'wp_footer', 'calibrefx_add_socials_script' );

/**
 * Show Tracking Scripts
 */
function calibrefx_show_tracking_scrips() {

    $analytic_id = calibrefx_get_option( 'analytic_id' );
    $google_tagmanager_code = calibrefx_get_option( 'google_tagmanager_code' );
    $facebook_tracking_code = calibrefx_get_option( 'facebook_tracking_code' );

    if( !empty( $analytic_id ) ) {
        echo "
<script type='text/javascript'>
    var _gaq = _gaq || [];
     _gaq.push(['_setAccount', '$analytic_id']);
     _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement( 'script' ); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ( 'https:' == document.location.protocol ? 'https://ssl' : 'http://www' ) + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName( 'script' )[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
        ";
    }

    if( !empty( $google_tagmanager_code ) ) {
        echo stripslashes($google_tagmanager_code);
    }

    if( !empty( $facebook_tracking_code ) ) {
        echo stripslashes($facebook_tracking_code);
    }
}
add_action( 'wp_footer', 'calibrefx_show_tracking_scrips' );