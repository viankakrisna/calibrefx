(function() {
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
		url1 = url.replace('js','');
		url2 = url1.replace('assets/','');
		url2 = url2 + 'framework/lib/shortcodes';
	
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_buttons', function() {		
			ed.windowManager.open({			
				file : url2 + '/form-buttons.php',
				width : 360 + ed.getLang('calibrefx_shortcode_buttons.delta_width', 0),
				height : 200 + ed.getLang('calibrefx_shortcode_buttons.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_buttons button
		ed.addButton('calibrefx_shortcode_buttons', {
			title : 'Button shortcode',
			cmd : 'calibrefx_sc_buttons',
			image : url1 + '/img/shortcode/buttons/buttons.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_sc_buttons', n.nodeName == 'IMG');		
		});
	}, 

});

tinymce.create('tinymce.plugins.calibrefx_shortcode_tooltips', {
	/**
	* Initializes the plugin, this will be executed after the plugin has been created.
	* This call is done before the editor instance has finished it's initialization so use the onInit event
	* of the editor instance to intercept that event.
	*
	* @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
	* @param {string} url Absolute URL to where the plugin is located.
	*/

	init : function(ed, url) {	
		url1 = url.replace('js','');
		url2 = url1.replace('assets/','');
		url2 = url2 + 'framework/lib/shortcodes';
	
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_tooltips', function() {		
			ed.windowManager.open({			
				file : url2 + '/form-tooltips.php',
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
			image : url1 + '/img/shortcode/buttons/tooltips.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_sc_tooltips', n.nodeName == 'IMG');		
		});
	}, 

});

