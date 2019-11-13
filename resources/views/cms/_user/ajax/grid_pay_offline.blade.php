<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 80px" class="text-center">Mã GD</th>
            <th style="width: 100px" class="text-center">Mã GD (hóa đơn)</th>
            <th style="width: 100px" class="text-center">Số tiền thanh toán</th>
            <th style="width: 120px" class="text-center">Cashback</th>
            <th style="width: 120px" class="text-center">Ngày thanh toán</th>
            <th style="width: 220px" class="text-center">Deal/Place</th>
            <th style="width: 150px" class="text-center">Loại</th>
            <th style="width: 60px" class="text-center">Trạng thái</th>
            <th style="width: 40px" class="text-center">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($datas[0])) 
        @foreach($datas as $item)
        <tr>
            <td class="font-bold">{{$item->tran_id }}</td>
            <td class="font-bold">{{$item->payment_bill_code }}</td>
            <td class="text-right">{{\App\Common\Number::price($item->total_bill)}} đ</td>
            <td class="text-right">{{\App\Common\Number::price($item->cashback)}} đ</td>
            <td>{{$item->getCreatedAtTime()}}</td>
            <td>
                <div>
                 <b>Deal: </b> {{ isset($item->deal) ? $item->deal->deal_title : ""}} 
                </div>

                <div>
                    <b>Place: </b>{{$item->place->name}}
                    <br/><b>Địa chỉ: </b>{{$item->place->address}} 
                </div>
            </td> 
            <td>{{$item->typeQRCode() }}</td> 
            <td>{{$item->statusName() }}</td> 
            <td>
                <a class="item-tool" title="Xem chi tiết" target="_blank"
                   href="{{action('Cms\PayOffline@show', ['id'=>$item->clingme_id])}}">
                    <i class="material-icons">visibility</i>
                </a> 
            </td>
        </tr>
        @endforeach @else
        <tr>
            <td class="text-center" colspan="10"><b>Không có dữ liệu</b></td>
        </tr>
        @endif


    </tbody>
</table>