<?php

namespace App\Models\Helper;

use App\Models\Cms\Admin;
use App\Models\Cms\Menu;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    protected $guarded = [];
    protected $table = 'permission';
    /* dung update_at va created_at ko*/
    public $timestamps = false;

    const OBJECT_TYPE_ADMIN_GROUP  = 'ADMIN_GROUP';
    const OBJECT_TYPE_ADMIN  = 'ADMIN';

    /**
     * @todo lấy ra quyền của quản trị
     * @param $admin
     * @return array
     */
    public static function getPermissionOfAdmin($admin) {
        $allPermission = [];
        $from_group = self::getPermissionOfAdminGroup($admin->admin_group_id);
        if(isset($from_group) && !empty($from_group)){
            foreach($from_group as $tmp_group){
                if($tmp_group->status == 'ACTIVE') {
                    $allPermission[] = $tmp_group->code;
                }
            }
        }

        $from_private = self::query()
            ->where('object_id',$admin->id)
            ->where('object_type','ADMIN')
            ->get();
        $private_active = $private_unactive = [];
        if(!empty($from_private)) {
            foreach($from_private as $tmp_private) {

                if ($tmp_private->status == 'ACTIVE') {
                    $private_active[] = $tmp_private->code;
                } else {
                    $private_unactive[] = $tmp_private->code;
                }
            }
        }
	    if(request()->get('gp') == 1) {
		    print_r($allPermission);
		    print_r($private_active);
		    exit;
	    }
        $collection = collect($allPermission)
            ->merge($private_active)
            ->diff($private_unactive);

        $data = $collection->toArray();
        //lưu vào redis

        //
        return $data;
    }

    /**
     * @@todo lấy ra quyền của nhóm
     * @param $admin_group_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getPermissionOfAdminGroup($admin_group_id) {

        $list_permission = self::query()
            ->where('object_id',$admin_group_id)
            ->where('object_type','ADMIN_GROUP')
            ->get();
        return $list_permission;
    }


    /**
     * @todo check permission
     * @param $permission
     * @return bool
     */
    public static function has($permission) {
        
        $user = auth()->user();
        /**@var Admin $user*/
        if($user->is_admin == 1) {
            return true;
        }
        $permissionList = session('permission');
        if(!isset($permissionList) || empty($permissionList)) {
            return false;
        }
        return in_array($permission, $permissionList);
    }

    public static function make($user) {
        $admin_permission = Permission::getPermissionOfAdmin($user);
        session(['permission'=>$admin_permission]);
    }


	//
	public static function getRoutePermission() {
		$datas = Menu::query()->get();
		$results = [];
		foreach($datas as $data) {
			$results[$data->permission_code] = !empty($data->description)?$data->description:$data->permission_code;
		}
		return $results;
	}

	public static function getDefinePermission() {

	}
}
