<?php 
/**
 * Calibrefx HTML Helper
 */

/**
 * Output special xmlns on html tags
 */
function html_xmlns( $xml = '' ) {
    $xmls = array();
    $xmls = array_map( 'esc_attr', $xmls );

    $xmlns = apply_filters( 'html_xmlns', $xmls, $xml );

    echo join( ' ', $xmlns );
}

/**
 * Output if any body onload script defined
 */
function body_onload( $script = '' ) {
    $scripts = array();

    if ( !empty( $script ) ) {
        if ( !is_array( $script) ) {
            $script = preg_split( '#\s+#', $script);
        }

        $scripts = array_merge( $scripts, $script );
    } else {
        // Ensure that we always coerce class to being an array.
        $script = array();
    }

    $scripts = array_map( 'esc_attr', $scripts );

    $onload_scripts = apply_filters( 'body_onload_script', $scripts, $script );

    echo 'onload="' . join( ';', $onload_scripts ) . '"';
}

function body_attr( $attr = array() ) {    

    $attrs = array();
    $attrs = array_merge( apply_filters( 'body_attr', $attrs ), $attr );

    $attr_string = '';
    foreach($attrs as $attr_key => $attr_value){
        $attr_string .= ' '.$attr_key.'="'. $attr_value .'"';
    }

    echo $attr_string;
}