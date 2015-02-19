<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>

<?php foreach ($items as $item): ?>
<label>
	<?php if( !$is_template ) { ?>
	<?php $checked = ($item->value == $value); ?>
	<input type="radio" <?php if($checked) echo 'checked'; ?> class="vp-input<?php if($checked) echo " checked"; ?>" name="<?php echo $name; ?>" value="<?php echo $item->value; ?>" />
	<img src="<?php echo VP_Util_Res::img($item->img); ?>" alt="<?php echo $item->label; ?>" class="vp-js-tipsy image-item" style="<?php VP_Util_Text::print_if_exists($item_max_width, 'max-width: %spx; '); ?><?php VP_Util_Text::print_if_exists($item_max_height, 'max-height: %spx; '); ?>" original-title="<?php echo $item->label; ?>" />
	<?php }else{ 
	preg_match_all("/\[([^\]]*)\]/", $name, $matches);
	$target_field = $matches[1][count($matches[1])-1];
	?>
	<input type="radio" class="vp-input <?php echo $cssclass ?>" name="%template%[<?php echo $target_field; ?>]" value="<?php echo $item->value; ?>" />
	<img src="<?php echo VP_Util_Res::img($item->img); ?>" alt="<?php echo $item->label; ?>" class="vp-js-tipsy image-item" style="<?php VP_Util_Text::print_if_exists($item_max_width, 'max-width: %spx; '); ?><?php VP_Util_Text::print_if_exists($item_max_height, 'max-height: %spx; '); ?>" original-title="<?php echo $item->label; ?>" />
	<?php } ?>
</label>
<?php endforeach; ?>

<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot'); ?>