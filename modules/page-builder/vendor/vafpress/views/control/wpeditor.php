<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>

<?php
	// prepare value for tinyMCE editor
	$value     = html_entity_decode($value, ENT_COMPAT, 'UTF-8');
	if( has_filter('the_editor_content') )
		$value = apply_filters('the_editor_content', $value);
	else
		$value = wp_richedit_pre($value);
?>
<div class="customEditor">
	<div class="wp-editor-tools">
		<div class="custom_upload_buttons hide-if-no-js wp-media-buttons"><?php do_action( 'media_buttons' ); ?></div>
	</div>
	<?php if( !$is_template ) { ?>
	<textarea class="vp-input vp-js-wpeditor <?php echo $cssclass ?>" id="<?php echo $name . '_ce'; ?>" data-vp-opt="<?php echo $opt; ?>" rows="10" cols="50" name="<?php echo $name; ?>" rows="3"><?php echo $value; ?></textarea>
	<?php }else{ 
		preg_match_all("/\[([^\]]*)\]/", $name, $matches);
		$target_field = $matches[1][count($matches[1])-1];
	?>
	<textarea class="vp-input vp-js-wpeditor <?php echo $cssclass ?>" id="%template%[<?php echo $target_field; ?>]_ce" data-vp-opt="<?php echo $opt; ?>" rows="10" cols="50" name="%template%[<?php echo $target_field; ?>]" rows="3"><?php echo $value; ?></textarea>
	<?php } ?>
</div>

<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot', $head_info); ?>