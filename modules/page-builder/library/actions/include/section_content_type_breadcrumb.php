<?php
function section_ct_breadcrumb( $section, $section_key, $column, $column_key ){
    //$output = '<div class="" style="">';

    //TODO: Apakah breadcrumb ini perlu jadi element?

    //$output .= "</div>";

    // return $output;
    // 
    return "this is breadcrumb";
}
add_filter( 'section_content_type_breadcrumb', 'section_ct_breadcrumb', 10, 4 );