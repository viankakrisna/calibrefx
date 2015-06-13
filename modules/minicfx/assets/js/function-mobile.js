jQuery(document).ready(function($) {

	function bindMenuEvent(){
		$( document ).on( "swipeleft swiperight", ".ui-page-active", function( e ) {
			if ( $.mobile.activePage.jqmData( "panel" ) !== "open" ) {
				if ( e.type === "swipeleft"  ) {
					$( ".mobile-menu" ).panel( "close" );
				} else if ( e.type === "swiperight" ) {
					$( ".mobile-menu" ).panel( "open" );
				}
			}
		});

		$( '.menu-primary > li:has(> ul)' ).append( '<span class="mobile-arrow"><i class="icon-mobile-arrow"></i></span>' );

		$( '.menu-primary > li span.mobile-arrow' ).bind( 'click touchstart', function() {
			$this = $(this);
			$li = $this.parent();
			$anchor = $li.children( 'a' )
			$ul = $li.children( 'ul' );


			$allLi = $( '.menu-primary > li' );
			$allUl = $( '.menu-primary > li > ul' );

			if( $ul.length > 0) {

				if( $li.hasClass( 'mobile-open' ) ) {
					$allUl.slideUp();
					$allLi.removeClass( 'mobile-open' );
				}
				else{
					$allUl.slideUp();				
					$allLi.removeClass( 'mobile-open' );

					$ul.slideDown();
					$li.addClass( 'mobile-open' );
				}
			}
			else{
				if( $anchor.attr( 'href' ) != '#' ) window.location = $anchor.attr( 'href' );
				else return false;
			}

			return false;
		});
	}

	/* 	Triggered after the page is successfully loaded and inserted into the DOM.	*/ 
	$( document ).on( "pageload", function() {
		
	} );


	/* 	Triggered when the page has been created in the DOM (via ajax or other)
	 	and after all widgets have had an opportunity to enhance the contained markup.	*/
	$( document ).on( "pagecreate", function() {

		bindMenuEvent();

		$( document ).on( "panelopen", ".mobile-search", function() {
			$( this ).find( "input" ).focus();
		})

	} );

	bindMenuEvent();
});

// 	TODO : Need localized script and settings here.
jQuery( document ).on( "mobileinit", function() {
	
	jQuery.extend( jQuery.mobile , minicfx_settings );

	jQuery.each( minicfx_loading, function( index, val ) {
		jQuery.mobile.loader.prototype.options[index] = minicfx_loading[index];
	} );
	// jQuery.mobile.loader.prototype.options.text = minicfx_loading.text;
	// jQuery.mobile.loader.prototype.options.textVisible = true;
	// jQuery.mobile.loader.prototype.options.theme = "a";

	// jQuery.extend( jQuery.mobile , {
	// 	ajaxEnabled: true,
	// 	defaultPageTransition: 'slide',
	// } );
} );
