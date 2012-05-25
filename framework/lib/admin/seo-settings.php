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
 * Handle framework about page
 *
 * @package CalibreFx
 */
add_action('admin_init', 'calibrefx_register_seo_settings', 5);

/**
 * This function will save or reset settings
 */
function calibrefx_register_seo_settings() {
    register_setting(CALIBREFX_SEO_SETTINGS_FIELD, CALIBREFX_SEO_SETTINGS_FIELD);
    add_option(CALIBREFX_SEO_SETTINGS_FIELD, calibrefx_seo_settings_defaults());

    if (!isset($_REQUEST['page']) || $_REQUEST['page'] != 'calibrefx-seo')
        return;
    
    if (calibrefx_get_option('reset', CALIBREFX_SEO_SETTINGS_FIELD)) {
        
        update_option(CALIBREFX_SEO_SETTINGS_FIELD, calibrefx_seo_settings_defaults());

        calibrefx_admin_redirect('calibrefx-seo', array('reset' => 'true'));
        exit;
    }
}

add_action('admin_notices', 'calibrefx_seo_settings_notice');

/**
 * This function will show notification after save/reset settings
 */
function calibrefx_seo_settings_notice() {

    if (!isset($_REQUEST['page']) || $_REQUEST['page'] != 'calibrefx-seo')
        return;

    if (isset($_REQUEST['reset']) && 'true' == $_REQUEST['reset'])
        echo '<div id="message" class="updated"><p><strong>' . __('Settings reset.', 'calibrefx') . '</strong></p></div>';
    elseif (isset($_REQUEST['settings-updated']) && $_REQUEST['settings-updated'] == 'true')
        echo '<div id="message" class="updated"><p><strong>' . __('Settings saved.') . '</strong></p></div>';
}

add_action('admin_menu', 'calibrefx_seo_settings_init');
/**
 * This function will load scripts, styles and settings field
 */
function calibrefx_seo_settings_init() {
	global $_calibrefx_seo_settings_pagehook;

	add_action('load-'.$_calibrefx_seo_settings_pagehook, 'calibrefx_theme_settings_scripts');
	add_action('load-'.$_calibrefx_seo_settings_pagehook, 'calibrefx_theme_settings_styles');
	add_action('load-'.$_calibrefx_seo_settings_pagehook, 'calibrefx_seo_settings_boxes');
}

/**
 * This function load meta boxes
 */
function calibrefx_seo_settings_boxes() {
    global $_calibrefx_seo_settings_pagehook;
	
    //Metabox on main postbox
    add_meta_box('calibrefx-seo-settings-document-settings', __('Document Settings', 'calibrefx'), 'calibrefx_seo_settings_document_box', $_calibrefx_seo_settings_pagehook, 'main', 'high');

    //Metabox on side postbox
    add_meta_box('calibrefx-seo-settings-home-settings', __('Home Settings', 'calibrefx'), 'calibrefx_seo_settings_home_box', $_calibrefx_seo_settings_pagehook, 'side', 'high');
    add_meta_box('calibrefx-seo-settings-robot-meta-settings', __('Robot Meta Settings', 'calibrefx'), 'calibrefx_seo_settings_robot_box', $_calibrefx_seo_settings_pagehook, 'side');
    add_meta_box('calibrefx-seo-settings-archive-settings', __('Archive Settings', 'calibrefx'), 'calibrefx_seo_settings_archive_box', $_calibrefx_seo_settings_pagehook, 'side');
}

/**
 * This function will outout the seo settings layout to wordpress
 */
