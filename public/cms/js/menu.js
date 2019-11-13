var cms_menu = {

    load_list_menu:function() {
        if (typeof urlGetListMenu === 'undefined' || urlGetListMenu === null) {
            console.log(' url to get show relations must be set before');
            return false;
        }
        $.ajax({
            type:'get',
            dataType:'html',
            url : urlGetListMenu,
            success:function(result) {
                var data = $.parseJSON(result);
                $('#editable_wrapper').html(data.html);
            }
        });
    }
};
