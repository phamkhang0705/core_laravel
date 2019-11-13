<table class="table table-hover" id="editable" role="grid" aria-describedby="editable_info">
    <thead>
    <tr role="row">

        <th class="col-md-4">Tên menu </th>
        <th class="col-md-3">Mô tả</th>
        <th class="text-center col-md-1">Trạng thái</th>
        <th class="text-center col-md-1" >Sắp xếp</th>
        <th class="text-center col-md-1" >Sắp xếp</th>

        <th class="text-center col-md-2" class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i=0;

    ?>
    @if(isset($menu_1s) && !empty($menu_1s))
        @foreach($menu_1s as $key_1 => $tmp_1)
            <?php
            $i++;

            ?>
            <tr class="tr_menu_1" data-menu-id="{!! $tmp_1['id'] !!}" role="row">

                <td>
                    <div class="menu_1">
                        <strong>
                            <a href="{!! route('cms.menu.show',['id'=>$tmp_1['id']]) !!}">{!! $tmp_1['name'] !!}</a>
                        </strong>
                        <br/>
                        {!! $tmp_1['url'] !!}
                    </div>
                </td>
                <td>{!! $tmp_1['description'] !!}</td>

                <td class="text-center">
                    <a href="#" class="change_status" data-id="{!! $tmp_1['id'] !!}">
                        @if($tmp_1['display'] == 1)
                            <i class="material-icons col-cyan">check_circle</i>
                        @else
                            <i class="material-icons col-blue-grey">highlight_off</i>
                        @endif
                    </a>
                </td>
                <td class="text-center">
                    @if($i > 1)

                        <a href="#" class="big_order_up" data-menu-id="{!! $tmp_1['id'] !!}">
                            <i class="material-icons">vertical_align_top</i>

                        </a>
                    @endif

                    @if($i < count($menu_1s))
                        <a href="#" class="m-l big_order_down" data-menu-id="{!! $tmp_1['id'] !!}">
                            <i class="material-icons">vertical_align_bottom</i>
                        </a>
                    @endif
                </td>
                <td></td>
                <td class="text-center">
                    <a class="item-tool" href="{!! route('cms.menu.show',['id'=>$tmp_1['id']]) !!}">

                        <i class="material-icons">visibility</i>
                    </a>
                    <a class="item-tool" href="{!! route('cms.menu.edit',['id'=>$tmp_1['id']]) !!}">

                        <i class="material-icons">edit</i>
                    </a>
                    <a class="item-tool" href="{!! url('cms_menu/delete',['id'=>$tmp_1['id']]) !!}">

                        <i class="material-icons">delete</i>
                    </a>
                </td>
            </tr>
            <?php
            if(isset($menu_2s) && isset($tmp_1['id']) && isset($menu_2s[$tmp_1['id']])) {
            $chs = $menu_2s[$tmp_1['id']];
            $j = 0;

            foreach($chs as $ch) { $j++;?>
            <tr class="tr_menu_2" data-parent-id="{!! $ch['parent_id'] !!}" data-menu-id="{!! $ch['id'] !!}" role="row">

                <td>
                    @if(isset($menu_2s[$tmp_1['id']]))
                        <input type="hidden" class="list_menu_2" data-menu-id="{!! $tmp_1['id'] !!}">
                    @endif
                    <div class="menu_2" style="padding-left: 30px">
                        <i class="jstree-icon jstree-ocl"></i>
                        <a href="{!! route('cms.menu.show',['id'=>$ch['id']]) !!}">{!! $ch['name'] !!}</a>
                        <br/>
                        {!! $ch['url'] !!}
                    </div>
                </td>
                <td>{!! $ch['description'] !!}</td>

                <td class="text-center">
                    @if($ch['display'] == 1)
                        <i class="material-icons col-cyan">check_circle</i>
                    @else
                        <i class="material-icons col-blue-grey">highlight_off</i>
                    @endif
                </td>
                <td></td>
                <td class="text-center">
                    @if($j > 1)
                        <a href="#" class="order_up"
                           data-parent-id="{!! $tmp_1['id'] !!}" data-menu-id="{!! $ch['id'] !!}">
                            <i class="material-icons">vertical_align_top</i>
                        </a>
                    @endif

                    @if($j < count($chs) )
                        <a href="#" class="m-l order_down"
                           data-parent-id="{!! $tmp_1['id'] !!}" data-menu-id="{!! $ch['id'] !!}">

                            <i class="material-icons">vertical_align_bottom</i>
                        </a>
                    @endif
                </td>
                <td class="text-center">
                    <a class="item-tool" href="{!! route('cms.menu.show',['id'=>$ch['id']]) !!}">
                        <i class="material-icons">visibility</i>
                    </a>
                    <a class="item-tool" href="{!! route('cms.menu.edit',['id'=>$ch['id']]) !!}">
                        <i class="material-icons">edit</i>
                    </a>

                    <a class="item-tool" href="{!! url('menu/delete',['id'=>$ch['id']]) !!}">
                        <i class="material-icons">delete</i>
                    </a>
                </td>
            </tr>
            <?php }
            } ?>

        @endforeach
    @endif
    </tbody>

