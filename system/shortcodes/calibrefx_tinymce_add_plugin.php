<?php
/**
 * CalibreFx Framework
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package     CalibreFx
 * @author      CalibreFx Team
 * @authorlink  http://www.calibrefx.com
 * @copyright   Copyright (c) 2012-2013, CalibreWorks. (http://www.calibreworks.com/)
 * @license     GNU GPL v2
 * @link        http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This define the framework constants
 *
 * @package CalibreFx
 */

/**
 * Calibrefx TinyMCE Plugin Button Helper
 *
 * @package		CalibreFx
 * @subpackage  Helper
 * @author		Hilaladdiyar
 * @since		Version 2.0
 * @link		http://www.calibrefx.com
 */

include('../../../../../wp-load.php');

$plugin_name = sanitize_text_field( $_REQUEST['plugin_name'] );
$form_url = sanitize_text_field( $_REQUEST['form_url'] );
$width = sanitize_text_field( $_REQUEST['width'] );
$height = sanitize_text_field( $_REQUEST['height'] );
$title = sanitize_text_field( $_REQUEST['title'] );
$img_url = sanitize_text_field( $_REQUEST['img_url'] );

header("Content-type: text/javascript");
?>
(function() {
tinymce.create('tinymce.plugins.<?php echo $plugin_name; ?>', {
	init : function(ed, url) {		
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('<?php echo $plugin_name; ?>', function() {		
			ed.windowManager.open({			
				file : '<?php echo $form_url; ?>',
				width : <?php echo $width; ?> + ed.getLang('<?php echo $plugin_name; ?>.delta_width', 0),
				height : <?php echo $height; ?> + ed.getLang('<?php echo $plugin_name; ?>.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_buttons button
		ed.addButton('<?php echo $plugin_name; ?>', {
			title : '<?php echo $title; ?>',
			cmd : '<?php echo $plugin_name; ?>',
			image : '<?php echo $img_url; ?>'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('<?php echo $plugin_name; ?>', n.nodeName == 'IMG');		
		});
	}
});

tinymce.PluginManager.add('<?php echo $plugin_name; ?>', tinymce.plugins.<?php echo $plugin_name; ?>);
})();