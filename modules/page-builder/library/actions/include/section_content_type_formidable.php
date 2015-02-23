<?php
function section_ct_formidable( $element, $element_key, $column_key, $section_key ){
    $output = '<div id="element-'.$section_key.'-'.$column_key.'-'.$element_key.'" class="element element-formidable '.$element[0]['css_class'].'">';
    $output .= do_shortcode('[formidable id='.$element[0]['form_id'].']');
    $output .= "</div>";
    return $output;
}
add_filter( 'section_content_type_formidable', 'section_ct_formidable', 10, 4 );