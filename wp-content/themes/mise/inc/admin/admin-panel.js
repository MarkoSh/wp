(function($) {
	"use strict";
	$(document).ready(function() {

		$(".toggleTitle").click(function(){
			//$(".toggleText").slideToggle(200);
			//$(".singleToggle .dashicons").toggleClass('iconRotate');
			
			$(this).next().slideToggle(200).parent().toggleClass("active");
			return false;
			
		});

	});
})(jQuery);