jQuery(document).ready(function($){

	$('#menuBars').click(function(){
		$('#mobileMenu').slideToggle();
	});

	$(function(){
		$(window).resize(function(){
			if($(window).width() > 768){
				$('#mobileMenu').hide();
			}
		}).resize();
	});

});
