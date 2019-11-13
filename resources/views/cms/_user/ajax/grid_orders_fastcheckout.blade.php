
<table class="table table-hover">
    <thead>
    <tr>
        <th width="50">Mã GD</th> 
        <th width="70">Mã HĐ</th> 
        {{-- <th width="70">User ID</th>
        <th width="120">Khách hàng</th> --}}
        <th width="70">Số tiền <br/>thanh toán</th>
        {{-- <th width="70">Cashback</th> --}}
        <th width="70">Ngày thanh toán</th>
        <th width="120">Deal/Place</th>
        {{-- <th width="80">Loại</th> --}}
        <th width="80">Trạng thái</th> 
        <th width="50">Hành động</th>
    </tr>
    </thead>
    <tbody>
    <?php $i =0; ?>
    @if(isset($data[0]))
    @foreach($data as $key=>$item)
    <?php $i++; ?>
        <tr> 
            <td class="font-bold">{{$item->order_code }}</td>
            <td class="font-bold">{{$item->external_order_code }}</td>
            {{-- <td>{{$item->user->global_user_id ?? '' }}</td>
            <td>{{$item->user->nick_name ?? '' }} <br/> {{ isset($item->user) ? $item->user->getPhone() : '' }}</td> --}}
            <td class="text-rightx">{{\App\Common\Number::price($item->price_total + $item->shipping_fee)}}đ</td>
            <td>{{$item->getCreatedTime()}}</td>
            <td>
                {{-- <div>
                    <b>Deal: </b> {{ isset($item->deal) ? $item->deal->deal_title : ""}} 
                </div> --}}
                <div>
                    <b>Place: </b>{{$item->place->name}}
                    <br/><b>Địa chỉ: </b>{{$item->place->address}} 
                </div>
            </td> 
            {{-- <td>{{$item->typeQRCode() }}</td>  --}}
            <td>{{$item->fastCheckoutStatusName() }}</td> 
            <td class="text-center">
                <a class="item-tool" title="Thông tin" target="_blank"
                    href="{{action('Cms\FastCheckout@show', ['id'=>$item->order_id])}}">
                        <i class="material-icons">visibility</i>
                    </a> 
            </td>
        </tr>
    @endforeach
    @else
    <tr> 
            <td colspan="10"><b>Không tìm thấy dữ liệu</b></td>
    </tr>
    @endif

    </tbody>
</table>