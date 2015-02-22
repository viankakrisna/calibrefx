<?php
function section_ct_autoresponder( $element, $element_key, $column_key, $section_key ){
    
    $data = $element[0];
    if( !is_array( $data ) ) return;

    $result = calibrefx_parse_autoresponder_form( $data['form_code'] );
    
    $output = '<div id="element-' . $section_key . '-' . $column_key . '-' . $element_key . '" class="element element-heading">';
    
    $output .= '<form method="post" class="' . $data['css_class'] . '" action="' . $result['url'] . '">';

    $output .= '<div style="display: none;">';   

    foreach ($result as $key => $value) {
        if( $key == 'url' OR $key == 'name' OR $key == 'email' ) continue;

        $output .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
     } 

    $output .= "</div>";

    //show name and email field
    $output .= '<input class="text" type="text" name="name" value=""  />';
    $output .= '<input class="text" type="text" name="email" value=""  />';
    $output .= '<input class="submit" type="text" name="submit" value="Submit"  />';

    $output .= '</form>';

    $output .= "</div>";
    return $output;
}
add_filter( 'section_content_type_autoresponder', 'section_ct_autoresponder', 10, 4 );