function calibrefx_seo_settings_admin() {
    global $_calibrefx_seo_settings_pagehook, $wp_meta_boxes;
    ?>
    <div id="calibrefx-seo-settings-page" class="wrap calibrefx-metaboxes">
        <form method="post" action="options.php">
            <?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false); ?>
            <?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false); ?>
            <?php settings_fields(CALIBREFX_SEO_SETTINGS_FIELD); // important! ?>
            <?php screen_icon('options-general'); ?>
            <h2>
                <?php _e('CalibreFx - SEO Settings', 'calibrefx'); ?>
            </h2>

            <div class="calibrefx-submit-button">
                <input type="submit" class="button-primary calibrefx-h2-button" value="<?php _e('Save Settings', 'calibrefx') ?>" />
                <input type="submit" class="button-highlighted calibrefx-h2-button" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[reset]" value="<?php _e('Reset Settings', 'calibrefx'); ?>" onclick="return calibrefx_confirm('<?php echo esc_js(__('Are you sure you want to reset?', 'calibrefx')); ?>');" />
            </div>

            <div class="metabox-holder">
                <div class="postbox-container main-postbox">
                    <?php
                    do_meta_boxes($_calibrefx_seo_settings_pagehook, 'main', null);
                    ?>
                </div>

                <div class="postbox-container side-postbox">
                    <?php
                    do_meta_boxes($_calibrefx_seo_settings_pagehook, 'side', null);
                    ?>
                </div>
            </div>

            <div class="clear"></div>
            <div class="calibrefx-submit-button">
                <input type="submit" class="button-primary calibrefx-h2-button" value="<?php _e('Save Settings', 'calibrefx') ?>" />
                <input type="submit" class="button-highlighted calibrefx-h2-button" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[reset]" value="<?php _e('Reset Settings', 'calibrefx'); ?>" onclick="return calibrefx_confirm('<?php echo esc_js(__('Are you sure you want to reset?', 'calibrefx')); ?>');" />
            </div>
        </form>
    </div>
    <script type="text/javascript">
        //<![CDATA[
        jQuery(document).ready( function($) {
            // close postboxes that should be closed
            $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
            // postboxes setup
            postboxes.add_postbox_toggles('<?php echo $_calibrefx_seo_settings_pagehook; ?>');
        });
        //]]>
    </script>

    <?php
}

/**
 * Show document setting box
 */
function calibrefx_seo_settings_document_box(){ ?>
    <span class="description">
        The Document Title is the single most important SEO tag in your document source. It will tell search engines the information contained in the document. The doctitle changes from page to page, but these options will help you control what it looks by default.
    </span>
    <p>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[doc_canonical_url]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[doc_canonical_url]" value="1" <?php checked(1, calibrefx_get_seo_option('doc_canonical_url')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[doc_canonical_url]"><?php _e("Enable Canonical URL?", 'calibrefx'); ?></label><br/>
        <span class="description">This option will automatically generate Canonical URLS for your entire WordPress installation. This will help to prevent duplicate content penalties by Google.</span>
    </p>
    <p>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[doc_enable_rewrite_title]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[doc_enable_rewrite_title]" value="1" <?php checked(1, calibrefx_get_seo_option('doc_enable_rewrite_title')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[doc_enable_rewrite_title]"><?php _e("Enable Rewrite Title?", 'calibrefx'); ?></label><br/>
        <span class="description">This option will automatically generate title for your entire site (can be override from post).</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[post_rewrite_title]"><?php _e('Post Rewrite Title:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('post_rewrite_title'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[post_rewrite_title]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[post_rewrite_title]">
        <span class="description">This option will automatically generate title for your entire post.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[page_rewrite_title]"><?php _e('Page Rewrite Title:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('page_rewrite_title'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[page_rewrite_title]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[page_rewrite_title]">
        <span class="description">This option will automatically generate title for your entire page.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[category_rewrite_title]"><?php _e('Category Rewrite Title:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('category_rewrite_title'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[category_rewrite_title]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[category_rewrite_title]">
        <span class="description">This option will automatically generate title for your entire category.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[archive_rewrite_title]"><?php _e('Archive Rewrite Title:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('archive_rewrite_title'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[archive_rewrite_title]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[archive_rewrite_title]">
        <span class="description">This option will automatically generate title for your entire archive.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_rewrite_title]"><?php _e('Author Rewrite Title:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('author_rewrite_title'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_rewrite_title]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_rewrite_title]">
        <span class="description">This option will automatically generate title for author page.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_rewrite_title]"><?php _e('Tag Rewrite Title:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('tag_rewrite_title'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_rewrite_title]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_rewrite_title]">
        <span class="description">This option will automatically generate title for your entire tag page.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_rewrite_title]"><?php _e('Search Rewrite Title:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('search_rewrite_title'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_rewrite_title]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_rewrite_title]">
        <span class="description">This option will automatically generate title for your Search page result.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[404_rewrite_title]"><?php _e('404 Rewrite Title:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('404_rewrite_title'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[404_rewrite_title]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[404_rewrite_title]">
        <span class="description">This option will automatically generate title for your Search page result.</span>
    </p>
    
    <span class="description">
        The Document Description Format. It will tell search engines the information contained in the document.
    </span>
    
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[post_description]"><?php _e('Post Description Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('post_description'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[post_description]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[post_description]">
        <span class="description">This option will automatically generate description for your entire post.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[page_description]"><?php _e('Page Description Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('page_description'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[page_description]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[page_description]">
        <span class="description">This option will automatically generate description for your entire page.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_description]"><?php _e('Search Description Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('search_description'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_description]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_description]">
        <span class="description">This option will automatically generate description for your search page.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[category_description]"><?php _e('Category Description Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('category_description'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[category_description]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[category_description]">
        <span class="description">This option will automatically generate description for your category page.</span>
    </p>
     <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_description]"><?php _e('Author Description Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('author_description'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_description]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_description]">
        <span class="description">This option will automatically generate description for your author page.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[archive_description]"><?php _e('Archive Description Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('archive_description'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[archive_description]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[archive_description]">
        <span class="description">This option will automatically generate description for your archive page.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_description]"><?php _e('Tag Description Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('tag_description'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_description]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_description]">
        <span class="description">This option will automatically generate description for your tag page.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[404_description]"><?php _e('404 Page Description Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('404_description'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[404_description]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[404_description]">
        <span class="description">This option will automatically generate description for your 404 page.</span>
    </p>
    
    <span class="description">
        The Document Keywords Format. It will tell search engines the information contained in the document.
    </span>
    
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[post_keywords]"><?php _e('Post Keywords Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('post_keywords'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[post_keywords]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[post_keywords]">
        <span class="description">This option will automatically generate keywords for your entire post.</span>
    </p>
    
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[post_keywords]"><?php _e('Post Keywords Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('post_keywords'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[post_keywords]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[post_keywords]">
        <span class="description">This option will automatically generate keywords for your entire post.</span>
    </p>
    
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[page_keywords]"><?php _e('Page Keywords Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('page_keywords'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[page_keywords]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[page_keywords]">
        <span class="description">This option will automatically generate keywords for your entire page.</span>
    </p>
    
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_keywords]"><?php _e('Author Keywords Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('author_keywords'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_keywords]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_keywords]">
        <span class="description">This option will automatically generate keywords for your author page.</span>
    </p>
    
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_keywords]"><?php _e('Search Keywords Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('search_keywords'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_keywords]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_keywords]">
        <span class="description">This option will automatically generate keywords for your search page.</span>
    </p>
    
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[archive_keywords]"><?php _e('Archive Keywords Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('archive_keywords'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[archive_keywords]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[archive_keywords]">
        <span class="description">This option will automatically generate keywords for your archive page.</span>
    </p>
    
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_keywords]"><?php _e('Tag Keywords Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('tag_keywords'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_keywords]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_keywords]">
        <span class="description">This option will automatically generate keywords for your tag archive page.</span>
    </p>
    
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[404_keywords]"><?php _e('404 Keywords Format:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('404_keywords'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[404_keywords]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[404_keywords]">
        <span class="description">This option will automatically generate keywords for your 404 page.</span>
    </p>
