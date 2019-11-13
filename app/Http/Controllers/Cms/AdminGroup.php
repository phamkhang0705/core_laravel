<?php

namespace App\Http\Controllers\Cms;

use App\Common\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Cms\AdminGroupRole;
use App\Models\Cms\AdminRole;
use App\Models\Cms\AdminGroup as AdminGroupModel;

class AdminGroup extends Base
{

    public function index(Request $request)
    {
        $breadcrumb = [
            [
                'title' => 'Nhóm quản trị',
                'url' => route('cms.admin_group.index'),
                'active' => false
            ],
            [
                'title' => 'Quản lý phân quyền',
                'url' => '#',
                'active' => true
            ]
        ];

        $page = $request->page;

        $admin_group = \App\Models\Cms\AdminGroup::query()->with(['roles']);

        if (!empty($request->name)) {
            $admin_group->where('name', 'like', "%{$request->name}%");
        }

        if (!empty($request->code)) {
            $admin_group->where('code', 'like', "%{$request->code}%");
        }

        $datas = $admin_group->orderBy('created_time', 'desc')->get();
        $admin_group = $admin_group->paginate(Utility::LIMIT);

        return view('cms.admin_group.index', compact(
            'breadcrumb', 'admin_group', 'limit'
        ));
    }

    public function create()
    {
        $breadcrumb = [
            [
                'title' => 'Nhóm quản trị',
                'url' => route('cms.admin_group.index'),
                'active' => false
            ],
            [
                'title' => 'Thêm mới nhóm quản trị',
                'url' => '#',
                'active' => true
            ]
        ];
        $form_option = [
            'action' => 'cms.admin_group.store',
            'method' => 'post',
        ];

        $admin_roles = AdminRole::query()->where('status', AdminRole::STATUS_ENABLED)->orderBy('name')->get();

        return view('cms.admin_group.form', compact('breadcrumb', 'form_option', 'admin_roles'));
    }

    public function store(Request $request)
    {
        $code = trim($request->code);
        // Get admin group
        $adminGroup = AdminGroupModel::query()->where('code', $code)->first();
        // return var_dump($adminGroup);
        if (!is_null($adminGroup)) {
            return redirect()->route('cms.admin_group.create')
                ->withErrors('Mã nhóm đã tồn tại')->withInput();
        }

        /**@var User $user */
        $user = auth()->user();

        $admin_group = new \App\Models\Cms\AdminGroup();

        $admin_group->code = trim($request->code);
        $admin_group->name = trim($request->name);
        $admin_group->status = $request->status;
        $admin_group->description = $request->description;
        $admin_group->created_by_id = $user->id;
        $admin_group->created_by_name = $user->name;
        $admin_group->created_time = Carbon::now();

        if ($admin_group->save()) {
            if (!empty($request->role)) {
                $actions = [];
                foreach ($request->role as $key => $role) {
                    if (!empty($role)) {
                        foreach ($role as $item) {
                            $actions[] = $item;

                            $role_data[$key] = [
                                'action' => $item
                            ];

                            $admin_group->roles()
                                ->wherePivot('action', $item)
                                ->sync([
                                    $key => [
                                        'action' => $item
                                    ]
                                ]);
                        }
                    }
                }
            }

            return redirect()->route('cms.admin_group.index')
                ->with('success', 'Tạo mới thông tin nhóm thành công');
        }

        return redirect()->route('cms.admin_group.create')
            ->withErrors('Có lỗi xảy ra');
    }


    public function show($id)
    {
        $admin_group_odm = \App\Models\Cms\AdminGroup::query()->with('roles')->find($id);
        if (!$admin_group_odm) {
            abort(404);
        }
        $data = $admin_group_odm->toArray();

        $breadcrumb = [
            [
                'title' => 'Nhóm quản trị',
                'url' => route('cms.admin_group.index'),
                'active' => false
            ],
            [
                'title' => 'Thông tin chi tiết nhóm quản trị',
                'url' => '#',
                'active' => true
            ]
        ];

        $form_option = [
            'action' => 'cms.admin_group.update',
            'method' => 'put',
            'id' => $id
        ];

        $admin_roles = AdminRole::query()->where('status', AdminRole::STATUS_ENABLED)->orderBy('name')->get();

        $role_allows = [];
        foreach ($admin_group_odm->roles as $role) {
            if (!empty($role->pivot->action)) {
                $role_allows[$role->id][$role->pivot->action] = 1;
            }
        }

        return view('cms.admin_group.show', compact('breadcrumb', 'form_option', 'data', 'admin_roles', 'role_allows'));
    }


    public function edit($id)
    {
        $admin_group_odm = \App\Models\Cms\AdminGroup::query()->with('roles')->find($id);
        if (!$admin_group_odm) {
            abort(404);
        }
        $data = $admin_group_odm->toArray();

        $breadcrumb = [
            [
                'title' => 'Nhóm quản trị',
                'url' => route('cms.admin_group.index'),
                'active' => false
            ],
            [
                'title' => 'Cập nhật nhóm quản trị',
                'url' => '#',
                'active' => true
            ]
        ];

        $form_option = [
            'action' => 'cms.admin_group.update',
            'method' => 'put',
            'id' => $id
        ];

        $admin_roles = AdminRole::query()->where('status', AdminRole::STATUS_ENABLED)->orderBy('name')->get();

        $role_allows = [];
        foreach ($admin_group_odm->roles as $role) {
            if (!empty($role->pivot->action)) {
                $role_allows[$role->id][$role->pivot->action] = 1;
            }
        }

        return view('cms.admin_group.form', compact('breadcrumb', 'form_option', 'data', 'admin_roles', 'role_allows'));
    }


    public function update(Request $request, $id)
    {
        /**@var User $user */
        $user = auth()->user();

        $admin_group = \App\Models\Cms\AdminGroup::query()->with(['roles'])->where('id', $id)->first();
        if (!$admin_group instanceof \App\Models\Cms\AdminGroup) {
            return redirect()->route('cms.admin_group.edit', ['id' => $id])
                ->withErrors('Không tìm thấy thông tin yêu cầu');
        }

//        $admin_group->code = $request->code;
        $admin_group->name = $request->name;
        $admin_group->status = $request->status;
        $admin_group->description = $request->description;
        $admin_group->updated_by_id = $user->id;
        $admin_group->updated_by_name = $user->name;
        $admin_group->updated_time = Carbon::now();

        if ($admin_group->save()) {
            if (!empty($request->role)) {
                $actions = [];
                foreach ($request->role as $key => $role) {
                    if (!empty($role)) {
                        foreach ($role as $item) {
                            $actions[] = $item;

                            $role_data[$key] = [
                                'action' => $item
                            ];

                            $admin_group->roles()
                                ->wherePivot('action', $item)
                                ->sync([
                                    $key => [
                                        'action' => $item
                                    ]
                                ]);
                        }
                    }
                }

                if (!empty($actions)) {
                    AdminGroupRole::query()->where('admin_group_id', $id)->whereNotIn('action', $actions)
                        ->delete();
                }
            }

            return redirect()->route('cms.admin_group.index')
                ->with('success', 'Chỉnh sửa thông tin nhóm thành công');
        }

        return redirect()->route('cms.admin_group.edit', ['id' => $id])
            ->withErrors('Có lỗi xảy ra');
    }


    public function delete($id)
    {
        \App\Models\Cms\AdminGroup::query()->find($id)->delete();

        return redirect()->route('admin_group.index')->with('message', 'Delete Success');
    }
}
