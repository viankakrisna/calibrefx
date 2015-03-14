var calibrefx_toggles = {
	"content_archive":["#calibrefx-settings\\[content_archive\\]",".calibrefx_content_limit_setting","full"],
	"layout_type":["#calibrefx-settings\\[layout_type\\]",".calibrefx_layout_width","static"],
	"email_protocol":["#calibrefx-settings\\[email_protocol\\]","#email_setting_box_content","smtp"]
};

window['calibrefx'] = {
	update_character_count: function (event) {
		'use strict';
		jQuery( '#' + event.target.id + '_chars' ).html(jQuery(event.target).val().length.toString() );
	},
	
	toggle_settings: function (event) {
		'use strict';

		// Cache selectors
		var $selector = jQuery(event.data.selector),
		$show_selector = jQuery(event.data.show_selector),
		check_value = event.data.check_value;
		
		if (
			(jQuery.isArray(check_value) && jQuery.inArray( $selector.val(), check_value) > -1) ||
			(check_value === null && $selector.is( ':checked' ) ) ||
			(check_value !== null && $selector.val() === check_value)
			) {
			jQuery( $show_selector).slideDown( 'fast' );
		} else {
			jQuery( $show_selector).slideUp( 'fast' );
		}
	},
	
	toggle_settings_init: function () {
		'use strict';

		jQuery.each(calibrefx_toggles, function (k, v) {
			// Prepare data
			var data = {
				selector: v[0], 
				show_selector: v[1], 
				check_value: v[2]
				};
			
			// Setup toggle binding
			jQuery( 'div.calibrefx-metaboxes' ).on( 'change.calibrefx.calibrefx_toggle', v[0], data, calibrefx.toggle_settings);

			jQuery(v[0]).trigger( 'change.calibrefx_toggle', data);
		});
	},
	
	layout_highlighter: function (event) {
		'use strict';

		// Cache class name
		var selected_class = 'selected';

		// Remove class from all labels
		jQuery( 'input[name="' + jQuery(event.target).attr( 'name' ) + '"]' ).parent( 'label' ).removeClass(selected_class);

		// Add class to selected layout
		jQuery(event.target).parent( 'label' ).addClass(selected_class);

	},
	
	ready: function () {
		'use strict';
		
		// Initialise settings that can toggle the display of other settings
		calibrefx.toggle_settings_init();

		jQuery( '#calibrefx_title, #calibrefx_description' ).on( 'keyup.calibrefx.calibrefx_character_count', calibrefx.update_character_count);
		
		// Bind layout highlighter behaviour
		jQuery( '.calibrefx-layout-selector' ).on( 'change.calibrefx.calibrefx_layout_selector', 'input[type="radio"]', calibrefx.layout_highlighter);
	}
};

jQuery(calibrefx.ready);

jQuery(document).ready(function( $) {
	$( 'input.calibrefx-settings-checkbox' ).click(function() {
		var id = $(this).attr( 'target' );
		
		if( $(this).is( ':checked' ) ) {
			$( '#' + id).val( '1' );
		}else{
			$( '#' + id).val( '0' );
		}
	});

	$( '.show_advanced' ).live( 'click', function() {
		var parent = $(this).parents( '.widget' );

		if( $(this).is( ':checked' ) ) {
			parent.find( '.advanced-widget-options' ).slideDown();
		}else{
			parent.find( '.advanced-widget-options' ).slideUp();
		}
	});

	var imageFrame;
	$( '.upload_image_button' ).click( function( event ) {
		event.preventDefault();
		
		var options, attachment;
		
		$self = $( event.target );
		$div = $self.parents( 'div.option-item' );
		
		// if the frame already exists, open it
		if ( imageFrame ) {
			imageFrame.open();
			return;
		}
		
		// set our settings
		imageFrame = wp.media({
			title: 'Choose Image',
			multiple: false,
			library: {
				type: 'image'
			},
			button: {
				text: 'Use This Image'
			}
		});
		
		// set up our select handler
		imageFrame.on( 'select', function() {
			var i = 0;
			selection = imageFrame.state().get( 'selection' );
			
			if ( ! selection ) return;
			
			// loop through the selected files
			selection.each( function( attachment ) {
				var src = attachment.attributes.sizes.full.url;
				var id = attachment.id;
				
				var img = $( '<img>' );
				img.attr( 'src', src );

				$div.find( '.preview_image' ).html( img );
				$div.find( '.image_id' ).val( id );
				$div.find( '.form-control' ).val( src ); i++;
			} );
		});
		
		// open the frame
		imageFrame.open();
	});

	$( '.image_reset_button' ).click( function(){
		$div = $( this ).parents( 'div.option-item' );

		$div.find( '.preview_image' ).html( '' );
		$div.find( '.image_id' ).val( '' );
		$div.find( '.form-control' ).val( '' );
	} );

	$('body').on('click', '.calibrefx-sc-generator', function(){
		//Fire magnific popup
		$.magnificPopup.open({
				mainClass: 'mfp-zoom-in',
				items: {
					src: '#calibrefx-sc-generator'
				},
				type: 'inline',
				removalDelay: 500
		}, 0);
	}); 
});

