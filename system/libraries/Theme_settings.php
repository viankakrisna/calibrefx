<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://www.calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This File will handle theme-settings and provide default settings
 *
 * @package CalibreFx
 */

/**
 * Calibrefx Theme Setting Class
 *
 * @package		Calibrefx
 * @subpackage          Library
 * @author		CalibreWorks Team
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
            'enable_bootstrap' => 1,
            'blog_title' => 'text',
            'header_right' => 0,
            'layout_type' => 'fluid',
            'calibrefx_layout_width' => 960,
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
            'content_archive_limit' => 250,
            'posts_nav' => 'older-newer',
            'header_scripts' => '',
            'footer_scripts' => '',
            'calibrefx_version' => FRAMEWORK_VERSION,
            'calibrefx_db_version' => FRAMEWORK_DB_VERSION)
        );

        //we need to initialize the model
        $CFX = & calibrefx_get_instance();
        $CFX->load->model('theme_settings_m');
        $this->_model = & $CFX->theme_settings_m;

        $this->initialize();
    }

    /**
     * Register Our Security Filters
     *
     * $return void
     */
    public function security_filters() {
        $CFX = & calibrefx_get_instance();

        $CFX->security->add_sanitize_filter(
                'one_zero', $this->settings_field, array(
            'update',
            'enable_bootstrap',
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

        $CFX->security->add_sanitize_filter(
                'safe_text', $this->settings_field, array(
            'blog_title',
            'calibrefx_version',
            'calibrefx_db_version',
            'posts_nav',
            'content_archive',
            'layout_type',
            'site_layout')
        );

        $CFX->security->add_sanitize_filter(
                'integer', $this->settings_field, array(
            'calibrefx_layout_width',
            'content_archive_limit',
            'calibrefx_db_version')
        );
    }

    public function meta_sections() {
        global $calibrefx_current_section;

        calibrefx_clear_meta_section();

        calibrefx_add_meta_section('general', __('General', 'calibrefx'));
        calibrefx_add_meta_section('design', __('Design', 'calibrefx'));
        calibrefx_add_meta_section('social', __('Social', 'calibrefx'));

        do_action('more_theme_setting');

        $calibrefx_current_section = 'general';
        if (!empty($_GET['section'])) {
            $calibrefx_current_section = sanitize_text_field($_GET['section']);
        }
    }

    public function meta_boxes() {
        calibrefx_add_meta_box('general', 'basic', 'calibrefx-theme-settings-navigation', __('Navigation Settings', 'calibrefx'), array($this, 'navigation_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('general', 'professor', 'calibrefx-theme-settings-content-archive', __('Content Archives', 'calibrefx'), array($this, 'content_archive_box'), $this->pagehook, 'side');
        calibrefx_add_meta_box('general', 'professor', 'calibrefx-theme-settings-breadcrumb', __('Breadcrumbs', 'calibrefx'), array($this, 'breadcrumb_box'), $this->pagehook, 'side');
        calibrefx_add_meta_box('general', 'professor', 'calibrefx-theme-settings-comment', __('Comment and Trackbacks', 'calibrefx'), array($this, 'comment_box'), $this->pagehook, 'side');

        calibrefx_add_meta_box('design', 'basic', 'calibrefx-theme-settings-layout', __('Default Layout Settings', 'calibrefx'), array($this, 'layout_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('design', 'professor', 'calibrefx-theme-settings-custom-script', __('Themes Custom Script', 'calibrefx'), array($this, 'custom_script_box'), $this->pagehook, 'side');


        calibrefx_add_meta_box('social', 'basic', 'calibrefx-theme-settings-feeds', __('Feeds Setting', 'calibrefx'), array($this, 'feeds_box'), $this->pagehook, 'main');
        calibrefx_add_meta_box('social', 'basic', 'calibrefx-theme-social-link', __('Social Media Links', 'calibrefx'), array($this, 'social_link'), $this->pagehook, 'main');
        calibrefx_add_meta_box('social', 'professor', 'calibrefx-theme-settings-socials', __('Social Settings', 'calibrefx'), array($this, 'socials_box'), $this->pagehook, 'side');
    }

    //Meta Boxes Sections
    /**
     * Show navigation setting box
     */
    function navigation_box() {
        ?>
        <?php if (calibrefx_nav_menu_supported('primary')) : ?>
            <h4><?php _e('Primary Navigation', 'calibrefx'); ?></h4>
            <p>
                <input type="checkbox" name="" target="calibrefx-settings-nav" value="1" id="calibrefx-settings-checkbox-nav" class="calibrefx-settings-checkbox" <?php checked(1, calibrefx_get_option('nav')); ?> /> <label for="calibrefx-settings-checkbox-nav"><?php _e("Include Primary Navigation Menu?", 'calibrefx'); ?></label>
                <input type="hidden" name="<?php echo $this->settings_field; ?>[nav]" id="calibrefx-settings-nav" value="<?php echo calibrefx_get_option('nav'); ?>" />
            </p>
            <p><span class="description"><?php _e('You can assign your primary menu from Appreances > Menus.', 'calibrefx'); ?></span></p>
            <hr class="div" />
        <?php endif; ?>

        <?php if (calibrefx_nav_menu_supported('secondary')) : ?>
            <h4><?php _e('Secondary Navigation', 'calibrefx'); ?></h4>
            <p>
                <input type="checkbox" name="" target="calibrefx-settings-subnav" id="calibrefx-settings-checkbox-subnav" value="1" class="calibrefx-settings-checkbox" <?php checked(1, calibrefx_get_option('subnav')); ?> /> <label for="calibrefx-settings-checkbox-subnav"><?php _e("Include Secondary Navigation Menu?", 'calibrefx'); ?></label>
                <input type="hidden" name="<?php echo $this->settings_field; ?>[subnav]" id="calibrefx-settings-subnav" value="<?php echo calibrefx_get_option('subnav'); ?>" />
            </p>
            <p><span class="description"><?php _e('You can assign your secondary menu from Appreances > Menus.', 'calibrefx'); ?></span></p>
            <hr class="div" />
        <?php endif; ?>

        <p><span class="description"><?php printf(__('Please build a <a href="%s">custom menu</a>, then assign it to the proper Menu Location.', 'calibrefx'), admin_url('nav-menus.php')); ?></span></p>
        <?php
    }

    /**
     * Show default layout box
     */
    function layout_box() {
        global $calibrefx_user_ability;
        if ($calibrefx_user_ability === 'professor') {
            ?>
            <p><label><?php _e('Enable Bootstrap', 'calibrefx'); ?></label>
                <label for="calibrefx-settings-checkbox-enable-bootstrap">
                    <input type="checkbox" name="" id="calibrefx-settings-checkbox-enable-bootstrap" value="1" <?php checked(1, calibrefx_get_option('enable_bootstrap')); ?> target="calibrefx-settings-enable-bootstrap" class="calibrefx-settings-checkbox"  />
                </label>
                <input type="hidden" name="<?php echo $this->settings_field; ?>[enable_bootstrap]" id="calibrefx-settings-enable-bootstrap" value="<?php echo calibrefx_get_option('enable_bootstrap'); ?>" />
                <span class="description"><?php printf(__('This option will use Twitter Bootstrap as css and javascript libraries.', 'calibrefx'), admin_url('nav-menus.php')); ?></span>
            </p>

            <hr class="div" />

            <p><label><?php _e('Enable Responsive Layout', 'calibrefx'); ?></label>
                <label for="calibrefx-settings-checkbox-enable-responsive">
                    <input type="checkbox" name="" id="calibrefx-settings-checkbox-enable-responsive" value="1" <?php checked(1, calibrefx_get_option('enable_responsive')); ?> target="calibrefx-settings-enable-responsive" class="calibrefx-settings-checkbox" />
                </label>
                <input type="hidden" name="<?php echo $this->settings_field; ?>[enable_responsive]" id="calibrefx-settings-enable-responsive" value="<?php echo calibrefx_get_option('enable_responsive'); ?>" />
                <span class="description"><?php printf(__('This option will enable responsive layout.', 'calibrefx'), admin_url('nav-menus.php')); ?></span>
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
        function custom_script_box() {
            ?>
        <p><?php _e("Custom CSS code will be output at <code>wp_head()</code>:", 'calibrefx'); ?></p>
        <textarea name="<?php echo $this->settings_field; ?>[custom_css]" cols="78" rows="8"><?php echo stripslashes(esc_textarea(calibrefx_get_option('custom_css'))); ?></textarea>
        <p>
            <span class="description"><?php _e('You can add your custom css codes here. Example: <code>a.hover {color:#ffffff}</code> .', 'calibrefx'); ?></span>
        </p>

        <hr class="div" />

        <p><?php _e("Header script will be output at <code>wp_head()</code>:", 'calibrefx'); ?></p>
        <textarea name="<?php echo $this->settings_field; ?>[header_scripts]" cols="78" rows="8"><?php echo stripslashes(esc_textarea(calibrefx_get_option('header_scripts'))); ?></textarea>
        <p>
            <span class="description"><?php _e('You can add your javascript at the head of the page. For example Google analytics code. <br/>Samples: <code>&lt;script type="text/javascript">alert("Hello World");&lt;/script></code>', 'calibrefx'); ?></span></p>

        <hr class="div" />

        <p><?php _e("Footer scripts will be output at <code>wp_footer()</code>:", 'calibrefx'); ?></p>
        <textarea name="<?php echo $this->settings_field; ?>[footer_scripts]" cols="78" rows="8"><?php echo stripslashes(esc_textarea(calibrefx_get_option('footer_scripts'))); ?></textarea>
        <p>
            <span class="description"><?php _e('You can add your javascript at the footer of the page. For example tracking code. <br/>Samples: <code>&lt;script type="text/javascript">alert("Hello World");&lt;/script></code>', 'calibrefx'); ?></span></p>
        <?php
    }

    /**
     * Show content archive box inside Theme Settings 
     */
    function content_archive_box() {
        ?>
        <p>
            <label for="<?php echo $this->settings_field; ?>[content_archive]"><?php _e('Select one of the following:', 'calibrefx'); ?></label>
            <select name="<?php echo $this->settings_field; ?>[content_archive]" id="<?php echo $this->settings_field; ?>[content_archive]">
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
        </p>

        <div id="calibrefx_content_limit_setting">
            <p>
                <label for="<?php echo $this->settings_field; ?>[content_archive_limit]"><?php _e('Limit content to', 'calibrefx'); ?>
                    <input type="text" name="<?php echo $this->settings_field; ?>[content_archive_limit]" value="<?php echo esc_attr(calibrefx_get_option('content_archive_limit')); ?>" size="3" />
        <?php _e('characters', 'calibrefx'); ?></label>
            </p>

            <p><span class="description"><?php _e('This option will limit the text and strip all formatting from the text displayed. Use this option, with "Display post content" in the selected box above.', 'calibrefx'); ?></span></p>
        </div>

        <hr class="div" />

        <p>
            <label for="<?php echo $this->settings_field; ?>[posts_nav]"><?php _e('Select Post Navigation:', 'calibrefx'); ?></label>
            <select name="<?php echo $this->settings_field; ?>[posts_nav]" id="<?php echo $this->settings_field; ?>[posts_nav]">
            <?php
            $postnav_display = apply_filters(
                    'calibrefx_post_navigation_options', array(
                    'older-newer' => __('older/Newer', 'calibrefx'),
                    'prev-next' => __('Previous/Next', 'calibrefx'),
                    'numeric' => __('Numeric', 'calibrefx'),
                    )
            );

            foreach ((array) $postnav_display as $value => $name)
                echo '<option value="' . esc_attr($value) . '"' . selected(calibrefx_get_option('posts_nav'), esc_attr($value), false) . '>' . esc_html($name) . '</option>' . "\n";
            ?>
            </select>
        </p>
        <p><span class="description"><?php _e('You can choose your navigation format. Choices: Numeric, Older-Newer, or Previous-Next', 'calibrefx'); ?></span></p>
        <?php
        }

            /**
             * Show breadcrumb box inside Theme Settings
             */
    function breadcrumb_box() {
                ?>
        <p><?php _e("Show Breadcrumb on:", 'calibrefx'); ?></p>

        <!-- breadcrumb breadcrumb_home -->
        <label for="calibrefx-settings-checkbox-breadcrumb-home">
            <input type="checkbox" name="" id="calibrefx-settings-checkbox-breadcrumb-home" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_home')); ?> target="calibrefx-settings-breadcrumb-home" class="calibrefx-settings-checkbox" /> <?php _e("Front Page", 'calibrefx'); ?>
        </label>
        <input type="hidden" name="<?php echo $this->settings_field; ?>[breadcrumb_home]" id="calibrefx-settings-breadcrumb-home" value="<?php echo calibrefx_get_option('breadcrumb_home'); ?>" />

        <!-- breadcrumb breadcrumb_single -->
        <label for="calibrefx-settings-checkbox-breadcrumb-single">
            <input type="checkbox" name="" id="calibrefx-settings-checkbox-breadcrumb-single" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_single')); ?> target="calibrefx-settings-breadcrumb-single" class="calibrefx-settings-checkbox" /> <?php _e("Posts", 'calibrefx'); ?></label>
        <input type="hidden" name="<?php echo $this->settings_field; ?>[breadcrumb_single]" id="calibrefx-settings-breadcrumb-single" value="<?php echo calibrefx_get_option('breadcrumb_single'); ?>" />

        <!-- breadcrumb breadcrumb_page -->
        <label for="calibrefx-settings-checkbox-breadcrumb-page">
            <input type="checkbox" name="" id="calibrefx-settings-checkbox-breadcrumb-page" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_page')); ?> target="calibrefx-settings-breadcrumb-page" class="calibrefx-settings-checkbox" /> <?php _e("Pages", 'calibrefx'); ?></label>
        <input type="hidden" name="<?php echo $this->settings_field; ?>[breadcrumb_page]" id="calibrefx-settings-breadcrumb-page" value="<?php echo calibrefx_get_option('breadcrumb_page'); ?>" />

        <!-- breadcrumb breadcrumb_archive -->
        <label for="calibrefx-settings-checkbox-breadcrumb-archive">
            <input type="checkbox" name="" id="calibrefx-settings-checkbox-breadcrumb-archive" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_archive')); ?> target="calibrefx-settings-breadcrumb-archive" class="calibrefx-settings-checkbox" /> <?php _e("Archives", 'calibrefx'); ?></label>
        <input type="hidden" name="<?php echo $this->settings_field; ?>[breadcrumb_archive]" id="calibrefx-settings-breadcrumb-archive" value="<?php echo calibrefx_get_option('breadcrumb_archive'); ?>" />

        <!-- breadcrumb breadcrumb_404 -->
        <label for="calibrefx-settings-checkbox-breadcrumb-404">
            <input type="checkbox" name="" id="calibrefx-settings-checkbox-breadcrumb-404" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_404')); ?> target="calibrefx-settings-breadcrumb-404" class="calibrefx-settings-checkbox" /> <?php _e("404 Page", 'calibrefx'); ?></label>
        <input type="hidden" name="<?php echo $this->settings_field; ?>[breadcrumb_404]" id="calibrefx-settings-breadcrumb-404" value="<?php echo calibrefx_get_option('breadcrumb_404'); ?>" />
        
        <p><span class="description"><?php _e('You can choose where you want to show breadcrumb (sitemap navigation) links.', 'calibrefx'); ?></span></p>
        <?php
    }

    /**
     * Show breadcrumb box inside Theme Settings
     */
    function comment_box() {
        ?>

        <p><label><?php _e('Enable Comments', 'calibrefx'); ?></label>
            <!-- comment comments_posts -->
            <label for="calibrefx-settings-checkbox-comments-posts">
                <input type="checkbox" name="" id="calibrefx-settings-checkbox-comments-posts" value="1" <?php checked(1, calibrefx_get_option('comments_posts')); ?> target="calibrefx-settings-comments-posts" class="calibrefx-settings-checkbox" /> <?php _e("on posts?", 'calibrefx'); ?>
            </label>
            <input type="hidden" name="<?php echo $this->settings_field; ?>[comments_posts]" id="calibrefx-settings-comments-posts" value="<?php echo calibrefx_get_option('comments_posts'); ?>" />

            <!-- comment comments_pages -->
            <label for="calibrefx-settings-checkbox-comments-pages">
                <input type="checkbox" name="" id="calibrefx-settings-checkbox-comments-pages" value="1" <?php checked(1, calibrefx_get_option('comments_pages')); ?> target="calibrefx-settings-comments-pages" class="calibrefx-settings-checkbox" /> <?php _e("on pages?", 'calibrefx'); ?>
            </label>
            <input type="hidden" name="<?php echo $this->settings_field; ?>[comments_pages]" id="calibrefx-settings-comments-pages" value="<?php echo calibrefx_get_option('comments_pages'); ?>" />
        </p>

        <p><label><?php _e('Enable Trackbacks', 'calibrefx'); ?></label>
            <!-- trackback trackbacks_posts -->
            <label for="calibrefx-settings-checkbox-trackbacks-posts">
                <input type="checkbox" name="" id="calibrefx-settings-checkbox-trackbacks-posts" value="1" <?php checked(1, calibrefx_get_option('trackbacks_posts')); ?> target="calibrefx-settings-trackbacks-posts" class="calibrefx-settings-checkbox" /> <?php _e("on posts?", 'calibrefx'); ?>
            </label>
            <input type="hidden" name="<?php echo $this->settings_field; ?>[trackbacks_posts]" id="calibrefx-settings-trackbacks-posts" value="<?php echo calibrefx_get_option('trackbacks_posts'); ?>" />

            <!-- trackback trackbacks_pages -->
            <label for="calibrefx-settings-checkbox-trackbacks-pages">
                <input type="checkbox" name="" id="calibrefx-settings-checkbox-trackbacks-pages" value="1" <?php checked(1, calibrefx_get_option('trackbacks_pages')); ?> target="calibrefx-settings-trackbacks-pages" class="calibrefx-settings-checkbox" /> <?php _e("on pages?", 'calibrefx'); ?>
            </label>
            <input type="hidden" name="<?php echo $this->settings_field; ?>[trackbacks_pages]" id="calibrefx-settings-trackbacks-pages" value="<?php echo calibrefx_get_option('trackbacks_pages'); ?>" />
        </p>

        <p><span class="description"><?php _e("You can generally enabled/disabled comments and trackbacks per post/page.", 'calibrefx'); ?></span></p>
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
        <hr class="div" />
        <h4><?php _e('Twitter Settings:', 'calibrefx'); ?></h4>
        <p>
            <label for="<?php echo $this->settings_field; ?>[twitter_username]"><?php _e('Twiiter Username:', 'calibrefx'); ?></label>
            <input type="text" size="30" value="<?php echo calibrefx_get_option('twitter_username'); ?>" id="<?php echo $this->settings_field; ?>[twitter_username]" name="<?php echo $this->settings_field; ?>[twitter_username]">
            <span class="description"><?php _e("This will use for Latest Tweets Widget to show your latest tweets on the sidebar or footer.", 'calibrefx'); ?></span>
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
        <?php
    }

}