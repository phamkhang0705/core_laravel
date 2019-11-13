var lastBtn = false;

function openTab(evt, tabName) { 
    btnsub = $("#btn").is(":disabled");  
    $(".tablinks").each(function(i, e){
        if($(e).data('id') == tabName){
            $(e).addClass('active');   
        }else{
            $(e).removeClass('active');   
        }
    });

    $(".tabcontent").each(function(i, e){ 
        if($(e).attr('id') == tabName){
            $(e).addClass('active');   
            $(e).css('display','block');  
        }else{
            $(e).removeClass('active');   
            $(e).css('display','none');   
        }
    });

    if(tabName == "Match"){       
        $("#btnsub").html('Chốt kèo');  
    }else{
        $("#btnsub").html('&nbsp;');  
    }
}

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
                cancel: {
                    label: " Đóng",
                    className: "btn "
                    // className: "btn btn-df"
                },                
                success: {
                    label:  "Xác nhận",
                    className: typeDialog.buttonClass,
                    callback: callbackFuntion
                },
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
                    title: "Bạn đã chốt kèo",
                    className: 'modal-success',
                    // buttonClass: 'btn btn-primary',
                    buttonClass: 'btn',
                };
                break;
            case 'warning':
                type = {
                    title: "Thông báo",
                    className: 'modal-warning',
                    buttonClass: 'btn',
                    // buttonClass: 'btn btn-primary'
                };
                break;
            case 'error':
                type = {
                    title: "Lỗi",
                    className: 'modal-error',
                    buttonClass: 'btn',
                    // buttonClass: 'btn btn-primary',
                };
                break;
            case 'primary':
                type = {
                    title: " Xác nhận",
                    className: 'modal-primary',
                    // buttonClass: 'btn btn-primary'
                    buttonClass: 'btn'
                };
                break;
        }
        return type;
    }
}
var flag_sub = false;

$(document).ready(function () {
    // đã view điều kiện
    if(logview == 1)
        $("#myLoad").modal('show');
    else
        $("#dcLoad").modal('show');
    // hide điều kiện
    $('#dcLoad').on('hidden', function () {
        $("#myLoad").modal('show');
    })

    $("#btnsub").click(function () {
        if(flag_sub == true)
            return false;
        flag_sub = true;
        setTimeout(function (){flag_sub = false;}, 200);
        var obj = getData();
        if(obj.match.length > 0){                
            var msg = getMsg(obj.match);
            Dialog.Confirm("Bạn đã dự đoán", msg, function(i,isCf){                
                // loock btn
                $("#btnsub").prop('disabled', true);
                $("#btnsub").html('&nbsp;');              
                // post
                 $.ajax({
                    url:'/gamecup/add',
                    type: 'POST',
                    data: obj, 
                    cache: false,
                    dataType: 'json',
                    success: function (response) {  
                        if(response.status == 1 ){  
                            var msg_rs = getMsgByData(obj.match, response.data);
                            Dialog.Alert(msg_rs, 'success', function(){
                                ajaxRes(response,obj);
                            });                            
                        }else{
                            Dialog.Alert(response.message);
                        }
                    }  
                });       

            });           
        }
    });
       
  
   var $edit = false;    
    $('.val_num').on('keyup', function(e) {
        console.log(e);
        var field = $(e.target);
        var tr = field.closest('tr');
        var action = 'add';
        var key = e.keyCode;

        setTimeout(function() {  
            var prevValue = field.val();   
            if(key != 9)            {
               // set lại val
               var pv = parseInt(prevValue);
               if(pv >=99) pv=99;
               field.val(pv); 
            }

            if(key == 13){
                $("#btnsub").trigger('click');
            }        
            // ko phải xóa, ko phải tab
            if (key != 8 && key != 9 ) {                
                // set val = 0 cho thằng còn lại
                tr.find('.val_num').each(function (i, ev) {                
                    if ($(ev).val() == ''){
                        $(ev).focus();
                        $edit = true;
                    }
                }); 
            }            
        
            upNumOfUser();   

        }, 1); 

      });
     

});

function ajaxRes(response, obj){
    // response
    if(response.status == 1 ){ 
        var mat_dt = obj.match;
        // get html những cái đã book
        $('#Match ._item').each(function (i, ev) {
            if(mat_dt.length == 0 ) {
                return false;
            }
            var match_id = $(ev).data('match');
            var isMatch = false;
            mat_dt = mat_dt.filter(function(x){
                if(!isMatch)
                    isMatch = x.match_id == match_id;
                return x.match_id != match_id;
            });
            if(isMatch){                    
                $new = $(ev).clone();               
                // remove khỏi tab trận đấu
                $(ev).remove();                
                // add va lich su
                $new.removeClass('_item')
                    .removeClass('_use')
                    .addClass('_history')
                    .addClass('bx_noal')
                    .addClass('_his')
                    .data('match','')
                    .data('matchname','')
                    .data('team1','')
                    .data('team2','');

                $new.find('.val_num').prop('disabled',true);
                $new.find('.val_num')
                        .attr('name','')
                        .removeClass('val_num')
                        .removeClass('team1')
                        .removeClass('team2');
                if($('#his_null').length > 0){                    
                    $('#his_null').remove();         
                }
                $('#History').prepend($new);                
            }
        });

        // active history
        $("[data-id=History]").trigger('click');  
       
    }else{
        Dialog.Alert(response.message);
    }
}

