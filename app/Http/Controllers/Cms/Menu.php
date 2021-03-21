<?php

namespace App\Http\Controllers\Cms;

use App\Common\AjaxResponse;
use App\Models\Cms\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Cms\Menu as CmsMenuModel;
use Illuminate\Support\Facades\DB as DB;

class Menu extends Base
{

    public function index()
    {

	    $breadcrumb = [
		    ['title'=>'Menu','url'=>route('cms.menu.index')],
		    ['title'=>'Danh sách menu cms','url'=>'','active'=>true],
	    ];
        //

        return view('cms.menu.index',compact(
	        'breadcrumb',
	        'params')
        );
    }


    public function create()
    {
        if(!\App\Models\Helper\Permission::has('cms_menu')) {
            abort(403);
        }
        $breadcrumb = [
            ['title'=>'Menu','url'=>route('cms.menu.index')],
            ['title'=>'Thêm menu mới','url'=>route('cms.menu.create'),'active'=>true],
        ];



        /*$datas = CmsMenuModel::query()->get()->toArray();
        $menu_1s = array_where($datas,function($key, $value) {
            return $value['parent_id'] == 0;
        });
        $menu_1s = collect($menu_1s)->keyBy('id')->toArray();

        $menu_1s = array_pluck($menu_1s,'name','id');*/

	    $menu_1s = CmsMenuModel::query()->where('parent_id',0)
		    ->orderBy('order','asc')
		    ->get()
		    ->toArray();

	    $menu_1s = array_pluck($menu_1s,'name','id');

        $form_option = [
            'action'=>'cms.menu.store',
            'method'=>'post',
        ];

        return view('cms.menu.form',compact('breadcrumb','form_option','menu_1s'));
    }


    public function store(Request $request)
    {

        /**@var Admin $user*/
        $user = auth()->user();
        //
        $name = $request->get('name');
        $display = $request->get('display');

        $url = $request->get('url');
        $parent_id = $request->get('parent_id');
        $description = $request->get('description');
        $icon = $request->get('icon');
        $permission_code = $request->get('permission_code');

        //cách insert 1
        $data = [
            'name' => $name,
            'display' => isset($display)?1:0,
            'url' => $url,
	        'permission_code'=>$permission_code,
            'icon'=>$icon,
            'parent_id'=>$parent_id,
            'description'=>$description,
            'created_by_id'=>$user->id,
            'created_by_name'=>$user->name,
            'updated_by_id'=>$user->id,
            'updated_by_name'=>$user->name,
        ];
        $odm = new CmsMenuModel($data);
        $result = $odm->save();
        if($result == false) {
            return back()->withErrors('Không thể tạo  mới, vui lòng liên hệ kỹ thuật');
        }
	    $update_data = [
		    'order'=>$odm->id
	    ];
	    $odm->update($update_data);

        $this::log($odm->id, \App\Common\ContentAction::ADD, 'Tạo mới menu', $data);

        return redirect()->route('cms.menu.index')->with('success','Tạo thành công menu "'.$odm->name.'"');
    }


    public function show($id)
    {
        if(!\App\Models\Helper\Permission::has('cms_menu')) {
            abort(403);
        }
        $breadcrumb = [
            ['title'=>'Menu','url'=>route('cms.menu.index')],
            ['title'=>'Thông tin chi tiết','url'=>route('cms.menu.create'),'active'=>true],
        ];

        $data = CmsMenuModel::query()->find($id);


        return view('cms.menu.show',compact('breadcrumb','menu_1s','data'));
    }


