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

class CFX_Twitter_Widget extends WP_Widget {

    protected $defaults;

    /**
     * Constructor
     */
    function __construct() {

        $this->defaults = array(
            'title' => '',
            'interval' => '',
            'twitter_width' => 250,
            'twitter_height' => 300,
            'shell_bg' => '333333',
            'shell_color' => 'ffffff',
            'tweets_bg' => '000000',
            'tweets_color' => 'ffffff',
            'tweets_links' => '4aed05',
			'tweets_num' => 4,
			'show_avatar' => 'false',
        );

        $widget_ops = array(
            'classname' => 'twitter-widget',
            'description' => __('Display Twitter Widget', 'calibrefx'),
        );

        $control_ops = array(
            'id_base' => 'twitter-widget'
        );

        $this->WP_Widget('twitter-widget', __('CalibreFx - Twitter Widget Box', 'calibrefx'), $widget_ops, $control_ops);
    }

    /**
     * Display widget content.
     *
     * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
     * @param array $instance The settings for the particular instance of the widget
     */
    function widget($args, $instance) {
		global $twitteruser;
		
		$twitteruser = calibrefx_get_option('twitter_username');
		
        extract($args);
        $instance = wp_parse_args((array) $instance, $this->defaults);
		
		if($twitteruser) :
		
        echo $before_widget . '<div class="twitter-widget">';

        if (!empty($instance['title']))
            echo $before_title . apply_filters('widget_title', $instance['title'], $instance, $this->id_base) . $after_title;
			
		echo '<div id="twitter-widget-content"></div>';

        //Widget Body Start
        
        printf('<script>
			jQuery(document).ready(function(){
				var twitterWidget = new TWTR.Widget({
				  version: 2,
				  type: \'profile\',
				  rpp: %10$s,
				  interval: %2$s,
				  width: %2$s,
				  height: %3$s,
				  id: \'twitter-widget-content\',
				  theme: {
					shell: {
					  background: \'#%4$s\',
					  color: \'#%5$s\'
					},
					tweets: {
					  background: \'#%6$s\',
					  color: \'#%7$s\',
					  links: \'#%8$s\'
					}
				  },
				  features: {
					scrollbar: false,
					loop: false,
					live: false,
					behavior: \'all\',
					avatars: %11$s
				  }
				});
				
				twitterWidget.render().setUser(\'%9$s\').start();
			});
			</script>',
			$instance['interval'],
			$instance['twitter_width'],
			$instance['twitter_height'],
			$instance['shell_bg'],
			$instance['shell_color'],
			$instance['tweets_bg'],
			$instance['tweets_color'],
			$instance['tweets_links'],
			$twitteruser,
			$instance['tweets_num'],
			$instance['show_avatar']
		);
        
        //Widget Body Stop

        echo '</div>' . $after_widget;
		
		endif;
    }

    /**
     * Update a particular instance.
     */
    function update($new_instance, $old_instance) {

        $new_instance['title'] = strip_tags($new_instance['title']);
        return $new_instance;
    }

    /**
     * Display the settings update form.
     */
    function form($instance) {
        $instance = wp_parse_args((array) $instance, $this->defaults);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id('tweets_num'); ?>"><?php _e('Number of Tweets', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('tweets_num'); ?>" name="<?php echo $this->get_field_name('tweets_num'); ?>" value="<?php echo esc_attr($instance['tweets_num']); ?>" class="widefat" />
        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id('show_avatar'); ?>"><?php _e('Show Avatar', 'calibrefx'); ?>:</label>
			<select id="<?php echo $this->get_field_id('show_avatar'); ?>" name="<?php echo $this->get_field_name('show_avatar'); ?>">
				<option value="true"<?php if($instance['show_avatar']=='true'){ echo ' selected="selected"'; } ?>>Yes</option>
				<option value="false"<?php if($instance['show_avatar']=='false'){ echo ' selected="selected"'; } ?>>No</option>
			</select>
		</p>

        <p>
            <label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Twitter Interval', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>" value="<?php echo esc_attr($instance['interval']); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('twitter_width'); ?>"><?php _e('Widget Width', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('twitter_width'); ?>" name="<?php echo $this->get_field_name('twitter_width'); ?>" value="<?php echo esc_attr($instance['twitter_width']); ?>" class="widefat" />
        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id('twitter_height'); ?>"><?php _e('Widget Height', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('twitter_height'); ?>" name="<?php echo $this->get_field_name('twitter_height'); ?>" value="<?php echo esc_attr($instance['twitter_height']); ?>" class="widefat" />
        </p>

        <hr class="div" />

        <p>
            <label for="<?php echo $this->get_field_id('shell_bg'); ?>"><?php _e('Shell Background Color #', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('shell_bg'); ?>" name="<?php echo $this->get_field_name('shell_bg'); ?>" value="<?php echo esc_attr($instance['shell_bg']); ?>" class="widefat" />
        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id('shell_color'); ?>"><?php _e('Shell Color #', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('shell_color'); ?>" name="<?php echo $this->get_field_name('shell_color'); ?>" value="<?php echo esc_attr($instance['shell_color']); ?>" class="widefat" />
        </p>

        <hr class="div" />

        <p>
            <label for="<?php echo $this->get_field_id('tweets_bg'); ?>"><?php _e('Tweets Background Color #', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('tweets_bg'); ?>" name="<?php echo $this->get_field_name('tweets_bg'); ?>" value="<?php echo esc_attr($instance['tweets_bg']); ?>" class="widefat" />
        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id('tweets_color'); ?>"><?php _e('Tweets Color #', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('tweets_color'); ?>" name="<?php echo $this->get_field_name('tweets_color'); ?>" value="<?php echo esc_attr($instance['tweets_color']); ?>" class="widefat" />
        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id('tweets_links'); ?>"><?php _e('Tweets Link Color #', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('tweets_links'); ?>" name="<?php echo $this->get_field_name('tweets_links'); ?>" value="<?php echo esc_attr($instance['tweets_links']); ?>" class="widefat" />
        </p>
        <?php
    }

}