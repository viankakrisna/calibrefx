<?php
function section_ct_archive( $element, $element_key, $column_key, $section_key ){
    
    $data = $element[0];
    if( !is_array( $data ) ) return;
    die_dump($data);
    $output = '<div id="element-' . $section_key . '-' . $column_key . '-' . $element_key . '" class="element element-archive">';
    
    
    
    $output .= "</div>";
    return $output;
}
add_filter( 'section_content_type_archive', 'section_ct_archive', 10, 4 );