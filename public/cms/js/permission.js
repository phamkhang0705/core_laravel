$(document).ready(function() {

    $('.grant').click(function() {
        var is_checked = $(this).is(':checked');

        var object_id = $('#object_id').val();
        var object_type = $('#object_type').val();
        var code = $(this).attr('data-code');

        $.ajax({
            type:'post',
            dataType:'html',
            url : permission_grant_url,
            data : {
                object_id:object_id,
                object_type:object_type,
                is_checked:(is_checked == true)?1:0,
                code:code
            },
            success:function(result) {

            }
        });
    });
});

