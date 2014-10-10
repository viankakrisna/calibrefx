<?php 
/**
 * Register the widget for use in Appearance -> Widgets
 */
function calibrefx_facebook_comment_init() {
    register_widget( 'CFX_Facebook_Comment_Widget' );
}
add_action( 'widgets_init', 'calibrefx_facebook_comment_init' );

class CFX_Facebook_Comment_Widget extends WP_Widget {

    protected $defaults;

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct(
            'facebook-comment-widget',
            apply_filters( 'calibrefx_widget_name', __( 'Facebook Comment', 'calibrefx' ) ),
            array(
                'classname' => 'widget_facebook_comment',
                'description' => __( 'Display a Facebook Comment', 'calibrefx' )
            )
        );

        $this->defaults = array(
            'title' => '',
            'facebook_url' => '',
            'facebook_width' => 470,
            'facebook_number_posts' => 2,
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

        $featured_page = new WP_Query(array( 'page_id' => $instance['page_id']) );

        echo $before_widget . '<div class="facebook-comment">';

        if (!empty( $instance['title']) )
            echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base) . $after_title;

        //Widget Body Start
        ?>
        <div class="fb-comments" data-href="<?php echo $instance['facebook_url']; ?>" 
             data-num-posts="<?php echo $instance['facebook_number_posts']; ?>" 
             data-width="<?php echo $instance['facebook_width']; ?>"></div>
        <?php
        //Widget Body Stop

        echo '</div>' . $after_widget;
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
            <label for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php _e( 'Facebook Url', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'facebook_url' ); ?>" name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" value="<?php echo esc_attr( $instance['facebook_url']); ?>" class="widefat" />
        </p>

        <hr class="div" />

        <p>
            <label for="<?php echo $this->get_field_id( 'facebook_width' ); ?>"><?php _e( 'Width', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'facebook_width' ); ?>" name="<?php echo $this->get_field_name( 'facebook_width' ); ?>" value="<?php echo esc_attr( $instance['facebook_width']); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'facebook_number_posts' ); ?>"><?php _e( 'Number Of Posts', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'facebook_number_posts' ); ?>" name="<?php echo $this->get_field_name( 'facebook_number_posts' ); ?>" value="<?php echo esc_attr( $instance['facebook_number_posts']); ?>" class="widefat" />
        </p>

        <?php
    }

}