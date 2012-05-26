<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibrefx.com
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
add_action('admin_init', 'calibrefx_register_theme_settings', 5);

/**
 * This function will save or reset settings
 */
function calibrefx_register_theme_settings() {
    register_setting(CALIBREFX_SETTINGS_FIELD, CALIBREFX_SETTINGS_FIELD);
    add_option(CALIBREFX_SETTINGS_FIELD, calibrefx_theme_settings_defaults());

    if (!isset($_REQUEST['page']) || $_REQUEST['page'] != 'calibrefx')
        return;

    if (calibrefx_get_option('reset')) {
        update_option(CALIBREFX_SETTINGS_FIELD, calibrefx_theme_settings_defaults());

        calibrefx_admin_redirect('calibrefx', array('reset' => 'true'));
        exit;
    }
}

add_action('admin_notices', 'calibrefx_theme_settings_notice');

/**
 * This function will show notification after save/reset settings
 */
function calibrefx_theme_settings_notice() {

    if (!isset($_REQUEST['page']) || $_REQUEST['page'] != 'calibrefx')
        return;

    if (isset($_REQUEST['reset']) && 'true' == $_REQUEST['reset'])
        echo '<div id="message" class="updated"><p><strong>' . __('Settings reset.', 'calibrefx') . '</strong></p></div>';
    elseif (isset($_REQUEST['settings-updated']) && $_REQUEST['settings-updated'] == 'true')
        echo '<div id="message" class="updated"><p><strong>' . __('Settings saved.') . '</strong></p></div>';
}

add_action('admin_menu', 'calibrefx_theme_settings_init');

/**
 * This function will load scripts, styles and settings field
 */
function calibrefx_theme_settings_init() {
    global $_calibrefx_theme_settings_pagehook;

    add_action('load-' . $_calibrefx_theme_settings_pagehook, 'calibrefx_theme_settings_scripts');
    add_action('load-' . $_calibrefx_theme_settings_pagehook, 'calibrefx_theme_settings_styles');
    add_action('load-' . $_calibrefx_theme_settings_pagehook, 'calibrefx_theme_settings_boxes');
}

/**
 * This function load required javascripts 
 */
function calibrefx_theme_settings_scripts() {
    wp_enqueue_script('common');
    wp_enqueue_script('wp-lists');
    wp_enqueue_script('postbox');
}

/**
 * This function load required styles 
 */
function calibrefx_theme_settings_styles() {
    wp_enqueue_style('calibrefx_admin_css');
}

/**
 * This function load meta boxes
 */
function calibrefx_theme_settings_boxes() {
    global $_calibrefx_theme_settings_pagehook;

    //Metabox on main postbox
    add_meta_box('calibrefx-theme-settings-navigation', __('Navigation Settings', 'calibrefx'), 'calibrefx_theme_settings_navigation_box', $_calibrefx_theme_settings_pagehook, 'main', 'high');
    add_meta_box('calibrefx-theme-settings-layout', __('Default Layout Settings', 'calibrefx'), 'calibrefx_theme_settings_layout_box', $_calibrefx_theme_settings_pagehook, 'main', 'high');
    add_meta_box('calibrefx-theme-settings-custom-script', __('Themes Custom Script', 'calibrefx'), 'calibrefx_theme_settings_custom_script_box', $_calibrefx_theme_settings_pagehook, 'main');

    //Metabox on side postbox
    add_meta_box('calibrefx-theme-settings-content-archive', __('Content Archives', 'calibrefx'), 'calibrefx_theme_settings_content_archive_box', $_calibrefx_theme_settings_pagehook, 'side');
    add_meta_box('calibrefx-theme-settings-breadcrumb', __('Breadcrumbs', 'calibrefx'), 'calibrefx_theme_settings_breadcrumb_box', $_calibrefx_theme_settings_pagehook, 'side');
    add_meta_box('calibrefx-theme-settings-comment', __('Comment and Trackbacks', 'calibrefx'), 'calibrefx_theme_settings_comment_box', $_calibrefx_theme_settings_pagehook, 'side');

    add_meta_box('calibrefx-theme-settings-socials', __('Social Settings', 'calibrefx'), 'calibrefx_theme_settings_socials_box', $_calibrefx_theme_settings_pagehook, 'side');
}