</table>
<div class="row">
    <div class="col-sm-6">
        <div class="dataTables_info" id="editable_info" role="status" aria-live="polite">
            Hiển thị từ 1 đến {!! isset($params['total'])?$params['total']:0 !!} trong tổng số {!! isset($params['total'])?$params['total']:0 !!} kết quả</div>
    </div>
</div>
<input type="hidden" id="big_menu_sort">
<script type="text/javascript">
    var urlCmsMenuSort = "{!! url('menu/big_sort') !!}";
</script>
<script type="javascript" src="/cms/js/cms.menu.js"></script>
<script type="text/javascript">
    function sort(order) {
        $.ajax({
            url : urlCmsMenuSort,
            type : 'post',
            data : {
                order : order
            },
            success : function() {
                cms_menu.load_list_menu();
            }
        });
    }

    $(document).ready(function(){
        var big_menu_sort = new Array;

        $('.tr_menu_1').each(function(){
            var _menu_1_id = $(this).attr('data-menu-id');
            big_menu_sort.push(_menu_1_id);

        });
        console.log(big_menu_sort);
        $('.big_order_up').click(function(event){
            event.preventDefault();
            var data_menu_id = $(this).attr('data-menu-id');
            var index_of_this = big_menu_sort.indexOf(data_menu_id);
            var plant_to_remove = big_menu_sort[index_of_this-1];
            var plant_to_replace = big_menu_sort[index_of_this+1];


            big_menu_sort.splice(index_of_this-1,1);
            big_menu_sort.splice(index_of_this,1,plant_to_remove,plant_to_replace);
            console.log(big_menu_sort);

            sort(big_menu_sort);
        });

        $('.big_order_down').click(function(event) {
            event.preventDefault();

            var data_menu_id = $(this).attr('data-menu-id');
            var index_of_this = big_menu_sort.indexOf(data_menu_id);

            var plant_to_remove = big_menu_sort[index_of_this];
            var plant_to_replace = big_menu_sort[index_of_this+1];

            big_menu_sort.splice(index_of_this,1);

            big_menu_sort.splice(index_of_this,1, plant_to_replace, plant_to_remove);
            console.log(big_menu_sort);
            sort(big_menu_sort);
        });
        //nhỏ
        $('.tr_menu_2').each(function() {
            var _menu_2_id = $(this).attr('data-menu-id');
            var _menu_parent_id = $(this).attr('data-parent-id');
            var input = $('.list_menu_2[data-menu-id='+_menu_parent_id+']');
            var current_value = input.val();
            if(current_value == '') {
                input.val(_menu_2_id);
            }else{
                input.val(current_value+","+_menu_2_id);
            }
        });

        $('.order_up').click(function(event){
            event.preventDefault();

            var data_menu_id = $(this).attr('data-menu-id');
            var _menu_parent_id = $(this).attr('data-parent-id');
            var input = $('.list_menu_2[data-menu-id='+_menu_parent_id+']');
            var menu_sort = input.val();
            menu_sort = menu_sort.split(',');
            var index_of_this = menu_sort.indexOf(data_menu_id);

            var plant_to_remove = menu_sort[index_of_this];
            var plant_to_replace = menu_sort[index_of_this-1];

            menu_sort.splice(index_of_this,1);
            menu_sort.splice(index_of_this-1,1, plant_to_remove,plant_to_replace);
            console.log(menu_sort);
            sort(menu_sort);


        });
        $('.order_down').click(function(event){
            event.preventDefault();

            var data_menu_id = $(this).attr('data-menu-id');
            var _menu_parent_id = $(this).attr('data-parent-id');
            var input = $('.list_menu_2[data-menu-id='+_menu_parent_id+']');
            var menu_sort = input.val();
            menu_sort = menu_sort.split(',');
            var index_of_this = menu_sort.indexOf(data_menu_id);

            var plant_to_remove = menu_sort[index_of_this];
            var plant_to_replace = menu_sort[index_of_this+1];

            menu_sort.splice(index_of_this,1);

            menu_sort.splice(index_of_this,1, plant_to_replace, plant_to_remove);

            console.log(menu_sort);
            sort(menu_sort);
        });

    });
</script>