    public function edit($id)
    {

        if(!\App\Models\Helper\Permission::has('cms_menu')) {
            abort(403);
        }
        $odm = CmsMenuModel::query()->find($id);
        if(!$odm) {
            abort(404);
        }
        $data = $odm->toArray();

        $breadcrumb = [
            ['title'=>'Cms Menu','url'=>route('cms.menu.index')],
            ['title'=>'Cập nhật thông tin','url'=>''],
        ];
        $form_option = [
            'action'=>'cms.menu.update',
            'method'=>'put',
            'id'=>$id
        ];
        /*$datas = CmsMenuModel::query()->get()->toArray();

        $menu_1s = array_where($datas,function($key, $value) {
            return $value['parent_id'] == 0;
        });
        $menu_1s = collect($menu_1s)->keyBy('id')->toArray();

        $menu_1s = array_pluck($menu_1s,'name','id');*/
	    
	    $menu_1s = CmsMenuModel::query()->where('parent_id',0)
		    ->orderBy('order','asc')
		    ->get()
		    ->toArray();

	    $menu_1s = array_pluck($menu_1s,'name','id');


        //
        return view('cms.menu.form',compact('breadcrumb','form_option','data','menu_1s'));
    }


    public function update(Request $request, $id)
    {
        /**@var Admin $user*/
        $user = auth()->user();
        //
        $name = $request->get('name');
        $display = $request->get('display');
        $url = $request->get('url');
        $parent_id = $request->get('parent_id');
        $description = $request->get('description');
        $icon = $request->get('icon');
        $permission_code = $request->get('permission_code');

        //cách insert 1
        $data = [
            'name' => $name,
            'display' => isset($display)?1:0,
            'url' => $url,
            'permission_code' => $permission_code,
            'icon' => $icon,
            'parent_id'=>$parent_id,
            'description'=>$description,
            'created_by_id'=>$user->id,
            'created_by_name'=>$user->name,
            'updated_by_id'=>$user->id,
            'updated_by_name'=>$user->name,
        ];
        $odm = CmsMenuModel::query()->find($id);
        if(!$odm instanceof CmsMenuModel) {
            abort(404);
        }

        $result = $odm->update($data);
        if($result == false) {
            return back()->withErrors('Không thể cập nhật, vui lòng liên hệ kỹ thuật');
        }

        $this::log($odm->id, \App\Common\ContentAction::EDIT, 'Cập nhật menu', $data);

        return redirect()->route('cms.menu.index')
		    ->with('success','Cập nhật thông tin menu "'.$odm->name.'" thành công');
    }


    public function delete($id) {
        
        $odm = CmsMenuModel::query()->find($id);

        $result = $odm->delete();
        //make event to log or notification
        if($result == true) {
            return back()->with('success','Xóa menu thành công');
        }

        $this::log($id, \App\Common\ContentAction::DELETE, 'Xóa menu', $odm);
        return back()->withErrors('Không thể xóa, vui lòng liên hệ kỹ thuật');
    }


    public function getListMenu() {
        $datas = CmsMenuModel::query()->orderBy('order','asc')->get()->toArray();

	    $menu_1s = CmsMenuModel::query()->orderBy('order','asc')->get()
		    ->where('parent_id',0)
		    ->toArray();
        $datas = collect($datas)->groupBy('parent_id')->toArray();

        $menu_2s = array_where($datas,function($key, $value) {
            return $key != 0;
        });
        // var_dump($menu_1s);
        // var_dump($menu_2s);
        // die();
        $total = DB::table(CmsMenuModel::TABLE)->count('id');


        $params = ['total'=>$total];
        $html =  view('cms.menu.ajax.list',compact('breadcrumb','menu_1s','menu_2s','params'))->render();

        return response()->json(AjaxResponse::response(
            'Lấy danh sách menu thành công', AjaxResponse::STATUS_SUCCESS,['html'=>$html]
        ));

    }

    public function bigSort(Request $request) {
        $new_order_array = $request->get('order');
        if(!empty($new_order_array)) {
            foreach($new_order_array as $index => $new_order) {
                $cmsMenu = CmsMenuModel::query()->find($new_order);
                $data = [
                    'order'=>$index
                ];
                $cmsMenu->update($data);
            }
        }
        return response()->json(AjaxResponse::response(
            'Sắp xếp vị trí thành công', AjaxResponse::STATUS_SUCCESS
        ));
    }

    public function log($id, $action, $desc, $data) {
        $user = auth()->user();
        \App\Models\Cms\AdminActivity::addData($user, $action, $id, \App\Common\Content::TYPE_MENU,  $desc, json_encode
        ($data));
    }


}
