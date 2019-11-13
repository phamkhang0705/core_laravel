$('.all').change(function () {
    var roleId = $(this).attr('data-role-id');
    if ($(this).prop('checked') == true) {
        $('.element-' + roleId).prop('checked', true)
    } else {
        $('.element-' + roleId).prop('checked', false)
    }
})

$('.create-new').click(function (event) {
    event.preventDefault();
    var code = $.trim($('input[name=code').val())
    var codeRe = new RegExp('^[A-Za-z\\d]{3,30}$')
    if (!codeRe.test(code)) {
        alert('Mã nhóm nhập gồm chữ và số viết liền không dấu, không chứa khoảng trắng, độ dài 3-30 ký tự');
        $('input[name=code').focus();
        return
    }
    $('#create-new').submit()
})