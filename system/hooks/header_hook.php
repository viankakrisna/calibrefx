<?php defined( 'CALIBREFX_URL' ) OR exit();
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
 * Calibrefx Header Hooks
 *
 * @package		Calibrefx
 * @subpackage  Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

global $cfxgenerator;

$cfxgenerator->calibrefx_doctype = array( 'calibrefx_print_doctype' );
$cfxgenerator->calibrefx_html_header = array( 'calibrefx_do_html_header' );
$cfxgenerator->calibrefx_meta = array(
    'calibrefx_do_meta_description', 'calibrefx_do_meta_keywords', 'calibrefx_do_link_author',
    'calibrefx_print_favicon', 'calibrefx_print_media_icon', 'calibrefx_load_stylesheet', 
    'calibrefx_do_dublin_core', 'calibrefx_do_fb_og' );

$cfxgenerator->calibrefx_header = array( 
        array( 'function' => 'calibrefx_header_area', 'priority' => 10 )
    );

$cfxgenerator->get_header = array(
        array( 'function' => 'calibrefx_remove_wp_generator', 'priority' => 0 )
    );

$cfxgenerator->wp_head = array(
    'calibrefx_print_wrap', 'calibrefx_do_meta_pingback', 'calibrefx_header_scripts',
    'calibrefx_header_custom_styles', 'calirbefx_show_feeds_meta'
);

/********************
 * FUNCTIONS BELOW  *
 ********************/

/**
 * Adds header structures.
 * 
 * This function handles the doctype. Default HTML5.
 *
 * @package CalibreFx
 */
function calibrefx_print_doctype() { ?>
<!doctype html>
<!--[if lt IE 7 ]><html class="ie ltie9 ie6 no-js" lang="<?php bloginfo( 'language' ); ?>"><![endif]-->
<!--[if IE 7 ]><html class="ie ltie9 ie7 no-js" lang="<?php bloginfo( 'language' ); ?>"><![endif]-->
<!--[if IE 8 ]><html class="ie ltie9 ie8 no-js" lang="<?php bloginfo( 'language' ); ?>"><![endif]-->
<!--[if IE 9 ]><html class="ie ie9 no-js" lang="<?php bloginfo( 'language' ); ?>"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="<?php bloginfo( 'language' ); ?>"><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->
<head id="<?php echo calibrefx_get_site_url(); ?>" data-template-set="html5-reset">
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?php if ( calibrefx_is_responsive_enabled() ) { ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php } ?>
<?php
}

/**
 * Display All the header requirements
 */
function calibrefx_do_html_header() {
    do_action( 'calibrefx_doctype' );
    do_action( 'calibrefx_title' );
    do_action( 'calibrefx_meta' );
    wp_head();
}

/**
 * Remove WP Generator Tag from header
 */
function calibrefx_remove_wp_generator() {
    remove_action( 'wp_head', 'wp_generator' );
}

/**
 * Print meta description, get from blog description
 * Will be override by seo addon later
 */
function calibrefx_do_meta_description() {
    $description = apply_filters( 'calibrefx_do_meta_description', get_bloginfo( 'description' ) );

    // Add the description, but only if one exists
    if ( !empty( $description ) ) {
        echo '<meta name="description" content="' . esc_attr( $description ) . '" />' . "\n";
    }
}

/**
 * Print meta keywords
 * Will be override by seo addon later
 */
function calibrefx_do_meta_keywords() {
    $keywords = apply_filters( 'calibrefx_do_meta_keywords', '' ); 

    // Add the description, but only if one exists
    if ( !empty( $keywords ) ) {
        echo '<meta name="keywords" content="' . esc_attr( $keywords ) . '" />' . "\n";
    }
}

/**
 * Print meta keywords
 * Will be override by seo addon later
 */
function calibrefx_do_link_author() {
    $link_author = apply_filters( 'calibrefx_do_link_author', '' );
    $link_publisher = apply_filters( 'calibrefx_do_link_publisher', '' );

    // Add the description, but only if one exists
    if ( !empty( $link_author ) ) {
        echo '<link rel="author" content="' . esc_attr( $link_author ) . '" />' . "\n";
    }

    // Add the description, but only if one exists
    if ( !empty( $link_author ) ) {
        echo '<link rel="publisher" content="' . esc_attr( $link_publisher ) . '" />' . "\n";
    }
}

