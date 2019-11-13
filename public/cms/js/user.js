App.on('click', '.btn_search_user', function () {
    var that = $(this)
    $dataType = that.data('type')
    searchUser($dataType)
});

$(document).keypress(function(e) {
    if(e.which == 13) {
        $dataType = $('.btn_search_user').attr('data-type')
        searchUser($dataType)
    }
});

function searchUser($dataType) {
    var phone = $('#search_phone_text').val();

    if (phone == '') {
        swal({
            title: "Thông báo",
            text: 'Vui lòng nhập số điện thoại khách hàng',
            type: "error",
            confirmButtonText: "Hủy",
            closeOnConfirm: true
        });

        return false;
    }

    $.ajax({
        url: '/user/search',
        type: 'get',
        data: {
            phone: phone,
            type: $dataType
        },
        beforeSend: function () {
            App.mask(true);
        },
        success: function (response) {
            App.mask(false);
            $('#search_phone_text').val('')

            if (response.status != 200) {
                swal({
                    title: "Thông báo",
                    text: response.message,
                    type: "error",
                    confirmButtonText: "Hủy",
                    closeOnConfirm: true
                });
                return false;
            }

            $('#user_info > .body').html(response.data.html);

            $('#user_info').show();

            if (response.data.message != '') {
                swal({
                    title: "Thông báo",
                    text: response.data.message,
                    type: "info",
                    confirmButtonText: "Ok",
                    closeOnConfirm: true
                });

                return false;
            }
        }
    });
}

App.on('click', '.btn_cancel', function () {
    var that = $(this);

    swal({
        title: "",
        text: 'Vui lòng nhập lý do hủy',
        type: "input",
        showCancelButton: true,
        confirmButtonColor: "#F44336",
        confirmButtonText: "Xác nhận",
        cancelButtonText: "Hủy",
        closeOnConfirm: false,
        inputPlaceholder: "Nhập lý do hủy"
    }, function (inputValue) {
        if (inputValue === false) return false;
        inputValue = $.trim(inputValue)
        if (inputValue === "") {
            swal.showInputError("Bạn chưa nhập lý do hủy");
            return false;
        } else if (parseInt(inputValue.length) > parseInt(200)) {
            swal.showInputError("Bạn nhập lý do quá 200 ký tự");
            return false;
        }

        $.ajax({
            url: '/user/' + that.data('id'),
            type: 'post',
            data: {
                note: inputValue,
                _method: 'DELETE'
            },
            beforeSend: function () {
                App.mask(true);
            },
            success: function (data) {
                that.attr('disabled', 'disabled');

                App.mask(false);
                $('#search_phone_text').val('')

                swal({
                    title: "Thông báo",
                    text: 'Đã hủy thông tin khách hàng thành công',
                    type: "info",
                    confirmButtonText: "Ok",
                    closeOnConfirm: true
                });
            }
        });
    });
});

App.on('click', '.btn_lock', function () {
    var that = $(this);

    swal({
        title: "",
        text: 'Vui lòng nhập lý do khóa',
        type: "input",
        showCancelButton: true,
        confirmButtonColor: "#F44336",
        confirmButtonText: "Xác nhận",
        cancelButtonText: "Hủy",
        closeOnConfirm: false,
        inputPlaceholder: "Nhập lý do khóa"
    }, function (inputValue) {
        if (inputValue === false) return false;
        inputValue = $.trim(inputValue)
        if (inputValue == '') {
            swal.showInputError("Bạn chưa nhập lý do khóa");
            return false;
        } else if (parseInt(inputValue.length) > parseInt(200)) {
            swal.showInputError("Bạn nhập lý do quá 200 ký tự");
            return false;
        }

        $.ajax({
            url: '/user/change_status',
            type: 'post',
            data: {
                id: that.data('id'),
                note: inputValue,
                status: 0
            },
            beforeSend: function () {
                App.mask(true);
            },
            success: function (data) {
                that.attr('disabled', 'disabled');

                App.mask(false);
                $('#search_phone_text').val('')

                swal({
                    title: "Thông báo",
                    text: 'Đã khóa thông tin khách hàng thành công',
                    type: "info",
                    confirmButtonText: "Ok",
                    closeOnConfirm: true
                });
            }
        });
    });
});

App.on('click', '.btn_unlock', function () {
    var that = $(this);

    swal({
        title: "",
        text: 'Bạn có chắc chắn muốn mở khóa tài khoản khách hàng này không?',
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#F44336",
        confirmButtonText: "Xác nhận",
        cancelButtonText: "Hủy",
        closeOnConfirm: false,
        inputPlaceholder: "Nhập lý do khóa"
    }, function (isConfirm) {
        if (isConfirm === false) return false;

        $.ajax({
            url: '/user/change_status',
            type: 'post',
            data: {
                id: that.data('id'),
                status: 1
            },
            beforeSend: function () {
                App.mask(true);
            },
            success: function (data) {
                that.attr('disabled', 'disabled');

                App.mask(false);
                $('#search_phone_text').val('')
                swal({
                    title: "Thông báo",
                    text: 'Đã mở khóa thông tin khách hàng thành công',
                    type: "info",
                    confirmButtonText: "Ok",
                    closeOnConfirm: true
                });
            }
        });
    });
});