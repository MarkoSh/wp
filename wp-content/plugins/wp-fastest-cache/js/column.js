if(window.attachEvent) {
    window.attachEvent('onload', wpfc_column_button_action);
} else {
    if(window.onload) {
        var curronload = window.onload;
        var newonload = function(evt) {
            curronload(evt);
            wpfc_column_button_action(evt);
        };
        window.onload = newonload;
    } else {
        window.onload = wpfc_column_button_action;
    }
}
function wpfc_column_button_action(){
	jQuery(document).ready(function(){
        jQuery("button.button.wpfc-clear-column-action:visible").click(function(e){

            jQuery(e.currentTarget).attr("disabled", true);

            jQuery.ajax({
                type: 'GET',
                url: ajaxurl,
                data : {"action": "wpfc_clear_cache_column", "id" : jQuery(e.currentTarget).attr("wpfc-clear-column")},
                dataType : "json",
                cache: false, 
                success: function(data){
                    if(typeof data.success != "undefined" && data.success == true){
                        jQuery(e.currentTarget).attr("disabled", false);
                    }else{
                        alert("Clear Cache Error");
                    }
                }
            });

            return false;
        });
	});
}