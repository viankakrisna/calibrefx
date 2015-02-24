<?php
/**
 * Default content template part
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php do_action( 'calibrefx_before_post_title' ); ?>
    <?php do_action( 'calibrefx_post_title' ); ?>
    <?php do_action( 'calibrefx_after_post_title' ); ?>

    <?php do_action( 'calibrefx_before_post_content' ); ?>
    <div class="entry-content">
        <?php do_action( 'calibrefx_post_content' ); ?>
    </div><!-- end .entry-content -->
    <?php do_action( 'calibrefx_after_post_content' ); ?>

</div><!-- end .postclass -->