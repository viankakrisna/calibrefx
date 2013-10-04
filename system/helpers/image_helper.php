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


/**
 * Get image id from a post
 */
function calibrefx_get_image_id($num = 0) {
    global $post;

	if(is_404()) return;
	
    $image_ids = array_keys(
            get_children(
                    array(
                        'post_parent' => $post->ID,
                        'post_type' => 'attachment',
                        'post_mime_type' => 'image',
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    )
            )
    );

    if (isset($image_ids[$num]))
        return $image_ids[$num];

    return false;
}

/**
 * Get an image from the media gallery and returns it
 */
function calibrefx_get_image($args = array()) {
    global $post;
	
	if(!$post) return;
	
    $defaults = array(
        'format' => 'html',
        'size' => 'full',
        'num' => 0,
        'attr' => '',
		'id' => ''
    );
    $defaults = apply_filters('calibrefx_get_image_default_args', $defaults);

    $args = wp_parse_args($args, $defaults);
    
    // Allow child theme to short-circuit this function
    $pre = apply_filters('calibrefx_pre_get_image', false, $args, $post);
    if (false !== $pre)
        return $pre;

    // check for feature image
    if (has_post_thumbnail() && ($args['num'] === 0)) {
        $id = (!empty($args['id']) ? $args['id'] : get_post_thumbnail_id());
        //$html = wp_get_attachment_image($id, $args['size'], false, $args['attr']);
        $html = get_the_post_thumbnail($post->ID, $args['size'], $args['attr']);
        list($url) = wp_get_attachment_image_src($id, $args['size'], false, $args['attr']);
    } else {
        $id = (!empty($args['id']) ? $args['id'] : calibrefx_get_image_id($args['num']));
        $html = wp_get_attachment_image($id, $args['size'], false, $args['attr']);
        list($url) = wp_get_attachment_image_src($id, $args['size'], false, $args['attr']);
    }

    // source path, relative to the root
    $src = str_replace(home_url(), '', $url);

    // determine output
    if (strtolower($args['format']) == 'html')
        $output = $html;
    elseif (strtolower($args['format']) == 'url')
        $output = $url;
    else
        $output = $src;

    // $url is blank return false
    if (empty($url))
        $output = FALSE;

    // return data, filtered
    return apply_filters('calibrefx_get_image', $output, $args, $id, $html, $url, $src);
}

/**
 * Get an image from media gallery
 * an helper function to shorten calibrefx_get_image
 */
function calibrefx_image($args = array()) {
    $image = calibrefx_get_image($args);

    if ($image)
        echo $image;
    else
        return FALSE;
}

add_filter('wp_get_attachment_image_attributes', 'calibrefx_filter_attachment_image_attributes', 10, 2);

/**
 * Filters the attributes array in the wp_get_attachment_image function
 */
function calibrefx_filter_attachment_image_attributes($attr, $attachment) {
    $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);

    if ($alt)
        $attr['alt'] = esc_attr($alt);

    return $attr;
}

/**
 * Get additional image sizes
 *
 * @return array
 */
function calibrefx_get_additional_image_sizes() {
    global $_wp_additional_image_sizes;

    if ($_wp_additional_image_sizes)
        return $_wp_additional_image_sizes;

    return array();
}

/**
 * Get all image sizes
 *
 * @return array
 */
function calibrefx_get_image_sizes() {
    $builtin_sizes = array(
        'large' => array(
            'width' => get_option('large_size_w'),
            'height' => get_option('large_size_h')
        ),
        'medium' => array(
            'width' => get_option('medium_size_w'),
            'height' => get_option('medium_size_h')
        ),
        'thumbnail' => array(
            'width' => get_option('thumbnail_size_w'),
            'height' => get_option('thumbnail_size_h')
        )
    );

    $additional_sizes = calibrefx_get_additional_image_sizes();

    return array_merge($builtin_sizes, $additional_sizes);
}