tinymce.create('tinymce.plugins.calibrefx_shortcode_dropcaps', {
	/**
	* Initializes the plugin, this will be executed after the plugin has been created.
	* This call is done before the editor instance has finished it's initialization so use the onInit event
	* of the editor instance to intercept that event.
	*
	* @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
	* @param {string} url Absolute URL to where the plugin is located.
	*/

	init : function(ed, url) {	
		url1 = url.replace('js','');
		url2 = url1.replace('assets/','');
		url2 = url2 + 'framework/lib/shortcodes';
	
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_dropcaps', function() {		
			ed.windowManager.open({			
				file : url2 + '/form-dropcaps.php',
				width : 360 + ed.getLang('calibrefx_shortcode_dropcaps.delta_width', 0),
				height : 340 + ed.getLang('calibrefx_shortcode_dropcaps.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_dropcaps button
		ed.addButton('calibrefx_shortcode_dropcaps', {
			title : 'Dropcaps shortcode',
			cmd : 'calibrefx_sc_dropcaps',
			image : url1 + '/img/shortcode/buttons/dropcaps.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_shortcode_dropcaps', n.nodeName == 'IMG');		
		});
	}, 

});

tinymce.create('tinymce.plugins.calibrefx_shortcode_list', {
	/**
	* Initializes the plugin, this will be executed after the plugin has been created.
	* This call is done before the editor instance has finished it's initialization so use the onInit event
	* of the editor instance to intercept that event.
	*
	* @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
	* @param {string} url Absolute URL to where the plugin is located.
	*/

	init : function(ed, url) {	
		url1 = url.replace('js','');
		url2 = url1.replace('assets/','');
		url2 = url2 + 'framework/lib/shortcodes';
	
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_list', function() {		
			ed.windowManager.open({			
				file : url2 + '/form-list.php',
				width : 360 + ed.getLang('calibrefx_shortcode_list.delta_width', 0),
				height : 340 + ed.getLang('calibrefx_shortcode_list.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_cols button
		ed.addButton('calibrefx_shortcode_list', {
			title : 'List shortcode',
			cmd : 'calibrefx_sc_list',
			image : url1 + '/img/shortcode/buttons/list.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_shortcode_list', n.nodeName == 'IMG');		
		});
	}, 

});

tinymce.create('tinymce.plugins.calibrefx_shortcode_column', {
	/**
	* Initializes the plugin, this will be executed after the plugin has been created.
	* This call is done before the editor instance has finished it's initialization so use the onInit event
	* of the editor instance to intercept that event.
	*
	* @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
	* @param {string} url Absolute URL to where the plugin is located.
	*/

	init : function(ed, url) {	
		url1 = url.replace('js','');
		url2 = url1.replace('assets/','');
		url2 = url2 + 'framework/lib/shortcodes';
	
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_cols', function() {		
			ed.windowManager.open({			
				file : url2 + '/form-cols.php',
				width : 360 + ed.getLang('calibrefx_shortcode_column.delta_width', 0),
				height : 340 + ed.getLang('calibrefx_shortcode_column.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_cols button
		ed.addButton('calibrefx_shortcode_column', {
			title : 'Column shortcode',
			cmd : 'calibrefx_sc_cols',
			image : url1 + '/img/shortcode/buttons/cols.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_sc_cols', n.nodeName == 'IMG');		
		});
	}, 

});

tinymce.create('tinymce.plugins.calibrefx_shortcode_gmaps', {
	/**
	* Initializes the plugin, this will be executed after the plugin has been created.
	* This call is done before the editor instance has finished it's initialization so use the onInit event
	* of the editor instance to intercept that event.
	*
	* @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
	* @param {string} url Absolute URL to where the plugin is located.
	*/

	init : function(ed, url) {	
		url1 = url.replace('js','');
		url2 = url1.replace('assets/','');
		url2 = url2 + 'framework/lib/shortcodes';
	
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_gmaps', function() {		
			ed.windowManager.open({			
				file : url2 + '/form-gmaps.php',
				width : 360 + ed.getLang('calibrefx_shortcode_gmaps.delta_width', 0),
				height : 340 + ed.getLang('calibrefx_shortcode_gmaps.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_gmaps button
		ed.addButton('calibrefx_shortcode_gmaps', {
			title : 'Google maps shortcode',
			cmd : 'calibrefx_sc_gmaps',
			image : url1 + '/img/shortcode/buttons/googlemaps.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_sc_gmaps', n.nodeName == 'IMG');		
		});
	}, 

});

tinymce.create('tinymce.plugins.calibrefx_shortcode_video', {
	/**
	* Initializes the plugin, this will be executed after the plugin has been created.
	* This call is done before the editor instance has finished it's initialization so use the onInit event
	* of the editor instance to intercept that event.
	*
	* @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
	* @param {string} url Absolute URL to where the plugin is located.
	*/

	init : function(ed, url) {	
		url1 = url.replace('js','');
		url2 = url1.replace('assets/','');
		url2 = url2 + 'framework/lib/shortcodes';
	
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
		ed.addCommand('calibrefx_sc_video', function() {		
			ed.windowManager.open({			
				file : url2 + '/form-video.php',
				width : 360 + ed.getLang('calibrefx_shortcode_video.delta_width', 0),
				height : 340 + ed.getLang('calibrefx_shortcode_video.delta_height', 0),
				inline : 1			
			}, {			
				plugin_url : url		
			});
		});
		// Register calibrefx_sc_video button
		ed.addButton('calibrefx_shortcode_video', {
			title : 'Video shortcode',
			cmd : 'calibrefx_sc_video',
			image : url1 + '/img/shortcode/buttons/video.png'		
		});
		// Add a node change handler, selects the button in the UI when a image is selected
		ed.onNodeChange.add(function(ed, cm, n) {		
			cm.setActive('calibrefx_sc_video', n.nodeName == 'IMG');		
		});
	}, 

});

// Register plugin
tinymce.PluginManager.add('calibrefx_shortcode_buttons', tinymce.plugins.calibrefx_shortcode_buttons);
tinymce.PluginManager.add('calibrefx_shortcode_tooltips', tinymce.plugins.calibrefx_shortcode_tooltips);
tinymce.PluginManager.add('calibrefx_shortcode_dropcaps', tinymce.plugins.calibrefx_shortcode_dropcaps);
tinymce.PluginManager.add('calibrefx_shortcode_list', tinymce.plugins.calibrefx_shortcode_list);
tinymce.PluginManager.add('calibrefx_shortcode_column', tinymce.plugins.calibrefx_shortcode_column);
tinymce.PluginManager.add('calibrefx_shortcode_gmaps', tinymce.plugins.calibrefx_shortcode_gmaps);
tinymce.PluginManager.add('calibrefx_shortcode_video', tinymce.plugins.calibrefx_shortcode_video);
})();