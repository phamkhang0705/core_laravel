GROUP_TYPE_MERCHANT = 'MERCHANT';

App.on('click', '.lock', function () {
    var that = $(this);

    swal({
        html: true,
        title: "Xác nhận",
        text: "Bạn chắc chắn muốn khóa tài khoản <b>" + that.data('name') + '</b>?',
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
                url: '/admin/change_status',
                type: 'post',
                data: {
                    id: that.data('id'),
                    status: 'INACTIVE'
                },
                beforeSend: function () {
                    App.mask(true);
                },
                success: function (data) {
                    App.refresh();
                }
            });
        }

        swal.close();
    });

    return false;
});

App.on('click', '.unlock', function () {
    var that = $(this);

    swal({
        html: true,
        title: "Xác nhận",
        text: "Bạn chắc chắn muốn mở khóa tài khoản <b>" + that.data('name') + '</b>?',
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
                url: '/admin/change_status',
                type: 'post',
                data: {
                    id: that.data('id'),
                    status: 'ACTIVE'
                },
                beforeSend: function () {
                    App.mask(true);
                },
                success: function (data) {
                    App.refresh();
                }
            });
        }

        swal.close();
    });

    return false;
});

$(document).keypress(function(e) {
    if(e.which == 13) {
        $('#form').submit();
    }
});

$('select[name="admin_group_id"]').on('change', function() {
    var selected_code = $(this).find(':selected').data('code');
    if(selected_code == GROUP_TYPE_MERCHANT){
        $('#view_select_merchant').show();
    }else{
        $('#view_select_merchant').hide();
    }
});

$('.create-new').click(function(event) {
    event.preventDefault();
    var userName = $.trim($('input[name=name').val())
    var userNameRe = new RegExp('^[A-Za-z\\d]{5,30}$')
    if (!userNameRe.test(userName)) {
        alert('Tên đăng nhập gồm chữ và số viết liền không dấu, không chứa khoảng trắng, độ dài 5-30 ký tự');
        $('input[name=name').focus();
        return
    }

    var name = $.trim($('input[name=fullname').val())
    var nameRe = new RegExp('^[\\S.*\\S]{1,50}$')
    if (!nameRe.test(name)) {
        alert('Hộ và tên gồm chữ và số, không chứa khoảng trắng hai đầu, độ dài tối đa 50 ký tự');
        $('input[name=fullname').focus();
        return
    }

    var email = $.trim($('input[name=email').val())
    var emailRe = new RegExp('^[a-z][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$')
    if (!emailRe.test(email)) {
        alert('Email bắt đầu bằng chữ, phần tên email có độ dài 5-32 ký tự');
        $('input[name=email').focus();
        return
    }
    
    var phone = $.trim($('input[name=phone').val())
    if (phone != '') {
        var phoneRe = new RegExp('^[\\d]{10,12}$')
        if (!phoneRe.test(phone)) {
            alert('Số điện thoại là số, có độ dài 10-12 ký tự');
            $('input[name=phone').focus();
            return
        }
    }
    
    var admin = $('select[name=admin_group_id]').val()
    if (parseInt(admin) < parseInt(1)) {
        alert('Bạn cần chọn Nhóm quản trị!')
        return
    }

    var selected_code = $('select[name="admin_group_id"]').find(':selected').data('code');
    if(selected_code == GROUP_TYPE_MERCHANT){
        var merchant_id = $('select[name="merchant_id"]').val();
        if(merchant_id <= 0){
            alert('Bạn cần chọn thông tin merchant!');
            return;
        }
    }


    $('#create-new').submit()
});

$('.update_data').click(function(event) {
    event.preventDefault();
    var userName = $.trim($('input[name=username').val())
    var userNameRe = new RegExp('^[A-Za-z\\d]{5,30}$')
    if (!userNameRe.test(userName)) {
        alert('Tên đăng nhập gồm chữ và số viết liền không dấu, không chứa khoảng trắng, độ dài 5-30 ký tự');
        $('input[name=username').focus();
        return
    }

    var name = $.trim($('input[name=fullname').val())
    var nameRe = new RegExp('^[\\S.*\\S]{1,50}$')
    if (!nameRe.test(name)) {
        alert('Hộ và tên gồm chữ và số, không chứa khoảng trắng hai đầu, độ dài tối đa 50 ký tự');
        $('input[name=fullname').focus();
        return
    }

    var email = $.trim($('input[name=email').val())
    var emailRe = new RegExp('^[a-z][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$')
    if (!emailRe.test(email)) {
        alert('Email bắt đầu bằng chữ, phần tên email có độ dài 5-32 ký tự');
        $('input[name=email').focus();
        return
    }

    var phone = $.trim($('input[name=phone').val())
    if (phone != '') {
        var phoneRe = new RegExp('^[\\d]{10,12}$')
        if (!phoneRe.test(phone)) {
            alert('Số điện thoại là số, có độ dài 10-12 ký tự');
            $('input[name=phone').focus();
            return
        }
    }

    var admin = $('select[name=admin_group_id]').val()
    if (parseInt(admin) < parseInt(1)) {
        alert('Bạn cần chọn Nhóm quản trị!')
        return
    }

    var selected_code = $('select[name="admin_group_id"]').find(':selected').data('code');
    if(selected_code == GROUP_TYPE_MERCHANT){
        var merchant_id = $('select[name="merchant_id"]').val();
        if(merchant_id <= 0){
            alert('Bạn cần chọn thông tin merchant!');
            return;
        }
    }


    $('#update_data').submit()
})