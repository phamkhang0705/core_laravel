$(document).ready(function () {
    $("#btnTicket").click(UserSv.showTicket);
    $("#btnSuspect").click(UserSv.showSuspect);
    $("#btnStatus").click(UserSv.updateStatus);

    // Lịch sử đặt giao hàng  
    $('body').on('show.bs.collapse', function (e) {
        UserSv.getBoxHtml(e);
    });

    $('.card-panel.panel').on('show.bs.collapse', UserSv.panelJs);
    $('.card-panel.panel').on('hide.bs.collapse', UserSv.panelJs);

});

var UserSv = {
    panelJs: function(e){
        var $p = $(e.target).closest('.card-panel.panel');
        var cp = $p.find('.panel-collapse.collapse.in');
        // đang mở
        if(cp.length > 0){
            $p.find('.panel-title .material-icons').html('expand_more');
        }else{
            $p.find('.panel-title .material-icons').html('expand_less');
        }
    },
    showTicket: function () {
        App.showWithTitleMessage("Tạo Ticket", "Đang cập nhật...");
    },
    showSuspect: function () {
        App.showWithTitleMessage("Đánh dấu gian lận", "Đang cập nhật...");
    },
    updateStatus: function (e) {
        var id = $(e.target).data("id");
        var status = $(e.target).data("status");
        var title = (status === 0 ? "Khóa tài khoản!" : "Mở khóa tài khoản!");
        var text = "<p>Người dùng bị khóa tài khoản sẽ không đăng nhập và sử dụng dịch vụ nữa. Vui lòng nhập lý do để thông báo cho người dùng v/v khóa tài khoản. Người dùng sẽ không thể đăng nhập sử dụng dịch vụ sau 24h gửi thông báo này.</p>";
        if (status !== 0) {
            text = "<p>Nhập lý do mở khóa tài khoản.</p>";
        }
        var noteid = "noteid";
        UserSv.showAreaMessage(title, text, noteid,
            function (e, i) {
                var note = $("#" + noteid).val();
                if (!note) {
                    swal.showInputError("Bạn chưa nhập nội dung!");
                    return false;
                } else {
                    var obj = {
                        id: id,
                        status: status,
                        note: note
                    };
                    App.post('/user/update_status', obj, true, function (result) { 
                        if (result.status == 1) {
                            swal({
                                title: title,
                                text: "Cập nhật tài khoản thành công",
                            }, function (inputValue) {
                                window.location.reload();
                            });
                        }
                    });
                }
            });
    },
    showAreaMessage: function (title, text, inputid, callback) {
        swal({
            title: title,
            text: text + '<br />' + '<textarea id="' + inputid + '" class="form-control no-resize" rows="3" style="display: block;" placeholder="Nhập nội dung" ></textarea>',
            html: true,             
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonColor: "#F44336",
            inputPlaceholder: 'Nhập lý do',
            confirmButtonText: "Lưu",
            cancelButtonText: "Hủy"
        }, function (inputValue) {

            if (typeof callback == 'function') {
                callback.call(this, inputValue);
            }
        });
    },
    getBoxHtml: function (e) {
        $p = $(e.target).closest(".card-panel").find(".panel-body");
        var isdata = $p.data("isdata");
        var url = $p.data("url");
        if (url !== "" && isdata !== "true") {
            $p.html("Loading ...");
            var obj = {
                id: $("[name=global_user_id]").val()
            };
            App.post(url, obj, true, function (result) {
                $p.data("url", "");
                $p.data("isdata", "true");
                $p.html(result.html);
            });
        }
    }

}