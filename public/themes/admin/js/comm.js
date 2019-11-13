Array.prototype.unique = function () {
    var a = this.concat();
    for (var i = 0; i < a.length; ++i) {
        for (var j = i + 1; j < a.length; ++j) {
            if (a[i] === a[j])
                a.splice(j--, 1);
        }
    }
    return a;
};
Array.prototype.uniqueByKey = function (key) {
    var a = this.concat();
    for (var i = 0; i < a.length; ++i) {
        for (var j = i + 1; j < a.length; ++j) {
            if (a[i][key] === a[j][key])
                a.splice(j--, 1);
        }
    }
    return a;
};

String.prototype.encodedStr = function () {
    return this.replace(/[\u00A0-\u9999<>\&]/gim, function (i) {
        return '&#' + i.charCodeAt(0) + ';';
    });
};

Number.prototype.toRad = function () {
    return this * Math.PI / 180;
}

function toRad(Value) {
    /** Converts numeric degrees to radians */
    return Value * Math.PI / 180;
}


function _dynamicSort(property) {
    var sortOrder = 1;
    if (property[0] === "-") {
        sortOrder = -1;
        property = property.substr(1);
    }
    return function (a, b) {
        var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
        return result * sortOrder;
    }
}

function _dynamicSortMultiple() {
    /*
     * save the arguments object as it will be overwritten
     * note that arguments object is an array-like object
     * consisting of the names of the properties to sort by
     */
    var props = arguments;
    return function (obj1, obj2) {
        var i = 0,
            result = 0,
            numberOfProperties = props.length;
        /* try getting a different result from 0 (equal)
         * as long as we have extra properties to compare
         */
        while (result === 0 && i < numberOfProperties) {
            result = _dynamicSort(props[i])(obj1, obj2);
            i++;
        }
        return result;
    }
};


Object.defineProperty(Array.prototype, "sortBy", {
    enumerable: false,
    writable: true,
    value: function () {
        return this.sort(_dynamicSortMultiple.apply(null, arguments));
    }
});


var Sv = Sv || {};

