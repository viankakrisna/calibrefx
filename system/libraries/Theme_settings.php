<?php 
defined( 'CALIBREFX_URL' ) OR exit();
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
 * Calibrefx Theme Setting Class
 *
 * @package		Calibrefx
 * @subpackage          Library
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */
class CFX_Theme_Settings extends CFX_Admin {

    /**
     * Constructor - Initializes
     */
    function __construct() {
        $this->page_id = 'calibrefx';
        $this->default_settings = apply_filters( 'calibrefx_theme_settings_defaults', array(
            'update' => 1,
            'blog_title' => 'text',
            'header_right' => 0,
            'layout_type' => 'static',
            'calibrefx_layout_width' => 960,
            'calibrefx_layout_wrapper_fixed' => 0,
            'site_layout' => calibrefx_get_default_layout(),
            'nav' => 1,
            'subnav' => 0,
            'breadcrumb_home' => 1,
            'breadcrumb_single' => 1,
            'breadcrumb_page' => 1,
            'breadcrumb_archive' => 1,
            'breadcrumb_404' => 1,
            'comments_pages' => 0,
            'comments_posts' => 1,
            'trackbacks_pages' => 0,
            'trackbacks_posts' => 1,
            'custom_css' => '',
            'content_archive' => 'full',
            'content_archive_limit' => 0,
            'posts_nav' => 'older-newer',
            'header_scripts' => '',
            'footer_scripts' => '',
            'enable_mobile' => 0,
            'calibrefx_version' => FRAMEWORK_VERSION,
            'calibrefx_db_version' => FRAMEWORK_DB_VERSION)
        );

        //we need to initialize the model
        global $calibrefx;
        $calibrefx->load->model( 'theme_settings_m' );
        $this->_model = $calibrefx->theme_settings_m;

        $this->initialize();
    }

    /**
     * Register Our Security Filters
     *
     * $return void
     */
    public function security_filters() {
        global $calibrefx;

        $calibrefx->security->add_sanitize_filter(
                'one_zero', $this->settings_field, array(
                    'update',
                    'calibrefx_layout_wrapper_fixed',
                    'header_right',
                    'nav',
                    'subnav',
                    'breadcrumb_home',
                    'breadcrumb_single',
                    'breadcrumb_page',
                    'breadcrumb_archive',
                    'breadcrumb_404',
                    'comments_posts',
                    'comments_pages',
                    'trackbacks_posts',
                    'trackbacks_pages' )
                );

        $calibrefx->security->add_sanitize_filter(
                'safe_text', $this->settings_field, array(
                    'blog_title',
                    'calibrefx_version',
                    'calibrefx_db_version',
                    'posts_nav',
                    'content_archive',
                    'layout_type',
                    'site_layout' )
                );

        $calibrefx->security->add_sanitize_filter(
                'integer', $this->settings_field, array(
                    'calibrefx_layout_width',
                    'content_archive_limit',
                    'calibrefx_db_version' )
                );
    }

    public function meta_sections() {
        global $calibrefx_current_section, $calibrefx_target_form, $calibrefx_user_ability;

        $calibrefx_target_form = apply_filters( 'calibrefx_target_form', 'options.php' );

        calibrefx_clear_meta_section();

        calibrefx_add_meta_section( 'general', __( 'General Settings', 'calibrefx' ), $calibrefx_target_form, 1);
        calibrefx_add_meta_section( 'layout', __( 'Layout Settings', 'calibrefx' ), $calibrefx_target_form,2);
        calibrefx_add_meta_section( 'social', __( 'Social Settings', 'calibrefx' ), $calibrefx_target_form,10);    

        do_action( 'calibrefx_theme_settings_meta_section' );

        $calibrefx_current_section = 'general';
        if (!empty( $_GET['section']) ) {
            $calibrefx_current_section = sanitize_text_field( $_GET['section']);
        }
    }