/**
 * Print outs favicon
 */
function calibrefx_print_favicon() {

    //allow overriding
    $pre = apply_filters( 'calibrefx_pre_load_favicon', false );

    if ( $pre !== false ){
        $favicon = $pre;
    } elseif ( file_exists( CALIBREFX_IMAGES_URI . '/ico/favicon.ico' ) ) {
        $favicon = CALIBREFX_IMAGES_URL . '/ico/favicon.ico';
    } else {
        $favicon = CALIBREFX_IMAGES_URL . '/favicon.ico';
    }

    //Check if child themes have the favicon.ico
    if ( file_exists( CHILD_URI . '/favicon.ico' ) ) {
        $favicon = CHILD_URL . '/favicon.ico';
    }

    if ( file_exists( CHILD_IMAGES_URI . '/favicon.ico' ) ) {
        $favicon = CHILD_IMAGES_URL . '/favicon.ico';
    }

    $favicon = apply_filters( 'calibrefx_favicon_url', $favicon);

    if ( $favicon ) {
        echo '<link rel="Shortcut Icon" href="' . esc_url( $favicon ) . '" type="image/x-icon" />' . "\n";
    }
}

/**
 * Print outs media icon for apple touch
 */
function calibrefx_print_media_icon() {

    //allow overriding
    $pre = apply_filters( 'calibrefx_pre_load_media57_icon', false );

    if ( $pre !== false ) {
        $media57 = $pre;
    } elseif ( file_exists( CALIBREFX_IMAGES_URI . '/media-57x57.png' ) ) {
        $media57 = CALIBREFX_IMAGES_URL . '/media-57x57.png';
    } else {
        $media57 = CALIBREFX_IMAGES_URL . '/media-57x57.png';
    }

    $media57 = apply_filters( 'calibrefx_media57_url', $media57 );

    if ( $media57 ) {
        echo '<link rel="apple-touch-icon" href="' . esc_url( $media57) . '"/>' . "\n";
    }

    $pre = apply_filters( 'calibrefx_pre_load_media72_icon', false );

    if ( $pre !== false ) {
        $media72 = $pre;
    } elseif ( file_exists( CALIBREFX_IMAGES_URI . '/media-72x72.png' ) ) {
        $media72 = CALIBREFX_IMAGES_URL . '/media-72x72.png';
    } else {
        $media72 = CALIBREFX_IMAGES_URL . '/media-72x72.png';
    }

    $media72 = apply_filters( 'calibrefx_media72_url', $media72 );

    if ( $media72 ) {
        echo '<link rel="apple-touch-icon" sizes="72x72" href="' . esc_url( $media72 ) . '"/>' . "\n";
    }

    $pre = apply_filters( 'calibrefx_pre_load_media114_icon', false );

    if ( $pre !== false ) {
        $media114 = $pre;
    } elseif ( file_exists( CALIBREFX_IMAGES_URI . '/media-114x114.png' ) ) {
        $media114 = CALIBREFX_IMAGES_URL . '/media-114x114.png';
    } else {
        $media114 = CALIBREFX_IMAGES_URL . '/media-114x114.png';
    }

    $media114 = apply_filters( 'calibrefx_media114_url', $media114 );

    if ( $media114 ) {
        echo '<link rel="apple-touch-icon" sizes="114x114" href="' . esc_url( $media114) . '"/>' . "\n";
    }
}

/**
 * This function loads the stylesheet.
 * If a child theme is active, it loads the child theme's stylesheet.
 *
 */
function calibrefx_load_stylesheet() {
    wp_enqueue_style( 'calibrefx-child-style', get_bloginfo( 'stylesheet_url' ) );
}

add_action( 'calibrefx_title', 'wp_title' );
add_filter( 'wp_title', 'calibrefx_do_title' );

/**
 * Print html title, this will override by seo addon later
 */
function calibrefx_do_title() {
    return apply_filters( 'calibrefx_do_title', get_bloginfo( 'name' ) );
}

add_filter( 'wp_title', 'calibrefx_do_title_wrap', 20 );

