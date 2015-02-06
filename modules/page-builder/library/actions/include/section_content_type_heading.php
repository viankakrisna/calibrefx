<?php
function section_ct_heading( $element ){
    
    return $element[0]['header_text'];
}
add_filter( 'section_content_type_heading', 'section_ct_heading', 10 );