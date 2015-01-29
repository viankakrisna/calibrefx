jQuery(document).ready(function($){

	/***************** IMAGES ANIMATION ******************/
	$('img.img-with-animation').each(function() {

		$(this).appear(function() {
			if($(this).attr('data-animation') == 'fade-in-from-left'){
				$(this).delay($(this).attr('data-delay')).animate({
					'opacity' : 1,
					'left' : '0px'
				},800,'easeOutSine');
			} else if($(this).attr('data-animation') == 'fade-in-from-right'){
				$(this).delay($(this).attr('data-delay')).animate({
					'opacity' : 1,
					'right' : '0px'
				},800,'easeOutSine');
			} else if($(this).attr('data-animation') == 'fade-in-from-bottom'){
				$(this).delay($(this).attr('data-delay')).animate({
					'opacity' : 1,
					'bottom' : '0px'
				},800,'easeOutSine');
			} else if($(this).attr('data-animation') == 'fade-in') {
				$(this).delay($(this).attr('data-delay')).animate({
					'opacity' : 1
				},800,'easeOutSine');	
			} else if($(this).attr('data-animation') == 'grow-in') {
				var $that = $(this);
				setTimeout(function(){ 
					$that.transition({ scale: 1, 'opacity':1 },900,'cubic-bezier(0.15, 0.84, 0.35, 1.25)');
				},$that.attr('data-delay'));
			}
		
		},{accX: 0, accY: -105},'easeInCubic');

	});

});