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
add_action('admin_menu', 'calibrefx_about_init');

/**
 * This is a necessary go-between to get our scripts and boxes loaded
 * on the theme settings page only, and not the rest of the admin
 */
function calibrefx_about_init() {
    global $_calibrefx_about_pagehook;

    add_action('load-' . $_calibrefx_about_pagehook, 'calibrefx_theme_settings_scripts');
    add_action('load-' . $_calibrefx_about_pagehook, 'calibrefx_theme_settings_styles');
    add_action('load-' . $_calibrefx_about_pagehook, 'calibrefx_about_boxes');
}

/**
 * This function load meta boxes
 */
function calibrefx_about_boxes() {
    global $_calibrefx_about_pagehook;
    global $calibrefx_section;
    global $calibrefx_user_ability;
    global $current_user;
    
    $calibrefx_section = 'system';
    if(!empty($_GET['section']))
        $calibrefx_section = sanitize_text_field($_GET['section']);
    
    $calibrefx_user_ability = 'general';
    if(!empty($_GET['ability'])){
        update_user_meta($current_user->ID, 'ability', $_GET['ability']);
    }
    if(get_usermeta( $current_user->ID, 'ability' ) !== '' ){
        $calibrefx_user_ability = get_usermeta( $current_user->ID, 'ability' );
    }

	//Metabox on main postbox
    add_meta_box('calibrefx-about-version', __('Information', 'calibrefx'), 'calibrefx_about_info_box', $_calibrefx_about_pagehook, 'main', 'high');
	add_meta_box('calibrefx-latest-news', __('Latest News', 'calibrefx'), 'calibrefx_latest_news_box', $_calibrefx_about_pagehook, 'main', 'high');
	
	//Metabox on side postbox
    add_meta_box('calibrefx-latest-tweets', __('<span class="twitter-logo"></span>Latest Tweets', 'calibrefx'), 'calibrefx_latest_tweets_box', $_calibrefx_theme_settings_pagehook, 'side');
}

/**
 * Show Framework Information
 */
function calibrefx_about_page() {
    global $_calibrefx_about_pagehook, $wp_meta_boxes;
    global $calibrefx_section;
    
    $section_header = array(
        'system' => __('System', 'calibrefx'),
        'team' => __('Team', 'calibrefx'),
    );
    ?>
    <div id="calibrefx-about-page" class="wrap calibrefx-metaboxes">
        <?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false); ?>
        <?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false); ?>
        <?php settings_fields(CALIBREFX_SETTINGS_FIELD); // important! ?>

        <div class="calibrefx-header">
            <div class="calibrefx-option-logo">
                <a target="_blank" href="http://www.calibrefx.com" title="CalibreFx v1.0">&nbsp;</a>
            </div>
            <div class="calibrefx-version">
                <span>v<?php calibrefx_option('calibrefx_version'); ?> ( Codename : <?php echo FRAMEWORK_CODENAME; ?>)</span>
            </div>
            <div class="calibrefx-ability">
                <a class="calibrefx-general" href="admin.php?page=calibrefx&section=general&ability=general">General</a>
                <a class="calibrefx-professor" href="admin.php?page=calibrefx&section=general&ability=professor">Professor</a>
            </div>
        </div>
        <div class="calibrefx-content">
            <div class="calibrefx-submit-button">
                
            </div>
            
            <div class="metabox-holder">
                <div class="calibrefx-tab">
                    <ul class="calibrefx-tab-option">
                        <li <?php if($calibrefx_section==="system") echo 'class="current"';?>>
                            <a href="admin.php?page=calibrefx-about&section=system"><?php echo __('System', 'calibrefx');?></a><span></span>
                        </li>
                        <li <?php if($calibrefx_section==="team") echo 'class="current"';?>>
                            <a href="admin.php?page=calibrefx-about&section=team"><?php echo __('Team', 'calibrefx');?></a><span></span>
                        </li>
                    </ul>
                    <div class="calibrefx-option">
                        <h2><?php echo $section_header[$calibrefx_section];?></h2>
                        <div class="postbox-container main-postbox">
                            <?php
                            do_meta_boxes($_calibrefx_about_pagehook, 'main', null);
                            ?>
                        </div>

                        <div class="postbox-container side-postbox">
                            <?php
                            do_meta_boxes($_calibrefx_theme_settings_pagehook, 'side', null);
                            ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="calibrefx-submit-button calibrefx-bottom">
                    
                </div>
            </div>
        </div>
    </div>
	<script type="text/javascript">
        //<![CDATA[
        jQuery(document).ready( function($) {
            // close postboxes that should be closed
            $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
            // postboxes setup
            postboxes.add_postbox_toggles('<?php echo $_calibrefx_theme_settings_pagehook; ?>');
            postboxes._mark_area = function() {
                var visible = $('div.postbox:visible').length, side = $('#post-body #side-sortables');

                $('#calibrefx-seo-settings-page .meta-box-sortables:visible').each(function(n, el){
                    var t = $(this);

                    if ( visible == 1 || t.children('.postbox:visible').length )
                        t.removeClass('empty-container');
                    else
                        t.addClass('empty-container');
                });

                if ( side.length ) {
                    if ( side.children('.postbox:visible').length )
                        side.removeClass('empty-container');
                    else if ( $('#postbox-container-1').css('width') == '280px' )
                        side.addClass('empty-container');
                }
            };
            postboxes._mark_area();
        });
        //]]>
    </script>

    <?php
}

