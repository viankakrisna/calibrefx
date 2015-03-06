<?php
/**
 * Register the widget for use in Appearance -> Widgets
 */
function calibrefx_social_icon_init() {
	register_widget( 'CFX_Social_Widget' );
}
add_action( 'widgets_init', 'calibrefx_social_icon_init' );

class CFX_Social_Widget extends WP_Widget {

	protected $defaults;

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct(
			'social-icon-widget',
			apply_filters( 'calibrefx_widget_name', __( 'Social Media', 'calibrefx' ) ),
			array(
				'classname' => 'widget_social_icon',
				'description' => __( 'Display social media link', 'calibrefx' )
			)
		);

		$this->defaults = array(
		   'title' => '',
		   'layout' => 'horizontal',
		   'label_facebook' => '',
		   'label_twitter' => '',
		   'label_youtube' => '',
		   'label_gplus' => '',
		   'label_linkedin' => '',
		   'label_pinterest' => '',
		   'label_instagram' => '',
		   'label_github' => '',
		   'icon_size' => '',
		   'icon_style' => '',
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

		echo $before_widget;

		$fb_url = esc_attr( calibrefx_get_option( 'facebook_fanpage' ) );
		$tw_url = esc_attr( calibrefx_get_option( 'twitter_profile' ) );
		$youtube_url = esc_attr( calibrefx_get_option( 'youtube_channel' ) );
		$gplus_url = esc_attr( calibrefx_get_option( 'gplus_page' ) );
		$linkedin_profile = esc_attr( calibrefx_get_option( 'linkedin_profile' ) );
		$pinterest_profile = esc_attr( calibrefx_get_option( 'pinterest_profile' ) );
		$instagram_profile = esc_attr( calibrefx_get_option( 'instagram_profile' ) );
		$github_profile = esc_attr( calibrefx_get_option( 'github_profile' ) );

		if ( ! empty( $instance['title']) ) {
			echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title; }

		$output = '';
		$output .= '<div class="social-media-wrapper"><ul class="social-media-list '.$instance['layout'].'">';

		$output .= apply_filters( 'calibrefx_social_widget_before_list', '' );

		if ( ! empty( $fb_url) ) {
			$output .= '<li class="facebook">
					<a href="'.$fb_url.'" title="'.__( 'View us on facebook', 'calibrefx' ).'" target="_blank">
						<i class="social-icon fa fa-facebook'.$instance['icon_style'].' fa-fw '.$instance['icon_size'].'"></i>
						'.(( $instance['layout'] == 'vertical' ) ? ' <span class="social-media-label">'.stripslashes( $instance['label_facebook'] ) : '' ).'</span>
					</a>
				</li>';
		}

		if ( ! empty( $tw_url) ) {
			$output .= '<li class="twitter">
					<a href="'.$tw_url.'" title="'.__( 'View us on twitter', 'calibrefx' ).'" target="_blank">
						<i class="social-icon fa fa-twitter'.$instance['icon_style'].' fa-fw '.$instance['icon_size'].'"></i>
						'.(( $instance['layout'] == 'vertical' ) ? ' <span class="social-media-label">'.stripslashes( $instance['label_twitter'] ) : '' ).'</span>
					</a>
				</li>';
		}

		if ( ! empty( $gplus_url) ) {
			$output .= '<li class="gplus">
					<a href="'.$gplus_url.'" title="'.__( 'View us on google+', 'calibrefx' ).'" target="_blank">
						<i class="social-icon fa fa-google-plus'.$instance['icon_style'].' fa-fw '.$instance['icon_size'].'"></i>
						'.(( $instance['layout'] == 'vertical' ) ? ' <span class="social-media-label">'.stripslashes( $instance['label_gplus'] ) : '' ).'</span>
					</a>
				</li>';
		}

		if ( ! empty( $youtube_url) ) {
			$output .= '<li class="youtube">
					<a href="'.$youtube_url.'" title="'.__( 'View our youtube channel', 'calibrefx' ).'" target="_blank">
						<i class="social-icon fa fa-youtube'.$instance['icon_style'].' fa-fw '.$instance['icon_size'].'"></i>
						'.(( $instance['layout'] == 'vertical' ) ? ' <span class="social-media-label">'.stripslashes( $instance['label_youtube'] ) : '' ).'</span>
					</a>
				</li>';
		}

		if ( ! empty( $linkedin_profile) ) {
			$output .= '<li class="linkedin">
					<a href="'.$linkedin_profile.'" title="'.__( 'View us on linkedin', 'calibrefx' ).'" target="_blank">
						<i class="social-icon fa fa-linkedin'.$instance['icon_style'].' fa-fw '.$instance['icon_size'].'"></i>
						'.(( $instance['layout'] == 'vertical' ) ? ' <span class="social-media-label">'.stripslashes( $instance['label_linkedin'] ) : '' ).'</span>
					</a>
				</li>';
		}

		if ( ! empty( $pinterest_profile) ) {
			$output .= '<li class="pinterest">
					<a href="'.$pinterest_profile.'" title="'.__( 'View us on pinterest', 'calibrefx' ).'" target="_blank">
						<i class="social-icon fa fa-pinterest'.$instance['icon_style'].' fa-fw '.$instance['icon_size'].'"></i>
						'.(( $instance['layout'] == 'vertical' ) ? ' <span class="social-media-label">'.stripslashes( $instance['label_pinterest'] ) : '' ).'</span>
					</a>
				</li>';
		}

		if ( ! empty( $instagram_profile) ) {
			$output .= '<li class="instagram">
					<a href="'.$instagram_profile.'" title="'.__( 'View us on instagram', 'calibrefx' ).'" target="_blank">
						<i class="social-icon fa fa-instagram'.$instance['icon_style'].' fa-fw '.$instance['icon_size'].'"></i>
						'.(( $instance['layout'] == 'vertical' ) ? ' <span class="social-media-label">'.stripslashes( $instance['label_instagram'] ) : '' ).'</span>
					</a>
				</li>';
		}

		if ( ! empty( $github_profile) ) {
			$output .= '<li class="github">
					<a href="'.$github_profile.'" title="'.__( 'View us on github', 'calibrefx' ).'" target="_blank">
						<i class="social-icon fa fa-github'.$instance['icon_style'].' fa-fw '.$instance['icon_size'].'"></i>
						'.(( $instance['layout'] == 'vertical' ) ? ' <span class="social-media-label">'.stripslashes( $instance['label_github'] ) : '' ).'</span>
					</a>
				</li>';
		}

		$output .= apply_filters( 'calibrefx_social_widget_after_list', '' );

		$output .= '</ul></div>';

		$widget_output = apply_filters( 'calibrefx_social_widget_output', $output, $instance, $fb_url, $tw_url, $gplus_url, $youtube_url, $linkedin_profile, $pinterest_profile );

		echo $widget_output;

		echo $after_widget;
	}

