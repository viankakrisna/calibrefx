(function() {
tinymce.create('tinymce.plugins.calibrefx_shortcode_buttons', {
	init : function(ed, url) {		
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_buttons', function() {		
			ed.windowManager.open({			
				file : calibrefx_local.shortcode_url + '/form-buttons.php',
				width : 360 + ed.getLang('calibrefx_shortcode_buttons.delta_width', 0),
				height : 420 + ed.getLang('calibrefx_shortcode_buttons.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_buttons button
		ed.addButton('calibrefx_shortcode_buttons', {
			title : 'Button shortcode',
			cmd : 'calibrefx_sc_buttons',
			image : calibrefx_local.assets_img_url + '/shortcode/form/buttons.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_sc_buttons', n.nodeName == 'IMG');		
		});
	}
});

tinymce.create('tinymce.plugins.calibrefx_shortcode_tooltips', {
	init : function(ed, url) {		
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_tooltips', function() {		
			ed.windowManager.open({			
				file : calibrefx_local.shortcode_url + '/form-tooltips.php',
				width : 360 + ed.getLang('calibrefx_shortcode_tooltips.delta_width', 0),
				height : 380 + ed.getLang('calibrefx_shortcode_tooltips.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_tooltips button
		ed.addButton('calibrefx_shortcode_tooltips', {
			title : 'Tooltips shortcode',
			cmd : 'calibrefx_sc_tooltips',
			image : calibrefx_local.assets_img_url + '/shortcode/form/tooltips.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_sc_tooltips', n.nodeName == 'IMG');		
		});
	}
});

tinymce.create('tinymce.plugins.calibrefx_shortcode_dropcaps', {
	init : function(ed, url) {	
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_dropcaps', function() {		
			ed.windowManager.open({			
				file : calibrefx_local.shortcode_url + '/form-dropcaps.php',
				width : 360 + ed.getLang('calibrefx_shortcode_dropcaps.delta_width', 0),
				height : 280 + ed.getLang('calibrefx_shortcode_dropcaps.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_dropcaps button
		ed.addButton('calibrefx_shortcode_dropcaps', {
			title : 'Dropcaps shortcode',
			cmd : 'calibrefx_sc_dropcaps',
			image : calibrefx_local.assets_img_url + '/shortcode/form/dropcaps.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_shortcode_dropcaps', n.nodeName == 'IMG');		
		});
	}

});

tinymce.create('tinymce.plugins.calibrefx_shortcode_text', {
	init : function(ed, url) {	
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_text', function() {		
			ed.windowManager.open({			
				file : calibrefx_local.shortcode_url + '/form-texts.php',
				width : 360 + ed.getLang('calibrefx_shortcode_text.delta_width', 0),
				height : 280 + ed.getLang('calibrefx_shortcode_text.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_text button
		ed.addButton('calibrefx_shortcode_text', {
			title : 'Text shortcode',
			cmd : 'calibrefx_sc_text',
			image : calibrefx_local.assets_img_url + '/shortcode/form/text.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_shortcode_text', n.nodeName == 'IMG');		
		});
	}

});

tinymce.create('tinymce.plugins.calibrefx_shortcode_list', {
	init : function(ed, url) {		
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_list', function() {		
			ed.windowManager.open({			
				file : calibrefx_local.shortcode_url + '/form-list.php',
				width : 360 + ed.getLang('calibrefx_shortcode_list.delta_width', 0),
				height : 200 + ed.getLang('calibrefx_shortcode_list.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_cols button
		ed.addButton('calibrefx_shortcode_list', {
			title : 'List shortcode',
			cmd : 'calibrefx_sc_list',
			image : calibrefx_local.assets_img_url + '/shortcode/form/list.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_shortcode_list', n.nodeName == 'IMG');		
		});
	}
});

tinymce.create('tinymce.plugins.calibrefx_shortcode_column', {
	init : function(ed, url) {		
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_cols', function() {		
			ed.windowManager.open({			
				file : calibrefx_local.shortcode_url + '/form-cols.php',
				width : 360 + ed.getLang('calibrefx_shortcode_column.delta_width', 0),
				height : 220 + ed.getLang('calibrefx_shortcode_column.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_cols button
		ed.addButton('calibrefx_shortcode_column', {
			title : 'Column shortcode',
			cmd : 'calibrefx_sc_cols',
			image : calibrefx_local.assets_img_url + '/shortcode/form/cols.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_sc_cols', n.nodeName == 'IMG');		
		});
	}
});

tinymce.create('tinymce.plugins.calibrefx_shortcode_gmaps', {
	init : function(ed, url) {		
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_gmaps', function() {		
			ed.windowManager.open({			
				file : calibrefx_local.shortcode_url + '/form-gmaps.php',
				width : 470 + ed.getLang('calibrefx_shortcode_gmaps.delta_width', 0),
				height : 240 + ed.getLang('calibrefx_shortcode_gmaps.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_gmaps button
		ed.addButton('calibrefx_shortcode_gmaps', {
			title : 'Google maps shortcode',
			cmd : 'calibrefx_sc_gmaps',
			image : calibrefx_local.assets_img_url + '/shortcode/form/googlemaps.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_sc_gmaps', n.nodeName == 'IMG');		
		});
	}, 

});

tinymce.create('tinymce.plugins.calibrefx_shortcode_video', {
	init : function(ed, url) {	
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_video', function() {		
			ed.windowManager.open({			
				file : calibrefx_local.shortcode_url + '/form-video.php',
				width : 360 + ed.getLang('calibrefx_shortcode_video.delta_width', 0),
				height : 240 + ed.getLang('calibrefx_shortcode_video.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_video button
		ed.addButton('calibrefx_shortcode_video', {
			title : 'Video shortcode',
			cmd : 'calibrefx_sc_video',
			image : calibrefx_local.assets_img_url + '/shortcode/form/video.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_sc_video', n.nodeName == 'IMG');		
		});
	}
});

tinymce.create('tinymce.plugins.calibrefx_shortcode_slider', {
	init : function(ed, url) {		
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_slider', function() {		
			ed.windowManager.open({			
				file : calibrefx_local.shortcode_url + '/form-slider.php',
				width : 400 + ed.getLang('calibrefx_shortcode_slider.delta_width', 0),
				height : 460 + ed.getLang('calibrefx_shortcode_slider.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_slider button
		ed.addButton('calibrefx_shortcode_slider', {
			title : 'Slider shortcode',
			cmd : 'calibrefx_sc_slider',
			image : calibrefx_local.assets_img_url + '/shortcode/form/nivo.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_sc_slider', n.nodeName == 'IMG');		
		});
	} 

});

tinymce.create('tinymce.plugins.calibrefx_shortcode_tabs', {
	init : function(ed, url) {		
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_tabs', function() {		
			ed.windowManager.open({			
				file : calibrefx_local.shortcode_url + '/form-tabs.php',
				width : 360 + ed.getLang('calibrefx_shortcode_tabs.delta_width', 0),
				height : 340 + ed.getLang('calibrefx_shortcode_tabs.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_tabs button
		ed.addButton('calibrefx_shortcode_tabs', {
			title : 'Tabs shortcode',
			cmd : 'calibrefx_sc_tabs',
			image : calibrefx_local.assets_img_url + '/shortcode/form/tabs.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_sc_tabs', n.nodeName == 'IMG');		
		});
	}
});

tinymce.create('tinymce.plugins.calibrefx_shortcode_togglebox', {
	init : function(ed, url) {	
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_togglebox', function() {		
			ed.windowManager.open({			
				file : calibrefx_local.shortcode_url + '/form-togglebox.php',
				width : 360 + ed.getLang('calibrefx_shortcode_togglebox.delta_width', 0),
				height : 200 + ed.getLang('calibrefx_shortcode_togglebox.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_togglebox button
		ed.addButton('calibrefx_shortcode_togglebox', {
			title : 'Togglebox shortcode',
			cmd : 'calibrefx_sc_togglebox',
			image : calibrefx_local.assets_img_url + '/shortcode/form/togglebox.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_sc_togglebox', n.nodeName == 'IMG');		
		});
	}
});

tinymce.create('tinymce.plugins.calibrefx_shortcode_social', {
	init : function(ed, url) {	
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_social', function() {		
			ed.windowManager.open({			
				file : calibrefx_local.shortcode_url + '/form-social.php',
				width : 360 + ed.getLang('calibrefx_shortcode_social.delta_width', 0),
				height : 200 + ed.getLang('calibrefx_shortcode_social.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_social button
		ed.addButton('calibrefx_shortcode_social', {
			title : 'Social icon shortcode',
			cmd : 'calibrefx_sc_social',
			image : calibrefx_local.assets_img_url + '/shortcode/form/social.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_sc_social', n.nodeName == 'IMG');		
		});
	}
});


// Register plugin
tinymce.PluginManager.add('calibrefx_shortcode_buttons', tinymce.plugins.calibrefx_shortcode_buttons);
tinymce.PluginManager.add('calibrefx_shortcode_tooltips', tinymce.plugins.calibrefx_shortcode_tooltips);
tinymce.PluginManager.add('calibrefx_shortcode_dropcaps', tinymce.plugins.calibrefx_shortcode_dropcaps);
tinymce.PluginManager.add('calibrefx_shortcode_text', tinymce.plugins.calibrefx_shortcode_text);
tinymce.PluginManager.add('calibrefx_shortcode_list', tinymce.plugins.calibrefx_shortcode_list);
tinymce.PluginManager.add('calibrefx_shortcode_column', tinymce.plugins.calibrefx_shortcode_column);
tinymce.PluginManager.add('calibrefx_shortcode_gmaps', tinymce.plugins.calibrefx_shortcode_gmaps);
tinymce.PluginManager.add('calibrefx_shortcode_video', tinymce.plugins.calibrefx_shortcode_video);
tinymce.PluginManager.add('calibrefx_shortcode_slider', tinymce.plugins.calibrefx_shortcode_slider);
tinymce.PluginManager.add('calibrefx_shortcode_tabs', tinymce.plugins.calibrefx_shortcode_tabs);
tinymce.PluginManager.add('calibrefx_shortcode_togglebox', tinymce.plugins.calibrefx_shortcode_togglebox);
tinymce.PluginManager.add('calibrefx_shortcode_social', tinymce.plugins.calibrefx_shortcode_social);
})();