/**
 * This function will outout the settings layout to wordpress
 */
function calibrefx_theme_settings_admin() {
    global $_calibrefx_theme_settings_pagehook, $wp_meta_boxes;
    
    ?>
    <div id="calibrefx-theme-settings-page" class="wrap calibrefx-metaboxes">
        <form method="post" action="options.php">
            <?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false); ?>
            <?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false); ?>
            <?php settings_fields(CALIBREFX_SETTINGS_FIELD); // important! ?>
            <input type="hidden" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[calibrefx_version]>" value="<?php echo esc_attr(calibrefx_get_option('calibrefx_version')); ?>" />
            <input type="hidden" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[calibrefx_db_version]>" value="<?php echo esc_attr(calibrefx_get_option('calibrefx_db_version')); ?>" />

            <?php screen_icon('options-general'); ?>
            <h2>
                <?php _e('CalibreFx - Theme Settings', 'calibrefx'); ?>
            </h2>

            <div class="calibrefx-submit-button">
                <input type="submit" class="button-primary calibrefx-h2-button" value="<?php _e('Save Settings', 'calibrefx') ?>" />
                <input type="submit" class="button-highlighted calibrefx-h2-button" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[reset]" value="<?php _e('Reset Settings', 'calibrefx'); ?>" onclick="return calibrefx_confirm('<?php echo esc_js(__('Are you sure you want to reset?', 'calibrefx')); ?>');" />
            </div>

            <div class="metabox-holder">
                <div class="postbox-container main-postbox">
                    <?php
                    do_meta_boxes($_calibrefx_theme_settings_pagehook, 'main', null);
                    ?>
                </div>

                <div class="postbox-container side-postbox">
                    <?php
                    do_meta_boxes($_calibrefx_theme_settings_pagehook, 'side', null);
                    ?>
                </div>
            </div>

            <div class="clear"></div>
            <div class="calibrefx-submit-button">
                <input type="submit" class="button-primary calibrefx-h2-button" value="<?php _e('Save Settings', 'calibrefx') ?>" />
                <input type="submit" class="button-highlighted calibrefx-h2-button" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[reset]" value="<?php _e('Reset Settings', 'calibrefx'); ?>" onclick="return calibrefx_confirm('<?php echo esc_js(__('Are you sure you want to reset?', 'calibrefx')); ?>');" />
            </div>
        </form>
    </div>
    <script type="text/javascript">
        //<![CDATA[
        jQuery(document).ready( function($) {
            // close postboxes that should be closed
            $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
            // postboxes setup
            postboxes.add_postbox_toggles('<?php echo $_calibrefx_theme_settings_pagehook; ?>');
        });
        //]]>
    </script>
    <?php
}

/**
 * Show navigation setting box
 */
function calibrefx_theme_settings_navigation_box() {
    ?>
    <?php if (calibrefx_nav_menu_supported('primary')) : ?>
        <h4><?php _e('Primary Navigation', 'calibrefx'); ?></h4>
        <p>
            <input type="checkbox" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[nav]" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[nav]" value="1" <?php checked(1, calibrefx_get_option('nav')); ?> /> <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[nav]"><?php _e("Include Primary Navigation Menu?", 'calibrefx'); ?></label>
        </p>

        <hr class="div" />
    <?php endif; ?>

    <?php if (calibrefx_nav_menu_supported('secondary')) : ?>
        <h4><?php _e('Secondary Navigation', 'calibrefx'); ?></h4>
        <p>
            <input type="checkbox" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[subnav]" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[subnav]" value="1" <?php checked(1, calibrefx_get_option('subnav')); ?> /> <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[subnav]"><?php _e("Include Secondary Navigation Menu?", 'calibrefx'); ?></label>
        </p>

        <hr class="div" />
    <?php endif; ?>

    <p><span class="description"><?php printf(__('Please build a <a href="%s">custom menu</a>, then assign it to the proper Menu Location.', 'calibrefx'), admin_url('nav-menus.php')); ?></span></p>
    <?php
}

