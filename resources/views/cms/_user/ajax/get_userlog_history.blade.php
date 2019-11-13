<table class="table table-bordered">
    <thead>
    <tr>
        <th style="width: 20px" class="text-center">STT</th> 
        <th style="width: 80px">Thời gian</th>
        <th style="width: 180px" >Loại hàng động</th>
        <th style="width: 200px" >Nội dung thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(true)
        <?php $i = 0 ; ?>
            @foreach($datas as $item)
                <?php $i++;
                    $u = $item->user()->first();
                ?>
                <tr>
                    <td class="text-center"> {{ $i }} </td> 
                    <td>{{ $item->getCreatedTime()}}</td> 
                    <td>{{ $item->action_type.' - '.$item->action }}</td>
                    <td>{{ $item->content_type.' - '.$item->content }}</td> 
                </tr>
            @endforeach
        @else
            <tr>
                <td class="4"> Không có dữ liệu </td>
            </tr>
        @endif
    </tbody>
</table>