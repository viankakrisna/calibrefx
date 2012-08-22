<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @link		http://calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 * 
 *
 * @package CalibreFx
 */
/**
 * Calibrefx Inpost Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
 */
add_action('admin_menu', 'calibrefx_add_inpost_layout_box');

/**
 * Register a new meta box to the post / page edit screen, so that the user can
 * set layout options on a per-post or per-page basis.
 *
 * @access public
 * @author Hilaladdiyar <hilal@calibrefx.com>
 * @return void
 *
 */
function calibrefx_add_inpost_layout_box() {
    if (!current_theme_supports('calibrefx-inpost-layouts'))
        return;

    foreach ((array) get_post_types(array('public' => true)) as $type) {
        if (post_type_supports($type, 'calibrefx-layouts'))
            add_meta_box('calibrefx_inpost_layout_box', __('Calibrefx Custom Layout', 'calibrefx'), 'calibrefx_inpost_layout_box', $type, 'normal', 'high');
    }
}

/**
 * Show inpost layout box
 */
function calibrefx_inpost_layout_box() {

    wp_nonce_field(plugin_basename(__FILE__), 'calibrefx_inpost_layout_nonce');

    $layout = calibrefx_get_custom_field('site_layout');
    ?>
    <div class="calibrefx-layout-selector">
        <p><input type="radio" name="_calibrefx_layout" id="default-layout" value="" <?php checked($layout, ''); ?> /> <label class="default" for="default-layout"><?php printf(__('Default Layout set in <a href="%s">Theme Settings</a>', 'calibrefx'), menu_page_url('calibrefx', 0)); ?></label></p>

        <p><?php calibrefx_layout_selector(array('name' => '_calibrefx_layout', 'selected' => $layout, 'type' => 'site')); ?></p>
    </div>

    <br class="clear" />

    <p><label for="calibrefx_custom_body_class"><b><?php _e('Custom Body Class', 'calibrefx'); ?></b></label></p>
    <p><input class="large-text" type="text" name="_calibrefx_custom_body_class" id="calibrefx_custom_body_class" value="<?php echo esc_attr(sanitize_html_class(calibrefx_get_custom_field('_calibrefx_custom_body_class'))); ?>" /></p>

    <p><label for="calibrefx_custom_post_class"><b><?php _e('Custom Post Class', 'calibrefx'); ?></b></label></p>
    <p><input class="large-text" type="text" name="_calibrefx_custom_post_class" id="calibrefx_custom_post_class" value="<?php echo esc_attr(sanitize_html_class(calibrefx_get_custom_field('_calibrefx_custom_post_class'))); ?>" /></p>
    <?php
}

add_action('save_post', 'calibrefx_inpost_layout_save', 1, 2);

/**
 * Saves the layout options when we save a post / page.
 *
 * It does so by grabbing the array passed in $_POST, looping through it, and
 * saving each key / value pair as a custom field.
 *
 * @access public
 * @author Hilaladdiyar <hilal@calibrefx.com>
 * @return voides
 */
function calibrefx_inpost_layout_save($post_id, $post) {

    /** 	Verify the nonce */
    if (!isset($_POST['calibrefx_inpost_layout_nonce']) || !wp_verify_nonce($_POST['calibrefx_inpost_layout_nonce'], plugin_basename(__FILE__)))
        return $post_id;

    /*     * Don't try to save the data under autosave, ajax, or future post. */
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
    if (defined('DOING_CRON') && DOING_CRON)
        return;

    /** 	Check capability */
    if (( 'page' == $_POST['post_type'] && !current_user_can('edit_page', $post_id) ) || !current_user_can('edit_post', $post_id))
        return $post_id;

    $calibrefx_post_layout = $_POST['_calibrefx_layout'];

    if ($calibrefx_post_layout)
        update_post_meta($post_id, 'site_layout', $calibrefx_post_layout);
    else
        delete_post_meta($post_id, 'site_layout');

    $calibrefx_custom_body_class = $_POST['_calibrefx_custom_body_class'];

    if ($calibrefx_custom_body_class)
        update_post_meta($post_id, '_calibrefx_custom_body_class', $calibrefx_custom_body_class);
    else
        delete_post_meta($post_id, '_calibrefx_custom_body_class');

    $calibrefx_custom_post_class = $_POST['_calibrefx_custom_post_class'];

    if ($calibrefx_custom_post_class)
        update_post_meta($post_id, '_calibrefx_custom_post_class', $calibrefx_custom_post_class);
    else
        delete_post_meta($post_id, '_calibrefx_custom_post_class');
}