    public function meta_boxes() {
        calibrefx_add_meta_box( 'general', 'basic', 'calibrefx-theme-settings-content', __( 'Content Setting', 'calibrefx' ), array( $this, 'content_setting' ), $this->pagehook, 'main' );
        calibrefx_add_meta_box( 'general', 'basic', 'calibrefx-theme-settings-navigation', __( 'Navigation Settings', 'calibrefx' ), array( $this, 'navigation_box' ), $this->pagehook, 'main', 'high' );
        calibrefx_add_meta_box( 'general', 'basic', 'calibrefx-theme-settings-comment', __( 'Post Comment Setting', 'calibrefx' ), array( $this, 'comment_setting' ), $this->pagehook, 'main' );
        calibrefx_add_meta_box( 'general', 'basic', 'calibrefx-theme-settings-tracking', __( 'Website Tracking Setting', 'calibrefx' ), array( $this, 'tracking_setting' ), $this->pagehook, 'main' );

        calibrefx_add_meta_box( 'layout', 'basic', 'calibrefx-theme-settings-layout', __( 'Website Layout Settings', 'calibrefx' ), array( $this, 'layout_box' ), $this->pagehook, 'main', 'high' );
        calibrefx_add_meta_box( 'layout', 'basic', 'calibrefx-theme-settings-custom-script', __( 'Themes Advanced Customization', 'calibrefx' ), array( $this, 'custom_script_box' ), $this->pagehook, 'main', 'low' );

        calibrefx_add_meta_box( 'social', 'basic', 'calibrefx-theme-settings-socials', __( 'Social Integration', 'calibrefx' ), array( $this, 'socials_integrated_box' ), $this->pagehook, 'main' );

        do_action( 'calibrefx_theme_settings_meta_box' );
    }

    public function hidden_fields() {
        ?>
        <input type="hidden" name="<?php echo $this->settings_field; ?>[calibrefx_version]>" value="<?php echo esc_attr(calibrefx_get_option( 'calibrefx_version', $this->_model) ); ?>" />
        <input type="hidden" name="<?php echo $this->settings_field; ?>[calibrefx_db_version]>" value="<?php echo esc_attr(calibrefx_get_option( 'calibrefx_db_version', $this->_model) ); ?>" />
        <?php
    }

    //Meta Boxes Sections
    /**
     * Show navigation setting box
     */
    function navigation_box() {
        global $calibrefx;

        calibrefx_add_meta_group( 'themenavigation-settings', 'navigation-settings', __( 'Menu Settings', 'calibrefx' ) );

        add_action( 'themenavigation-settings_options', function() {            
            calibrefx_add_meta_option(
                'navigation-settings',  // group id
                'nav', // field id and option name
                __( 'Primary Navigation' ), // Label
                array(
                    'option_type' => 'checkbox',
                    'option_items' => '1',
                    'option_default' => '',
                    'option_filter' => 'integer',
                    'option_description' => __("You can assign primary menu from the Apperances > Menu", 'calibrefx' ),
                ), // Settings config
                1 //Priority
            );

            calibrefx_add_meta_option(
                'navigation-settings',  // group id
                'subnav', // field id and option name
                __( 'Secondary Navigation' ), // Label
                array(
                    'option_type' => 'checkbox',
                    'option_items' => '1',
                    'option_default' => '',
                    'option_filter' => 'integer',
                    'option_description' => __("You can assign secondary menu from the Apperances > Menu", 'calibrefx' ),
                ), // Settings config
                1 //Priority
            );
        });

        calibrefx_do_meta_options( $calibrefx->theme_settings, 'themenavigation-settings' );
    }

