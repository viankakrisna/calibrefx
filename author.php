<?php
/**
 * Default template for author page
 */

function calibrefx_show_author_info(){
	if ( get_the_author_meta( 'calibrefx_author_box_archive', get_the_author_meta( 'ID' ) ) ) {
		get_template_part( 'author-bio' );
	}
}
add_action( 'calibrefx_after_loop', 'calibrefx_show_author_info', 20 );

calibrefx();