add_action('admin_menu', 'calibrefx_add_inpost_seo_box');

/**
 * Register a new meta box to the post / page edit screen, so that the user can
 * set SEO options on a per-post or per-page basis.
 */
function calibrefx_add_inpost_seo_box() {

    foreach ((array) get_post_types(array('public' => true)) as $type) {
        if (post_type_supports($type, 'calibrefx-seo'))
            add_meta_box('calibrefx_inpost_seo_box', __('CalibreFx SEO Settings', 'calibrefx'), 'calibrefx_inpost_seo_box', $type, 'normal', 'high');
    }
}

/**
 * Show inpost seo box
 */
function calibrefx_inpost_seo_box() {
    ?>
    <input type="hidden" name="calibrefx_inpost_seo_nonce" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>" />

    <p><label for="calibrefx_title"><b><?php _e('Custom Document Title', 'calibrefx'); ?></b> <abbr title="&lt;title&gt; Tag">[?]</abbr> <span class="hide-if-no-js"><?php printf(__('Characters Used: %s', 'calibrefx'), '<span id="calibrefx_title_chars">' . strlen(calibrefx_get_custom_field('_calibrefx_title')) . '</span>'); ?></span></label></p>
    <p><input class="large-text" type="text" name="calibrefx_seo[_calibrefx_title]" id="calibrefx_title" value="<?php echo esc_attr(calibrefx_get_custom_field('_calibrefx_title')); ?>" /></p>

    <p><label for="calibrefx_description"><b><?php _e('Custom Post/Page Meta Description', 'calibrefx'); ?></b> <abbr title="&lt;meta name=&quot;description&quot; /&gt;">[?]</abbr> <span class="hide-if-no-js"><?php printf(__('Characters Used: %s', 'calibrefx'), '<span id="calibrefx_description_chars">' . strlen(calibrefx_get_custom_field('_calibrefx_description')) . '</span>'); ?></span></label></p>
    <p><textarea class="large-text" name="calibrefx_seo[_calibrefx_description]" id="calibrefx_description" rows="4" cols="4"><?php echo esc_textarea(calibrefx_get_custom_field('_calibrefx_description')); ?></textarea></p>

    <p><label for="calibrefx_keywords"><b><?php _e('Custom Post/Page Meta Keywords, comma separated', 'calibrefx'); ?></b> <abbr title="&lt;meta name=&quot;keywords&quot; /&gt;">[?]</abbr></label></p>
    <p><input class="large-text" type="text" name="calibrefx_seo[_calibrefx_keywords]" id="calibrefx_keywords" value="<?php echo esc_attr(calibrefx_get_custom_field('_calibrefx_keywords')); ?>" /></p>

    <p><label for="calibrefx_canonical"><b><?php _e('Custom Canonical URI', 'calibrefx'); ?></b> <a href="http://www.mattcutts.com/blog/canonical-link-tag/" target="_blank" title="&lt;link rel=&quot;canonical&quot; /&gt;">[?]</a></label></p>
    <p><input class="large-text" type="text" name="calibrefx_seo[_calibrefx_canonical_uri]" id="calibrefx_canonical" value="<?php echo esc_url(calibrefx_get_custom_field('_calibrefx_canonical_uri')); ?>" /></p>

    <p><label for="calibrefx_redirect"><b><?php _e('Custom Redirect URI', 'calibrefx'); ?></b> <a href="http://www.google.com/support/webmasters/bin/answer.py?hl=en&amp;answer=93633" target="_blank" title="301 Redirect">[?]</a></label></p>
    <p><input class="large-text" type="text" name="calibrefx_seo[_calibrefx_redirect_url]" id="calibrefx_redirect_url" value="<?php echo esc_url(calibrefx_get_custom_field('_calibrefx_redirect_url')); ?>" /></p>

    <br />

    <p><b><?php _e('Robots Meta Settings', 'calibrefx'); ?></b></p>

    <p>
        <input type="checkbox" name="calibrefx_seo[_calibrefx_noindex]" id="calibrefx_noindex" value="1" <?php checked(calibrefx_get_custom_field('_calibrefx_noindex')); ?> />
        <label for="calibrefx_noindex"><?php printf(__('Apply %s to this post/page', 'calibrefx'), '<code>noindex</code>'); ?> <a href="http://www.robotstxt.org/meta.html" target="_blank">[?]</a></label><br />

        <input type="checkbox" name="calibrefx_seo[_calibrefx_nofollow]" id="calibrefx_nofollow" value="1" <?php checked(calibrefx_get_custom_field('_calibrefx_nofollow')); ?> />
        <label for="calibrefx_nofollow"><?php printf(__('Apply %s to this post/page', 'calibrefx'), '<code>nofollow</code>'); ?> <a href="http://www.robotstxt.org/meta.html" target="_blank">[?]</a></label><br />

        <input type="checkbox" name="calibrefx_seo[_calibrefx_noarchive]" id="calibrefx_noarchive" value="1" <?php checked(calibrefx_get_custom_field('_calibrefx_noarchive')); ?> />
        <label for="calibrefx_nofollow"><?php printf(__('Apply %s to this post/page', 'calibrefx'), '<code>noarchive</code>'); ?> <a href="http://www.ezau.com/latest/articles/no-archive.shtml" target="_blank">[?]</a></label>
    </p>

    <br />

    <p><label for="calibrefx_scripts"><b><?php _e('Custom Tracking/Conversion Code', 'calibrefx'); ?></b></label></p>
    <p><textarea class="large-text" rows="4" cols="4" name="calibrefx_seo[_calibrefx_scripts]" id="calibrefx_scripts"><?php echo esc_textarea(calibrefx_get_custom_field('_calibrefx_scripts')); ?></textarea></p>
    <?php
}

