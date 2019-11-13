App.on('click', '.lock', function () {
    var that = $(this);

    swal({
        title: "Xác nhận",
        text: "Bạn chắc chắn muốn khóa dịch vụ " + that.data('name') + '?',
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
                url: '/service/change_status',
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
        text: "Bạn chắc chắn muốn mở khóa dịch vụ " + that.data('name') + '?',
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
                url: '/service/change_status',
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


$(document).ready(function () {

    $('#table_card').on( 'click','.order_up', function (event) {
        event.preventDefault();
        var data_id = $(this).attr('data-id');
        var parent_id = $(this).attr('data-parent-id');
        var _sort = {
            data_id: data_id,
            parent_id: parent_id,
            type: 'up'
        };
        ajaxSort(_sort);
    });

    $('#table_card').on('click','.order_down', function (event) {
        event.preventDefault();
        var data_id = $(this).attr('data-id');
        var parent_id = $(this).attr('data-parent-id');
        var _sort = {
            data_id: data_id,
            parent_id: parent_id,
            type:'down'
        };
        ajaxSort(_sort);
    });

    function ajaxSort(param) {
        param.name= $('[name=name]').val();
        param.code= $('[name=code]').val();
        param.status= $('[name=status]').val();

        App.ajax('/service/sort', param, 'post', true, function(response){
            if(response.status == 200 || response.status == 1 ) {
                $('#table_card').html(response.data.html);
            }else{
                App.alert(response.message);
            }
        }, function(){
            App.alert("Có lỗi trong quá trình xử lý!");
        }) ;

    }
});

$('.update-service').click(function(event) {
    event.preventDefault()
    var name = $.trim($('input[name=name]').val())
    if (name == '') {
        alert('Bạn cần nhập tên!')
        $('input[name=name]').focus()
        return
    } else if (parseInt(name.length) > parseInt(100)) {
        alert('Bạn nhập tên quá 100 ký tự!')
        $('input[name=name]').focus()
        return
    }
    $('#form_update').submit()
})