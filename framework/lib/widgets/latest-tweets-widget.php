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
 * Contain latest Tweets widgets class
 * extend from WP_Widget Class
 *
 * @package CalibreFx
 */
 
 class Calibrefx_Latest_Tweets_Widget extends WP_Widget {
	
	protected $defaults;
	
	/**
	 * Constructor
	 */
	function __construct() {

		$this->defaults = array(
			'title'       	   => '',
			'twitter_id'       => '',
			'twitter_postnum'  => 0,
			'twitter_duration' => 0,
			'image_alignment'  => 'alignleft',
		);

		$widget_ops = array(
			'classname'   => 'latest-tweets-widget',
			'description' => __( 'Display latest Tweets', 'calibrefx' ),
		);
		
		$control_ops = array(
			'id_base' => 'latest-tweets',
			'width'   => 200,
			'height'  => 250,
		);

		parent::__construct( 'latest-tweets', __( 'CalibreFx - Latest Tweet', 'calibrefx' ), $widget_ops, $control_ops );

	}
	
	/**
	 * Display widget content.
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		
		echo $before_widget . '<div class="latest-tweets">';

			if ( ! empty( $instance['title'] ) )
				echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;
			
			//Widget Body Start
			echo '<ul>' . "\n";
			
			$tweets = get_transient( $instance['twitter_id'] . '-' . $instance['twitter_postnum'] . '-' . $instance['twitter_duration'] );
			
			if ( ! $tweets ) {
				$count = (int) $instance['twitter_postnum'];
				$twitter = wp_remote_retrieve_body(
					wp_remote_request(
						sprintf( 'http://api.twitter.com/1/statuses/user_timeline.json?screen_name=%s&count=%s&trim_user=1', $instance['twitter_id'], $count ),
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
						if ( ! empty( $tweets[(int)$instance['twitter_postnum'] - 1] ) )
							break;

						$timeago = sprintf( __( 'about %s ago', 'calibrefx' ), human_time_diff( strtotime( $tweet->created_at ) ) );
						$timeago_link = sprintf( '<a href="%s" rel="nofollow">%s</a>', esc_url( sprintf( 'http://twitter.com/%s/status/%s', $instance['twitter_id'], $tweet->id_str ) ), esc_html( $timeago ) );

						$tweets[] = '<li>' . calibrefx_tweet_linkify( $tweet->text ) . ' <span style="font-size: 85%;">' . $timeago_link . '</span></li>' . "\n";
					}
					
					/** Just in case */
					$tweets = array_slice( (array) $tweets, 0, (int) $instance['twitter_postnum'] );
					
					$time = ( absint( $instance['twitter_duration'] ) * 60 );

					/** Save them in transient */
					set_transient( $instance['twitter_id'].'-'.$instance['twitter_postnum'].'-'.$instance['twitter_duration'], $tweets, $time );
				}
			}
			
			
			
			foreach( (array) $tweets as $tweet ) echo $tweet;
			
			echo '</ul>' . "\n";
			//Widget Body Stop
			
			
		echo '</div>' . $after_widget;
		
	}
	 
	 /**
	  * Update a particular instance.
	  */
	function update( $new_instance, $old_instance ) {

		$new_instance['title'] = strip_tags( $new_instance['title'] );
		delete_transient( $old_instance['twitter_id'].'-'.$old_instance['twitter_postnum'].'-'.$old_instance['twitter_duration'] );
		return $new_instance;

	}
	
	/**
	 * Display the settings update form.
	 */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'calibrefx' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_id' ); ?>"><?php _e( 'Twitter Username', 'calibrefx' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'twitter_id' ); ?>" name="<?php echo $this->get_field_name( 'twitter_id' ); ?>" value="<?php echo esc_attr( $instance['twitter_id'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_postnum' ); ?>"><?php _e( 'Number of Tweets to Show', 'calibrefx' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'twitter_postnum' ); ?>" name="<?php echo $this->get_field_name( 'twitter_postnum' ); ?>" value="<?php echo esc_attr( $instance['twitter_postnum'] ); ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_duration' ); ?>"><?php _e( 'Load new Tweets every', 'calibrefx' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'twitter_duration' ); ?>" id="<?php echo $this->get_field_id( 'twitter_duration' ); ?>">
				<option value="5" <?php selected( 5, $instance['twitter_duration'] ); ?>><?php _e( '5 Min.' , 'calibrefx' ); ?></option>
				<option value="15" <?php selected( 15, $instance['twitter_duration'] ); ?>><?php _e( '15 Minutes' , 'calibrefx' ); ?></option>
				<option value="30" <?php selected( 30, $instance['twitter_duration'] ); ?>><?php _e( '30 Minutes' , 'calibrefx' ); ?></option>
				<option value="60" <?php selected( 60, $instance['twitter_duration'] ); ?>><?php _e( '1 Hour' , 'calibrefx' ); ?></option>
				<option value="120" <?php selected( 120, $instance['twitter_duration'] ); ?>><?php _e( '2 Hours' , 'calibrefx' ); ?></option>
				<option value="240" <?php selected( 240, $instance['twitter_duration'] ); ?>><?php _e( '4 Hours' , 'calibrefx' ); ?></option>
			</select>
		</p>

<?php
	}
}