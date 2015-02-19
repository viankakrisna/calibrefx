<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>
<?php if( !$is_template ) { ?>
<select multiple name="<?php echo $name; ?>" class="vp-input vp-js-sorter <?php echo $cssclass ?>" data-vp-opt="<?php echo $opt; ?>">
<?php }else{ 
preg_match_all("/\[([^\]]*)\]/", $name, $matches);
$target_field = $matches[1][count($matches[1])-1];
?>
<select multiple name="%template%[<?php echo $target_field; ?>]" class="vp-input vp-js-sorter <?php echo $cssclass ?>" data-vp-opt="<?php echo $opt; ?>">
<?php } ?>
	<?php
	$labels = array();
	foreach ($items as $item) $labels[$item->value] = $item->label;
	?>

	<?php foreach ($value as $v): ?>
	<option selected value="<?php echo $v; ?>"><?php echo $labels[$v]; ?></option>
	<?php unset($labels[$v]); endforeach; ?>

	<?php foreach ($labels as $i => $label): ?>
	<option value="<?php echo $i; ?>"><?php echo $label; ?></option>
	<?php endforeach; ?>
</select>

<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot'); ?>