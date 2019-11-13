App.on('click', '.lock', function () {
    var that = $(this);

    swal({
        title: "Xác nhận",
        text: "Bạn chắc chắn muốn khóa nhóm khách hàng: " + that.data('name') + '?',
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
                url: '/user_group/change_status',
                type: 'post',
                data: {
                    id: that.data('id'),
                    status: 0
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
        title: "Xác nhận",
        text: "Bạn chắc chắn muốn mở khóa nhóm khách hàng: " + that.data('name') + '?',
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
                url: '/user_group/change_status',
                type: 'post',
                data: {
                    id: that.data('id'),
                    status: 1
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

if ($('#form_update').length) {
    $('#form_update').validate({
        rules: {
            code: {
                required: true,
                maxlength: 50,
            },
            name: {
                required: true,
                maxlength: 255,
            },
        },
        messages: {
            code: {
                required: "Vui lòng nhập mã",
            },
            name: {
                required: "Vui lòng nhập tên",
            },
        }
    });
}