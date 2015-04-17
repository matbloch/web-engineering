jQuery(document).ready(function($) {

var map = { "img1" : 1, "img2" : 2, "img3" : 3 , "img4" : 4};
var map_info = { "img1" : "ETH Terrasse", "img2" : "ETH Main Building, interior", "img3" : "ETH Main Building", "img4" : "ETH Main Building 2"};

/*------------------------------------*\
    TILT AND TAP
\*------------------------------------*/

(function ( $ ) {

	$.fn.MobileApp = function( options ) {
	
		/* default settings */
		var settings = $.extend({
			drag_block: 100,	// delay to fix fast drag movement
		}, options );
		
		/* setup selectors */
		var $selectors = {};
		
		$selectors.container = $( this );
		$selectors.thumbs_block = $selectors.container.find('#thumbs-block');
		$selectors.thumbs_wrp = $selectors.thumbs_block.find('.wrp');
		$selectors.thumbs = $selectors.thumbs_wrp.find('img');
		
		$selectors.zoom_container = $selectors.container.find('div#touch');
		$selectors.info_container = $selectors.zoom_container.find('p#info');
		
		/* status */
		var status = {
			'current_item' : 0,
			'next_item' : 1,
			'previous_item' : 0,
			'is_zoomed' : 0,
			'show_info' : 0
		} 
		
		/* methods */
		var methods = {};
		
		methods.update_item_position = function(){
			status.current_item = $selectors.thumbs.filter('.selected').closest('div.wrp').index();
			status.next_item = (status.current_item == $selectors.thumbs_wrp.length-1 ? status.current_item:status.current_item+1 );
			status.previous_item = (status.current_item == 0 ? 0:1 );
		}
		
		methods.update_zoomed_item = function (){
			// clone current item into div "touch" and add ".centerimg" class to image

			// remove any images
			$selectors.zoom_container.find('img').remove();
			
			if(!status.is_zoomed){return};

			// update image if in zoom mode
			var $img = $selectors.thumbs_wrp.eq(status.current_item).find('img').clone().removeClass().addClass('centerimg');
			$selectors.zoom_container.prepend($img);
			
			status.is_zoomed = 1;

		}
		
		methods.update_current_item_info = function (){
		
			$selectors.info_container.html();

			if(!status.show_info){return;}
			
			// add info of current image
			var map_key = Object.keys(map).filter(function(key) {return map[key] == (status.current_item+1)})[0];
			$selectors.info_container.html(map_info[map_key]);
		}
		
		
		/* main function calls */
		
		methods.show_zoomed_image = function (){
			status.is_zoomed = 1;
			$selectors.container.trigger('galleryModeChange');
		}
		methods.hide_zoomed_image = function (){
			status.is_zoomed = 0;
			$selectors.container.trigger('galleryModeChange');
		}
		methods.toggle_zoomed_image = function (){
			status.is_zoomed = (status.is_zoomed==1?0:1);
			$selectors.container.trigger('galleryModeChange');
		}
		methods.show_info = function (){
			status.show_info = 1;
			$selectors.container.trigger('infoChange');
		}
		methods.hide_info = function (){
			status.show_info = 0;
			$selectors.container.trigger('infoChange');
		}
		methods.toggle_info = function (){
			status.show_info = (status.show_info==1?0:1);
			$selectors.container.trigger('infoChange');
		}
		methods.show_next_item = function (){
			$selectors.thumbs_wrp.eq(status.current_item).find('img').removeClass('selected').addClass('notselected');
			$selectors.thumbs_wrp.eq(status.next_item).find('img').removeClass('notselected').addClass('selected');
			$selectors.container.trigger('itemChange');
		}
		methods.show_previous_item = function (){
			$selectors.thumbs_wrp.eq(status.current_item).find('img').removeClass('selected').addClass('notselected');
			$selectors.thumbs_wrp.eq(status.previous_item).find('img').removeClass('notselected').addClass('selected');
			$selectors.container.trigger('itemChange');
		}
		
		/* init */
		methods.init = function (){
			
			// update position: when item is changed
			$selectors.container.bind('itemChange', methods.update_item_position);
			// update zoom image: when gallery mode or item is changed
			$selectors.container.bind('itemChange galleryModeChange', methods.update_zoomed_item);
			// update info: when item or infomode is changed
			$selectors.container.bind('itemChange infoChange', methods.update_current_item_info);

			// test methods
			methods.show_info();

				
			/*
			TODO: bind tilt-and-tap plugin to main functions
			*/
			
		}
		
		/* start */
		methods.init();
		
	};
	
}( jQuery ));

/* initiate on DOM  element */
$('body').MobileApp({});


});


