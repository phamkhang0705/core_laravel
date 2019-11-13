<table class="table table-bordered">
    <thead>
        <tr>
            <th class="" style="width: 150px">Loại lỗi</th>
            <th class="" style="width: 100px">Mức độ ưu tiên</th>
            <th class="" style="width: 100px">Ngày gửi</th>
            <th class="" style="width: 150px">CSKH</th>
            <th class="" style="width: 100px">Người cập nhật</th>
            <th class="" style="width: 100px">Ngày cập nhật</th>
            <th class="" style="width: 100px">Trạng thái</th>
            <th class="" style="width: 100px">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($datas[0])) @foreach($datas as $tmp)
        <?php  
            $a = $tmp->admin()->first();
            $ac = $tmp->adminCreate()->first();
            $t = $tmp->types()->first();
            ?>
        <tr class="" role="row">
            <td class="">{!! isset($t) ? $t->title : '' !!}</td>
            <td class="">{!! $tmp->labelName() !!}</td>

            <td>{{ $tmp->getCreatedTime() }}</td>
            <td class="">{{ isset($a) ? $a->fullname : ''}}</td>
            <td class="">{!! isset($ac) ? $ac->fullname : '' !!}</td>
            <td class="">{{ $tmp->getUpdatedTime() }}</td>
            <td>{!! $tmp->statusName() !!} </td>
            <td class="text-center">
                <a class="item-tool" title="Xem thông tin" target="_blank" href="{!! route('cms.ticket.show',['id'=>$tmp->id]) !!}">
                        <i class="material-icons">visibility</i>
                    </a>

            </td>
        </tr>
        @endforeach @else
        <tr>
            <td class="text-center" colspan="5"><b>Không có dữ liệu</b></td>
        </tr>
        @endif
    </tbody>
</table>