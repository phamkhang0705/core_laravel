<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 80px" class="text-center">Mã GD</th>
            <th style="width: 100px" classx="text-center">User</th>
            <th style="width: 100px" classx="text-center">SĐT User</th>
            <th style="width: 120px" classx="text-center">Loại</th>
            <th style="width: 120px" classx="text-center">SĐT nạp</th>
            <th style="width: 120px" classx="text-center">Nhà mạng</th>
            <th style="width: 150px" class="text-center">Số tiền TT</th>
            <th style="width: 60px" class="text-center">Ngày TT</th>
            <th style="width: 60px" class="text-center">Trạng thái TT</th>
            <th style="width: 60px" class="text-center">Trạng thái nạp tiền đt</th>
            <th style="width: 40px" class="text-center">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($datas[0])) @foreach($datas as $item)
        <?php
        $userRequestCashbackFirst = null;
        if (isset($item->info->userRequestCashback) && $item->info->userRequestCashback instanceof \Illuminate\Database\Eloquent\Collection) {
            $userRequestCashbackFirst =  $item->info->userRequestCashback->first();
        }
        ?>
        <tr>
            <td class="font-bold">{{$item->order_code }}</td>
            <td>{{$item->user->nick_name }}</td>
            <td>{{$item->user->phone}}</td>
            <td>{{$item->getType() }}</td>
            <td>{{$item->receiver_phone }}</td>
            <td>{{$item->info->getTelcoName() }}</td>
            <td class="text-right">{{\App\Common\Number::price($item->price_total)}}đ</td>
            <td>{{$item->getCreatedTime()}}</td>
            <td data-toggle="{{$item->status}}">{{$item->getStatus()}}</td>
            <td>
                @if($userRequestCashbackFirst instanceof \App\Models\HlGlobal\UserRequestCashbackGame)
                <span data-status="{{$userRequestCashbackFirst->status}}" data-id="{{$userRequestCashbackFirst->request_id}}">
                                        {{$userRequestCashbackFirst->getStatus()}}
                                    </span> @endif
            </td>
            <td>
                <a class="item-tool" title="Xem chi tiết" target="_blank"
                   href="{{action('Cms\TransactionMobile@show', ['id'=>$item->order_id] )}}">
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