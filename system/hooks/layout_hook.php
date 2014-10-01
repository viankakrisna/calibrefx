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
 * Calibrefx Layout Hooks
 *
 * @package     Calibrefx
 * @subpackage  Hook
 * @author      CalibreFx Team
 * @since       Version 1.0
 * @link        http://www.calibrefx.com
 */

global $cfxgenerator;

$cfxgenerator->init = array(
    array( 'function' => 'calibrefx_custom_background', 'priority' => 0 ), 
    array( 'function' => 'calibrefx_custom_header', 'priority' => 5 )
);

$cfxgenerator->calibrefx_init = array(
    array( 'function' => 'calibrefx_setup_layout', 'priority' => 0 )
);

$cfxgenerator->calibrefx_wrapper = array(
    array( 'function' => 'calibrefx_do_open_wrapper', 'priority' => 0 )
);

$cfxgenerator->calibrefx_after_wrapper = array(
    array( 'function' => 'calibrefx_do_close_wrapper','priority'  => 99 )
);

$cfxgenerator->calibrefx_inner = array(
    array( 'function' => 'calibrefx_do_open_inner', 'priority' => 0 )
);

$cfxgenerator->calibrefx_after_inner = array(
    array( 'function' => 'calibrefx_do_close_inner','priority'  => 99 )
);

$cfxgenerator->calibrefx_after_content = array(
    array( 'function' => 'calibrefx_get_sidebar', 'priority' => 10 )
);

$cfxgenerator->calibrefx_before_content = array(
    array( 'function' => 'calibrefx_get_sidebar_alt', 'priority' => 10 )
);

$cfxgenerator->calibrefx_sidebar = array(
    array( 'function' => 'calibrefx_do_sidebar', 'priority' => 10 )
);

$cfxgenerator->calibrefx_sidebar_alt = array(
    array( 'function' => 'calibrefx_do_sidebar_alt', 'priority' => 10 )
);

$cfxgenerator->get_header = array(
    array( 'function' => 'calibrefx_setup_custom_layout','priority' => 0 ),
    array( 'function' => 'calibrefx_header_body_classes_filter','priority' => 0 )
);

/********************
 * FUNCTIONS BELOW  *
 ********************/

function calibrefx_setup_custom_layout() {
    global $cfxgenerator;

    $site_layout = calibrefx_site_layout();

    if( $site_layout == 'sidebar-content-sidebar' ) {
        $cfxgenerator->move( 'calibrefx_before_content', 'calibrefx_after_content', 'calibrefx_get_sidebar_alt', 15);
        
        add_action( 'calibrefx_before_content','calibrefx_sidebar_content_sidebar_wrapper_open' );
        add_action( 'calibrefx_after_content','calibrefx_sidebar_content_sidebar_wrapper_close' );
    }
}

/**
 * Open #wrapper div
 */
function calibrefx_do_open_wrapper() {
    global $calibrefx;

    $wrapper_class = apply_filters( 'wrapper_class', 'container' );
    echo '<div id="wrapper" class="'.$wrapper_class.'">';
    $calibrefx->is_wrapper_open = true;
}

add_filter( 'wrapper_class', 'calibrefx_wrapper_class' );
function calibrefx_wrapper_class(){

    if( calibrefx_layout_is_fluid() ){
        return 'container-fluid';
    } elseif ( calibrefx_layout_is_fixed_wrapper() ) {
        return 'container';
    }

    return '';
}

/**
 * Open #inner div
 */
function calibrefx_do_close_wrapper() {
    global $calibrefx;

    if(isset( $calibrefx->is_wrapper_open ) ) {
        echo '</div><!-- end #wrapper -->';
    }
}

/**
 * Open #inner div
 */
function calibrefx_do_open_inner() {
    global $calibrefx;

    $inner_class = apply_filters( 'inner_class', '' );
    echo '<div id="inner" class="'.$inner_class.'">';
    $calibrefx->is_inner_open = true;

}

/**
 * Open #inner div
 */
function calibrefx_do_close_inner() {
    global $calibrefx;

    if( isset( $calibrefx->is_inner_open ) ) {
        echo '</div><!-- end #inner -->';
    }
}

function calibrefx_sidebar_content_sidebar_wrapper_open() {
    echo '<div id="content-sidebar" class="' . calibrefx_content_sidebar_span() . '"><div class="' . calibrefx_row_class() . '">';
}

