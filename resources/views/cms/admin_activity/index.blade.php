@extends('cms.layouts.default')

@section('title', 'Admin action')

@section('content')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="card" style="margin-bottom: 15px;">
                <div class="body">
                    <form id='form-filter' action="{{route('cms.admin_activity.index')}}" method="get">
                        <div class="row clearfix">
                            <div class="col-sm-1 col-xs-12 m-b-0"></div>
                            <div class="col-sm-2 col-xs-12 m-b-0">
                                <div class="form-group m-0">
                                    <label>Từ ngày</label>
                                    <div class="form-line">
                                        <input type="text" class="_datetime_ form-control" name="from_date"
                                               placeholder="Hiển thị từ" value="{{request('from_date')== "" ? (date
                                                ('Y-m-d').' 00:00') : request('from_date') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-12 m-b-0">
                                <div class="form-group m-0">
                                    <label>Tới ngày</label>
                                    <div class="form-line">
                                        <input type="text" class="_datetime_ form-control" name="to_date"
                                               placeholder="Hiển thị từ" value="{{ request('to_date')== "" ? (date
                                                ('Y-m-d').' 23:59') : request('to_date') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-12 m-b-0">
                                <div class="form-group m-0">
                                    <label>Tài khoản</label>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="keyword"
                                               placeholder="Tên đăng nhập, tên người dùng"
                                               value="{{request('keyword')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2 col-xs-12 m-b-0">
                                <div class="form-group m-0">
                                    <label>Hành động</label>
                                    <div class="form-line">
                                        <select name="action" class="form-control " onchange="$('#form-filter')
                                        .submit();">
                                            <option value="">Tất cả</option>
                                            <?php $contentAction = \App\Common\ContentAction::getContentAction(); ?>
                                            @foreach($contentAction as $key=>$item)
                                                <option value="{{ $key }}" {{request('action') == $key ?
                                                'selected':''}} >{{ $item}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2 col-xs-12 m-b-0">
                                <div class="form-group m-0">
                                    <label>Nội dung</label>
                                    <div class="form-line">
                                        <select name="type" class="form-control "
                                                onchange="$('#form-filter').submit();">
                                            <option value="">Tất cả</option>

                                            <?php $contentType = \App\Common\Content::getContent(); ?>
                                            @foreach($contentType as $key=>$item)
                                                <option value="{{ $key }}" {{request('type') == $key ? 'selected':''}} >{{
                                        $item}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 m-b-0">
                                <label for=""></label>
                                <button type="submit" class="btn btn-primary btn-lg waves-effect btn-block">
                                    Tìm kiếm
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="header">
                    <h2>
                        DANH SÁCH
                    </h2>
                </div>
                <div class="body table-responsive" style="padding-bottom: 150px;">

                    @include('cms.element.alert')
                    @include('cms.element.paginate')
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 20px" class="text-center">STT</th>
                            <th style="width: 150px" class="text-center">Thời gian</th>
                            <th style="width: 150px" class="text-center">Tài khoản</th>
                            <th style="width: 150px" class="text-center">Họ và tên</th>
                            <th style="width: 150px" class="text-center">Hàng động</th>
                            <th style="width: 150px" class="text-center">Nội dung</th>
                            <th style="width: 220px" class="text-center">Nội dung thao tác</th>
                            <th style="width: 300px" class="text-center">Data</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0;?>
                        @if(count($datas)>0)

                            @foreach($datas as $item)
                                <?php $i++;?>
                                <tr>
                                    <td class="text-center"> {!! App\Common\Utility::pageRowIndex($datas, $i) !!} </td>
                                    <td>  {{$item->getCreatedTime()}}</td>
                                    <td>{{ $item->admin_name }}</td>
                                    <td>{{ \App\Models\Cms\Admin::findOrFail($item->admin_id)->fullname }}</td>
                                    <td>{{ \App\Common\ContentAction::getContentActionName($item->action)   }}</td>
                                    <td>{{ \App\Common\Content::getContentName($item->content_type) }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td class="wrapword">{{ $item->data }}</td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">Không có dữ liệu</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                    @include('cms.element.paginate')
                </div>
            </div>
        </div>
    </div>

@endsection 