<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>
<?php if( !$is_template ) { ?>
<textarea class="vp-input <?php echo $cssclass ?>" name="<?php echo $name; ?>" style="display: none;"><?php echo $value; ?></textarea>
<?php }else{ 
preg_match_all("/\[([^\]]*)\]/", $name, $matches);
$target_field = $matches[1][count($matches[1])-1];
?>
<textarea class="vp-input <?php echo $cssclass ?>" name="%template%[<?php echo $target_field; ?>]" style="display: none;"><?php echo $value; ?></textarea>
<?php } ?>
<div class="vp-js-codeeditor" data-vp-opt="<?php echo $opt; ?>"></div>

<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot'); ?>