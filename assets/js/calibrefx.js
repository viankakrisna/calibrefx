( function() {
	var special = jQuery.event.special, uid1 = 'D' + (+new Date() ), uid2 = 'D' + (+new Date() + 1);
	special.scrollstart = {setup: function() {var timer, handler =  function(evt) {var _self = this, _args = arguments;if (timer) { clearTimeout(timer); } else { evt.type = 'scrollstart';jQuery.event.handle.apply(_self, _args);}timer = setTimeout( function() {timer = null;}, special.scrollstop.latency);};jQuery(this).bind( 'scroll', handler).data(uid1, handler);},teardown: function() {jQuery(this).unbind( 'scroll', jQuery(this).data(uid1) );}};
	special.scrollstop = {latency: 300,setup: function() {var timer, handler = function(evt) {var _self = this, _args = arguments;if (timer) {clearTimeout(timer);}timer = setTimeout( function() {timer = null;evt.type = 'scrollstop';jQuery.event.handle.apply(_self, _args);}, special.scrollstop.latency);};jQuery(this).bind( 'scroll', handler).data(uid2, handler);},teardown: function() { jQuery(this).unbind( 'scroll', jQuery(this).data(uid2) );}};
} )();

jQuery( window ).load( function() {
	if ( jQuery.isFunction(jQuery.fn.NProgress) ) {
   		NProgress.done();
	}
});


jQuery( document ).ready( function( $ ) {
	
	if ( typeof NProgress != "undefined" ) {
		NProgress.configure( { 
			ease: 'ease', speed: 1000,
			trickle: false,
			showSpinner: false,
			parent: ':not(.mobile) > #wrapper'
		} );
		NProgress.start();
	}
	
	// function to invoke for loaded image
	function imageLoaded() {
		if ( typeof NProgress != "undefined" ) {
			NProgress.inc();
		}
	}

	$( 'img' ).each(function() {
		if( this.complete ) {
			imageLoaded.call( this );
		} else {
			$(this).one( 'load', imageLoaded);
		}

	});

	$("#commentform, #calibrefx_contact_form").validate();
	
	$( '#header .menu, .superfish' ).superfish({
		cssArrows: false,
		delay: 200
	});
	
	$( '.scrolltop a' ).click(function(e) {
		e.preventDefault()
		$( 'html, body' ).animate({scrollTop: '0px'}, 800);
	});
	
	$( 'body' ).tooltip({
		selector: "a[data-toggle=tooltip], label.form-tooltip, #wp-calendar a"
	});

	$( '#content .entry-content table:not(.no-table-style), #comments .comment-content table:not(.no-table-style)' ).addClass( 'table table-bordered' ).wrap( '<div class="table-responsive"></div>' );

	$( '#commentform #submit' ).addClass( 'btn btn-primary' );


	$( '.mobile-main-menu' ).bind( 'click touchstart', function() {
		$( '#wrapper' ).toggleClass( 'm' );

		return false;
	});

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

	function check_focus(elm,val){
		if(elm.value.toLowerCase() == val.toLowerCase()){
			elm.value = '';    
		}
	}

	function check_blur(elm,val){
		if(elm.value.toLowerCase() == ''){
			elm.value = val;    
		}
	}

});
