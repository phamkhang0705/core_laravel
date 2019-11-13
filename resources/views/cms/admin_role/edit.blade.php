@extends('cms.layouts.default')
<?php
$isview = isset($isview) ? $isview : false;
if ($isview == true) {
    $title = 'Xem thông tin: ' . $data->name;
} else {
    $title = 'Sửa thông tin: ' . $data->name;
}
?>

@section('title', 'Sửa thông tin: '.$data->name)

@section('content')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body">
                    <form id="form_update" class="form-horizontal"
                          action="{{action('Cms\AdminRole@update', ['id' => $data->id])}}"
                          method="POST" enctype="multipart/form-data">

                        <input name="_method" type="hidden" value="PATCH">

                        @include('cms.element.alert')

                        {{ csrf_field() }}

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label class="form-label">Mã(*)</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="controller"
                                               placeholder="Nhập mã"
                                               {{ ($isview ) ? 'disabled' : ''  }}  value="{{ old('controller', $data->controller) }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label class="form-label">Tên(*)</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name" placeholder="Nhập tên"
                                               {{ ($isview ) ? 'disabled' : ''  }} value="{{ old('name', $data->name) }}"/>
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
                                               placeholder="Nhập sắp xếp"
                                               {{ ($isview ) ? 'disabled' : ''  }}  value="{{ old('order', $data->order) }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Trạng thái hoạt động</label>
                            <div class="col-sm-10">
                                <input type="checkbox"
                                       {{ old('status', $data->status) == 'ENABLE'?'checked':''}} name="status"
                                       {{ ($isview ) ? 'disabled' : ''  }}
                                       value="ENABLE" id="basic_checkbox_1" class="filled-in">
                                <label for="basic_checkbox_1" class="m-0 p-0" style="display: initial;"></label>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7 text-right">
                                <div class="form-group">
                                    @if( $isview == false)
                                    <button class="btn btn-lg btn-primary waves-effect" type="submit">
                                        Cập nhật
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                    </button>
                                    @endif
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