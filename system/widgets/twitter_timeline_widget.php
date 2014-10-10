<?php 
/**
 * Register the widget for use in Appearance -> Widgets
 */
function calibrefx_twitter_timeline_init() {
    register_widget( 'CFX_Twitter_Timeline_Widget' );
}
add_action( 'widgets_init', 'calibrefx_twitter_timeline_init' );

class CFX_Twitter_Timeline_Widget extends WP_Widget {

    protected $defaults;

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct(
            'twitter-timeline-widget',
            apply_filters( 'calibrefx_widget_name', __( 'Twitter Widget', 'calibrefx' ) ),
            array(
                'classname' => 'widget_twitter-timeline',
                'description' => __( 'Display Twitter Timeline Widget', 'calibrefx' )
            )
        );

        $this->defaults = array(
            'title' => '',
            'theme' => '',
            'link_color' => '',
            'user_name' => '',
            'width' => '',
            'height' => '',
            'widget_id' => '',
            'border_color' => ''
        );
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
		
		if(!empty( $instance['widget_id']) && !empty( $instance['user_name']) ) :
		
        echo $before_widget;

        if (!empty( $instance['title']) )
            echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base) . $after_title;
			
	    $attr = '';
        if(!empty( $instance['theme']) ) $attr .= ' data-theme="'.$instance['theme'].'"';
        if(!empty( $instance['width']) ) $attr .= ' width="'.$instance['width'].'"';
        if(!empty( $instance['height']) ) $attr .= ' height="'.$instance['height'].'"';
        if(!empty( $instance['link_color']) ) $attr .= ' data-link-color="'.$instance['link_color'].'"';
        if(!empty( $instance['border_color']) ) $attr .= ' data-border-color="'.$instance['border_color'].'"';

        echo '<a class="twitter-timeline" href="https://twitter.com/'.$instance['user_name'].'" data-widget-id="'.$instance['widget_id'].'"'.$attr.'>Tweets by @'.$instance['user_name'].'</a>';

        echo $after_widget;
		
		endif;
    }

    /**
     * Update a particular instance.
     */
    function update( $new_instance, $old_instance) {

        $new_instance['title'] = strip_tags( $new_instance['title']);
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
            <label for="<?php echo $this->get_field_id( 'user_name' ); ?>"><?php _e( 'Twitter Username', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'user_name' ); ?>" name="<?php echo $this->get_field_name( 'user_name' ); ?>" value="<?php echo esc_attr( $instance['user_name']); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'widget_id' ); ?>"><?php _e( 'Widget ID', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'widget_id' ); ?>" name="<?php echo $this->get_field_name( 'widget_id' ); ?>" value="<?php echo esc_attr( $instance['widget_id']); ?>" class="widefat" />
            <span class="description"><?php _e( 'You can get the widget ID from <a href="https://twitter.com/settings/widgets" target="_blank">widgets section of your twitter settings page</a>', 'calibrefx' ); ?></span>
        </p>
		
        <hr class="div" />

		<p>
            <label for="<?php echo $this->get_field_id( 'theme' ); ?>"><?php _e( 'Widget Theme', 'calibrefx' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'theme' ); ?>" name="<?php echo $this->get_field_name( 'theme' ); ?>">
				<option value=""<?php if( $instance['theme']=='' ) { echo ' selected="selected"'; } ?>><?php _e( 'Default', 'calibrefx' ); ?></option>
				<option value="dark"<?php if( $instance['theme']=='dark' ) { echo ' selected="selected"'; } ?>><?php _e( 'Dark', 'calibrefx' ); ?></option>
			</select>
		</p>

        <p>
            <label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Widget Width', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo esc_attr( $instance['width']); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Widget Height', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo esc_attr( $instance['height']); ?>" class="widefat" />
        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id( 'link_color' ); ?>"><?php _e( 'Link Color', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'link_color' ); ?>" name="<?php echo $this->get_field_name( 'link_color' ); ?>" value="<?php echo esc_attr( $instance['link_color']); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'border_color' ); ?>"><?php _e( 'Border Color', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'border_color' ); ?>" name="<?php echo $this->get_field_name( 'border_color' ); ?>" value="<?php echo esc_attr( $instance['border_color']); ?>" class="widefat" />
        </p>
        <?php
    }

}