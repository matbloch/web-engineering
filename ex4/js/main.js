jQuery(document).ready(function($) {

var map = { "img1" : 1, "img2" : 2, "img3" : 3 , "img4" : 4}
var map_info = { "img1" : "ETH Terrasse", "img2" : "ETH Main Building, interior", "img3" : "ETH Main Building", "img4" : "ETH Main Building 2"}

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
		
		/* status */
		var status = {

		}
		
		/* methods */
		var methods = {};
		
		/* init */
		methods.init = function (){

		}
		
		/* start */
		methods.init();
		
	};
	
}( jQuery ));

/* initiate on DOM  element */
$('body').MobileApp({});


});


