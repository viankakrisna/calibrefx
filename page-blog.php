<?php
	/* Template Name: Page Blog Template */
	get_header();
	
    do_action('calibrefx_before_content_wrapper');
    ?>
    <div id="content-wrapper" class="row" >
        <?php do_action('calibrefx_before_content'); ?>
        <div id="content" class="<?php echo calibrefx_content_span(); ?>">
            <?php
            do_action('calibrefx_before_loop');
            do_action('calibrefx_blog_loop');
            do_action('calibrefx_after_loop');
            ?>
        </div><!-- end #content -->
        <?php do_action('calibrefx_after_content'); ?>
    </div><!-- end #content-wrapper -->
    <?php
    do_action('calibrefx_after_content_wrapper');

    get_footer();
?>