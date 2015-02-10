<?php
function section_ct_raw_html( $element, $element_key, $column_key, $section_key ){
    $output = '<div id="element-'.$section_key.'-'.$column_key.'-'.$element_key.'" class="element element-raw-html element-raw-html-'.$section_key.'-'.$column_key.'-'.$element_key.'">';
    $output .= $element[0]['raw_html_code'];
    $output .= "</div>";
    return $output;
}
add_filter( 'section_content_type_raw_html', 'section_ct_raw_html', 10, 4 );