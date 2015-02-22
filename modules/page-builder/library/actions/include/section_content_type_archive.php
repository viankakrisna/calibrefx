<?php
function section_ct_archive( $element, $element_key, $column_key, $section_key ){
    
    $data = $element[0];
    if( !is_array( $data ) ) return;
    
    $posts_per_page = isset( $data['posts_per_page'] )? $data['posts_per_page'] : get_option( 'posts_per_page' );
    $post_type = isset( $data['post_type'] )? $data['post_type'] : 'post';
    $nopaging = ($data['show_pagination'] == 1)? false : true;
    $layout = $data['layout']? $data['layout'] : 'list';
    $read_more = $data['read_more']? $data['read_more'] : '[Read more...]';
    $excerpt_length = $data['excerpt_length']? $data['excerpt_length'] : 0;

    $output = '<div id="element-' . $section_key . '-' . $column_key . '-' . $element_key . '" class="element element-archive layout-' . $layout . '">';
    
    $args = array(
        'post_type'   => $post_type,
        'post_status' => 'publish',
        
        //Pagination Parameters
        'posts_per_page'         => $posts_per_page,
        'nopaging'               => $nopaging,
        'paged'                  => get_query_var('paged'),
    );
    
    $query = new WP_Query( $args );
    ob_start();
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) : $query->the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php do_action( 'calibrefx_post_title' ); ?>

                <?php do_action( 'calibrefx_before_post_content' ); ?>
                <div class="entry-content">
                    <?php 
                        $img = calibrefx_get_image( array( 'format' => 'html', 'size' => $default_post_archive_image_size, 'attr' => array( 'class' => 'post-image img-responsive' ) ) );
        
                        if( $img ) {
                            printf( '<a href="%s" title="%s" class="post-image-link">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), apply_filters( 'post_archive_image', $img, $img ) );
                        }

                        if( $excerpt_length > 0 ){
                            the_content_limit( (int) $excerpt_length, $read_more );
                        }else{
                            the_content( $read_more );
                        }
                    ?>
                </div><!-- end .entry-content -->
            </div><!-- end .postclass -->
        <?php
        endwhile;

        if( !$nopaging ){
            calibrefx_numeric_posts_nav( $posts_per_page );
        }
    
    } else {
        /** if no posts exist * */
        do_action( 'calibrefx_no_post' );
    }

    $output .= ob_get_contents(); //get the result from buffer
    ob_end_clean(); //close buffer
    
    $output .= "</div>";
    return $output;
}
add_filter( 'section_content_type_archive', 'section_ct_archive', 10, 4 );