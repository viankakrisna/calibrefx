<?php
function section_ct_slider_revolution( $element, $element_key, $column_key, $section_key ){
    $output = '<div id="element-'.$section_key.'-'.$column_key.'-'.$element_key.'" class="element element-slider-revolution">';
    $output .= do_shortcode('[rev_slider '.$element[0]['slider_revolution_item'].']');
    $output .= "</div>";
    return $output;
}
add_filter( 'section_content_type_slider_revolution', 'section_ct_slider_revolution', 10, 4 );