add_action('save_post', 'calibrefx_inpost_seo_save', 1, 2);

/**
 * Save the SEO settings when we save a post or page.
 */
function calibrefx_inpost_seo_save($post_id, $post) {

    /*     * Verify the nonce */
    if (!isset($_POST['calibrefx_inpost_seo_nonce']) || !wp_verify_nonce($_POST['calibrefx_inpost_seo_nonce'], plugin_basename(__FILE__)))
        return $post->ID;

    /*     * Don't try to save the data under autosave, ajax, or future post */
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
    if (defined('DOING_CRON') && DOING_CRON)
        return;

    /*     * Check user is allowed to edit the post or page */
    if (( 'page' == $_POST['post_type'] && !current_user_can('edit_page', $post->ID) ) || !current_user_can('edit_post', $post->ID))
        return $post->ID;

    /** Don't try to store data during revision save */
    if ('revision' == $post->post_type)
        return;

    /** Define all as false, to be trumped by user submission */
    $seo_post_defaults = array(
        '_calibrefx_title' => '',
        '_calibrefx_description' => '',
        '_calibrefx_keywords' => '',
        '_calibrefx_canonical_uri' => '',
        '_calibrefx_redirect_url' => '',
        '_calibrefx_noindex' => 0,
        '_calibrefx_nofollow' => 0,
        '_calibrefx_noarchive' => 0,
        '_calibrefx_scripts' => '',
    );

    /** Merge defaults with user submission */
    $calibrefx_seo = wp_parse_args($_POST['calibrefx_seo'], $seo_post_defaults);

    /** Loop through values, to potentially store or delete as custom field */
    foreach ((array) $calibrefx_seo as $key => $value) {
        /** Sanitize the title, description, and tags before storage */
        if (in_array($key, array('_calibrefx_title', '_calibrefx_description', '_calibrefx_keywords')))
            $value = esc_html(strip_tags($value));

        /** Save, or delete if the value is empty */
        if ($value)
            update_post_meta($post->ID, $key, $value);
        else
            delete_post_meta($post->ID, $key);
    }
}