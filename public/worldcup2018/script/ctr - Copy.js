var Dialog = {
    Success: 'success',
    Warning: 'warning',
    Error: 'error',
    CONFIRM: 'primary',
    /*  Description: Dialog thông báo
                     - message: Thông tin thông báo cần hiển thị.
                     - status: Trạng thái dialog (Success: Thành công, Warning: Cảnh báo, Error: Thất bại).
                     - callbackFuntion: Function Callback thực hiện sau khi ấn nút xác nhận form thông báo.
        Author: vivu  */
    Alert: function (message, status, callbackFuntion, hideModalFuntion) {
        status = status ? status : 'warning';
        var typeDialog = this._getTypeDialog(status);
        bootbox.dialog({
            message: message,
            title: typeDialog.title,
            closeButton: false,
            className: typeDialog.className,
            buttons: {
                success: {
                    label: "Đóng",
                    className: typeDialog.buttonClass,
                    callback: callbackFuntion
                }
            }
        }).on('shown.bs.modal', function () {
            $('.bootbox').find('button:first').focus();
        });
    },
    Confirm: function (title, message, callbackFuntion, showModalFuntion) {
        var typeDialog = this._getTypeDialog(this.CONFIRM);
        bootbox.dialog({
            message: message,
            title: title ? title : typeDialog.title,// title ? typeDialog.title : title,
            closeButton: false,
            className: typeDialog.className,
            buttons: {
                success: {
                    label:  "Xác nhận",
                    className: typeDialog.buttonClass,
                    callback: callbackFuntion
                },
                cancel: {
                    label: " Đóng",
                    className: "btn btn-df"
                }
            }
        }).on('shown.bs.modal', showModalFuntion == undefined ? function () {
            //$('.bootbox').find('button:first').focus();
        } : showModalFuntion);
    },
    /*  Description: Hàm xác định kiểu của Dialog
        Author: vivu  */
    _getTypeDialog: function (status) {
        var type = {};
        switch (status) {
            case 'success':
                type = {
                    title: "Thành công",
                    className: 'modal-success',
                    buttonClass: 'btn btn-primary'
                };
                break;
            case 'warning':
                type = {
                    title: "Thông báo",
                    className: 'modal-warning',
                    buttonClass: 'btn btn-primary'
                };
                break;
            case 'error':
                type = {
                    title: "Lỗi",
                    className: 'modal-error',
                    buttonClass: 'btn btn-primary'
                };
                break;
            case 'primary':
                type = {
                    title: " Xác nhận",
                    className: 'modal-primary',
                    buttonClass: 'btn btn-primary'
                };
                break;
        }
        return type;
    }
}

$(document).ready(function () {

    $(".btnsub").click(function () {
        let obj = getData();
        if(obj.match.length > 0){
            var msg = getConfirm();
            Dialog.Confirm("Bạn đã dự đoán",msg , function(i,isCf){
                 $.ajax({
                    url:'/worldcup/add',
                    type: 'POST',
                    data: obj, 
                    cache: false,
                    dataType: 'json',
                    success: function (response) {
                        console.log(response); 
                        if(response.status == 1 ){
                            window.location.href = '/worldcup/history';
                        }else{
                            Dialog.Alert(response.message);
                        }
                    }  
                });       
            });           
        }
    });


    //keyup
    $('.val_num').keyup(function (e) {
        var $this = $(e.target);
        var $tr = $this.closest('tr');
        var $v = $this.val();
        var action = 'add';
        // xóa 
        if (e.keyCode == 8 && $v == "") {
            action = 'sub';
        }
        // set giá trị 0 nếu nhập tỷ số cho 1 đội
        $tr.find('.val_num').each(function (i, ev) {
            if (action == 'add') {
                if ($(ev).val() == '')
                    $(ev).val(0);
                $v = $(ev).val();
                $(ev).val(parseInt($v));
            }
        });
        upNumOfUser(); 
    });
    // focusout
    $('.val_num').focusout(function (e) {
        var $this = $(e.target);
        var $tr = $this.closest('tr');
        var isRemove = false;
        // remove những thằng thiết lập không chính xác
        $tr.find('.val_num').each(function (i, ev) {
            if ($(ev).val() == '')
                isRemove = true;
        });
        // nếu xóa =>
        if (isRemove == true) {
            $tr.find('.val_num').val('');
        }
        upNumOfUser(); 
    });



});

function getConfirm(){
    msg = "";
    $('._item').each(function (i, ev) { 
        let item = {
            'match': $(ev).data('matchname'),
            'team1_val':  $(ev).find('.val_num.team1').val(), 
            'team2_val':  $(ev).find('.val_num.team2').val(), 
            'team1_title': $(ev).data('team1'),
            'team2_title': $(ev).data('team2')
        }
        if(item.team1_val != '' && item.team2_val){
             msg += ( item.team1_title + ' ' + item.team1_val + ' - ' + item.team2_val + ' '+ item.team2_title + '<br />');
        }
    });
return msg;
}

function getData() {

    let obj = {
        'user_id': $('[name=user_id]').val(),
        'session': $('[name=session]').val(),
        '_token': $('[name=_token]').val(),
        'isapp': 1,
        'match': [],
    };

    $('._item').each(function (i, ev) {
        let $t1 = $(ev).find('.val_num.team1');
        let $t2 = $(ev).find('.val_num.team2');
        let item = {
            'match_id': $(ev).data('match'),
            'team1_val': $t1.val(), //val team1
            'team2_val': $t2.val(), //val team2
            'team1_id': $t1.data('id'), //id team1
            'team2_id': $t2.data('id') //id team2
        }
        if(item.team1_val != '' && item.team2_val){
            obj.match.push(item);
        }
    });

    return obj;
}

function upNumOfUser() {
    let numUse = 0;
    $('._item').each(function (i, ev) {
        let $v1 = $(ev).find('.val_num.team1').val();
        let $v2 = $(ev).find('.val_num.team2').val();
        if ($v1 != '' || $v2 != '') {
            numUse += 1;
            $(ev).addClass('_use');
        } else {
            $(ev).removeClass('_use');
        }
    });
    // lock
    var lock = numUse >= num_of_user;
    $('._item').each(function (i, ev) {
        let iteUse = $(ev).hasClass('_use');
        // nếu được sử dụng
        if (!iteUse && lock) {
            $(ev).find('.val_num').prop('disabled', true);
        }
        if (!lock) {
            $(ev).find('.val_num').prop('disabled', false);
        }

    });
    
    if(numUse > 0  && num_of_user > 0){
        $("#btnsub").prop('disabled', false);
        $("#btnsub").html('Dự đoán');  
    }else{
        $("#btnsub").prop('disabled', true);
        $("#btnsub").html('&nbsp;');  
    }

    if( num_of_user > 0){
        $('#user_num').html(num_of_user - numUse);
        $('#user_num').data('lock', lock);
    }
}