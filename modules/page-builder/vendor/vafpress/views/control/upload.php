<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>
<?php if( !$is_template ) { ?>
<input class="vp-input" type="text" readonly id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
<?php }else{ 
preg_match_all("/\[([^\]]*)\]/", $name, $matches);
$target_field = $matches[1][count($matches[1])-1];
?>
<input class="vp-input <?php echo $cssclass ?>" type="text" readonly id="%template%[<?php echo $target_field; ?>]" name="%template%[<?php echo $target_field; ?>]" value="<?php echo $value; ?>" />
<?php } ?>
<div class="buttons">
	<input class="vp-js-upload vp-button button" type="button" value="<?php _e('Choose File', 'vp_textdomain'); ?>" />
	<input class="vp-js-remove-upload vp-button button" type="button" value="x" />
</div>
<div class="image">
	<img src="<?php echo $preview; ?>" alt="" />
</div>

<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot'); ?>