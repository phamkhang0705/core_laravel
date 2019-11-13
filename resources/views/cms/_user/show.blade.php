@extends('cms.layouts.default') 
@section('title', "Thông tin user") 
@section('content')


<!--- -->
<div class="row clearfix">
    <input type="hidden" name="global_user_id" id="global_user_id" value="{{$data->global_user_id}}" />
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="card">
            <div class="body clearfix">
                <div class="pull-right">

                    {{-- <button type="button" id="btnTicket" class="btn text-upper bg-red btn-lg waves-effect">Tạo Ticket</button> &nbsp; --}}
                    <a href="{{ route('cms.ticket.create',['user_id'=>$data->global_user_id]) }}" class="btn text-upper bg-red btn-lg waves-effect">Tạo Ticket</a>                    &nbsp;
                    <a href="{{ route('cms.user.edit',['id'=>$data->global_user_id]) }}" class="btn text-upper bg-red btn-lg waves-effect">Chỉnh sửa thông tin</a>                    &nbsp;
                    <button type="button" id="btnSuspect" class="btn text-upper bg-red btn-lg waves-effect">Đánh dấu gian lận</button>                    &nbsp;
                    <button type="button" id="btnStatus" class="btn text-upper bg-red btn-lg waves-effect" data-id="{{ $data->global_user_id }}" data-status="{{ $data->status()}}"> {{ $data->status() ==  App\Models\HlGlobal\AdminGlobalUser::STATUS_ACTIVE ? "Khóa tài khoản" : "Mở khóa tài khoản"  }} </button>                    &nbsp;
                </div>
            </div>
        </div>

        <div class="card">
            <div class="header">
                <h2> Thông tin khách hàng </h2>
            </div>

            <div class="body">
            @include('cms.element.alert')

                <div class="row clearfix">
                    <div class="col-sm-4 col-xs-12">
                        <p class="">Tên: {{$data->nick_name}}</p>
                        <p class="">SĐT: {{$data->getPhone() }}</p>
                        <p class="">Email: {{$data->email}}</p>
                        <p class="">Nhóm khách hàng: {{ join($groups->pluck('short')->toArray(), ', ') }}
                        </p>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <p class="">Ngày sinh: {{$data->getDateOfBirthTime() }}</p>
                        <p class="">Giới tính: {!! $data->getGenderName() !!}</p>
                        <p class="">Facebook: @if(isset($data->facebook_id))
                            <a href="https://fb.com/{{$data->facebook_id}}" target="_blank"> https://facebook.com/{{$data->facebook_id}}</a>                            @endif
                        </p>
                        @if(!$card_info->isEmpty())
                            <p class="">Thẻ thanh toán: </p>
                            @foreach($card_info as $card)
                            <?php $b = $card->bank()->first();  ?>
                            <p> &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; - {{$b->description}} ({{$card->HintCardNumber}})</p>
                            @endforeach
                        @endif
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <p class="">Ngày đăng ký: {{$data->getCreatedAtTime() }}</p>
                        <p class="">Trạng thái: {!! $data->statusHtml() !!}</p>
                        <p class="">Lần cuối đăng nhập: {{$data->getLoginAtTime()}}</p>
                        <p class="">Tài khoản Clingme Cashback: {{ App\Common\Utility::numberFormat(( $wallet ? $wallet->Amount : "0"),1000,"")}}đ
                        <p class="">Điểm thưởng (Credit): {{ App\Common\Utility::numberFormat(( $credit ? $credit->Amount : "0"),1000,"")}}
                        </p>
                        @if($suspects > 0)
                        <p class="font-bold col-pink">Đã đánh dấu gian lận {{ $suspects }} lần</p>
                        @endif
                    </div>
                </div>


            </div>
        </div>

        {{-- cskh --}}
        <div class="card-panel panel" id="tab1">
            <div class="panel-heading" role="tab">
                <h4 class="panel-title">
                    <a class="ptitle" role="button" data-toggle="collapse" href="#collapseOne_1">
                        Lịch sử CSKH 
                    </a>
                    <a href="{{ route('cms.ticket.index',['user_id'=>$data->global_user_id]) }}" class="ahref" target="_blank">Xem tất cả</a>
                    <label role="button" data-toggle="collapse" href="#collapseOne_1">
                        <i class="material-icons">expand_more</i>
                    </label>
                </h4>
            </div>
            <div id="collapseOne_1" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body" data-isdata="false" data-url="/user/get_ticket_history">
                    <p>Đang cập nhật...</p>
                </div>
            </div>
        </div>

        {{-- lịch sử đặt hàng --}}
        <div class="card-panel panel" id="tab2">
            <div class="panel-heading" role="tab">
                <h4 class="panel-title">
                    <a class="ptitle" role="button" data-toggle="collapse" href="#collapseOne_2">
                            Lịch sử đặt giao hàng 
                        </a>
                    <a href="{{ route('cms.order.index',['user_id'=>$data->global_user_id]) }}" class="ahref" target="_blank">Xem tất cả</a>
                    <label role="button" data-toggle="collapse" href="#collapseOne_2">
                            <i class="material-icons">expand_more</i>
                        </label>
                </h4>
            </div>
            <div id="collapseOne_2" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body" data-isdata="false" data-url="/user/get_data_orders">
                    <p>Đang cập nhật...</p>
                </div>
            </div>
        </div>

        {{-- lịch sử thanh toán tại địa điểm --}}
        <div class="card-panel panel" id="tab3">
            <div class="panel-heading" role="tab">
                <h4 class="panel-title">
                    <a class="ptitle" role="button" data-toggle="collapse" href="#collapseOne_3">
                                Lịch sử thanh toán tại địa điểm
                            </a>
                    <a href="{{ route('cms.pay_offline.index',['cate'=>'0', 'status'=>'',  'user_id'=>$data->global_user_id]) }}" class="ahref" target="_blank">Xem tất cả</a>
                    <label role="button" data-toggle="collapse" href="#collapseOne_3">
                                <i class="material-icons">expand_more</i>
                            </label>
                </h4>
            </div>
            <div id="collapseOne_3" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body" data-isdata="false" data-url="/user/get_pay_offline">
                    <p>Đang cập nhật...</p>
                </div>
            </div>
        </div>



        {{-- lịch sử thanh toán fast checkout --}}
        <div class="card-panel panel" id="tab_fast">
                <div class="panel-heading" role="tab">
                    <h4 class="panel-title">
                        <a class="ptitle" role="button" data-toggle="collapse" href="#collapseOne_tab_fast">
                                    Lịch sử thanh toán Fast checkout
                                </a>
                        <a href="{{ route('cms.fast_checkout.index',[ 'user_id'=>$data->global_user_id]) }}" class="ahref" target="_blank">Xem tất cả</a>
                        <label role="button" data-toggle="collapse" href="#collapseOne_tab_fast">
                                    <i class="material-icons">expand_more</i>
                                </label>
                    </h4>
                </div>
                <div id="collapseOne_tab_fast" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body" data-isdata="false" data-url="/user/get_pay_fast_checkout">
                        <p>Đang cập nhật...</p>
                    </div>
                </div>
            </div>
        {{-- lịch sử đặt chỗ --}}
        <div class="card-panel panel" id="tab4">
            <div class="panel-heading" role="tab">
                <h4 class="panel-title">
                    <a class="ptitle" role="button" data-toggle="collapse" href="#collapseOne_4">
                                    Lịch sử đặt chỗ
                                </a>
                    <a href="{{ route('cms.booking.index',['userid'=>$data->global_user_id]) }}" class="ahref" target="_blank">Xem tất cả</a>
                    <label role="button" data-toggle="collapse" href="#collapseOne_4">
                                    <i class="material-icons">expand_more</i>
                                </label>
                </h4>
            </div>
            <div id="collapseOne_4" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body" data-isdata="false" data-url="/user/get_booking">
                    <p>Đang cập nhật...</p>
                </div>
            </div>
        </div>

        {{-- lịch sử cashback--}}
        <div class="card-panel panel" id="tab5">
            <div class="panel-heading" role="tab">
                <h4 class="panel-title">
                    <a class="ptitle" role="button" data-toggle="collapse" href="#collapseOne_5">
                                    Lịch sử cashback
                                </a>
                    <a href="{{ action('Cms\DealTransaction@index', ['user_id' => $data->global_user_id, 'status'=>'all']) }}" class="ahref" target="_blank">Xem tất cả</a>
                    <label role="button" data-toggle="collapse" href="#collapseOne_5">
                                    <i class="material-icons">expand_more</i>
                                </label>
                </h4>
            </div>
            <div id="collapseOne_5" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body" data-isdata="false" data-url="/user/get_cashback">
                    <p>Đang cập nhật...</p>
                </div>
            </div>
        </div>

        {{-- lịch sử nạp tiền--}}
        <div class="card-panel panel" id="tab6">
            <div class="panel-heading" role="tab">
                <h4 class="panel-title">
                    <a class="ptitle" role="button" data-toggle="collapse" href="#collapseOne_6">
                                    Lịch sử nạp tiền điện thoại
                                </a>
                    <a href="{{ route('cms.transaction_mobile.index',['user_phone'=>$data->phone]) }}" class="ahref" target="_blank">Xem tất cả</a>
                    <label role="button" data-toggle="collapse" href="#collapseOne_6">
                                    <i class="material-icons">expand_more</i>
                                </label>
                </h4>
            </div>
            <div id="collapseOne_6" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body" data-isdata="false" data-url="/user/get_data_topup">
                    <p>Đang cập nhật...</p>
                </div>
            </div>
        </div>

        {{-- lịch sử cashout--}}
        <div class="card-panel panel" id="tab7">
            <div class="panel-heading" role="tab">
                <h4 class="panel-title">
                    <a class="ptitle" role="button" data-toggle="collapse" href="#collapseOne_7">
                                   Lịch sử cashout
                               </a>
                    <a href="{{ route('cms.cashout.index',['status'=> '-1','type'=> 'userid', 'q'=>$data->global_user_id]) }}" class="ahref" target="_blank">Xem tất cả</a>
                    <label role="button" data-toggle="collapse" href="#collapseOne_7">
                                   <i class="material-icons">expand_more</i>
                               </label>
                </h4>
            </div>
            <div id="collapseOne_7" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body" data-isdata="false" data-url="/user/get_cashout">
                    <p>Đang cập nhật...</p>
                </div>
            </div>
        </div>

        {{-- lịch sử tăng giảm số dư--}}
        <div class="card-panel panel" id="tab71">
            <div class="panel-heading" role="tab">
                <h4 class="panel-title">
                    <a class="ptitle" role="button" data-toggle="collapse" href="#collapseOne_71">
                                   Lịch sử thay đổi số dư tài khoản clingme
                               </a>
                    <a href="{{ route('cms.user_balance_history.index',['type'=> 'userid', 'q'=>$data->global_user_id]) }}" class="ahref" target="_blank">Xem tất cả</a>
                    <label role="button" data-toggle="collapse" href="#collapseOne_71">
                                   <i class="material-icons">expand_more</i>
                               </label>
                </h4>
            </div>
            <div id="collapseOne_71" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body" data-isdata="false" data-url="/user/get_balance_history">
                    <p>Đang cập nhật...</p>
                </div>
            </div>
        </div>

        {{-- lịch sử tăng giảm số dư credit--}}
        <div class="card-panel panel" id="tab72">
            <div class="panel-heading" role="tab">
                <h4 class="panel-title">
                    <a class="ptitle" role="button" data-toggle="collapse" href="#collapseOne_72">
                        Lịch sử thay đổi số dư Credit
                    </a>
                    <a href="{{ route('cms.user_credit_history.index',['type'=> 'userid', 'q'=>$data->global_user_id]) }}" class="ahref" target="_blank">Xem tất cả</a>
                    <label role="button" data-toggle="collapse" href="#collapseOne_72">
                        <i class="material-icons">expand_more</i>
                    </label>
                </h4>
            </div>
            <div id="collapseOne_72" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body" data-isdata="false" data-url="/user/get_credit_history">
                    <p>Đang cập nhật...</p>
                </div>
            </div>
        </div>

        {{-- lịch sử truy cập--}}
        <div class="card-panel panel" id="tab8">
            <div class="panel-heading" role="tab">
                <h4 class="panel-title">
                    <a class="ptitle" role="button" data-toggle="collapse" href="#collapseOne_8">
                            Lịch sử truy cập
                        </a>
                        <a href="{{ route('cms.user_action_log.index',['user_id'=>$data->global_user_id]) }}" class="ahref" target="_blank">Xem tất cả</a>
                    <label role="button" data-toggle="collapse" href="#collapseOne_8">
                            <i class="material-icons">expand_more</i>
                        </label>
                </h4>
            </div>
            <div id="collapseOne_8" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body" data-isdata="false" data-url="/user/get_userlog_history">
                    <p>Đang cập nhật...</p>
                </div>
            </div>
        </div>



    </div>
</div>



@stop 
@section('footer.script') @parent
<script src="{{asset('cms/js/user.js')}}"></script>
@endsection