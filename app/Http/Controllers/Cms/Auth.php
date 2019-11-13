<?php

namespace App\Http\Controllers\Cms;

use App\Common\Utility;
use App\Common\Response;
use App\Common\HttpStatusCode;
use App\Common\SendEmailApi;

use App\Http\Controllers\Controller;
use App\Models\Cms\Admin;
use App\Models\Helper\Permission;
use Illuminate\Http\Request;

class Auth extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function loginForm()
    {
        return view('cms.auth.login', compact('breadcrumb'));                
    }

    public function login(Request $request)
    {

        if (!$request->isMethod('post')) {
            return false;
        }

        $username = $request->get('name', '');
        $password = $request->get('password', '');

        if (empty($username) || empty($password)) {
            return false;
        }
        try {
            $admin = Admin::query()
                ->where('name', $username)
                ->first();
        } catch (\Exception $e) {
            return redirect()->route('cms.login_form')->withErrors('Tài khoản không tồn tại');
        }

        if (isset($admin) && $admin instanceof Admin
            && $admin->status == 'ACTIVE' && md5($password) == $admin->password) {
            auth()->login($admin);
            return redirect()->action('Cms\Dashboard@index');
        } else if (isset($admin) && $admin instanceof Admin && $admin->status == 'INACTIVE') {
            return redirect()->route('cms.login_form')->withErrors('Tài khoản đã bị khóa');
        } else if (isset($admin) && $admin instanceof Admin && $admin->status == 'ACTIVE' && md5($password) != $admin->password) {
            return redirect()->route('cms.login_form')->withErrors('Mật khẩu không chính xác');
        }
        return redirect()->route('cms.login_form')->withErrors('Tài khoản không tồn tại');
    }

    public function forgetPassword(Request $request)
    {
        $name = trim($request->name);
        if (is_null($name) || empty($name)) {
            return Response::error(HttpStatusCode::HTTP_NOT_ACCEPTABLE, 'Tham số không hợp lệ');
        }

        $admin = Admin::query()->where('name', $name)->first();
        if (isset($admin) && $admin instanceof Admin
            && $admin->status == 'ACTIVE') {
            $password = Utility::generateRandomString(6);
            $admin->password = md5($password);

            $insert = $admin->save();
            // $insert = 1; // TODO test
            // return var_dump($insert);
            if ($insert) {
                if (is_null($admin->email) || empty($admin->email)) {
                    return Response::error(HttpStatusCode::HTTP_NOT_FOUND, 'Đổi mật khẩu thành công, nhưng không có email để gửi');
                }
                // Send password to user
                $html = view('cms.admin.send_password', [
                    'userName' => $admin->name,
                    'url' => request()->root(),
                    'password' => $password
                ])->render();
                // env('SEND_EMAIL_HOST', '');
                $dataForSend = new \stdClass();
                $dataForSend->toEmail = $admin->email;
                // $dataForSend->toEmail = 'kindaichikt@gmail.com'; // TODO test
                $dataForSend->toUserName = $admin->fullname;
                $dataForSend->emailTitle = 'Mật khẩu đăng nhập hệ thống';
                $dataForSend->emailContent = $html;
                $dataForSend->images = [];
                SendEmailApi::postApi(env('SEND_EMAIL_HOST', ''), json_encode($dataForSend));

                return Response::success('Đặt lại mật khẩu thành công');
                // $this::log($user->id, \App\Common\ContentAction::ADD, 'Tạo mới quản trị viên', $user);
            } else {
                return Response::error(HttpStatusCode::HTTP_NOT_FOUND, 'Đặt lại mật khẩu không thành công');
            }
        } else if (isset($admin) && $admin instanceof Admin && $admin->status == 'INACTIVE') {
            return Response::error(HttpStatusCode::HTTP_NOT_FOUND, 'Tài khoản đã bị khóa');
        }
        return Response::error(HttpStatusCode::HTTP_NOT_FOUND, 'Tài khoản không tồn tại');
    }

    public function logout()
    {
        \Illuminate\Support\Facades\Auth::logout();
        return redirect()->back();
    }
}