function calibrefx_sidebar_content_sidebar_wrapper_close() {
    echo '</div></div>';
}


/**
 * Register all the available layout
 *
 * @access public
 * @return void
 */
function calibrefx_setup_layout() {

    calibrefx_register_layout(
            'content-sidebar', array(
                'label' => __( 'Content Sidebar (default blog)', 'calibrefx' ),
                'img' => CALIBREFX_IMAGES_URL . '/layouts/cs.gif',
                'default' => true
            )
    );
    calibrefx_register_layout(
            'full-width-content', array(
                'label' => __( 'Full Width Content (minisite)', 'calibrefx' ),
                'img' => CALIBREFX_IMAGES_URL . '/layouts/c.gif' 
            )
    );
    calibrefx_register_layout(
            'sidebar-content', array(
                'label' => __( 'Sidebar Content', 'calibrefx' ),
                'img' => CALIBREFX_IMAGES_URL . '/layouts/sc.gif' 
            )
    );
    calibrefx_register_layout(
            'sidebar-content-sidebar', array(
                'label' => __( 'Sidebar Content Sidebar', 'calibrefx' ),
                'img' => CALIBREFX_IMAGES_URL . '/layouts/scs.gif' 
            )
    );
}

/**
 * This function will show sidebar after the content
 */
function calibrefx_get_sidebar() {

    // get the layout
    $site_layout = calibrefx_site_layout();

    // don't load sidebar on pages that don't need it
    if ( $site_layout == 'full-width-content' )
        return;

    // output the primary sidebar
    get_sidebar();
}

/**
 * This function will show sidebar after the content
 */
function calibrefx_get_sidebar_alt() {

    // get the layout
    $site_layout = calibrefx_site_layout();

    // don't load sidebar on pages that don't need it
    if ( $site_layout == 'full-width-content' ||
            $site_layout == 'content-sidebar' ||
            $site_layout == 'sidebar-content' )
        return;

    // output the primary sidebar
    get_sidebar( 'alt' );
}

/**
 * Primary Sidebar Content
 */
function calibrefx_do_sidebar() {

    if ( !dynamic_sidebar( 'sidebar' ) ) {

        $output = '<div class="widget widget_text"><div class="widget-wrap">';
        $output .= '<h4 class="widgettitle">';
        $output .= __( 'Primary Sidebar Widget Area', 'calibrefx' );
        $output .= '</h4>';
        $output .= '<div class="textwidget"><p>';
        $output .= sprintf(__( 'This is the Primary Sidebar Widget Area. You can add content to this area by visiting your <a href="%s">Widgets Panel</a> and adding new widgets to this area.', 'calibrefx' ), admin_url( 'widgets.php' ) );
        $output .= '</p></div>';
        $output .= '</div></div>';
        
        echo apply_filters( 'calibrefx_sidebar_default', $output );
    }
}

/**
 * Alternate Sidebar Content
 */
function calibrefx_do_sidebar_alt() {

    if ( !dynamic_sidebar( 'sidebar-alt' ) ) {

        $output = '<div class="widget widget_text"><div class="widget-wrap">';
        $output .=  '<h4 class="widgettitle">';
        $output .= __( 'Secondary Sidebar Widget Area', 'calibrefx' );
        $output .=  '</h4>';
        $output .=  '<div class="textwidget"><p>';
        $output .= sprintf(__( 'This is the Secondary Sidebar Widget Area. You can add content to this area by visiting your <a href="%s">Widgets Panel</a> and adding new widgets to this area.', 'calibrefx' ), admin_url( 'widgets.php' ) );
        $output .=  '</p></div>';
        $output .=  '</div></div>';
        
        echo apply_filters( 'calibrefx_sidebar_alt_default', $output );
    }
}

/**
 * This function will activate the custom background from WordPress
 *
 * It gets arguments passed through add_theme_support(), defines the constants,
 * and calls calibrefx_custom_background().
 *
 * @return void
 */
function calibrefx_custom_background() {

    $custom_background = get_theme_support( 'calibrefx-custom-background' );

    /** If not active, do nothing */
    if ( !$custom_background ) {
        return;
    }

    $args = apply_filters( 'calibrefx_custom_background_args', array( 'default-color' => 'EDEDEB' ) );
    
    add_theme_support( 'custom-background', $args );
}

