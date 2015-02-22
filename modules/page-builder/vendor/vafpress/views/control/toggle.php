<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>
<?php if( !$is_template ) { ?>
<label>
	<input <?php if( $value ) echo 'checked'; ?> class="vp-input<?php if( $value ) echo ' checked'; ?> <?php echo $cssclass ?>" type="checkbox" name="<?php echo $name; ?>" value="1" />
	<span></span>
</label>
<?php }else{ 
preg_match_all("/\[([^\]]*)\]/", $name, $matches);
$target_field = $matches[1][count($matches[1])-1];
?>
<label>
	<input class="vp-input <?php echo $cssclass ?>" type="checkbox" name="%template%[<?php echo $target_field; ?>]" value="1" />
	<span></span>
</label>
<?php } ?>
<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot', $head_info); ?>