/**
 * Show default layout box
 */
function calibrefx_theme_settings_layout_box() {
    ?>

    <p>
        <label>Layout Type:</label>
        <select name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[layout_type]" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[layout_type]">
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
            <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[calibrefx_layout_width]"><?php _e('Layout Width', 'calibrefx'); ?>
                <input type="text" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[calibrefx_layout_width]" value="<?php echo esc_attr(calibrefx_get_option('calibrefx_layout_width')); ?>" size="3" />
        <?php _e('pixels', 'calibrefx'); ?></label>
        </p>

        <p><span class="description"><?php _e('This option will limit the width in pixels size.', 'calibrefx'); ?></span></p>
    </div>

    <hr class="div" />

    <p class="calibrefx-layout-selector">
        <?php
        calibrefx_layout_selector(array('name' => CALIBREFX_SETTINGS_FIELD . '[site_layout]', 'selected' => calibrefx_get_option('site_layout')));
        ?>
    </p>

    <br class="clear" />

    <?php
}

/**
 * Show setting box inside Theme Settings
 */
function calibrefx_theme_settings_custom_script_box() {
    ?>
    <p><?php _e("Custom CSS code will be output at <code>wp_head()</code>:", 'calibrefx'); ?></p>
    <textarea name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[custom_css]" cols="78" rows="8"><?php echo esc_textarea(calibrefx_get_option('custom_css')); ?></textarea>
    <p><span class="description"><?php _e('The <code>wp_head()</code> hook executes immediately before the closing <code>&lt;/head&gt;</code> tag in the document source.', 'calibrefx'); ?></span></p>

    <hr class="div" />

    <p><?php _e("Header script will be output at <code>wp_head()</code>:", 'calibrefx'); ?></p>
    <textarea name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[header_scripts]" cols="78" rows="8"><?php echo esc_textarea(calibrefx_get_option('header_scripts')); ?></textarea>
    <p><span class="description"><?php _e('The <code>wp_head()</code> hook executes immediately before the closing <code>&lt;/head&gt;</code> tag in the document source.', 'calibrefx'); ?></span></p>

    <hr class="div" />

    <p><?php _e("Footer scripts will be output at <code>wp_footer()</code>:", 'calibrefx'); ?></p>
    <textarea name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[footer_scripts]" cols="78" rows="8"><?php echo esc_textarea(calibrefx_get_option('footer_scripts')); ?></textarea>
    <p><span class="description"><?php _e('The <code>wp_footer()</code> hook executes immediately before the closing <code>&lt;/body&gt;</code> tag in the document source.', 'calibrefx'); ?></span></p>
    <?php
}

/**
 * Show content archive box inside Theme Settings 
 */
function calibrefx_theme_settings_content_archive_box() {
    ?>
    <p>
        <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[content_archive]"><?php _e('Select one of the following:', 'calibrefx'); ?></label>
        <select name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[content_archive]" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[content_archive]">
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
            <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[content_archive_limit]"><?php _e('Limit content to', 'calibrefx'); ?>
                <input type="text" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[content_archive_limit]" value="<?php echo esc_attr(calibrefx_get_option('content_archive_limit')); ?>" size="3" />
    <?php _e('characters', 'calibrefx'); ?></label>
        </p>

        <p><span class="description"><?php _e('This option will limit the text and strip all formatting from the text displayed. Use this option, with "Display post content" in the selected box above.', 'calibrefx'); ?></span></p>
    </div>

    <hr class="div" />

    <p>
        <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[posts_nav]"><?php _e('Select Post Navigation:', 'calibrefx'); ?></label>
        <select name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[posts_nav]" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[posts_nav]">
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
    <?php
}

