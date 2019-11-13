@extends('backend.layout.default')

@section('title', 'Chi tiết quản trị viên '.$user->username)

@section('content')

    <div class="wrapper wrapper-content">

        <div class="col-lg-8 no-padding">
            <div class="ibox float-e-margins">
                <a class="btn btn-sm btn-primary" href="{!! action('Backend\Admin@change_password') !!}">Đổi mật khẩu</a>
                <div class="ibox-content">
                    <table class="table table-bordered">

                        <tbody>

                        <tr>
                            <td class="col-sm-3">
                                <label>Tên người dùng</label>
                            </td>
                            <td>{!! $user->username !!}</td>
                        </tr>
                        <tr>
                            <td>
                                <label>Tên đầy đủ</label>
                            </td>
                            <td>{!! $user->fullname !!}</td>
                        </tr>
                        <tr>
                            <td>
                                <label>Email</label>
                            </td>
                            <td>{!! $user->email !!}</td>
                        </tr>
                        <tr>
                            <td>
                                <label>Phone</label>
                            </td>
                            <td>{!! $user->phone !!}</td>
                        </tr>

                        <tr>
                            <td>
                                <label>Trạng thái</label>
                            </td>
                            <td>
                                @if($user->active == 1)
                                    <span class="text-success">Hoạt động</span>
                                @else
                                    <span class="text-warning">Không hoạt động</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Ngày tham gia</label>
                            </td>
                            <td>
                                {!! \App\Common\Utility::displayDatetime($user->created_time) !!}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@stop

