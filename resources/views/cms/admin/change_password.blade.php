@extends('backend.layout.default')

@section('title', 'Chi tiết quản trị viên '.$user->username)

@section('content')


    <div class="wrapper wrapper-content">
        <div class="col-lg-8">


                <input name="_method" type="hidden" value="PATCH">

                {{csrf_field()}}

                <div class="row">
                    <div class="tabs-container">
                        @include('backend.element.alert',[])
                        <form method="POST" action="/backend/admin/do_change_password" class="form-horizontal"
                              enctype="multipart/form-data">
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="password" class="col-sm-2 control-label">Mật khẩu cũ</label>

                                            <div class="col-sm-10">
                                                <input type="password" autocomplete="off" class="form-control" name="old_pass"
                                                       value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-sm-2 control-label">Mật khẩu mới</label>

                                            <div class="col-sm-10">
                                                <input type="password" autocomplete="off" class="form-control" name="new_pass"
                                                       value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-sm-2 control-label">Mật khẩu nhập lại</label>

                                            <div class="col-sm-10">
                                                <input type="password" autocomplete="off" class="form-control" name="re_new_pass"
                                                       value="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password" class="col-sm-2 control-label"></label>

                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-sm btn-primary">Thay đổi mật khẩu</button>
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