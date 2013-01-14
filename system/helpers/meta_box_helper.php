<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This file handles meta box in admin settings
 *
 * @package CalibreFx
 */
function calibrefx_clear_meta_section() {
    global $calibrefx_sections;
    unset($calibrefx_sections);

    if (!isset($calibrefx_sections))
        $calibrefx_sections = array();
}

/**
 * Add Section tab in the Theme Settings
 *
 * @since 1.0.2
 *
 * @param string $slug String section slug.
 * @param string $title Title of the section.
 * @param string $ability Optional. The ability that can see the settings ('general', 'professor').
 */
function calibrefx_add_meta_section($slug, $title, $target='options.php') {
    global $calibrefx_sections;

    if (!isset($calibrefx_sections))
        $calibrefx_sections = array();

    if (!isset($calibrefx_sections[$slug]))
        $calibrefx_sections[$slug] = array();

    //if the section already exist then we do nothing
    if (!empty($calibrefx_sections[$slug])) {
        return;
    }

    $calibrefx_sections[$slug] = array(
        'slug' => $slug,
        'title' => $title,
        'basic' => array(),
        'professor' => array()
    );



    $func = create_function('', 'return '.$target.';');
    add_filter('calibrefx_'.$slug.'_form_url', $func);
}

function calibrefx_do_meta_sections($section, $screen, $context, $object) {
    global $calibrefx_sections, $calibrefx_user_ability;
    global $wp_meta_boxes;

    if (!isset($calibrefx_sections))
        return;

    if (!isset($calibrefx_user_ability))
        $calibrefx_user_ability = 'basic';

    if (empty($screen))
        $screen2 = get_current_screen();
    elseif (is_string($screen))
        $screen2 = convert_to_screen($screen);

    $page = $screen2->id;
    $sorted = get_user_option("meta-box-order_$page");
    
    if (empty($wp_meta_boxes[$page][$context]['sorted'])) {
        if (!empty($calibrefx_sections[$section]['basic'])) {
            foreach ($calibrefx_sections[$section]['basic'] as $metas) {
                add_meta_box($metas['id'], $metas['title'], $metas['callback'], $metas['screen'], $metas['context'], $metas['priority'], $metas['callback']);
            }
        }

        if (!empty($calibrefx_sections[$section]['professor']) && $calibrefx_user_ability === 'professor') {
            foreach ($calibrefx_sections[$section]['professor'] as $metas) {
                add_meta_box($metas['id'], $metas['title'], $metas['callback'], $metas['screen'], $metas['context'], $metas['priority'], $metas['callback']);
            }
        }
    }

    do_meta_boxes($screen, $context, $object);
}

/**
 * Add a meta box to an edit form.
 *
 * @since 1.0.2
 *
 * @use add_meta_box
 * @param string $section String for use in the 'id' attribute of tags.
 * @param string $ability current user ability. professor|general.
 * @param string $id String for use in the 'id' attribute of tags.
 * @param string $title Title of the meta box.
 * @param string $callback Function that fills the box with the desired content. The function should echo its output.
 * @param string|object $screen Optional. The screen on which to show the box (post, page, link). Defaults to current screen.
 * @param string $context Optional. The context within the page where the boxes should show ('normal', 'advanced').
 * @param string $priority Optional. The priority within the context where the boxes should show ('high', 'low').
 */
function calibrefx_add_meta_box($section, $ability, $id, $title, $callback, $screen = null, $context = 'advanced', $priority = 'default', $callback_args = null) {
    global $calibrefx_sections;

    if (!isset($calibrefx_sections))
        return;

    if (!isset($calibrefx_sections[$section]))
        return;

    $calibrefx_sections[$section][$ability][] = array(
        "id" => $id,
        "title" => $title,
        "callback" => $callback,
        "screen" => $screen,
        "context" => $context,
        "priority" => $priority,
        "callback_args" => $callback_args,
    );
}