    /**
     * Show google analytic setting box
     */
    function tracking_setting() {
        global $calibrefx;

        calibrefx_add_meta_group( 'themetracking-settings', 'google-analytics-settings', __( 'Google Anlytic Settings', 'calibrefx' ) );
        calibrefx_add_meta_group( 'themetracking-settings', 'facebook-tracking-settings', __( 'Facebook Tracking Settings', 'calibrefx' ) );

        add_action( 'themetracking-settings_options', function() {            
            calibrefx_add_meta_option(
                'google-analytics-settings',  // group id
                'analytic_id', // field id and option name
                __( 'Google Analytics ID' ), // Label
                array(
                    'option_type' => 'textinput',
                    'option_default' => '',
                    'option_filter' => 'no_html',
                    'option_description' => __("Enter your google analytics ID, example: <strong>UA-xxxxxxxx-x</strong>", 'calibrefx' ),
                ), // Settings config
                1 //Priority
            );

            calibrefx_add_meta_option(
                'google-analytics-settings',  // group id
                'google_tagmanager_code', // field id and option name
                __( 'Paste your Google Tag Manager Script' ), // Label
                array(
                    'option_type' => 'textarea',
                    'option_default' => '',
                    'option_filter' => 'no_filter',
                    'option_description' => __("Learn more about Google Tag Manager <a href='http://www.google.com/tagmanager/get-started.html' target='_blank'>here</a>", 'calibrefx' ),
                ), // Settings config
                5 //Priority
            );
        });

        add_action( 'themetracking-settings_options', function() {            
            calibrefx_add_meta_option(
                'facebook-tracking-settings',  // group id
                'facebook_tracking_code', // field id and option name
                __( 'Paste your Facebook conversion pixels' ), // Label
                array(
                    'option_type' => 'textarea',
                    'option_default' => '',
                    'option_filter' => 'no_filter',
                    'option_description' => __("Learn more about Facebook conversion pixel <a href='https://www.facebook.com/help/435189689870514/' target='_blank'>here</a>", 'calibrefx' ),
                ), // Settings config
                1 //Priority
            );
        });

        calibrefx_do_meta_options( $calibrefx->theme_settings, 'themetracking-settings' );
    }

