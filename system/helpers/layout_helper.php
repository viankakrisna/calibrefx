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
 * Calibrefx Layout Helper
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 */

/**
 * Function to check if layout is reponsive or fixed
 * 
 * @return type 
 */
function calibrefx_layout_is_fluid() {
    return calibrefx_get_option('layout_type') == 'fluid';
}

/**
 * Put wrappers into the structure
 *
 * @access public
 * @return string
 */
function calibrefx_put_wrapper($context = '', $output = '<div class="wrap row">', $echo = true) {

    $calibrefx_context_wrappers = get_theme_support('calibrefx-wraps');

    if (!in_array($context, (array) $calibrefx_context_wrappers[0]))
        return '';

    if (calibrefx_layout_is_fluid())
        return '';

    $row_class = calibrefx_row_class();
    switch ($output) {
        case 'open':
            $output = '<div class="wrap '.$row_class.'">';
            break;
        case 'close':
            $output = '</div><!-- end .wrap -->';
            break;
    }

    if ($echo)
        echo $output;
    else
        return $output;
}

/**
 * Register a layout
 *
 * @access public
 * @param $id the id of the layout
 * @paramg $args, layout configurations such as label, image, and value
 * @return void
 */
function calibrefx_register_layout($id, $args = array()) {
    global $_calibrefx_layouts;

    if (!is_array($_calibrefx_layouts))
        $_calibrefx_layouts = array();

    $defaults = array(
        'label' => __('No Label Selected', 'calibrefx'),
        'img' => CALIBREFX_IMAGES_URL . '/layouts/none.gif',
    );

    //don't allow duplicate id
    if (isset($_calibrefx_layouts[$id]))
        return;

    //parse the arguments
    $args = wp_parse_args($args, $defaults);

    $_calibrefx_layouts[$id] = $args;
}

/**
 * Remove a layout as the id given
 *
 * @access public
 * @param $id the id of the layout
 * @return bool, true if success
 */
function calibrefx_unregister_layout($id) {
    global $_calibrefx_layouts;

    //check if the id available, if not do nothing
    if (!isset($_calibrefx_layouts[$id]))
        return;

    //remove from array
    unset($_calibrefx_layouts[$id]);

    return true;
}

/**
 * Return the default layout settings: content-sidebar
 *
 * @access public
 * @return string
 */
function calibrefx_get_default_layout() {
    //For now just return content-sidebar as default
    //@TODO: make the option from the theme settings
    global $_calibrefx_layouts;

    $default = '';

    foreach ((array) $_calibrefx_layouts as $key => $value) {
        if (isset($value['default']) && $value['default']) {
            $default = $key;
            break;
        }
    }

    // return default layout, if exists
    if ($default) {
        return $default;
    }


    //if no default layout exist, then return the first key in array
    return key($_calibrefx_layouts);
}

/**
 * Helper to get the global layouts
 *
 * @access public
 * @return array
 */
function calibrefx_get_layouts() {
    global $_calibrefx_layouts;

    if (!is_array($_calibrefx_layouts))
        $_calibrefx_layouts = array();

    return $_calibrefx_layouts;
}

/**
 * Get the layout based on the context given
 *
 * @param string layout name
 * @return string
 */
function calibrefx_get_layout($context) {
    $layouts = calibrefx_get_layouts();

    if (!isset($layouts[$context]))
        return;

    return $layouts[$context];
}

/**
 * This function will get the custom layout from the specific post
 * if none, then will return default layout
 *
 * @param void
 * @return string
 */
function calibrefx_site_layout() {

    $site_layout = calibrefx_get_option('site_layout'); 

    // Use default layout as a fallback, if necessary
    if (!calibrefx_get_layout($site_layout)) {
        $site_layout = calibrefx_get_default_layout();
    }

    $front_content = get_option('show_on_front');

    $custom_layout = calibrefx_get_custom_field('site_layout');

    if((is_home() && $front_content == 'posts') || (is_front_page() && $front_content == 'posts')){
        $custom_layout = false;
    }

    if ($custom_layout) {
        return esc_attr(apply_filters('calibrefx_site_layout', $custom_layout));
    }
    return esc_attr(apply_filters('calibrefx_site_layout', $site_layout));
}

/**
 * html helper function to output layout setting
 *
 * @param array args
 * @return string
 */
function calibrefx_layout_selector($args = array()) {

    /** Merge defaults with user args */
    $args = wp_parse_args($args, array(
        'name' => '',
        'selected' => '',
        'echo' => true
            ));

    $output = '';

    foreach (calibrefx_get_layouts() as $id => $data) {

        $class = $id == $args['selected'] ? 'selected' : '';

        $output .= sprintf('<label title="%1$s" class="box %2$s"><img src="%3$s" alt="%1$s" /><br /> <input type="radio" name="%4$s" id="%5$s" value="%5$s" %6$s /></label>', esc_attr($data['label']), esc_attr($class), esc_url($data['img']), esc_attr($args['name']), esc_attr($id), checked($id, $args['selected'], false)
        );
    }

    /** Echo or Return output */
    if ($args['echo'])
        echo $output;
    else
        return $output;
}

/**
 * Get the row class for the html. will have post fix '-fluid' for responsive layout
 *
 * @return string
 */
function calibrefx_row_class() {
    $rowClass = 'row-fluid';

    return apply_filters( 'calibrefx_row_class', $rowClass );
}

/**
 * Echo function for calibrefx_row_class()
 *
 * @echo string
 */
function row_class() {
    echo calibrefx_row_class();
}

/**
 * Get the container class for the html. will have post fix '-fluid' for responsive layout
 *
 * @return string
 */
function calibrefx_container_class() {
    $containerClass = 'container-fluid';

    return apply_filters( 'calibrefx_container_class', $containerClass );
}

function calibrefx_set_layout($layout){
    add_filter('calibrefx_site_layout', 'calibrefx_layout_'.$layout);
}


/**
 * Helper function to change layout programmatically to full width
 *
 * @return string
 */
function calibrefx_layout_full_width(){
    return 'full-width-content';
}

/**
 * Helper function to change layout programmatically to content-sidebar
 *
 * @return string
 */
function calibrefx_layout_content_sidebar(){
    return 'content-sidebar';
}

/**
 * Helper function to change layout programmatically to sidebar-content
 *
 * @return string
 */
function calibrefx_layout_sidebar_content(){
    return 'sidebar-content';
}

/**
 * Helper function to change layout programmatically to sidebar-content-sidebar
 *
 * @return string
 */
function calibrefx_layout_sidebar_content_sidebar(){
    return 'sidebar-content-sidebar';
}