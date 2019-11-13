@extends('cms.layouts.default')

@section('title', "Form cập nhật thông tin admin group")

@section('content')
    <?php $id = isset($form_option['id']) ? $form_option['id'] : '';?>


    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body">
                    <div class="form-horizontal">

                        <div class="form-group">
                            <label class="col-sm-2 text-right">Mã nhóm</label>

                            <div class="col-sm-10">
                                {{$data['code'] or ''}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 text-right">Tên nhóm</label>

                            <div class="col-sm-10">
                                {{$data['name'] or ''}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Danh sách chức năng</label>

                            <div class="col-sm-10">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr role="row">
                                        <th class="text-center" width="50" style="width: 50px">#</th>
                                        <th>Tên chức năng</th>
                                        <th width="80" class="text-center">Tất cả</th>
                                        <th width="80" class="text-center">Xem</th>
                                        <th width="80" class="text-center">Thêm</th>
                                        <th width="80" class="text-center">Sửa</th>
                                        <th width="80" class="text-center">Xóa</th>
                                        <th width="80" class="text-center">Duyệt</th>
                                        <th width="150" class="text-center">Xuất dữ liệu</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($admin_roles))
                                        @foreach($admin_roles as $key=>$role)
                                            <tr>
                                                <td class="text-center">{{$key+1}}</td>
                                                <td>{{$role->name}}</td>
                                                <td class="text-center">
                                                    @if(!empty($role_allows[$role->id][$role->controller.'@']))
                                                        <i class="material-icons">check_box</i>
                                                    @else
                                                        <i class="material-icons">check_box_outline_blank</i>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if(!empty($role_allows[$role->id][$role->controller.'@view']))
                                                        <i class="material-icons">check_box</i>
                                                    @else
                                                        <i class="material-icons">check_box_outline_blank</i>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if(!empty($role_allows[$role->id][$role->controller.'@create']))
                                                        <i class="material-icons">check_box</i>
                                                    @else
                                                        <i class="material-icons">check_box_outline_blank</i>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if(!empty($role_allows[$role->id][$role->controller.'@edit']))
                                                        <i class="material-icons">check_box</i>
                                                    @else
                                                        <i class="material-icons">check_box_outline_blank</i>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if(!empty($role_allows[$role->id][$role->controller.'@destroy']))
                                                        <i class="material-icons">check_box</i>
                                                    @else
                                                        <i class="material-icons">check_box_outline_blank</i>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if(!empty($role_allows[$role->id][$role->controller.'@approve']))
                                                        <i class="material-icons">check_box</i>
                                                    @else
                                                        <i class="material-icons">check_box_outline_blank</i>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if(!empty($role_allows[$role->id][$role->controller.'@export']))
                                                        <i class="material-icons">check_box</i>
                                                    @else
                                                        <i class="material-icons">check_box_outline_blank</i>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7 text-right">
                                    <div class="form-group">
                                        @include('cms.element.button_back',
                                            ['url'=> request()->ref ? request()->ref : action('Cms\AdminGroup@index') ])
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