/**
 * Show breadcrumb box inside Theme Settings
 */
function calibrefx_theme_settings_breadcrumb_box() {
    ?>
    <p><?php _e("Show Breadcrumb on:", 'calibrefx'); ?></p>

    <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_home]"><input type="checkbox" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_home]" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_home]" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_home')); ?> /> <?php _e("Front Page", 'calibrefx'); ?></label>
    <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_single]"><input type="checkbox" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_single]" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_single]" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_single')); ?> /> <?php _e("Posts", 'calibrefx'); ?></label>
    <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_page]"><input type="checkbox" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_page]" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_page]" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_page')); ?> /> <?php _e("Pages", 'calibrefx'); ?></label>
    <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_archive]"><input type="checkbox" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_archive]" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_archive]" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_archive')); ?> /> <?php _e("Archives", 'calibrefx'); ?></label>
    <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_404]"><input type="checkbox" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_404]" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[breadcrumb_404]" value="1" <?php checked(1, calibrefx_get_option('breadcrumb_404')); ?> /> <?php _e("404 Page", 'calibrefx'); ?></label>
    <?php
}

/**
 * Show breadcrumb box inside Theme Settings
 */
function calibrefx_theme_settings_comment_box() {
    ?>

    <p><label><?php _e('Enable Comments', 'calibrefx'); ?></label>
        <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[comments_posts]"><input type="checkbox" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[comments_posts]" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[comments_posts]" value="1" <?php checked(1, calibrefx_get_option('comments_posts')); ?> /> <?php _e("on posts?", 'calibrefx'); ?></label>
        <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[comments_pages]"><input type="checkbox" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[comments_pages]" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[comments_pages]" value="1" <?php checked(1, calibrefx_get_option('comments_pages')); ?> /> <?php _e("on pages?", 'calibrefx'); ?></label>
    </p>

    <p><label><?php _e('Enable Trackbacks', 'calibrefx'); ?></label>
        <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[trackbacks_posts]"><input type="checkbox" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[trackbacks_posts]" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[trackbacks_posts]" value="1" <?php checked(1, calibrefx_get_option('trackbacks_posts')); ?> /> <?php _e("on posts?", 'calibrefx'); ?></label>
        <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[trackbacks_pages]"><input type="checkbox" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[trackbacks_pages]" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[trackbacks_pages]" value="1" <?php checked(1, calibrefx_get_option('trackbacks_pages')); ?> /> <?php _e("on pages?", 'calibrefx'); ?></label>
    </p>

    <p><span class="description"><?php _e("You can generally enabled/disabled comments and trackbacks per post/page.", 'calibrefx'); ?></span></p>
    <?php
}

/**
 * This function calibrefx_theme_settings_socials_box is to show social settings
 * Use For Widgets
 */
function calibrefx_theme_settings_socials_box() {
    ?>
    <h4><?php _e('Facebook Settings:', 'calibrefx'); ?></h4>
    <p>
        <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[facebook_app_id]"><?php _e('Facebook APP ID:', 'calibrefx'); ?></label>
        <input type="text" size="30" value="<?php echo calibrefx_get_option('facebook_app_id'); ?>" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[facebook_app_id]" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[facebook_app_id]">
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[facebook_app_secret]"><?php _e('Facebook APP Secret:', 'calibrefx'); ?></label>
        <input type="text" size="30" value="<?php echo calibrefx_get_option('facebook_app_secret'); ?>" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[facebook_app_secret]" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[facebook_app_secret]">
    </p>

    <h4><?php _e('Twitter Settings:', 'calibrefx'); ?></h4>
    <p>
        <label for="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[twitter_username]"><?php _e('Twiiter Username:', 'calibrefx'); ?></label>
        <input type="text" size="30" value="<?php echo calibrefx_get_option('twitter_username'); ?>" id="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[twitter_username]" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[twitter_username]">
    </p>
<?php
}