/**
 * This function/filter adds custom body class(es) to the
 * body class array. 
 */
function calibrefx_layout_body_class( $classes) {

    $site_layout = calibrefx_site_layout();

    //add css class to the body class array
    if ( $site_layout ) {
        $classes[] = $site_layout;
    }

    if ( calibrefx_layout_is_fixed_wrapper() && calibrefx_layout_is_static() ) {
        $classes[] = 'layout-wrapper-fixed';
    } elseif ( calibrefx_layout_is_static() && !calibrefx_layout_is_fixed_wrapper() ) {
        $classes[] = 'layout-wrapper-fluid';
    }

    return $classes;
}
add_filter( 'body_class', 'calibrefx_layout_body_class' );

/**
 * Add class row/row-fluid to post
 */
function calibrefx_post_class( $classes) {

    $custom_post = calibrefx_get_custom_field( '_calibrefx_custom_post_class' );
    if ( !empty( $custom_post ) ) {
        $classes[] = $custom_post;
    }

    return $classes;
}
add_filter( 'post_class', 'calibrefx_post_class' );

/**
 * This function/filter adds new classes to the <body>
 * so that we can use psuedo-variables in our CSS file,
 * which helps us achieve multiple header layouts with minimal code
 *
 * @since 0.2.2
 */
function calibrefx_header_body_classes( $classes ) {

    // add header classes to $classes array
    if ( !is_active_sidebar( 'header-right' ) ) {
        $classes[] = 'header-full-width';
    }

    if ( current_theme_supports( 'calibrefx-custom-header' ) && ( 'image' == calibrefx_get_option( 'blog_title' ) || 'blank' == get_header_textcolor() ) ) {
        $classes[] = 'header-image';
    }
    
    if ( calibrefx_is_responsive_enabled() ) {
        $classes[] = 'responsive';
    } else {
        $classes[] = 'non-responsive'; 
    }   

    if ( calibrefx_layout_is_fluid() ) {
        $classes[] = 'fluid';
    } else {
       $classes[] = 'static'; 
    }

    $custom_body = calibrefx_get_custom_field( '_calibrefx_custom_body_class' );
    if ( !empty( $custom_body ) ) {
        $classes[] = $custom_body;
    }
    // return filtered $classes
    return $classes;
}

function calibrefx_header_body_classes_filter() {
    add_filter( 'body_class', 'calibrefx_header_body_classes' );  
}

/**
 * This function will activate the custom header image from WordPress
 *
 * It gets arguments passed through add_theme_support(), defines the constants,
 * and calls add_custom_image_header().
 *
 * @return void
 */
function calibrefx_custom_header() {

    $custom_header = get_theme_support( 'calibrefx-custom-header' );
    /** If not active, do nothing */
    if ( !$custom_header ) {
        return;
    }

    /** Blog title option is obsolete when custom header is active */
    add_filter( 'calibrefx_pre_get_option_blog_title', '__return_empty_array' );

    /** Cast, if necessary */
    $custom_header = isset( $custom_header[0] ) && is_array( $custom_header[0] ) ? $custom_header[0] : array();

    /** Merge defaults with passed arguments */
    $args = wp_parse_args( $custom_header, array(
        'width' => 260,
        'height' => 100,
        'default-text-color' => '333333',
        'default-image' => CALIBREFX_IMAGES_URL . '/header.png',
        'header-text' => true,
        'wp-head-callback' => 'calibrefx_custom_header_style',
        'admin-head-callback' => 'calibrefx_custom_header_admin_style'
            ) );

    /** Define all the constants */
    if ( !defined( 'HEADER_IMAGE_WIDTH' ) && is_numeric( $args['width']) ) {
        define( 'HEADER_IMAGE_WIDTH', apply_filters( 'calibrefx_header_logo_width', $args['width'] ) );
    }

    if ( !defined( 'HEADER_IMAGE_HEIGHT' ) && is_numeric( $args['height']) ) {
        define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'calibrefx_header_logo_height', $args['height'] ) );
    }

    if ( !defined( 'HEADER_TEXTCOLOR' ) && $args['default-text-color'] ) {
        define( 'HEADER_TEXTCOLOR', apply_filters( 'calibrefx_header_text_color', $args['default-text-color']) );
    }

    if ( !defined( 'HEADER_TEXT' ) && $args['header-text'] ) {
        define( 'HEADER_TEXT', apply_filters( 'calibrefx_header_text', $args['header-text'] ) );
    }

    if ( !defined( 'HEADER_IMAGE' ) && $args['default-image'] ) {
        define( 'HEADER_IMAGE', apply_filters( 'calibrefx_header_logo_url', $args['default-image'] ) );
    }
        
    $custom_header_args = array(
        'width' => HEADER_IMAGE_WIDTH,
        'height' => HEADER_IMAGE_HEIGHT,
        'default-text-color' => HEADER_TEXTCOLOR,
        'default-image' => HEADER_IMAGE,
        'header-text' => HEADER_TEXT,
        'wp-head-callback' => 'calibrefx_custom_header_style',
        'admin-head-callback' => 'calibrefx_custom_header_admin_style'
    );

    /** Activate Custom Header */
    add_theme_support( 'custom-header', $custom_header_args );
}

