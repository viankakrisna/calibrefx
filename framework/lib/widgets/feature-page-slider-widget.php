<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * Contain facebook comment widgets class
 * extend from WP_Widget Class
 *
 * @package CalibreFx
 */
class Calibrefx_Page_Slider_Widget extends WP_Widget {

    protected $defaults;

    /**
     * Constructor
     */
    function __construct() {

        $this->defaults = array(
            'title' => '',
            'page_id' => '',
            'effect' => 'random',
            'slices' => '15',
            'boxCols' => '8',
            'boxRows' => '4',
            'animSpeed' => '500',
            'pauseTime' => '3000', 
            'directionNav' => 'true',
            'controlNav' => 'true',
        );

        $widget_ops = array(
            'classname' => 'page-slider-widget',
            'description' => __('Display image slider based on page', 'calibrefx'),
        );

 
        $this->WP_Widget('page-slider', __('CalibreFx - Page Slider Widget', 'calibrefx'), $widget_ops);
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

        echo $before_widget . '<div id="page-slider" class="nivoSlider">';

        if ( $q->have_posts() ) : while ( $q->have_posts() ) : $q->the_post();
        
        $img = calibrefx_get_image(array( 'format' => 'html', 'size' => '', 'class' => 'nivo-image'));
        
        echo $img;
        
        endwhile;    
        endif;

        echo '</div><!-- end slider -->'; 
        
        echo "
        <script>
            jQuery(document).ready(function(){
                $('#page-slider').nivoSlider({
			effect: '".$instance['effect']."', // Specify sets like: 'fold,fade,sliceDown'
			slices: ".$instance['slices'].", // For slice animations
			boxCols: ".$instance['boxCols'].", // For box animations
			boxRows: ".$instance['boxRows'].", // For box animations
			animSpeed: ".$instance['animSpeed'].", // Slide transition speed
			pauseTime: ".$instance['pauseTime'].", // How long each slide will show
			startSlide: 0, // Set starting Slide (0 index)
			directionNav: ".$instance['directionNav'].", // Next & Prev navigation
			directionNavHide: true, // Only show on hover
			controlNav: ".$instance['controlNav'].", // 1,2,3... navigation
			controlNavThumbs: false, // Use thumbnails for Control Nav
			controlNavThumbsFromRel: false, // Use image rel for thumbs
			controlNavThumbsSearch: '.jpg', // Replace this with...
			controlNavThumbsReplace: '_thumb.jpg', // ...this in thumb Image src
			keyboardNav: false, // Use left & right arrows
			pauseOnHover: true, // Stop animation while hovering
			manualAdvance: false, // Force manual transitions
			captionOpacity: 0.8, // Universal caption opacity
			prevText: 'Prev', // Prev directionNav text
			nextText: 'Next', // Next directionNav text
			randomStart: false, // Start on a random slide
			beforeChange: function(){}, // Triggers before a slide transition
			afterChange: function(){}, // Triggers after a slide transition
			slideshowEnd: function(){}, // Triggers after all slides have been shown
			lastSlide: function(){}, // Triggers when last slide is shown
			afterLoad: function(){} // Triggers when slider has loaded
		});
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
            <label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Page ID', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('page_id'); ?>" name="<?php echo $this->get_field_name('page_id'); ?>" value="<?php echo esc_attr($instance['page_id']); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('effect'); ?>"><?php _e('Effect', 'calibrefx'); ?>:</label>
            <select id="<?php echo $this->get_field_id( 'effect' ); ?>" name="<?php echo $this->get_field_name( 'effect' ); ?>">
                    <option value="sliceDown" <?php selected( 'sliceDown', $instance['effect'] ); ?>><?php _e( 'Slice Down', 'calibrefx' ); ?></option>
                    <option value="sliceDownLeft" <?php selected( 'sliceDownLeft', $instance['effect'] ); ?>><?php _e( 'Slice Down Left', 'calibrefx' ); ?></option>
                    <option value="sliceUp" <?php selected( 'sliceUp', $instance['effect'] ); ?>><?php _e( 'Slice Up', 'calibrefx' ); ?></option>
                    <option value="sliceUpLeft" <?php selected( 'sliceUpLeft', $instance['effect'] ); ?>><?php _e( 'Slice Up Left', 'calibrefx' ); ?></option>
                    <option value="sliceUpDown" <?php selected( 'sliceUpDown', $instance['effect'] ); ?>><?php _e( 'Slice Up Down', 'calibrefx' ); ?></option>
                    <option value="sliceUpDownLeft" <?php selected( 'sliceUpDownLeft', $instance['effect'] ); ?>><?php _e( 'Slice Up Down Left', 'calibrefx' ); ?></option>
                    <option value="fold" <?php selected( 'fold', $instance['effect'] ); ?>><?php _e( 'Fold', 'calibrefx' ); ?></option>
                    <option value="fade" <?php selected( 'fade', $instance['effect'] ); ?>><?php _e( 'Fade', 'calibrefx' ); ?></option>
                    <option value="random" <?php selected( 'random', $instance['effect'] ); ?>><?php _e( 'Random', 'calibrefx' ); ?></option>
                    <option value="slideInRight" <?php selected( 'slideInRight', $instance['effect'] ); ?>><?php _e( 'Slide In Right', 'calibrefx' ); ?></option>
                    <option value="slideInLeft" <?php selected( 'slideInLeft', $instance['effect'] ); ?>><?php _e( 'Slide In Left', 'calibrefx' ); ?></option>
                    <option value="boxRandom" <?php selected( 'boxRandom', $instance['effect'] ); ?>><?php _e( 'Box Random', 'calibrefx' ); ?></option>
                    <option value="boxRain" <?php selected( 'boxRain', $instance['effect'] ); ?>><?php _e( 'Box Rain', 'calibrefx' ); ?></option>
                    <option value="boxRainReverse" <?php selected( 'boxRainReverse', $instance['effect'] ); ?>><?php _e( 'Box Rain Reverse', 'calibrefx' ); ?></option>
                    <option value="boxRainGrow" <?php selected( 'boxRainGrow', $instance['effect'] ); ?>><?php _e( 'Box Rain Grow', 'calibrefx' ); ?></option>
                    <option value="boxRainGrowReverse" <?php selected( 'boxRainGrowReverse', $instance['effect'] ); ?>><?php _e( 'Box Rain Grow Reverse', 'calibrefx' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('slices'); ?>"><?php _e('Number Of Slices', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('slices'); ?>" name="<?php echo $this->get_field_name('slices'); ?>" value="<?php echo esc_attr($instance['slices']); ?>" class="widefat" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('boxCols'); ?>"><?php _e('Number Of Columns (For box animations)', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('boxCols'); ?>" name="<?php echo $this->get_field_name('boxCols'); ?>" value="<?php echo esc_attr($instance['boxCols']); ?>" class="widefat" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('boxRows'); ?>"><?php _e('Number Of Rows (For box animations)', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('boxRows'); ?>" name="<?php echo $this->get_field_name('boxRows'); ?>" value="<?php echo esc_attr($instance['boxRows']); ?>" class="widefat" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('animSpeed'); ?>"><?php _e('Slide Transition Speed', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('animSpeed'); ?>" name="<?php echo $this->get_field_name('animSpeed'); ?>" value="<?php echo esc_attr($instance['animSpeed']); ?>" class="widefat" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('pauseTime'); ?>"><?php _e('Slide Transition Pause Time', 'calibrefx'); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('pauseTime'); ?>" name="<?php echo $this->get_field_name('pauseTime'); ?>" value="<?php echo esc_attr($instance['pauseTime']); ?>" class="widefat" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('directionNav'); ?>"><?php _e('Show Direction', 'calibrefx'); ?>:</label>
            <select id="<?php echo $this->get_field_id( 'directionNav' ); ?>" name="<?php echo $this->get_field_name( 'directionNav' ); ?>">
                    <option value="true" <?php selected( 'true', $instance['directionNav'] ); ?>><?php _e( 'Show', 'calibrefx' ); ?></option>
                    <option value="false" <?php selected( 'false', $instance['directionNav'] ); ?>><?php _e( 'Hide', 'calibrefx' ); ?></option>
            </select>
        </p>  
        
        <p>
            <label for="<?php echo $this->get_field_id('controlNav'); ?>"><?php _e('Show Number Navigation', 'calibrefx'); ?>:</label>
            <select id="<?php echo $this->get_field_id( 'controlNav' ); ?>" name="<?php echo $this->get_field_name( 'controlNav' ); ?>">
                    <option value="true" <?php selected( 'true', $instance['controlNav'] ); ?>><?php _e( 'Show', 'calibrefx' ); ?></option>
                    <option value="false" <?php selected( 'false', $instance['controlNav'] ); ?>><?php _e( 'Hide', 'calibrefx' ); ?></option>
            </select>
        </p>

        <?php
    }

}