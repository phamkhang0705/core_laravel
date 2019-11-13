@extends('cms.layouts.default')

@section('title', "Danh sách quản trị viên")

@section('content')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card" style="margin-bottom: 15px;">
                <div class="body">
                    <form id='form' action="/admin" method="get">
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 m-b-0">
                                <label>Nhóm người dùng</label>
                                <select name="admin_group" class="form-control" onchange="$('#form').submit();">
                                    <option value="all" @if(request()->get('status') == 'all') selected @endif >Tất cả
                                    </option>
                                    @foreach($admin_groups as $admin_group)
                                        <option
                                                @if($admin_group->name == request()->get('admin_group')) selected @endif
                                        value="{!! $admin_group->name !!}">{!! $admin_group->name !!}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 m-b-0">
                                <label>Trạng thái</label>

                                <select name="status" class="form-control" onchange="$('#form').submit();">
                                    <option value="all" @if(request()->get('status') == 'all') selected @endif >Tất cả
                                    </option>
                                    <option value="ACTIVE" @if(request()->get('status') == 'ACTIVE') selected @endif>
                                        Hoạt động
                                    </option>
                                    <option value="INACTIVE"
                                            @if(request()->get('status') == 'INACTIVE') selected @endif>Khóa
                                    </option>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 m-b-0">
                                <div class="form-group m-0">
                                    <label>&nbsp;</label>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Tên đăng nhập" value="{{request()->get('name')}}">

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 m-b-0">
                                <div class="form-group m-0">
                                    <label>&nbsp;</label>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="fullname"
                                               placeholder="Họ tên" value="{{request()->get('fullname')}}">

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 m-b-0">
                                <div class="form-group m-0">
                                    <label>&nbsp;</label>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="email"
                                               placeholder="Email" value="{{request()->get('email')}}">

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 m-b-0">
                                <label>&nbsp;</label>

                                <button type="submit" class="btn btn-primary dropdown-toggle">
                                    Tìm kiếm
                                </button>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">

                <div class="body table-responsive" style="padding-bottom: 150px;">
                    <?php $datas = $users;?>
                    @include('cms.element.alert')
                    @include('cms.element.paginate')

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 60px" class="text-center">#</th>
                            <th>Tên đăng nhập</th>
                            <th class="col-sm-1">Họ tên</th>
                            <th class="col-sm-1">Email</th>
                            <th class="col-sm-1">Điện thoại</th>
                            <th class="col-sm-1">Nhóm quản trị</th>
                            <th class="col-sm-2">Trạng thái</th>
                            <th width="100" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0;?>
                        @if(count($datas)>0)
                            @foreach($users as $user)
                                <?php $i++;?>
                                <tr>
                                    <td class="text-center">{!! $i !!}</td>
                                    <td>
                                        <strong>
                                            <a href="{!! route('cms.admin.show',['id'=>$user->id]) !!}">
                                                {!! $user->name !!}
                                            </a>
                                        </strong>
                                    </td>
                                    <td>{!! $user->fullname !!}</td>
                                    <td>{!! $user->email !!}</td>
                                    <td>{!! $user->phone !!}</td>
                                    <td>{!! $user->group_name !!}</td>
                                    <td>
                                        @if($user->status == 'ACTIVE')
                                            <span class="font-bold col-teal">
                                            Hoạt động
                                        </span>
                                        @else
                                            <span class="font-bold col-pink">
                                            Khóa
                                        </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- <a class="item-tool" title="Xem thông tin"
                                           href="">
                                            <i class="material-icons">visibility</i>
                                        </a> -->
                                        @if(\App\Common\AdminPermission::isAllow("Admin" . '@' . "edit"))
                                            <a class="item-tool" title="Sửa thông tin"
                                               href="{!! route('cms.admin.edit',['id'=>$user->id]) !!}">
                                                <i class="material-icons">edit</i>
                                            </a>

                                            @if($user->status == 'ACTIVE')
                                                <a class="item-tool lock" href="javascript:void(0);"
                                                   title="Khóa tài khoản"
                                                   data-id="{{$user->id}}" data-name="{{$user->name}}">
                                                    <i class="material-icons">lock</i>
                                                </a>
                                            @else
                                                <a class="item-tool unlock" href="javascript:void(0);"
                                                   title="Mở khóa tài khoản"
                                                   data-id="{{$user->id}}" data-name="{{$user->name}}">
                                                    <i class="material-icons">lock_open</i>
                                                </a>
                                            @endif
                                        @endif

                                    </td>
                                </tr>
                            @endforeach @else
                            <tr>
                                <td colspan="8" class="text-center">Không có dữ liệu</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    @include('cms.element.paginate')

                </div>
            </div>
        </div>
    </div>
    @if(\App\Common\AdminPermission::isAllow("Admin" . '@' . "create"))
        @include('cms.element.button_create', ['url'=>action('Cms\Admin@create'),'tooltip'=>'Thêm nhân viên mới'])
    @endif
@stop

@section('footer.script')
    @parent

    <script src="{{ asset('cms/js/admin.js') }}"></script>

@endsection