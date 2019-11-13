@extends('cms.layouts.default')

@section('title', 'Quản lý chức năng phân quyền CMS')

@section('content')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="card" style="margin-bottom: 15px;">
                <div class="body">
                    <form id='form-filter' action="{!! action('Cms\AdminRole@index') !!}" method="get"
                          class="form-inline">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 m-b-0"></div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 m-b-0">
                                <label>Mã</label>
                                <div class="form-group m-0">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="code"
                                               placeholder="Nhập mã " value="{{request('code')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 m-b-0">
                                <label>Tên</label>
                                <div class="form-group m-0">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Nhập tên " value="{{request('name')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 m-b-0">
                                <label>Trạng thái</label>

                                <select name="status" class="form-control" onchange="$('#form-filter').submit();">
                                    <option value="" {{request('status', '') ==  ''?'selected':''}}>Tất cả
                                    </option>
                                    <option value="ENABLE" {{request('status', '') == 'ENABLE'?'selected':''}}>
                                        Đang hoạt động
                                    </option>
                                    <option value="DISABLE" {{request('status', '') == 'DISABLE'?'selected':''}}>Không
                                        hoạt động
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 m-b-0">
                                <label></label>
                                <button type="submit" class="btn btn-primary waves-effect btn-block">
                                    TÌM KIẾM
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="header">
                    <h2>
                        QUẢN LÝ CHỨC NĂNG PHÂN QUYỀN CMS
                    </h2>
                </div>
                <div class="body table-responsive" style="padding-bottom: 150px;">

                    @include('cms.element.alert')

                    @include('cms.element.paginate',['datas'=>$data])

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th width="5%" class="text-center">ID</th>
                            <th width="20%">Code</th>
                            <th>Tên</th>
                            <th width="10%">Sắp xếp</th>
                            <th width="10%">Trạng thái</th>
                            <th width="10%" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($data as $key=>$item)
                            <tr>
                                <td class="text-center">{{$item->id}}</td>
                                <td class="font-bold">{{ $item->controller }}</td>
                                <td class="font-bold">{{ $item->name }}</td>
                                <td class="font-bold">{{ $item->order }}</td>

                                <td>
                                    @if($item->status == 'ENABLE')
                                        <span class="font-bold col-teal">
                                            Hoạt động
                                        </span>
                                    @else
                                        <span class="font-bold col-pink">
                                            Khóa
                                        </span>
                                    @endif
                                </td>

                                <td class="text-right">
                                    <a class="item-tool" title="Xem thông tin"
                                       href="{{action('Cms\AdminRole@show', ['id'=>$item->id])}}">
                                        <i class="material-icons">visibility</i>
                                    </a>
                                    @if($item->status == 'ENABLE')
                                        <a class="item-tool lock" href="javascript:void(0);" title="Khóa"
                                           data-id="{{$item->id}}" data-name="{{$item->name}}">
                                            <i class="material-icons">lock</i>
                                        </a>
                                    @else
                                        <a class="item-tool unlock" href="javascript:void(0);" title="Mở khóa"
                                           data-id="{{$item->id}}" data-name="{{$item->name}}">
                                            <i class="material-icons">lock_open</i>
                                        </a>
                                    @endif

                                    <a class="item-tool" title="Sửa thông tin"
                                       href="{{action('Cms\AdminRole@edit', ['id'=>$item->id])}}">
                                        <i class="material-icons">edit</i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    @include('cms.element.paginate',['datas'=>$data])

                </div>
            </div>
        </div>
    </div>
    @if(\App\Common\AdminPermission::isAllow("AdminRole" . '@' . "create"))
        @include('cms.element.button_create', ['url'=>action('Cms\AdminRole@create'),'tooltip'=>'Thêm mới'])
    @endif

@endsection

@section('footer.script')
    @parent

    <script src="{{ asset('cms/js/admin_role.js') }}"></script>

@endsection