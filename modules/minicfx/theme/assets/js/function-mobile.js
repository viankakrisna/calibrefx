jQuery(document).ready(function($) {
	
	$( '#super-wrapper' ).on( 'swiperight', function(){
		
		$( '#wrapper' ).addClass( 'm' );	

		return false;
	} );
	
	$( '#super-wrapper' ).on( 'swipeleft', function(){

		$( '#wrapper' ).removeClass( 'm' );	

		return false;
	} );


	/* 	Triggered after the page is successfully loaded and inserted into the DOM.	*/ 
	$( document ).on( "pageload", function() {
	} );


	/* 	Triggered when the page has been created in the DOM (via ajax or other)
	 	and after all widgets have had an opportunity to enhance the contained markup.	*/
	$( document ).on( "pagecreate", function() {

		var pages = $( 'body' ).find( '.ui-page' ),
			i = 0;

		$( '#lightbox' ).remove();

		$( '#lightboxOverlay' ).remove();

		for( ; i < pages.length; i++ ){

			if( ! $( pages[i] ).hasClass( 'ui-page-active' ) ){

			} else {

				$( pages[i] ).remove();
			}
		}

		setTimeout( function(){

			jQuery( '#lightbox' ).fadeOut( 'slow', function() {
			
			} );
		}, 1500 );
	} );


});

// 	TODO : Need localized script and settings here.
jQuery( document ).on( "mobileinit", function() {

	jQuery.extend( jQuery.mobile , {

		ajaxEnabled: true
	} );
} );