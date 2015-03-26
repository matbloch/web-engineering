jQuery(document).ready(function($) {

/*------------------------------------*\
    PIN MENU
\*------------------------------------*/

(function ( $ ) {

	$.fn.pinMenu = function( options ) {
	
		/* default settings */
		var settings = $.extend({
			drag_block: 200,	// delay to fix fast drag movement
			sticking_delay: 2000,	// delay before menu sticks to side
			sticking_margin: 20,	// sticking margin
			stick_to_corner: 0, 	
			stick_to_side:1		// stick to the nearest browser side
		}, options );
		
		/* setup selectors */
		var $selectors = {};
		
		$selectors.container = $( this );
		$selectors.stick = $selectors.container.find("[data-fn='stick']");
		$selectors.pin = $selectors.container.find("[data-fn='pin']");
		$selectors.openClose = $selectors.container.find("[data-fn='open_close']");
		$selectors.items = $selectors.container.find(".items");
		$selectors.content = $selectors.container.find(".content").add($selectors.pin);
		
		/* plugin status */
		var status = {
			'window_width' : $(window).width(),
			'menu_height' : $selectors.container.outerHeight(),
			'menu_width' : $selectors.container.outerWidth(),
			'sticked' : 0,
			'pinned' : 0,
			'dragging' : 0,
			'in_animation' : 0
		}
		
		/* methods */
		var methods = {};
		
		/* open/close the menu */
		methods.openClose = function (e){

			e.preventDefault();
			
			if(status.dragging || status.in_animation){ return;}
			
			// handle animation lock
			status.in_animation = 1; setTimeout(function() {status.in_animation = 0;}, 500);
			
			// change size
			if($selectors.container.hasClass('closed')){
				// back to initial size
				$selectors.container.animate({"height":status.menu_height+"px","width":status.menu_width+"px"}, 500);
				$selectors.content.fadeIn(500);
			}else{
				$selectors.container.animate({"height":"41px","width":"41px"}, 500);
				$selectors.content.fadeOut(500);
			}
			
			// toggle status class
			$selectors.container.toggleClass('closed');

		}
		
		methods.pin = function (e){
			
			e.preventDefault();
			
			// toggle status
			status.pinned = !status.pinned;
			
			// toggle button
			$selectors.pin.toggleClass('active');
		
		}
		
		/* stick the menu to the side */
		methods.stickToSide = function (e){
			
			// always abort if on hover
			if ($selectors.container.is(":hover")) {return;}
			
			// don't stick to side, if the menu is pinned, an animation is running,already sticked, or beeing draged
			if(status.sticked || status.dragging || status.pinned || status.in_animation){return;}
			
			 console.log('===== now stick');
			
			// handle animation lock
			status.in_animation = 1; setTimeout(function() {status.in_animation = 0;}, 500);
			
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
		}
		
		/* timing helpers */	
		methods.start_sticking = function (){
		
			$selectors.container.mouseleave(function() {

				if(status.dragging || status.in_animation || status.sticking){ return;}

				console.log('---mouse leave');

				setTimeout(function() {
				methods.stickToSide();
				}, settings.sticking_delay);	// add small delay
				
			});

		}

		/* adds the functionalities to the menu */
		methods.init = function (){

			// add functionality: drageable
			$selectors.container.draggable({
				start: function(e) {
					// set draging lock
					status.dragging = 1;
				},
				stop: function(event, ui) {
					// release draging lock (fast movements lead to mouseout)
					setTimeout(function() {status.dragging = 0;}, settings.drag_block);
				}
			});
		
			// add functionality: open/close
			$selectors.openClose.bind('click',methods.openClose);
			
			// add functionality: pinning
			$selectors.pin.bind('click',methods.pin);
			
			// add functionality: sticking to window side
			methods.start_sticking();

		}
		
		// start the plugin
		methods.init();
		
	};
	
}( jQuery ));

/* initiate on DOM  element */
$('#hover_nav').pinMenu({});


});


