<?php extract($head_info); ?>

<div class="vp-field <?php echo $type; ?><?php echo !empty($container_extra_classes) ? (' ' . $container_extra_classes) : ''; ?>"
	data-vp-type="<?php echo $type; ?>"
	<?php echo VP_Util_Text::print_if_exists(isset($binding) ? $binding : '', 'data-vp-bind="%s"'); ?>
	<?php echo VP_Util_Text::print_if_exists(isset($dependency) ? $dependency : '', 'data-vp-dependency="%s"'); ?>
	id="<?php echo $name; ?>">
	<div class="field" style="height: <?php echo $height; ?>;">
		<div class="input" id="<?php echo $name . '_dom'; ?>">
			<?php echo VP_WP_Util::kses_html($value); ?>
		</div>
		<?php if( !$is_template ) { ?>
		<textarea name="<?php echo $name; ?>" class="vp-hide <?php echo $cssclass ?>"><?php echo VP_WP_Util::kses_html($value); ?></textarea>
		<?php }else{ 
		preg_match_all("/\[([^\]]*)\]/", $name, $matches);
		$target_field = $matches[1][count($matches[1])-1];
		?>
		<textarea name="%template%[<?php echo $target_field; ?>]" class="vp-hide <?php echo $cssclass ?>"><?php echo VP_WP_Util::kses_html($value); ?></textarea>
		<?php } ?>
		<?php VP_Util_Text::print_if_exists($description, '<div class="description">%s</div>'); ?>
		<div class="vp-js-bind-loader vp-field-loader vp-hide"><img src="<?php VP_Util_Res::img_out('ajax-loader.gif', ''); ?>" /></div>
	</div>
</div>