(function($) {
	"use strict";
	$(window).load(function() {
		if ( $( '.flexslider' ).length ) {
		  $('.flexslider').flexslider({
			animation: "fade",
			controlNav: false,
			slideshowSpeed: 7000,
			animationSpeed: 1000, 
			pauseOnHover: true, 		
		  });
		}
	});
	$(document).ready(function() {
		/*-----------------------------------------------------------------------------------*/
		/*  Page Loader
		/*-----------------------------------------------------------------------------------*/ 
			if ( $( '.miseLoader' ).length ) {
				$('.miseLoader').delay(600).fadeOut(1000);
			}
		/*-----------------------------------------------------------------------------------*/
		/*  Detect Mobile Browser
		/*-----------------------------------------------------------------------------------*/
			var mobileDetect = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
		/*-----------------------------------------------------------------------------------*/
		/*  Set height of featured image and onepage
		/*-----------------------------------------------------------------------------------*/ 
			function setHeight() {
				if ( $( '.miseBigImage' ).length ) {
					var windowHeight = $(window).innerHeight() / 1.5;
					var imageHeight = $('header.site-header').outerHeight();
					$('.miseBigImage').css({
					  'height': windowHeight
					});
					$('#content.site-content').css({
						'padding-top' : '3em'
					});
				}
			};
			function setHeightOnepage() {
				if ( $( '.flexslider' ).length ) {
					var windowHeight = $(window).innerHeight() / 1.5;
					var imageHeight = $('header.site-header').outerHeight();
					$('.flexslider, .flexslider .slides > li .flexText .inside, .flexslider .slides li .flexImage').css({
					  'height': windowHeight
					});
					$('#content.site-content').css({
						'padding-top' : '0em'
					});
				}
			};
			function setHeightServices() {
				if($('body').hasClass('page-template-template-onepage')) {
					if ( $( 'section.mise_services' ).length ) {
						var servicesHeight = $('.singleServiceContent').outerHeight();
						$('.serviceContent').css({
						  'height': servicesHeight
						});
					}
				}
			}
			setHeight();
			setHeightOnepage();
			setHeightServices();
		/*-----------------------------------------------------------------------------------*/
		/*  Check if featured image exist
		/*-----------------------------------------------------------------------------------*/ 
			if ( $( '.miseBigImage, .flexslider' ).length ) {
			} else {
				$('header.site-header').addClass('noImage');
			}
		/*-----------------------------------------------------------------------------------*/
		/*  Set nanoscroller
		/*-----------------------------------------------------------------------------------*/ 
			function setNano() {
				if ( $( '#tertiary.widget-area' ).length ) {
					$(".nano").nanoScroller({ preventPageScrolling: true });
				}
			};
			setNano();
		/*-----------------------------------------------------------------------------------*/
		/*  Sidebar Push Button
		/*-----------------------------------------------------------------------------------*/ 
			$('.hamburger, .opacityBox').click(function(){
				$('body, #tertiary.widget-area, .push-background, .opacityBox, .hamburger').toggleClass('yesOpen');
			});
		/*-----------------------------------------------------------------------------------*/
		/*  Search Button
		/*-----------------------------------------------------------------------------------*/ 
			$( '.mainStuff, .opacityBoxSearch' ).click(function() {
			  $('.mainStuff, .opacityBoxSearch, .search-container').toggleClass('open');
			});
		/*-----------------------------------------------------------------------------------*/
		/*  Home icon in main menu
		/*-----------------------------------------------------------------------------------*/ 
			if($('body').hasClass('rtl')) {
				$('.main-navigation .menu-item-home:first-child > a').append('<i class="fa fa-home spaceLeft"></i>');
			} else {
				$('.main-navigation .menu-item-home:first-child > a').prepend('<i class="fa fa-home spaceRight"></i>');
			}
		/*-----------------------------------------------------------------------------------*/
		/*  Scroll to section
		/*-----------------------------------------------------------------------------------*/ 
			$('ul.menu a[href*="#"]:not([href="#"])').click(function() {
				if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
				  var target = $(this.hash);
				  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
				  if (target.length) {
					$('html, body').animate({
					  scrollTop: target.offset().top
					}, 1000);
					return false;
				  }
				}
			});
		/*-----------------------------------------------------------------------------------*/
		/*  Menu Widget
		/*-----------------------------------------------------------------------------------*/
			if ( $( 'aside ul.menu' ).length ) {
				$('aside ul.menu').find("li").each(function(){
					if($(this).children("ul").length > 0){
						$(this).append("<span class='indicatorBar'></span>");
					}
				});
				$('aside ul.menu > li.menu-item-has-children .indicatorBar, .aside ul.menu > li.page_item_has_children .indicatorBar').click(function() {
					$(this).parent().find('> ul.sub-menu, > ul.children').toggleClass('yesOpenBar');
					$(this).toggleClass('yesOpenBar');
					var $self = $(this).parent();
					if($self.find('> ul.sub-menu, > ul.children').hasClass('yesOpenBar')) {
						$self.find('> ul.sub-menu, > ul.children').slideDown(300);
					} else {
						$self.find('> ul.sub-menu, > ul.children').slideUp(200);
					}
				});
			}
		/*-----------------------------------------------------------------------------------*/
		/*  Mobile Menu
		/*-----------------------------------------------------------------------------------*/ 
			if ($( window ).width() <= 1024) {
				$('.main-navigation').find("li").each(function(){
					if($(this).children("ul").length > 0){
						$(this).append("<span class='indicator'></span>");
					}
				});
				$('.main-navigation ul > li.menu-item-has-children .indicator, .main-navigation ul > li.page_item_has_children .indicator').click(function() {
					$(this).parent().find('> ul.sub-menu, > ul.children').toggleClass('yesOpen');
					$(this).toggleClass('yesOpen');
					var $self = $(this).parent();
					if($self.find('> ul.sub-menu, > ul.children').hasClass('yesOpen')) {
						$self.find('> ul.sub-menu, > ul.children').slideDown(300);
					} else {
						$self.find('> ul.sub-menu, > ul.children').slideUp(200);
					}
				});
			}
			$(window).resize(function() {
				if ($( window ).width() > 1024) {
					$('.main-navigation ul > li.menu-item-has-children, .main-navigation ul > li.page_item_has_children').find('> ul.sub-menu, > ul.children').slideDown(300);
				}
			});
		/*-----------------------------------------------------------------------------------*/
		/*  Waypoints general script
		/*-----------------------------------------------------------------------------------*/ 
		if($('body').hasClass('page-template-template-onepage')) {
			if ( $.isFunction($.fn.waypoint) ) {
				/*-----------------------------------------------------------------------------------*/
				/*  Waypoints for skills
				/*-----------------------------------------------------------------------------------*/ 
				$('section.mise_skills').waypoint(function() {
					$('.skillBottom .skillRealBar').each( function() {
					var $this = $(this)
						setTimeout(function() {
							$this.css('width',$this.data('number'))
						}, $this.data('delay'));
					});
					$('.skillTop .skillValue').each( function() {
					var $this = $(this)
						setTimeout(function() {
							$this.css({'opacity':'1', 'bottom': '-5px'});
						}, 1000 + $this.data('delay'));
					});
				},{
					triggerOnce: true,
					offset: '60%',
				});
				/*-----------------------------------------------------------------------------------*/
				/*  Waypoints for contact icon
				/*-----------------------------------------------------------------------------------*/ 
				$('section.mise_contact').waypoint(function() {
					$('.contact_columns .miseContactIcon').css({'opacity':'0.1', 'left': '25px'});
				},{
					triggerOnce: true,
					offset: '20%',
				});
			}
		}
		/*-----------------------------------------------------------------------------------*/
		/*  Detect Mobile Browser
		/*-----------------------------------------------------------------------------------*/ 
			if ( !mobileDetect ) {
				/*-----------------------------------------------------------------------------------*/
				/*  Header Parallax
				/*-----------------------------------------------------------------------------------*/ 
					$( '.miseBigImage' ).data( 'height', $( '.miseBigImage' ).outerHeight() );
					$( window ).scroll( function( event ) {
						var position = window.scrollY,
							bottom   = window.innerHeight - document.getElementById( 'colophon' ).offsetHeight,
							height   = $( '.miseBigImage' ).data( 'height' ),
							content  = $( '#content' ).offset().top,
							footer   = $( '#colophon' ).offset().top - position;

						if ( position > 0 && content > position && footer > bottom ) {
							if ( position < height ) {
								$( '.miseBigText header.entry-header' ).css({
									'bottom' : ( 0 + position / 4)
								});
								$('.miseBigImage').css({
									'opacity' : ( 1 - position / height * 1 )
								});
							}
						} else if ( position <= 0 ) {
							$( '.miseBigText header.entry-header' ).css({
								'bottom' : 0
							});
							$('.miseBigImage').css({
								'opacity' : 1
							});
						}
					});
				/*-----------------------------------------------------------------------------------*/
				/*  Set resize
				/*-----------------------------------------------------------------------------------*/ 
					$(window).resize(function() {
						setHeight();
						setHeightOnepage();
						setNano();
						setHeightServices();
					});
				/*-----------------------------------------------------------------------------------*/
				/*  Menu Fixed
				/*-----------------------------------------------------------------------------------*/ 
					var $filter = $('header.site-header');
					if ($filter.size()) {
						$(window).scroll(function () {
							if (!$filter.hasClass('menuMinor') && $(window).scrollTop() > 0 ) {
								$filter.addClass("menuMinor");
								$('body').addClass('menuMinor');
								$('.site-branding .site-description').slideUp(200);
							} else if ($filter.hasClass('menuMinor') && $(window).scrollTop() <= 0 ) {
								$filter.removeClass("menuMinor");
								$('body').removeClass('menuMinor');
								$('.site-branding .site-description').slideDown(200);
							}
						});
					}
				/*-----------------------------------------------------------------------------------*/
				/*  Social Buttons Float
				/*-----------------------------------------------------------------------------------*/ 
					if ( $( '.site-social ' ).length ) {
						if ( $( '.miseBigImage' ).length ) {
							$(window).scroll(function () {
								if ($(window).scrollTop() >= $('.miseBigImage').outerHeight() ) {
									$('.site-social').addClass('showSocial');
								} else {
									$('.site-social').removeClass('showSocial');
								}
							});
						} else if ( $( '.flexslider' ).length ) {
							$(window).scroll(function () {
								if ($(window).scrollTop() >= $('.flexslider').outerHeight() ) {
									$('.site-social').addClass('showSocial');
								} else {
									$('.site-social').removeClass('showSocial');
								}
							});
						} else {
							$('.site-social').addClass('showSocial');
						}
					}
				/*-----------------------------------------------------------------------------------*/
				/*  Scroll Down button
				/*-----------------------------------------------------------------------------------*/ 
					if ( $( '.scrollDown' ).length ) {
						$('.scrollDown').click(function(){
							$("html, body").animate({ scrollTop: $('.miseBigImage, .mise_slider').outerHeight() }, 1000);
							return false;
						});
					}
				/*-----------------------------------------------------------------------------------*/
				/*  Scroll To Top
				/*-----------------------------------------------------------------------------------*/ 
					$(window).scroll(function(){
						if ($(this).scrollTop() > 700) {
							$('#toTop').addClass('visible');
						} 
						else {
							$('#toTop').removeClass('visible');
						}
					}); 
					$('#toTop').click(function(){
						$("html, body").animate({ scrollTop: 0 }, 1000);
						return false;
					});
			}
	});
})(jQuery);