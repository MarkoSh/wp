(function ($) {
    "use strict";
    $(document).ready(function () {
        function set_shop_sidebar_height() {
            var loop_height = $(".fix-shop-sidebar-wrapper .grand_popo-loop .products").outerHeight();
            var sidebar_height = $(".fix-shop-sidebar-wrapper .shop-sidebar").outerHeight();
            setTimeout(function () {
                if (sidebar_height <= loop_height) {
                    $(".fix-shop-sidebar-wrapper .shop-sidebar").css('height', loop_height);
                } else {
                    $(".fix-shop-sidebar-wrapper .shop-sidebar").css('height', 'auto');
                }
            }, 500);
        }
        set_shop_sidebar_height();
        $("img[data-src]").unveil();
        
        $(document).on('click touchstart', '#header-menu-icon', function () {
            $(this).css('transform', 'scale(0)');
            setTimeout(function () {
                $('#mobile-site-navigation').css('transform', 'translateX(0px)');
                $('#header-menu-mask').addClass('is-active');
            }, 200);
        });
        $(document).on('click touchstart', '#header-menu-close,#header-menu-mask', function () {
            $('#mobile-site-navigation').css('transform', 'translateX(-100%)');
            $('#header-menu-mask').removeClass('is-active');
            setTimeout(function () {
                $('#header-menu-icon').css('transform', 'scale(1)');
            }, 200);
        });
        $(document).on('click touchstart', '.mobile-nav-menu li.menu-item-has-children > a', function (e) {
            e.preventDefault();
            $(this).parent('.mobile-nav-menu li.menu-item-has-children').toggleClass('menu-item-open');
            $(this).siblings('ul.sub-menu').slideToggle('fast');
        });
        $(document).on('click touchstart', '.mobile-nav-menu li.page_item_has_children > a', function (e) {
            e.preventDefault();
            $(this).parent('.mobile-nav-menu li.page_item_has_children').toggleClass('menu-item-open');
            $(this).siblings('ul.children').slideToggle('fast');
        });
        $(window).load(function () {
            $("#site-navigation-wrap").mCustomScrollbar({
                axis: "y",
                theme: "minimal",
                scrollInertia: 300,
                advanced: {
                    autoScrollOnFocus: false,
                    updateOnContentResize: true
                }
            });
        });
        $('.page-size-container').on('change', 'select.autosubmit', function () {
            $(this).closest('form').submit();
        });
        
//        $(document).on('click touchstart', '.shop-view-tools', function () {
//            $('#shop-view-menu-mask-2').addClass('is-active');
//            $('.per-row-container').css('opacity', '1');
//            $('.per-row-container').css('visibility', 'visible');
//        });
//        $(document).on('click touchstart', '#shop-view-menu-mask-2', function () {
//            $('#shop-view-menu-mask-2').removeClass('is-active');
//            $('.per-row-container').css('opacity', '0');
//            $('.per-row-container').css('visibility', 'hidden');
//        });
        $(document).on('click touchstart', '#shop-view-menu-mask', function () {
            $('#shop-view-menu-mask').toggleClass('is-active');
            $('.per-row-container').css('opacity', '0');
            $('.per-row-container').css('visibility', 'hidden');
        });

        if ($('#woo-exist').hasClass('woo-exist')) {
            $('.wc-bf-loop-wrap select,.woocommerce div.product form.cart .variations select').select2({
                minimumResultsForSearch: -1
            });
        }
        ;
        var cart_box = $('.cart-detail');
        var cart_link = $('.mini-cart');
        $(document).on('click touchstart', '.mini-cart', function () {
            cart_box.toggle();
            return false;
        });
        $(document).on('click touchstart', function () {
            cart_box.hide();
        });
        $(document).on('click touchstart', '.cart-detail', function (e) {
            e.stopPropagation();
        });
        $(document.body).bind('added_to_cart', function (event, fragments, cart_hash) {
            cart_box.html(fragments["div.widget_shopping_cart_content"]);
            $(".cart-detail ul.cart_list").mCustomScrollbar({
                axis: "y",
                theme: "minimal-dark",
                scrollInertia: 300,
                advanced: {
                    autoScrollOnFocus: false,
                    updateOnContentResize: true
                }
            });
        });
        $("[name='update_cart']").after($(".wc-proceed-to-checkout"));
        var windowsize = $(window).width();

        function mobile_shop_sidebar_layout() {
            var windowsize = $(window).width();
            if (windowsize <= 768) {
                $(document).on('click touchstart', '#top-menu-icon', function () {
                    $(this).css('transform', 'scale(0)');
                    setTimeout(function () {
                        $('#secondary.shop-sidebar').addClass('mobile-shop-sidebar');
                        $('#shop-view-menu-mask').addClass('fixed is-active');
                    }, 200);
                });
                $(document).on('click touchstart', '#top-menu-close,#shop-view-menu-mask.fixed.is-active', function () {
                    $('#secondary.shop-sidebar').removeClass('mobile-shop-sidebar');
                    $('.grand_popo-loop').css('float', 'none');
                    $('.grand_popo-loop').css('width', '100%');
                    $('#shop-view-menu-mask').removeClass('fixed is-active');
                    setTimeout(function () {
                        $('#top-menu-icon').css('transform', 'scale(1)');
                    }, 200);
                });
            } else {
                $(document).on('click touchstart', '#top-menu-icon', function () {
                    $(this).css('transform', 'scale(0)');
                    setTimeout(function () {
                        $('#secondary.shop-sidebar').css('transform', 'translateX(0)');
                        $('#secondary.shop-sidebar').css('display', 'block');
                        if ($('.grand_popo-loop-wrap').hasClass('right-sidebar')) {
                            $('.grand_popo-loop').css('float', 'left');
                        } else {
                            $('.grand_popo-loop').css('float', 'right');
                        }
                        $('.grand_popo-loop').css('width', '75%');
                        $('#top-menu-mask').addClass('is-active');
                    }, 200);
                });
                $(document).on('click touchstart', '.grand_popo-loop #top-menu-mask', function () {
                    $('#secondary.shop-sidebar').css('transform', 'translateX(100%)');
                    $('#secondary.shop-sidebar').css('display', 'none');
                    $('.grand_popo-loop').css('float', 'none');
                    $('.grand_popo-loop').css('width', '100%');
                    $('#top-menu-mask').removeClass('is-active');
                    $('.per-row-container').css('opacity', '0');
                    $('.per-row-container').css('visibility', 'hidden');
                    setTimeout(function () {
                        $('#top-menu-icon').css('transform', 'scale(1)');
                    }, 200);
                });
            }
        }
        ;
        mobile_shop_sidebar_layout();
        $(window).resize(function () {
            mobile_shop_sidebar_layout();
        });
        $('.grand_popo-advanced-search').submit(function () {
            $(this).find("[value='all']").val("");
        });
        if ($("#masthead").hasClass("sticky")) {
            var menu_height = 75;
            $(window).bind('scroll', function () {
                if ($(window).scrollTop() > menu_height) {
                    $('#masthead').addClass('fixed-nav');
                    $('#sticky-menu').addClass('fixed-nav');
                } else {
                    $('#masthead').removeClass('fixed-nav');
                    $('#sticky-menu').removeClass('fixed-nav');
                }
            });
        }
        if ($("a[href='#top']").hasClass("grand_popo-scroll-to-top")) {
            var footer_height = 300;
            $(window).bind('scroll', function () {
                if ($(window).scrollTop() > footer_height) {
                    $("a[href='#top']").css("display", "block");
                } else {
                    $("a[href='#top']").css("display", "none");
                }
            });
        }
        $(document).on("click touchstart", "a[href='#top']", function () {
            $("html, body").animate({
                scrollTop: 0
            }, "100");
            return false;
        });
        $(".owl-carousel.grand_popo-post-gallery").owlCarousel({
            navigation: true,
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true,
            autoPlay: true,
            stopOnHover: true,
            pagination: true
        });
        if (window.matchMedia("(min-width: 1100px)").matches) {
            $('.single-product .prodcut-img-box .thumbnails').bxSlider({
                mode: 'vertical',
                pager: false,
                prevText: '',
                nextText: '',
                infiniteLoop: true,
                minSlides: 4,
                moveSlides: 2,
                slideWidth: 130,
                slideMargin: 10
            });
        }
        if (window.matchMedia("(min-width: 1024px) and (max-width: 1099px").matches) {
            $('.single-product .prodcut-img-box .thumbnails').bxSlider({
                mode: 'vertical',
                pager: false,
                prevText: '',
                nextText: '',
                infiniteLoop: true,
                minSlides: 4,
                moveSlides: 2,
                slideWidth: 110,
                slideMargin: 10
            });
        }
        if (window.matchMedia("(min-width: 740px) and (max-width: 1023px)").matches) {
            $('.single-product .prodcut-img-box .thumbnails').bxSlider({
                mode: 'vertical',
                pager: false,
                prevText: '',
                nextText: '',
                infiniteLoop: true,
                minSlides: 6,
                moveSlides: 2,
                slideWidth: 120,
                slideMargin: 10
            });
        }
        if (window.matchMedia("(min-width: 640px) and (max-width: 739px)").matches) {
            $('.single-product .prodcut-img-box .thumbnails').bxSlider({
                mode: 'vertical',
                pager: false,
                prevText: '',
                nextText: '',
                infiniteLoop: true,
                minSlides: 5,
                moveSlides: 1,
                slideWidth: 120,
                slideMargin: 10
            });
        }
        if (window.matchMedia("(min-width: 520px) and (max-width: 639px)").matches) {
            $('.single-product .prodcut-img-box .thumbnails').bxSlider({
                mode: 'vertical',
                pager: false,
                prevText: '',
                nextText: '',
                infiniteLoop: true,
                minSlides: 4,
                moveSlides: 1,
                slideWidth: 120,
                slideMargin: 10
            });
        }
        if (window.matchMedia("(min-width: 380px) and (max-width: 520px)").matches) {
            $('.single-product .prodcut-img-box .thumbnails').bxSlider({
                mode: 'vertical',
                pager: false,
                prevText: '',
                nextText: '',
                infiniteLoop: true,
                minSlides: 3,
                moveSlides: 2,
                slideWidth: 100,
                slideMargin: 10
            });
        }
        if (window.matchMedia("(min-width: 280px) and (max-width: 379px)").matches) {
            $('.single-product .prodcut-img-box .thumbnails').bxSlider({
                mode: 'vertical',
                pager: false,
                prevText: '',
                nextText: '',
                infiniteLoop: true,
                minSlides: 3,
                moveSlides: 2,
                slideWidth: 70,
                slideMargin: 10
            });
        }
        if (window.matchMedia("(min-width: 240px) and (max-width: 279px)").matches) {
            $('.single-product .prodcut-img-box .thumbnails').bxSlider({
                mode: 'vertical',
                pager: false,
                prevText: '',
                nextText: '',
                infiniteLoop: true,
                minSlides: 3,
                moveSlides: 2,
                slideWidth: 45,
                slideMargin: 10
            });
        }
        $("#secondary.shop-sidebar,.cart-detail ul.cart_list,.cart-detail").mCustomScrollbar({
            axis: "y",
            theme: "minimal-dark",
            scrollInertia: 300,
            advanced: {
                autoScrollOnFocus: false,
                updateOnContentResize: true
            }
        });
        
        if ($("#shop-sidebar ").hasClass("toggle")) {
            $(".shop-sidebar section .widget-title").toggle(function () {
                $(this).parent().find('ul:first,form:first,div:first').hide();
                $(this).addClass('closed');
            }, function () {
                $(this).parent().find('ul:first,form:first,div:first').show();
                $(this).removeClass('closed');
            });
        }
        $(document).on('click , touchstart', '.qty-spiner-wrap .qty-plus, .qty-spiner-wrap .qty-minus', function (e) {
            e.preventDefault();
            var $qty = $(this).parent().siblings(".qty-text");
            var currentVal = parseFloat($qty.val());
            var max = parseFloat($qty.attr('max'));
            var min = parseFloat($qty.attr('min'));
            var step = $qty.attr('step');
            if (!currentVal || currentVal === '' || currentVal === 'NaN')
                currentVal = 0;
            if (max === '' || max === 'NaN')
                max = '';
            if (min === '' || min === 'NaN')
                min = 0;
            if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN')
                step = 1;
            if ($(this).is('.qty-plus')) {
                if (max && (max == currentVal || currentVal > max)) {
                    $qty.val(max).trigger("change");
                } else {
                    $qty.val(currentVal + parseFloat(step)).trigger("change");
                }
            } else {
                if (min && (min == currentVal || currentVal < min)) {
                    $qty.val(min).trigger("change");
                } else if (currentVal > 0) {
                    $qty.val(currentVal - parseFloat(step)).trigger("change");
                }
            }
        });
        $(".yith-wcwl-add-to-wishlist,.compare.grand_popo-compare").insertAfter($(".single_add_to_cart_button"));
        $("[data-original-title]").tooltip();
    });

})(jQuery);