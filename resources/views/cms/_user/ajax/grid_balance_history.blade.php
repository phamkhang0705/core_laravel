<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 80px" class="">ID</th>
            <th style="width: 80px" class="">Mã GD</th>
            <th style="width: 120px" class="">Loại giao dịch</th>
            <th style="width: 200px" class="text-center">Ghi chú</th> 
            <th style="width: 80px" class="text-right">Số tiền</th>
            <th style="width: 100px" class="text-center">Số dư sau GD</th>
            <th style="width: 100px" class="">Thời gian</th> 
        </tr>
    </thead>
    <tbody>
        @if(isset($datas[0])) 
        @foreach($datas as $item)
        <tr>
            <td class="font-bold">{!! $item->ID !!}</td>
            <td class="font-bold">{!! $item->resOrder()['id'] !!}</td>
            {{-- <td class="font-bold">{{$item->ExternalOrderID }}</td> --}}
            <td>{{ $item->resOrder()['type'] }}</td>
            <td>{{$item->Info}}</td>
            <td class="text-right">{!! $item->Side == \App\Models\Payment\Transaction::SIDE_ADD  ? "+" : "-" !!} {{\App\Common\Number::price($item->Amount)}}đ</td>
            <td class="text-right">{{\App\Common\Number::price($item->Balance)}}đ</td>
            <td>{{$item->getCreateDate() }}</td>
        </tr>
        @endforeach 
        @else
        <tr>
            <td class="text-center" colspan="5"><b>Không có dữ liệu</b></td>
        </tr>
        @endif
    </tbody>
</table>