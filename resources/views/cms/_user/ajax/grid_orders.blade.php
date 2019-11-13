<table class="table table-bordered">
    <thead>
    <tr>
        <th width="80">ID</th>
        <th width="80">Mã MC</th>
        <th width="120">Mã đơn hàng</th>
        {{-- <th width="80">UserID</th>
        <th width="150">User</th> --}}
        <th>Địa điểm</th>
        <th width="180">Tổng tiền thanh toán</th>
        <th width="150">Thời gian đặt hàng</th>
        <th width="180">Trạng thái đơn hàng</th>
        <th width="180">Trạng thái user</th>
        <th width="50">Hành động</th>
        {{-- <th width="100">Hành động</th> --}}
    </tr>
    </thead>
    <tbody>
    @if($datas->count() > 0)
        @foreach($datas as $key=>$item)
            <tr>
                <td class="font-bold">{{$item->order_id}}</td>
                <td class="font-bold">{{$item->external_order_code}}</td>
                <td class="font-bold">{{$item->order_code}}</td>
                {{-- <td>{{$item->user_id}}</td>
                <td>
                    @if($item->user instanceof \App\Models\HlGlobal\AdminGlobalUser)
                        <p>{{$item->user->nick_name}}</p>
                        {{$item->user->phone}}
                    @endif
                </td> --}}
                <td>
                    {{$item->place->name}}

                    <div>
                        <b>Địa chỉ: </b>{{$item->place->address}}
                    </div>
                </td>
                <td>{{\App\Common\Number::price($item->price_total)}}đ</td>
                <td>{{$item->getCreatedTime()}}</td>
                <td data-action="{{$item->status}}">{{$item->getStatus()}}</td>
                <td>{{$item->getMemberStatus()}}</td>
                <td>
                    <a class="item-tool" title="Xem chi tiết" target="_blank"
                        href="{{action('Cms\Order@show', ['id'=>$item->order_id])}}">
                        <i class="material-icons">visibility</i>
                    </a>
                    {{-- @if(in_array($item->status, [\App\Models\HlGlobal\SaleProductOrder::STATUS_CANCELLED,
                    \App\Models\HlGlobal\SaleProductOrder::STATUS_WAITING_PAY,
                    \App\Models\HlGlobal\SaleProductOrder::STATUS_FAIL]))
                        <a class="item-tool" title="Xem chi tiết"
                            href="{{action('Cms\Order@edit', ['id'=>$item->order_id])}}">
                            <i class="material-icons">edit</i>
                        </a>
                    @endif --}}
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="9" class="text-center">
                <b>Không tìm thấy dữ liệu</b>
            </td>
        </tr>
    @endif

    </tbody>
</table>