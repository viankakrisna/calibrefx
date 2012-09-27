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

/**
 * Calibrefx About Setting Class
 *
 * @package		Calibrefx
 * @subpackage          Library
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
 */

class CFX_About_Settings extends CFX_Admin {
    
    /**
     * Constructor - Initializes
     */
    function __construct() {
        $this->page_id = 'calibrefx-about';
        $this->settings_field = apply_filters('calibrefx_about_field', 'calibrefx-about');
        
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
    public function security_filters(){
        //Nothing to add here
    }
    

    public function meta_sections() {
        global $calibrefx_current_section, $calibrefx_sections;

        calibrefx_clear_meta_section();

        calibrefx_add_meta_section('system', __('System Information', 'calibrefx'));
        calibrefx_add_meta_section('team', __('The Team', 'calibrefx'));

        $calibrefx_current_section = 'system';
        if (!empty($_GET['section'])) {
            $calibrefx_current_section = sanitize_text_field($_GET['section']);
        }
    }

    public function meta_boxes() {
        calibrefx_add_meta_box('system', 'basic', 'calibrefx-about-version', __('Information', 'calibrefx'), array(&$this,'info_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('system', 'basic', 'calibrefx-latest-news', __('Latest News', 'calibrefx'), array(&$this,'latest_news_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('system', 'basic', 'calibrefx-latest-tweets', __('<span class="twitter-logo"></span>Latest Tweets', 'calibrefx'), array(&$this,'latest_tweets_box'), $this->pagehook, 'side');
    }

    public function info_box() {
        ?>
        <p><strong><?php _e('Framework Name: ', 'calibrefx'); ?></strong><?php echo FRAMEWORK_NAME; ?> (<?php
        _e('Codename: ', 'calibrefx');
        echo FRAMEWORK_CODENAME;
        ?>)</p>
        <p><strong><?php _e('Version:', 'calibrefx'); ?></strong> <?php calibrefx_option('calibrefx_version'); ?> <?php echo '&middot;'; ?> <strong><?php _e('Released:', 'calibrefx'); ?></strong> <?php echo FRAMEWORK_RELEASE_DATE; ?></p>
        <p><strong><?php _e('DB Version: ', 'calibrefx'); ?></strong><?php calibrefx_option('calibrefx_db_version'); ?></p>
        <?php
    }

    public function latest_news_box() {
        echo '<div>';
        wp_widget_rss_output(array(
            'url' => 'http://www.calibreworks.com/feed/',
            'title' => 'Latest news from Calibreworks Team',
            'items' => 5,
            'show_summary' => 1,
            'show_author' => 0,
            'show_date' => 1
        ));
        echo "</div>";
    }

    public function latest_tweets_box() {
        $twitter_id = 'calibrefx';
        $postnum = 5;
        $twitter_duration = 0;

        echo '<ul class="twitter-tweets">' . "\n";

        $tweets = get_transient($twitter_id . '-' . $postnum . '-' . $twitter_duration);

        if (!$tweets) {
            $count = (int) $postnum;
            $twitter = wp_remote_retrieve_body(
                    wp_remote_request(
                            sprintf('http://api.twitter.com/1/statuses/user_timeline.json?screen_name=%s&count=%s&trim_user=1', $twitter_id, $count), array('timeout' => 100,)
                    )
            );

            $json = json_decode($twitter);

            if (!$twitter) {
                $tweets[] = '<li>' . __('The Twitter API is taking too long to respond. Please try again later.', 'calibrefx') . '</li>' . "\n";
            } elseif (is_wp_error($twitter)) {
                $tweets[] = '<li>' . __('There was an error while attempting to contact the Twitter API. Please try again.', 'calibrefx') . '</li>' . "\n";
            } elseif (is_object($json) && $json->error) {
                $tweets[] = '<li>' . __('The Twitter API returned an error while processing your request. Please try again.', 'calibrefx') . '</li>' . "\n";
            } else {
                /** Build the tweets array */
                foreach ((array) $json as $tweet) {
                    if (!empty($tweets[(int) $postnum - 1]))
                        break;

                    $timeago = sprintf(__('about %s ago', 'calibrefx'), human_time_diff(strtotime($tweet->created_at)));
                    $timeago_link = sprintf('<a href="%s" rel="nofollow">%s</a>', esc_url(sprintf('http://twitter.com/%s/status/%s', $twitter_id, $tweet->id_str)), esc_html($timeago));

                    $tweets[] = '<li>' . calibrefx_tweet_linkify($tweet->text) . ' <span style="font-size: 85%;">' . $timeago_link . '</span></li>' . "\n";
                }

                /** Just in case */
                $tweets = array_slice((array) $tweets, 0, (int) $postnum);

                $time = ( absint($twitter_duration) * 60 );

                /** Save them in transient */
                set_transient($twitter_id . '-' . $postnum . '-' . $twitter_duration, $tweets, $time);
            }
        }



        foreach ((array) $tweets as $tweet)
            echo $tweet;

        echo '</ul>' . "\n";
    }

}