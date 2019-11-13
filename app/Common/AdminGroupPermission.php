<?php

namespace App\Common;

class AdminGroupPermission
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
            $user = auth()->user();

            $group = $user->group()->with('roles')->first();

            self::$instance = $group;
        }

        return self::$instance;
    }


}