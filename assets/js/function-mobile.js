jQuery(document).ready(function($) {
	
	$( '#super-wrapper' ).on( 'swiperight', function(){
		
		$( '#wrapper' ).addClass( 'm' );	

		return false;
	} );
	
	$( '#super-wrapper' ).on( 'swipeleft', function(){

		$( '#wrapper' ).removeClass( 'm' );	

		return false;
	} );

});