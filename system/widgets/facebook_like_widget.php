<?php

/**
 * Register the widget for use in Appearance -> Widgets
 */
function calibrefx_facebook_likebox_init() {
	register_widget( 'CFX_Facebook_Like_Widget' );
}
add_action( 'widgets_init', 'calibrefx_facebook_likebox_init' );

class CFX_Facebook_Like_Widget extends WP_Widget {

	protected $defaults;

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct(
			'facebook-likebox-widget',
			apply_filters( 'calibrefx_widget_name', __( 'Facebook Likebox', 'calibrefx' ) ),
			array(
				'classname' => 'widget_facebook_likebox',
				'description' => __( 'Display a Facebook Likebox to allow your visitor like your Facebook Page', 'calibrefx' )
			)
		);

		$this->defaults = array(
			'title' 					=> '',
			'facebook_url' 				=> '',
			'facebook_width' 			=> 500,
			'facebook_show_facepile' 	=> 1,
			'facebook_show_posts' 		=> 0,
			'facebook_show_cover' 		=> 1,
		);
	}

	/**
	 * Display widget content.
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $before_widget . '<div class="facebook-like">';

		if ( ! empty( $instance['title']) ) {
			echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title; }

		printf( '<div class="fb-page" data-href="%1$s"
  			data-width="%2$s" data-hide-cover="%3$s" data-show-facepile="%4$s" 
  			data-show-posts="%5$s"></div>', 
  			$instance['facebook_url'], 
  			$instance['facebook_width'],
			( $instance['facebook_show_cover'] == '1' ) ? 'false' : 'true',
  			( $instance['facebook_show_facepile'] == '1' ) ? 'true' : 'false',
  			( $instance['facebook_show_posts'] == '1' ) ? 'true' : 'false'
		);

		echo '</div>' . $after_widget;
	}

	/**
	 * Update a particular instance.
	 */
	function update( $new_instance, $old_instance) {

		$new_instance['title'] = strip_tags( $new_instance['title'] );

		$new_instance['facebook_show_posts'] = ( $new_instance['facebook_show_posts'] ? 1 : 0 );
		$new_instance['facebook_show_facepile'] = ( $new_instance['facebook_show_facepile'] ? 1 : 0 );
		$new_instance['facebook_show_cover'] = ( $new_instance['facebook_show_cover'] ? 1 : 0 );
		$new_instance['facebook_show_border'] = ( $new_instance['facebook_show_border'] ? 1 : 0 );

		return $new_instance;
	}

	/**
	 * Display the settings update form.
	 */
	function form( $instance) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php _e( 'Facebook Page Url', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'facebook_url' ); ?>" name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" value="<?php echo esc_attr( $instance['facebook_url'] ); ?>" class="widefat" />
        </p>

        <hr class="div" />

        <p>
            <label for="<?php echo $this->get_field_id( 'facebook_width' ); ?>"><?php _e( 'Width (px)', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'facebook_width' ); ?>" name="<?php echo $this->get_field_name( 'facebook_width' ); ?>" value="<?php echo esc_attr( $instance['facebook_width'] ); ?>" class="widefat" />
        </p>

        <hr class="div" />

        <p><input id="<?php echo $this->get_field_id( 'facebook_show_facepile' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'facebook_show_facepile' ); ?>" value="1" <?php checked( 1, $instance['facebook_show_facepile'] ); ?>/> <label for="<?php echo $this->get_field_id( 'facebook_show_facepile' ); ?>"><?php _e( 'Show Friend\'s Faces', 'calibrefx' ); ?></label></p>
        <p><input id="<?php echo $this->get_field_id( 'facebook_show_posts' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'facebook_show_posts' ); ?>" value="1" <?php checked( 1, $instance['facebook_show_posts'] ); ?>/> <label for="<?php echo $this->get_field_id( 'facebook_show_posts' ); ?>"><?php _e( 'Show Page Posts', 'calibrefx' ); ?></label></p>
        <p><input id="<?php echo $this->get_field_id( 'facebook_show_cover' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'facebook_show_cover' ); ?>" value="1" <?php checked( 1, $instance['facebook_show_cover'] ); ?>/> <label for="<?php echo $this->get_field_id( 'facebook_show_cover' ); ?>"><?php _e( 'Show Cover Photo', 'calibrefx' ); ?></label></p>
        <?php
	}

}