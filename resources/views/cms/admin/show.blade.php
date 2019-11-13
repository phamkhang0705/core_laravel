@extends('cms.layouts.default')

@section('title', 'Chi tiết quản trị viên '.$user->username)

@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                <div class="card">
                    <div class="body table-responsive" style="padding-bottom: 150px;">
                        <table class="table table-bordered">

                            <tbody>

                            <tr>
                                <td class="col-sm-2">
                                    <label>Tên người dùng</label>
                                </td>
                                <td>{!! $user->name !!}</td>
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
                                    <label>Nhóm</label>
                                </td>
                                <td>{!! $user->admin_group_id !!}</td>
                            </tr>

                            <tr>
                                <td>
                                    <label>Trạng thái</label>
                                </td>
                                <td>
                                    @if($user->active == 1)
                                        <span class="text-success">Hoạt động</span>
                                    @else
                                        <span class="text-warning">Không hoạt đôngj</span>
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