<?php    
}

/**
 * Show home setting box
 */
function calibrefx_seo_settings_home_box(){ ?>
    <span class="description">
        The Home Title is the single most important SEO tag in your document source. It will tell search engines the information contained in the document especially in your homepage.
    </span>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_title]"><?php _e('Home Title:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('home_title'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_title]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_title]">
        <span class="description">If you leave the home title field blank, your site’s title will be used instead.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_meta_description]"><?php _e('Home Meta Description:', 'calibrefx'); ?></label>
        <textarea cols="70" rows="3" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_meta_description]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_meta_description]"></textarea>
        <span class="description">If you leave the home title field blank, your site’s title will be used instead.</span>
    </p>
    <p>
        <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_meta_keywords]"><?php _e('Home Meta Keywords:', 'calibrefx'); ?></label>
        <input type="text" size="80" value="<?php echo calibrefx_seo_option('home_meta_keywords'); ?>" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_meta_keywords]" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_meta_keywords]">
        <span class="description">If you leave the home title field blank, your site’s title will be used instead.</span>
    </p>
    
    <h4>Homepage Robots Meta Tags:</h4>
    
    <p>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_noindex]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_noindex]" value="1" <?php checked(1, calibrefx_get_seo_option('home_noindex')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_noindex]"><?php _e("Apply <code>noindex</code> to the homepage?", 'calibrefx'); ?></label><br/>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_nofollow]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_nofollow]" value="1" <?php checked(1, calibrefx_get_seo_option('home_nofollow')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_nofollow]"><?php _e("Apply <code>nofollow</code> to the homepage?", 'calibrefx'); ?></label><br/>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_noarchive]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_noarchive]" value="1" <?php checked(1, calibrefx_get_seo_option('home_noarchive')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[home_noarchive]"><?php _e("Apply <code>noarchive</code> to the homepage?", 'calibrefx'); ?></label><br/>
    </p>
<?php
}

/**
 * Show robot setting box
 */