function getMsg(data){
console.log(data);
    var msg = "<table width='100%'>";
    if(data.length > 1){
        for (var i = 0; i < data.length; i++) { 
            msg += getMsgRow(data[i], i + 1);       
        }    
    }else if(data.length == 1){
        msg += getMsgRow(data[0], 0);  
    }
    msg += "</table>"; 
    msg += '<br/>Mỗi trận đấu chỉ được dự đoán 1 lần, bạn có chắc chắn với dự đoán của mình?';    

    return msg;
}

function getMsgByData(data, bo){
    var msg = "<table width='100%'>";
    if(data.length > 1){
        for (var i = 0; i < data.length; i++) {
            msg += getMsgRow(data[i], i + 1);          
        }    
    }else if(data.length == 1){
        msg += getMsgRow(data[0], 0);  
    }
    msg += "</table>"; 
    msg += '<br/>Bạn có thể nâng mức tiền thưởng lên 10 triệu, 50 triệu hay 100 triệu, thậm chí hơn thế... vì tiền thưởng bằng giá trị hóa đơn mua sắm lớn nhất chưa nhận thưởng với Clingme trong vòng 24 giờ tính đến thời điểm bóng lăn. <br />Chúc bạn may mắn!';


    return msg;
}

function getMsgRow(item, index){
    var htm = "<tr>";
    // if(index == 0){
    htm += "<td class='text-right' width='40%'  >"+item.team1_title+"</td>"
        +"<td class='text-right' style='padding-right:8px'  width='9%'>"+item.team1_val+"</td>"
        +"<td class='text-center' width='2%'>-</td>"
        +"<td class='text-left' style='padding-left:8px' width='9%'>"+item.team2_val+"</td>"
        +"<td class='text-left' width='40%'>"+item.team2_title+"</td>";           
  
    // else{
    //     htm += "<td class='text-left' width='20%'  > Kèo: "+index+"</td>"
    //         +"<td class='text-right' width='30%'  >"+item.team1_title+"</td>"
    //         +"<td class='text-center' width='9%'>"+item.team1_val+"</td>"
    //         +"<td class='text-center' width='2%'>-</td>"
    //         +"<td class='text-center' width='9%'>"+item.team2_val+"</td>"
    //         +"<td class='text-left' width='30%'>"+item.team2_title+"</td>";
    // }
    return htm +"</tr>"; 
}



function getData() {

    var obj = {
        'user_id': $('[name=user_id]').val(),
        'session': $('[name=session]').val(),
        '_token': $('[name=_token]').val(),
        'isapp': 1,
        'match': [],
    };

    $('#Match ._item').each(function (i, ev) {
        var $t1 = $(ev).find('.val_num.team1');
        var $t2 = $(ev).find('.val_num.team2');
        var item = {
            'match_id': $(ev).data('match'),
            'team1_val': $t1.val(), //val team1
            'team2_val': $t2.val(), //val team2
            'team1_id': $t1.data('id'), //id team1
            'team2_id': $t2.data('id'), //id team2
            
            'team1_title': $(ev).data('team1'),
            'team2_title': $(ev).data('team2'),
        }
        if(item.team1_val != '' && item.team2_val){
            obj.match.push(item);
        }
    });

    return obj;
}

function autoUpdate() {
    $('#Match ._item').each(function (i, ev) {
        var v1 = $(ev).find('.val_num.team1').val();
        var v2 = $(ev).find('.val_num.team2').val(); 
        // neu 1 trong 2 chú rỗng => set rỗng
        if (!(v1 != '' && v2 != '')) { 
            $(ev).find('.val_num.team1').val('');
            $(ev).find('.val_num.team2').val('');
        }
    });
}

var time_out = null;
function autoHideKeyboard(e, allow) {  
    if(time_out != null)
        clearTimeout(time_out);
    // không nhập liên tục => auto close keyboard
    time_out = setTimeout(function(){   
        console.log(e);
        if (( e.keyCode != 8 && e.keyCode != 9) || allow ) {
            $(e.target).blur();
        }  
    }, 50); 
}

function upNumOfUser() {
    var numUse = 0;
    $('#Match ._item').each(function (i, ev) {
        var v1 = $(ev).find('.val_num.team1').val();
        var v2 = $(ev).find('.val_num.team2').val(); 
        if (v1 != '' || v2 != '') {
            numUse += 1;
            $(ev).addClass('_use');
        } else {
            $(ev).removeClass('_use'); 
        }
    });
    // lock
    var lock = numUse >= num_of_user;
    $('#Match ._item').each(function (i, ev) {
        var iteUse = $(ev).hasClass('_use');
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
    }else{
        $("#btnsub").prop('disabled', true);
    }

    if( num_of_user > 0){
        $('#user_num').html(num_of_user - numUse);
        $('#user_num').data('lock', lock);
    }
}