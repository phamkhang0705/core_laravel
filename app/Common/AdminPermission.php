<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25/09/2018
 * Time: 9:07 AM
 */

namespace App\Common;


class AdminPermission
{
    public static function isAllow($action)
    {
        // is admin
        $user = auth()->user();

        /**@var Admin $user */
        if ($user->is_admin == 1) {
            return true;
        }
        // end is admin

        if (empty($action))
            return false;
        // controller ko check -> cho phép vào
        if (AdminPermission::isControllerPermission($action)) {
            return AdminPermission::isActionPermission($action);
        }

        return false;
    }

    // kiểm tra controller có phân quyền ko
    // => ko phân quyền -> ko check (ai cung dc vào)
    public static function isControllerPermission($action)
    {
        $controller = AdminControllerPermission::getInstance();
        list($_controller, $_action) = explode('@', $action);
        $_controller = str_replace('App\Http\Controllers\Cms\\', '', $_controller);
        return in_array($_controller, $controller);
    }

    // kiểm tra controller-action có phân quyền ko
    // => ko phân quyền -> ko dc vào
    public static function isActionPermission($action)
    {
        // đổi index = view
        $action = str_replace('App\Http\Controllers\Cms\\', '', $action);
        $action = str_replace('@index', '@view', $action);
        $roles = AdminRolePermission::getInstance();

        return in_array($action, $roles);
    }

}