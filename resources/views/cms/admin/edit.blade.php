@extends('cms.layouts.default')

@section('title', $user->name)

@section('content')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body">

                    <form method="POST" id="update_data" autocomplete="off" action="/admin/{{$user->id}}" class="form-horizontal"
                          enctype="multipart/form-data">

                        <input name="_method" type="hidden" value="PATCH">

                        {{csrf_field()}}

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">

                                        <div class="row">
                                            <div class="">
                                                <div class="form-group">
                                                    <label for="username" class="col-sm-3 control-label">Tên đăng
                                                        nhập (*)</label>

                                                    <div class="col-sm-9">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" id="username"
                                                                   name="username" value="{{$user->name}}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="form-group">
                                                    <label for="fullname" class="col-sm-3 control-label">Họ tên (*)</label>

                                                    <div class="col-sm-9">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" id="fullname"
                                                                   name="fullname" value="{{$user->fullname}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="">
                                                <div class="form-group">
                                                    <label for="email" class="col-sm-3 control-label">Email (*)</label>

                                                    <div class="col-sm-9">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" id="email"
                                                                   name="email"
                                                                   value="{{$user->email}}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="form-group">
                                                    <label for="phone" class="col-sm-3 control-label">Số điện
                                                        thoại</label>

                                                    <div class="col-sm-9">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" id="phone"
                                                                   name="phone"
                                                                   value="{{$user->phone}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="">
                                                <div class="form-group">
                                                    <label for="fullname" class="col-sm-3 control-label">Nhóm quản trị (*)</label>

                                                    <div class="col-sm-9">
                                                        <div class="form-line">
                                                            <select class="form-control" name="admin_group_id">
                                                                <option>Tất cả</option>
                                                                <?php
                                                                $groups = \App\Models\Cms\AdminGroup::query()->get();
                                                                if(isset($groups) && !empty($groups)) {
                                                                foreach ($groups as $group) {
                                                                ?>
                                                                <option @if($group->id == $user->admin_group_id) selected
                                                                        @endif data-code="{{$group->code}}" value="{!! $group->id !!}">{!! $group->name !!}</option>
                                                                <?php
                                                                }
                                                                }
                                                                ?>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="" style="display: @if(isset($group) && $group->code == \App\Models\Cms\AdminGroup::CODE_MERCHANT){{'block'}}@else{{'none'}}@endif" id="view_select_merchant">
                                                <div class="form-group">
                                                    <label for="fullname" class="col-sm-3 control-label">Chọn merchant <label class="text-danger">*</label></label>

                                                    <div class="col-sm-9">
                                                        <div class="form-line">
                                                            <select class="form-control" name="merchant_id" data-live-search="true">
                                                                <option value="0">Chọn</option>
                                                                <?php
                                                                if(isset($merchants) && !empty($merchants)) {
                                                                foreach ($merchants as $merchant) {
                                                                ?>
                                                                <option value="{!! $merchant->id !!}"
                                                                        @if($user->merchant_id == $merchant->id) selected @endif
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
                                                    <label for="status" class="col-sm-3 control-label">Trạng thái</label>

                                                    <div class="col-sm-9">
                                                        <input type="checkbox" @if($user->status == 'ACTIVE') checked @endif
                                                        name="status" id="basic_checkbox_1" class="filled-in">
                                                        <label for="basic_checkbox_1" class="m-0 p-0"
                                                               style="display: initial;"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    <!--
                                        <div class="form-group">
                                            <label for="password" class="col-sm-2 control-label">Mật khẩu</label>

                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="password" autocomplete="off" class="form-control"
                                                           id="password" name="password"
                                                           value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email" class="col-sm-2 control-label">Địa chỉ</label>

                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" id="address" name="address"
                                                           value="{{$user->address}}">
                                                </div>
                                            </div>
                                        </div>
                                        -->

                                       <div class="row">
                                           <div class="col-md-12 text-right">
                                               <div class="form-group">
                                                   <button class="btn btn-primary btn-lg waves-effect update_data" type="submit">
                                                       CẬP NHẬT
                                                   </button>
                                                   @include('cms.element.button_back',
                                                                         ['url'=> request()->ref ? request()->ref :
                                                                          action('Cms\Admin@index') ])
                                               </div>
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
@section('footer.script')
    @parent
    <script type="text/javascript">
        $(document).ready(function() {
            $("input[name=name]").attr("autocomplete", "off");
        });
    </script>
    <script src="{{ asset('cms/js/admin.js') }}"></script>
@endsection