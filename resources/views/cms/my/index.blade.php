@extends('cms.layouts.default')

@section('title', 'Cá nhân')

@section('content')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">

                <div class="body table-responsive">

                    @include('cms.element.alert')
                    <!-- <a class="btn btn-warning btn-md waves-effect" href="#">
                        Thay đổi thông tin
                    </a> -->

                    <table class="table table-striped" style="margin-top: 10px">
                        <tr>
                            <td class="font-bold col-md-4">Tên đăng nhập</td>
                            <td>{{$data->name}}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">Tên đầy đủ</td>
                            <td>{{$data->fullname}}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">Email</td>
                            <td>{{$data->email}}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">Phone</td>
                            <td>{{$data->phone}}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">Ngày tạo</td>
                            <td>{{$data->created_time}}</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>



@endsection

@section('footer.script')
    @parent

@endsection