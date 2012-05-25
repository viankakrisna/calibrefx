$(function() {		  
	$.fn.extend({ 	
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
  
	jQuery('.ltt-tooltip').each(function() {
		jQuery(this).ltttooltip();
	});
});