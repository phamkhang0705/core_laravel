<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Cms\Menu;

class Base extends Controller
{
    public function __construct()
    {
        //parent::__construct();

        $this->middleware(function ($request, $next) {
            if (!auth()->check()) {
                return redirect()->action('Cms\Auth@loginForm');
            }
            $menus = Menu::getListMenuForDisPlay();

            view()->share('menus', $menus);
            view()->share('current_path', request()->path());
            return $next($request);
        });
    }

}
