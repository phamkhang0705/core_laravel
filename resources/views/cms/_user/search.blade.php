@extends('cms.layouts.default') 
@section('title', "Tìm kiếm user") 
@section('content')

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="card" style="margin-bottom: 15px;">
            <div class="body">
                
                <div class="cms_element_alert">
                    @include('cms.element.alert')
                </div>
                <form id='form-filter' action="{{route('cms.user.search')}}" method="get">
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-12"></div>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                            <div class="form-group m-0">
                                <div class="form-line">
                                    <input type="text" id="username" name="username" class="form-control fake" value="{{request('username') ?? old('username')}}">
                                    <label class="form-label" for="username">Tìm theo tên User</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                            <div class="form-group m-0">
                                <div class="form-line">
                                    <input type="text" id="userid" name="userid" class="form-control fake" value="{{request('userid') ?? old('userid')}}">
                                    <label class="form-label" for="userid">Tìm theo Id User</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                            <div class="form-group m-0">
                                <div class="form-line">
                                    <input type="text" id="phone" name="phone" class="form-control fake" value="{{request('phone') ?? old('phone')}}">
                                    <label class="form-label" for="phone">Tìm theo số điện thoại</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                            <div class="form-group m-0">
                                <div class="form-line">
                                    <input type="text" id="email" name="email" class="form-control fake" value="{{request('email') ?? old('email')}}">
                                    <label class="form-label" for="email">Tìm theo Email</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-12 col-sm-8 col-xs-12">  
                            <div class="pull-right">
                                {{-- <button type="button" data-clear="true" class="btn btn-default">
                                    LÀM MỚI
                                </button> --}}
                                <button type="submit" class="btn btn-primary">
                                    TÌM KIẾM
                                </button>
                            </div>
                        </div> 
                    </div>
                </form>
            </div>
        </div>

        @if(isset($datas))
        <div class="card">
            <div class="body table-responsive" style="padding-bottom: 150px;">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 80px" class="text-center">User ID</th>
                            <th style="width: 200px" classx="text-center">Khách hàng</th>
                            <th style="width: 100px" classx="text-center">SĐT</th>
                            <th style="width: 120px" classx="text-center">Email</th>
                            <th style="width: 120px" classx="text-center">Facebook</th>
                            <th style="width: 150px" class="text-center">Nhóm khách hàng</th>
                            <th style="width: 80px" class="text-center">Trạng thái</th>
                            <th style="width: 60px" class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($datas)==0)
                        <tr>
                            <td colspan="8" class=text-center>Không tìm thấy dữ liệu</td>
                        </tr>

                        @else @foreach($datas as $item)
                        <tr>
                            <td>{{ $item ->global_user_id }}</td>
                            <td>{{ $item ->nick_name }}</td>
                            <td>{{ $item ->phone }}</td>
                            <td>{{ $item ->email}}</td>
                            <td>@if(isset($item->facebook_id))
                                    <a href="https://fb.com/{{$item->facebook_id}}" target="_blank"> https://facebook.com/{{$item->facebook_id}}</a>   
                                    @endif
                                </td>
                            <td><?php $groups= $item->groupShow()->get(); ?>
                                @foreach($groups as $g) {{$g->desciption.', ' }} @endforeach</td>
                            <td>{!! $item ->statusHtml() !!}</td>
                            <td class="text-center">
                                <a class="item-tool" title="Xem" href="{!! route('cms.user.show',['id'=>$item->global_user_id]) !!}">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                {{-- <a class="item-tool" title="Sửa" href="{!! route('cms.user.edit',['id'=>$item->global_user_id]) !!}">
                                            <i class="material-icons">edit</i>
                                        </a> --}}
                            </td>
                        </tr>
                        @endforeach @endif
                    </tbody>
                </table>

            </div>
        </div>
        @endif

    </div>
</div>
{{--    @include('cms.element.button_create', ['url'=>action('Cms\Admin@create'),'tooltip'=>'Thêm nhân user mới']) --}} 
@stop