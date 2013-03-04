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
 
class CFX_Subscriber_Widget extends WP_Widget {
	
	protected $defaults;
	
	/**
	 * Constructor
	 */
	function __construct() {

		$this->defaults = array(
			'title'       => '',
			'text'        => '',
			'id'          => '',
			'input_text'  => '',
			'button_text' => '',
		);

		$widget_ops = array(
			'classname'   => 'subscriber-widget',
			'description' => __( 'Display email subscriber form for Feedburner', 'calibrefx' ),
		);

		$this->WP_Widget( 'subscriber', __( 'CalibreFx - Email Updates', 'calibrefx' ), $widget_ops );

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
		
		echo $before_widget . '<div class="subscriber">';

			if ( ! empty( $instance['title'] ) )
				echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;

			echo wpautop( $instance['text'] ); // We run KSES on update

			if ( ! empty( $instance['id'] ) ) : ?>
			<form id="subscribe" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open( 'http://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_js( $instance['id'] ); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
				<input type="text" value="<?php echo esc_attr( $instance['input_text'] ); ?>" id="subbox" onfocus="if ( this.value == '<?php echo esc_js( $instance['input_text'] ); ?>') { this.value = ''; }" onblur="if ( this.value == '' ) { this.value = '<?php echo esc_js( $instance['input_text'] ); ?>'; }" name="email" />
				<input type="hidden" name="uri" value="<?php echo esc_attr( $instance['id'] ); ?>" />
				<input type="hidden" name="loc" value="<?php echo esc_attr( get_locale() ); ?>" />
				<input type="submit" value="<?php echo esc_attr( $instance['button_text'] ); ?>" id="subbutton" />
			</form>
			<?php endif;

		echo '</div>' . $after_widget;
		
	}
	 
	 /**
	  * Update a particular instance.
	  */
	function update( $new_instance, $old_instance ) {

		$new_instance['title'] = strip_tags( $new_instance['title'] );
		$new_instance['text']  = calibrefx_formatting_kses( $new_instance['text'] );
		return $new_instance;

	}
	
	/**
	 * Display the settings update form.
	 */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'calibrefx' ); ?>:</label><br />
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text To Show', 'calibrefx' ); ?>:</label><br />
			<textarea id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" class="widefat" rows="6" cols="4"><?php echo htmlspecialchars( $instance['text'] ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'Google/Feedburner ID', 'calibrefx' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo esc_attr( $instance['id'] ); ?>" class="widefat" />
		</p>

		<p>
			<?php $input_text = empty( $instance['input_text'] ) ? __( 'Enter your email address...', 'calibrefx' ) : $instance['input_text']; ?>
			<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'Input Text', 'calibrefx' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'input_text' ); ?>" name="<?php echo $this->get_field_name( 'input_text' ); ?>" value="<?php echo esc_attr( $input_text ); ?>" class="widefat" />
		</p>

		<p>
			<?php $button_text = empty( $instance['button_text'] ) ? __( 'Go', 'calibrefx' ) : $instance['button_text']; ?>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Button Text', 'calibrefx' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" value="<?php echo esc_attr( $button_text ); ?>" class="widefat" />
		</p>
<?php
	}
}