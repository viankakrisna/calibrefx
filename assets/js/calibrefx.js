(function(){
var special = jQuery.event.special, uid1 = 'D' + (+new Date()), uid2 = 'D' + (+new Date() + 1);
special.scrollstart = {setup: function() {var timer, handler =  function(evt) {var _self = this, _args = arguments;if (timer) { clearTimeout(timer); } else { evt.type = 'scrollstart';jQuery.event.handle.apply(_self, _args);}timer = setTimeout( function(){timer = null;}, special.scrollstop.latency);};jQuery(this).bind('scroll', handler).data(uid1, handler);},teardown: function(){jQuery(this).unbind( 'scroll', jQuery(this).data(uid1) );}};
special.scrollstop = {latency: 300,setup: function() {var timer, handler = function(evt) {var _self = this, _args = arguments;if (timer) {clearTimeout(timer);}timer = setTimeout( function(){timer = null;evt.type = 'scrollstop';jQuery.event.handle.apply(_self, _args);}, special.scrollstop.latency);};jQuery(this).bind('scroll', handler).data(uid2, handler);},teardown: function() { jQuery(this).unbind( 'scroll', jQuery(this).data(uid2) );}};
})();

jQuery(document).ready(function($) {
	$("#commentform, #calibrefx_contact_form").validate();
	
	$('#header .menu, .superfish').superfish({
		cssArrows: false,
		delay: 200
	});
	
	$('.scrolltop a').click(function(e){
		e.preventDefault()
		$('html, body').animate({scrollTop: '0px'}, 800);
	});
	
	$('body').tooltip({
      	selector: "a[data-toggle=tooltip], label.form-tooltip, #wp-calendar a"
    });

    $('#content .entry-content table:not(.no-table-style), #comments .comment-content table:not(.no-table-style)').addClass('table table-bordered').wrap('<div class="table-responsive"></div>');

    $('#commentform #submit').addClass('btn btn-primary');


	$('.mobile-main-menu').bind('click touchstart', function(){
		$('#wrapper').toggleClass('m');

		return false;
	});
});