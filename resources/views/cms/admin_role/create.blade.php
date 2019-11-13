@extends('cms.layouts.default')

@section('title', 'Tạo mới thông tin chức năng CMS')

@section('content')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body">
                    <form id="form_update" class="form-horizontal"
                          method="POST"
                          autocomplete="off"
                          action="{!! action('Cms\AdminRole@store') !!}"
                          enctype="multipart/form-data">

                        <input name="_method" type="hidden" value="POST">
                        {{ csrf_field() }}

                        @include('cms.element.alert')

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label class="form-label">Mã (*)</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="controller"
                                               maxlength="50"
                                               placeholder="Nhập mã"  value="{{old('controller', '')
                                               }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label class="form-label">Tên (*)</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Nhập tên"
                                               maxlength="200"  value="{{old('name', '')}}"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label class="form-label">Sắp xếp</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="order"
                                               placeholder="Nhập sắp xếp"   value="{{old('order', '')}}"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Trạng thái hoạt động</label>
                            <div class="col-sm-10">
                                <input type="checkbox" {{ old('status', 'ENABLE') == 'ENABLE' ? 'checked' : '' }} name="status"
                                       value="ENABLE" id="basic_checkbox_1" class="filled-in">
                                <label for="basic_checkbox_1" class="m-0 p-0" style="display: initial;"></label>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7 text-right">
                                <div class="form-group">
                                    <button class="btn btn-lg btn-primary waves-effect" type="submit">
                                        Tạo mới
                                    </button>
                                    @include('cms.element.button_back',
                                        ['url'=> request()->ref ? request()->ref : action('Cms\AdminRole@index') ])
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer.script')
    @parent

    <script src="{{ asset('cms/js/admin_role.js') }}"></script>

@endsection