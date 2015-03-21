<?php
add_action( 'widgets_init', create_function( '', "register_widget('CFX_Contact_Widget');" ) );

class CFX_Contact_Widget extends WP_Widget {

	protected $defaults;

	/**
	 * Constructor
	 */
	function __construct() {

		$this->defaults = array(
		   'title' => '',
		   'map_type' => 'gmap',
		   'map_height' => '180',
		   'show_map' => 1,
		   'show_personal_info' => 1,
		   'personal_info_title' => 'Contact Info',
		   'show_name' => 1,
		   'show_email' => 1,
		   'show_phone' => 1,
		   'show_mobile_phone' => 1,
		   'show_address' => 1,
		);

		$widget_ops = array(
			'classname' => 'contact-widget',
			'description' => __( 'Display contact information', 'calibrefx' ),
		);

		parent::__construct(
			'contact-info-widget',
			apply_filters( 'calibrefx_widget_name', __( 'Contact Widget', 'calibrefx' ) ),
			$widget_ops
		);
	}

	/**
	 * Display widget content.
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget($args, $instance) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $before_widget;

		if ( ! empty($instance['title']) ) {
			echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title; }
		?>
        <div class="contact-wrapper">
            <?php if ( $instance['show_map'] ){ ?>
            <div class="contact-map">
                <?php echo do_shortcode( '[contact_map height="'.$instance['map_height'].'"]' ); ?>
            </div>
            <?php } ?>
            <div class="contact-detail">    
            <?php
				$personal_info_output = '<ul class="personal-info fa-ul">';
				
                if ( $instance['show_name'] ){
					$personal_info_output .= '<li class="contact-name"><i class="fa fa-li fa-user fa-fw icon-contact-name"></i>' . calibrefx_get_option( 'contact_name' ) . '</li>';
				}
				
                if ( $instance['show_email'] ){
					$personal_info_output .= '<li class="contact-email"><a href="mailto:' . calibrefx_get_option( 'contact_email' ) . '"><i class="fa fa-li fa-envelope fa-fw icon-contact-email"></i>' . calibrefx_get_option( 'contact_email' ) . '</a></li>';
				}
				
                if ( $instance['show_phone'] ){
					$personal_info_output .= '<li class="contact-phone"><a href="' . calibrefx_get_option( 'contact_phone' ) . '"><i class="fa fa-li fa-phone fa-fw icon-contact-phone"></i>' . calibrefx_get_option( 'contact_phone' ) . '</a></li>';
				}
				
                if ( $instance['show_mobile_phone'] ){
					$personal_info_output .= '<li class="contact-fax"><a href="' . calibrefx_get_option( 'contact_mobile_phone' ) . '"><i class="fa fa-li fa-mobile fa-fw icon-contact-mobile"></i>' . calibrefx_get_option( 'contact_mobile_phone' ) . '</a></li>';
				}
				
                if ( $instance['show_address'] ){
					$personal_info_output .= '<li class="contact-address"><i class="fa fa-li fa-home fa-fw icon-contact-address"></i>' . nl2br( calibrefx_get_option( 'contact_address' ) ) . '</li>';
				}
				
                $personal_info_output .= '</ul>';

				$personal_info_output = apply_filters( 'calibrefx_personal_info_output', $personal_info_output );

				echo $personal_info_output;
			?>
            </div>
        </div>
        <?php
		echo $after_widget;
	}

	/**
	 * Update a particular instance.
	 */
	function update($new_instance, $old_instance) {
		if ( empty( $new_instance['show_name'] ) ) { $new_instance['show_name'] = 0; }
		if ( empty( $new_instance['show_email'] ) ) { $new_instance['show_email'] = 0; }
		if ( empty( $new_instance['show_phone'] ) ) { $new_instance['show_phone'] = 0; }
		if ( empty( $new_instance['show_mobile_phone'] ) ) { $new_instance['show_mobile_phone'] = 0; }
		if ( empty( $new_instance['show_address'] ) ) { $new_instance['show_address'] = 0; }
		if ( empty( $new_instance['show_map'] ) ) { $new_instance['show_map'] = 0; }

		return $new_instance;
	}

	/**
	 * Display the settings update form.
	 */
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		?>
        <p class="description" style="padding: 0px"><?php _e( 'All the configuration info', 'calibrefx' ); ?><a href="<?php echo admin_url( 'admin.php?page=calibrefx&section=contact' ); ?>"> <?php _e( 'here', 'calibrefx' ); ?></a></p>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
        </p>

        <hr class="div" />

        <p>
            <label for="<?php echo $this->get_field_id( 'show_map' ); ?>"><strong><?php _e( 'Show Map', 'calibrefx' ); ?>:</strong></label>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'show_map' ); ?>" name="<?php echo $this->get_field_name( 'show_map' ); ?>" value="1" <?php if ( $instance['show_map'] ) { echo 'checked="checked"'; } ?>/>
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id( 'map_height' ); ?>"><?php _e( 'Map Height', 'calibrefx' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'map_height' ); ?>" name="<?php echo $this->get_field_name( 'map_height' ); ?>" value="<?php echo esc_attr( $instance['map_height'] ); ?>" class="widefat" />
        </p>
        <p class="description" style="padding-bottom: 0px"><?php _e( 'Enter height for map. default: 180px', 'calibrefx' ); ?></p>

        <hr class="div" />
        
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'show_name' ); ?>" name="<?php echo $this->get_field_name( 'show_name' ); ?>" value="1" <?php if ( $instance['show_name'] ) { echo 'checked="checked"'; } ?>/>
            <label for="<?php echo $this->get_field_id( 'show_name' ); ?>"><?php _e( 'Show Contact Name', 'calibrefx' ); ?></label>
        </p>
        
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'show_email' ); ?>" name="<?php echo $this->get_field_name( 'show_email' ); ?>" value="1" <?php if ( $instance['show_email'] ) { echo 'checked="checked"'; } ?>/>
            <label for="<?php echo $this->get_field_id( 'show_email' ); ?>"><?php _e( 'Show Email Address', 'calibrefx' ); ?></label>
        </p>

        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'show_phone' ); ?>" name="<?php echo $this->get_field_name( 'show_phone' ); ?>" value="1" <?php if ( $instance['show_phone'] ) { echo 'checked="checked"'; } ?>/>
            <label for="<?php echo $this->get_field_id( 'show_phone' ); ?>"><?php _e( 'Show Phone Number', 'calibrefx' ); ?></label>
        </p>
        
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'show_mobile_phone' ); ?>" name="<?php echo $this->get_field_name( 'show_mobile_phone' ); ?>" value="1" <?php if ( $instance['show_mobile_phone'] ) { echo 'checked="checked"'; } ?>/>
            <label for="<?php echo $this->get_field_id( 'show_mobile_phone' ); ?>"><?php _e( 'Show Mobile Phone Number', 'calibrefx' ); ?></label>
        </p>

        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'show_address' ); ?>" name="<?php echo $this->get_field_name( 'show_address' ); ?>" value="1" <?php if ( $instance['show_address'] ) { echo 'checked="checked"'; } ?>/>
            <label for="<?php echo $this->get_field_id( 'show_address' ); ?>"><?php _e( 'Show Address', 'calibrefx' ); ?></label>
        </p>
        <?php
	}

}
