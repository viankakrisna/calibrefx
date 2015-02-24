<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>
<?php if( !$is_template ) { ?>
<input id="<?php echo $name; ?>" name="<?php echo $name; ?>" 
	type="text" class="vp-input wp-colorpicker <?php echo $cssclass ?>" 
	value="<?php echo $value; ?>" />
<?php }else{ 
preg_match_all("/\[([^\]]*)\]/", $name, $matches);
$target_field = $matches[1][count($matches[1])-1];
?>
<input id="%template%[<?php echo $target_field; ?>]" name="%template%[<?php echo $target_field; ?>]" 
	type="text" class="vp-input wp-colorpicker <?php echo $cssclass ?>" 
	value="<?php echo $value; ?>" />
<?php } ?>
<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot', $head_info); ?>