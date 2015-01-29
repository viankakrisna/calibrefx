<?php

global $calibrefx;

require_once dirname( __FILE__ ) . "/vendor/vafpress/bootstrap.php";

require_once dirname( __FILE__ ) . '/template/data_sources.php';


function get_revolution_sliders() {    
    $result = array();
    if(!class_exists('RevSlider')){
        return $result;
    }
    $sliders = new RevSlider();
    foreach ($sliders->getAllSliderAliases() as $slider) {
        $result[] = array('value' => $slider, 'label' => $slider);
    }
    return $result;
}

function dep_section_is_breadcrumb($value){
    if($value === 'breadcrumb') return true;
    return false;
}
VP_Security::instance()->whitelist_function('dep_section_is_breadcrumb');

function dep_section_is_slider($value){
    if($value === 'slider') return true;
    return false;
}
VP_Security::instance()->whitelist_function('dep_section_is_slider');

function dep_section_is_editor($value){
    if($value === 'editor') return true;
    return false;
}
VP_Security::instance()->whitelist_function('dep_section_is_editor');

function dep_section_is_heading($value){
    if($value === 'heading') return true;
    return false;
}
VP_Security::instance()->whitelist_function('dep_section_is_heading');

function dep_section_is_carousel($value){
    if($value === 'carousel') return true;
    return false;
}
VP_Security::instance()->whitelist_function('dep_section_is_carousel');

function dep_section_is_raw_html($value){
    if($value === 'raw_html') return true;
    return false;
}
VP_Security::instance()->whitelist_function('dep_section_is_raw_html');

new VP_Metabox(dirname( __FILE__ ) . '/template/metabox/page-builder.php');
