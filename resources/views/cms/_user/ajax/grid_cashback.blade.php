<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 80px" class="text-center">Mã GD</th>
            <th style="width: 200px" class="text-center">Deal/Place</th>
            <th style="width: 100px" class="text-center">Tổng tiền HĐ</th>
            <th style="width: 120px" class="text-center">Cashback</th>
            <th style="width: 120px" class="text-center">Ngày gửi hóa đơn</th>
            <th style="width: 120px" class="text-center">Ngày cập nhật</th>
            <th style="width: 150px" class="text-center">Người cập nhật</th>
            <th style="width: 60px" class="text-center">Trạng thái</th>
            <th style="width: 40px" class="text-center">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($datas[0])) @foreach($datas as $item)
        <tr>
            <td>{{$item->getCode() }}</td>
            <td>
                <div>
                    <b>Deal: </b> {{ isset($item->deal) ? $item->deal->deal_title : ""}}
                </div>

                <div>
                    <b>Place: </b>{{isset($item->place) ? $item->place->name : "" }}
                    <br/><b>Địa chỉ: </b>{{isset($item->place) ? $item->place->address : ""}}
                </div>
            </td>
            <td class="text-right">{{\App\Common\Number::price($item->money_amount)}}đ</td>
            <td class="text-right">{{\App\Common\Number::price($item->cash_back)}}đ</td> 
            <td>{{$item->getBoughtTime() }}</td>
            <td>{{$item->getStatusUpdateTime() }}</td>
            <td></td>
            <td>{{$item->statusName()}}</td>
            <td>
                <a class="item-tool" title="Xem chi tiết" target="_blank"
                href="{{action('Cms\DealTransaction@show', ['id'=>$item->deal_transaction_id])}}" >
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