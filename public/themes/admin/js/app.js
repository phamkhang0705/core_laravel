var App = App || {};

!function (window, $, App) {
    App.log = function (msg) {
        if (typeof console == 'object') {
            window.console.log(msg);
        }
    };

    App.on = function (event, element, callback) {
        /* Used jQbox-App-likeuery 1.7 event handler */
        $('body').on(event, element, function (e) {
            callback.apply(this, arguments); // Used arguments to fixed error in IE

            // e.preventDefault();
        });
    };

    App.alert = function ($msg) {
        alert($msg);
    };

    App.initHourTimePicker = function () {
        $('._hour_ ').datetimepicker({
            sideBySide: true,
            format: 'HH:mm'
        });
    };

    App.refresh = function (url, timeout) {
        timeout = typeof (timeout) == 'undefined' ? 0 : timeout;
        return window.setTimeout(function () {
            if (typeof (url) == 'undefined' || url === '') {
                window.location.reload()
            } else {
                window.location = url;
            }
        }, timeout);
    };

    App.changeUrl = function (title, url) {
        if (typeof (history.pushState) != "undefined") {
            var obj = {
                Title: title,
                Url: url
            };
            history.pushState(obj, obj.Title, obj.Url);
        } else {
            window.location.href = url;
        }
    };

    App.stripTag = function (text) {
        return text.replace(/<[^>]+>/g, '');
    };

    App.showConfirm = function (title, message, callback) {
        swal({
            title: title,
            text: message,
            type: "",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Xác nhận",
            cancelButtonText: "Hủy",
            closeOnConfirm: false
        }, function (isConfirm) {
            if (typeof callback == 'function') {
                callback.call(this, isConfirm);
            }
            swal.close();
        });
    };

    App.showWithTitleMessage = function (title, message) {
        swal(title, message);
    };

    App.showPromptMessage = function (title, text, confirmButtonText, cancelButtonText, callback) {
        swal({
            title: title,
            text: text,
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonColor: "#DD6B55",
            animation: "slide-from-top",
            inputPlaceholder: 'Nhập nội dung',
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText
        }, function (inputValue) {
            if (inputValue === false) return false;

            inputValue = inputValue.trim();

            if (inputValue === "") {
                swal.showInputError("Bạn chưa nhập nội dung!");

                return false
            }

            if (typeof callback == 'function') {
                callback.call(this, inputValue);
            }
        });
    };

    App.validUrl = function (value) {
        return /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})).?)(?::\d{2,5})?(?:[/?#]\S*)?$/i.test(value);
    };

    App.validEmail = function (value) {
        return /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(value);
    };

    App.sweetDeleteItemMessage = function (url, ids, callback, options) {
        var title = "Bạn chắc chắn muốn xóa?",
            text = "";

        options = options || {};

        if (options.title != undefined) {
            title = options.title;
        }

        if (options.text != undefined) {
            text = options.text;
        }

        swal({
            title: title,
            text: text,
            type: "error",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Đồng ý",
            cancelButtonText: "Hủy",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        ids: ids
                    },
                    success: function (response) {
                        if (response.status == 200 || response.status == 1) {
                            if (typeof callback == 'function') {
                                callback(response);
                                swal.close();
                            } else {
                                //Sv.setCookie("window_mgsSuccess", response.message);
                                App.refresh();
                                /*swal({
                                    title: "Thông báo",
                                    text: "Bạn đã xóa thành công. Thông báo tự tắt trong 2s.",
                                    type: "success",
                                    timer: 2000,
                                    confirmButtonText: "OK",
                                    closeOnConfirm: false
                                }, function () {
                                    App.refresh();
                                });*/
                            }
                        } else {
                            swal.close();
                            Sv.ToTop();
                            Sv.showMgs(response.message, false);
                            // swal({
                            //     title: "Thông báo",
                            //     text: response.message,
                            //     type: "error",
                            //     timer: 2000,
                            //     confirmButtonText: "OK",
                            //     closeOnConfirm: false
                            // });
                        }
                    }
                });
            }
        });
    };

    App.showNotification = function (colorName, text, placementFrom, placementAlign, animateEnter, animateExit) {
        if (colorName === null || colorName === '') {
            colorName = 'bg-black';
        }
        if (text === null || text === '') {
            text = 'Turning standard Bootstrap alerts';
        }
        if (animateEnter === null || animateEnter === '') {
            animateEnter = 'animated fadeInDown';
        }
        if (animateExit === null || animateExit === '') {
            animateExit = 'animated fadeOutUp';
        }
        var allowDismiss = true;

        $.notify({
            message: text
        }, {
            type: colorName,
            allow_dismiss: allowDismiss,
            newest_on_top: true,
            timer: 3,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            animate: {
                enter: animateEnter,
                exit: animateExit
            },
            template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
        });
    };

    App.getDistrictWithProvince = function (province_id, district_id) {
        if (province_id == '') {
            return;
        }

        district_id = district_id || '';

        $.ajax({
            url: '/province/district',
            type: 'post',
            data: {
                id: province_id,
                district_id: district_id
            },
            beforeSend: function () {
                $('select[name=district]').attr('disabled');
            },
            success: function (response) {
                $('select[name=district]').html(response.data.html);

                $('select[name=district]').removeAttr('disabled');

                $('select[name=district]').selectpicker("refresh");
            }
        });
    };

    App.mask = function (show) {
        show = show || false;

        if (show == true) {
            $('#mask').addClass('in');
        } else {
            $('#mask').removeClass('in');
        }
    };
    App.post = function (url, data, showMask, callback) {
        $.ajax({
            url: url,
            data: data,
            type: 'post',
            cache: true,
            beforeSend: function () {
                if (showMask)
                    App.mask(true);
            },
            complete: function () {
                if (showMask)
                    App.mask(false);
            },
            success: function (response) {
                if (callback && typeof callback == 'function') {
                    callback.call(this, response);
                }
            },
            error: function (e) {
                App.showWithTitleMessage("Thông báo", "Có lỗi trong quá trình xử lý");
            }

        });
    };

    App.ajax = function (url, data, method, showMask, callback, callbackerr) {
        $.ajax({
            url: url,
            data: data,
            type: method,
            cache: true,
            beforeSend: function () {
                if (showMask)
                    App.mask(true);
            },
            complete: function () {
                if (showMask)
                    App.mask(false);
            },
            success: function (response) {
                if (showMask)
                    App.mask(false);

                if (callback && typeof callback == 'function') {
                    callback.call(this, response);
                }
            },
            error: function (e) {
                if (callback && typeof callbackerr == 'function') {
                    callbackerr.call(this, e);
                } else if (e.status == 422 && $(".cms_element_alert").length > 0) {
                    var mgs = Object.values(e.responseJSON.errors);
                    Sv.showMgs(mgs.join("<br />"), false);
                } else {
                    App.showWithTitleMessage("Thông báo", "Có lỗi trong quá trình xử lý");
                }
            }

        });
    };

    App.ajaxFile = function (url, data, method, showMask, callback, callbackerr) {
        return $.ajax({
            url: url,
            data: data,
            type: method,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                if (showMask)
                    App.mask(true);
            },
            complete: function () {
                if (showMask)
                    App.mask(false);
            },
            success: function (response) {
                if (showMask)
                    App.mask(false);

                if (callback && typeof callback == 'function') {
                    callback.call(this, response);
                }
            },
            error: function (e) {
                if (callback && typeof callbackerr == 'function') {
                    callbackerr.call(this, e);
                } else if (e.status == 422 && $(".cms_element_alert").length > 0) {
                    var mgs = Object.values(e.responseJSON.errors);
                    Sv.showMgsAuto(mgs.join("<br />"), false);
                } else {
                    App.showWithTitleMessage("Thông báo", "Có lỗi trong quá trình xử lý");
                }
            }

        });
    };

    App.select_language = {
        inputTooShort: function (args) {
            var remainingChars = args.minimum - args.input.length;
            var message = 'Vui lòng nhập tối thiểu ' + remainingChars + ' ký tự';
            return message;
        },
        noResults: function () {
            return "Không có dữ liệu";
        },
        searching: function () {
            return "Đang tìm kiếm...";
        },
        maximumSelected: function (args) {
            // args.maximum is the maximum number of items the user may select
            return "Error loading results";
        },
        inputTooLong: function (args) {
            return "You typed too much";
        },
        errorLoading: function () {
            return "Có lỗi";
        },
        loadingMore: function () {
            return "Loading more results";
        },
    };
    App.select2Ajax = function ($e, url, callback) {
        var placeholder_str = $e.attr('placeholder');
        $e.select2({
            language: App.select_language,
            width: '100%',
            ajax: {
                url: url,
                type: 'POST',
                dataType: 'json',
                delay: 200,
                cache: true,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    if (callback && typeof callback == 'function') {
                        return callback.call(this, data, params);
                    }
                    return {
                        results: data.items
                    };
                }
            },
            placeholder: (placeholder_str && placeholder_str.length) > 0 ? placeholder_str : "Vui lòng chọn",
            // escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 0,
            // templateResult: formatRepo,
            // templateSelection: formatRepoSelection
        });
    };

    App.inArray = function (arr, val) {
        if (!Array.isArray(arr)) {
            return -1;
        }
        return arr.indexOf(val.toString()) > -1;
    };

    App.b64toBlob = function (b64Data, contentType, sliceSize) {
        contentType = contentType || '';
        sliceSize = sliceSize || 512;

        var byteCharacters = atob(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

        var blob = new Blob(byteArrays, {type: contentType});

        return blob;
    };

    // DOM ready
    $(function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name=csrf-token]').getAttribute("content")
            }
        });

        $.fn.addInputErrorMsg = function (msg) {
            var parent = this.closest('.form-group');

            parent.addClass('has_error');

            if (parent.find('label.error').length == 0) {
                parent.append('<label class="error">' + msg + '</label>')
            } else {
                parent.find('label.error').val(msg);
            }
        };

        App.on('change', '#item-checkbox--all', function (e) {
            var $this = $(this),
                parent = $this.closest('table'),
                checked = $this.is(':checked');

            if (checked) {
                $('input.item-checkbox').prop('checked', true);
            } else {
                $('input.item-checkbox').prop('checked', false);
            }
        });

        App.on('change', '#item-checkbox-before--all', function (e) {
            var $this = $(this),
                parent = $this.closest('table'),
                checked = $this.is(':checked');

            if (checked) {
                $('input.item-checkbox-before').prop('checked', true);
            } else {
                $('input.item-checkbox-before').prop('checked', false);
            }
        });

        App.on('change', '.item_checkbox_all', function (e) {
            var $this = $(this),
                parent = $this.closest('table'),
                checked = $this.is(':checked');

            if (checked) {
                parent.find('input.item_checkbox').prop('checked', true);
            } else {
                parent.find('input.item_checkbox').prop('checked', false);
            }
        });
        //
        App.on('click', '.delete-item--selected', function (e) {
            var $this = $(this),
                url = $this.data('href'),
                text = $this.data('text'),
                ids = [];

            $('input.item-checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            if (text == '' || text == undefined) {
                text = 'Bạn chưa chọn thông tin cần xóa';
            }

            if (ids.length == 0) {
                swal({
                    title: "Thông báo",
                    text: text,
                    type: "error",
                    timer: 2000,
                    confirmButtonText: "OK",
                    closeOnConfirm: false
                });

                return false;
            }

            App.sweetDeleteItemMessage(url, ids);

            e.preventDefault();
        });


        App.on('click', '.action--selected', function (e) {
            var $this = $(this),
                url = $this.data('href'),
                text = $this.data('text'),
                ids = [];

            $('input.item-checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length == 0) {
                swal({
                    title: "Thông báo",
                    text: 'Bạn chưa chọn thông tin cần thao tác',
                    type: "error",
                    timer: 2000,
                    confirmButtonText: "OK",
                    closeOnConfirm: false
                });

                return false;
            }

            swal({
                title: '',
                text: text,
                type: "error",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Đồng ý",
                cancelButtonText: "Hủy",
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            ids: ids
                        },
                        success: function (response) {
                            if (response.status == 200 || response.status == 1) {
                                App.refresh();

                                /*if (callback && typeof callback == 'function') {
                                    callback(response);
                                    swal.close();
                                } else {
                                    App.refresh();
                                }*/
                            } else {
                                swal({
                                    title: "Thông báo",
                                    text: response.message,
                                    type: "error",
                                    timer: 2000,
                                    confirmButtonText: "OK",
                                    closeOnConfirm: false
                                });
                            }
                        }
                    });
                }
            });

            e.preventDefault();
        });

        App.on('click', '.sweet-alert--action', function (e) {
            var $this = $(this),
                url = $this.data('href'),
                ids = $this.data('ids'),
                title = $this.data('title'),
                text = $this.data('text');

            App.sweetDeleteItemMessage(url, ids, null, {
                text: text,
                title: title
            });

            return false;
        });

        App.on('click', '.sweet-alert--delete', function (e) {
            var $this = $(this),
                url = $this.data('href'),
                id = $this.data('id'),
                title = $this.data('title'),
                text = $this.data('text');

            if (!title || title == '')
                title = "Bạn chắc chắn muốn xóa?";
            if (!text || text == '')
                text = "";

            swal({
                title: title,
                text: text,
                type: "error",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Đồng ý xóa",
                cancelButtonText: "Hủy",
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            id: id
                        },
                        success: function (response) {
                            if (response.status == 200 || response.status == 1) {

                                Sv.setCookie("window_mgsSuccess", response.message);
                                App.refresh();

                            } else {
                                swal({
                                    title: "Thông báo",
                                    text: response.message,
                                    type: "error",
                                    timer: 2000,
                                    confirmButtonText: "OK",
                                    closeOnConfirm: false
                                });
                            }
                        }
                    });
                }
            });

        });


        App.on('click', '.sweet-alert--delete-mutil', function (e) {
            var $this = $(this),
                url = $this.data('href'),
                ids = $this.data('ids'),
                title = $this.data('title'),
                text = $this.data('text');

            if (!title || title == '')
                title = "Bạn chắc chắn muốn xóa?";
            if (!text || text == '')
                text = "";

            swal({
                title: title,
                text: text,
                type: "error",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Đồng ý xóa",
                cancelButtonText: "Hủy",
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            ids: ids
                        },
                        success: function (response) {
                            if (response.status == 200 || response.status == 1) {
                                // if (callback && typeof callback == 'function') {
                                //     callback(response);
                                //     swal.close();
                                // } else {
                                Sv.setCookie("window_mgsSuccess", response.message);
                                App.refresh();
                                // }
                            } else {
                                swal({
                                    title: "Thông báo",
                                    text: response.message,
                                    type: "error",
                                    timer: 2000,
                                    confirmButtonText: "OK",
                                    closeOnConfirm: false
                                });
                            }
                        }
                    });
                }
            });

        });

        App.on('click', '.sweet-alert--action-2', function (e) {
            var $this = $(this),
                url = $this.data('href'),
                ids = $this.data('ids'),
                callback = $this.data('callback');

            App.sweetDeleteItemMessage(url, ids, eval(callback));
        });

        App.on('change', '.image-upload > input[type=file]', function (event) {
            var $this = $(this),
                reader = new FileReader(),
                target_files = event.target.files;
            reader.onload = function (e) {
                $this.parent('.image-upload').css('background-image', 'url("' + e.target.result + '")');
            };

            reader.readAsDataURL(target_files[0]);
        });

        App.on('change', '.image-upload-2 > input[type=file]', function (event) {
            var $this = $(this),
                reader = new FileReader(),
                target_files = event.target.files;
            reader.onload = function (e) {
                $this.closest('.image-upload--form').find('img').attr('src', e.target.result);
            };

            reader.readAsDataURL(target_files[0]);
        });


        App.on('change', '.image-multiple--upload', function (event) {
            var $this = $(this),
                reader = new FileReader(),
                target_files = event.target.files,
                parents = $this.parents('.form-group');

            $.each(event.originalEvent.srcElement.files, function (i, file) {
                var reader = new FileReader(),
                    img = $('<img>').attr('src', event.target.result).css('width', '160px');

                reader.onloadend = function () {
                    img.attr('src', reader.result);
                };

                reader.readAsDataURL(file);

                parents.append(img);
            });
        });

        App.on('change', 'select[name=province]', function (e) {
            var id = $(this).val();

            if (id != '') {
                App.getDistrictWithProvince($(this).val());
            }
        });

        App.on('click', '.form-filter--action', function (e) {
            $('#form-filter--type').val($(this).data('type'));
            $('#form-filter').submit();
        });

        // App.on('click', 'button[type=submit]', function (e) {
        //     if (!$(this).hasClass('no_disable')) {
        //         $(this).attr('disabled', 'disabled');
        //     }
        //
        //     $(this).closest('form').submit();
        // });

        App.on('change', 'select.__action__', function (e) {
            var $this = $(this);
        });

        $('input.price_mask').inputmask({
            alias: 'decimal',
            groupSeparator: '.',
            rightAlign: false,
            autoGroup: true
        });

        $(document).on('click', 'tr.fill_checkbox_item', function (event) {
            if (event.target.type == 'checkbox') {
                return false;
            }

            var $target = $(event.target),
                $parent = $target.closest('tr'),
                $checkbox = $parent.find('input[type=checkbox]');

            if ($checkbox.is(':checked')) {
                $checkbox.prop('checked', false);
            } else {
                $checkbox.prop('checked', true);
            }

            return false;
        });

        $('.date_range_1').daterangepicker({
            autoUpdateInput: false,
            opens: 'left',
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end, label) {

        });
        $('.date_range_1').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('.date_range_1').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        var xhr;
        App.on('keyup', '.__merchant_search__ .bs-searchbox > input', function (e) {
            var $this = $(this);

            if (e.keyCode == 37 || e.keyCode == 38 || e.keyCode == 39 || e.keyCode == 40) {
                return false;
            }

            if (xhr && xhr.readyState != 4) {
                xhr.abort();
            }

            xhr = $.ajax({
                url: '/merchant/search',
                type: 'get',
                data: {
                    keyword: $this.val()
                },
                beforeSend: function () {
                    $('select.__merchant_search__').html('<option value="">Đang tải dữ liệu...</option>');

                    $('select.__merchant_search__').selectpicker("refresh");
                },
                success: function (response) {
                    console.log(response);

                    if (response.status == 200) {
                        var html = '';
                        response.data.forEach(function (item) {
                            html += '<option value="' + item.id + '" data-tokens = "' + item.token + '">' + item.name + '</option>';
                        });

                        $('select.__merchant_search__').html(html);
                        $('select.__merchant_search__').selectpicker("refresh");
                    }
                }
            });
        });
        
        App.on('change', '#item-checkbox--all-search', function (e) {
            var $this = $(this),
                parent = $this.closest('table'),
                checked = $this.is(':checked');
            if (checked) {
                $('input.item-checkbox-search').prop('checked', true);
            } else {
                $('input.item-checkbox-search').prop('checked', false);
            }
        });

    }); // End DOM ready
}(window, window.jQuery, window.App);