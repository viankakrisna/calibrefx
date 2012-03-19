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
 * This file handle calibrefx update
 *
 * @package CalibreFx
 */

/**
 * This function calibrefx_update_check is to ...
 */
function calibrefx_update_check() {
    global $wp_version;

    /** Get time of last update check */
    $calibrefx_update = get_transient('calibrefx-update');

    /** If it has expired, do an update check */
    if (!$calibrefx_update) {
        $url = 'http://api.calibrefx.com/themes-update/';
        $options = apply_filters(
                    'calibrefx_update_remote_post_options', array(
                        'body' => array(
                            'theme_version' => FRAMEWORK_VERSION,
                            'wp_version' => $wp_version,
                            'php_version' => phpversion(),
                            'uri' => home_url(),
                            'user-agent' => "WordPress/$wp_version;",
                         ),
                    )
                   );

        $response = wp_remote_post($url, $options);
        $calibrefx_update = wp_remote_retrieve_body($response);
        
        /** If an error occurred, return FALSE, store for 1 hour */
        if ('error' == $calibrefx_update || is_wp_error($calibrefx_update) || !is_serialized($calibrefx_update)) {
            set_transient('calibrefx-update', array('new_version' => FRAMEWORK_VERSION), 60 * 60);
            return false;
        }

        /** Else, unserialize */
        $calibrefx_update = maybe_unserialize($calibrefx_update);

        /** And store in transient for 24 hours */
        set_transient('calibrefx-update', $calibrefx_update, 60 * 60 * 24);
    }

    /** If we're already using the latest version, return false */
    if (version_compare(FRAMEWORK_VERSION, $calibrefx_update['new_version'], '>='))
        return false;

    return $calibrefx_update;
}

add_action('admin_init', 'calibrefx_upgrade', 25);

/**
 * Iteratively update calibreFx to the latest version
 */
function calibrefx_upgrade() {

    /** Don't do anything if we're on the latest version */
    if (calibrefx_get_option('calibrefx_db_version', null, false) >= FRAMEWORK_DB_VERSION)
        return;
    //debug_var(calibrefx_get_option( 'calibrefx_db_version'));
    //Do upgrade time to time here


    do_action('calibrefx_upgrade');
}

add_action('calibrefx_upgrade', 'calibrefx_upgrade_redirect');

/**
 * Redirects the user back to the theme settings page
 */
function calibrefx_upgrade_redirect() {

    if (!is_admin())
        return;

    calibrefx_admin_redirect('calibrefx-about', array('upgraded' => 'true'));
    exit;
}

add_action('admin_notices', 'calibrefx_upgraded_notice');

/**
 * Displays the notice that the theme settings were successfully updated to the
 * latest version.
 */
function calibrefx_upgraded_notice() {

    if (!calibrefx_is_menu_page('calibrefx-about'))
        return;

    if (isset($_REQUEST['upgraded']) && 'true' == $_REQUEST['upgraded'])
        echo '<div id="message" class="updated highlight" id="message"><p>' . sprintf(__('Congratulations! You are now using the latest version of Calibrefx v%s', 'calibrefx'), calibrefx_get_option('calibrefx_version')) . '</p></div>';
}

add_filter('update_theme_complete_actions', 'calibrefx_update_action_links', 10, 2);

/**
 * Filters the action links at the end of an update.
 */
function calibrefx_update_action_links($actions, $theme) {

    if ('calibrefx' != $theme)
        return $actions;

    return sprintf('<a href="%s">%s</a>', menu_page_url('calibrefx-about', 0), __('Click here to complete the upgrade', 'calibrefx'));
}

add_action('admin_notices', 'calibrefx_update_notification');

/**
 *  Displays the update notification at the top of the dashboard if there is a Calibrefx
 *  update available.
 */
function calibrefx_update_notification() {

    $calibrefx_update = calibrefx_update_check();

    if (!is_super_admin() || !$calibrefx_update)
        return false;

    echo '<div id="update-nag">';
    printf(
            __('CalibreFx %s is available. <a href="%s" class="thickbox thickbox-preview">Check out what\'s new</a> or <a href="%s" onclick="return calibrefx_confirm(\'%s\');">update now</a>.', 'calibrefx'), esc_html($calibrefx_update['new_version']), esc_url($calibrefx_update['changelog_url']), wp_nonce_url('update.php?action=upgrade-theme&amp;theme=calibrefx', 'upgrade-theme_calibrefx'), esc_js(__('Upgrading CalibreFx will overwrite the current installed version of CalibreFx. Are you sure you want to upgrade?. "Cancel" to stop, "OK" to upgrade.', 'calibrefx'))
    );
    echo '</div>';
}

add_filter('site_transient_update_themes', 'calibrefx_update_push');
add_filter('transient_update_themes', 'calibrefx_update_push');

/**
 * Push Calibrefx update check to WordPress update checks.
 *
 * This function filters the value that is returned when WordPress tries to pull
 * theme update transient data.
 */
function calibrefx_update_push($value) {

    $calibrefx_update = calibrefx_update_check();

    if ($calibrefx_update)
        $value->response['calibrefx'] = $calibrefx_update;

    return $value;
}

add_action('load-update-core.php', 'calibrefx_clear_update_transient');
add_action('load-themes.php', 'calibrefx_clear_update_transient');

/**
 * Delete Calibrefx update transient after updates.
 */
function calibrefx_clear_update_transient() {

    delete_transient('calibrefx-update');
    remove_action('admin_notices', 'calibrefx_update_notification');
}