    /**
     * Show content box
     */
    function content_setting() {
        global $calibrefx;

        calibrefx_add_meta_group( 'content-settings', 'breadcrumb-settings', __( 'Breadcrumb Settings', 'calibrefx' ) );
        calibrefx_add_meta_group( 'content-settings', 'content-archives-settings', __( 'Category Page Settings', 'calibrefx' ) );
        calibrefx_add_meta_group( 'content-settings', 'post-navigation-settings', __( 'Post Navigation Settings', 'calibrefx' ) );
        
        //For breadcrumb settings        
        add_action( 'content-settings_options', function() {            
            calibrefx_add_meta_option(
                'breadcrumb-settings',  // group id
                'breadcrumb_home', // field id and option name
                __( 'Show Breadcrumb on Homepage','calibrefx' ), // Label
                array(
                    'option_type' => 'checkbox',
                    'option_items' => '1',
                    'option_default' => '',
                    'option_filter' => 'integer',
                    'option_description' => __("", 'calibrefx' ),
                ), // Settings config
                1 //Priority
            );

            calibrefx_add_meta_option(
                'breadcrumb-settings',  // group id
                'breadcrumb_single', // field id and option name
                __( 'Show Breadcrumb on Blog Post','calibrefx' ), // Label
                array(
                    'option_type' => 'checkbox',
                    'option_items' => '1',
                    'option_default' => '',
                    'option_filter' => 'integer',
                    'option_description' => __("", 'calibrefx' ),
                ), // Settings config
                5 //Priority
            );

            calibrefx_add_meta_option(
                'breadcrumb-settings',  // group id
                'breadcrumb_page', // field id and option name
                __( 'Show Breadcrumb on Static Page' ), // Label
                array(
                    'option_type' => 'checkbox',
                    'option_items' => '1',
                    'option_default' => '',
                    'option_filter' => 'integer',
                    'option_description' => __("", 'calibrefx' ),
                ), // Settings config
                10 //Priority
            );

            calibrefx_add_meta_option(
                'breadcrumb-settings',  // group id
                'breadcrumb_archive', // field id and option name
                __( 'Show Breadcrumb on Archive / Category Page','calibrefx' ), // Label
                array(
                    'option_type' => 'checkbox',
                    'option_items' => '1',
                    'option_default' => '',
                    'option_filter' => 'integer',
                    'option_description' => __("", 'calibrefx' ),
                ), // Settings config
                15 //Priority
            );

            calibrefx_add_meta_option(
                'breadcrumb-settings',  // group id
                'breadcrumb_404', // field id and option name
                __( 'Show Breadcrumb on 404 Page','calibrefx' ), // Label
                array(
                    'option_type' => 'checkbox',
                    'option_items' => '1',
                    'option_default' => '',
                    'option_filter' => 'integer',
                    'option_description' => __("", 'calibrefx' ),
                ), // Settings config
                20 //Priority
            );

            calibrefx_add_meta_option(
                'breadcrumb-settings',  // group id
                'breadcrumb_description', // field id and option name
                __( 'Check it if you want to show breadcrumb in any of thoses pages.','calibrefx' ), // Label
                array(
                    'option_type' => 'description',
                ), // Settings config
                99 //Priority
            );
        });
    
        //For content archive settings
        add_action( 'content-settings_options', function() {            
            calibrefx_add_meta_option(
                'content-archives-settings',  // group id
                'content_archive', // field id and option name
                __( 'How do you want to show the excerpt of the content on blog post list?','calibrefx' ), // Label
                array(
                    'option_type' => 'select',
                    'option_items' => apply_filters(
                            'calibrefx_archive_display_options', array(
                                    'full' => __( 'Display post content', 'calibrefx' ),
                                    'excerpts' => __( 'Display post excerpts', 'calibrefx' ),
                                )
                            ),
                    'option_default' => 'full',
                    'option_filter' => 'safe_text',
                    'option_description' => __("", 'calibrefx' ),
                ), // Settings config
                1 //Priority
            );

            calibrefx_add_meta_option(
                'content-archives-settings',  // group id
                'content_archive_limit', // field id and option name
                __( 'Limit total characters for your content excerpt' ), // Label
                array(
                    'option_type' => 'textinput',
                    'option_default' => '500',
                    'option_filter' => 'integer',
                    'option_description' => __("To show all contents fill with <code>0</code>", 'calibrefx' ),
                    'option_attr' => array("class" => "calibrefx_content_limit_setting"),
                ), // Settings config
                5 //Priority
            );
        });

        //For post navigation settings
        add_action( 'content-settings_options', function() {            
            calibrefx_add_meta_option(
                'post-navigation-settings',  // group id
                'posts_nav', // field id and option name
                __( 'How do you want to show the post navigation?','calibrefx' ), // Label
                array(
                    'option_type' => 'select',
                    'option_items' => apply_filters(
                            'calibrefx_post_navigation_options', array(
                            'older-newer' => __( 'Older/Newer', 'calibrefx' ),
                            'prev-next' => __( 'Previous/Next', 'calibrefx' ),
                            'numeric' => __( 'Numeric', 'calibrefx' ),
                            'disabled' => __( 'Don\'t show navigation' , 'calibrefx' ),
                            )
                        ),
                    'option_default' => 'older-newer',
                    'option_filter' => 'safe_text',
                    'option_description' => __("There are 3 types of pagination available. Choose which one is the best for you.", 'calibrefx' ),
                ), // Settings config
                1 //Priority
            );
        });

        calibrefx_do_meta_options( $calibrefx->theme_settings, 'content-settings' );
        //do_action( 'calibrefx_content_settings_meta_box' );
    }