	/**
	 * Update a particular instance.
	 */
	function update( $new_instance, $old_instance) {
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

        <hr class="div" />

        <p><strong>Icon Style</strong></p>
        
        <p>
            <label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php _e( 'Layout Type', 'calibrefx' ); ?>:</label><br />
            <select name="<?php echo $this->get_field_name( 'layout' ); ?>" id="<?php echo $this->get_field_id( 'layout' ); ?>">
                <option value="horizontal"<?php selected( 'horizontal', $instance['layout'], true ); ?>><?php _e( 'Horizontal', 'calibrefx' ); ?></option>
                <option value="vertical"<?php selected( 'vertical', $instance['layout'], true ); ?>><?php _e( 'Vertical', 'calibrefx' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'icon_size' ); ?>"><?php _e( 'Icon Size', 'calibrefx' ); ?>:</label><br />
            <select name="<?php echo $this->get_field_name( 'icon_size' ); ?>" id="<?php echo $this->get_field_id( 'icon_size' ); ?>">
                <option value=""><?php _e( 'Default', 'calibrefx' ); ?></option>
                <option value="fa-lg"<?php selected( 'fa-lg', $instance['icon_size'], true ); ?>><?php _e( 'Large', 'calibrefx' ); ?></option>
                <option value="fa-2x"<?php selected( 'fa-2x', $instance['icon_size'], true ); ?>><?php _e( '2x', 'calibrefx' ); ?></option>
                <option value="fa-3x"<?php selected( 'fa-3x', $instance['icon_size'], true ); ?>><?php _e( '3x', 'calibrefx' ); ?></option>
                <option value="fa-4x"<?php selected( 'fa-4x', $instance['icon_size'], true ); ?>><?php _e( '4x', 'calibrefx' ); ?></option>
                <option value="fa-4x"<?php selected( 'fa-5x', $instance['icon_size'], true ); ?>><?php _e( '5x', 'calibrefx' ); ?></option>
            </select>
        </p>

         <p>
            <label for="<?php echo $this->get_field_id( 'icon_style' ); ?>"><?php _e( 'Icon Style', 'calibrefx' ); ?>:</label><br />
            <select name="<?php echo $this->get_field_name( 'icon_style' ); ?>" id="<?php echo $this->get_field_id( 'icon_style' ); ?>">
                <option value=""><?php _e( 'Default', 'calibrefx' ); ?></option>
                <option value="-square"<?php selected( '-square', $instance['icon_style'], true ); ?>><?php _e( 'Boxed', 'calibrefx' ); ?></option>
            </select>
        </p>

        <hr class="div" />

        <p><strong>Icon Label</strong></p>

        <p>
            <label for="<?php echo $this->get_field_id( 'label_facebook' ); ?>"><?php _e( 'Facebook label', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'label_facebook' ); ?>" name="<?php echo $this->get_field_name( 'label_facebook' ); ?>" value="<?php echo esc_attr( $instance['label_facebook'] ); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'label_twitter' ); ?>"><?php _e( 'Twitter label', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'label_twitter' ); ?>" name="<?php echo $this->get_field_name( 'label_twitter' ); ?>" value="<?php echo esc_attr( $instance['label_twitter'] ); ?>" class="widefat" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id( 'label_gplus' ); ?>"><?php _e( 'Google+ label', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'label_gplus' ); ?>" name="<?php echo $this->get_field_name( 'label_gplus' ); ?>" value="<?php echo esc_attr( $instance['label_gplus'] ); ?>" class="widefat" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id( 'label_youtube' ); ?>"><?php _e( 'Youtube label', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'label_youtube' ); ?>" name="<?php echo $this->get_field_name( 'label_youtube' ); ?>" value="<?php echo esc_attr( $instance['label_youtube'] ); ?>" class="widefat" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id( 'label_linkedin' ); ?>"><?php _e( 'LinkedIn link label', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'label_linkedin' ); ?>" name="<?php echo $this->get_field_name( 'label_linkedin' ); ?>" value="<?php echo esc_attr( $instance['label_linkedin'] ); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'label_pinterest' ); ?>"><?php _e( 'Pinterest label', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'label_pinterest' ); ?>" name="<?php echo $this->get_field_name( 'label_pinterest' ); ?>" value="<?php echo esc_attr( $instance['label_pinterest'] ); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'label_instagram' ); ?>"><?php _e( 'Instagram label', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'label_instagram' ); ?>" name="<?php echo $this->get_field_name( 'label_instagram' ); ?>" value="<?php echo esc_attr( $instance['label_instagram'] ); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'label_github' ); ?>"><?php _e( 'Github label', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'label_github' ); ?>" name="<?php echo $this->get_field_name( 'label_github' ); ?>" value="<?php echo esc_attr( $instance['label_github'] ); ?>" class="widefat" />
        </p>
        <?php
	}

}