<?php
function section_ct_heading( $element, $element_key, $column_key, $section_key ){
    
    $data = $element[0];
    if( !is_array( $data ) ) return;

    $align = isset( $data['heading_alignment'] )? $data['heading_alignment'] : 'left';

    $element_class = '';

    if( $data['heading_icon'] ) $element_class .= ' has-icon';

    $output = '<div id="element-' . $section_key . '-' . $column_key . '-' . $element_key . '" class="element element-heading element-heading-' . $section_key . '-'.$column_key . '-'.$element_key . $element_class . '" style="text-align: ' . $align . '">';
    
    if( $data['heading_icon'] ){
    	$output .= '<img class="element-img-icon" src="' . $data['heading_icon'] . '" />';
    }

    if( $data['header_text'] ){
    	$output .= '<h1 class="element-header-text">' . $data['header_text'] . '</h1>';
    }

    if( $data['sub_header_text'] ){
    	$output .= '<p class="element-subheader-text">' . $data['sub_header_text'] . '</p>';
    }
    
    $output .= "</div>";
    return $output;
}
add_filter( 'section_content_type_heading', 'section_ct_heading', 10, 4 );