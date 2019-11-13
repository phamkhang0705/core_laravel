<?php

namespace App\Http\Controllers\Cms;

use App\Common\Adapter\DB;
use App\Common\HttpStatusCode;
use App\Common\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \App\Models\Cms\AdminRole as AdminRoleModel;
use App\Common\Utility;

class AdminRole extends Base
{
    const PAGE = "chức năng";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumb = [
            [
                'title' => 'Quản lý '.$this::PAGE,
                'url' => '#',
                'active' => true
            ]
        ];

        $data = AdminRoleModel::query();

        $name = $request->get('name');
        if (!empty($name)) {
            $data->where('name', 'like', "%{$name}%");
        }

        $code = $request->get('code');
        if (!empty($code)) {
            $data->where('controller', 'like', "%{$code}%");
        }

        $status = $request->get('status', '');
        if ($status != '') {
            $data->where('status', $status);
        }

        $data = $data->orderBy('order', 'asc')
            ->paginate(Utility::LIMIT);

        return view('cms.admin_role.index', compact('data', 'breadcrumb'));
    }

    public function show($id)
    {
        $data = AdminRoleModel::query()->where('id', $id)->first();

        if (!$data instanceof AdminRoleModel) {
            abort(404);
        }

        $breadcrumb = [
            [
                'title' => 'Quản lý '.$this::PAGE,
                'url' => action('Cms\AdminRole@index'),
                'active' => false
            ],
            [
                'title' => 'Xem thông tin: ' . $data->name,
                'url' => '#',
                'active' => true
            ]
        ];
        $isview = true;
        return view('cms.admin_role.edit', compact('breadcrumb', 'data','isview'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = AdminRoleModel::query()->where('id', $id)->first();

        if (!$data instanceof AdminRoleModel) {
            abort(404);
        }

        $breadcrumb = [
            [
                'title' => 'Quản lý '.$this::PAGE,
                'url' => action('Cms\AdminRole@index'),
                'active' => false
            ],
            [
                'title' => 'Sửa thông tin: ' . $data->name,
                'url' => '#',
                'active' => true
            ]
        ];
        $isview = false;
        return view('cms.admin_role.edit', compact('breadcrumb', 'data','isview'));
    }

    public function create()
    {
        $breadcrumb = [
            [
                'title' => 'Quản lý '. $this::PAGE,
                'url' => action('Cms\AdminRole@index'),
                'active' => false
            ],
            [
                'title' => 'Tạo mới thông tin '. $this::PAGE,
                'url' => '#',
                'active' => true
            ]
        ];

        return view('cms.admin_role.create', compact('breadcrumb'));
    }



    public function store(Request $request)
    {
        $user = auth()->user();

        $dbo = DB::connection('mysql');
        $dbo->beginTransaction();

        $last = AdminRoleModel::query()
            ->orderBy('order', 'desc')
            ->first();

        $data = new AdminRoleModel();
        $data->name = $request->name;
        $data->controller = $request->controller;

        $data->status = $request->status;
        $data->created_time = Carbon::now();
        $data->created_by_id = $user->id;
        $data->created_by_name = $user->name;

        $data->order = isset($last) ? ($last->order+ 1) : 1;

        $insert =$data->save();

        if ($insert > 0) {
            $dbo->commit();
            $this::log($data->id, \App\Common\ContentAction::ADD, 'Tạo mới role phân quyền cms ', $data);

            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Tạo mới thông tin thành công!');
            }
            return redirect()->action('Cms\AdminRole@index')->with('success', 'Tạo mới thông tin thành công!');
        }

        $dbo->rollBack();
        return redirect()->action('Cms\AdminRole@create' )->withErrors(['message' => 'Tạo mới thông tin thất bại']);

    }



    public function update(Request $request, $id)
    {
        $data = AdminRoleModel::query()->where('id', $id)->first();

        if (!$data instanceof AdminRoleModel) {
            abort(404);
        }

        $dbo = DB::connection('mysql');
        $dbo->beginTransaction();

        $user = auth()->user();

        $data->controller = $request->controller;
        $data->name = $request->name;
        $data->status = $request->status;

        $data->updated_time = Carbon::now();
        $data->updated_by_id = $user->id;
        $data->updated_by_name = $user->name;

        $result = $data->save();

        if ($result > 0) {

            $dbo->commit();
            $this::log($id, \App\Common\ContentAction::EDIT, 'Cập nhật role phân quyền cms ', $data);

            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Cập nhật thông tin thành công!');
            }
            return redirect()->action('Cms\AdminRole@index')->with('success', 'Cập nhật thông tin thành công!');
        }
        $dbo->rollBack();
        return redirect()->action('Cms\AdminRole@edit', ['id' => $id] )->withErrors(['message' => 'Cập nhật thông tin thất bại']);


    }

    public function changeStatus(Request $request)
    {
        if (empty($request->id)) {
            return Response::error(HttpStatusCode::HTTP_NOT_ACCEPTABLE, 'Tham số không hợp lệ');
        }

        $user = auth()->user();
        $updated = AdminRoleModel::query()->where('id', $request->id)
            ->update([
                'status' => $request->status,
                'updated_time' => Carbon::now(),
                'updated_by_id' => $user->id,
                'updated_by_name' => $user->name
            ]);

        if ($updated) {
            $this::log($request->id, \App\Common\ContentAction::EDIT, 'Thay đổi trạng thái', ["id"=>$request->id,'status' => $request->status]);

            return Response::success('Cập nhật thành công');
        }

        return Response::error(HttpStatusCode::HTTP_NOT_ACCEPTABLE, 'Có lỗi xảy ra');
    }


    public function log($id, $action, $desc, $data) {
        $user = auth()->user();
        \App\Models\Cms\AdminActivity::addData($user, $action, $id, \App\Common\Content::TYPE_ROLE,  $desc, json_encode
        ($data));
    }


}
