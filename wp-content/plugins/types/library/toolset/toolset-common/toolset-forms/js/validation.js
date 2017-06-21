/*
 * Validation JS
 *
 * - Initializes validation on selector (forms)
 * - Adds/removes rules on elements contained in var wptoolsetValidationData
 * - Checks if elements are hidden by conditionals
 *
 * @see class WPToolset_Validation
 *
 *
 */
var wptValidationForms = [];
var wptValidationDebug = false;
//Contains IDs for CRED form that were already initialised, to prevent multiple initialisation
var initialisedCREDForms = [];

var wptValidation = (function ($) {
    function init() {
        /**
         * add extension to validator method
         */
        $.validator.addMethod("extension", function (value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, "|") : param;
            if ($(element).attr('res') && $(element).attr('res') != "")
                return true;
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        });

        /**
         * add hexadecimal to validator method
         */
        $.validator.addMethod("hexadecimal", function (value, element, param) {
            return value == "" || /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(value);
        });

        /**
         * add skype to validator method
         */
        $.validator.addMethod("skype", function (value, element, param) {
            return value == "" || /^([a-z0-9\.\_\,\-\#]+)$/i.test(value);
        });

        /**
         * add extension to validator method require
         */
        $.validator.addMethod("required", function (value, element, param) {
            var _name = $(element).attr('name');
            var _value = $(element).val();

            // check if dependency is met
            if (!this.depend(param, element))
                return "dependency-mismatch";
            switch (element.nodeName.toLowerCase()) {
                case 'select':
                    return _value && $.trim(_value).length > 0;
                case 'input':
                    if (jQuery(element).hasClass("wpt-form-radio")) {
                        var val = jQuery('input[name="' + _name + '"]:checked').val();

                        if (wptValidationDebug)
                            console.log("radio " + (typeof val != 'undefined' && val && $.trim(val).length > 0));

                        return typeof val != 'undefined' && val && $.trim(val).length > 0;
                    }

                    var $element = jQuery(element).siblings('input[type="hidden"]').first();
                    var elementFieldType = $element.attr('data-wpt-type');
                    if ($element &&
                        !$element.prop("disabled") &&
                        ( elementFieldType == 'file' || elementFieldType == 'video' || elementFieldType == 'image' )) {
                        var val = $element.val();
                        if (wptValidationDebug)
                            console.log("hidden " + (val && $.trim(val).length > 0));

                        return val && $.trim(val).length > 0;
                    }

                    if (jQuery(element).attr('type') == "checkbox") {
                        if (wptValidationDebug) {
                            console.log("checkbox " + (element.checked));
                        }
                        return element.checked;
                    }
                    
                    if (jQuery(element).hasClass("hasDatepicker")) {
                        if (wptValidationDebug)
                            console.log("hasDatepicker");
                        return false;
                    }

                    if (this.checkable(element)) {
                        if (wptValidationDebug)
                            console.log("checkable " + (this.getLength(value, element) > 0));
                        return this.getLength(value, element) > 0;
                    }

                    if (wptValidationDebug)
                        console.log(_name + " default: " + value + " val: " + _value + " " + ($.trim(_value).length > 0));

                    return $.trim(_value).length > 0;
                default:
                    return $.trim(value).length > 0;
            }
        });

        /**
         * Add validation method for datepicker adodb_xxx format for date fields
         */
        $.validator.addMethod(
            "dateADODB_STAMP",
            function (a, b) {
                return this.optional(b) || /^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(a) && -12219292800 < a && a < 32535215940
            },
            "Please enter a valid date"
        );

        if (wptValidationDebug) {
            console.log("INIT");
            console.log(wptValidationForms);
        }

        _.each(wptValidationForms, function (formID) {
            //Only apply to non CRED elements, CRED ones will be init on cred_form_ready
            if(formID.indexOf('#cred') == -1){
                _initValidation(formID);
                applyRules(formID);
            }
        });
    }

    function _initValidation(formID) {
        if (wptValidationDebug) {
            console.log("_initValidation " + formID);
        }
        var $form = $(formID);
        $form.validate({
            // :hidden is kept because it's default value.
            // All accepted by jQuery.not() can be added.
            ignore: 'input[type="hidden"]:not(.js-wpt-date-auxiliar),:not(.js-wpt-validate)',
            errorPlacement: function (error, element) {
                error.insertBefore(element);
            },
            highlight: function (element, errorClass, validClass) {
                // Expand container
                $(element).parents('.collapsible').slideDown();
                if (formID == '#post') {
                    var box = $(element).parents('.postbox');
                    if (box.hasClass('closed')) {
                        $('.handlediv', box).trigger('click');
                    }
                }
                $(element).parent('div').addClass('has-error');
                // $.validator.defaults.highlight(element, errorClass, validClass); // Do not add class to element
            },
            unhighlight: function (element, errorClass, validClass) {
                $("input#publish, input#save-post").removeClass("button-primary-disabled").removeClass("button-disabled");
                $(element).parent('div').removeClass('has-error');
                // $.validator.defaults.unhighlight(element, errorClass, validClass);
            },
            invalidHandler: function (form, validator) {
                if (formID == '#post') {
                    $('#publishing-action .spinner').css('visibility', 'hidden');
                    $('#publish').bind('click', function () {
                        $('#publishing-action .spinner').css('visibility', 'visible');
                    });
                    $("input#publish").addClass("button-primary-disabled");
                    $("input#save-post").addClass("button-disabled");
                    $("#save-action .ajax-loading").css("visibility", "hidden");
                    $("#publishing-action #ajax-loading").css("visibility", "hidden");
                }
            },
//            submitHandler: function(form) {
//                // Remove failed conditionals
//                $('.js-wpt-remove-on-submit', $(form)).remove();
//                form.submit();
//            },
            errorElement: 'small',
            errorClass: 'wpt-form-error'
        });

        // On some pages the form may not be ready yet at this point (e.g. Edit Term page).
        jQuery(document).ready(function () {
            if (wptValidationDebug)
                console.log($form.selector);

            jQuery(document).off('submit', $form.selector, null);
            jQuery(document).on('submit', $form.selector, function () {
                if (wptValidationDebug) {
                    console.log("submit " + $form.selector);
                }

                var myformid = formID.replace('#', '');
                myformid = myformid.replace('-', '_');
                var cred_settings = eval('cred_settings_' + myformid);

                if (typeof grecaptcha !== 'undefined') {
                    var $error_selector = jQuery(formID).find('div.recaptcha_error');
                    if (_recaptcha_id != -1) {
                        if (grecaptcha.getResponse(_recaptcha_id) == '') {
                            $error_selector.show();
                            setTimeout(function () {
                                $error_selector.hide();
                            }, 5000);
                            return false;
                        }
                    }
                    $error_selector.hide();
                }

                if (wptValidationDebug) {
                    console.log("validation...");
                }

                if ($form.valid()) {
                    if (wptValidationDebug)
                        console.log("form validated " + $form);

                    $('.js-wpt-remove-on-submit', $(this)).remove();

                    if (cred_settings.use_ajax && cred_settings.use_ajax == 1) {
                        $('<input value="cred_ajax_form" name="action">').attr('type', 'hidden').appendTo(formID);
                        $('<input value="true" name="form_submit">').attr('type', 'hidden').appendTo(formID);

                        $body = $("body");
                        $body.addClass("wpt-loading");

                        $.ajax({
                            type: 'post',
                            url: $(formID).attr('action'),
                            data: $(formID).serialize(),
                            dataType: 'json',
                            complete: function (data) {
                                $body.removeClass("wpt-loading");
                            },
                            success: function (data) {
                                $body.removeClass("wpt-loading");
                                if (data) {
                                    $(formID).replaceWith(data.output);
                                    reload_tinyMCE();

                                    if (data.result == 'ok') {
                                        alert(cred_settings.operation_ok);
                                    }

                                    try_to_reload_reCAPTCHA(formID);
                                }

                                //An event to indicate the completion of CRED form ajax with success
                                jQuery(document).trigger('cred_form_ajax_completed');
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(cred_settings.operation_ko);
                            }
                        });
                    }
                } else {
                    if (wptValidationDebug) {
                        console.log("form not valid!");
                    }
                }
                if (cred_settings.use_ajax && cred_settings.use_ajax == 1) {
                    return false;
                }
            });
        });
    }

    var _recaptcha_id = -1;

    function try_to_reload_reCAPTCHA(formID) {
        if (typeof grecaptcha !== 'undefined') {
            var _sitekey = jQuery(formID).find('div.g-recaptcha').data('sitekey');
            _recaptcha_id = grecaptcha.render($('.g-recaptcha')[0], {sitekey: _sitekey});
        }
    }

    function reload_tinyMCE() {
        jQuery('textarea.wpt-wysiwyg').each(function (index) {
            var $area = jQuery(this),
                area_id = $area.prop('id');
            if (typeof area_id !== 'undefined') {
                if (typeof tinyMCE !== 'undefined') {
                    tinyMCE.get(area_id).remove();
                }
                tinyMCE.init(tinyMCEPreInit.mceInit[area_id]);
				// Note that this Quicktags initialization is broken by design
				// since WPV_Toolset.add_qt_editor_buttons expects as second parameter a Codemirror editor instace
				// and here we are passing just a textarea ID.
                var quick = quicktags(tinyMCEPreInit.qtInit[area_id]);
                WPV_Toolset.add_qt_editor_buttons(quick, area_id);
            }
        });

        jQuery("button.wp-switch-editor").click();
        jQuery("button.switch-tmce").click();
    }

    $(document).on('js_event_wpv_pagination_completed, js_event_wpv_parametric_search_results_updated', function (event, data) {
        if (typeof wptValidation !== 'undefined') {
            wptValidation.init();
        }
        if (typeof wptCond !== 'undefined') {
            wptCond.init();
        }
        if (typeof wptRep !== 'undefined') {
            wptRep.init();
        }
        if (typeof wptCredfile !== 'undefined') {
            wptCredfile.init('body');
        }
        if (typeof toolsetForms !== 'undefined') {
            toolsetForms.cred_tax = new toolsetForms.CRED_taxonomy();
            if (typeof initCurrentTaxonomy == 'function') {
                initCurrentTaxonomy();
            }
        }

        if (typeof wptDate !== 'undefined') {
            wptDate.init('body');
        }

        if (typeof jQuery('.wpt-suggest-taxonomy-term') && jQuery('.wpt-suggest-taxonomy-term').length) {
            jQuery('.wpt-suggest-taxonomy-term').hide();
        }

        reload_tinyMCE();
    });

    function isIgnored($el) {
        var ignore = $el.parents('.js-wpt-field').hasClass('js-wpt-validation-ignore') || // Individual fields
            $el.parents('.js-wpt-remove-on-submit').hasClass('js-wpt-validation-ignore'); // Types group of fields
        return ignore;
    }

    function applyRules(container) {
        $('[data-wpt-validate]', $(container)).each(function () {
            _applyRules($(this).data('wpt-validate'), this, container);
        });
    }

    function _applyRules(rules, selector, container) {
        var element = $(selector, $(container));
        if (element.length > 0) {
            if (isIgnored(element)) {
                element.rules('remove');
                element.removeClass('js-wpt-validate');
            } else if (!element.hasClass('js-wpt-validate')) {
                _.each(rules, function (value, rule) {
                    var _rule = {messages: {}};
                    _rule[rule] = value.args;
                    if (value.message !== 'undefined') {
                        _rule.messages[rule] = value.message;
                    }
                    element.rules('add', _rule);
                    element.addClass('js-wpt-validate');
                });
            }
        }
    }

    return {
        init: init,
        applyRules: applyRules,
        isIgnored: isIgnored,
        _initValidation: _initValidation
    };

})(jQuery);

//cred_form_ready will fire when a CRED form is ready, so we init it's validation rules then
jQuery(document).on('cred_form_ready', function(evt, data){
    if(initialisedCREDForms.indexOf(data.form_id) == -1){
        wptValidation._initValidation('#' + data.form_id);
        wptValidation.applyRules('#' + data.form_id);
        initialisedCREDForms.push(data.form_id);
    }
});

jQuery(document).ready(function () {

    //init ready CRED forms
    if( typeof( credFrontEndViewModel ) != 'undefined' ) {
        for(var credFormIDIndex in credFrontEndViewModel.readyCREDForms){
            var credFormID = credFrontEndViewModel.readyCREDForms[credFormIDIndex];
            if(initialisedCREDForms.indexOf(credFormID) == -1) {
                wptValidation._initValidation('#' + credFormID);
                wptValidation.applyRules('#' + credFormID);
                initialisedCREDForms.push(credFormID);
            }
        }
    }

    wptCallbacks.reset.add(function () {
        wptValidation.init();
    });
    wptCallbacks.addRepetitive.add(function (container) {
        wptValidation.applyRules(container);
    });
    wptCallbacks.removeRepetitive.add(function (container) {
        wptValidation.applyRules(container);
    });
    wptCallbacks.conditionalCheck.add(function (container) {
        if(container.indexOf('#cred') == -1){
            wptValidation.applyRules(container);
        }
    });
});