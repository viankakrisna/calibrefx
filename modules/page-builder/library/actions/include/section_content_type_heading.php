<?php
function section_content_type_heading(){
    return 'this is heading';
}
add_filter('section_content_type_heading', 'section_content_type_heading');