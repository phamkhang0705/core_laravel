<?php

namespace App\Http\Controllers\Cms;

use App\Common\HttpStatusCode;
use App\Common\Response;
use App\Common\Utility;
use App\Common\SendEmailApi;
use App\Models\Cms\AdminGroup;
use App\Models\Deal365\AdminMerchant;
use Illuminate\Http\Request;

class Admin extends Base
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $fullUrl = request()->root();
        // var_dump($fullUrl);
        // exit;

        $breadcrumb = [
            [
                'title' => 'Quản trị viên',
                'url' => route('cms.admin.index'),
                'active' => false
            ],
            [
                'title' => 'Quản lý người dùng',
                'url' => '#',
                'active' => true
            ]
        ];

        $limit = 25;
        $query = \App\Models\Cms\Admin::query()
            ->leftJoin('admin_group', 'admin.admin_group_id', '=', 'admin_group.id')
            ->orderBy('admin.created_time', 'desc')
            ->select('admin.*', 'admin_group.name as group_name');

        $admin_group = request()->get('admin_group', '');
        if (!empty($admin_group) && $admin_group != 'all') {
            $query->where('admin_group.name', '=', $admin_group);
        }
        $status = request()->get('status', '');
        if (!empty($status) && $status != 'all') {
            $query->where('admin.status', '=', $status);
        }

        $name = request()->get('name', '');
        if (!empty($name)) {
            $query->where('admin.name', 'like', "%$name%");
        }

        $fullname = request()->get('fullname', '');
        if (!empty($fullname)) {
            $query->where('admin.fullname', 'like', "%$fullname%");
        }

        $email = request()->get('email', '');
        if (!empty($email)) {
            $query->where('admin.email', 'like', "%$email%");
        }

        $users = $query->paginate($limit);

        $admin_groups = AdminGroup::query()->orderBy('name')->get();
        return view('cms.admin.index', compact('users', 'breadcrumb', 'admin_groups', 'limit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumb = [
            [
                'title' => 'Quản trị viên',
                'url' => route('cms.admin.index'),
                'active' => false
            ],
            [
                'title' => 'Tạo mới người dùng',
                'url' => '#',
                'active' => true
            ]
        ];

        $groups = \App\Models\Cms\AdminGroup::query()->get();
        $merchants = AdminMerchant::query()->get();

        return view('cms.admin.create', compact(
            'breadcrumb',
            'groups', 'merchants'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * admin/1 , admin/1/edit
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $logged = auth()->user();
    $__request = $request->all();

    $name = $__request["name"];
    $existName = \App\Models\Cms\Admin::query()->where('name', $name)->first();
    if(isset($existName) && !empty($existName)) {
        return back()->withErrors('Tài khoản này đã tồn tại.')->withInput();
    }

    $email = $__request["email"];
    $existEmail = \App\Models\Cms\Admin::query()->where('email', $email)->first();
    if(isset($existEmail) && !empty($existEmail)) {
        return back()->withErrors('Tài khoản này đã tồn tại.')->withInput();
    }

    $groupId = intval($__request["admin_group_id"]);
    if ($groupId < 1) {
        return back()->withErrors('Bạn cần chọn nhóm Quản trị')->withInput();
    }

    $group = AdminGroup::query()->where('id', $groupId)->first();
    if(!$group instanceof AdminGroup){
        return back()->withErrors('Bạn cần chọn nhóm Quản trị')->withInput();
    }

    $merchant_id = $request->get('merchant_id');

    if($group->code == AdminGroup::CODE_MERCHANT){
        $merchant = AdminMerchant::query()->where('id', $merchant_id)->first();
        if(!$merchant instanceof AdminMerchant){
            return back()->withErrors('Bạn phải chọn merchant')->withInput();
        }
    }

    $user = new \App\Models\Cms\Admin();

    $user->name = $__request["name"];
//    $password = Utility::generateRandomString(6);
    $password = $request->get('password');
    if(empty($password)){
        $password = "123456";
    }

    $user->password = md5($password);
    // if (!empty($__request["password"])) {
    //     $user->password = md5($__request["password"]);
    // }
    $user->fullname = $__request["fullname"];
    $user->email = $__request["email"];
    $user->phone = $__request["phone"];
    $user->address = !empty($__request["address"]) ? $__request["address"] : '';
    $user->admin_group_id = $groupId;
    $user->status = isset($__request["status"]) ? 'ACTIVE' : 'INACTIVE';

    $user->created_by_id = $logged->id;
    $user->created_by_name = $logged->name;
    $user->updated_by_id = $logged->id;
    $user->updated_by_name = $logged->name;
    if($group->code == AdminGroup::CODE_MERCHANT){
        $user->merchant_id = $merchant_id;
    }

    $user->created_time = date('Y-m-d H:i:s', time());

    $insert = $user->save();
    // $insert = 1; // TODO test

    if ($insert) {
        // Send password to user
        $html = view('cms.admin.send_password', [
            'userName' => $user->name,
            'url' => request()->root(),
            'password' => $password
        ])->render();
        // env('SEND_EMAIL_HOST', '');
        $dataForSend = new \stdClass();
        $dataForSend->toEmail = $user->email;
        // $dataForSend->toEmail = 'kindaichikt@gmail.com'; // TODO test
        $dataForSend->toUserName = $user->fullname;
        $dataForSend->emailTitle = 'Mật khẩu đăng nhập hệ thống';
        $dataForSend->emailContent = $html;
        $dataForSend->images = [];
//        SendEmailApi::postApi(env('SEND_EMAIL_HOST', ''), json_encode($dataForSend));

        $this::log($user->id, \App\Common\ContentAction::ADD, 'Tạo mới quản trị viên', $user);
        return redirect()->route('cms.admin.index')->with('success', 'Thêm quản trị thành công');
    }

    return redirect()->route('cms.admin.index')->with('Có lỗi xảy ra!');
}

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \App\Models\Cms\Admin::findOrFail($id);

        $breadcrumb = [
            [
                'title' => 'Quản trị viên',
                'url' => route('cms.admin.index'),
                'active' => false
            ],
            [
                'title' => 'Thông tin nhân viên ' . $user->name,
                'url' => '#',
                'active' => true
            ]
        ];

        return view('cms.admin.show', compact(
            'user',
            'breadcrumb'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = \App\Models\Cms\Admin::findOrFail($id);

        $breadcrumb = [
            [
                'title' => 'Quản trị viên',
                'url' => route('cms.admin.index'),
                'active' => false
            ],
            [
                'title' => 'Cập nhật tài khoản người dùng',
                'url' => '#',
                'active' => true
            ]
        ];

        $group_id = $user->merchant_id;
        $group = null;
        if(isset($group_id)){
            $group = AdminGroup::query()->where('id', $group_id)->first();
        }

        $merchants = AdminMerchant::query()->get();
        return view('cms.admin.edit', compact(
            'user',
            'group', 'merchants',
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
        $logged = auth()->user();

        $password = isset($__request["password"]) ? $__request["password"] : '';
        $user = \App\Models\Cms\Admin::findOrFail($id);
        if ($password != '') {
            $user->password = md5($password);
        }

        $groupId = intval($__request["admin_group_id"]);
        if ($groupId < 1) {
            return redirect()->route('cms.admin.index')->withErrors('Bạn cần chọn nhóm Quản trị');
        }

        $group = AdminGroup::query()->where('id', $groupId)->first();
        if(!$group instanceof AdminGroup){
            return redirect()->route('cms.admin.index')->withErrors('Bạn cần chọn nhóm Quản trị');
        }

        $merchant_id = $request->get('merchant_id');

        if($group->code == AdminGroup::CODE_MERCHANT){
            $merchant = AdminMerchant::query()->where('id', $merchant_id)->first();
            if(!$merchant instanceof AdminMerchant){
                return redirect()->route('cms.admin.index')->withErrors('Bạn phải chọn merchant');
            }
        }

        $user->fullname = $__request["fullname"];
        //$user->email = $__request["email"];
        $user->phone = $__request["phone"];
        //$user->position = $__request["position"];
        //$user->address = $__request["address"];
        $user->status = isset($__request["status"]) ? 'ACTIVE' : 'INACTIVE';
        $user->admin_group_id = intval($__request["admin_group_id"]);
        //$user->sale_id = intval($__request["sale_id"]);

        if($group->code == AdminGroup::CODE_MERCHANT){
            $user->merchant_id = $merchant_id;
        }

        $user->updated_by_id = $logged->id;
        $user->updated_by_name = $logged->name;

        $update = $user->save();

        if ($update) {
            $this::log($user->id, \App\Common\ContentAction::EDIT, 'Cập nhật quản trị viên', $user);
            return redirect()->route('cms.admin.index')->with('success', 'Cập nhật thành công');
        }

        return redirect()->route('cms.admin.index')->withErrors('Có lỗi xảy ra!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function change_password()
    {

        //
        $user = auth()->user();
        $breadcrumb = [
            [
                'title' => 'Cá nhân',
                'url' => route('cms.my.show'),
                'active' => false
            ],
            [
                'title' => 'Đổi mật khẩu',
                'url' => '#',
                'active' => true
            ]
        ];
        return view('backend.admin.change_password', compact(
            'user',
            'breadcrumb'
        ));
    }

    public function do_change_password()
    {
        $old_pass = request()->get('old_pass');
        $new_pass = request()->get('new_pass');
        $re_new_pass = request()->get('re_new_pass');
        if ($old_pass == '' || $new_pass == '' || $re_new_pass == '') {
            return redirect(url('backend/admin/change_password'))
                ->withErrors('Yêu cầu nhập đầy đủ thông tin!');
        }
        if (strlen($new_pass) < 6 || $new_pass != $re_new_pass) {
            return redirect(url('backend/admin/change_password'))
                ->withErrors('Mật khẩu mới ít nhất 6 ký tự');
        }

        if ($new_pass != $re_new_pass) {
            return redirect(url('backend/admin/change_password'))
                ->withErrors('Mật khẩu nhập lại không đúng');
        }

        $user = auth()->user();
        $odm = \App\Models\Cms\Admin::query()->where('id', $user->id)->first();
        if (md5($old_pass) != $odm->password) {
            return redirect(url('backend/admin/change_password'))
                ->withErrors('Mật khẩu nhập lại không đúng');
        }

        $data = [
            'password' => md5($new_pass)
        ];
        $odm->update($data);
        $this::log($user->id, \App\Common\ContentAction::EDIT, 'Thay đổi mật khẩu', $data);
        //
        return redirect(url('backend/admin/change_password'))->with('success', 'Cập nhật thành công');
    }

    public function changeStatus(Request $request)
    {
        if (empty($request->id) || empty($request->status)) {
            return Response::error(HttpStatusCode::HTTP_NOT_ACCEPTABLE, 'Tham số không hợp lệ');
        }

        $updated =\App\Models\Cms\Admin::query()->where('id', $request->id)
            ->update([
                'status' => $request->status
            ]);

        if ($updated) {
            $this::log($request->id, \App\Common\ContentAction::EDIT, 'Thay đổi trạng thái', ["id"=>$request->id,'status' => $request->status]);
            return Response::success('Cập nhật thành công');
        }

        return Response::error(HttpStatusCode::HTTP_NOT_ACCEPTABLE, 'Có lỗi xảy ra');
    }

    public function log($id, $action, $desc, $data) {
        $user = auth()->user();
        \App\Models\Cms\AdminActivity::addData($user, $action, $id, \App\Common\Content::TYPE_ADMIN,  $desc, json_encode($data));
    }


}