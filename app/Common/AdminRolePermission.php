<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25/09/2018
 * Time: 8:45 AM
 */

namespace App\Common;


use App\Models\Cms\AdminGroup;

class AdminRolePermission
{

    /**
     * @var
     */
    public static $instance = null;

    /**
     * Storage constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (!auth()->check()) {
            return self::$instance;
        }

        if (empty(self::$instance)) {
            self::$instance = self::getRoles();
        }

        return self::$instance;
    }


    /**
     * quyền của user
     */
    public static function getRoles()
    {
        $group = \App\Common\AdminGroupPermission::getInstance();

        if (!$group instanceof AdminGroup) {
            return [];
        }

        if ($group->roles->isEmpty()) {
            return [];
        }

        $roles = [];

        foreach ($group->roles as $_role) {
            list($controller, $action) = explode('@', $_role->pivot->action);

            if (!empty($action)) {
                $roles[] = $_role->pivot->action;
            } else {
                $roles[] = $controller . '@view';
                $roles[] = $controller . '@create';
                $roles[] = $controller . '@edit';
                $roles[] = $controller . '@destroy';
                $roles[] = $controller . '@approve';
                $roles[] = $controller . '@export';
            }
        } ;

        return $roles;
    }

}