function calibrefx_confirm( text ) {
	var answer = confirm( text );

	if( answer ) {
		return true;
	} else {
		return false;
	}
}

function tos_bind_events() {
	(function( $) {
		$( '.button-ajax' ).click( function() {
			var button = this;
			$.post( ajaxurl, {
				'action': $(button).attr( 'data-action' ),
				'_ajax_nonce': $(button).attr( 'data-nonce' ),
				'param': $(button).attr( 'data-param' ),
				'name': $( '#name' ).val,
				'url': $( '#url' ).val,
				'info': $( '#info' ).val,
			})
			.success( function( result ) {
				if ( '1' === result ) {
					$(button).unbind( 'click' ).prop( 'disabled', true);
				} else {
					alert( result );
					$( button ).after( '<span class="a8c-developer-action-result error">' + result + '</span>' );
				}
			})
			.error( function( response ) {
				$( button ).after( '<span class="a8c-developer-action-result error">' + response.statusText + ': ' + response.responseText + '</span>' );
			});

			return false;
		}); 
	})(jQuery);
}

// Shortcodes
jQuery(document).ready(function($){
	
	initUpload();

	$("select#calibrefx-shortcodes").chosen({
		width: "100%",
		disable_search_threshold: 30
	});

	$('input.popup-colorpicker-bg').wpColorPicker();
	$('input.popup-colorpicker-text').wpColorPicker();
	$('input.popup-colorpicker-shadow').wpColorPicker();

	$('#add-shortcode').click(function(){
		//column animation check (don't add the attrs when unnecessary)
		var name = $('#calibrefx-shortcodes').val();
		var dataType = $('#options-'+name).attr('data-type');
		
		update_shortcode();
			
		var $shortcodeData = $('#shortcode-storage-o').text() + $('#shortcode-storage-d').text() + $('#shortcode-storage-c').text() ;
			
		window.wp.media.editor.insert( $('#shortcode-storage-o').text() + $('#shortcode-storage-d').text() + $('#shortcode-storage-c').text() );
		$.magnificPopup.close();
			
		//wipe out storage 
		$('#shortcode-storage-o, #shortcode-storage-d, #shortcode-storage-c').text('');
			
		resetFileds();
			
		return false;
	});

	$('#calibrefx-shortcodes').change(function(){
		$('.shortcode-options').hide();
		$('#options-'+$(this).val()).show();

		var dataType = $('#options-'+$(this).val()).attr('data-type');
		
		if( dataType == 'checkbox' || dataType == 'simple' ){
			$('#shortcode-content').show().find('textarea').val('');
		}
		
		else {
			$('#shortcode-content textarea').val('').parent().parent().hide();
		}

	});

	//icon selection
	$('.icon-option i').click(function(){
		$('.icon-option i').removeClass('selected');
		$(this).addClass('selected');
	});

	//icon set selection
	$('select[name="icon-set-select"]').change(function(){
		var $selected_set = $(this).val();
		$('.icon-option').hide();
		$('.icon-option').next('.clear').hide();
		$('.icon-option.'+$selected_set).stop(true,true).fadeIn();
		$('.icon-option.'+$selected_set).next('.clear').show();
	});
	$('select[name="icon-set-select"]').trigger('change');

	function update_shortcode(ending){
		
		var name = $('#calibrefx-shortcodes').val();
		var dataType = $('#options-'+name).attr('data-type');
		var extra_attrs = '', extra_attrs2 = '', extra_attrs3 = '', extra_attrs3b = '', extra_attrs4 = '';
		
		ending = ending || '';
		
		//take care of the dynamic events easier
		// dynamic_items();
		
		//last check
		var code = '['+name;
		if( $('#options-'+name).attr('data-type')=='checkbox' ){
			if($('#options-'+name+' input.last').attr('checked') == 'checked') ending = '_last';
		}
		code += ending;
		 
		//checkbox loop for extra attrs
		$('#options-'+name+' input[type=checkbox]').each(function(){
			 if($(this).attr('checked') == 'checked' && $(this).attr('class') != 'last') extra_attrs += ' ' + $(this).attr('class')+'="true"';  
		});
		
		code += extra_attrs;
		
		//textarea loop for extra attrs
		$('#options-'+name+' textarea:not("#shortcode_content")').each(function(){
			 extra_attrs2 += ' ' + $(this).attr('data-attrname')+'="'+ $(this).val() +'"';  
		});
		
		if(dataType != 'dynamic') code += extra_attrs2;
		
		//select loop for extra attrs
		$('#options-'+name+' select:not(".dynamic-select, [multiple=multiple], .skip-processing")').each(function(){
			 extra_attrs3 += ' ' + $(this).attr('id')+'="' + $(this).attr('value') + '"';   
		});
		
		code += extra_attrs3;
		
		//multiselect loop for extra attrs
		$('#options-'+name+' select[multiple=multiple]').each(function(){
			 var $categories = ($(this).val() != null && $(this).val().length > 0) ? $(this).val() : 'all';
			 extra_attrs3b += ' ' + $(this).attr('id')+'="' + $categories + '"';    
		});
		
		code += extra_attrs3b;
		
		//image upload loop for extra attrs
		$('#options-'+name+' [data-name=image-upload] img.redux-opts-screenshot').each(function(){
			 extra_attrs4 += ' ' + $(this).attr('id')+'="' + $(this).attr('src') + '"'; 
		});
		
		code += extra_attrs4;
		
		//input loop for extra attrs
		$('#options-'+name+' input.attr:not(".skip-processing")').each(function(){
			if( $(this).attr('type') == 'text' ){ code += ' '+ $(this).attr('data-attrname')+'="'+ $(this).val()+'"'; }
			else { if($(this).attr('checked') == 'checked') code += ' '+ $(this).attr('data-attrname')+'="'+ $(this).val()+'"'; }
		});
		
		
		//color loop for extra attrs
		$('#options-'+name+' input.popup-colorpicker-bg').each(function(){
			 code += ' background_color="'+ $(this).val()+'"'; 
		});
		
		//color loop for extra attrs
		$('#options-'+name+' input.popup-colorpicker-text').each(function(){
			 code += ' text_color="'+ $(this).val()+'"'; 
		});

		//color loop for extra attrs
		$('#options-'+name+' input.popup-colorpicker-shadow').each(function(){
			 code += ' shadow_color="'+ $(this).val()+'"'; 
		});
		
		//take care of icon attrs
		if(name == 'icon' && $('.icon-option i.selected').length > 0 ) {
			var icon_class = $('.icon-option i.selected').attr('class').split(' ');
			var the_class = icon_class[0];
			if(icon_class.length > 1){
				the_class = icon_class[icon_class.length - 2];
			}
			code += ' image="'+ the_class +'"'; 
		}
		
		code += ']';

		$('#shortcode-storage-o').html(code);
		if( dataType!= 'dynamic') $('#shortcode-storage-d').text($('#shortcode-content textarea').val());
		if( dataType != 'regular' && dataType != 'radios') $('#shortcode-storage-c').html(' [/'+name+ending+']');
		
	}

	function initUpload(){
		console.log("redux-opts-upload");
		jQuery(".redux-opts-upload").on('click',function( event ) {
			
			var activeFileUploadContext = jQuery(this).parent();
			var relid = jQuery(this).attr('rel-id');

			event.preventDefault();

			// if its not null, its broking custom_file_frame's onselect "activeFileUploadContext"
			custom_file_frame = null;

			// Create the media frame.
			custom_file_frame = wp.media.frames.customHeader = wp.media({
				// Set the title of the modal.
				title: jQuery(this).data("choose"),

				// Tell the modal to show only images. Ignore if want ALL
				library: {
					type: 'image'
				},
				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: jQuery(this).data("update")
				}
			});

			custom_file_frame.on( "select", function() {
				// Grab the selected attachment.
				var attachment = custom_file_frame.state().get("selection").first();

				// Update value of the targetfield input with the attachment url.
				jQuery('.redux-opts-screenshot',activeFileUploadContext).attr('src', attachment.attributes.url);
				jQuery('#' + relid ).val(attachment.attributes.url).trigger('change');

				jQuery('.redux-opts-upload',activeFileUploadContext).hide();
				jQuery('.redux-opts-screenshot',activeFileUploadContext).show();
				jQuery('.redux-opts-upload-remove',activeFileUploadContext).show();
			});

			custom_file_frame.open();
		});

		jQuery(".redux-opts-upload-remove").on('click', function( event ) {
			var activeFileUploadContext = jQuery(this).parent();
			var relid = jQuery(this).attr('rel-id');

			event.preventDefault();

			jQuery('#' + relid).val('');
			jQuery(this).prev().fadeIn('slow');
			jQuery('.redux-opts-screenshot',activeFileUploadContext).fadeOut('slow');
			jQuery(this).fadeOut('slow');
		});
	}

	function resetFileds(){
		//reset data
		$('#calibrefx-sc-generator').find('input:text, input:password, input:file, textarea').val('');
		$('#calibrefx-sc-generator').find('select:not(#calibrefx-shortcodes) option:first-child').attr("selected", "selected");
		$('#calibrefx-sc-generator').find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
		$('#calibrefx-sc-generator').find('.shortcode-options').each(function(){
			$(this).find('.shortcode-dynamic-item').addClass('marked-for-removal');
			$(this).find('.shortcode-dynamic-item:first').removeClass('marked-for-removal');
			$(this).find('.shortcode-dynamic-item.marked-for-removal').remove();
		});
		$('#calibrefx-sc-generator').find('.redux-opts-screenshot').attr('src','');
		$('#calibrefx-sc-generator').find('.redux-opts-upload-remove').hide();
		$('#calibrefx-sc-generator').find('.redux-opts-upload').show();
		$('#calibrefx-sc-generator').find('.wp-color-result').attr('style','');
		
		//starting category population
		$('.starting_category').hide();
		$('.starting_category').next('.clear').hide();
	}

});