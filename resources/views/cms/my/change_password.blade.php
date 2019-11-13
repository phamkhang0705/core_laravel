@extends('cms.layouts.default')

@section('title', 'Thay đổi mật khẩu')

@section('content')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body">
                    @include('cms.element.alert',[])
                    <form method="POST" action="{!! route('cms.my.do_change_password') !!}" class="form-horizontal"
                          enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="password" class="col-sm-3 control-label">Mật khẩu cũ <label class="text-danger">*</label></label>

                                            <div class="col-sm-9 ">
                                                <div class="form-line">
                                                    <input type="password" autocomplete="off" class="form-control" name="old_pass"
                                                           value="{{ old('old_pass') }}" required maxlength="30">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-sm-3 control-label">Mật khẩu mới <label class="text-danger">*</label></label>

                                            <div class="col-sm-9">
                                                <div class="form-line">
                                                    <input type="password" autocomplete="off" class="form-control" name="new_pass"
                                                           value="{{ old('new_pass') }}" required maxlength="30">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-sm-3 control-label">Mật khẩu nhập lại <label class="text-danger">*</label></label>

                                            <div class="col-sm-9">
                                                <div class="form-line">
                                                    <input type="password" autocomplete="off" class="form-control" name="re_new_pass"
                                                           value="{{ old('re_new_pass') }}" required maxlength="30">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password" class="col-sm-3 control-label"></label>

                                            <div class="col-sm-9">

                                                <button type="submit" class="btn btn-lg btn-primary waves-effect">
                                                    Thay đổi mật khẩu
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop