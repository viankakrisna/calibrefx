<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>
<?php if( !$is_template ) { ?>
<label class="indicator" for="<?php echo $name; ?>"><span style="background-color: <?php echo $value; ?>;"></span></label>
<input id="<?php echo $name; ?>" class="vp-input vp-js-colorpicker <?php echo $cssclass ?>"
	type="text" name="<?php echo $name ?>" value="<?php echo $value; ?>" data-vp-opt="<?php echo $opt; ?>" />
<?php }else{ 
preg_match_all("/\[([^\]]*)\]/", $name, $matches);
$target_field = $matches[1][count($matches[1])-1];
?>
<label class="indicator" for="%template%[<?php echo $target_field; ?>]"><span style="background-color: <?php echo $value; ?>;"></span></label>
<input id="%template%[<?php echo $target_field; ?>]" class="vp-input vp-js-colorpicker <?php echo $cssclass ?>"
	type="text" name="%template%[<?php echo $target_field; ?>]" value="<?php echo $value; ?>" data-vp-opt="<?php echo $opt; ?>" />
<?php } ?>
<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot', $head_info); ?>