    /**
     * Show Comment Settings Box
     */
    function comment_setting() {
        global $calibrefx;

        calibrefx_add_meta_group( 'comment-settings', 'comment-display-settings', __( 'Comments', 'calibrefx' ) );
        calibrefx_add_meta_group( 'comment-settings', 'trackback-display-settings', __( 'Trackbacks', 'calibrefx' ) );
        calibrefx_add_meta_group( 'comment-settings', 'comment-social-settings', __( 'Social Comment Integration', 'calibrefx' ) );
        
        //For Comment Display settings
        add_action( 'comment-settings_options', function() {            
            calibrefx_add_meta_option(
                'comment-display-settings',  // group id
                'comments_posts', // field id and option name
                __( 'Show comment on post?','calibrefx' ), // Label
                array(
                    'option_type' => 'checkbox',
                    'option_items' => '1',
                    'option_default' => '',
                    'option_filter' => 'integer',
                    'option_description' => __("", 'calibrefx' ),
                ), // Settings config
                1 //Priority
            );
            calibrefx_add_meta_option(
                'comment-display-settings',  // group id
                'comments_pages', // field id and option name
                __( 'Show comment on page?','calibrefx' ), // Label
                array(
                    'option_type' => 'checkbox',
                    'option_items' => '1',
                    'option_default' => '',
                    'option_filter' => 'integer',
                    'option_description' => __("", 'calibrefx' ),
                ), // Settings config
                5 //Priority
            );

            calibrefx_add_meta_option(
                'comment-display-settings',  // group id
                'comments_description', // field id and option name
                __( 'You can generally disabled comment on posts or pages. Uncheck it if you want to disable comment box.','calibrefx' ), // Label
                array(
                    'option_type' => 'description',
                ), // Settings config
                99 //Priority
            );
        });

        //For Trackback Display settings
        add_action( 'comment-settings_options', function() {            
            calibrefx_add_meta_option(
                'trackback-display-settings',  // group id
                'trackbacks_posts', // field id and option name
                __( 'Show trackbacks on posts?','calibrefx' ), // Label
                array(
                    'option_type' => 'checkbox',
                    'option_items' => '1',
                    'option_default' => '',
                    'option_filter' => 'integer',
                    'option_description' => __("", 'calibrefx' ),
                ), // Settings config
                1 //Priority
            );
            calibrefx_add_meta_option(
                'trackback-display-settings',  // group id
                'trackbacks_pages', // field id and option name
                __( 'Show trackbacks on pages?','calibrefx' ), // Label
                array(
                    'option_type' => 'checkbox',
                    'option_items' => '1',
                    'option_default' => '',
                    'option_filter' => 'integer',
                    'option_description' => __("", 'calibrefx' ),
                ), // Settings config
                5 //Priority
            );

            calibrefx_add_meta_option(
                'trackback-display-settings',  // group id
                'trackbacks_description', // field id and option name
                __( 'You can generally disabled trackback / pingbacks on posts or pages. Uncheck it if you want to disable comment box. <br/>
                     Learn more about WordPress Trackbacks and Pingbacks <a href="https://make.wordpress.org/support/user-manual/building-your-wordpress-community/trackbacks-and-pingbacks/" target="_blank">here</a>','calibrefx' ), // Label
                array(
                    'option_type' => 'description',
                ), // Settings config
                99 //Priority
            );
        });

        //For Social Comment Integration
        add_action( 'comment-settings_options', function() {            
            calibrefx_add_meta_option(
                'comment-social-settings',  // group id
                'facebook_comments', // field id and option name
                __( 'Use Facebook comment instead of WordPress Default Comment','calibrefx' ), // Label
                array(
                    'option_type' => 'checkbox',
                    'option_items' => '1',
                    'option_default' => '',
                    'option_filter' => 'integer',
                    'option_description' => __("You can override WordPress default comment to use Facebook comment box. Please check it if you would like to activate it.", 'calibrefx' ),
                ), // Settings config
                1 //Priority
            );
        });

        calibrefx_do_meta_options( $calibrefx->theme_settings, 'comment-settings' );
    }

    /**
     * Show default layout box
     */
    function layout_box() {
        global $calibrefx;

        calibrefx_add_meta_group( 'layout-settings', 'layout-general-settings', __( 'Layout Settings', 'calibrefx' ) );
        calibrefx_add_meta_group( 'layout-settings', 'layout-type-settings', __( 'General Layout Settings', 'calibrefx' ) );

         //For Layout Settings
        add_action( 'layout-settings_options', function() {            
            calibrefx_add_meta_option(
                'layout-general-settings',  // group id
                'layout_type', // field id and option name
                __( 'How would you like the main layout of the website?','calibrefx' ), // Label
                array(
                    'option_type' => 'select',
                    'option_items' => apply_filters(
                            'calibrefx_layout_type_options', array(
                                'static' => __( 'Fix Width Layout', 'calibrefx' ),
                                'fluid' => __( 'Fluid Layout', 'calibrefx' ),
                            )
                        ),
                    'option_default' => 'older-newer',
                    'option_filter' => 'integer',
                    'option_description' => __("", 'calibrefx' ),
                ), // Settings config
                1 //Priority
            );

            calibrefx_add_meta_option(
                'layout-general-settings',  // group id
                'calibrefx_layout_width', // field id and option name
                __( 'Layout Width (pixels)', 'calibrefx' ), // Label
                array(
                    'option_type' => 'textinput',
                    'option_default' => '940',
                    'option_filter' => 'integer',
                    'option_description' => __("", 'calibrefx' ),
                    'option_attr' => array("class" => "calibrefx_layout_width"),
                ), // Settings config
                5 //Priority
            );

            calibrefx_add_meta_option(
                'layout-general-settings',  // group id
                'calibrefx_layout_wrapper_fixed', // field id and option name
                __( 'Use Wrapper Border Box','calibrefx' ), // Label
                array(
                    'option_type' => 'checkbox',
                    'option_items' => '1',
                    'option_default' => '',
                    'option_filter' => 'integer',
                    'option_description' => __("Check this if you want to have wrapper box layout.", 'calibrefx' ),
                    'option_attr' => array("class" => "calibrefx_layout_width"),
                ), // Settings config
                6 //Priority
            );

            calibrefx_add_meta_option(
                'layout-general-settings',  // group id
                'responsive_disabled', // field id and option name
                __( 'Check this to disable responsive' ), // Label
                array(
                    'option_type' => 'checkbox',
                    'option_items' => '1',
                    'option_default' => '0',
                    'option_filter' => 'integer',
                    'option_description' => __("Check this if you want to disable mobile responsive feature", 'calibrefx' ),
                ), // Settings config
                15 //Priority
            );
        });

        //For General Layout Settings
        add_action( 'layout-settings_options', function() {            
            calibrefx_add_meta_option(
                'layout-type-settings',  // group id
                'site_layout', // field id and option name
                __( 'Pick your general layout column','calibrefx' ), // Label
                array(
                    'option_type' => 'custom',
                    'option_custom' => calibrefx_layout_selector(array(
                            'name' => 'calibrefx-settings[site_layout]', 
                            'selected' => calibrefx_get_option( 'site_layout' ),
                            'echo' => false) ),
                    'option_default' => '',
                    'option_filter' => '',
                    'option_description' => __("", 'calibrefx' ),
                    'option_attr' => array("class" => "calibrefx-layout-selector"),
                ), // Settings config
                1 //Priority
            );

            calibrefx_add_meta_option(
                'layout-type-settings',  // group id
                'layout_description', // field id and option name
                __( 'You can choose your Website layout. You can override per post / page later.','calibrefx' ), // Label
                array(
                    'option_type' => 'description',
                ), // Settings config
                5 //Priority
            );
        });        
        
        calibrefx_do_meta_options( $calibrefx->theme_settings, 'layout-settings' );

    }

    /**
     * Show setting box inside Theme Settings
     */
    function custom_script_box() { 
        global $calibrefx;
        
        calibrefx_add_meta_group( 'themelayout-script-settings', 'custom-css-settings', __( 'Style Customization', 'calibrefx' ) );
        calibrefx_add_meta_group( 'themelayout-script-settings', 'custom-script-settings', __( 'Javascript Customization', 'calibrefx' ) );
        
        add_action( 'themelayout-script-settings_options', function() {            
            calibrefx_add_meta_option(
                'custom-css-settings',  // group id
                'custom_css', // field id and option name
                __( 'Custom CSS code will be output at <code>wp_head()</code>' ), // Label
                array(
                    'option_type' => 'textarea',
                    'option_default' => '',
                    'option_filter' => 'no_html',
                    'option_description' => __("You can add your custom css codes here. Example: <code>a.hover {color:#ffffff}</code>.", 'calibrefx' ),
                ), // Settings config
                1 //Priority
            );

            calibrefx_add_meta_option(
                'custom-script-settings',  // group id
                'header_scripts', // field id and option name
                __( 'Header script will be output at <code>wp_head()</code>' ), // Label
                array(
                    'option_type' => 'textarea',
                    'option_default' => '',
                    'option_filter' => 'no_filter',
                    'option_description' => __("You can add your javascript at the head of the page. For example Google analytics code. <br/>Samples: <code>&lt;script type=\"text/javascript\">alert(\"Hello World\");&lt;/script></code>.", 'calibrefx' ),
                ), // Settings config
                1 //Priority
            );

            calibrefx_add_meta_option(
                'custom-script-settings',  // group id
                'footer_scripts', // field id and option name
                __( 'Footer scripts will be output at <code>wp_footer()</code>' ), // Label
                array(
                    'option_type' => 'textarea',
                    'option_default' => '',
                    'option_filter' => 'no_filter',
                    'option_description' => __("You can add your javascript at the footer of the page. For example Google analytics code. <br/>Samples: <code>&lt;script type=\"text/javascript\">alert(\"Hello World\");&lt;/script></code>.", 'calibrefx' ),
                ), // Settings config
                5 //Priority
            );
        });

        calibrefx_do_meta_options( $calibrefx->theme_settings, 'themelayout-script-settings' );
    }

    /**
     * This function socials_integrated_box is to show social media setting
     */
    function socials_integrated_box() {
        global $calibrefx;

        calibrefx_add_meta_group( 'themesocial-settings', 'facebook-settings', __( 'Facebook Settings', 'calibrefx' ) );
        calibrefx_add_meta_group( 'themesocial-settings', 'social-settings', __( 'Social Link Settings', 'calibrefx' ) );
        calibrefx_add_meta_group( 'themesocial-settings', 'feed-settings', __( 'RSS Feed Settings', 'calibrefx' ) );

        add_action( 'themesocial-settings_options', function() {
            calibrefx_add_meta_option(
                'facebook-settings',  // group id
                'facebook_admins', // field id and option name
                __( 'Facebook Admin ID' ), // Label
                array(
                    'option_type' => 'textinput',
                    'option_default' => 'anyvalue',
                    'option_filter' => 'safe_text',
                    'option_description' => __("This will be use for Facebook Insight. <br/>This will output: <code>&lt;meta property=\"fb:admins\" content=\"YOUR ADMIN ID HERE\"/></code> Read More about this <a href='https://developers.facebook.com/docs/insights/' target='_blank'>here</a>.", 'calibrefx' ),
                ), // Settings config
                1 //Priority
            );

            calibrefx_add_meta_option(
                    'facebook-settings',  // group id
                    'facebook_og_type', // field id and option name
                    __( 'Facebook Page Type' ), // Label
                    array(
                        'option_type' => 'select',
                        'option_items' => apply_filters(
                                        'calibrefx_facebook_og_types', array(
                                        'article' => 'Article',
                                        'website' => 'Website',
                                        'blog' => 'Blog',
                                        'movie' => 'Movie',
                                        'song' => 'Song',
                                        'product' => 'Product',
                                        'book' => 'Book',
                                        'food' => 'Food',
                                        'drink' => 'Drink',
                                        'activity' => 'Activity',
                                        'sport' => 'Sport',
                                        )
                                ),
                        'option_default' => 'website',
                        'option_filter' => 'safe_text',
                        'option_description' => __("This is open graph protocol that helo to identify your content. <br/>This will output: <code>&lt;meta property=\"og:type\" content=\"TYPE\"/></code>", 'calibrefx' ),
                    ), // Settings config
                    5 //Priority
            );
        } );

        add_action( 'themesocial-settings_options', function() {
            calibrefx_add_meta_option(
                    'social-settings',  // group id
                    'gplus_profile', // field id and option name
                    __( 'Google+ Profile Link' ), // Label
                    array(
                        'option_type' => 'textinput',
                        'option_default' => '',
                        'option_filter' => 'safe_text',
                        'option_description' => __("This will output <code>&lt;link rel=\"author\" href=\"YOUR GOOGLE+ LINK HERE\"/></code> in html head.", 'calibrefx' ),
                        'option_attr' => array("class" => "fullwidth"),
                    ), // Settings config
                    1 //Priority
            );

            calibrefx_add_meta_option(
                    'social-settings',  // group id
                    'gplus_page', // field id and option name
                    __( 'Google+ Page Link' ), // Label
                    array(
                        'option_type' => 'textinput',
                        'option_default' => '',
                        'option_filter' => 'safe_text',
                        'option_description' => __("This will use for Google Page For Business link, and it will show if using the Social Widget", 'calibrefx' ),
                        'option_attr' => array("class" => "fullwidth"),
                    ), // Settings config
                    5 //Priority
            );

            calibrefx_add_meta_option(
                    'social-settings',  // group id
                    'facebook_fanpage', // field id and option name
                    __( 'Facebook Page Link' ), // Label
                    array(
                        'option_type' => 'textinput',
                        'option_default' => '',
                        'option_filter' => 'safe_text',
                        'option_description' => __("This will use for Facebook Page link, and it will show if using the Social Widget", 'calibrefx' ),
                        'option_attr' => array("class" => "fullwidth"),
                    ), // Settings config
                    10 //Priority
            );

            calibrefx_add_meta_option(
                    'social-settings',  // group id
                    'twitter_profile', // field id and option name
                    __( 'Twitter Profile Link' ), // Label
                    array(
                        'option_type' => 'textinput',
                        'option_default' => '',
                        'option_filter' => 'safe_text',
                        'option_description' => __("This will use for Twitter link, and it will show if using the Social Widget", 'calibrefx' ),
                        'option_attr' => array("class" => "fullwidth"),
                    ), // Settings config
                    15 //Priority
            );

            calibrefx_add_meta_option(
                    'social-settings',  // group id
                    'youtube_channel', // field id and option name
                    __( 'Youtube Channel Link' ), // Label
                    array(
                        'option_type' => 'textinput',
                        'option_default' => '',
                        'option_filter' => 'safe_text',
                        'option_description' => __("This will use for Youtube Channel link, and it will show if using the Social Widget", 'calibrefx' ),
                        'option_attr' => array("class" => "fullwidth"),
                    ), // Settings config
                    20 //Priority
            );

            calibrefx_add_meta_option(
                    'social-settings',  // group id
                    'linkedin_profile', // field id and option name
                    __( 'Linkedin Profile Link' ), // Label
                    array(
                        'option_type' => 'textinput',
                        'option_default' => '',
                        'option_filter' => 'safe_text',
                        'option_description' => __("This will use for Linkedin link, and it will show if using the Social Widget", 'calibrefx' ),
                        'option_attr' => array("class" => "fullwidth"),
                    ), // Settings config
                    25 //Priority
            );

            calibrefx_add_meta_option(
                    'social-settings',  // group id
                    'pinterest_profile', // field id and option name
                    __( 'Pinterest Profile Link' ), // Label
                    array(
                        'option_type' => 'textinput',
                        'option_default' => '',
                        'option_filter' => 'safe_text',
                        'option_description' => __("This will use for Pinterest link, and it will show if using the Social Widget", 'calibrefx' ),
                        'option_attr' => array("class" => "fullwidth"),
                    ), // Settings config
                    30 //Priority
            );
        } );

        add_action( 'themesocial-settings_options', function() {
            calibrefx_add_meta_option(
                    'feed-settings',  // group id
                    'feed_uri', // field id and option name
                    __( 'Main Feed URL' ), // Label
                    array(
                        'option_type' => 'textinput',
                        'option_default' => '',
                        'option_filter' => 'safe_text',
                        'option_description' => __("You can replace WordPress builtin Feed URL using this options. For sample you want to use feedburner instead. <br/>Sample: <code>http://feeds2.feedburner.com/calibrefx.</code>", 'calibrefx' ),
                        'option_attr' => array("class" => "fullwidth"),
                    ), // Settings config
                    1 //Priority
            );

            calibrefx_add_meta_option(
                    'feed-settings',  // group id
                    'comments_feed_uri', // field id and option name
                    __( 'Comment Feed URL' ), // Label
                    array(
                        'option_type' => 'textinput',
                        'option_default' => '',
                        'option_filter' => 'safe_text',
                        'option_description' => __("You can replace WordPress builtin Feed URL using this options. For sample you want to use feedburner instead. <br/>Sample: <code>http://feeds2.feedburner.com/calibrefxcomment.</code>", 'calibrefx' ),
                        'option_attr' => array("class" => "fullwidth"),
                    ), // Settings config
                    2 //Priority
            );
        } );

        calibrefx_do_meta_options( $calibrefx->theme_settings, 'themesocial-settings' );
    }
}