/**
 * Wraps the html doc title in <title></title> tags.
 *
 * @param string $title
 * @return string Plain text or HTML markup
 */
function calibrefx_do_title_wrap( $title ) {
    return is_feed() || is_admin() ? $title : sprintf("<title>%s</title>\n", $title );
}

/**
 * Print .wrap style
 */
function calibrefx_print_wrap() {
    $wrap = '';
    if ( calibrefx_is_responsive_enabled() AND !calibrefx_layout_is_fluid() ) {
        $wrap = sprintf( '
.container{
max-width: %dpx;
}', calibrefx_get_option("calibrefx_layout_width") );
        
    }

    if ( !calibrefx_is_responsive_enabled() ) {
        $wrap = sprintf( '
body{
    min-width: %dpx;
}
.container{
    max-width: none;
    width: %dpx !important;
}', calibrefx_get_option("calibrefx_layout_width"), calibrefx_get_option("calibrefx_layout_width") );
    }

    printf( '<style type="text/css">%1$s'."\n".'</style>'."\n", $wrap);
}

/**
 * This function adds the pingback meta tag to the <head> so that other
 * sites can know how to send a pingback to our site.
 */
function calibrefx_do_meta_pingback() {
    if ( 'open' == get_option( 'default_ping_status' ) ) {
        echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />' . "\n";
    }
}

/**
 * This function adds dublin core meta in header
 */
function calibrefx_do_dublin_core() {
    echo '<meta name="DC.title" content="' . apply_filters( 'calibrefx_do_title', get_bloginfo( 'name' ) ) . '" />'."\n";
    echo '<meta name="DC.description" content="' . apply_filters( 'calibrefx_seo_description', get_bloginfo( 'description' ) ) . '" />'."\n";
    echo '<meta name="DC.subject" content="' . apply_filters( 'calibrefx_do_title', get_bloginfo( 'name' ) ) . '" />'."\n";
    echo '<meta name="DC.language" content="' . get_bloginfo( 'language' ) . '" />' . "\n";
}

/**
 * This function adds dublin core meta in header
 */
function calibrefx_do_fb_og() {

    if( !current_theme_supports( 'calibrefx-open-graph' ) ) return;

    echo '<meta property="locale" content="' . calibrefx_og_locale() . '" />'."\n";
    echo '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '" />'."\n";
    
    if ( calibrefx_get_option( 'facebook_admins' ) ) echo '<meta property="fb:admins" content="' . calibrefx_get_option( 'facebook_admins' ) . '" />'."\n";
    if ( calibrefx_get_option( 'facebook_og_type' ) ) echo '<meta property="og:type" content="' . calibrefx_get_option( 'facebook_og_type' ) . '" />'."\n";
    
    echo '<meta property="og:title" content="' . calibrefx_og_title() . '" />'."\n";
    echo '<meta property="og:url" content="' . calibrefx_og_url() . '" />'."\n";
    echo '<meta property="og:description" content="' . calibrefx_og_description() . '" />'."\n";
    
    $image = calibrefx_og_image();
    if ( $image) {
        echo '<meta property="og:image" content="' . $image . '" />'."\n";
    }
	
	do_action( 'calibrefx_do_another_fb_og' );
}

/**
 * Echo the header scripts, defined in Theme Settings.
 */
function calibrefx_header_scripts() {
    echo apply_filters( 'calibrefx_header_scripts', stripslashes( calibrefx_get_option( 'header_scripts' ) ) );
}

/**
 * Echo the header custom styles, defined in Theme Settings.
 */
function calibrefx_header_custom_styles() {
    $custom_css = stripslashes( calibrefx_get_option( 'custom_css' ) );
    if ( !empty( $custom_css ) ) {
        printf( '<style type="text/css">%1$s</style>', apply_filters( 'calibrefx_header_custom_styles', $custom_css) );
    }

    // If singular, echo scripts from custom field
    if ( is_singular() ) {
        printf( '<style type="text/css">%1$s</style>', calibrefx_custom_field( '_calibrefx_custom_styles' ) );
    }
}

add_action( 'calibrefx_site_title', 'calibrefx_do_site_title' );

/**
 * Echo the site title into the #header.
 *
 */
function calibrefx_do_site_title() {

    // Set what goes inside the wrapping tags
    $inside = sprintf( '<a href="%s" title="%s">%s</a>', trailingslashit( home_url() ), esc_attr( get_bloginfo( 'name' ) ), get_bloginfo( 'name' ) );

    // Build the Title
    if ( is_home() ||is_front_page() ) {
        $title = sprintf( '<h1 id="title">%s</h1>', $inside );
    } else {
        $title = sprintf( '<h2 id="title">%s</h2>', $inside );
    }

    echo apply_filters( 'calibrefx_seo_title', $title, $inside, $wrap = '' );
}

add_action( 'calibrefx_site_description', 'calibrefx_do_site_description' );

/**
 * Echo the site description into the #header.
 *
 */
function calibrefx_do_site_description() {
    // Set what goes inside the wrapping tags
    $inside = esc_html(get_bloginfo( 'description' ) );

    // Determine which wrapping tags to use
    $wrap = 'p';

    // Build the Description
    $description = $inside ? sprintf( '<%s id="description">%s</%s>', $wrap, $inside, $wrap ) : '';

    // Return (filtered)
    echo apply_filters( 'calibrefx_seo_description', $description, $inside, $wrap );
}

/**
 * Markup the header area
 */
function calibrefx_header_area() {
    echo '<div id="header">';
    calibrefx_put_wrapper( 'header', 'open' );
    calibrefx_do_header();
    calibrefx_put_wrapper( 'header', 'close' );
    echo '</div><!--end #header-->';
}

/**
 * Do Header Callback
 */
function calibrefx_do_header() {
    $header_title_class = apply_filters( 'header_title_class', 'pull-left', '' );
    echo '<div id="header-title" class="' . $header_title_class . '">';
    do_action( 'calibrefx_site_title' );
    do_action( 'calibrefx_site_description' );
    echo '</div><!-- end #header-title -->';

    $header_right_widget = current_theme_supports( 'calibrefx-header-right-widgets' );
    $header_right_class = apply_filters( 'header_right_class', 'pull-right', '' );
    
    if ( $header_right_widget ) {
       echo '<div id="header-right" class="' . $header_right_class . '">';
       do_action( 'calibrefx_header_right_widget' );
       echo '</div><!-- end #header-right -->';
    }
}

/**
 * Print header right widget
 */
function calibrefx_do_header_right_widget() {
    if ( is_active_sidebar( 'header-right' ) ) {
        dynamic_sidebar( 'header-right' );
    }
}
add_action( 'calibrefx_header_right_widget', 'calibrefx_do_header_right_widget' );


/**
 * Filter the feed URI if the user has input a custom feed URI.
 */
function calibrefx_feed_links_filter( $output, $feed ) {
    $feed_uri = calibrefx_get_option( 'feed_uri' );
    $comments_feed_uri = calibrefx_get_option( 'comments_feed_uri' );

    if ( $feed_uri && !strpos( $output, 'comments' ) && ( '' == $feed || 'rss2' == $feed || 'rss' == $feed || 'rdf' == $feed || 'atom' == $feed ) ) {
        $output = esc_url( $feed_uri );
    }

    if ( $comments_feed_uri && strpos( $output, 'comments' ) ) {
        $output = esc_url( $comments_feed_uri );
    }

    return $output;
}
add_filter( 'feed_link', 'calibrefx_feed_links_filter', 10, 2 );

/**
 * Show Feed Meta
 */
function calirbefx_show_feeds_meta() {
    echo "\n".'<link rel="alternate" type="application/rss+xml" title="' . get_bloginfo( 'name' ) . ' ' . __("RSS Feed", 'calibrefx' ) . '" href="' . get_bloginfo( 'rss2_url' ) . '" />'."\n";
    echo '<link rel="alternate" type="application/atom+xml" title="' . get_bloginfo( 'name' ) . ' ' . __("Atom Feed", 'calibrefx' ) . '" href="' . get_bloginfo( 'atom_url' ) . '" />'."\n";
    echo '<link rel="alternate" type="application/rss+xml" title="' . get_bloginfo( 'name' ) . ' ' . __("Comment Feed", 'calibrefx' ) . '" href="' . get_bloginfo( 'comments_rss2_url' ) . '" />'."\n";
}