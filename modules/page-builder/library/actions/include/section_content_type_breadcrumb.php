<?php
function section_content_type_breadcrumb(){
    return 'this is breadcrumb';
}
add_filter( 'section_content_type_breadcrumb', 
			'section_content_type_breadcrumb' );