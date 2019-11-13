<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 80px" class="text-center">Mã GD</th>
            <th style="width: 100px" class="text-center">Cashout</th>
            <th style="width: 100px" class="text-center">Hình thức</th>
            <th style="width: 120px" class="text-center">Chi tiết</th>
            <th style="width: 120px" class="text-center">Ngày gửi yêu cầu</th>
            <th style="width: 120px" class="text-center">Ngày cập nhật</th>
            <th style="width: 150px" class="text-center">Người cập nhật</th>
            <th style="width: 60px" class="text-center">Trạng thái</th>
            <th style="width: 40px" class="text-center">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($datas[0])) @foreach($datas as $item)
        <tr>
            <td class="font-bold">{{$item->cash_out_id }}</td>
            <td>{{\App\Common\Number::price($item->cash)}}đ</td>
            <td>{{$item->typeName() }}</td>
            <td>{!!$item->getDetail() !!}</td>
            <td>{{$item->getCreateTime() }}</td>
            <td>{{$item->getConfirmedTime() }}</td>
            <td>{{ "" }}</td>
            <td>{!!$item->statusName() !!}</td>
            <td>
                <a class="item-tool" title="Xem chi tiết" target="_blank"
                    href="{{action('Cms\Cashout@show', ['id'=>$item->cash_out_id])}}">
                    <i class="material-icons">visibility</i>
                </a> 
            </td>
        </tr>
        @endforeach @else
        <tr>
            <td class="text-center" colspan="9"><b>Không có dữ liệu</b></td>
        </tr>
        @endif


    </tbody>
</table>