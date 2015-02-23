<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>

<?php foreach ($items as $item): ?>
<label>
	<?php if( !$is_template ) { ?>
	<?php $checked = ($item->value == $value); ?>
	<input <?php if($checked) echo 'checked'; ?> class="vp-input<?php if($checked) echo " checked"; ?> <?php echo $cssclass ?>" type="radio" name="<?php echo $name; ?>" value="<?php echo $item->value; ?>" />
	<span></span><?php echo $item->label; ?>
	<?php }else{ 
	preg_match_all("/\[([^\]]*)\]/", $name, $matches);
	$target_field = $matches[1][count($matches[1])-1];
	?>
	<input class="vp-input<?php if($checked) echo " checked"; ?> <?php echo $cssclass ?>" type="radio" name="%template%[<?php echo $target_field; ?>]" value="<?php echo $item->value; ?>" />
	<?php } ?>
</label>
<?php endforeach; ?>

<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot', $head_info); ?>