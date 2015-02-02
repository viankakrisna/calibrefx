<?php

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