<table class="table table-hover">
    <thead>
    <tr>
        <th width="50">Mã đặt chỗ MC</th>
        <th width="70">Mã đặt chỗ</th>
        <th width="70">User ID</th>
        <th width="100">Khách hàng</th>
        <th width="150">Địa điểm</th>
        <th width="80">Thời gian tạo</th>
        <th width="150">Nội dung</th>
        <th width="80">MC status</th> 
        <th width="40">Hành động</th> 
    </tr>
    </thead>
    <tbody>
        <?php $i = 0;?>
    @foreach($data as $key=>$item)
    <?php $i++;?>
        <tr>
            <td class="font-bold">{{$item->order_code }}</td>
            <td class="font-bold">{{$item->tran_id }}</td>
            <td>{{$item->user->global_user_id }}</td>
            <td>{{$item->user->nick_name }} <br/> {{$item->user->getPhone() }}</td>
            <td>
                <div>
                    <b>Place: </b>{{$item->place->name}}
                    <br/><b>Địa chỉ: </b>{{$item->place->address}}
                </div>
            </td>
            <td>{{$item->getCreatedAt() }}</td>
            <td>{!! $item->deatils() !!}</td>
            <td>{{$item->statusName() }}</td> 
            <td>
                <a class="item-tool" title="Xem chi tiết" target="_blank"
                   href="{{action('Cms\Booking@show', ['id'=>$item->clingme_id])}}">
                    <i class="material-icons">visibility</i>
                </a> 
            </td>
        </tr>
    @endforeach
    </tbody>
</table>