/**
 * Header callback. It outputs special CSS to the document
 * head, modifying the look of the header based on user input.
 *
 */
function calibrefx_custom_header_style() {
    $header = '';
    $text = '';

    /** If no options set, don't waste the output. Do nothing. */
    if( ( HEADER_IMAGE == '' && get_header_image() == '' ) || ( HEADER_TEXTCOLOR != 'blank' && get_header_textcolor() != 'blank' ) || ( HEADER_TEXT && display_header_text() ) ) {
       $text = sprintf( '
#title, #title a{ 
    color: %s
}'."\n", get_header_textcolor() );
    }else{
        $header = sprintf( '
#header-title { 
    background: url(%1$s) no-repeat left center; 
    width: %2$spx; 
    height: %3$dpx
}', esc_url( get_header_image() ), HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT );
    
        $text = sprintf( '
#title, #title a, #title a:hover{ 
    display: block; 
    margin: 0; 
    overflow: hidden; 
    padding: 0;
    text-indent: -9999px; 
    width: %dpx; 
    height: %dpx 
}'."\n", HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT );
    }

    printf( '<style type="text/css">%1$s %2$s</style>'."\n", $header, $text );
}

/**
 * Header admin callback. It outputs special CSS to the admin
 * document head, modifying the look of the header area based on user input.
 *
 * Will probably need to be overridden in the child theme with a custom callback.
 */
function calibrefx_custom_header_admin_style() {

    $headimg = sprintf( '.appearance_page_custom-header #headimg { background: url(%s) no-repeat; min-height: %spx; }', get_header_image(), HEADER_IMAGE_HEIGHT );
    $h1 = sprintf( '#headimg h1, #headimg h1 a { color: #%s; font-size: 24px; font-weight: normal; line-height: 30px; margin: 20px 0 0; text-decoration: none; }', esc_html(get_header_textcolor() ) );
    $desc = sprintf( '#headimg #desc { color: #%s; font-size: 12px; font-style: italic; line-height: 1; margin: 0; }', esc_html(get_header_textcolor() ) );

    printf( '<style type="text/css">%1$s %2$s %3$s</style>', $headimg, $h1, $desc );
}

/**
 * Using a filter, we're replacing the default search form structure
 */
function calibrefx_search_form() {

    $search_text = get_search_query() ? esc_attr( apply_filters( 'the_search_query', get_search_query() ) ) : apply_filters( 'calibrefx_search_text', sprintf( esc_attr__( 'Search this website %s', 'calibrefx' ), '&hellip;' ) );

    $button_text = apply_filters( 'calibrefx_search_button_text', esc_attr__( 'Search', 'calibrefx' ) );

    $onfocus = " onfocus=\"if (this.value == '$search_text' ) {this.value = '';}\"";
    $onblur = " onblur=\"if (this.value == '' ) {this.value = '$search_text';}\"";

    $form = '
        <form method="get" class="searchform" action="' . home_url() . '/" >
            <div class="input-group">
                <input type="text" value="' . $search_text . '" name="s" class="s form-control"' . $onfocus . $onblur . ' />
                <span class="input-group-btn">
                    <input type="submit" class="searchsubmit btn btn-primary" value="' . $button_text . '" />
                </span>
            </div>
        </form>
    ';
    
    return apply_filters( 'calibrefx_search_form', $form, $search_text, $button_text );
}
add_filter( 'get_search_form', 'calibrefx_search_form' );
