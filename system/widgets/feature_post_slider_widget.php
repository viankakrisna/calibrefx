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

class CFX_Feature_Post_Slider_Widget extends WP_Widget {

    protected $defaults;

    /**
     * Constructor
     */
    function __construct() {

        $this->defaults = array(
            'title' => '',
            'category_id' => '',
            'numberPost' => '5',
            'interval' => '5000',
			'image_size' => '',
			'caption' => '1',
			'text_limit' => '100',
			'more_text' => 'read more'
        );

        $widget_ops = array(
            'classname' => 'post-slider-widget',
            'description' => __('Display image slider based on post', 'calibrefx'),
        );

 
        $this->WP_Widget('post-slider', __('CalibreFx - Post Slider Widget', 'calibrefx'), $widget_ops);
    }

    /**
     * Display widget content.
     *
     * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
     * @param array $instance The settings for the particular instance of the widget
     */
    function widget($args, $instance) {
        extract($args);
        $instance = wp_parse_args((array) $instance, $this->defaults);

        $q = new WP_Query(array('cat' => $instance['category_id'], 'posts_per_page' => $instance['numberPost']));

        echo $before_widget . '<div id="post-slider" class="carousel slide">';
		
		echo '<div class="carousel-inner">';

		$loop_counter = 1;
        if ( $q->have_posts() ) : while ( $q->have_posts() ) : $q->the_post();
			
			if($loop_counter == 1){
				echo '<div class="item active">';
			}else{
				echo '<div class="item">';
			}
			
			$img = calibrefx_get_image(array( 'format' => 'html', 'size' => $instance['image_size']));
        
			echo $img;
			
			if($instance['caption']){
				echo '<div class="carousel-caption">';
				echo '<h4>'.get_the_title().'</h4>';
				
				the_content_limit( (int) $instance['text_limit'], esc_html( $instance['more_text'] ) );
				echo '</div><!-- end carousel caption -->';
			}
			
			echo '</div><!-- end carousel item -->';
			
			$loop_counter++;
        endwhile;    
        endif;
		
		echo '</div><!-- end carousel inner -->';
		echo '<!-- Carousel nav -->
			<a class="carousel-control left" href="#post-slider" data-slide="prev">&lsaquo;</a>
			<a class="carousel-control right" href="#post-slider" data-slide="next">&rsaquo;</a>
		';
        echo '</div><!-- end carousel slide -->';
        
        echo "
        <script>
            jQuery(document).ready(function(){
                $('#post-slider').carousel({
				  interval: ".$instance['interval']."
				})
            });
        </script>
        ";
        
        echo $after_widget;
    }

    /**
     * Update a particular instance.
     */
    function update($new_instance, $old_instance) {

        $new_instance['title'] = strip_tags($new_instance['title']);
        return $new_instance;
    }

    /**
     * Display the settings update form.
     */
    function form($instance) {
        $instance = wp_parse_args((array) $instance, $this->defaults);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('category_id'); ?>"><?php _e('Category', 'calibrefx'); ?>:</label>
            <?php wp_dropdown_categories( array( 'name' => $this->get_field_name( 'category_id' ), 'selected' => $instance['category_id'] ) ); ?>
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('numberPost'); ?>"><?php _e('Number of Slider', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('numberPost'); ?>" name="<?php echo $this->get_field_name('numberPost'); ?>" value="<?php echo esc_attr($instance['numberPost']); ?>" class="widefat" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Interval', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>" value="<?php echo esc_attr($instance['interval']); ?>" class="widefat" />
        </p>
		
		<p>
			<label for="<?php echo $this->get_field_id('image_size'); ?>"><?php _e('Image Size', 'calibrefx'); ?>:</label>
			<?php $sizes = calibrefx_get_additional_image_sizes(); ?>
			<select id="<?php echo $this->get_field_id('image_size'); ?>" name="<?php echo $this->get_field_name('image_size'); ?>">
				<option style="padding-right:10px;" value="thumbnail">thumbnail (<?php echo get_option('thumbnail_size_w'); ?>x<?php echo get_option('thumbnail_size_h'); ?>)</option>
				<?php
				foreach((array)$sizes as $name => $size) :
				echo '<option style="padding-right: 10px;" value="'.esc_attr($name).'" '.selected($name, $instance['image_size'], FALSE).'>'.esc_html($name).' ('.$size['width'].'x'.$size['height'].')</option>';
				endforeach;
				?>
			</select>
		</p>	
		
		<p>
			<label for="<?php echo $this->get_field_id('caption'); ?>"><?php _e('Show Caption', 'calibrefx'); ?>:</label>
			<select id="<?php echo $this->get_field_id('caption'); ?>" name="<?php echo $this->get_field_name('caption'); ?>">
				<option value="1"<?php if($instance['caption'] == '1') echo ' selected="selected"'?>>Show</option>
				<option value="0"<?php if($instance['caption'] == '0') echo ' selected="selected"'?>>Hide</option>
			</select>
		</p>	
		
		<p>
            <label for="<?php echo $this->get_field_id('text_limit'); ?>"><?php _e('Caption Text Limit', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('text_limit'); ?>" name="<?php echo $this->get_field_name('text_limit'); ?>" value="<?php echo esc_attr($instance['text_limit']); ?>" class="widefat" />
        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id('more_text'); ?>"><?php _e('Caption Read More Text', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('more_text'); ?>" name="<?php echo $this->get_field_name('more_text'); ?>" value="<?php echo esc_attr($instance['more_text']); ?>" class="widefat" />
        </p>

        <?php
    }

}