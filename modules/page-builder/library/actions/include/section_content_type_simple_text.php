<?php
function section_ct_simple_text( $element, $element_key, $column_key, $section_key ){
    
    $data = $element[0];
    if( !is_array( $data ) ) return;

    $color = isset( $data['text_color'] )? $data['text_color'] : 'inherit';
    $font_size = isset( $data['font_size'] )? $data['font_size'] : 'inherit';
    $font_weight = isset( $data['font_weight'] )? $data['font_weight'] : 'normal';
    $bg_color = isset( $data['background_color'] )? $data['background_color'] : 'transparent';
    
    $output = '<div id="element-' . $section_key . '-' . $column_key . '-' . $element_key . '" class="element element-simple_text">';
    
    $output .= '<p><span style="color: ' . $color . '; font-size: ' . $font_size . 'px; font-weight: ' . $font_weight . '; background-color: ' . $bg_color . '">' 
                . $data['text'] . '</span></p>';

    if( $data['sub_header_text'] ){
    	$output .= '<p class="element-subheader-text">' . $data['sub_header_text'] . '</p>';
    }
    
    $output .= "</div>";
    return $output;
}
add_filter( 'section_content_type_simple_text', 'section_ct_simple_text', 10, 4 );