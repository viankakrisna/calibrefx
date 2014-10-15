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

/**
 * Display author box and its contents.
 */
function calibrefx_author_box( $context = '' ) {

    global $authordata;

    $authordata = is_object( $authordata) ? $authordata : get_userdata( get_query_var( 'author' ) );
    $gravatar_size = apply_filters( 'calibrefx_author_box_gravatar_size', 70, $context );
    $gravatar = get_avatar( get_the_author_meta( 'email' ), $gravatar_size );
    $title = apply_filters( 'calibrefx_author_box_title', sprintf( '<strong>%s %s</strong>', __( 'About', 'calibrefx' ), get_the_author() ), $context );
    $description = wpautop( get_the_author_meta( 'description' ) );

    /** The author box markup, contextual */
    $pattern = $context == 'single' ? '<div class="author-box well"><div>%s %s<br />%s</div></div><!-- end .authorbox-->' : '<div class="author-box well">%s<h1>%s</h1><div>%s</div></div><!-- end .authorbox-->';

    echo apply_filters( 'calibrefx_author_box', sprintf( $pattern, $gravatar, $title, $description ), $context, $pattern, $gravatar, $title, $description );
}

/**
 *  Output a body class for Calibrefx Admin Area
 */
function calibrefx_admin_body_class( $classes ) {
  $screen = get_current_screen();
  if (strpos( $screen->id,'calibrefx' ) !== false ) {
    $classes .= ' calibrefx-admin-page';
  }

  return $classes;
}