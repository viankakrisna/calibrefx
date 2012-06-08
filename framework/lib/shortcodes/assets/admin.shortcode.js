(function() {
// Load plugin specific language pack
tinymce.PluginManager.requireLangPack('calibrefx_shortcode_buttons');
tinymce.create('tinymce.plugins.calibrefx_shortcode_buttons', {
    
/**
* Initializes the plugin, this will be executed after the plugin has been created.
* This call is done before the editor instance has finished it's initialization so use the onInit event
* of the editor instance to intercept that event.
*
* @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
* @param {string} url Absolute URL to where the plugin is located.
*/

init : function(ed, url) {	
	// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
	ed.addCommand('mcelizatomic_sc_boxs', function() {		
		ed.windowManager.open({			
			file : url + '/form/buttons-form.php',
			width : 360 + ed.getLang('calibrefx_shortcode_buttons.delta_width', 0),
			height : 200 + ed.getLang('calibrefx_shortcode_buttons.delta_height', 0),
			inline : 1			
		}, {			
			plugin_url : url		
		});
	});
	// Register lizatomic_sc_boxs button
	ed.addButton('calibrefx_shortcode_buttons', {
		title : 'Content box shortcode',
		cmd : 'mcelizatomic_sc_boxs',
		image : url + '/img/buttons.png'		
	});
	// Add a node change handler, selects the button in the UI when a image is selected
	ed.onNodeChange.add(function(ed, cm, n) {		
		cm.setActive('mcelizatomic_sc_boxs', n.nodeName == 'IMG');		
	});
}, 

/**
* Returns information about the plugin as a name/value array.
* The current keys are longname, author, authorurl, infourl and version.
*
* @return {Object} Name/value array containing information about the plugin.
*/

getInfo : function() {	
    return {		
			longname : "Lizatomic's shortcodes",
			author : 'LizaTom.com',
			authorurl : 'http://LizaTom.com/',
			infourl : 'http://LizaTom.com/',
			version : "0.9"			
	};	
}
});
// Register plugin
tinymce.PluginManager.add('calibrefx_shortcode_buttons', tinymce.plugins.calibrefx_shortcode_buttons);
})();