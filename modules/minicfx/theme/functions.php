<?php

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 584; }

add_action( 'after_setup_theme', 'minicfx_setup' );
function minicfx_setup(){

}



function calibrefx_mobile(){
	get_header();

	do_action( 'calibrefx_inner' );
	do_action( 'calibrefx_before_content_wrapper' );

	$content_wrapper_class = calibrefx_row_class() . ' ' . apply_filters( 'content_wrapper_class', '' );
	?>
    <div id="content-wrapper" class="<?php echo esc_attr( $content_wrapper_class ); ?>" >
        <?php do_action( 'calibrefx_before_content' ); ?>
        <div id="content" class="<?php echo esc_attr( calibrefx_content_span() ); ?>">
            <?php
			do_action( 'calibrefx_before_loop' );
			do_action( 'calibrefx_loop' );
			do_action( 'calibrefx_after_loop' );
			?>
        </div><!-- end #content -->
        <?php do_action( 'calibrefx_after_content' ); ?>
    </div><!-- end #content-wrapper -->
    <?php
	do_action( 'calibrefx_after_content_wrapper' );
	do_action( 'calibrefx_after_inner' );

	get_footer();
}