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

class CFX_Feature_Page_Slider_Widget extends WP_Widget {

    protected $defaults;

    /**
     * Constructor
     */
    function __construct() {

        $this->defaults = array(
            'title' => '',
            'page_id' => '',
            'interval' => 5000,
            'speed' => 800,
            'fx' => 'fade',
            'image_size' => '',
            'caption' => 0,
            'display_link' => 0,
        );

        $widget_ops = array(
            'classname' => 'page-slider-widget',
            'description' => __('Display image slider based on page', 'calibrefx'),
        );

 
        $this->WP_Widget('page-slider', __('Feature Page with Slider (CalibreFx)', 'calibrefx'), $widget_ops);
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
        
        $page_ids = explode(',', $instance['page_id']);

        $q = new WP_Query(array('post__in' => $page_ids, 'post_type'=>'page', 'orderby' => 'id', 'order' => 'ASC'));

       echo $before_widget;

        if(!empty($instance['title']))
            echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;
        
        $attr = '';
        $attr .= ' data-cycle-timeout="'.$instance['interval'].'"';
        $attr .= ' data-cycle-speed="'.$instance['speed'].'"';
        $attr .= ' data-cycle-fx="'.$instance['fx'].'"';
        $attr .= ' data-cycle-slides="> div.page-slider-item"';

        echo '<div class="page-slider-wrapper">';
        echo '<div class="page-slider cycle-slideshow"'.$attr.'>';

        if($instance['caption']){
            echo '<div class="cycle-overlay"></div>';

            $attr .= ' data-cycle-caption-plugin=caption2';
        }
    
        $loop_counter = 1;
        if ( $q->have_posts() ) : while ( $q->have_posts() ) : $q->the_post();
            
            $display_link = $instance['display_link'];

            if($display_link)
                 echo '<div class="page-slider-item" data-cycle-title=\'<a href="'.get_permalink().'">'.get_the_title().'</a>\' data-cycle-desc="">';
            else
                echo '<div class="page-slider-item" data-cycle-title="'.get_the_title().'" data-cycle-desc="">';

            $img = calibrefx_get_image(array( 'format' => 'html', 'size' => $instance['image_size']));

            if($display_link) echo '<a href="'.get_permalink().'">';
            echo $img;
            if($display_link) echo '</a>';
            
            
            echo '</div>';
            
            $loop_counter++;
        endwhile;    
        endif;
        
        echo '</div><!-- end .post-slider -->';
        echo '</div><!-- end .post-slider-wrapper -->';
        
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
            <label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Page ID', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('page_id'); ?>" name="<?php echo $this->get_field_name('page_id'); ?>" value="<?php echo esc_attr($instance['page_id']); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Interval', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>" value="<?php echo esc_attr($instance['interval']); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Slider Speed', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>" value="<?php echo esc_attr($instance['speed']); ?>" class="widefat" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('fx'); ?>"><?php _e('Slider Effect', 'calibrefx'); ?>:</label>
            <select id="<?php echo $this->get_field_id('fx'); ?>" name="<?php echo $this->get_field_name('fx'); ?>">
                <option style="padding-right:10px;" value="fade"<?php if($instance['fx'] == 'fade') echo ' selected="selected"'; ?>><?php _e('Fade', 'calibrefx'); ?></option>
                <option style="padding-right:10px;" value="fadeOut"<?php if($instance['fx'] == 'fadeOut') echo ' selected="selected"'; ?>><?php _e('Fade Out', 'calibrefx'); ?></option>
                <option style="padding-right:10px;" value="scrollHorz"<?php if($instance['fx'] == 'scrollHorz') echo ' selected="selected"'; ?>><?php _e('Scroll Horizontal', 'calibrefx'); ?></option>
                <option style="padding-right:10px;" value="none"<?php if($instance['fx'] == 'none') echo ' selected="selected"'; ?>><?php _e('None', 'calibrefx'); ?></option>
            </select>
        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id('image_size'); ?>"><?php _e('Image Size', 'calibrefx'); ?>:</label>
            <select id="<?php echo $this->get_field_id('image_size'); ?>" name="<?php echo $this->get_field_name('image_size'); ?>">
                <option style="padding-right:10px;" value="thumbnail"<?php if($instance['image_size'] == 'thumbnail') echo ' selected="selected"'; ?>><?php _e('thumbnail', 'calibrefx'); ?> (<?php echo get_option('thumbnail_size_w'); ?>x<?php echo get_option('thumbnail_size_h'); ?>)</option>
                <option style="padding-right:10px;" value="medium"<?php if($instance['image_size'] == 'medium') echo ' selected="selected"'; ?>><?php _e('medium', 'calibrefx'); ?> (<?php echo get_option('medium_size_w'); ?>x<?php echo get_option('medium_size_h'); ?>)</option>
                <option style="padding-right:10px;" value="large"<?php if($instance['image_size'] == 'large') echo ' selected="selected"'; ?>><?php _e('large', 'calibrefx'); ?> (<?php echo get_option('large_size_w'); ?>x<?php echo get_option('large_size_h'); ?>)</option>
                <option style="padding-right:10px;" value="full"<?php if($instance['image_size'] == 'full') echo ' selected="selected"'; ?>><?php _e('full size', 'calibrefx'); ?></option>
                <?php
                    $sizes = calibrefx_get_additional_image_sizes();
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
            <label for="<?php echo $this->get_field_id('display_link'); ?>"><?php _e('Show Post Link', 'calibrefx'); ?>:</label>
            <select id="<?php echo $this->get_field_id('display_link'); ?>" name="<?php echo $this->get_field_name('display_link'); ?>">
                <option value="1"<?php if($instance['display_link'] == '1') echo ' selected="selected"'?>>Show</option>
                <option value="0"<?php if($instance['display_link'] == '0') echo ' selected="selected"'?>>Hide</option>
            </select>
        </p>   

        <?php
    }

}