@extends('cms.layouts.default')

@section('title', "Thêm thông tin menu")

@section('content')
        <?php $id = isset($form_option['id'])?$form_option['id']:'';?>


        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">


                    <div class="body">
                        {!! Form::open(['route'=>[$form_option['action'],'id'=>$id], 'method'=>'post', 'class'=>'form-horizontal']) !!}
                        {!! Form::hidden('_method',$form_option['method']) !!}
                        {!! Form::hidden('id', $id) !!}

                        <?php $action = isset($form_option['method'])?$form_option['method']:'post'?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tên (*)</label>

                            <div class="col-sm-10">
                                <div class="form-line">
                                    {!! Form::input('text', 'name', isset($data['name'])?$data['name']:'', ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Đường dẫn</label>

                            <div class="col-sm-10">
                                <div class="form-line">
                                {!! Form::input('text', 'url', isset($data['url'])?$data['url']:'', ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Danh mục cha</label>

                            <div class="col-sm-10">
                                <div class="form-line">
                                    <?php
                                    if(isset($menu_1s)) {
                                        $menu_1s[0] = 'Chọn danh mục';
                                    }
                                    ?>
                                    {!! Form::select('parent_id',isset($menu_1s)?$menu_1s:[] ,isset($data['parent_id'])?$data['parent_id']:'',['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Mã quyền</label>

                            <div class="col-sm-10">
                                <div class="form-line">
                                    {!! Form::input('text', 'permission_code', isset($data['permission_code'])?$data['permission_code']:'', ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Mô tả</label>

                            <div class="col-sm-10">
                                <div class="form-line">
                                    {!! Form::textarea('description', isset($data['description'])?$data['description']:'', ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Class</label>

                            <div class="col-sm-10">
                                <div class="form-line">
                                    {!! Form::input('text', 'icon', isset($data['icon'])?$data['icon']:'', ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Trạng thái</label>

                            <div class="col-sm-10">
                                <input type="checkbox"
                                       @if(isset($data['display']) && $data['display'] == 1)
                                       checked
                                       @endif
                                       name="display" value="1" id="basic_checkbox_1" class="filled-in">

                                <label for="basic_checkbox_1" class="m-0 p-0" style="display: initial;"></label>
                            </div>
                        </div>



                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg waves-effect" type="submit">
                                        @if(isset($action) && $action == 'put')
                                            CẬP NHẬT CHỈNH SỬA
                                        @else
                                            THÊM MỚI
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
@stop