!function (window, $, Sv) {
    Sv.log = function (msg) {
        if (typeof console == 'object') {
            window.console.log(msg);
        }
    };

    Sv.on = function (event, element, callback) {
        /* Used jQbox-App-likeuery 1.7 event handler */
        $('body').on(event, element, function (e) {
            callback.apply(this, arguments); // Used arguments to fixed error in IE

            // e.preventDefault();
        });
    };

    Sv.alert = function ($msg, callback) {
        swal({
            title: "Thông báo",
            text: $msg,
        }, function (e) {
            if (typeof callback == 'function') {
                callback.call();
            }
        });
    };

    Sv.numberToString = function (value) {
        return value != null ? value.toString().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') : "0";
    };
    Sv.numberToString2 = function (value) {
        var v = Math.round(value * 100) / 100;
        return v != null ? v.toString().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') : "0";
    };

    Sv.sprintf = function (str) {
        var args = arguments,
            flag = true,
            i = 1;

        str = str.replace(/%s/g, function () {
            var arg = args[i++];

            if (typeof arg === 'undefined') {
                flag = false;
                return '';
            }
            return arg;
        });
        return flag ? str : '';
    };

    Sv.getPropertyFromOther = function (list, from, to, value) {
        var result = '';
        $.each(list, function (i, item) {
            if (item[from] === value) {
                result = item[to];
                return false;
            }
            return true;
        });
        return result;
    };


    Sv.escapeHTML = function (text) {
        if (typeof text === 'string') {
            return text
                .replace(/</g, '')
                .replace(/>/g, '')
                .replace(/"/g, '');
            // .replace(/&/g, '&amp;')
            // .replace(/</g, '&lt;')
            // .replace(/>/g, '&gt;')
            // .replace(/"/g, '&quot;')
            // .replace(/'/g, '&#039;')
            // .replace(/`/g, '&#x60;');
        }
        return text;
    };

    Sv.isIEBrowser = function () {
        return !!(navigator.userAgent.indexOf("MSIE ") > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./));
    };

    Sv.objectKeys = function () {
        if (!Object.keys) {
            Object.keys = (function () {
                var hasOwnProperty = Object.prototype.hasOwnProperty,
                    hasDontEnumBug = !({
                        toString: null
                    }).propertyIsEnumerable('toString'),
                    dontEnums = [
                        'toString',
                        'toLocaleString',
                        'valueOf',
                        'hasOwnProperty',
                        'isPrototypeOf',
                        'propertyIsEnumerable',
                        'constructor'
                    ],
                    dontEnumsLength = dontEnums.length;

                return function (obj) {
                    if (typeof obj !== 'object' && (typeof obj !== 'function' || obj === null)) {
                        throw new TypeError('Object.keys called on non-object');
                    }

                    var result = [],
                        prop, i;

                    for (prop in obj) {
                        if (hasOwnProperty.call(obj, prop)) {
                            result.push(prop);
                        }
                    }

                    if (hasDontEnumBug) {
                        for (i = 0; i < dontEnumsLength; i++) {
                            if (hasOwnProperty.call(obj, dontEnums[i])) {
                                result.push(dontEnums[i]);
                            }
                        }
                    }
                    return result;
                };
            }());
        }
    };


    Sv.showMgs = function (msg, status, callback) {
        var $e = $(".body .cms_element_alert");
        if (msg == null || msg.length == 0) {
            $e.hide();
        } else {
            Sv.showMgsElement($e, msg, status, callback);
        }
    };
    Sv.showMsg = function (msg, status, callback) {
        Sv.showMgs(msg, status, callback);
    };

    Sv.TimeOutMsg;
    Sv.showMgsAuto = function (msg, status, callback) {
        Sv.showMgs(msg, status, function () {
            clearTimeout(Sv.TimeOutMsg);
            Sv.TimeOutMsg = setTimeout(() => {
                $(".body .cms_element_alert").hide();
            }, 5000);
        });
    };
    Sv.showMsgAuto = function (msg, status, callback) {
        Sv.showMgsAuto(msg, status, callback);
    };


    Sv.showMgsElement = function ($e, msg, status, callback) {
        if ($e.length <= 0)
            Sv.alert(msg, callback);
        else {
            var htmlstr = "";
            // false
            if (status == 0 || status == false || status == "0" || status == "00") {
                htmlstr = '<div class="alert alert-danger alert-dismissible" role="alert">' +
                    '       <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '           <span aria-hidden="true">×</span>' +
                    '       </button>' +
                    msg +
                    '   </div>';
            } else {
                htmlstr = '<div class="alert bg-green alert-dismissible" role="alert">' +
                    '       <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '           <span aria-hidden="true">×</span>' +
                    '       </button>' +
                    msg +
                    '   </div>';
            }
            $e.html(htmlstr);
            $e.show();
            if (typeof callback == 'function') {
                callback.call(msg, status);
            }
        }
    };

    // Hàm thiết lập Cookie -- default 30p
    Sv.setCookie = function (name, value, days) {
        var expires = "";
        if (!days) days = 1;
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + "; path=/";
    };

    // Hàm lấy Cookie
    Sv.getCookie = function (name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0)
                return c.substring(nameEQ.length, c.length);
        }
        return "";
    };

    // xóa cookie
    Sv.clearCookie = function (name) {
        Sv.setCookie(name, "", -1);
    }


    Sv.select2Ajax = function ($e, url, callback) {
        var placeholder_str = $e.attr('placeholder');
        $e.select2({
            language: App.select_language,
            width: '100%',
            ajax: {
                url: url,
                type: 'POST',
                dataType: 'json',
                delay: 200,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    if (typeof callback == 'function') {
                        return callback.call(this, data, params);
                    } else
                        return {
                            results: data.items
                        };
                },
                cache: true
            },
            placeholder: (placeholder_str && placeholder_str.length) > 0 ? placeholder_str : "Vui lòng chọn",
            // escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 0,
            // templateResult: formatRepo,
            // templateSelection: formatRepoSelection
        });
    };

    Sv.popupDelete = function (callback, options) {
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
            confirmButtonText: "Đồng ý xóa",
            cancelButtonText: "Hủy",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                callback(isConfirm);
            }
        });
    };

    Sv.Confirm = function (title, message, callback) {
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

    Sv.SetupModal = function (option, callbackOpen, callbackSave) {
        if (option.id)
            option.modalId = option.id;
        if (!option.modalId)
            option.modalId = "modalOze";
        var init = 0;
        $modal = $("#" + option.modalId);
        if ($modal.length == 0) {
            init = 1;
            Sv.InitModal(option);
            $modal = $("#" + option.modalId);
        } else {
            if (option.button) {
                $("#" + option.modalId).find(".modal-footer").html(option.button);
            }
        }

        var $btn = $modal.find("#btnSave");
        if ($btn.length == 0) {
            $btn = $modal.find("#btnSave_" + option.modalId);
        }
        $modal.off('show.bs.modal').on('show.bs.modal', function () {
            if (init == 0 && option.title) {
                $modal.find(".modal-title").find("label").html(option.title);
            }
            $modal.find(".modal-body").html('<p>loading..</p>');
            if (option.html != undefined) {
                $modal.find(".modal-body").html(option.html);
                bindModal(option.html);
            } else if (option.data != undefined) {
                $.post(option.url, option.data, function (d) {
                    $modal.find(".modal-body").html(d);
                    bindModal(d);
                });
            } else {
                $modal.find(".modal-body").load(option.url, function (d) {
                    bindModal(d);
                });
            }
        });

        function bindModal(d) {
            //Sv.SetupInputMask();
            if (typeof callbackOpen === "function") callbackOpen(d);

            $btn.off("click").click(function (e) {
                if (typeof callbackSave === "function") callbackSave(d, e);
            });

        }

        $modal.modal("show");
    };


    // setup open modal
    Sv.SetupModalPost = function (option, callbackOpen, callbackSave) {
        if (!option.modalId)
            option.modalId = "modalDetails";
        var init = 0;

        $modal = $("#" + option.modalId);
        if ($modal.length == 0) {
            init = 1;
            Sv.InitModal(option);
            $modal = $("#" + option.modalId);
        }
        var $btn = $modal.find("#" + option.modalId + " #btnSave");
        if ($btn.length == 0) {
            $btn = $modal.find("#btnSave_" + option.modalId);
        }

        $modal.off('show.bs.modal');
        $modal.on('show.bs.modal', function () {
            if (option.title && init == 0) {
                $modal.find(".modal-title").find("label").html(option.title);
            }
            $modal.find(".modal-body").html('<p>loading..</p>');
            $.ajax({
                url: option.url,
                type: 'post',
                data: option.data,
                cache: true,
                success: function (response) {
                    $modal.find(".modal-body").html(response.html);
                    if (typeof callbackOpen === "function") callbackOpen(response);
                    $btn.off("click").click(function (e) {
                        if (typeof callbackSave === "function") callbackSave(response, e);
                    });
                }
            });
        });
        $modal.modal("show");
    }

    // init
    Sv.InitModal = function (option) {
        var html = '';
        html += '<div id="' + option.modalId + '" class="modal fade" role="dialog" data-backdrop="static"        >';
        html += '   <div class="modal-dialog ' + (option.modalclass != undefined ? option.modalclass : "modal-lg") + '">';
        html += '       <div class="modal-content">';
        html += '           <div class="modal-header">';
        // html += '               <button type="button" class="close" data-dismiss="modal">&times;</button>';
        html += '               <h4 class="modal-title btn-header"><label>' + option.title + '</label></h4>';
        html += '           </div>';
        html += '           <div class="modal-body">';
        html += '               <div class="modal-body-content">';
        html += '                   <p>Loading...</p>';
        html += '               </div>';
        html += '           </div>';
        html += '           <div class="modal-footer text-center">';

        if (option.button) {
            html += option.button;
        } else {
            html += '          <button type="button" class="btn bg-red btn-lg waves-effect" data-dismiss="modal">Hủy</button>';
            html += '          <button type="button" id="btnSave_' + option.modalId + '" class="btn bg-red btn-lg waves-effect" > Lưu</button> ';
        }

        html += '           </div>';
        html += '       </div>';
        html += '   </div>';
        html += '</div>';
        $("body").append(html);
    };

    Sv.AddMsg = function (msg, newMsg) {
        if (!msg || msg.length == 0)
            msg = newMsg;
        else
            msg += '<br />' + newMsg;
        return msg;
    };
    Sv.ToTop = function () {
        $("html,body").animate({
            scrollTop: 0
        }, "slow");
    };

    Sv.isAndroidFn = function (fntrue, fnfalse) {
        var ua = navigator.userAgent.toLowerCase();
        isAndroid = ua.indexOf("android") > -1;
        if (isAndroid) {
            fntrue();
        } else {
            fnfalse();
        }
    };

    Sv.SetupInputMask = function () {
        Sv.isAndroidFn(
            function () {
                $("body").find(".percent-mask").on().prop('type', 'number');
                $("body").find(".number-mask").on().prop('type', 'number');
                $("body").find(".money-mask").on().prop('type', 'number');
                $("body").find(".float-mask").on().prop('type', 'number');
                $("body").find(".percent-mask-left").on().prop('type', 'number');
                $("body").find(".number-mask-left").on().prop('type', 'number');
                $("body").find(".money-mask-left").on().prop('type', 'number');

                $("body").find(".float-mask-2").on().prop('type', 'number');
                $("body").find(".float-mask-3").on().prop('type', 'number');
                $("body").find(".float-mask-left-2").on().prop('type', 'number');
                $("body").find(".float-mask-left-3").on().prop('type', 'number');


                $("body").find(".percent-mask.text-center").on().prop('type', 'number');
            },
            function () {
                var option = {
                    alias: 'decimal',
                    groupSeparator: '.',
                    /* Ký tự phân cách giữa phần trăm, nghìn... */
                    radixPoint: ",",
                    /* Ký tự phân cách với phần thập phân */
                    autoGroup: true,
                    digits: 0,
                    /* Lấy bao nhiêu số phần thập phân, mặc định của inputmask là 2 */
                    autoUnmask: true,
                    /* Tự động bỏ mask khi lấy giá trị */
                    allowMinus: true,
                    /* Không cho nhập dấu trừ */
                    allowPlus: false,
                    /* Không cho nhập dấu cộng */
                    integerDigits: 15,
                    onUnMask: function (value) {
                        // var exp = /([^0-9]{1,3})+([^,]([^0-9]){1,2}){0,1}/g;
                        return value.replace(/\./g, '').replace(/\,/, '.');
                    },
                };

                $("body").find(".percent-mask.text-center").on().inputmask("percentage", {
                    placeholder: '',
                    radixPoint: ",",
                    autoUnmask: true,
                    rightAlign: false,
                });
                // rightAlign: right,
                $("body").find(".percent-mask").on().inputmask("percentage", {
                    placeholder: '',
                    radixPoint: ",",
                    autoUnmask: true,
                });


                $("body").find(".number-mask").on().inputmask(option);

                var o1 = option;
                o1.allowMinus = false;
                $("body").find(".money-mask").on().inputmask(o1);

                var o2 = option;
                o2.digits = 0;
                $("body").find(".float-mask").on().inputmask(o2);
                var ox2 = option;
                ox2.digits = 2;
                $("body").find(".float-mask-2").on().inputmask(ox2);
                var ox3 = option;
                ox3.digits = 3;
                $("body").find(".float-mask-3").on().inputmask(ox3);

                // rightAlign: false,
                $("body").find(".percent-mask-left").on().inputmask("percentage", {
                    placeholder: '',
                    radixPoint: ",",
                    autoUnmask: true,
                    rightAlign: false,
                });

                var option2 = {
                    alias: 'decimal',
                    groupSeparator: '.',
                    /* Ký tự phân cách giữa phần trăm, nghìn... */
                    radixPoint: ",",
                    /* Ký tự phân cách với phần thập phân */
                    autoGroup: true,
                    digits: 0,
                    /* Lấy bao nhiêu số phần thập phân, mặc định của inputmask là 2 */
                    autoUnmask: true,
                    /* Tự động bỏ mask khi lấy giá trị */
                    allowMinus: true,
                    /* Không cho nhập dấu trừ */
                    allowPlus: false,
                    /* Không cho nhập dấu cộng */
                    integerDigits: 15,
                    onUnMask: function (value) {
                        // var exp = /([^0-9]{1,3})+([^,]([^0-9]){1,2}){0,1}/g;
                        return value.replace(/\./g, '').replace(/\,/, '.');
                    },
                    rightAlign: false,
                };
                $("body").find(".number-mask-left").on().inputmask(option2);

                var o12 = option2;
                o12.allowMinus = false;
                $("body").find(".money-mask-left").on().inputmask(o12);

                var o22 = option2;
                o22.digits = 0;
                $("body").find(".float-mask-left").on().inputmask(o22);
                var o24 = option2;
                o24.digits = 2;
                $("body").find(".float-mask-left-2").on().inputmask(o24);
                var o23 = option2;
                o23.digits = 3;
                $("body").find(".float-mask-left-3").on().inputmask(o23);


            });
    };

    Sv.getFormData = function ($form) {
        var formData = new FormData();
        var unindexed_array = $form.serializeArray();
        // console.log(unindexed_array);
        $.map(unindexed_array, function (n, i) {
            formData.append(n['name'], n['value']);
        });
        return formData;
    };

    Sv.getFormObject = function ($form) {
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};
        $.map(unindexed_array, function (n, i) {
            $e = $('[name="' + n['name'] + '"]');
            var na = (n['name']).replace('[]', '');
            // select multiple
            if ($e[0] && $e[0].tagName == "SELECT" && $e.attr('multiple') != undefined) {
                indexed_array[na] = $e.val();
            }
            // input check box
            else if ($e[0] && $e[0].tagName == "INPUT" && $e[0].type == "checkbox") {
                var val = [];
                for (var x = 0; x < $e.length; x++) {
                    var $element = $($e[x]);
                    if ($element.is(":checked"))
                        val.push($element.val());
                }
                indexed_array[na] = val;
            } else {
                indexed_array[na] = n['value'];
            }
        });
        return indexed_array;
    };

    Sv.arrayDuplicates = function (arr) {
        var sorted_arr = arr.slice().sort();
        var results = [];
        for (var i = 0; i < sorted_arr.length - 1; i++) {
            if (sorted_arr[i + 1] == sorted_arr[i]) {
                results.push(sorted_arr[i]);
            }
        }
        return results;
    };


    // google api get location
    Sv.searchLocationAddress = function (address, callback) {
        if (!address) address = "Hà Nội";
        (new google.maps.Geocoder).geocode({
            'address': address
        }, function (results, status) {
            callback(status, results);
            // if (status == google.maps.GeocoderStatus.OK) {
            //     // lat = results[0].geometry.location.lat(),
            //     // lng = results[0].geometry.location.lng();
            //     callback( status, results);
            // }else{
            //     callback( status, results);
            // }
        });
    };

    // khoảng cách giữa 2 location (chim bay)
    Sv.geoDistance = function (lat1, lon1, lat2, lon2) {
        //Radius of the earth in:  1.609344 miles,  var R = 6371 km;
        var R = 6371000;
        var dLat = toRad(lat2 - lat1);
        var dLon = toRad(lon2 - lon1);
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        var c = Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)) * 2;
        return R * c;
    };

    Sv.formatMoney = function (value) {
        return value != null ? value.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') : 0;
    };

    Sv.loadChild = function ($e, $child, url) {
        $e.on('change', function () {
            App.ajax(url, {id: $e.val()}, 'post', false, function (respon) {
                if (respon.data.length <= 0) {
                    $child.html("");
                    $child.selectpicker('refresh');
                    return false;
                }
                $child.html("");
                var html = '<option value=\'0\'>Tất cả</option>';
                $.each(respon.data, function (i, it) {
                    var li = ('<option value=\'' + it.id + '\'>')
                        + (it.name)
                        + ('</option>');
                    html += li;
                });
                $child.html(html);
                $child.selectpicker('refresh');
            }, function () {
                $child.html("");
                $child.selectpicker('refresh');
            });
        });
    };
    Sv.ConvertTimestampToDateTime = function (timestamp, format = "HH:mm:ss DD/MM/YYYY") {
        return moment.unix(timestamp).format(format);
    }


}(window, window.jQuery, window.Sv);

