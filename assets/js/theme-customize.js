/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
(function( $ ) {
	var api = wp.customize;
	//Update site title color in real time...
	// wp.customize( 'mytheme_options[link_textcolor]', function( value ) {
	// 	value.bind( function( newval ) {
	// 		$( 'a' ).css( 'color', newval );
	// 	} );
	// } );
	api.Control = api.Class.extend({
		initialize: function( id, options ) {
			var control = this,
				nodes, radios, settings;

			this.params = {};
			$.extend( this, options || {} );

			this.id = id;
			this.selector = '#customize-control-' + id.replace( ']', '' ).replace( '[', '-' );
			this.container = $( this.selector );

			settings = $.map( this.params.settings, function( value ) {
				return value;
			});

			api.apply( api, settings.concat( function() {
				var key;

				control.settings = {};
				for ( key in control.params.settings ) {
					control.settings[ key ] = api( control.params.settings[ key ] );
				}

				control.setting = control.settings['default'] || null;
				control.ready();
			}) );

			control.elements = [];

			nodes  = this.container.find( '[data-customize-setting-link]' );
			radios = {};

			nodes.each( function() {
				var node = $(this),
					name;

				if ( node.is( ':radio' ) ) {
					name = node.prop( 'name' );
					if ( radios[ name ] )
						return;

					radios[ name ] = true;
					node = nodes.filter( '[name="' + name + '"]' );
				}

				api( node.data( 'customizeSettingLink' ), function( setting ) {
					var element = new api.Element( node );
					control.elements.push( element );
					element.sync( setting );
					element.set( setting() );
				});
			});
		},

		ready: function() {},

		dropdownInit: function() {
			var control  = this,
				statuses = this.container.find( '.dropdown-status' ),
				params   = this.params,
				update   = function( to ) {
					if ( typeof	to === 'string' && params.statuses && params.statuses[ to ] )
						statuses.html( params.statuses[ to ] ).show();
					else
						statuses.hide();
				};

			var toggleFreeze = false;

			// Support the .dropdown class to open/close complex elements
			this.container.on( 'click keydown', '.dropdown', function( event ) {
				if ( event.type === 'keydown' &&  13 !== event.which ) // enter
					return;

				event.preventDefault();

				if (!toggleFreeze)
					control.container.toggleClass( 'open' );

				if ( control.container.hasClass( 'open' ) )
					control.container.parent().parent().find( 'li.library-selected' ).focus();

				// Don't want to fire focus and click at same time
				toggleFreeze = true;
				setTimeout(function () {
					toggleFreeze = false;
				}, 400);
			});

			this.setting.bind( update );
			update( this.setting() );
		}
	});

	// Create the collection of Control objects.
	api.control = new api.Values({ defaultConstructor: api.Control });

	$.each({
			'show_on_front': {
				controls: [ 'calibrefx-settings[calibrefx_layout_width]' ],
				callback: function( to ) { return 'static' === to }
			},
		}, function( settingId, o ) {
			api( settingId, function( setting ) {
				$.each( o.controls, function( i, controlId ) {
					api.control( controlId, function( control ) {
						var visibility = function( to ) {
							control.container.toggle( o.callback( to ) );
						};

						visibility( setting.get() );
						setting.bind( visibility );
					});
				});
			});
		});

} )( jQuery );
