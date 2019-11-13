@extends('cms.layouts.default')

@section('title', "Danh sách nhóm quản trị viên")

@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="card" style="margin-bottom: 15px;">
                <div class="body">
                    <form id='form-filter' action="/admin_group" method="get" class="form-inline">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 m-b-10"></div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 m-b-10">
                                <div class="form-group m-0">
                                    <div class="form-line">
                                        <label for="">Mã nhóm quản trị</label>
                                        <input type="text" class="form-control" name="code"
                                               placeholder="Mã nhóm quản trị" value="{{request('code')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 m-b-10">
                                <div class="form-group m-0">
                                    <div class="form-line">
                                        <label for="">Tên nhóm quản trị</label>
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Tên nhóm quản trị" value="{{request('name')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 m-b-0">
                                <label for=""></label>
                                <button type="submit" class="btn btn-primary btn-lg waves-effect btn-block">
                                    Tìm kiếm
                                </button>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 m-b-0">
                                <label for=""></label>
                                <a href="/admin_group">
                                    <button type="button" class="btn btn-default btn-lg waves-effect btn-block">
                                        Reset
                                    </button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">

                <div class="body table-responsive" style="padding-bottom: 150px;">

                    @include('cms.element.alert')

                    <div>
                        {!! App\Common\Utility::pagePagination($admin_group) !!}
                    </div>

                    <table class="table table-striped table-bordered table-hover  dataTable" id="editable" role="grid"
                           aria-describedby="editable_info">
                        <thead>
                        <tr role="row">
                            <th class="text-center" width="50" style="width: 50px">ID</th>
                            <th width="150">Mã nhóm quản trị</th>
                            <th width="150">Tên nhóm quản trị</th>
                            <th>Cập nhật</th>
                            <th class="text-center" width="150" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = (request()->get('page', 1) - 1) * \App\Common\Utility::LIMIT
                        ?>
                        @foreach($admin_group as $tmp)
                            @if($tmp instanceof \App\Models\Cms\AdminGroup)
                                <?php $i++; ?>
                                <tr class="gradeA @if($i%2==0) odd @else event @endif" role="row">
                                    <td class="text-center">{!! $i !!}</td>
                                    <td>{{ $tmp->code }}</td>
                                    <td>{{ $tmp->name }}</td>
                                    <td>
                                        <a href="{!! App\Models\Cms\AdminHelper::detailLink($tmp->updated_by_id) !!}">{!! $tmp->updated_by_name !!}</a>
                                        {!! \App\Common\Utility::displayDatetime($tmp->updated_time) !!}
                                    </td>
                                    <td class="text-center">
                                        <a class="item-tool" title="Xem thông tin nhóm"
                                           href="{!! route('cms.admin_group.show',['id'=>$tmp->id]) !!}">
                                            <i class="material-icons">visibility</i>
                                        </a>

                                        <a class="item-tool" title="Sửa nhóm"
                                           href="{!! route('cms.admin_group.edit',['id'=>$tmp->id]) !!}">
                                            <i class="material-icons">edit</i>
                                        </a>

                                    <!-- <a class="item-tool" title="Xóa nhóm"
                                           href="{!! route('cms.admin_group.delete',['id'=>$tmp->id]) !!}">
                                            <i class="material-icons">delete</i>
                                        </a> -->

                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>

                    </table>

                    <div>
                        {!! App\Common\Utility::pagePagination($admin_group) !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
    @if(\App\Common\AdminPermission::isAllow("AdminGroup" . '@' . "create"))
        @include('cms.element.button_create', ['url'=>action('Cms\AdminGroup@create'),'tooltip'=>'Thêm mới'])
    @endif
@stop