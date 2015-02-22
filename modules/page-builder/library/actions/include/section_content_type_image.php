<?php
function section_ct_image( $element, $element_key, $column_key, $section_key ){
    
    $data = $element[0];
    if( !is_array( $data ) ) return;
    
    $align = isset( $data['image_alignment'] )? $data['image_alignment'] : 'left';
    $alt_tag = isset( $data['alt_text'] )? $data['alt_text'] : '';

    $element_class = $data['css_class'] . ' ' ;

    if( $data['image_animation'] ) {
        $element_class .= 'img-with-animation';
        $data_delay =  isset( $data['delay'] )? $data['delay'] : '200';
        $data_delay =  "data-delay='" . $data_delay . "'";
        $data_animation=  isset( $data['image_animation'] )? $data['image_animation'] : '';
        $data_animation =  "data-animation='" . $data_animation . "'";
    }

    $output = '<div id="element-' . $section_key . '-' . $column_key . '-' . $element_key . '" class="element element-image" style="text-align: ' . $align . '">';
    
    if( !empty( $data['link'] ) ){
        $target = isset( $data['link_target'] )? 'target=_blank' : '';
        $output .= '<a href="' . $data['link'] . '" ' . $target . ' >';
    }

    $output .= '<img class="' . $element_class . '" ' . $data_delay . ' ' . strtolower( $data_animation ) . ' src="' . $data['image_url'] . '" alt="' . $alt_tag . '"/>';
    
    if( !empty( $data['link'] ) ){
        $output .= '</a>';
    }

    $output .= "</div>";
    return $output;
}
add_filter( 'section_content_type_image', 'section_ct_image', 10, 4 );