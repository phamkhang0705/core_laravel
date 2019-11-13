<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class My extends Base
{

    public function index() {
        $data = auth()->user();

        $breadcrumb = [
            [
                'title' => 'Thông tin cá nhân',
                'url' => '#',
                'active' => true
            ]
        ];

        return view('cms.my.index', compact(
            'data',
            'breadcrumb'
        ));
    }


    public function show() {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = \App\Models\Admin::findOrFail($id);

        $breadcrumb = [
            [
                'title' => 'Nhân viên',
                'url' => route('cms.my.index'),
                'active' => false
            ],
            [
                'title' => 'Chỉnh sửa thông tin '.$user->name,
                'url' => '#',
                'active' => true
            ]
        ];

        return view('cms.admin.edit', compact(
            'user',
            'breadcrumb'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $__request = $request->all();
        $password = isset($__request["password"])?$__request["password"]:'';
        $user = \App\Models\Cms\Admin::findOrFail($id);
        if($password !=''){
            $user->password = md5($password);
        }
        $user->fullname = $__request["fullname"];

        $user->fullname = $__request["fullname"];
        $user->email = $__request["email"];
        $user->phone = $__request["phone"];
        $user->position = $__request["position"];
        $user->address = $__request["address"];
        $user->status = isset($__request["status"]) ? 'ACTIVE' : 'INACTIVE';
        $user->admin_group_id = $__request["admin_group_id"];
        $update = $user->save();

        if ($update) {
            return redirect('backend/admin')->with('success', 'Cập nhật thành công');
        }

        return redirect('backend/admin')->with('error', 'Có lỗi xảy ra!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {}

    public function changePassword() {

        //
        $user = auth()->user();
        $breadcrumb = [
            [
                'title' => 'Cá nhân',
                'url' => route('cms.my.index'),
                'active' => false
            ],
            [
                'title' => 'Đổi mật khẩu',
                'url' => '#',
                'active' => true
            ]
        ];
        return view('cms.my.change_password', compact(
            'user',
            'breadcrumb'
        ));
    }

    public function doChangePassword() {
        $old_pass = trim(request()->get('old_pass'));
        $new_pass = trim(request()->get('new_pass'));
        $re_new_pass = trim(request()->get('re_new_pass'));

        if ($old_pass == '' || $new_pass == '' || $re_new_pass == '') {
            return redirect(route('cms.my.change_password'))
                ->withErrors('Yêu cầu nhập đầy đủ thông tin!')
                ->withInput();
        }

        if(strlen($new_pass) < 6) {
            return redirect(route('cms.my.change_password'))
                ->withErrors('Mật khẩu mới ít nhất 6 ký tự')
                ->withInput();
        }
        
        if (strcmp($old_pass, $new_pass) == 0) {
            return redirect(route('cms.my.change_password'))
                ->withErrors('Mật khẩu mới phải khác mật khẩu cũ')
                ->withInput();
        }

        if ($new_pass != $re_new_pass) {
            return redirect(route('cms.my.change_password'))
                ->withErrors('Mật khẩu nhập lại không đúng')
                ->withInput();
        }

        $user = auth()->user();
        $odm = \App\Models\Cms\Admin::query()->where('id', $user->id)->first();
        if (md5($old_pass) != $odm->password) {
            return redirect(route('cms.my.change_password'))
                ->withErrors('Mật khẩu cũ không đúng')
                ->withInput();
        }

        $data = [
            'password'=> md5($new_pass)
        ];
        $odm->update($data);
        //
        return redirect(route('cms.my.change_password'))->with('success', 'Cập nhật mật khẩu mới thành công');
    }
}