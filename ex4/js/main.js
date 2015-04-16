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
			'is_zoomed' : 0
		} 
		
		/* methods */
		var methods = {};
		
		
		methods.update_item_position = function(){
			status.current_item = $selectors.thumbs.filter('.selected').closest('div.wrp').index();
			status.next_item = (status.current_item == $selectors.thumbs_wrp.length-1 ? status.current_item:status.current_item+1 );
			status.previous_item = (status.current_item == 0 ? 0:1 );
		}
		
		methods.show_hide_zoomed_item = function (){
			// clone current item into div "touch" and add ".centerimg" class to image

			// remove any images
			$selectors.zoom_container.find('img').remove();
			
			if(!status.is_zoomed){return};

			// update image if in zoom mode
			var $img = $selectors.thumbs_wrp.eq(status.current_item).find('img').clone().removeClass().addClass('centerimg');
			$selectors.zoom_container.prepend($img);
			
			status.is_zoomed = 1;

		}
		
		methods.show_hide_current_item_info = function (){
		
			$selectors.info_container.html();
			
			if(!status.is_zoomed){return;}
			
			// add info of current image
			$selectors.info_container.html(map.img1);
			
		}

		/* use this method with the tilt-tap events to toggle gallery mode */
		methods.toggle_gallery_mode = function (){
			if(status.is_zoomed == 1){
				status.is_zoomed = 0;
			}else{
				status.is_zoomed = 1;
			}
			$selectors.container.trigger('modeChange');
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
			
			// update position
			$selectors.container.bind('itemChange', methods.update_item_position);
			// update zoom image
			$selectors.container.bind('itemChange', 'modeChange', methods.show_hide_zoomed_item);
			// update info
			$selectors.container.bind('itemChange', methods.show_hide_current_item_info);

			
			/*
			TODO: bind tilt-and-tap plugin to toggle_gallery_mode, show_next_item, show_previous_item
			
			*/
			
		}
		
		/* start */
		methods.init();
		
	};
	
}( jQuery ));

/* initiate on DOM  element */
$('body').MobileApp({});


});


