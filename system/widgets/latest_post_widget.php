<?php

/**
 * Register the widget for use in Appearance -> Widgets
 */
function calibrefx_latest_post_init() {
	register_widget( 'CFX_Latest_Post_Widget' );
}
add_action( 'widgets_init', 'calibrefx_latest_post_init' );

class CFX_Latest_Post_Widget extends WP_Widget {

	protected $defaults;

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct(
			'recent-posts-widget',
			apply_filters( 'calibrefx_widget_name', __( 'Recent Posts', 'calibrefx' ) ),
			array(
				'classname' => 'widget_recent_posts',
				'description' => __( 'Display recent posts with thumbnail on your sidebar', 'calibrefx' )
			)
		);

		$this->defaults = array(
			'title'       	=> '',
			'post_type'       	=> '',
			'num_posts'  	=> '5',
			'show_thumbnail' => 0,
			'image_size' => 'thumbnail',
			'show_detail' => 0,
			'show_category' => 0,
			'detail_length' => 100
		);

	}

	/**
	 * Display widget content.
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {
		global $wp_query,$calibrefx;

		extract( $args );
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $before_widget;

		if ( ! empty( $instance['title'] ) ) {
			echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title; }



		$query_args = array(
			'posts_per_page' => $instance['num_posts'],
			'orderby' => 'date',
			'order' => 'DESC',
			'ignore_sticky_posts' => true
		);

		if(empty($instance['post_type'])){
			if ( is_post_type_archive() ) {
				$query_args['post_type'] = get_queried_object()->query_var;
			}else if( is_singular() ){
				if( get_post_type() != 'page' ){
					$query_args['post_type'] = get_post_type();
				}
			}
		}else{
			$query_args['post_type'] = $instance['post_type'];
		}

		$query = new WP_Query( $query_args );

		$no_post_thumbnail = apply_filters( 'no_thumbnail_image_url', CALIBREFX_IMAGES_URL.'/no-image.jpg' );

		echo '<ul class="list-latest-posts">';

		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) : $query->the_post();

				$img = calibrefx_get_image( array( 'format' => 'html', 'size' => $instance['image_size']) );
				$img = ( ! empty( $img) ? $img : '<img src="'.$no_post_thumbnail.'" />' );
				$date_format = get_option( 'date_format' );
				$item_class = apply_filters( 'calibrefx_latest_posts_item_class', calibrefx_row_class() );
				$image_class = apply_filters( 'calibrefx_latest_posts_image_class', col_class( 12,4,4 ) );
				$content_class = apply_filters( 'calibrefx_latest_posts_content_class', col_class( 12,8,8 ) );

				if ( $instance['show_thumbnail'] ) {
					echo '
						<li>
							<div class="'.$item_class.' latest-post-item">
								<div class="latest-post-thumb '. $image_class .'">
									<a href="'.get_permalink().'" class="thumbnail">'.$img.'</a>
								</div>
								<div class="latest-post-detail '. $content_class .'">
									<h5 class="latest-post-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h5>
									<p class="latest-post-info">'.do_shortcode( '[post_date]' ).'</p>
									'.(($instance['show_category']) ? '<p class="latest-post-category">'.$this->print_category(get_the_id()).'</p>' : '').'
									'.($instance['show_detail'] ? get_the_content_limit( $instance['detail_length'] ) : '' ).'
								</div>
							</div>
						</li>
					';
				}else {
					echo '
						<li>
							<div class="'.calibrefx_row_class().' latest-post-item">
								<div class="latest-post-detail col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<h5 class="latest-post-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h5>
									<p class="latest-post-date">'.date( $date_format, get_the_time( 'U' ) ).'</p>
									'.(( $instance['show_detail']) ? get_the_content_limit( $instance['detail_length'] ) : '' ).'
									'.(( $instance['show_category']) ? '<p class="latest-post-category">'.$this->print_category(get_the_id()).'</p>' : '').'
								</div>
							</div>
						</li>
					';
				}

			endwhile;
		else :
			echo '<li>'.__( 'There is no post available yet', 'calibrefx' ).'</li>';
		endif;

		echo '</ul>';

		echo $after_widget;

		wp_reset_query();
		wp_reset_postdata();
	}

	 /**
	  * Update a particular instance.
	  */
	function update( $new_instance, $old_instance ) {

		$new_instance['title'] = strip_tags( $new_instance['title'] );
		return $new_instance;

	}

	/**
	 * Display the settings update form.
	 */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$args = array(
		   'public'   => true,
		   '_builtin' => false
		);

		$output = 'objects'; // names or objects, note names is the default
		$operator = 'or'; // 'and' or 'or'

		$post_types = get_post_types( $args, $output, $operator );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'calibrefx' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post type', 'calibrefx' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
				<option value=""><?php _e( 'Dynamic', 'calibrefx' ); ?></option>
				<?php foreach ($post_types as $key => $value): ?>
					<option value="<?php echo $key; ?>" <?php selected( $instance['post_type'], $key, true); ?>><?php echo $value->labels->name; ?></option>
				<?php endforeach ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'num_posts' ); ?>"><?php _e( 'Number of posts to show', 'calibrefx' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'num_posts' ); ?>" name="<?php echo $this->get_field_name( 'num_posts' ); ?>" value="<?php echo absint( $instance['num_posts'] ); ?>" size="3" />
		</p>

		<p>
			<input id="<?php echo $this->get_field_id( 'show_detail' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_detail' ); ?>" value="1"<?php checked( $instance['show_detail'] ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_detail' ); ?>"><?php _e( 'Show Content', 'calibrefx' ); ?></label>
		</p>

		<p>
			<input id="<?php echo $this->get_field_id( 'show_category' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_category' ); ?>" value="1"<?php checked( $instance['show_category'] ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_category' ); ?>"><?php _e( 'Show Category', 'calibrefx' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'detail_length' ); ?>"><?php _e( 'Content Length', 'calibrefx' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'detail_length' ); ?>" name="<?php echo $this->get_field_name( 'detail_length' ); ?>" value="<?php echo absint( $instance['detail_length'] ); ?>" size="3" />
		</p>

		<hr class="div" />

		<p>
			<input id="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'show_thumbnail' ); ?>" value="1"<?php checked( $instance['show_thumbnail'] ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>"><?php _e( 'Show Thumbnail', 'calibrefx' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e( 'Image Size', 'calibrefx' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'image_size' ); ?>" name="<?php echo $this->get_field_name( 'image_size' ); ?>">
				<option value="thumbnail">thumbnail (<?php echo get_option( 'thumbnail_size_w' ); ?>x<?php echo get_option( 'thumbnail_size_h' ); ?>)</option>
				<?php
				$sizes = calibrefx_get_additional_image_sizes();
				foreach ( (array) $sizes as $name => $size ) {
					echo '<option value="' . $name . '" ' . selected( $name, $instance['image_size'], false ) . '>' . $name . ' ( ' . $size['width'] . 'x' . $size['height'] . ' )</option>'; }
				?>
			</select>
		</p>

<?php
	}
	function print_category($id){
		$categories = wp_get_post_terms( $id, get_post_taxonomies( $id ) );
		$separator = ', ';
		$output = '';
		if ( ! empty( $categories ) ) {
		    foreach( $categories as $category ) {
		        $output .= '<a href="' . esc_url( get_term_link( $category ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
		    }
		    return trim( $output, $separator );
		}
	}
}
