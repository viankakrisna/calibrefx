<?php
function section_ct_menu( $element, $element_key, $column_key, $section_key ){
    
    $data = $element[0];
    if( !is_array( $data ) ) return;

    $output = '<div id="element-' . $section_key . '-' . $column_key . '-' . $element_key . '" class="element element-menu">';
    
    
    
    $output .= "</div>";
    return $output;
}
add_filter( 'section_content_type_menu', 'section_ct_menu', 10, 4 );