<?php

namespace App\Common;

class AdminControllerPermission
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
            self::$instance = \App\Models\Cms\AdminRole::getAllControl();
        }

        return self::$instance;
    }
}