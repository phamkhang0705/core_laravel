@extends('cms.layouts.default')

@section('title', 'System Log')

@section('content')

<div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="card" style="margin-bottom: 15px;">
                <div class="body">
                    <form id='form-filter' action="{{route('cms.system_log.index')}}" method="get">
                        <div class="row clearfix"> 
                            <div class="col-sm-5 col-xs-12 m-b-0"></div> 
                            <div class="col-sm-2 col-xs-12 m-b-0">
                                <div class="form-group m-0">
                                    <label>Từ ngày</label>
                                    <div class="form-line">
                                        <input type="text" class="_datetime_ form-control" name="from_date"
                                                placeholder="Từ ngày" value="{{request('from_date')== "" ? date('Y-m-d H:i') : request('from_date') }}">
                                    </div>
                                </div>   
                            </div> 
                            <div class="col-sm-2 col-xs-12 m-b-0">
                                <div class="form-group m-0">
                                    <label>Tới ngày</label>
                                    <div class="form-line">
                                        <input type="text" class="_datetime_ form-control" name="to_date"
                                                placeholder="Tới ngày" value="{{ request('to_date')== "" ? date('Y-m-d H:i') : request('to_date') }}">
                                    </div>
                                </div>   
                            </div>
                            <div class="col-sm-2 col-xs-12 m-b-0">
                                <div class="form-group m-0">
                                    <label>Từ khóa</label>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="keyword"
                                               placeholder="Người dùng, hành động ..." value="{{request('keyword')}}">
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
                    <div>
                            {!! App\Common\Utility::pageTopPagination($datas) !!}
                        </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 100px" class="text-center">Thời gian</th>
                            <th style="width: 100px" class="text-center">Tài khoản</th>
                            <th style="width: 120px" class="text-center">Họ và tên</th>
                            <th style="width: 150px" class="text-center">Hành động</th> 
                            <th style="width: 60px" class="text-center">Data</th> 
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0;?>
                        @foreach($datas as $item)
                            <?php $i++;?>
                            <tr> 
                                 <td>  {{$item->getCreatedTime()}}</td> 
                                <td>{{ $item->user_name }}</td>
                                <td>{{ \App\Models\Cms\Admin::findOrFail($item->user_id)->fullname }}</td>
                                <td>{{ $item->action  }}</td> 
                                <td>{{ $item->data  }}</td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div>
                            {!! App\Common\Utility::pagePagination($datas) !!}
                        </div>
                </div>
            </div>
        </div>
    </div>
 
@endsection 