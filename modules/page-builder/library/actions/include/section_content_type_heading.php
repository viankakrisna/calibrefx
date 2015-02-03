<?php
function section_ct_heading( $section, $section_key, $column, $column_key ){
    return 'this is heading';
}
add_filter('section_content_type_heading', 'section_ct_heading', 10, 4);