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
 
class CFX_Feature_Post_Widget extends WP_Widget {
	
	protected $defaults;
	
	/**
	 * Constructor
	 */
	function __construct() {

		$this->defaults = array(
			'title'       	  => '',
			'posts_cat'       => '',
			'post_num'        => 5,
			'show_image'      => 0,
			'image_alignment' => 'alignleft',
			'image_size'      => '',
			'show_title'      => 0,
			'show_content'    => 0,
			'show_date'       => 0,
			'content_limit'   => '',
			'more_text'   	  => '[More...]',
		);

		$widget_ops = array(
			'classname'   => 'feature-post-widget',
			'description' => __( 'Display feature post with thumbnail', 'calibrefx' ),
		);

		$this->WP_Widget( 'feature-post', __( 'Feature Post (CalibreFx)', 'calibrefx' ), $widget_ops );

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
		
		//$featured_page = new WP_Query( array( 'page_id' => $instance['page_id'] ) );
		$query_args = array(
			'post_type' => 'post',
			'cat'       => $instance['posts_cat'],
			'showposts' => $instance['post_num'],
		);
		$featured_posts = new WP_Query( $query_args );
		
		echo $before_widget . '<div class="feature-post">';

			if ( ! empty( $instance['title'] ) )
				echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;

			if ( $featured_posts->have_posts() ) : while ( $featured_posts->have_posts() ) : $featured_posts->the_post();
				echo '<div class="' . implode( ' ', get_post_class() ) . '">';
			
				if ( ! empty( $instance['show_title'] ) )
					printf( '<h4 class="entry-title"><a href="%s" title="%s">%s</a></h4>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );
				
				//Show image
				if ( ! empty( $instance['show_image'] ) )
					printf(
						'<a href="%s" title="%s" class="%s">%s</a>',
						get_permalink(),
						the_title_attribute( 'echo=0' ),
						esc_attr( $instance['image_alignment'] ),
						calibrefx_get_image( array( 'format' => 'html', 'size' => $instance['image_size'], ) )
					);

				if ( ! empty( $instance['show_content'] ) ) {
					if ( empty( $instance['content_limit'] ) )
						the_content( $instance['more_text'] );
					else
						the_content_limit( (int) $instance['content_limit'], esc_html( $instance['more_text'] ) );
				}

				if ( ! empty( $instance['show_content'] ) ) {
					echo do_shortcode('[post_date format="relative"]');
				}

				echo '</div><!--end post_class()-->' . "\n\n";

				endwhile;
			endif;
		echo '</div>' . $after_widget;
		
		wp_reset_query();
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
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'calibrefx' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'posts_cat' ); ?>"><?php _e( 'Category', 'calibrefx' ); ?>:</label>
			<?php
			$categories_args = array(
				'name'            => $this->get_field_name( 'posts_cat' ),
				'selected'        => $instance['posts_cat'],
				'orderby'         => 'Name',
				'hierarchical'    => 1,
				'show_option_all' => __( 'All Categories', 'calibrefx' ),
				'hide_empty'      => '0',
			);
			wp_dropdown_categories( $categories_args ); ?>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'post_num' ); ?>"><?php _e( 'Number of Posts to Show', 'calibrefx' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'post_num' ); ?>" name="<?php echo $this->get_field_name( 'post_num' ); ?>" value="<?php echo esc_attr( $instance['post_num'] ); ?>" size="2" />
		</p>

		<hr class="div" />
		
		<p>
			<input id="<?php echo $this->get_field_id( 'show_image' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_image' ); ?>" value="1"<?php checked( $instance['show_image'] ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( 'Show Featured Image', 'calibrefx' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e( 'Image Size', 'calibrefx' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'image_size' ); ?>" name="<?php echo $this->get_field_name( 'image_size' ); ?>">
				<option value="thumbnail">thumbnail (<?php echo get_option( 'thumbnail_size_w' ); ?>x<?php echo get_option( 'thumbnail_size_h' ); ?>)</option>
				<?php
				$sizes = calibrefx_get_additional_image_sizes();
				foreach ( (array) $sizes as $name => $size )
					echo '<option value="' . $name . '" ' . selected( $name, $instance['image_size'], FALSE ) . '>' . $name . ' (' . $size['width'] . 'x' . $size['height'] . ')</option>';
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'image_alignment' ); ?>"><?php _e( 'Image Alignment', 'calibrefx' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'image_alignment' ); ?>" name="<?php echo $this->get_field_name( 'image_alignment' ); ?>">
				<option value="alignnone">- <?php _e( 'None', 'calibrefx' ); ?> -</option>
				<option value="alignleft" <?php selected( 'alignleft', $instance['image_alignment'] ); ?>><?php _e( 'Left', 'calibrefx' ); ?></option>
				<option value="alignright" <?php selected( 'alignright', $instance['image_alignment'] ); ?>><?php _e( 'Right', 'calibrefx' ); ?></option>
			</select>
		</p>

		<hr class="div" />
		
		<p>
			<input id="<?php echo $this->get_field_id( 'show_title' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_title' ); ?>" value="1"<?php checked( $instance['show_title'] ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show Page Title', 'calibrefx' ); ?></label>
		</p>

		<p>
			<input id="<?php echo $this->get_field_id( 'show_content' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_content' ); ?>" value="1"<?php checked( $instance['show_content'] ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_content' ); ?>"><?php _e( 'Show Page Content', 'calibrefx' ); ?></label>
		</p>

		<p>
			<input id="<?php echo $this->get_field_id( 'show_date' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_date' ); ?>" value="1"<?php checked( $instance['show_date'] ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Show Date Content', 'calibrefx' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'content_limit' ); ?>"><?php _e( 'Content Character Limit', 'calibrefx' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'content_limit' ); ?>" name="<?php echo $this->get_field_name( 'content_limit' ); ?>" value="<?php echo esc_attr( $instance['content_limit'] ); ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'more_text' ); ?>"><?php _e( 'More Text', 'calibrefx' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'more_text' ); ?>" name="<?php echo $this->get_field_name( 'more_text' ); ?>" value="<?php echo esc_attr( $instance['more_text'] ); ?>" />
		</p>
<?php
	}
}