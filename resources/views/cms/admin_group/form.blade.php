@extends('cms.layouts.default')

@section('title', "Form cập nhật thông tin admin group")

@section('content')
    <?php $id = isset($form_option['id']) ? $form_option['id'] : '';?>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body">
                    
                    @include('cms.element.alert')
                    
                    {!! Form::open(['route'=>[$form_option['action'],'id'=>$id], 'method'=>'post', 'class'=>'form-horizontal', 'id'=>'create-new']) !!}
                    {!! Form::hidden('_method',$form_option['method']) !!}
                    {!! Form::hidden('id', $id) !!}

                    <?php $action = isset($form_option['method']) ? $form_option['method'] : 'post'?>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Mã nhóm <label class="text-danger">*</label></label>

                        <div class="col-sm-10">
                            <div class="form-line">
                                    <input name="code" value="@if(isset($data['code'])) {!! $data['code'] !!} @else {{ old('code', '') }} @endif"
                                        type="text" class="need_focus form-control"
                                        @if(isset($action) && $action == 'put')
                                            disabled
                                        @endif
                                        required maxlength="10">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tên nhóm <label class="text-danger">*</label></label>

                        <div class="col-sm-10">
                            <div class="form-line">
                                <input name="name" value="@if(isset($data['name'])){!! $data['name'] !!} @else {{ old('name', '') }} @endif"
                                       type="text" class="form-control" required maxlength="30">
                            </div>
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
                                                <input type="checkbox" id="role_{{$role->id}}_all" class="filled-in all" data-role-id="{{ $role->id }}"
                                                    {{!empty($role_allows[$role->id][$role->controller.'@'])?'checked':''}}
                                                       name="role[{{$role->id}}][]" value="{{$role->controller}}@"/>
                                                <label for="role_{{$role->id}}_all"></label>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="role_{{$role->id}}_view" class="filled-in element-{{ $role->id }}"
                                                       name="role[{{$role->id}}][]"
                                                       {{!empty($role_allows[$role->id][$role->controller.'@view'])?'checked':''}}
                                                       value="{{$role->controller.'@'}}view"/>
                                                <label for="role_{{$role->id}}_view"></label>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="role_{{$role->id}}_create" class="filled-in element-{{ $role->id }}"
                                                    name="role[{{$role->id}}][]"
                                                       {{!empty($role_allows[$role->id][$role->controller.'@create'])?'checked':''}}
                                                       value="{{$role->controller}}@create"/>
                                                <label for="role_{{$role->id}}_create"></label>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="role_{{$role->id}}_edit"
                                                       name="role[{{$role->id}}][]" value="{{$role->controller}}@edit"
                                                       {{!empty($role_allows[$role->id][$role->controller.'@edit'])?'checked':''}}
                                                       class="filled-in element-{{ $role->id }}"/>
                                                <label for="role_{{$role->id}}_edit"></label>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="role_{{$role->id}}_destroy"
                                                       name="role[{{$role->id}}][]" value="{{$role->controller}}@destroy"
                                                       {{!empty($role_allows[$role->id][$role->controller.'@destroy'])?'checked':''}}
                                                       class="filled-in element-{{ $role->id }}"/>
                                                <label for="role_{{$role->id}}_destroy"></label>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="role_{{$role->id}}_approve"
                                                       name="role[{{$role->id}}][]" value="{{$role->controller}}@approve"
                                                       {{!empty($role_allows[$role->id][$role->controller.'@approve'])?'checked':''}}
                                                       class="filled-in element-{{ $role->id }}"/>
                                                <label for="role_{{$role->id}}_approve"></label>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="role_{{$role->id}}_export"
                                                       name="role[{{$role->id}}][]" value="{{$role->controller}}@export"
                                                       {{!empty($role_allows[$role->id][$role->controller.'@export'])?'checked':''}}
                                                       class="filled-in element-{{ $role->id }}"/>
                                                <label for="role_{{$role->id}}_export"></label>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <div class="col-sm-12 text-right">
                            <button class="btn btn-primary waves-effect create-new" type="submit" style="height: 37px;">
                                <i class="fa fa-check"></i>
                                @if(isset($action) && $action == 'put')
                                    CẬP NHẬT
                                @else
                                    THÊM MỚI
                                @endif
                            </button>
                            @include('cms.element.button_back',
                                        ['url'=> request()->ref ? request()->ref : action('Cms\AdminGroup@index') ])
                        </div>

                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@stop

@section('footer.script')
    @parent
    <script src="{{ asset('cms/js/admin_group.js') }}"></script>
@endsection