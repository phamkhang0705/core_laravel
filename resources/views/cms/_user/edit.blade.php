@extends('cms.layouts.default') 
@section('title', "Chỉnh sửa thông tin user") 
@section('content')

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="card">
            <div class="body clearfix">

                <form id='form-user-edit' action="{{action('Cms\User@update', ['id'=>$data->global_user_id])}}" method="POST" enctype="multipart/form-data">

                    <input name="_method" type="hidden" value="PATCH">
    @include('cms.element.alert') {{ csrf_field() }}

                    <input type="hidden" name="global_user_id" value="{{$data->global_user_id}}">


                    <div class="form-group clearfix">
                        <div class="col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label class="">Tên người dùng</label>
                        </div>
                        <div class="col-md-10 col-sm-8 col-xs-7">
                            <div class="form-line">
                                <input type="text" class="form-control" name="nick_name" placeholder="Tên người dùng" value="{{ old('nick_name', $data->nick_name) }}"
                                disabled
                                />
                            </div>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label class=" ">Số điện thoại</label>
                        </div>
                        <div class="col-md-10 col-sm-8 col-xs-7">
                            <div class="form-line">
                                <input type="text" class="form-control" name="phone" placeholder="Số điện thoại" value="{{old('phone', $data->phone)}}"
                                disabled />
                            </div>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label class="">Email</label>
                        </div>
                        <div class="col-md-10 col-sm-8 col-xs-7">
                            <div class="form-line">
                                <input type="text" class="form-control" name="email" placeholder="Email" value="{{old('email', $data->email) }}" 
                                disabled />
                            </div>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label class="">Ngày sinh</label>
                        </div>
                        <div class="col-md-10 col-sm-8 col-xs-7">
                            <div class="form-line">
                                <input type="text" class="_date1_ form-control" name="date_of_birth" placeholder="Ngày sinh" value="{{ old('date_of_birth', App\Common\Utility::displayDatetime($data->date_of_birth, 'd/m/Y') ) }}"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <div class="col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label class="">Giới tính</label>
                        </div>
                        <div class="col-md-10 col-sm-8 col-xs-7">
                            <div class="demo-radio-button">
                                <input name="gender" type="radio" id="gender1" value="1" 
                                    {{ old( 'gender', $data->gender) == '1' ? 'checked' : '' }} />
                                <label for="gender1">Nam</label>
                                <input name="gender" type="radio" id="gender2" value="2" 
                                    {{ old( 'gender', $data->gender)== '2' ? 'checked' : '' }}/>
                                <label for="gender2">Nữ</label>
                                {{-- <input name="gender" type="radio" id="gender0" value="0" 
                                    {{ old( 'gender', $data->gender) == 0 ? 'checked' : '' }}/>
                                <label for="gender0">Không xác định</label> --}}
                            </div>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <div class="col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label class="">Facebook</label>
                        </div>
                        <div class="col-md-10 col-sm-8 col-xs-7">
                            <div class="form-line">
                                <input type="text" class="form-control" name="facebook_idx" placeholder="Facebook" value="{{old('facebook_id', 'https://facebook.com/'.$data->facebook_id)}}"
                                disabled
                                />
                            </div>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <div class="col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label class="">Nhóm khách hàng</label>
                        </div>
                        <div class="col-md-10 col-sm-8 col-xs-7">
                            @foreach($groups as $g)
                            <a href='/group_user/{{$g->group_id }}' target="_blank" >
                                {{ $g->desciption }}
                            </a> <br/> @endforeach
                        </div>
                    </div>
 
                    <div class="form-group clearfix">
                        <div class="col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label class="">Trạng thái</label>
                        </div>
                        <div class="col-md-10 col-sm-8 col-xs-7">
                            <div class="demo-radio-button">
                                <input name="status" type="radio" id="status_active" value="0" {{ old( 'status', $data->status())
                                == '0' ? 'checked' : '' }} />
                                <label for="status_active">Hoạt động</label>
                                <input name="status" type="radio" id="status_look" value="1" {{ old( 'status', $data->status())
                                != '0' ? 'checked' : '' }}/>
                                <label for="status_look">Không hoạt động</label>
                            </div>
                        </div>
                    </div> 

                    <div class="pull-right clearfix">
                        <a href="{{ $back_url }}" class="btn  bg-red btn-lg waves-effect text-upper">Hủy</a>                        &nbsp;
                        <button type="sunmit" class="btn bg-red btn-lg waves-effect text-upper">Lưu</button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

</div>
</div>














@stop