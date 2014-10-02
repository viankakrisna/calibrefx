<?php defined( 'CALIBREFX_URL' ) OR exit();
/**
 * CalibreFx Framework
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package     CalibreFx
 * @author      CalibreFx Team 
 * @copyright   Copyright (c) 2012-2013, Calibreworks. (http://www.calibreworks.com/)
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
 * Calibrefx Mobile Hooks
 *
 * @package		Calibrefx
 * @subpackage  Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

global $cfxgenerator;

$cfxgenerator->calibrefx_setup = array(
    array( 'function' => 'calibrefx_detect_mobile_browser','priority' => 15 )
);

/********************
 * FUNCTIONS BELOW  *
 ********************/

/**
 * If mobile site is enable and there is a mobile template, then display mobile layout on mobile
 */
function calibrefx_detect_mobile_browser() {
	global $calibrefx; 

    if( is_admin() || !wp_is_mobile() ) {
        return;
    }

    if( !get_theme_support( 'mobile-site' ) OR !calibrefx_mobile_themes_exist() ) {
        return;
    }
    
	add_filter( 'body_class', 'calibrefx_mobile_body_class' );
    
	remove_action( 'calibrefx_after_header', 'calibrefx_do_nav' );

    if( get_theme_support( 'mobile-site-menu' ) ) {
        add_action( 'calibrefx_before_header', 'calibrefx_do_top_mobile_nav' ); 

        add_action( 'calibrefx_before_wrapper', 'calibrefx_mobile_open_nav' ); 
        add_action( 'calibrefx_after_wrapper', 'calibrefx_mobile_close_nav' ); 
    }

	add_filter( 'template_include', 'calibrefx_get_mobile_template' );

	if( file_exists(CHILD_MOBILE_URI . '/mobile.php' ) ) {
		include_once CHILD_MOBILE_URI . '/mobile.php';
	}
}


function calibrefx_mobile_body_class( $body_classes ) {
    global $post;
    
    $body_classes[] = 'mobile mobile-site';

    return $body_classes;
}

function calibrefx_do_top_mobile_nav() {
	?>
	<div id="top-mobile-nav" class="navbar navbar-default">
        <div class="mobile-header-top">
        	<a href="#m" class="mobile-main-menu"> <i class="icon-mobile-planning"></i> Menu</a>
        </div>
    </div>
	<?php
}


function calibrefx_mobile_open_nav() {
	?>
	<div id="super-wrapper">
		<div class="mobile-sidebar">
			<?php calibrefx_do_mobile_nav(); ?>
		</div>

	<?php
}


function calibrefx_mobile_close_nav() {
	?>
	</div>
	<?php
}

function calibrefx_do_mobile_nav() {
    global $calibrefx;
    /** Do nothing if menu not supported */
    if ( !calibrefx_nav_menu_supported( 'primary' ) ) {
        return;
    }
    
    $calibrefx->load->library( 'walker_nav_menu' );

    $nav = '';
    $args = '';
        
    $args = array(
        'menu' => 'mobile-menu',
        'container' => '',
        'menu_class' => calibrefx_get_option( 'nav_fixed_top' ) ? 'navbar navbar-default navbar-fixed-top menu-primary menu ' : 'nav navbar-nav menu-primary menu ',
        'echo' => 0,
        'walker' => $calibrefx->walker_nav_menu,
    );
    
    $nav = wp_nav_menu( $args );

    $nav_class = apply_filters( 'nav_class', calibrefx_row_class() );

    $nav_output = sprintf( '
        <div id="mobile-nav" class="navbar navbar-default">
             %1$s
        </div>
        <!-- end #mobile-nav -->', $nav );

    echo apply_filters( 'calibrefx_do_nav', $nav_output, $nav, $args );
    
}