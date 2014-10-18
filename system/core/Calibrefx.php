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

final class Calibrefx {

    /**
     * Reference to the global Plugin instance
     *
     * @var	object
     */
    protected static $instance;

    /**
     * Return the Calibrefx object
     *
     * @return	object
     */

    public static function get_instance() {
        $instance = wp_cache_get( 'calibrefx' );
        if ( $instance === TRUE ) {
            self::$instance = $instance;
        } elseif ( self::$instance === null ) {
            self::$instance = new Calibrefx();
        }
        
        return self::$instance;
    }

    /**
     * Constructor
     */
    function __construct() {
        self::$instance = $this;

        $this->config = calibrefx_load_class( 'Config', 'core' );
        $this->load = calibrefx_load_class( 'Loader', 'core' );
        //Since admin is abstract we don't instantiate
        calibrefx_load_class( 'Admin', 'core' );
        
        $this->load_theme_support();
        load_theme_textdomain( 'calibrefx', CALIBREFX_LANG_URI );

        calibrefx_log_message( 'debug', 'Calibrefx Class Initialized' );
    }

    /**
     * Add our calibrefx theme support
     */
    public function load_theme_support() {
        add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
        add_theme_support( 'menus' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'post-thumbnails' );

        add_theme_support( 'calibrefx-admin-menu' );
        add_theme_support( 'calibrefx-custom-header' );
        add_theme_support( 'calibrefx-custom-background' );
        add_theme_support( 'calibrefx-default-styles' );
        add_theme_support( 'calibrefx-inpost-layouts' );
        add_theme_support( 'calibrefx-responsive-style' );
        add_theme_support( 'calibrefx-open-graph' );
        add_theme_support( 'calibrefx-footer-widgets' );
        add_theme_support( 'calibrefx-header-right-widgets' );
        add_theme_support( 'mobile-site-menu' );

        if ( !current_theme_supports( 'calibrefx-menus' ) ) {
            add_theme_support( 'calibrefx-menus', 
                array(
                    'primary'   => __( 'Primary Navigation Menu', 'calibrefx' ),
                    'secondary' => __( 'Secondary Navigation Menu', 'calibrefx' )
                )
            );
        }

        $menus = get_theme_support( 'calibrefx-menus' );
        foreach ( $menus as $menu ) {
            register_nav_menus( $menu);
        }

        if ( !current_theme_supports( 'calibrefx-wraps' ) ){
            add_theme_support( 'calibrefx-wraps', 
                array( 'header', 'nav', 'subnav', 'inner', 'footer', 'footer-widget' ) );
        }
        
        if( is_admin() ) {
            if ( current_theme_supports( 'calibrefx-admin-bar' ) ) {
                $this->load->hook( 'admin_bar' );
            }
        }

        //@TODO: Will do in better ways for custom post type
        add_post_type_support( 'post', array( 'calibrefx-seo', 'calibrefx-layouts' ) );
        add_post_type_support( 'page', array( 'calibrefx-seo', 'calibrefx-layouts' ) );

        if ( ! isset( $content_width ) ) {
            $content_width = apply_filters( 'calibrefx_content_width', 550 );
        }
    }

    public function run() {
        
        /** Run the calibrefx_pre_init hook */
        do_action( 'calibrefx_pre_init' );

        /** Run the calibrefx_init hook */
        do_action( 'calibrefx_init' );

        /** Run the calibrefx_post_init hook */
        do_action( 'calibrefx_post_init' );

        /** Run the calibrefx_setup hook */
        do_action( 'calibrefx_setup' );
    }
}