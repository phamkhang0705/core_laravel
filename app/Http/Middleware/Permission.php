<?php

namespace App\Http\Middleware;

use App\Models\Cms\AdminGroup;
use Illuminate\Support\Facades\Route;

class Permission
{

    public function handle($request, \Closure $next)
    {
        $response = $next($request);
        $current_route = Route::currentRouteName();
        if ($current_route == 'cms.login_form' || $current_route == 'cms.forget_password' || $current_route == 'cms.login') {
            return $response;
        }

        if (!auth()->check()) {
            return redirect('/login');
        }

        $group = \App\Common\AdminGroupPermission::getInstance();

        if (!$group instanceof AdminGroup) {
            if ($current_route == 'cms.home') {
                return $response;
            } else
                abort(403);
        }

        $route = Route::getCurrentRoute()->getActionName();

        list($controller, $action) = explode('@', $route);

        $controller_current_name = str_replace('App\Http\Controllers\Cms\\', '', $controller);

        switch ($action) {
            case 'index':
            case 'show':
                $action = 'view';
                break;
        }

        $actions = [
            'view', 'edit', 'create', 'destroy', 'approve', 'export'
        ];
        $roles = $group->roles;
        if (\App\Common\AdminPermission::isAllow($controller_current_name . '@' . $action)) {
            return $response;
        }

        foreach ($roles as $role) {
            $_route = "App\Http\Controllers\Cms\\" . $role->pivot->action;
            list($_controller, $_action) = explode('@', $_route);

            if ($_controller == $controller && ($_action == '' || $_action == $action || !in_array($_action, $actions))) {
                return $response;
            }
        }

        return redirect('/');

        abort(403);
    }
}
