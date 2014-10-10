<?php 
/**
 * Calibrefx User Helper
 * 
 */
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