function calibrefx_seo_settings_robot_box(){ ?>
    <span class="description">
        The Document Title is the single most important SEO tag in your document source. It succinctly informs search engines of what information is contained in the document. The doctitle changes from page to page, but these options will help you control what it looks by default.
    </span>
    <p>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[category_noindex]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[category_noindex]" value="1" <?php checked(1, calibrefx_get_seo_option('category_noindex')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[category_noindex]"><?php _e("Apply <code>noindex</code> to Category Archives?", 'calibrefx'); ?></label><br/>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_noindex]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_noindex]" value="1" <?php checked(1, calibrefx_get_seo_option('tag_noindex')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_noindex]"><?php _e("Apply <code>noindex</code> to Tag Archives?", 'calibrefx'); ?></label><br/>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_noindex]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_noindex]" value="1" <?php checked(1, calibrefx_get_seo_option('author_noindex')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_noindex]"><?php _e("Apply <code>noindex</code> to Author Archives?", 'calibrefx'); ?></label><br/>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[date_noindex]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[date_noindex]" value="1" <?php checked(1, calibrefx_get_seo_option('date_noindex')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[date_noindex]"><?php _e("Apply <code>noindex</code> to Date Archives?", 'calibrefx'); ?></label><br/>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_noindex]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_noindex]" value="1" <?php checked(1, calibrefx_get_seo_option('search_noindex')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_noindex]"><?php _e("Apply <code>noindex</code> to Search Archives?", 'calibrefx'); ?></label><br/>
    </p>
    <span class="description">
        The Document Title is the single most important SEO tag in your document source. It succinctly informs search engines of what information is contained in the document. The doctitle changes from page to page, but these options will help you control what it looks by default.
    </span>
    <p>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[category_noarchive]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[category_noarchive]" value="1" <?php checked(1, calibrefx_get_seo_option('category_noarchive')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[category_noarchive]"><?php _e("Apply <code>noarchive</code> to Category Archives?", 'calibrefx'); ?></label><br/>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_noarchive]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_noarchive]" value="1" <?php checked(1, calibrefx_get_seo_option('tag_noarchive')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[tag_noarchive]"><?php _e("Apply <code>noarchive</code> to Tag Archives?", 'calibrefx'); ?></label><br/>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_noarchive]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_noarchive]" value="1" <?php checked(1, calibrefx_get_seo_option('author_noarchive')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[author_noarchive]"><?php _e("Apply <code>noarchive</code> to Author Archives?", 'calibrefx'); ?></label><br/>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[date_noarchive]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[date_noarchive]" value="1" <?php checked(1, calibrefx_get_seo_option('date_noarchive')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[date_noarchive]"><?php _e("Apply <code>noarchive</code> to Date Archives?", 'calibrefx'); ?></label><br/>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_noarchive]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_noarchive]" value="1" <?php checked(1, calibrefx_get_seo_option('search_noarchive')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[search_noarchive]"><?php _e("Apply <code>noarchive</code> to Search Archives?", 'calibrefx'); ?></label><br/>
    </p>
    <p>
        <span class="description">Occasionally, search engines use resources like the Open Directory Project and the Yahoo! Directory to find titles and descriptions for your content. Generally, you will not want them to do this. The <code>noodp</code> and <code>noydir</code> tags prevent them from doing so.</span>
    </p>
    <p>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[site_noarchive]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[site_noarchive]" value="1" <?php checked(1, calibrefx_get_seo_option('site_noarchive')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[site_noarchive]"><?php _e("Apply <code>noarchive</code> to your site?", 'calibrefx'); ?></label><br/>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[site_noodp]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[site_noodp]" value="1" <?php checked(1, calibrefx_get_seo_option('site_noodp')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[site_noodp]"><?php _e("Apply <code>noodp</code> to your site?", 'calibrefx'); ?></label><br/>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[site_noydir]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[site_noydir]" value="1" <?php checked(1, calibrefx_get_seo_option('site_noydir')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[site_noydir]"><?php _e("Apply <code>noydir</code> to your site?", 'calibrefx'); ?></label><br/>
    </p>
    
<?php
}

/**
 * Show archive setting box
 */
function calibrefx_seo_settings_archive_box(){ ?>
    <p>
        <input type="checkbox" name="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[archive_canonical]" id="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[category_noarchive]" value="1" <?php checked(1, calibrefx_get_seo_option('category_noarchive')); ?> /> <label for="<?php echo CALIBREFX_SEO_SETTINGS_FIELD; ?>[category_noarchive]"><?php _e("Canonical Paginated Archives", 'calibrefx'); ?></label><br/>
    </p>
<?php
}