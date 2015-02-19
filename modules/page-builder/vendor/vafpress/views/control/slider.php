<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>
<?php if( !$is_template ) { ?>
<input type="text" name="<?php echo $name; ?>" class="vp-input slideinput vp-js-tipsy <?php echo $cssclass ?>" original-title="Range between <?php echo $opt_raw['min']; ?> and <?php echo $opt_raw['max']; ?>" value="<?php echo $value; ?>" />
<div class="vp-js-slider slidebar" id="<?php echo $name; ?>" data-vp-opt="<?php echo $opt; ?>"></div>
<?php }else{ 
preg_match_all("/\[([^\]]*)\]/", $name, $matches);
$target_field = $matches[1][count($matches[1])-1];
?>
<input type="text" name="%template%[<?php echo $target_field; ?>]" class="vp-input slideinput vp-js-tipsy <?php echo $cssclass ?>" original-title="Range between <?php echo $opt_raw['min']; ?> and <?php echo $opt_raw['max']; ?>" value="<?php echo $value; ?>" />
<div class="vp-js-slider slidebar" id="%template%[<?php echo $target_field; ?>]" data-vp-opt="<?php echo $opt; ?>"></div>
<?php } ?>
<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot'); ?>