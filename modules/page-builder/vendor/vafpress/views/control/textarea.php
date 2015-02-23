<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>
<?php if( !$is_template ) { ?>
<textarea class="vp-input <?php echo $cssclass ?>" name="<?php echo $name; ?>"><?php echo esc_attr($value); ?></textarea>
<?php }else{ 
preg_match_all("/\[([^\]]*)\]/", $name, $matches);
$target_field = $matches[1][count($matches[1])-1];
?>
<textarea class="vp-input <?php echo $cssclass ?>" name="%template%[<?php echo $target_field; ?>]"><?php echo esc_attr($value); ?></textarea>
<?php } ?>
<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot', $head_info); ?>