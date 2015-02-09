<?php
function section_ct_html_editor( $element, $element_key, $column_key, $section_key ){
    $output = '<div id="element-'.$section_key.'-'.$column_key.'-'.$element_key.'" class="element element-html-editor element-html-editor-'.$section_key.'-'.$column_key.'-'.$element_key.'">';
    $output .= apply_filters('the_content', $element[0]['html_content']);
    $output .= "</div>";
    return $output;
}
add_filter( 'section_content_type_html_editor', 'section_ct_html_editor', 10, 4 );