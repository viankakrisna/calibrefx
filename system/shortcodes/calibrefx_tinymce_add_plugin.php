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

include( '../../../../../wp-load.php' );

$shortcode_options = get_option( 'calibrefx_shortcode_options' );

header("Content-type: text/javascript");
echo '(function() {';
foreach( $shortcode_options as $option) {
?>
tinymce.create( 'tinymce.plugins.<?php echo $option['plugin_name']; ?>', {
	init : function(ed, url) {		
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand( 'mceExample' );
		ed.addCommand( '<?php echo $option['plugin_name']; ?>', function() {		
			ed.windowManager.open({			
				file : '<?php echo $option['form_url']; ?>',
				width : <?php echo $option['width']; ?> + ed.getLang( '<?php echo $option['plugin_name']; ?>.delta_width', 0),
				height : <?php echo $option['height']; ?> + ed.getLang( '<?php echo $option['plugin_name']; ?>.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_buttons button
		ed.addButton( '<?php echo $option['plugin_name']; ?>', {
			title : '<?php echo $option['title']; ?>',
			cmd : '<?php echo $option['plugin_name']; ?>',
			image : '<?php echo $option['img_url']; ?>'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive( '<?php echo $option['plugin_name']; ?>', n.nodeName == 'IMG' );		
		});
	}
});

tinymce.PluginManager.add( '<?php echo $option['plugin_name']; ?>', tinymce.plugins.<?php echo $option['plugin_name']; ?>);

<?php
}
echo '})();';