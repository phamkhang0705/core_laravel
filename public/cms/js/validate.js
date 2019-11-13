$.validator.setDefaults({
    ignore: ":hidden:not(.chosen-select)",
    highlight: function (input) {
        $(input).closest('.form-line').addClass('error');
    },
    unhighlight: function (input) {
        $(input).closest('.form-line').removeClass('error');
    },
    errorPlacement: function (error, element) {
        var pa = $(element).closest('.form-group');
        var pa2 = $(element).closest('.form-line');
        if (pa.length > 0)
            pa.append(error);
        else if (pa2.length > 0)
            pa2.append(error);
        else
            $(element).parent().append(error);

    },
    onkeyup: function (element, event) {
        // console.log(event);
        if (event.which === 9 && this.elementValue(element) === "") {
            return;
        } else if (element.name in this.submitted || element === this.lastElement) {
            this.element(element);
        }
        this.checkForm();
        if (this.valid()) { // checks form for validity
            $(element).closest('form').find('button[type=submit]').prop('disabled', false);
        } else {
            $(element).closest('form').find('button[type=submit]').prop('disabled', true);
        }
    },

});

$.validator.addMethod("noOnlySpace", function (value, element) {
    value = $.trim(value);

    return this.optional(element) || value.length > 0;
});

$.validator.addMethod("noSpace", function (value, element) {
    value = $.trim(value);

    return this.optional(element) || value.length > 0;
}, "No space please and don't leave it empty");

$.validator.addMethod("number", function (value, element) {
    return this.optional(element) || /^-?\d+$/.test(value);
}, "A positive or negative non-decimal number please");

$.validator.addMethod("date_clm", function (value, element) {
    var rge = '^([012]{0,1}[0-9]:[0-6][0-9])[\\s]([1-9]|([012][0-9])|(3[01]))/([0]{0,1}[1-9]|1[012])/\\d\\d\\d\\d$';
    return (new RegExp(rge)).test(value);
}, $.validator.messages.date);

$.validator.addMethod("date_less_than", function (value, element, param) {
    value = $.trim(value);

    var time = $('input[name=' + param + ']').val();

    if (time == '') {
        return true;
    }

    time = time.split('/');

    var time_to = new Date();

    time_to.setFullYear(time[2], time[1], time[0]);

    var _value = value.split('/'),
        time_from = new Date();

    time_from.setFullYear(_value[2], _value[1], _value[0]);

    return time_from <= time_to;
});

$.validator.addMethod("date_great_than", function (value, element, param) {
    value = $.trim(value);

    var time = $('input[name=' + param + ']').val();

    if (time == '') {
        return true;
    }

    time = time.split('/');

    var time_to = new Date();

    time_to.setFullYear(time[2], time[1], time[0]);

    var _value = value.split('/'),
        time_from = new Date();

    time_from.setFullYear(_value[2], _value[1], _value[0]);

    return time_from >= time_to;
});

$.validator.addMethod("date_great_than_now", function (value, element, param) {//...
    value = $.trim(value);
    console.log(value);
    if (param) {
        var _value = value.split('/');

        var time = toTimestamp(_value[2], _value[1], _value[0], 0, 0, 0);
        console.log(time);
        var today = new Date(),
            d = today.getDate(),
            m = today.getMonth() + 1,
            y = today.getFullYear();

        var date_now = toTimestamp(y, m, d, 0, 0, 0);
        console.log(m);

        //console.log(date_now);
        if (time >= date_now) {
            return true;
        }
    }

    return false;
});

$.validator.addMethod("datetime_great_than_now", function (value, element, param) {
    value = $.trim(value);

    if (param) {
        var datetime = value.split(' ');
        var date = datetime[1].split('/');
        var time = datetime[0].split(':');
        var _time = toTimestamp(date[2], date[1], date[0], time[0], time[1], 0);

        var today = new Date(),
            d = today.getDate(),
            m = today.getMonth() + 1,
            y = today.getFullYear(),
            h = today.getHours(),
            i = today.getSeconds();

        var date_now = toTimestamp(y, m, d, h, i, 0);
        if (_time >= date_now) {
            return true;
        }
    }

    return false;
});

$.validator.addMethod("datetime_less_than_now", function (value, element, param) {
    value = $.trim(value);

    if (param) {
        var datetime = value.split(' ');
        var date = datetime[1].split('/');
        var time = datetime[0].split(':');
        var _time = toTimestamp(date[2], date[1], date[0], time[0], time[1], 0);

        var today = new Date(),
            d = today.getDate(),
            m = today.getMonth() + 1,
            y = today.getFullYear(),
            h = today.getHours(),
            i = today.getSeconds();

        var date_now = toTimestamp(y, m, d, h, i, 0);
        if (_time <= date_now) {
            return true;
        }
    }

    return false;
});


$.validator.addMethod("date_less_than_now", function (value, element, param) {//...
    value = $.trim(value);
    console.log(value);
    if (param) {
        var _value = value.split('/');

        var time = toTimestamp(_value[2], _value[1], _value[0], 0, 0, 0);
        console.log(time);
        var today = new Date(),
            d = today.getDate(),
            m = today.getMonth() + 1,
            y = today.getFullYear();

        var date_now = toTimestamp(y, m, d, 0, 0, 0);
        console.log(m);

        //console.log(date_now);
        if (time <= date_now) {
            return true;
        }
    }

    return false;
});

$.validator.addMethod('filesize', function (value, element, param) {
    if (element.files.length > 0) {
        return this.optional(element) || (element.files[0].size <= param)
    }

    return true;
}, 'File size must be less than {0}');

function toTimestamp(year, month, day, hour, minute, second) {//...
    var datum = new Date(Date.UTC(year, month - 1, day, hour, minute, second));

    return datum.getTime() / 1000;
}

//Lê Đăng Long
jQuery.validator.addMethod("no_space", function (value, element) {
    value = $.trim(value);
    return this.optional(element) || (value.indexOf(" ") < 0 && value != "");
}, "No space please and don't leave it empty");

//Lê Đăng Long
jQuery.validator.addMethod("phone", function (value, element) {
    if (value.length == 0) return this.optional(element) || true;
    var reg = /^(0|\+84|84)[\d]{9,10}$/;
    reg = new RegExp(reg);
    if (reg.test(value)) {
        return this.optional(element) || true;
    } else {
        return this.optional(element) || false;
    }
    ;
}, "Số điện thoại không đúng định dạng!");


jQuery.validator.addMethod("regex", function (value, element, param) {
    if (this.optional(element)) {
        return true;
    }
    if (typeof param === "string") {
        param = new RegExp("^(?:" + param + ")$");
    }
    return param.test(value);
}, "Invalid format.");