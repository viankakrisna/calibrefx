(function(){
var special = jQuery.event.special, uid1 = 'D' + (+new Date()), uid2 = 'D' + (+new Date() + 1);
special.scrollstart = {setup: function() {var timer, handler =  function(evt) {var _self = this, _args = arguments;if (timer) { clearTimeout(timer); } else { evt.type = 'scrollstart';jQuery.event.handle.apply(_self, _args);}timer = setTimeout( function(){timer = null;}, special.scrollstop.latency);};jQuery(this).bind('scroll', handler).data(uid1, handler);},teardown: function(){jQuery(this).unbind( 'scroll', jQuery(this).data(uid1) );}};
special.scrollstop = {latency: 300,setup: function() {var timer, handler = function(evt) {var _self = this, _args = arguments;if (timer) {clearTimeout(timer);}timer = setTimeout( function(){timer = null;evt.type = 'scrollstop';jQuery.event.handle.apply(_self, _args);}, special.scrollstop.latency);};jQuery(this).bind('scroll', handler).data(uid2, handler);},teardown: function() { jQuery(this).unbind( 'scroll', jQuery(this).data(uid2) );}};
})();

jQuery(document).ready(function($) {
	jQuery("#commentform").validate();
	
	// jQuery('#header .menu, .superfish').superfish({
	// 	delay:       200,								// 0.1 second delay on mouseout 
	// 	animation:   {opacity:'show',height:'show'},	// fade-in and slide-down animation 
	// 	dropSadows: false							// disable drop shadows 
	// });
	
	jQuery('.scrolltop a').click(
		function (e) {
			e.preventDefault()
			$('html, body').animate({scrollTop: '0px'}, 800);
		}
	);
	
	jQuery.fn.extend({ 	
		ltttooltip: function() {		
			var bubble = this;			
			this.hover(function() {				
				bubble.children('span').children('span').css({ display: 'block' });
				bubble.children('span').stop().css({ display: 'block', opacity: 0, bottom: '30px' }).animate({ opacity: 1, bottom: '40px' }, 200);				
			}, function() {				
				bubble.children('span').stop().animate({ opacity: 0, bottom: '50px' }, 200, function() {					
					jQuery(this).hide();					
				});				
			});			
		}
	});         
  
	jQuery('body').tooltip({
      	selector: "a[data-toggle=tooltip]"
    });
	
	jQuery(".ltt-toggler.closed .ltt-toggle-container").hide(); 
	jQuery(".ltt-toggler.open .ltt-toggle-container").show();
	jQuery(".ltt-toggler.open .ltt-trigger").addClass("active");

	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	jQuery(".ltt-trigger").click(function(){
		jQuery(this).toggleClass("active").next().slideToggle("slow");
		return false; //Prevent the browser jump to the link anchor
	});
});