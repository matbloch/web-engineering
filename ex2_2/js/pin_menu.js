jQuery(document).ready(function($) {

/*------------------------------------*\
    PIN MENU
\*------------------------------------*/

(function ( $ ) {

	$.fn.pinMenu = function( options ) {
	
		/* default settings */
		var settings = $.extend({
			fadeout_opacity: 0.4,
			drag_block: 200,
			sticking_delay: 300,
			sticking_margin: 20,
			stick_to_corner: 0,
			stick_to_side:1
		}, options );
		
		/* setup selectors */
		var $selectors = {};
		
		$selectors.container = $( this );
		$selectors.stick = $selectors.container.find("[data-fn='stick']");
		$selectors.openClose = $selectors.container.find("[data-fn='open_close']");
		$selectors.items = $selectors.container.find(".items");
		$selectors.content = $selectors.container.find(".content");
		
		/* plugin status */
		var status = {
			'window_width' : $(window).width(),
			'menu_height' : $selectors.container.outerHeight(),
			'menu_width' : $selectors.container.outerWidth(),
			'sticked' : 0,
			'dragging' : 0
		}
		
		
		/* methods */
		var methods = {};
		
		/* open/close the menu */
		methods.openClose = function (e){

			e.preventDefault();
			
			console.log(status.dragging);
			
			if(status.dragging == 1){
				return;
			}
			
			/* back to initial size */
			if($selectors.container.hasClass('closed')){
				$selectors.container.animate({"height":status.menu_height+"px","width":status.menu_width+"px"}, 500);
				$selectors.content.fadeIn(500);
			}else{
				$selectors.container.animate({"height":"41px","width":"41px"}, 500);
				$selectors.content.fadeOut(500);
			}
			
			$selectors.container.toggleClass('closed');

		}
		
		/* handle the menu opacity */
		methods.hoverOpacity = function (e){

			$selectors.container.stop(true).animate({opacity: settings.fadeout_opacity}, 300)
		
			$selectors.container.mouseover(function() {
				if(status.dragging == 1){return;}
				$(this).stop(true).animate({opacity: 1.0}, 200);
			  });
			$selectors.container.mouseout(function() {
				if(status.dragging == 1){return;}
				$(this).stop(true).animate({opacity: settings.fadeout_opacity}, 300);
			  });
		}
		
		/* stick the menu to the side */
		methods.stickToSide = function (e){
			
			if(status.sticked == 1){return;}
			
			setTimeout(function() {
			
				// check position
				var windowWidth = $(window).width(); //retrieve current window width
				var windowHeight = $(window).height(); //retrieve current window height
				var position = $selectors.container.position();
				var l = r = t = b = 0;

				// stick to nearest side
				if(settings.stick_to_side){
					l = position.left;
					r = windowWidth - l - $selectors.container.width();
					t = position.top;
					b = windowHeight - t - $selectors.container.height();
					
					var margins = [l,r,t,b];
					var i = margins.indexOf(Math.min.apply(Math, margins));
					margins = [0,0,0,0];
					margins[i] = 1;
					
					// animate
					if(margins[0]){
						$selectors.container.animate({"left":settings.sticking_margin+"px"}, 500).css({'right':'auto'});
					}else if(margins[1]){
						$selectors.container.animate({"right":settings.sticking_margin+"px"}, 500).css({'left':'auto'});
					}else if(margins[2]){
						$selectors.container.animate({"top":settings.sticking_margin+"px"}, 500).css({'bottom':'auto'});
					}else if(margins[3]){
						$selectors.container.animate({"bottom":settings.sticking_margin+"px"}, 500).css({'top':'auto'});
					}
					
				}

				// stick to corner
				if(settings.stick_to_corner){
					// vertical
					if(position.left < windowWidth/2){
						l = 1;
					}else{
						l = 0;
					}
					
					// horizontal
					if(position.top < windowHeight/2){
						t = 1;
					}else{
						t = 0;
					}
					
					// animate
					if(t && l){
						$selectors.container.animate({"left":settings.sticking_margin+"px","top":settings.sticking_margin+"px"}, 500).css({'right':'auto','bottom':'auto'});
					}else if(t && !l){
						$selectors.container.animate({"right":settings.sticking_margin+"px","top":settings.sticking_margin+"px"}, 500).css({'left':'auto','bottom':'auto'});
					}else if(!t && l){
						$selectors.container.animate({"left":settings.sticking_margin+"px","bottom":settings.sticking_margin+"px"}, 500).css({'right':'auto','top':'auto'});
					}else if(!t && !l){
						$selectors.container.animate({"right":settings.sticking_margin+"px","bottom":settings.sticking_margin+"px"}, 500).css({'left':'auto','top':'auto'});
					}
				}
				

			}, settings.sticking_delay);
			
		}

		methods.init = function (){

			// make drageable
			$selectors.container.draggable({
				start: function(e) {
					status.dragging = 1;
				},
				stop: function(event, ui) {

					setTimeout(function() {
						status.dragging = 0;
						methods.stickToSide();
					}, settings.drag_block);
				}
			});
		
			// open/close
			$selectors.openClose.bind('click',methods.openClose);
			
			// opacity
			//methods.hoverOpacity();

		}
		
		// start the plugin
		methods.init();
		
	};
	
}( jQuery ));

$('#hover_nav').pinMenu({});


});


