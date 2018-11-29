/* 
 * base application
 * @author Lamnx
 */
var App = {};

if (jQuery === undefined)
    jQuery = $ = {};

/** @param {jQuery} $ jQuery Object */
!function ($, window, document, _undefined)
{
    jQuery.extend(true, {
        /**
         * Sets the context of 'this' within a called function.
         * Takes identical parameters to $.proxy, but does not
         * enforce the one-elment-one-method merging that $.proxy
         * does, allowing multiple objects of the same type to
         * bind to a single element's events (for example).
         *
         * @param function|object Function to be called | Context for 'this', method is a property of fn
         * @param function|string Context for 'this' | Name of method within fn to be called
         *
         * @return function
         */
        context: function (fn, context)
        {
            if (typeof context == 'string')
            {
                var _context = fn;
                fn = fn[context];
                context = _context;
            }

            return function () {
                return fn.apply(context, arguments);
            };
        },
        /**
         * Sets a cookie.
         *
         * @param string cookie name (escaped)
         * @param mixed cookie value
         * @param string cookie expiry date
         *
         * @return mixed cookie value
         */
        setCookie: function (name, value, expires)
        {
            console.log('Set cookie %s = %s', name, value);

            document.cookie = App._cookieConfig.prefix + name + '=' + encodeURIComponent(value)
                    + (expires === undefined ? '' : ';expires=' + expires.toUTCString())
                    + (App._cookieConfig.path ? ';path=' + App._cookieConfig.path : '')
                    + (App._cookieConfig.domain ? ';domain=' + App._cookieConfig.domain : '');

            return value;
        },
        /**
         * Fetches the value of a named cookie.
         *
         * @param string Cookie name (escaped)
         *
         * @return string Cookie value
         */
        getCookie: function (name)
        {
            var expr, cookie;

            expr = new RegExp('(^| )' + App._cookieConfig.prefix + name + '=([^;]+)(;|$)');
            cookie = expr.exec(document.cookie);

            if (cookie)
            {
                return decodeURIComponent(cookie[2]);
            } else
            {
                return null;
            }
        },
        /**
         * Deletes a cookie.
         *
         * @param string Cookie name (escaped)
         *
         * @return null
         */
        deleteCookie: function (name)
        {
            console.info('Delete cookie %s', name);

            document.cookie = App._cookieConfig.prefix + name + '='
                    + (App._cookieConfig.path ? '; path=' + App._cookieConfig.path : '')
                    + (App._cookieConfig.domain ? '; domain=' + App._cookieConfig.domain : '')
                    + '; expires=Thu, 01-Jan-70 00:00:01 GMT';

            return null;
        },
        /**
         * Wrapper functions for commonly-used animation effects, so we can customize their behaviour as required
         */
    });
    /**
     * Extends jQuery functions
     */
    jQuery.fn.extend({
        /**
         * Wrapper for App.activate, for 'this' element
         *
         * @return jQuery
         */
        appActivate: function ()
        {
            return App.activate(this);
        },
        appFadeIn: function (speed, callback)
        {
            return this.fadeIn(speed, function () {
                $(this).ieOpacityFix(callback);
            });
        },
        appFadeOut: function (speed, callback)
        {
            return this.fadeOut(speed, callback);
        },
        appShow: function (speed, callback)
        {
            return this.show(speed, function () {
                $(this).ieOpacityFix(callback);
            });
        },
        appHide: function (speed, callback)
        {
            return this.hide(speed, callback);
        },
        appSlideDown: function (speed, callback)
        {
            return this.slideDown(speed, function () {
                $(this).ieOpacityFix(callback);
            });
        },
        appSlideUp: function (speed, callback)
        {
            return this.slideUp(speed, callback);
        },
        /**
         * Animates an element opening a space for itself, then fading into that space
         *
         * @param integer|string Speed of fade-in
         * @param function Callback function on completion
         *
         * @return jQuery
         */
        appFadeDown: function (fadeSpeed, callback)
        {
            this.filter(':hidden').appHide().css('opacity', 0);

            fadeSpeed = fadeSpeed || App.speed.normal;

            return this
                    .appSlideDown(App.speed.fast)
                    .animate({opacity: 1}, fadeSpeed, function ()
                    {
                        $(this).ieOpacityFix(callback);
                    });
        },
        /**
         * Animates an element fading out then closing the gap left behind
         *
         * @param integer|string Speed of fade-out - if this is zero, there will be no animation at all
         * @param function Callback function on completion
         * @param integer|string Slide speed - ignored if fadeSpeed is zero
         * @param string Easing method
         *
         * @return jQuery
         */
        appFadeUp: function (fadeSpeed, callback, slideSpeed, easingMethod)
        {
            fadeSpeed = ((typeof fadeSpeed == 'undefined' || fadeSpeed === null) ? App.speed.normal : fadeSpeed);
            slideSpeed = ((typeof slideSpeed == 'undefined' || slideSpeed === null) ? fadeSpeed : slideSpeed);

            return this
                    .slideUp({
                        duration: Math.max(fadeSpeed, slideSpeed),
                        easing: easingMethod || 'swing',
                        complete: callback,
                        queue: false
                    })
                    .animate({opacity: 0, queue: false}, fadeSpeed);
        },
        /**
         * Inserts and activates content into the DOM, using appFadeDown to animate the insertion
         *
         * @param string jQuery method with which to insert the content
         * @param string Selector for the previous parameter
         * @param string jQuery method with which to animate the showing of the content
         * @param string|integer Speed at which to run the animation
         * @param function Callback for when the animation is complete
         *
         * @return jQuery
         */
        appInsert: function (insertMethod, insertReference, animateMethod, animateSpeed, callback)
        {
            if (insertMethod == 'replaceAll')
            {
                $(insertReference).appFadeUp(animateSpeed);
            }

            this
                    .addClass('__AppActivator')
                    .css('display', 'none')
            [insertMethod || 'appendTo'](insertReference)
                    .appActivate()
            [animateMethod || 'appFadeDown'](animateSpeed, callback);

            return this;
        },
        /**
         * Removes an element from the DOM, animating its removal with appFadeUp
         * All parameters are optional.
         *
         *  @param string animation method
         *  @param function callback function
         *  @param integer Sliding speed
         *  @param string Easing method
         *
         * @return jQuery
         */
        appRemove: function (animateMethod, callback, slideSpeed, easingMethod)
        {
            return this[animateMethod || 'appFadeUp'](App.speed.normal, function ()
            {
                $(this).empty().remove();

                if ($.isFunction(callback))
                {
                    callback();
                }
            }, slideSpeed, easingMethod);
        },
        /**
         * Workaround for IE's font-antialiasing bug when dealing with opacity
         *
         * @param function Callback
         */
        ieOpacityFix: function (callback)
        {
            //ClearType Fix
            if (!$.support.opacity)
            {
                this.css('filter', '');
                this.attr('style', this.attr('style').replace(/filter:\s*;/i, ''));
            }

            if ($.isFunction(callback))
            {
                callback.apply(this);
            }

            return this;
        },
    });

    $.extend(App, {
        /**
         * CSRF Token
         *
         * @var string
         */
        _csrfToken: '',
        /**
         * Configuration for cookies
         *
         * @var object
         */
        _cookieConfig: {path: '/', domain: '', 'prefix': 'crm_'},
        _baseUrl: false,
        /**
         * Speeds for animation
         *
         * @var object
         */
        speed: {
            xxfast: 50,
            xfast: 100,
            fast: 200,
            normal: 400,
            slow: 600
        },
        formatter: {
            timeZone: 'Asia/Ho_Chi_Minh',
            decimals: 0,
            decPoint: ',',
            thousandsSep: '.',
        },
        phrases: {},
        /**
         * Binds all registered functions to elements within the DOM
         */
        init: function ()
        {
            // Activate all registered controls
            App.activate(document);

            // Autofocus for non-supporting browsers
            if (!('autofocus' in document.createElement('input')))
            {
                //TODO: work out a way to prevent focusing if something else already has focus http://www.w3.org/TR/html5/forms.html#attr-fe-autofocus
                $('input[autofocus], textarea[autofocus], select[autofocus]').first().focus();
            }
        },
        baseUrl: function ()
        {
            if (App._baseUrl === false)
            {
                var b = document.createElement('a'), $base = $('base');
                b.href = '';

                App._baseUrl = (b.href.match(/[^\x20-\x7f]/) && $base.length) ? $base.attr('href') : b.href;

                if (!$base.length)
                {
                    App._baseUrl = App._baseUrl.replace(/\?.*$/, '').replace(/\/[^\/]*$/, '/');
                }
            }

            return App._baseUrl;
        },
        csrfToken: function ()
        {
            if (App._csrfToken === '')
            {
                var $meta = $('meta[name="csrf-token"]');

                if ($meta.length) {
                    App._csrfToken = $meta.attr('content');
                }
            }

            return App._csrfToken;
        },
        /**
         * Fire the initialization events and activate functions for the specified element
         *
         * @param object Usually jQuery
         *
         * @return object
         */
        activate: function (element)
        {
            var $element = $(element);

            console.group('App.activate(%o)', element);

            $element.trigger('AppActivate').removeClass('__AppActivator');
            $element.find('noscript').empty().remove();

            $(document).trigger({element: element, type: 'ActivateHtml'});

            var $form = $element.find('form.AutoSubmit:first');
            if ($form.length)
            {
                $form.submit();
                $form.find('input[type="submit"], input[type="reset"]').hide();
            }

            console.groupEnd();

            return element;
        },
        /**
         * Binds a function to elements to fire on a custom event
         *
         * @param string jQuery selector - to get the elements to be bound
         * @param function Function to fire
         * @param string Custom event name (if empty, assume 'ActivateHtml')
         */
        register: function (selector, fn, event)
        {
            if (typeof fn == 'string')
            {
                var className = fn;
                fn = function (i)
                {
                    App.create(className, this);
                };
            }
//console.log(event);
            $(document).bind(event || 'ActivateHtml', function (e)
            {
                $(e.element).find(selector).each(fn);
            });
        },
        /**
         * Creates a new object of class App.{functionName} using
         * the specified element, unless one has already been created.
         *
         * @param string Function name (property of App)
         * @param object HTML element
         *
         * @return object App[functionName]($(element))
         */
        create: function (className, element)
        {
            var $element = $(element),
                    appObj = window,
                    parts = className.split('.'), i;

            for (i = 0; i < parts.length; i++) {
                appObj = appObj[parts[i]];
            }

            if (typeof appObj != 'function')
            {
                return console.error('%s is not a function.', className);
            }

            if (!$element.data(className))
            {
                $element.data(className, new appObj($element));
            }

            return $element.data(className);
        },
        hashCode: function (str) {
            var hash = 0, i, chr, len;
            if (str.length === 0)
                return hash;
            for (i = 0, len = str.length; i < len; i++) {
                chr = str.charCodeAt(i);
                hash = ((hash << 5) - hash) + chr;
                hash |= 0; // Convert to 32bit integer
            }
            return hash;
        },
        numberFormat: function number_format(number, decimals, decPoint, thousandsSep) {
            //@author kvz/locutus
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
            var n = !isFinite(+number) ? 0 : +number
            var prec = !isFinite(+decimals) ? this.formatter.decimals : Math.abs(decimals)
            var sep = (typeof thousandsSep === 'undefined') ? this.formatter.thousandsSep : thousandsSep
            var dec = (typeof decPoint === 'undefined') ? this.formatter.decPoint : decPoint
            var s = ''

            var toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec)
                return '' + (Math.round(n * k) / k)
                        .toFixed(prec)
            }

            // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || ''
                s[1] += new Array(prec - s[1].length + 1).join('0')
            }

            return s.join(dec)
        },
        ajax: function (url, data, success, options) {
            var successCallback = function (ajaxData, textStatus) {
                success.call(null, ajaxData, textStatus);
            };

            var referrer = window.location.href;
            if (referrer.match(/[^\x20-\x7f]/))
            {
                var a = document.createElement('a');
                a.href = '';
                referrer = referrer.replace(a.href, App.baseUrl());
            }

            options = $.extend(true,
                    {
                        data: data,
                        url: url,
                        success: successCallback,
                        type: 'POST',
                        dataType: 'json',
                        error: function (xhr, textStatus, errorThrown)
                        {
                            if (xhr.readyState == 0)
                            {
                                return;
                            }

                            try
                            {
                                // attempt to pass off to success, if we can decode JSON from the response
                                successCallback.call(null, $.parseJSON(xhr.responseText), textStatus);
                            } catch (e)
                            {
                                // not valid JSON, trigger server error handler
                                // handle server error
                            }
                        },
                        headers: {'X-Ajax-Referer': referrer},
                        timeout: 30000 // 30s
                    }, options);

            return $.ajax(options);
        },
        toastAlert: function (message, timeOut) {
            timeOut = timeOut || 3000;

            var $toastHtml = $('<div class="toast">'
                    + '<div class="toast-container">'
                    + '<div class="toast-icon">'
                    + '<div class="action-toast-icon">'
                    + '<i class="fa fa-check" aria-hidden="true"></i>'
                    + '</div>'
                    + '</div>'
                    + '<div class="toast-content">' + message + '</div>'
                    + '</div>'
                    + '</div>'),
                    $container = $('#action-toast');

            if (!$container.length) {
                $container = $('<div id="action-toast"></div>').appendTo('body');
            }

            $toastHtml.find('div.toast-content').html(message).end().appendTo($container);

            function removeToastAlert() {
                $toastHtml.remove();
            }

            $toastHtml.click(removeToastAlert);

            if (timeOut)
            {
                setTimeout(removeToastAlert, timeOut);
            }

            return $toastHtml;
        },
        confirm: function (message, callback, options) {
            options = $.extend(true, {
                id: 'platformAppConfirmDialog',
                title: 'Confirm',
                okLabel: 'Yes',
                cancelLabel: 'No',
                okClass: 'btn btn-danger',
                okBtnId: 'okPlatformConfirmButton',
                cancelClass: 'btn',
            }, options);

            if (callback === undefined) {
                callback = function () {
                    return true;
                }
            }

            if (!$('#' + options.id).length) {
                var modalHtml = '<div class="modal fade" id="' + options.id + '" role="dialog" aria-hidden="true">'
                        + '<div class="modal-dialog">'
                        + '<div class="modal-content">'
                        + '<div class="modal-header">'
                        + '<h4 class="modal-title">' + options.title + '</h4>'
                        + '</div>'
                        + '<div class="modal-body">'
                        + message
                        + '</div>'
                        + '<div class="modal-footer">'
                        + '<button type="button" data-dismiss="modal" class="' + options.okClass + ' DisableOnSubmit" id="' + options.okBtnId + '">' + options.okLabel + '</button>'
                        + '<button type="button" data-dismiss="modal" class="' + options.cancelClass + '">' + options.cancelLabel + '</button>'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '</div>';

                $('body').append(modalHtml);
            }

            $('#' + options.id).on('hidden.bs.modal', function (e) {
                $(e.currentTarget).unbind();
            });

            return $('#' + options.id).modal().one('click', '#' + options.okBtnId, function (e) {
                e.preventDefault();

                callback.call(null);
            });
        },
        copyToClipboard: function (elem) {
            // create hidden text element, if it doesn't already exist
            var targetId = "_hiddenCopyText_";
            var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
            var origSelectionStart, origSelectionEnd;
            if (isInput) {
                // can just use the original source element for the selection and copy
                target = elem;
                origSelectionStart = elem.selectionStart;
                origSelectionEnd = elem.selectionEnd;
            } else {
                // must use a temporary form element for the selection and copy
                target = document.getElementById(targetId);
                if (!target) {
                    var target = document.createElement("textarea");
                    target.style.position = "absolute";
                    target.style.left = "-9999px";
                    target.style.top = "0";
                    target.id = targetId;
                    document.body.appendChild(target);
                }
                target.textContent = elem.textContent;
            }
            // select the content
            var currentFocus = document.activeElement;
            target.focus();
            target.setSelectionRange(0, target.value.length);

            // copy the selection
            var succeed;
            try {
                succeed = document.execCommand("copy");
            } catch (e) {
                succeed = false;
            }
            // restore original focus
            if (currentFocus && typeof currentFocus.focus === "function") {
                currentFocus.focus();
            }

            if (isInput) {
                // restore prior selection
                elem.setSelectionRange(origSelectionStart, origSelectionEnd);
            } else {
                // clear temporary content
                target.textContent = "";
            }
            return succeed;
        }
    });

    /**
     * Allows a control to create a clone of an existing field, like 'add new response' for polls
     *
     * @param jQuery $button.FieldAdder[data-source=#selectorOfCloneSource]
     */
    App.FieldAdder = function ($button)
    {
        $button.click(function (e)
        {
            var $source = $($button.data('source')),
                    maxFields = $button.data('maxfields'),
                    $clone = null;

            if ($source.length && (!maxFields || ($source.length < maxFields)))
            {
                $clone = $source.last().clone();
                $clone.html(function (i, html) {
                    return html.replace(/\[[0-9]+\]/g, '[' + $source.length + ']');
                });

                $clone.find('input:not([type="button"], [type="submit"])').val('').prop('disabled', true);
                $clone.find('.spinBoxButton').remove();
                $clone.find('input[type="radio"]').prop('checked', false);

                $button.trigger({
                    type: 'FieldAdderClone',
                    clone: $clone
                });

                $clone.appInsert('insertAfter', $source.last(), false, false, function ()
                {
                    var $inputs = $clone.find('input');
                    $inputs.prop('disabled', false);
                    $inputs.first().focus().select();

                    if (maxFields)
                    {
                        if ($($button.data('source')).length >= maxFields)
                        {
                            $button.appRemove();
                        }
                    }
                });
            }
        });
    };

    /**
     * Allows a control to remove a clone of an existing field, like 'add new response' for polls
     *
     * @param jQuery $button.FieldAdder[data-source=#selectorOfCloneSource]
     */
    App.FieldRemover = function ($button)
    {
        $button.click(function (e)
        {
            var $source = $($(this).parents($button.data('source'))), minFields = $button.data('minfields'), elemNumber = $source.siblings().length;

            if ($source.length && (!minFields || (elemNumber > minFields)))
            {
                $source.appRemove();
            }
        });
    };

    /**
     * Allows an input:checkbox or input:radio to disable subsidiary controls
     * based on its own state
     *
     * @param {Object} $input
     */
    App.Disabler = function ($input)
    {
        /**
         * Sets the disabled state of form elements being controlled by this disabler.
         *
         * @param Event e
         * @param boolean If true, this is the initialization call
         */
        var setStatus = function (e, init)
        {
            //console.info('Disabler %o for child container: %o', $input, $childContainer);

            var $childControls = $childContainer.find('input, select, textarea, button, .inputWrapper'),
                    speed = init ? 0 : App.speed.fast,
                    select = function (e)
                    {
                        $childContainer.find('input:not([type=hidden], [type=file]), textarea, select, button').first().focus().select();
                    };

            if ($input.is(':checked:enabled'))
            {
                $childContainer
                        .removeAttr('disabled')
                        .removeClass('disabled')
                        .trigger('DisablerDisabled');

                $childControls
                        .removeAttr('disabled')
                        .removeClass('disabled');

                if ($input.hasClass('Hider'))
                {
                    if (init)
                    {
                        $childContainer.show();
                    } else
                    {
                        $childContainer.appFadeDown(speed, init ? null : select);
                    }
                } else if (!init)
                {
                    select.call();
                }
            } else
            {
                if ($input.hasClass('Hider'))
                {
                    if (init)
                    {
                        $childContainer.hide();
                    } else
                    {
                        $childContainer.appFadeUp(speed, null, speed, 'easeInBack');
                    }
                }

                $childContainer
                        .prop('disabled', true)
                        .addClass('disabled')
                        .trigger('DisablerEnabled');

                $childControls
                        .prop('disabled', true)
                        .addClass('disabled')
                        .each(function (i, ctrl)
                        {
                            var $ctrl = $(ctrl),
                                    disabledVal = $ctrl.data('disabled');

                            if (disabledVal !== null && typeof (disabledVal) != 'undefined')
                            {
                                $ctrl.val(disabledVal);
                            }
                        });
            }
        },
                $childContainer = $('#' + $input.attr('id') + '_Disabler'),
                $form = $input.closest('form');

        var setStatusDelayed = function ()
        {
            setTimeout(setStatus, 0);
        };

        if ($input.is(':radio'))
        {
            $form.find('input:radio[name="' + $input.fieldName() + '"]').click(setStatusDelayed);
        } else
        {
            $input.click(setStatusDelayed);
        }

        $form.bind('reset', setStatusDelayed);
        $form.bind('AppRecalculate', function () {
            setStatus(null, true);
        });

        setStatus(null, true);

        $childContainer.find('label, input, select, textarea').click(function (e)
        {
            if (!$input.is(':checked'))
            {
                $input.prop('checked', true);
                setStatus();
            }
        });

        this.setStatus = setStatus;
    };

    App.ModalTrigger = function (elm, target) {
        if ($(target).length <= 0) {
            var cached = $(elm).data('cached'), width = $(elm).data('width');

            if (cached === undefined) {
                cached = true;
            }

            if (width === undefined) {
                width = 0;
            }

            target = target.replace('#', '');
            var html = '<div class="modal fade" id="' + target + '"' + (cached ? ' data-cached="true" ' : ' data-cached="false" ') + 'role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true">'
                    + '<div class="modal-dialog" role="document"' + (width ? ' style="width:' + width + 'px;"' : '') + '>'
                    + '<div class="modal-content">'
                    + '</div>'
                    + '</div>'
                    + '</div>';
            $('body').append(html);
        }
    };

    App.submitFrom = function (modalId, formId) {
        var $form = $(formId);
        var modalTarget = $(modalId);
        $('.loading').css('display', 'block');
        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            success: function (response) {
                var res = JSON.parse(response);
                if (res === 'success') {
                    modalTarget.modal('toggle');
                    window.location.reload();
                } else {
                    var errorBox = $(formId).find("#message-box");
                    errorBox.removeClass('hidden').html('');
                    var ul = $("<ul>");
                    $.each(res, function (i, val) {
                        ul.append($('<li>', {text: val[0]}));
                    });
                    errorBox.append(ul);
                }
                $('#loading').fadeOut();
            }
        });
    };
    App.MultiSubmitFix = function ($form)
    {
        var selector = 'input:submit, input:reset, input.PreviewButton, input.DisableOnSubmit, button:submit, button.DisableOnSubmit',
                enable = function ()
                {
                    $(window).unbind('unload', enable);

                    $form.trigger('EnableSubmitButtons').find(selector)
                            .removeClass('disabled')
                            .removeAttr('disabled');
                };

        var disable = function (e)
        {
            setTimeout(function ()
            {
                var isWebKit = 'WebkitAppearance' in document.documentElement.style;
                /**
                 * Workaround for a Firefox issue that prevents resubmission after back button,
                 * however the workaround triggers a webkit rendering bug.
                 */
                if (!isWebKit)
                {
                    $(window).bind('unload', enable);
                }

                $form.trigger('DisableSubmitButtons').find(selector)
                        .prop('disabled', true)
                        .addClass('disabled');
            }, 0);

            setTimeout(enable, 5000);
        };

        $form.find(selector).on('click', function (e) {
            e.preventDefault();
            $form.submit();
        });

        $form.data('MultiSubmitEnable', enable)
                .data('MultiSubmitDisable', disable)
                .submit(disable);

        return enable;
    };

    App.AjaxSubmit = function ($form)
    {
        var handleCallback = function (callback) {
            if (/^[a-z0-9_]+$/i.test(callback)) {
                return this[callback];
            } else if (callback.indexOf('.') >= 0) {
                var parts = callback.split('.'), i;
                var appObj = this;

                for (i = 0; i < parts.length; i++) {
                    appObj = appObj[parts[i]];
                }

                return appObj;
            }

            return false;
        }

        $form.on('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var data = $form.data('yiiActiveForm'), callbackFunc = handleCallback($form.data('callback'));

            if (data.validated) {
                App.ajax($form.attr("action"), $form.serialize(), function (ajaxData, textStatus) {
                    if (ajaxData.status === 200) {
                        if (callbackFunc) {
                            callbackFunc.call(null, ajaxData, textStatus);
                        }
                    } else if (ajaxData.errors) {
                        $.each(data.attributes, function (i, $attribute) {
                            let field = $attribute.name;
                            if (typeof ajaxData.errors[field] != "undefined") {
                                $($attribute.container + ' ' + $attribute.error).html(ajaxData.errors[field].join(' '));
                                $($attribute.container).removeClass('has-success').addClass('has-error');
                                delete ajaxData.errors[field];
                            }
                        });

                        var $errorContainer = $form.find('.errorSummary');

                        if (Object.keys(ajaxData.errors).length) {
                            if (!$errorContainer.length) {
                                $errorContainer = $('<div class="alert alert-block alert-danger errorSummary"></div>');
                                $form.prepend($errorContainer);
                            }

                            var errorHtml = '';
                            $.each(ajaxData.errors, function (field, errors) {
                                errorHtml += '<p>' + errors.join('<br/> ') + '</p>';
                            });

                            $errorContainer.html(errorHtml);
                            $errorContainer.removeClass('hidden');
                        } else if ($errorContainer.length) {
                            $errorContainer.addClass('hidden');
                        }
                    }
                });
            }
        });
    };

    /**
     * Copy elem content
     *
     * @param {Object} $input
     */
    App.CopyToClipboard = function ($button) {
        $button.click(function (e) {
            e.preventDefault();

            var elemId = $(this).data('target-id');

            if (elemId !== undefined) {
                var elem = document.getElementById(elemId);
                if (App.copyToClipboard(elem)) {
                    App.toastAlert('Đã copy');
                } else {
                    App.toastAlert('Chưa copy được nội dung');
                }
            }
        });
    };

    /*
     * Popover
     **/
    App.Popover = function ($elem) {
        $elem.popover({html: true}).click(function (e) {
            e.preventDefault();
            $('.popover-content').append("<i class='fa fa-close close-popover'></i>");

            $('.close-popover').click(function (e) {
                (($elem.popover('hide').data('bs.popover') || {}).inState || {}).click = false
            });
        });

        //Hide popover when click outside
    };

    App.PopoverRegister = function (selector) {
        App.register(selector, 'App.Popover');

        $(document).on('click', function (e) {
            $(selector).each(function () {
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    (($(this).popover('hide').data('bs.popover') || {}).inState || {}).click = false  // fix for BS 3.3.6
                }
            });
        });
        //Hide popover when click outside
    };

    // *********************************************************************
    App.register('a.FieldAdder, input.FieldAdder', 'App.FieldAdder');

    App.register('a.FieldRemover', 'App.FieldRemover');

    App.register('input:checkbox.Disabler, input:radio.Disabler', 'App.Disabler');

    // Handle all forms
    App.register('form.lnxForm, .MultiSubmitFix', 'App.MultiSubmitFix');

    App.register('form.ajaxSubmit', 'App.AjaxSubmit');

    App.register('.copyButton', 'App.CopyToClipboard');

    App.PopoverRegister('[data-toggle="popover"]');

    var isScrolled = false;
    $(window).on('load', function () {
        if (isScrolled || !window.location.hash)
        {
            return;
        }

        var hash = window.location.hash.replace(/[^a-zA-Z0-9_-]/g, ''),
                $match = hash ? $('#' + hash) : $();

        if ($match.length)
        {
            $match.get(0).scrollIntoView(true);
        }
    });

    $(window).bind('beforeunload', function () {
        $('#loading').show();
        setTimeout(function() { $('#loading').hide(); }, 15000);
    });

    /**
     * Use jQuery to initialize the system
     */
    $(function ()
    {
        App.init();

        if (window.location.hash)
        {
            // do this after the document is ready as triggering it too early
            // causes the initial hash to trigger a scroll
            $(window).one('scroll', function (e) {
                isScrolled = true;
            });
        }

        $(document).on('click', 'a.sidebar-toggle', function (e) {
            $.setCookie('hide_sidebar', $('body').hasClass('sidebar-collapse') ? 1 : 0);
        });

        $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').not('#loading').length);
            $(this).css('z-index', zIndex);
            setTimeout(function () {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });

        $(document).on('focus', '.ModalTrigger', function (e) {
            App.ModalTrigger(this, $(this).data('target'));
            e.preventDefault();
            e.stopPropagation();
        });

        $(document).on('hidden.bs.modal', function (e) {
            if (!$(e.target).data('cached')) {
                $(e.target).removeData('bs.modal');
            }

            if ($('.modal.in').length > 0) {
                $('body').addClass('modal-open');
            }
        });

        $('#loading').fadeOut();
    });
}(jQuery, this, document);