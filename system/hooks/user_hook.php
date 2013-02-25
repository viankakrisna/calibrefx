<?php defined('CALIBREFX_URL') OR exit();
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
 * Calibrefx User Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */
add_action('init', 'calibrefx_set_user_ability', 15);

function calibrefx_set_user_ability() {
    global $calibrefx_user_ability, $current_user;

    //Set general as default
    $calibrefx_user_ability = 'general';
    if (!empty($_GET['ability'])) {
        update_user_meta($current_user->ID, 'ability', $_GET['ability']);
    }

    $calibrefx_user_ability = get_usermeta($current_user->ID, 'ability');
}

add_action('show_user_profile', 'calibrefx_user_social_fields');
add_action('edit_user_profile', 'calibrefx_user_social_fields');

/**
 * Adds fields for author social media information.
 *
 * Input / Textarea fields are:
 * - Google+ profile page
 * - Twitter profile
 * - Youtube channel
 * - Linkedin profile
 *
 */
function calibrefx_user_social_fields($user) {

    if (!current_user_can('edit_users', $user->ID))
        return false;
    ?>
    <h3><?php _e('Social Media Settings', 'calibrefx'); ?></h3>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row" valign="top"><label for="gplus_profile"><?php _e('Google+ Profile', 'calibrefx'); ?></label></th>
                <td>
                    <input name="meta[gplus_profile]" id="gplus_profile" type="text" value="<?php echo esc_attr(get_the_author_meta('gplus_profile', $user->ID)); ?>" class="regular-text" /><br />
                </td>
            </tr>

            <tr>
                <th scope="row" valign="top"><label for="facebook_profile"><?php _e('Facebook Profile', 'calibrefx'); ?></label></th>
                <td>
                    <input name="meta[facebook_profile]" id="facebook_profile" type="text" value="<?php echo esc_attr(get_the_author_meta('facebook_profile', $user->ID)); ?>" class="regular-text" /><br />
                </td>
            </tr>

            <tr>
                <th scope="row" valign="top"><label for="twitter_profile"><?php _e('Twitter Profile', 'calibrefx'); ?></label></th>
                <td>
                    <input name="meta[twitter_profile]" id="twitter_profile" type="text" value="<?php echo esc_attr(get_the_author_meta('twitter_profile', $user->ID)); ?>" class="regular-text" /><br />
                </td>
            </tr>

            <tr>
                <th scope="row" valign="top"><label for="youtube_channel"><?php _e('Youtube Channel', 'calibrefx'); ?></label></th>
                <td>
                    <input name="meta[youtube_channel]" id="youtube_channel" type="text" value="<?php echo esc_attr(get_the_author_meta('youtube_channel', $user->ID)); ?>" class="regular-text" /><br />
                </td>
            </tr>

            <tr>
                <th scope="row" valign="top"><label for="linkedin_profile"><?php _e('Linkedin Profile', 'calibrefx'); ?></label></th>
                <td>
                    <input name="meta[linkedin_profile]" id="linkedin_profile" type="text" value="<?php echo esc_attr(get_the_author_meta('linkedin_profile', $user->ID)); ?>" class="regular-text" /><br />
                </td>
            </tr>
           
        </tbody>
    </table>
    <?php
}

add_action('show_user_profile', 'calibrefx_user_archive_fields');
add_action('edit_user_profile', 'calibrefx_user_archive_fields');

/**
 * Adds fields for author archives contents to the user edit screen.
 *
 * Input / Textarea fields are:
 * - Custom Archive Headline
 * - Custom Description Text
 *
 * Checkbox fields are:
 * - Enable Author Box on the User's Posts?
 * - Enable Author Box on this User's Archives?
 *
 */
function calibrefx_user_archive_fields($user) {

    if (!current_user_can('edit_users', $user->ID))
        return false;
    ?>
    <h3><?php _e('Author Archive Settings', 'calibrefx'); ?></h3>
    <p><span class="description"><?php _e('These settings apply to this author\'s archive pages.', 'calibrefx'); ?></span></p>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row" valign="top"><label for="headline"><?php _e('Custom Archive Headline', 'calibrefx'); ?></label></th>
                <td>
                    <input name="meta[headline]" id="headline" type="text" value="<?php echo esc_attr(get_the_author_meta('headline', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description"><?php printf(__('Will display in the %s tag at the top of the first page', 'calibrefx'), '<code>&lt;h1&gt;&lt;/h1&gt;</code>'); ?></span>
                </td>
            </tr>

            <tr>
                <th scope="row" valign="top"><label for="intro_text"><?php _e('Custom Description Text', 'calibrefx'); ?></label></th>
                <td>
                    <textarea name="meta[intro_text]" id="intro_text" rows="5" cols="30"><?php echo esc_textarea(get_the_author_meta('intro_text', $user->ID)); ?></textarea><br />
                    <span class="description"><?php _e('This text will be the first paragraph, and display on the first page', 'calibrefx'); ?></span>
                </td>
            </tr>

            <tr>
                <th scope="row" valign="top"><?php _e('Author Box', 'calibrefx'); ?></th>
                <td>
                    <input id="meta[calibrefx_author_box_single]" name="meta[calibrefx_author_box_single]" type="checkbox" value="1" <?php checked(get_the_author_meta('calibrefx_author_box_single', $user->ID)); ?> />
                    <label for="meta[calibrefx_author_box_single]"><?php _e('Enable Author Box on this User\'s Posts?', 'calibrefx'); ?></label><br />
                    <input id="meta[calibrefx_author_box_archive]" name="meta[calibrefx_author_box_archive]" type="checkbox" value="1" <?php checked(get_the_author_meta('calibrefx_author_box_archive', $user->ID)); ?> />
                    <label for="meta[calibrefx_author_box_archive]"><?php _e('Enable Author Box on this User\'s Archives?', 'calibrefx'); ?></label>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

add_action('personal_options_update', 'calibrefx_user_meta_save');
add_action('edit_user_profile_update', 'calibrefx_user_meta_save');

/**
 * Adds / updates user meta when user edit page is saved.
 */
function calibrefx_user_meta_save($user_id) {

    if (!current_user_can('edit_users', $user_id))
        return;

    if (!isset($_POST['meta']) || !is_array($_POST['meta']))
        return;

    $meta = wp_parse_args(
            $_POST['meta'], array(
        'calibrefx_author_box_single' => '',
        'calibrefx_author_box_archive' => '',
            )
    );

    foreach ($meta as $key => $value)
        update_user_meta($user_id, $key, $value);
}

add_filter('get_the_author_calibrefx_author_box_single', 'calibrefx_author_box_single_default_on', 10, 2);

/**
 * This is a special filter function to be used to conditionally force
 * a default 1 value for each users' author box setting.
 */
function calibrefx_author_box_single_default_on($value, $user_id) {

    if (calibrefx_get_option('author_box_single'))
        return calibrefx_user_meta_default_on($value, $user_id);
    else
        return $value;
}