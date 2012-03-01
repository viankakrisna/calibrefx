jQuery(document).ready(function($) {
	
	// Array: selector of toggle element, selector of element to show/hide, checkable value for select || null
	var calibrefx_toggles = [
		// Checkbox toggles
		['#calibrefx-settings\\[content_archive\\]', '#calibrefx_content_limit_setting', 'full']
	];

	$.each( calibrefx_toggles, function( k, v ) {
		$( v[0] ).live( 'change', function() {
			calibrefx_toggle_settings( v[0], v[1], v[2] );
		});
		calibrefx_toggle_settings( v[0], v[1], v[2] ); // Check when page loads too.
	});
	
	function calibrefx_toggle_settings( selector, show_selector, check_value ) {
		if (
			( check_value === null && $( selector ).is( ':checked' ) ) ||
			( check_value !== null && $( selector ).val() === check_value )
		) {
			$( show_selector ).slideDown( 'fast' );
		} else {
			$( show_selector ).slideUp( 'fast' );
		}
	}
	
	$('.calibrefx-layout-selector input[type="radio"]').change(function() {
	    var tmp=$(this).attr('name');
	    $('input[name="'+tmp+'"]').parent("label").removeClass("selected");
	    $(this).parent("label").toggleClass("selected", this.selected);      
	});
	
	$('#calibrefx-admin-bar').sticky({topSpacing:0,center:true, className: 'sticky'});
});

function calibrefx_confirm( text ) {
	var answer = confirm( text );

	if( answer ) { return true; }
	else { return false; }
}