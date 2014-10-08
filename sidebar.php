<?php
/**
 * Sidebar template part
 */
?>

<div id="sidebar" class="<?php echo calibrefx_sidebar_span(); ?> sidebar widget-area">
<?php
	do_action( 'calibrefx_before_sidebar_widget_area' );
	do_action( 'calibrefx_sidebar' );
	do_action( 'calibrefx_after_sidebar_widget_area' );
?>
</div>