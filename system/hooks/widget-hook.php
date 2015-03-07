<?php
/**
 * Calibrefx Widget Hooks
 *
 */

/**
 * Add the "(Calibrefx)" suffix to the widget names
 */
function calibrefx_widgets_add_suffix( $widget_name ) {
	return sprintf( __( '%s (Calibrefx)', 'calibrefx' ), $widget_name );
}
add_filter( 'calibrefx_widget_name', 'calibrefx_widgets_add_suffix' );

/**
 * This function registers all the default CalibreFx widget.
 */
function calibrefx_register_widget() {

	calibrefx_register_sidebar(array(
		'name' => __( 'Primary Sidebar', 'calibrefx' ),
		'description' => __( 'This is the primary sidebar if you are using a 2 or 3 column site layout option', 'calibrefx' ),
		'id' => 'sidebar',
	) );

	calibrefx_register_sidebar(array(
		'name' => __( 'Secondary Sidebar', 'calibrefx' ),
		'description' => __( 'This is the secondary sidebar if you are using a 3 column site layout option', 'calibrefx' ),
		'id' => 'sidebar-alt',
	) );

	do_action( 'calibrefx_sidebar_registered' );
}
add_action( 'init', 'calibrefx_register_widget' );

/**
 * This function registers additional CalibreFx widget.
 */
function calibrefx_register_additional_widget() {
	$header_right_widget = current_theme_supports( 'calibrefx-header-right-widgets' );

	if ( $header_right_widget ) {
		calibrefx_register_sidebar( array(
			'name' => __( 'Header Right', 'calibrefx' ),
			'description' => __( 'This is the right side of the header', 'calibrefx' ),
			'id' => 'header-right',
		) );
	}

	$footer_widget = current_theme_supports( 'calibrefx-footer-widgets' );

	if ( $footer_widget ) {
		calibrefx_register_sidebar(array(
			'name' => __( 'Footer Widget', 'calibrefx' ),
			'description' => __( 'This is the footer widget', 'calibrefx' ),
			'id' => 'footer-widget',
		) );
	}
}
add_action( 'calibrefx_sidebar_registered', 'calibrefx_register_additional_widget' );

function calibrefx_custom_widget_attributes( $widget, $return, $instance ) {
	if ( ! isset( $instance['custom_widget_class'] ) ) { $instance['custom_widget_class'] = ''; }
	if ( ! isset( $instance['custom_icon_class'] ) ) { $instance['custom_icon_class'] = ''; }
	if ( ! isset( $instance['show_advanced'] ) ) { $instance['show_advanced'] = 0; }
?>
<p>
    <input type="checkbox" id="<?php echo $widget->get_field_id( 'show_advanced' ); ?>" name="<?php echo $widget->get_field_name( 'show_advanced' ); ?>" value="1" <?php if ( $instance['show_advanced'] ) { echo 'checked="checked"'; } ?> class="show_advanced" />
    <label for="<?php echo $widget->get_field_id( 'show_advanced' ); ?>"><strong><?php _e( 'Calibrefx Advanced Settings', 'calibrefx' ); ?></strong></label>
</p>

<div class="advanced-widget-options"<?php echo ( $instance['show_advanced'] ? ' style="display:block;"' : '' )?>>
    <p>
        <label for="<?php echo $widget->get_field_id( 'custom_widget_class' ); ?>"><?php _e( 'Custom Widget Classes', 'calibrefx' ); ?>:</label><br />
        <input type="text" id="<?php echo $widget->get_field_id( 'custom_widget_class' ); ?>" name="<?php echo $widget->get_field_name( 'custom_widget_class' ); ?>" value="<?php echo esc_attr( $instance['custom_widget_class'] ); ?>" class="widefat" />
    </p>
    <p class="description"><?php _e( 'This will set a custom classes for your widget', 'calibrefx' ); ?></p>

    <p>
        <label for="<?php echo $widget->get_field_id( 'custom_icon_class' ); ?>"><?php _e( 'Custom Icon Classes', 'calibrefx' ); ?>:</label><br />
        <input type="text" id="<?php echo $widget->get_field_id( 'custom_icon_class' ); ?>" name="<?php echo $widget->get_field_name( 'custom_icon_class' ); ?>" value="<?php echo esc_attr( $instance['custom_icon_class'] ); ?>" class="widefat" />
    </p>
    <p class="description"><?php _e( 'This set an icon in widget title using font-awesome. <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Learn more about font-awesome.</a>', 'calibrefx' ); ?></p>
</div>
<?php
}
add_filter( 'in_widget_form', 'calibrefx_custom_widget_attributes', 10, 3 );

function calibrefx_widget_update_callback( $instance, $new_instance ) {
	if ( empty( $new_instance['show_advanced'] ) ) {
		$new_instance['show_advanced'] = 0;
	}

	$instance = array_merge( $instance, $new_instance );

	return $instance;
}
add_filter( 'widget_update_callback', 'calibrefx_widget_update_callback', 20, 2 );

function calibrefx_custom_class_widget( $instance, $widget, $args ) {
	if ( isset( $instance['custom_widget_class'] ) ) {
		$widget_classname = $widget->widget_options['classname'];
		$custom_classname = $instance['custom_widget_class'];

		$args['before_widget'] = str_replace( $widget_classname, "{$widget_classname} {$custom_classname}", $args['before_widget'] );
	}

	if ( isset( $instance['custom_icon_class'] ) ) {
		$custom_icon_class = $instance['custom_icon_class'];

		$args['before_title'] = str_replace( 'widgettitle">', 'widgettitle"><i class="fa ' . $custom_icon_class . '"></i> ', $args['before_title'] );

	}

	$widget->widget( $args, $instance );

	return false;
}
add_filter( 'widget_display_callback', 'calibrefx_custom_class_widget', 10, 3 );