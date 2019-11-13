$(function () {
    $('#sign_in').validate({
        highlight: function (input) {
            console.log(input);
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.input-group').append(error);
        }
    });
});

$('input[name=name]').keyup(function() {
    var name = $('input[name=name]').val()
    var password = $('input[name=password]').val()
    if (name != '' && password.length >= 6 && password.length <= 30) {
        $('.btn').prop('disabled', false)
    } else {
        $('.btn').prop('disabled', true)
    }
})

$('input[name=password]').keyup(function() {
    var name = $('input[name=name]').val()
    var password = $('input[name=password]').val()
    if (name != '' && password.length >= 6 && password.length <= 30) {
        $('.btn').prop('disabled', false)
    } else {
        $('.btn').prop('disabled', true)
    }
})

$('.forget-password').click(function(event) {
    event.preventDefault()
    var name = $.trim($('input[name=name]').val())
    if (name == '') {
        alert('Bạn cần nhập tên đăng nhập')
        $('input[name=name]').focus()
        return
    }
    
    swal({
        html: true,
        title: "Xác nhận",
        text: "Chúng tôi sẽ gửi mật khẩu tới địa chỉ email của bạn. Bạn có muốn tiếp tục không?",
        type: "",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Đồng ý",
        cancelButtonText: "Hủy",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: '/forget-password',
                type: 'post',
                data: {
                    name: name,
                    "_token": $("[name=_token").val(),
                },
                beforeSend: function () {
                    // App.mask(true);
                },
                success: function (data) {
                    // App.refresh();
                    console.log(data)
                    if (data.status == 200) {
                        Sv.setCookie("window_mgsSuccess", "Đặt lại mật khẩu thành công");
                        window.location.reload();
                    } else {
                        Sv.setCookie("window_mgsError", data.message);
                        window.location.reload();
                    }
                }
            });
        }

        swal.close();
    });
})