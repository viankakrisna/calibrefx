<?php defined( 'CALIBREFX_URL' ) OR exit();
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

class CFX_Facebook_Like_Widget extends WP_Widget {

    protected $defaults;

    /**
     * Constructor
     */
    function __construct() {

        $this->defaults = array(
            'title' => '',
            'facebook_url' => '',
            'facebook_width' => 292,
            'facebook_height' => 320,
            'facebook_color' => 'light',
            'facebook_show_faces' => 1,
            'facebook_show_border' => 1,
            'facebook_show_stream' => 1,
            'facebook_show_header' => 1,
            'facebook_background_color' => ''
        );

        $widget_ops = array(
            'classname' => 'facebook-like-widget',
            'description' => __( 'Display facebook like box', 'calibrefx' ),
        );

        $control_ops = array(
            'id_base' => 'facebook-like',
            'width' => 200,
            'height' => 250,
        );

        $this->WP_Widget( 'facebook-like', __( 'Facebook Like Box (CalibreFx)', 'calibrefx' ), $widget_ops, $control_ops);
    }

    /**
     * Display widget content.
     *
     * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
     * @param array $instance The settings for the particular instance of the widget
     */
    function widget( $args, $instance) {
        extract( $args);
        $instance = wp_parse_args((array) $instance, $this->defaults);

        echo $before_widget . '<div class="facebook-like">';

        if (!empty( $instance['title']) )
            echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base) . $after_title;

        //Widget Body Start
        if(empty( $instance['facebook_background_color']) ) {
            if( $instance['facebook_color'] == 'dark' ) {
                $background_color = '#333333';
            }else{
                $background_color = '#ffffff';
            }
        }else{
            $background_color = $instance['facebook_background_color'];
        }
        
        printf( '<iframe
			src="http://www.facebook.com/plugins/likebox.php?href=%1$s&
			width=%2$s&height=%3$s&colorscheme=%4$s&show_faces=%5$s&stream=%6$s&header=%7$s&show_border=%8$s" 
			scrolling="no" frameborder="0" 
			style="border:none; overflow:hidden; width:%2$spx; height:%3$spx; background-color: %9$s" allowTransparency="true"></iframe>',
			$instance['facebook_url'],
			$instance['facebook_width'],
			$instance['facebook_height'],
			$instance['facebook_color'],
			( $instance['facebook_show_faces'] == '1' ) ? 'true' : 'false',
			( $instance['facebook_show_stream'] == '1' ) ? 'true' : 'false',
			( $instance['facebook_show_header'] == '1' ) ? 'true' : 'false',
			( $instance['facebook_show_border'] == '1' ) ? 'true' : 'false',
            $background_color);
        
        //Widget Body Stop

        echo '</div>' . $after_widget;
    }

    /**
     * Update a particular instance.
     */
    function update( $new_instance, $old_instance) {

        $new_instance['title'] = strip_tags( $new_instance['title']);

        $new_instance['facebook_show_stream'] = ( $new_instance['facebook_show_stream'] ? 1 : 0 );
		$new_instance['facebook_show_faces'] = ( $new_instance['facebook_show_faces'] ? 1 : 0 );
		$new_instance['facebook_show_header'] = ( $new_instance['facebook_show_header'] ? 1 : 0 );
		$new_instance['facebook_show_border'] = ( $new_instance['facebook_show_border'] ? 1 : 0 );
		
        return $new_instance;
    }

    /**
     * Display the settings update form.
     */
    function form( $instance) {
        $instance = wp_parse_args((array) $instance, $this->defaults);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title']); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php _e( 'Facebook Url', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'facebook_url' ); ?>" name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" value="<?php echo esc_attr( $instance['facebook_url']); ?>" class="widefat" />
        </p>

        <hr class="div" />

        <p>
            <label for="<?php echo $this->get_field_id( 'facebook_width' ); ?>"><?php _e( 'Width', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'facebook_width' ); ?>" name="<?php echo $this->get_field_name( 'facebook_width' ); ?>" value="<?php echo esc_attr( $instance['facebook_width']); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'facebook_height' ); ?>"><?php _e( 'Height', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'facebook_height' ); ?>" name="<?php echo $this->get_field_name( 'facebook_height' ); ?>" value="<?php echo esc_attr( $instance['facebook_height']); ?>" class="widefat" />
        </p>

        <hr class="div" />

        <p>
            <label for="<?php echo $this->get_field_id( 'facebook_color' ); ?>"><?php _e( 'Color Scheme', 'calibrefx' ); ?>:</label>
            <select id="<?php echo $this->get_field_id( 'facebook_color' ); ?>" name="<?php echo $this->get_field_name( 'facebook_color' ); ?>">
                <option style="padding-right:10px;" value="light" <?php selected( 'light', $instance['facebook_color']); ?>><?php _e( 'Light', 'calibrefx' ); ?></option>
                <option style="padding-right:10px;" value="dark" <?php selected( 'dark', $instance['facebook_color']); ?>><?php _e( 'Dark', 'calibrefx' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'facebook_background_color' ); ?>"><?php _e( 'Background Color', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'facebook_background_color' ); ?>" name="<?php echo $this->get_field_name( 'facebook_background_color' ); ?>" value="<?php echo esc_attr( $instance['facebook_background_color']); ?>" />
        </p>

        <hr class="div" />
		
		<p><input id="<?php echo $this->get_field_id( 'facebook_show_border' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'facebook_show_border' ); ?>" value="1" <?php checked( 1, $instance['facebook_show_border'] ); ?>/> <label for="<?php echo $this->get_field_id( 'facebook_show_border' ); ?>"><?php _e( 'Show Border', 'calibrefx' ); ?></label></p>
        <p><input id="<?php echo $this->get_field_id( 'facebook_show_faces' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'facebook_show_faces' ); ?>" value="1" <?php checked( 1, $instance['facebook_show_faces'] ); ?>/> <label for="<?php echo $this->get_field_id( 'facebook_show_faces' ); ?>"><?php _e( 'Show Faces', 'calibrefx' ); ?></label></p>
        <p><input id="<?php echo $this->get_field_id( 'facebook_show_stream' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'facebook_show_stream' ); ?>" value="1" <?php checked( 1, $instance['facebook_show_stream'] ); ?>/> <label for="<?php echo $this->get_field_id( 'facebook_show_stream' ); ?>"><?php _e( 'Show Stream', 'calibrefx' ); ?></label></p>
        <p><input id="<?php echo $this->get_field_id( 'facebook_show_header' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'facebook_show_header' ); ?>" value="1" <?php checked( 1, $instance['facebook_show_header'] ); ?>/> <label for="<?php echo $this->get_field_id( 'facebook_show_header' ); ?>"><?php _e( 'Show Header', 'calibrefx' ); ?></label></p>
        <?php
    }

}