var CFX_Builder = CFX_Builder || {};

( function( $ ) {

	$( document ).ready( function() {
		//Views
		console.log('initialize ContentTypeView');
		CFX_Builder.ContentTypeView = window.wp.Backbone.View.extend( {
			el : $('.content_type_fields'),

			events: {
				'change' : 'render_type'
			},

			initialize : function() {
				
			},

			render_type : function( event ) {
				event.preventDefault();
				console.log($(event.target).attr("name"));
				var parent = $(event.target).closest('.vp-controls');
				
				$(parent).find('.wpa_loop').remove();

				if( $(event.target).val() == '' ) return this;

				var name = $(event.target).attr("name");
				var res = name.match(/\[([^\]]*)\]/g);
				//remove last element
				res.pop();
				var template_name = "page_builder" + res.join("") + "[" + $(event.target).val() + "][0]";
				console.log(template_name);

				var html_to_copy = $('#tmpl-'+$(event.target).val()).html();
				html_to_copy = html_to_copy.replace(/%template%/g, template_name);

				$(parent).append( html_to_copy );
				$(parent).find('.wpa_loop-'+$(event.target).val()).removeClass('vp-hide').removeClass('vp-dep-inactive');

				return this;
			},

		} );

		viewObj = new CFX_Builder.ContentTypeView();

	} );
}(jQuery));