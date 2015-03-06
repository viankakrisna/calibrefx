<?php
/**
 * Sidebar alt template part
 */
?>

<div id="sidebar-alt" class="<?php echo sanitize_text_field( calibrefx_sidebar_alt_span() ); ?> sidebar widget-area">
<?php
	do_action( 'calibrefx_before_sidebar_alt_widget_area' );
	do_action( 'calibrefx_sidebar_alt' );
	do_action( 'calibrefx_after_sidebar_alt_widget_area' );
?>
</div>