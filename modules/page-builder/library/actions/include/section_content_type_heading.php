<?php
function section_ct_heading( $element, $element_key, $column_key, $section_key ){
    
    $data = $element[0];
    if( !is_array( $data ) ) return;

    $element_class = array('element', 'element-heading');

    $align = isset( $data['heading_alignment'] )? $data['heading_alignment'] : 'left';
    
    $element_class[] = 'text-align-'.$align;
    
    if( $data['heading_icon'] ) $element_class[] = 'has-icon';

    $output = '<div id="element-' . $section_key . '-' . $column_key . '-' . $element_key . '" class="' . implode(" ", $element_class) . '">';
    
    if( $data['heading_icon'] ){
        $output .= '<div class="heading-icon">';
    	$output .= '<img class="img-responsive" src="' . $data['heading_icon'] . '" />';
        $output .= '</div>';
    }

    if( $data['header_text'] || $data['sub_header_text']){
        $output .= '<div class="heading-text">';
        if( $data['header_text']){
    	    $output .= '<h1>' . $data['header_text'] . '</h1>';
        }
        if( $data['sub_header_text'] ){
        	$output .= '<p>' . $data['sub_header_text'] . '</p>';
        }
        $output .= "</div>";
    }

    
    
    $output .= "</div>";
    return $output;
}
add_filter( 'section_content_type_heading', 'section_ct_heading', 10, 4 );