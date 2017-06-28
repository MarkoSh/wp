(function($) { 
    "use strict";
    $(document).ready(function () {

        function hide_grand_popo_remove_icon_button_if_needed()
        {
            // Only show the "remove image" button when needed
            if (!$('#prod_cat_icon').val()) {
                $('.grand_popo_remove_file').hide();
            }
        }

        hide_grand_popo_remove_icon_button_if_needed();

        $(document).on("click", "#grand_popo-add-product-cat-icon", function (e) {
            e.preventDefault();
            var uploader = wp.media({
                title: 'Please set the picture',
                button: {
                    text: "Select picture(s)"
                },
                multiple: false
            })
                    .on('select', function () {
                        var selection = uploader.state().get('selection');
                        selection.map(
                                function (attachment) {
                                    attachment = attachment.toJSON();
                                    $('#prod-cat-image').attr("src", attachment.url);
                                    $('.cat-icon').val(attachment.url);

                                    $('.grand_popo_remove_file').show();
                                }
                        );
                    })
                    .open();
        });

        $('.grand_popo_remove_file').click(function () {
            $('.cat-icon').attr('value', '');
            var default_src = $('#prod-cat-image').attr('data-src');
            $('#prod-cat-image').attr('src', default_src);
        });

        if ($('.grand_popo_remove_file').length)
        {
            $(document).ajaxComplete(function (event, request, options) {
                if (request && 4 === request.readyState && 200 === request.status
                        && options.data && 0 <= options.data.indexOf('action=add-tag')) {

                    var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
                    if (!res || res.errors) {
                        return;
                    }
                    // Clear Thumbnail fields on submit
                    $('.grand_popo_remove_file').click();
                    return;
                }
            });
        }


    });
})(jQuery);