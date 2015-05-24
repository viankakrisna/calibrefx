jQuery(document).ready(function($) {
	
	function bindMenuEvent(){
		$( '.mobile-main-menu' ).bind( 'click touchstart', function() {
			$( '#wrapper' ).toggleClass( 'm' );

			return false;
		});

		$( '#super-wrapper' ).on( 'swiperight', function(){
			
			$( '#wrapper' ).addClass( 'm' );	

			return false;
		} );
		
		$( '#super-wrapper' ).on( 'swipeleft', function(){

			$( '#wrapper' ).removeClass( 'm' );	

			return false;
		} );

		$( '#mobile-nav .navbar-nav>li' ).append( '<span class="mobile-arrow"><i class="icon-mobile-arrow"></i></span>' );

		$( '#mobile-nav .navbar-nav>li span.mobile-arrow' ).bind( 'touchstart', function() {
			$this = $(this);
			$li = $this.parent();
			$anchor = $li.children( 'a' )
			$ul = $li.children( 'ul' );


			$allLi = $( '#mobile-nav .navbar-nav>li' );
			$allUl = $( '#mobile-nav .navbar-nav>li>ul' );

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
		console.log('pageload');
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

		bindMenuEvent();

	} );

	bindMenuEvent();
});

// 	TODO : Need localized script and settings here.
jQuery( document ).on( "mobileinit", function() {

	jQuery.extend( jQuery.mobile , {
		ajaxEnabled: true
	} );
} );