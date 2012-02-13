<?php
/**
 * WARNING: This file is part of the core Genesis framework. DO NOT edit
 * this file under any circumstances. Please do all modifications
 * in the form of a child theme.
 *
 * Handles the secondary sidebar structure.
 *
 * @package Genesis
 */
?><div id="sidebar-alt" class="<?php echo calibrefx_sidebar_span(); ?> pull-left sidebar widget-area">
<?php
	do_action( 'calibrefx_before_sidebar_alt_widget_area' );
	do_action( 'calibrefx_sidebar_alt' );
	do_action( 'calibrefx_after_sidebar_alt_widget_area' );
?>
</div>