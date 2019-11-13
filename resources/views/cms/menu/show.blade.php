@extends('cms.layouts.default')

@section('title', "CmsMenu")

@section('content')
    <style type="text/css">
        .col-lg-12 {
            padding-left: 0;
        }
    </style>
       <div class="row ">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">


                    <div class="body clearfix">
        <div class="col-lg-12 clearfix">
            <div class="ibox-content">
                <div class="input-group">
                    <a class="btn btn-primary btn-sm" href="{!! route('cms.menu.index') !!}">
                        <i class="fa fa-database"></i>
                        Danh sách
                    </a>
                </div>
                <br/>
                @if(isset($data))
                <table class="table table-striped table-bordered detail-view">
                    <tbody>
                    <tr>
                        <th>Tiêu đề</th>
                        <td>{!! $data->name !!}</td>
                    </tr>
                    <tr>
                        <th>Miêu tả</th>
                        <td>{!! $data->description !!}</td>
                    </tr>
                    <tr>
                        <th>Đường dẫn</th>
                        <td>{!! $data->url !!}</td>
                    </tr>
                    <tr>
                        <th>Trạng thái</th>
                        <td>
                            @if($data->display == 1)
                                <i class="fa fa-check text-navy"></i>
                            @else
                                <i class="fa fa-dot-circle-o text-red"></i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Danh mục cha</th>
                        <td>
                            {!! $data->parent_id == 0?'Không có':$data->parent_id !!}
                        </td>
                    </tr>
                    <tr>
                        <th>Icon</th>
                        <td>
                            <i class="{!! $data->icon !!}"></i>
                            {!! $data->icon !!}
                        </td>
                    </tr>
                    <tr>
                        <th>Ngày tạo</th>
                        <td>{!! $data->created_by_name.' lúc '.$data->created_time !!}</td>
                    </tr>
                    <tr>
                        <th>Ngày cập nhật</th>
                        <td>{!! $data->updated_by_name.' lúc '.$data->updated_time !!}</td>
                    </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div> 
</div> 
</div> 
@stop