$(document).ready(function () {
    var mgsSuccessAuto = Sv.getCookie("window_mgsSuccessAuto");
    if (mgsSuccessAuto != "") {
        Sv.showMgsAuto(mgsSuccessAuto);
        setTimeout(function () {
            Sv.clearCookie("window_mgsSuccessAuto")
        }, 500);
    }
    var mgsSuccess = Sv.getCookie("window_mgsSuccess");
    if (mgsSuccess != "") {
        Sv.showMgs(mgsSuccess);
        setTimeout(function () {
            Sv.clearCookie("window_mgsSuccess")
        }, 500);
    }

    var mgsError = Sv.getCookie("window_mgsError");
    if (mgsError != "") {
        Sv.showMgs(mgsError, false);
        setTimeout(function () {
            Sv.clearCookie("window_mgsError")
        }, 500);
    }

    $("button[data-clear='true']").click(function (e) {
        var $f = $(e.target).closest('form');
        if ($f.length > 0) {
            var elements = $f[0].elements;
            $f[0].reset();
            for (i = 0; i < elements.length; i++) {
                field_type = elements[i].type.toLowerCase();
                switch (field_type) {

                    case "number":
                        $(elements[i]).val("");
                        break;
                    case "email":
                    case "text":
                    case "password":
                    case "textarea":
                        $(elements[i]).val("");
                        //elements[i].value = "";
                        break;
                    case "radio":
                    case "checkbox":
                        if ($(elements[i]).checked) {
                            $(elements[i]).checked();
                        }
                        break;

                    case "select":
                    case "select-one":
                    case "select-multi":
                        var op1 = $(elements[i]).find("option:first-child").val();
                        if ($(elements[i]).closest('.bootstrap-select')) {
                            $(elements[i]).selectpicker('val', op1);
                        } else {
                            $(elements[i]).val(op1);
                        }

                        break;
                }
            }
            // xóa ảnh
            var $imgload = $f.find('.image-upload');
            if ($imgload.length > 0) {
                $imgload.css('background-image', 'url(\'http://cmsdev.vn:8080/img/image.png\')');
            }

        }
    });

    if (jQuery().inputmask) {

        Sv.SetupInputMask();
    }

    if (jQuery().daterangepicker) {


        /* daterangepicker */
        $('.date_range').daterangepicker({
            autoUpdateInput: false,
            opens: 'left',
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end, label) {

        });

        $('.date_range').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('.date_range').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });


        $('.datetime_range').daterangepicker({
            autoUpdateInput: false,
            opens: 'left',
            locale: {
                format: 'DD/MM/YYYY HH:MM'
            }
        }, function (start, end, label) {

        });

        $('.datetime_range').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('.datetime_range').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

    }

    if ($('#go_back').length > 0) {
        $('#go_back').on('click', function () {
            window.history.back();
        });
    }


});

// 2 scroll trong 1 table
$(function () {
    if ($('.scroll_fix_top').length > 0)
        $('.scroll_fix_top').on('scroll', function (e) {
            if ($('.table-responsive').length > 0)
                $('.table-responsive').scrollLeft($('.scroll_fix_top').scrollLeft());
        });
    if ($('.table-responsive').length > 0)
        $('.table-responsive').on('scroll', function (e) {
            if ($('.scroll_fix_top').length > 0)
                $('.scroll_fix_top').scrollLeft($('.table-responsive').scrollLeft());
        });
});
$(window).on('load', function (e) {
    if ($('.scroll_fix_top').length > 0) {
        $('.scroll_fix_top').css('width', '100%').css('overflow-y', 'hidden').css('overflow-x', 'scroll');
        $('.scroll_fix_top > div').css('height', '17px').width($('.table-responsive .table').width());
    }
});

$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};