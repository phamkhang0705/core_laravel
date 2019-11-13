@extends('cms.layouts.default')

@section('title', "Tạo mới người dùng")

@section('content')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body">
                    <form id="create-new" method="POST" autocomplete="off" action="{!! route('cms.admin.store') !!}" class="form-horizontal" enctype="multipart/form-data">
                    @include('cms.element.alert')
                        <input name="_method" type="hidden" value="POST">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="">
                                <div class="form-group">
                                    <label for="username" class="col-sm-2 control-label">Tên đăng nhập <label class="text-danger">*</label></label>

                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input id="{!! time() !!}" type="text" class="form-control" autocomplete="false"
                                                placeholder="Tên đăng nhập" value="{{ old('name', '') }}" name="name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group">
                                    <label for="fullname" class="col-sm-2 control-label">Họ tên <label class="text-danger">*</label></label>

                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="fullname" name="fullname"
                                                placeholder="Họ và tên" value="{{ old('fullname', '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Email <label class="text-danger">*</label></label>

                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="email" name="email"
                                                   placeholder="email"
                                                   value="{{ old('email', '') }}"
                                                   >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">Mật khẩu<label class="text-danger">*</label></label>

                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="password" name="password"
                                                   placeholder="Mật khẩu"
                                                   value="{{ old('password', '') }}"
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group">
                                    <label for="phone" class="col-sm-2 control-label">Số điện thoại</label>

                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                   value="{{ old('phone', '') }}" placeholder="Ex: 0987654321"
                                                   >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group">
                                    <label for="fullname" class="col-sm-2 control-label">Nhóm quản trị <label class="text-danger">*</label></label>

                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <select class="form-control" name="admin_group_id">
                                                <option value="0">Chọn</option>
                                                <?php
                                                    if(isset($groups) && !empty($groups)) {
                                                        foreach ($groups as $group) {
                                                ?>
                                                    <option data-code="{{$group->code}}" value="{!! $group->id !!}"
                                                    @if(old('admin_group_id', '') == $group->id) selected @endif
                                                    >{!! $group->name !!}</option>
                                                    <?php
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="" style="display: none" id="view_select_merchant">
                                <div class="form-group">
                                    <label for="fullname" class="col-sm-2 control-label">Chọn merchant <label class="text-danger">*</label></label>

                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <select class="form-control" name="merchant_id" data-live-search="true">
                                                <option value="0">Chọn</option>
                                                <?php
                                                if(isset($merchants) && !empty($merchants)) {
                                                foreach ($merchants as $merchant) {
                                                ?>
                                                <option value="{!! $merchant->id !!}"
                                                        @if(old('merchant_id', '') == $merchant->id) selected @endif
                                                >{!! $merchant->name !!}</option>
                                                <?php
                                                }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Trạng thái</label>

                                    <div class="col-sm-10">
                                        <input type="checkbox" name="status" id="basic_checkbox_1" class="filled-in">
                                        <label for="basic_checkbox_1" class="m-0 p-0" style="display: initial;"></label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12 text-right">
                                <div class="form-group">
                                        <button class="btn btn-primary btn-lg waves-effect create-new" type="submit">
                                            THÊM MỚI
                                        </button>
                                        @include('cms.element.button_back', ['url'=> request()->ref ? request()->ref : action('Cms\Admin@index') ])
                                </div>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

@stop
@section('footer.script')
    @parent
    <script type="text/javascript">
        $(document).ready(function() {
            $("input[name=name]").attr("autocomplete", "off");
        });
    </script>
    <script src="{{ asset('cms/js/admin.js') }}"></script>
@endsection