<?php 
defined('CALIBREFX_URL') OR exit();
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
        $this->default_settings = apply_filters('calibrefx_theme_settings_defaults', array(
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
        $calibrefx->load->model('theme_settings_m');
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
                    'trackbacks_pages')
                );

        $calibrefx->security->add_sanitize_filter(
                'safe_text', $this->settings_field, array(
                    'blog_title',
                    'calibrefx_version',
                    'calibrefx_db_version',
                    'posts_nav',
                    'content_archive',
                    'layout_type',
                    'site_layout')
                );

        $calibrefx->security->add_sanitize_filter(
                'integer', $this->settings_field, array(
                    'calibrefx_layout_width',
                    'content_archive_limit',
                    'calibrefx_db_version')
                );
    }

    public function meta_sections() {
        global $calibrefx_current_section, $calibrefx_target_form, $calibrefx_user_ability;

        $calibrefx_target_form = apply_filters('calibrefx_target_form', 'options.php');

        calibrefx_clear_meta_section();

        calibrefx_add_meta_section('general', __('General Settings', 'calibrefx'), $calibrefx_target_form, 1);
        calibrefx_add_meta_section('layout', __('Layout Settings', 'calibrefx'), $calibrefx_target_form,2);
        calibrefx_add_meta_section('social', __('Social Settings', 'calibrefx'), $calibrefx_target_form,10);
        
        /*if($calibrefx_user_ability == 'professor'){
            calibrefx_add_meta_section('email', __('Email Setting', 'calibrefx'), $calibrefx_target_form, 20);
        }*/

        do_action('calibrefx_theme_settings_meta_section');

        $calibrefx_current_section = 'general';
        if (!empty($_GET['section'])) {
            $calibrefx_current_section = sanitize_text_field($_GET['section']);
        }
    }

    public function meta_boxes() {
        calibrefx_add_meta_box('general', 'basic', 'calibrefx-theme-settings-navigation', __('Navigation Settings', 'calibrefx'), array($this, 'navigation_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('general', 'basic', 'calibrefx-theme-settings-content', __('Content Setting', 'calibrefx'), array($this, 'content_setting'), $this->pagehook, 'main');
        calibrefx_add_meta_box('general', 'basic', 'calibrefx-theme-settings-analytics', __('Google Analytics Setting', 'calibrefx'), array($this, 'analytics_setting'), $this->pagehook, 'main');

        calibrefx_add_meta_box('layout', 'basic', 'calibrefx-theme-settings-layout', __('Default Layout Settings', 'calibrefx'), array($this, 'layout_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('layout', 'basic', 'calibrefx-theme-settings-custom-css', __('Themes Custom CSS', 'calibrefx'), array($this, 'custom_css_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('layout', 'basic', 'calibrefx-theme-settings-custom-script', __('Themes Custom Script', 'calibrefx'), array($this, 'custom_script_box'), $this->pagehook, 'main', 'low');

        calibrefx_add_meta_box('social', 'basic', 'calibrefx-theme-settings-feeds', __('Feeds Setting', 'calibrefx'), array($this, 'feeds_box'), $this->pagehook, 'main');
        calibrefx_add_meta_box('social', 'basic', 'calibrefx-theme-social-link', __('Social Media Links', 'calibrefx'), array($this, 'social_link'), $this->pagehook, 'main');
        calibrefx_add_meta_box('social', 'basic', 'calibrefx-theme-settings-socials', __('Social Settings', 'calibrefx'), array($this, 'socials_box'), $this->pagehook, 'main');

        do_action('calibrefx_theme_settings_meta_box');
    }

    public function hidden_fields(){
        ?>
        <input type="hidden" name="<?php echo $this->settings_field; ?>[calibrefx_version]>" value="<?php echo esc_attr(calibrefx_get_option('calibrefx_version', $this->_model)); ?>" />
        <input type="hidden" name="<?php echo $this->settings_field; ?>[calibrefx_db_version]>" value="<?php echo esc_attr(calibrefx_get_option('calibrefx_db_version', $this->_model)); ?>" />
        <?php
    }

    //Meta Boxes Sections
    /**
     * Show navigation setting box
     */
    function navigation_box() {
        ?>
        <h3 class="section-title">Menu Navigation</h3>

        <div class="section-row">
            <div class="section-col">
                <?php if (calibrefx_nav_menu_supported('primary')) : ?>
                <div class="section-line">
                    <input type="checkbox" name="" target="calibrefx-settings-nav" value="1" id="calibrefx-settings-checkbox-nav" class="calibrefx-settings-checkbox" <?php checked(1, calibrefx_get_option('nav')); ?> /> <label for="calibrefx-settings-checkbox-nav"><span class="label-highlight"><?php _e("Primary Navigation", 'calibrefx'); ?></span></label>
                    <input type="hidden" name="<?php echo $this->settings_field; ?>[nav]" id="calibrefx-settings-nav" value="<?php echo calibrefx_get_option('nav'); ?>" />
                </div>
                <?php endif; ?>
                <?php if (calibrefx_nav_menu_supported('secondary')) : ?>
                <div class="section-line last">
                    <input type="checkbox" name="" target="calibrefx-settings-subnav" id="calibrefx-settings-checkbox-subnav" value="1" class="calibrefx-settings-checkbox" <?php checked(1, calibrefx_get_option('subnav')); ?> /> <label for="calibrefx-settings-checkbox-subnav"><span class="label-highlight"><?php _e("Secondary Navigation", 'calibrefx'); ?></span></label>
                    <input type="hidden" name="<?php echo $this->settings_field; ?>[subnav]" id="calibrefx-settings-subnav" value="<?php echo calibrefx_get_option('subnav'); ?>" />
                </div>
                <?php endif; ?>
            </div>
            <div class="section-col last">
                <div class="section-desc">
                    <?php _e('You can assign your primary menu from Appreances > Menus.', 'calibrefx'); ?>
                </div>
            </div>   
        </div>

         <p class="description"><?php printf(__('Please build a <a href="%s">custom menu</a>, then assign it to the proper Menu Location.', 'calibrefx'), admin_url('nav-menus.php')); ?></p>
        <?php

        do_action('calibrefx_navigation_settings_meta_box');
    }

    /**
     * Show google analytic setting box
     */
    function analytics_setting(){
    ?>
        <div id="analytics-settings">
            <h3 class="section-title">
                <label for="analytic_id"><?php _e('Google Analytics ID', 'calibrefx'); ?></label>
            </h3>

            <div class="section-row">
                <div class="section-col">
                    <input type="text" name="<?php echo $this->settings_field; ?>[analytic_id]" id="analytic_id" value="<?php echo esc_attr(calibrefx_get_option('analytic_id')); ?>" />
                </div>
                <div class="section-col noborder">
                    <div class="section-desc">
                        <p class="description">
                            <?php _e('Enter your google analytics ID, example: <strong>UA-xxxxxxxx-x</strong>', 'calibrefx'); ?>
                        </p>     
                    </div>
                </div>   
            </div>
        </div>
    <?php
        do_action('calibrefx_analytic_settings_meta_box');
    }

    /**
     * Show content box
     */
    function content_setting(){
    ?>
        <div id="breadcrumb-settings">
            <h3 class="section-title"><?php _e('Breadcrumbs', 'calibrefx'); ?></h3>

            <p><?php _e("Show Breadcrumb on:", 'calibrefx'); ?></p>

            <div class="section-row">
                <div class="section-col">
                    <div class="section-box">
                        <!-- breadcrumb breadcrumb_home -->
                        <label for="calibrefx-settings-checkbox-breadcrumb-home" class="section-label-checkbox">
                            <input type="checkbox" name="" id="calibrefx-settings-checkbox-breadcrumb-home" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_home')); ?> target="calibrefx-settings-breadcrumb-home" class="calibrefx-settings-checkbox" /> <?php _e("Front Page", 'calibrefx'); ?>
                        </label>
                        <input type="hidden" name="<?php echo $this->settings_field; ?>[breadcrumb_home]" id="calibrefx-settings-breadcrumb-home" value="<?php echo calibrefx_get_option('breadcrumb_home'); ?>" />

                        <!-- breadcrumb breadcrumb_single -->
                        <label for="calibrefx-settings-checkbox-breadcrumb-single" class="section-label-checkbox">
                            <input type="checkbox" name="" id="calibrefx-settings-checkbox-breadcrumb-single" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_single')); ?> target="calibrefx-settings-breadcrumb-single" class="calibrefx-settings-checkbox" /> <?php _e("Posts", 'calibrefx'); ?>
                        </label>
                        <input type="hidden" name="<?php echo $this->settings_field; ?>[breadcrumb_single]" id="calibrefx-settings-breadcrumb-single" value="<?php echo calibrefx_get_option('breadcrumb_single'); ?>" />

                        <!-- breadcrumb breadcrumb_page -->
                        <label for="calibrefx-settings-checkbox-breadcrumb-page" class="section-label-checkbox">
                            <input type="checkbox" name="" id="calibrefx-settings-checkbox-breadcrumb-page" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_page')); ?> target="calibrefx-settings-breadcrumb-page" class="calibrefx-settings-checkbox" /> <?php _e("Pages", 'calibrefx'); ?>
                        </label>
                        <input type="hidden" name="<?php echo $this->settings_field; ?>[breadcrumb_page]" id="calibrefx-settings-breadcrumb-page" value="<?php echo calibrefx_get_option('breadcrumb_page'); ?>" />

                        <!-- breadcrumb breadcrumb_archive -->
                        <label for="calibrefx-settings-checkbox-breadcrumb-archive" class="section-label-checkbox">
                            <input type="checkbox" name="" id="calibrefx-settings-checkbox-breadcrumb-archive" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_archive')); ?> target="calibrefx-settings-breadcrumb-archive" class="calibrefx-settings-checkbox" /> <?php _e("Archives", 'calibrefx'); ?>
                        </label>
                        <input type="hidden" name="<?php echo $this->settings_field; ?>[breadcrumb_archive]" id="calibrefx-settings-breadcrumb-archive" value="<?php echo calibrefx_get_option('breadcrumb_archive'); ?>" />

                        <!-- breadcrumb breadcrumb_404 -->
                        <label for="calibrefx-settings-checkbox-breadcrumb-404" class="section-label-checkbox">
                            <input type="checkbox" name="" id="calibrefx-settings-checkbox-breadcrumb-404" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_404')); ?> target="calibrefx-settings-breadcrumb-404" class="calibrefx-settings-checkbox" /> <?php _e("404 Page", 'calibrefx'); ?>
                        </label>
                        <input type="hidden" name="<?php echo $this->settings_field; ?>[breadcrumb_404]" id="calibrefx-settings-breadcrumb-404" value="<?php echo calibrefx_get_option('breadcrumb_404'); ?>" />
                    </div>
                </div>
                <div class="section-col noborder">
                    <div class="section-desc">
                        <p class="description"><?php _e('You can choose where you want to show breadcrumb (sitemap navigation) links.', 'calibrefx'); ?></p>
                    </div>
                </div>   
            </div>
        </div>

        <div id="content-archives-settings">
            <h3 class="section-title"><?php _e('Content Archives', 'calibrefx'); ?></h3>

            <p><label for="<?php echo $this->settings_field; ?>[content_archive]"><?php _e('Select one of the following:', 'calibrefx'); ?></label></p>

            <div class="section-row">
                <div class="section-col">
                    
                    <select name="<?php echo $this->settings_field; ?>[content_archive]" id="<?php echo $this->settings_field; ?>[content_archive]" class="calibrefx_content_archive">
                    <?php
                    $archive_display = apply_filters(
                            'calibrefx_archive_display_options', array(
                            'full' => __('Display post content', 'calibrefx'),
                            'excerpts' => __('Display post excerpts', 'calibrefx'),
                            )
                    );
                    foreach ((array) $archive_display as $value => $name)
                        echo '<option value="' . esc_attr($value) . '"' . selected(calibrefx_get_option('content_archive'), esc_attr($value), false) . '>' . esc_html($name) . '</option>' . "\n";
                    ?>
                    </select>
                        
                    <div class="calibrefx_content_limit_setting calibrefx_content_archive_limit">
                        <label for="<?php echo $this->settings_field; ?>[content_archive_limit]"><?php _e('Limit content to', 'calibrefx'); ?></label>
                        <input type="text" name="<?php echo $this->settings_field; ?>[content_archive_limit]" value="<?php echo esc_attr(calibrefx_get_option('content_archive_limit')); ?>" size="3" /><?php _e('characters', 'calibrefx'); ?>
                    </div>

                </div>
                <div class="section-col noborder">
                    <div class="section-desc">
                        <div class="calibrefx_content_limit_setting">
                            <p class="description"><?php _e('This option will limit the text and strip all formatting from the text displayed. Use this option, with "Display post content" in the selected box above.', 'calibrefx'); ?></p>
                        </div>
                    </div>
                </div>   
            </div>
        </div>

        <div id="comment-settings">
            <h3 class="section-title"><?php _e('Comments', 'calibrefx'); ?></h3>

            <div class="section-row">
                <div class="section-col">
                    <p><?php _e('Enable Comments', 'calibrefx'); ?></p>

                    <!-- comment comments_posts -->
                    <label for="calibrefx-settings-checkbox-comments-posts" class="section-label-checkbox">
                        <input type="checkbox" name="" id="calibrefx-settings-checkbox-comments-posts" value="1" <?php checked(1, calibrefx_get_option('comments_posts')); ?> target="calibrefx-settings-comments-posts" class="calibrefx-settings-checkbox" /> <?php _e("on posts?", 'calibrefx'); ?>
                    </label>
                    <input type="hidden" name="<?php echo $this->settings_field; ?>[comments_posts]" id="calibrefx-settings-comments-posts" value="<?php echo calibrefx_get_option('comments_posts'); ?>" />

                    <!-- comment comments_pages -->
                    <label for="calibrefx-settings-checkbox-comments-pages" class="section-label-checkbox">
                        <input type="checkbox" name="" id="calibrefx-settings-checkbox-comments-pages" value="1" <?php checked(1, calibrefx_get_option('comments_pages')); ?> target="calibrefx-settings-comments-pages" class="calibrefx-settings-checkbox" /> <?php _e("on pages?", 'calibrefx'); ?>
                    </label>
                    <input type="hidden" name="<?php echo $this->settings_field; ?>[comments_pages]" id="calibrefx-settings-comments-pages" value="<?php echo calibrefx_get_option('comments_pages'); ?>" />
                
                    <p class="enable-trackback"><?php _e('Enable Trackbacks', 'calibrefx'); ?></p>

                    <!-- trackback trackbacks_posts -->
                    <label for="calibrefx-settings-checkbox-trackbacks-posts" class="section-label-checkbox">
                        <input type="checkbox" name="" id="calibrefx-settings-checkbox-trackbacks-posts" value="1" <?php checked(1, calibrefx_get_option('trackbacks_posts')); ?> target="calibrefx-settings-trackbacks-posts" class="calibrefx-settings-checkbox" /> <?php _e("on posts?", 'calibrefx'); ?>
                    </label>
                    <input type="hidden" name="<?php echo $this->settings_field; ?>[trackbacks_posts]" id="calibrefx-settings-trackbacks-posts" value="<?php echo calibrefx_get_option('trackbacks_posts'); ?>" />

                    <!-- trackback trackbacks_pages -->
                    <label for="calibrefx-settings-checkbox-trackbacks-pages" class="section-label-checkbox">
                        <input type="checkbox" name="" id="calibrefx-settings-checkbox-trackbacks-pages" value="1" <?php checked(1, calibrefx_get_option('trackbacks_pages')); ?> target="calibrefx-settings-trackbacks-pages" class="calibrefx-settings-checkbox" /> <?php _e("on pages?", 'calibrefx'); ?>
                    </label>
                    <input type="hidden" name="<?php echo $this->settings_field; ?>[trackbacks_pages]" id="calibrefx-settings-trackbacks-pages" value="<?php echo calibrefx_get_option('trackbacks_pages'); ?>" />
                </div>
                <div class="section-col noborder">
                    <div class="section-desc">
                        <p class="description"><?php _e("You can generally enabled/disabled comments and trackbacks per post/page.", 'calibrefx'); ?></p>
                    </div>
                </div>   
            </div>
        </div>

        <div id="facebook-comment-settings">
            <div class="section-row">
                <div class="section-col">
                    <p>
                        <?php _e('Enable Facebook Comments', 'calibrefx'); ?>
                    </p>

                    <label for="calibrefx-settings-checkbox-facebook-comments">
                        <input type="checkbox" name="" id="calibrefx-settings-checkbox-facebook-comments" value="1" <?php checked(1, calibrefx_get_option('facebook_comments')); ?> target="calibrefx-settings-facebook-comments" class="calibrefx-settings-checkbox" /><?php _e('Enabled', 'calibrefx'); ?>
                    </label>
                    <input type="hidden" name="<?php echo $this->settings_field; ?>[facebook_comments]" id="calibrefx-settings-facebook-comments" value="<?php echo calibrefx_get_option('facebook_comments'); ?>" />
                </div>
                <div class="section-col noborder">
                    <div class="section-desc">
                       <p class="description"><?php _e("This will override the default comments form with facebook comments form", 'calibrefx'); ?></p>
                    </div>
                </div>   
            </div>
        </div>

        <div id="post-navigation-settings">
            <h3 class="section-title"><?php _e('Post Navigations', 'calibrefx'); ?></h3>

            <div class="section-row">
                <div class="section-col">
                    <p>
                        <label for="<?php echo $this->settings_field; ?>[posts_nav]"><?php _e('Select Post Navigation:', 'calibrefx'); ?></label>
                    </p>

                    <select name="<?php echo $this->settings_field; ?>[posts_nav]" id="<?php echo $this->settings_field; ?>[posts_nav]">
                    <?php
                    $postnav_display = apply_filters(
                            'calibrefx_post_navigation_options', array(
                            'older-newer' => __('older/Newer', 'calibrefx'),
                            'prev-next' => __('Previous/Next', 'calibrefx'),
                            'numeric' => __('Numeric', 'calibrefx'),
                            'disabled' => __('Disabled', 'calibrefx'),
                            )
                    );

                    foreach ((array) $postnav_display as $value => $name)
                        echo '<option value="' . esc_attr($value) . '"' . selected(calibrefx_get_option('posts_nav'), esc_attr($value), false) . '>' . esc_html($name) . '</option>' . "\n";
                    ?>
                    </select>
                </div>
                <div class="section-col noborder">
                    <div class="section-desc">
                        <p class="description">
                            <?php _e('You can choose your navigation format. Choices: Numeric, Older-Newer, or Previous-Next', 'calibrefx'); ?>
                        </p>     
                    </div>
                </div>   
            </div>
        </div>
    <?php

        do_action('calibrefx_content_settings_meta_box');
    }

    /**
     * Show default layout box
     */
    function layout_box() {
        global $calibrefx_user_ability;
        ?>
        <div id="mobile-settings">
            <div class="section-row">
                <div class="section-col">
                    <p>
                        <label for="calibrefx-settings-checkbox-enable-mobile"><?php _e('Enable Mobile Site', 'calibrefx'); ?></label>
                    </p>
                    <input type="checkbox" name="" id="calibrefx-settings-checkbox-enable-mobile" value="0" <?php checked(1, calibrefx_get_option('enable_mobile')); ?> target="calibrefx-settings-enable-mobile" class="calibrefx-settings-checkbox"  />
                </div>
                <div class="section-col noborder">
                    <div class="section-desc">
                        <p class="description">
                            <?php _e('You can choose your navigation format. Choices: Numeric, Older-Newer, or Previous-Next', 'calibrefx'); ?>
                        </p>     
                    </div>
                </div>   
            </div>
        </div>







        <?php
        if ($calibrefx_user_ability === 'professor') {
            ?>
             <p><label><?php _e('Enable Mobile Site', 'calibrefx'); ?></label>
                <label for="calibrefx-settings-checkbox-enable-mobile">
                    <input type="checkbox" name="" id="calibrefx-settings-checkbox-enable-mobile" value="0" <?php checked(1, calibrefx_get_option('enable_mobile')); ?> target="calibrefx-settings-enable-mobile" class="calibrefx-settings-checkbox"  />
                </label>
                <input type="hidden" name="<?php echo $this->settings_field; ?>[enable_mobile]" id="calibrefx-settings-enable-mobile" value="<?php echo calibrefx_get_option('enable_mobile'); ?>" />
                <span class="description"><?php _e('This option will overwrite your themes when view in mobile. But the child themes should support it to get it working. Contact your Child themes developer regarding this.', 'calibrefx'); ?></span>
            </p>

            <hr class="div" />
        <?php } ?>
        <p><span class="description"><?php _e('You can choose between static layout and fluid layout. If in static layout you need to put the max width size.', 'calibrefx'); ?></span></p>
        <p>
            <label>Layout Type:</label>
            <select name="<?php echo $this->settings_field; ?>[layout_type]" id="<?php echo $this->settings_field; ?>[layout_type]">
        <?php
        $layout_type = apply_filters(
                'calibrefx_layout_type_options', array(
                'static' => __('Static Layout', 'calibrefx'),
                'fluid' => __('Fluid Layout', 'calibrefx'),
                )
        );
        foreach ((array) $layout_type as $value => $name)
            echo '<option value="' . esc_attr($value) . '"' . selected(calibrefx_get_option('layout_type'), esc_attr($value), false) . '>' . esc_html($name) . '</option>' . "\n";
        ?>
            </select>

        </p>
        <div id="calibrefx_layout_width">
            <p>
                <label for="<?php echo $this->settings_field; ?>[calibrefx_layout_width]"><?php _e('Layout Width', 'calibrefx'); ?></label>
                <input type="text" name="<?php echo $this->settings_field; ?>[calibrefx_layout_width]" value="<?php echo esc_attr(calibrefx_get_option('calibrefx_layout_width')); ?>" size="3" /><?php _e('pixels', 'calibrefx'); ?>
            </p>
            <p>
                <label for="calibrefx_layout_wrapper_fixed_input">
                    <input type="checkbox" name="" value="1" class="calibrefx-settings-checkbox" id="calibrefx_layout_wrapper_fixed_input" target="calibrefx_layout_wrapper_fixed" <?php checked(1, calibrefx_get_option('calibrefx_layout_wrapper_fixed')); ?> /> <?php _e("Use fixed wrapper", 'calibrefx'); ?> 
                </label>
                <input type="hidden" name="<?php echo $this->settings_field; ?>[calibrefx_layout_wrapper_fixed]" id="calibrefx_layout_wrapper_fixed" value="<?php echo calibrefx_get_option('calibrefx_layout_wrapper_fixed') ?>" />
                
            </p>
            <p><span class="description"><?php _e('You can put maximum width in pixel size. Default: 960', 'calibrefx'); ?></span></p>
        </div>

        <hr class="div" />
        
        <p>
            <label><?php _e('General Layout Type:', 'calibrefx'); ?></label>
        </p>
        <p class="calibrefx-layout-selector">
        <?php
        calibrefx_layout_selector(array('name' => $this->settings_field . '[site_layout]', 'selected' => calibrefx_get_option('site_layout')));
        ?>
        </p>
        <div  class="clear"></div>
        <p><span class="description"><?php _e('You can choose your general layout type. You can override this from the post/page editor.', 'calibrefx'); ?></span></p>
        <br class="clear" />

            <?php
        }

        /**
         * Show setting box inside Theme Settings
         */
        function custom_css_box() { ?>
            <p><?php _e("Custom CSS code will be output at <code>wp_head()</code>:", 'calibrefx'); ?></p>
                <textarea name="<?php echo $this->settings_field; ?>[custom_css]" cols="78" rows="8"><?php echo stripslashes(esc_textarea(calibrefx_get_option('custom_css'))); ?></textarea>
            <p>
                <span class="description"><?php _e('You can add your custom css codes here. Example: <code>a.hover {color:#ffffff}</code> .', 'calibrefx'); ?></span>
            </p>
        <?php
    }

        /**
         * Show setting box inside Theme Settings
         */
        function custom_script_box() { ?>
        <p><?php _e("Header script will be output at <code>wp_head()</code>:", 'calibrefx'); ?></p>
            <textarea name="<?php echo $this->settings_field; ?>[header_scripts]" cols="78" rows="8"><?php echo stripslashes(esc_textarea(calibrefx_get_option('header_scripts'))); ?></textarea>
        <p>
            <span class="description"><?php _e('You can add your javascript at the head of the page. For example Google analytics code. <br/>Samples: <code>&lt;script type="text/javascript">alert("Hello World");&lt;/script></code>', 'calibrefx'); ?></span>
        </p>

        <hr class="div" />

        <p><?php _e("Footer scripts will be output at <code>wp_footer()</code>:", 'calibrefx'); ?></p>
        <textarea name="<?php echo $this->settings_field; ?>[footer_scripts]" cols="78" rows="8"><?php echo stripslashes(esc_textarea(calibrefx_get_option('footer_scripts'))); ?></textarea>
        <p>
            <span class="description"><?php _e('You can add your javascript at the footer of the page. For example tracking code. <br/>Samples: <code>&lt;script type="text/javascript">alert("Hello World");&lt;/script></code>', 'calibrefx'); ?></span>
        </p>
        <?php
    }

    /**
     * This function socials_box is to show feeds setting
     */
    function feeds_box() {
        ?>
        <p>
            <label for="<?php echo $this->settings_field; ?>[feed_uri]"><?php _e('Main Feed URL:', 'calibrefx'); ?></label>
            <input type="text" size="30" value="<?php echo calibrefx_get_option('feed_uri'); ?>" id="<?php echo $this->settings_field; ?>[feed_uri]" name="<?php echo $this->settings_field; ?>[feed_uri]">
        </p>
        <p><span class="description"><?php _e("You can replace WordPress builtin Feed URL using this options. For sample you want to use feedburner instead. Sample: http://feeds2.feedburner.com/calibrefx.", 'calibrefx'); ?></span></p>
        <hr class="div" />
        <p>
            <label for="<?php echo $this->settings_field; ?>[comments_feed_uri]"><?php _e('Comment Feed URL:', 'calibrefx'); ?></label>
            <input type="text" size="30" value="<?php echo calibrefx_get_option('comments_feed_uri'); ?>" id="<?php echo $this->settings_field; ?>[comments_feed_uri]" name="<?php echo $this->settings_field; ?>[comments_feed_uri]">
        </p>
        <p><span class="description"><?php _e("You can replace WordPress builtin Feed URL using this options. For sample you want to use feedburner instead. Sample: http://feeds2.feedburner.com/calibrefxcomment.", 'calibrefx'); ?></span></p>
        <?php
    }

    /**
     * This function socials_box is to show social settings
     * Use For Widgets
     */
    function socials_box() {
        ?>
        <h4><?php _e('Facebook Settings:', 'calibrefx'); ?></h4>
        <p>
            <label for="<?php echo $this->settings_field; ?>[facebook_admins]"><?php _e('Facebook Admin ID:', 'calibrefx'); ?></label>
            <input type="text" size="30" value="<?php echo calibrefx_get_option('facebook_admins'); ?>" id="<?php echo $this->settings_field; ?>[facebook_admins]" name="<?php echo $this->settings_field; ?>[facebook_admins]">
            <span class="description"><?php _e("This will be use for Facebook Insight. <br/>This will output: <code>&lt;meta property=\"fb:admins\" content=\"YOUR ADMIN ID HERE\"/></code> Read More about this <a href='https://developers.facebook.com/docs/insights/' target='_blank'>here</a>.", 'calibrefx'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[facebook_og_type]"><?php _e('Facebook Page Type:', 'calibrefx'); ?></label>
            <select name="<?php echo $this->settings_field; ?>[facebook_og_type]" id="<?php echo $this->settings_field; ?>[facebook_og_type]">
            <?php
            $page_types = apply_filters(
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
            );
            foreach ((array) $page_types as $value => $name)
                echo '<option value="' . esc_attr($value) . '"' . selected(calibrefx_get_option('facebook_og_type'), esc_attr($value), false) . '>' . esc_html($name) . '</option>' . "\n";
            ?>
            </select>
            <span class="description"><?php _e("This is open graph protocol that helo to identify your content. <br/>This will output: <code>&lt;meta property=\"og:type\" content=\"TYPE\"/></code>", 'calibrefx'); ?></span>
        </p>
        <?php
    }

    /**
     * This function social_link is to show social links
     * Use For Widgets
     */
    function social_link() {
        ?>
        <p>
            <label for="<?php echo $this->settings_field; ?>[gplus_profile]"><?php _e('Google+ Profile Link:', 'calibrefx'); ?></label>
            <input type="text" size="30" value="<?php echo calibrefx_get_option('gplus_profile'); ?>" id="<?php echo $this->settings_field; ?>[gplus_profile]" name="<?php echo $this->settings_field; ?>[gplus_profile]">
            <span class="description"><?php _e("This will output <code>&lt;link rel=\"author\" href=\"YOUR GOOGLE+ LINK HERE\"/></code> in html head", 'calibrefx'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[gplus_page]"><?php _e('Google+ Page Link:', 'calibrefx'); ?></label>
            <input type="text" size="30" value="<?php echo calibrefx_get_option('gplus_page'); ?>" id="<?php echo $this->settings_field; ?>[gplus_page]" name="<?php echo $this->settings_field; ?>[gplus_page]">
            <span class="description"><?php _e("This will use for Google Page For Business link, and it will show if using the Social Widget", 'calibrefx'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[facebook_fanpage]"><?php _e('Facebook Page Link:', 'calibrefx'); ?></label>
            <input type="text" size="30" value="<?php echo calibrefx_get_option('facebook_fanpage'); ?>" id="<?php echo $this->settings_field; ?>[facebook_fanpage]" name="<?php echo $this->settings_field; ?>[facebook_fanpage]">
            <span class="description"><?php _e("This will use for Facebook Page link, and it will show if using the Social Widget", 'calibrefx'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[twitter_profile]"><?php _e('Twitter Profile Link:', 'calibrefx'); ?></label>
            <input type="text" size="30" value="<?php echo calibrefx_get_option('twitter_profile'); ?>" id="<?php echo $this->settings_field; ?>[twitter_profile]" name="<?php echo $this->settings_field; ?>[twitter_profile]">
            <span class="description"><?php _e("This will use for Twitter link, and it will show if using the Social Widget", 'calibrefx'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[youtube_channel]"><?php _e('Youtube Channel Link:', 'calibrefx'); ?></label>
            <input type="text" size="30" value="<?php echo calibrefx_get_option('youtube_channel'); ?>" id="<?php echo $this->settings_field; ?>[youtube_channel]" name="<?php echo $this->settings_field; ?>[youtube_channel]">
            <span class="description"><?php _e("This will use for Youtube Channel link, and it will show if using the Social Widget", 'calibrefx'); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[linkedin_profile]"><?php _e('Linkedin Profile Link:', 'calibrefx'); ?></label>
            <input type="text" size="30" value="<?php echo calibrefx_get_option('linkedin_profile'); ?>" id="<?php echo $this->settings_field; ?>[linkedin_profile]" name="<?php echo $this->settings_field; ?>[linkedin_profile]">
            <span class="description"><?php _e("This will use for Linkedin link, and it will show if using the Social Widget", 'calibrefx'); ?></span>
        </p>
		<p>
            <label for="<?php echo $this->settings_field; ?>[pinterest_profile]"><?php _e('Pinterest Profile Link:', 'calibrefx'); ?></label>
            <input type="text" size="30" value="<?php echo calibrefx_get_option('pinterest_profile'); ?>" id="<?php echo $this->settings_field; ?>[pinterest_profile]" name="<?php echo $this->settings_field; ?>[pinterest_profile]">
            <span class="description"><?php _e("This will use for Pinterest link, and it will show if using the Social Widget", 'calibrefx'); ?></span>
        </p>
        <?php
    }

    /**
     * This function to do setting for the email settings
     */
    /*function email_setting_box(){ ?>
         <p>
            <label for="<?php echo $this->settings_field; ?>[email_protocol]"><?php _e('Select Mail Protocol:', 'calibrefx');?></label>
            <select name="<?php echo $this->settings_field; ?>[email_protocol]" id="<?php echo $this->settings_field; ?>[email_protocol]">
                <option value="sendmail" <?php selected(calibrefx_get_option('email_protocol'), 'sendmail'); ?> >Sendmail</option>
                <option value="smtp" <?php selected(calibrefx_get_option('email_protocol'), 'smtp'); ?>>SMTP</option>
            </select>
            <span class="description"><?php _e('Please choose your mailer protocol. (default: sendmail)', 'calibrefx'); ?></span>
        </p>

        <div id="email_setting_box_content">

            <p>
                <label for="<?php echo $this->settings_field; ?>[smtp_host]"><?php _e('SMTP Host:', 'calibrefx'); ?></label>
                <input type="text" size="30" value="<?php echo calibrefx_get_option('smtp_host'); ?>" id="<?php echo $this->settings_field; ?>[smtp_host]" name="<?php echo $this->settings_field; ?>[smtp_host]">
                <span class="description"><?php _e("Put your SMTP Host", 'calibrefx'); ?></span>
            </p>

           <p>
                <label for="<?php echo $this->settings_field; ?>[smtp_secure]"><?php _e('Use Secure Connection:', 'calibrefx'); ?></label>
                <select name="<?php echo $this->settings_field; ?>[smtp_secure]" id="<?php echo $this->settings_field; ?>[smtp_secure]">
                    <option value="-1" <?php selected(calibrefx_get_option('smtp_secure'), '-1'); ?> >No Secure Connection</option>
                    <option value="tls" <?php selected(calibrefx_get_option('smtp_secure'), 'tls'); ?> >TLS</option>
                    <option value="ssl" <?php selected(calibrefx_get_option('smtp_secure'), 'ssl'); ?> >SSL</option>
                </select>
                <span class="description"><?php _e('Use secure connection when sending email', 'calibrefx'); ?></span>
            </p>

            <p>
                <label for="<?php echo $this->settings_field; ?>[smtp_port]"><?php _e('SMTP Port:', 'calibrefx'); ?></label>
                <input type="text" size="30" value="<?php echo calibrefx_get_option('smtp_port'); ?>" id="<?php echo $this->settings_field; ?>[smtp_port]" name="<?php echo $this->settings_field; ?>[smtp_port]">
                <span class="description"><?php _e("Put your SMTP Port (ex: 25, 465)", 'calibrefx'); ?></span>
            </p>

            <p>
                <input type="checkbox" name="" target="calibrefx-settings-smtp_use_auth" value="1" id="calibrefx-settings-smtp_use_auth-box" class="calibrefx-settings-checkbox" <?php checked(1, calibrefx_get_option('smtp_use_auth')); ?> /> 
                <label for="calibrefx-settings-smtp_use_auth"><?php _e("Use SMTP Authentication", 'calibrefx'); ?></label>
                <input type="hidden" name="<?php echo $this->settings_field; ?>[smtp_use_auth]" id="calibrefx-settings-smtp_use_auth" value="<?php echo calibrefx_get_option('smtp_use_auth'); ?>" />
                <span class="description"><?php _e('Checked this if your SMTP need Authentication. If using Google Service, then this should be checked.', 'calibrefx'); ?></span>
            </p>

            <div id="smtp_use_auth_box_content">

                <p>
                    <label for="<?php echo $this->settings_field; ?>[smtp_username]"><?php _e('SMTP Username:', 'calibrefx'); ?></label>
                    <input type="text" size="30" value="<?php echo calibrefx_get_option('smtp_username'); ?>" id="<?php echo $this->settings_field; ?>[smtp_username]" name="<?php echo $this->settings_field; ?>[smtp_username]">
                    <span class="description"><?php _e("Put your SMTP Username", 'calibrefx'); ?></span>
                </p>

                <p>
                    <label for="<?php echo $this->settings_field; ?>[smtp_password]"><?php _e('SMTP Password:', 'calibrefx'); ?></label>
                    <input type="text" size="30" value="<?php echo calibrefx_get_option('smtp_password'); ?>" id="<?php echo $this->settings_field; ?>[smtp_password]" name="<?php echo $this->settings_field; ?>[smtp_password]">
                    <span class="description"><?php _e("Put your SMTP Password", 'calibrefx'); ?></span>
                </p>

            </div>  
        </div>  

        <hr class="div" />
        <h4><?php _e('Test Email', 'calibrefx'); ?></h4>
         <p>
            <label for="email-test"><?php _e('Email Recipient: ', 'calibrefx'); ?></label>
            <input type="text" size="30" value="" id="email-test" name="email-test">
            <label id="send-mail-res"></label><br/>
            <button class="button button-secondary" id="test-send-mail">Send</button>
        </p>

            

            <script type="text/javascript">

                // "smtp_use_auth":["#calibrefx-settings\\[smtp_use_auth\\]","#smtp_use_auth_box_content","1"]

                function checkbox_slide(i, $t){
                    if(jQuery(i).is(':checked')){
                        $t.slideDown('fast');
                    }else{                        
                        $t.slideUp('fast');
                    }
                }

                jQuery(document).ready(function($){
                    checkbox_slide(this, $("#smtp_use_auth_box_content"));
                    $("#calibrefx-settings-smtp_use_auth-box").click(function(){  
                        checkbox_slide(this, $("#smtp_use_auth_box_content"));
                    })

                    $("#calibrefx-settings\\[smtp_secure\\]").change(function(){
                        $this = $(this);

                        if($this.val() == '-1'){
                            $("#calibrefx-settings\\[smtp_port\\]").val("25");
                        }
                        else if($this.val() == 'tls'){
                            console.info('sdsdfsdf');
                            $("#calibrefx-settings\\[smtp_port\\]").val("965");
                        }
                        else if($this.val() == 'ssl'){
                            $("#calibrefx-settings\\[smtp_port\\]").val("465");
                        }
                    })
                });

            </script>

        
    <?php
    }*/

}