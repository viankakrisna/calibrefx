<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>
<?php if( !$is_template ) { ?>
<input type="text" name="<?php echo $name ?>" class="vp-input input-large <?php echo $cssclass ?>" value="<?php echo esc_attr($value); ?>" />
<?php }else{ 
preg_match_all("/\[([^\]]*)\]/", $name, $matches);
$target_field = $matches[1][count($matches[1])-1];
?>
<input type="text" name="%template%[<?php echo $target_field; ?>]" class="vp-input input-large <?php echo $cssclass ?>" value="<?php echo esc_attr($value); ?>" />
<?php } ?>
<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot', $head_info); ?>