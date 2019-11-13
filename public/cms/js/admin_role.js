App.on('click', '.lock', function () {
    var that = $(this);

    swal({
        title: "Xác nhận",
        text: "Bạn chắc chắn muốn khóa chức năng: " + that.data('name') + '?',
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
                url: '/admin_role/change_status',
                type: 'post',
                data: {
                    id: that.data('id'),
                    status: 'DISABLE'
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
        text: "Bạn chắc chắn muốn mở khóa chức năng: " + that.data('name') + '?',
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
                url: '/admin_role/change_status',
                type: 'post',
                data: {
                    id: that.data('id'),
                    status: 'ENABLE'
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
            controller: {
                required: true,
                maxlength: 100,
            },
            name: {
                required: true,
                maxlength: 255,
            },
        },
        messages: {
            code: {
                required: "Vui lòng nhập chức năng code",
            },
            name: {
                required: "Vui lòng nhập tên",
            },
        }
    });
}