function calibrefx_about_info_box() {
    ?>
    <p><strong><?php _e('Framework Name: ', 'calibrefx'); ?></strong><?php echo FRAMEWORK_NAME; ?> (<?php _e('Codename: ', 'calibrefx');
    echo FRAMEWORK_CODENAME; ?>)</p>
    <p><strong><?php _e('Version:', 'calibrefx'); ?></strong> <?php calibrefx_option('calibrefx_version'); ?> <?php echo '&middot;'; ?> <strong><?php _e('Released:', 'calibrefx'); ?></strong> <?php echo FRAMEWORK_RELEASE_DATE; ?></p>
    <p><strong><?php _e('DB Version: ', 'calibrefx'); ?></strong><?php calibrefx_option('calibrefx_db_version'); ?></p>
<?php
}

function calibrefx_latest_news_box() {
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

function calibrefx_latest_tweets_box() {
	$twitter_id = 'calibrefx';
	$postnum = 5;
	$twitter_duration = 0;

    echo '<ul class="twitter-tweets">' . "\n";
			
	$tweets = get_transient( $twitter_id . '-' . $postnum . '-' . $twitter_duration );
	
	if ( ! $tweets ) {
		$count = (int) $postnum;
		$twitter = wp_remote_retrieve_body(
			wp_remote_request(
				sprintf( 'http://api.twitter.com/1/statuses/user_timeline.json?screen_name=%s&count=%s&trim_user=1', $twitter_id, $count ),
				array( 'timeout' => 100, )
			)
		);
		
		$json = json_decode( $twitter );
		
		if ( ! $twitter ) {
			$tweets[] = '<li>' . __( 'The Twitter API is taking too long to respond. Please try again later.', 'calibrefx' ) . '</li>' . "\n";
		}
		elseif ( is_wp_error( $twitter ) ) {
			$tweets[] = '<li>' . __( 'There was an error while attempting to contact the Twitter API. Please try again.', 'calibrefx' ) . '</li>' . "\n";
		}
		elseif ( is_object( $json ) && $json->error ) {
			$tweets[] = '<li>' . __( 'The Twitter API returned an error while processing your request. Please try again.', 'calibrefx' ) . '</li>' . "\n";
		}
		else {
			/** Build the tweets array */
			
			foreach ( (array) $json as $tweet ) {
				if ( ! empty( $tweets[(int)$postnum - 1] ) )
					break;

				$timeago = sprintf( __( 'about %s ago', 'calibrefx' ), human_time_diff( strtotime( $tweet->created_at ) ) );
				$timeago_link = sprintf( '<a href="%s" rel="nofollow">%s</a>', esc_url( sprintf( 'http://twitter.com/%s/status/%s', $twitter_id, $tweet->id_str ) ), esc_html( $timeago ) );

				$tweets[] = '<li>' . calibrefx_tweet_linkify( $tweet->text ) . ' <span style="font-size: 85%;">' . $timeago_link . '</span></li>' . "\n";
			}
			
			/** Just in case */
			$tweets = array_slice( (array) $tweets, 0, (int) $postnum );
			
			$time = ( absint( $twitter_duration ) * 60 );

			/** Save them in transient */
			set_transient( $twitter_id.'-'.$postnum.'-'.$twitter_duration, $tweets, $time );
		}
	}
	
	
	
	foreach( (array) $tweets as $tweet ) echo $tweet;
	
	echo '</ul>' . "\n";
}