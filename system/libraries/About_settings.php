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
 * Calibrefx About Setting Class
 *
 * @package		Calibrefx
 * @subpackage          Library
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
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

        calibrefx_add_meta_section('system', __('System Information', 'calibrefx'), 'options.php', 1);
        calibrefx_add_meta_section('team', __('The Team', 'calibrefx'), 'options.php', 2);

        $calibrefx_current_section = 'system';
        if (!empty($_GET['section'])) {
            $calibrefx_current_section = sanitize_text_field($_GET['section']);
        }
    }

    public function meta_boxes() {
        calibrefx_add_meta_box('system', 'basic', 'calibrefx-about-version', __('Information', 'calibrefx'), array(&$this,'info_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('system', 'basic', 'calibrefx-latest-news', __('Latest News', 'calibrefx'), array(&$this,'latest_news_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('system', 'basic', 'calibrefx-latest-tweets', __('<span class="twitter-logo"></span>Latest Tweets', 'calibrefx'), array(&$this,'latest_tweets_box'), $this->pagehook, 'side');

        calibrefx_add_meta_box('team', 'basic', 'calibrefx-the-team', __('The Team', 'calibrefx'), array(&$this,'the_team'), $this->pagehook, 'main');
    }

    public function the_team() {
        ?>
        <div class="the-team-container">
            <div class="the-team">
                <div class="image">
                    <div class="frame">
                        <div class="inset">
                            <img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-snc6/c14.14.173.173/s160x160/262956_4317692468156_689102013_n.jpg" alt="ivan kristianto" />
                        </div>                    
                    </div>
                    <h4><a href="#">Ivan Kristianto</a></h4>
                </div>
                <div class="description">
                    <p><strong>A WordPress Expert</strong>. Actively develop WordPress and Plugins for more than 4 years. Develop Calibrefx as the masterpiece for WordPress Themes Framework</p>
                </div>
                <div class="clear"></div>
            </div>

            <div class="the-team">
                <div class="image">
                    <div class="frame">
                        <div class="inset">
                            <img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-snc6/c33.34.413.413/s160x160/271130_10150303743249882_7232460_n.jpg" alt="Sunil Tolani" />
                        </div>                    
                    </div>
                    <h4><a href="#">Sunil Tolani</a></h4>
                </div>
                <div class="description">
                    <p><strong>A Business Guru</strong></p>
                </div>
                <div class="clear"></div>
            </div>

            <div class="the-team">
                <div class="image">
                    <div class="frame">
                        <div class="inset">
                            <img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-snc6/c10.10.160.160/227639_10151271752418889_2108418971_a.jpg" alt="Dee Ferdinand" />
                        </div>                    
                    </div>
                    <h4><a href="#">Dee Ferdinand</a></h4>
                </div>
                <div class="description">
                    <p>A Well known marketer on the net as <strong>"Minisite Guru"</strong>, actively doing internet marketing seminar and expand his creative art skill.</p>
                </div>
                <div class="clear"></div>
            </div>

            <div class="the-team">
                <div class="image">
                    <div class="frame">
                        <div class="inset">
                            <img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-snc7/c33.33.414.414/s160x160/318329_10150288849259837_7462108_n.jpg" alt="Padro Widjaja" />
                        </div>                    
                    </div>
                    <h4><a href="#">Padro Widjaja</a></h4>
                </div>
                <div class="description">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
                <div class="clear"></div>
            </div>

            <div class="the-team">
                <div class="image">
                    <div class="frame">
                        <div class="inset">
                            <img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-frc1/c56.56.696.696/s160x160/154351_3834262819533_2120621801_n.jpg" alt="Hilal" />
                        </div>                    
                    </div>
                    <h4><a href="#">Hilal</a></h4>
                </div>
                <div class="description">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
                <div class="clear"></div>
            </div>

            <div class="the-team">
                <div class="image">
                    <div class="frame">
                        <div class="inset">
                            <img src="http://1.gravatar.com/avatar/300f565b24f0cf1711fb33fc9b311f9c?s=75" alt="ivan kristianto" />
                        </div>                    
                    </div>
                    <h4><a href="#">Fadhel</a></h4>
                </div>
                <div class="description">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
                <div class="clear"></div>
            </div>

            <div class="the-team">
                <div class="image">
                    <div class="frame">
                        <div class="inset">
                            <img src="http://1.gravatar.com/avatar/300f565b24f0cf1711fb33fc9b311f9c?s=75" alt="ivan kristianto" />
                        </div>                    
                    </div>
                    <h4><a href="#">Hendrik</a></h4>
                </div>
                <div class="description">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
                <div class="clear"></div>
            </div>



            <div class="clear"></div>
        </div>

        <style type="text/css">
            .main-postbox{
                width: 98%;
            }

            .side-postbox{
                display: none;
            }

            .the-team-container{

            }
        </style>
        <?php
    }

    public function info_box() {
        ?>
        <p>
            <span class="description">
            Below is the CalibreFx Framework Informations. All the codes and informations is copyrighted by <a href="http://www.calibreworks.com" target="_blank">CalibreWorks</a>. 
            CalibreFx is released under the GPL v2. For license information please refer to the license.txt in themes folder.
            </span>
        </p>
        <p><strong><?php _e('Framework Name: ', 'calibrefx'); ?></strong><?php echo FRAMEWORK_NAME; ?> (<?php _e('Codename: ', 'calibrefx'); echo FRAMEWORK_CODENAME; ?>)</p>
        <p><strong><?php _e('Version:', 'calibrefx'); ?></strong> <?php echo FRAMEWORK_VERSION; ?> <?php echo '&middot;'; ?> <strong><?php _e('Released:', 'calibrefx'); ?></strong> <?php echo FRAMEWORK_RELEASE_DATE; ?></p>
        <p><strong><?php _e('DB Version: ', 'calibrefx'); ?></strong><?php echo FRAMEWORK_DB_VERSION; ?></p>
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