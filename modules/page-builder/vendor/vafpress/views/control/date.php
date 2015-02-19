<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>
<?php if( !$is_template ) { ?>
<input <?php echo "data-vp-opt='" . $opt . "'"; ?> type="text" name="<?php echo $name ?>" class="vp-input vp-js-datepicker <?php echo $cssclass ?>" />
<?php }else{ 
preg_match_all("/\[([^\]]*)\]/", $name, $matches);
$target_field = $matches[1][count($matches[1])-1];
?>
<input <?php echo "data-vp-opt='" . $opt . "'"; ?> type="text" name="%template%[<?php echo $target_field; ?>]" class="vp-input vp-js-datepicker <?php echo $cssclass ?>" />
<?php } ?>
<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot'); ?>