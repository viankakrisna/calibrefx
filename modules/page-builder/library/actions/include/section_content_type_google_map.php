<?php
function section_ct_google_map( $element, $element_key, $column_key, $section_key ){
    $output = '<div id="element-'.$section_key.'-'.$column_key.'-'.$element_key.'" class="element element-google-map">';
    extract( 
        wp_parse_args( 
            $element[0],
            array(
                'latitude' => '',
                'longitude' => '',
                'zoom' => '16',
                'height' => '320',
                'title' => '',
                'address' => '',
                'image' => '',
            )
        )
    );
        
    if( $latitude AND $longitude ){
        $map_canvas_id = 'map_canvas_'.$section_key.'_'.$column_key.'_'.$element_key.'_' . sanitize_title( $latitude ) . '_' . sanitize_title( $longitude );
        $output .= '<div id="' . $map_canvas_id . '" style="width: 100%; height: ' . $height . 'px;"></div>'."\n\r";
        $output .= '<script type="text/javascript">' . "\n\r";
        $output .= '(function($){'."\n\r";
        $output .= '$( document ).ready(function() {' . "\n\r";
        
        $output .= 'var map_lat = ' . $latitude . ';' . "\n\r";
        $output .= 'var map_long = ' . $longitude . ';' . "\n\r";
        $output .= 'var map_style = [{"featureType": "all","stylers": [{"saturation": -100},{"gamma": 0.5}]}];' . "\n\r";
        $output .= 'var map_zoom = ' . $zoom . ';' . "\n\r";
        
        $output .= '$("#' . $map_canvas_id . '").googleMap({' . "\n\r";
        $output .= 'coords: [map_lat, map_long],' . "\n\r";
        $output .= 'styles: map_style,' . "\n\r";
        $output .= 'zoom: map_zoom' . "\n\r";
        $output .= '});' . "\n\r";
        
        $output .= '$("#' . $map_canvas_id . '").addMarker({' . "\n\r";
        $output .= 'coords: [map_lat, map_long],' . "\n\r";
        $output .= 'icon: "' . $image . '",' . "\n\r";
        $output .= 'title: "' . addslashes( $title ) . '",' . "\n\r";
        $output .= 'text: "' . addslashes( $address ) . '"' . "\n\r";
        $output .= '});' . "\n\r";
        
        $output .= '});' . "\n\r";
        $output .= '})(jQuery);' . "\n\r";
        $output .= '</script>' . "\n\r";
    }
    $output .= "</div>";
    return $output;
}
add_filter( 'section_content_type_google_map', 'section_ct_google_map', 10, 4 );