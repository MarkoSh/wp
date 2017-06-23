/**
 * Created by mark on 13/06/17.
 */


(function ($) {

    $(document).ready(function () {

        var $document = $(this);

        var main = {
            init: function () {
                var $main = this;
                $(".add-to-cart").click(function (e) {
                    console.log($main);
                    e.preventDefault();
                    $main.addToCart($(this));
                    return true;
                });
                $(".load-more").click(function (e) {
                    e.preventDefault();
                    $main.loadMore($(this));
                    return true;
                });
                $("form:not(.search)").submit(function (e) {
                    e.preventDefault();
                    $main.sendMessage($(this));
                    return true;
                });
            },
            addToCart: function ($obj) {
                console.log($obj);
            },
            loadMore: function ($obj) {
                console.log($obj);
            },
            sendMessage: function ($obj) {
                console.log($obj);
            }
        };

        //main.init();

    });
    
})(jQuery);