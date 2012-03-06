<?php
/**
 * WARNING: This file is part of the core Calibrefx framework. DO NOT edit
 * this file under any circumstances. Please do all modifications
 * in the form of a child theme.
 *
 * Handles primary sidebar structure.
 *
 * @package Calibrefx
 */
?><div id="sidebar" class="<?php echo calibrefx_sidebar_span(); ?> sidebar widget-area">
<?php
	do_action( 'calibrefx_before_sidebar_widget_area' );
	do_action( 'calibrefx_sidebar' );
	do_action( 'calibrefx_after_sidebar_widget_area' );
?>
</div>