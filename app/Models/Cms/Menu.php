<?php

namespace App\Models\Cms;

use App\Common\AdminPermission;
use function Aws\filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Menu extends Model
{
    protected $guarded = [];
    protected $table = 'menu';
    const TABLE = 'menu';

    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';

    /**
     * lấy menu hiển thị dựa theo phân quyền.
     */
    public static function getListMenuForDisPlay()
    {
        // $admin_permission = session('permission');
        $data = [];

        // all menu
        $menus = self::query()->where('display', 1)->get()->toArray();

        if (!isset($menus) || empty($menus)) {
            return $data;
        }

        $group = \App\Common\AdminGroupPermission::getInstance();
        if (!$group instanceof \App\Models\Cms\AdminGroup) {
            return $data;
        }

        // all router
        $routeInfo = \App\Common\Router::getInstance();

        // all uri
        $all_url = \App\Common\Router::getAllUri();

        $menu_1s = $menu_2s = [];

        // all menu
        foreach ($menus as $menu) {

            $url_menu = $menu['url'];
            $parent_id = $menu['parent_id'];

            if ($parent_id == 0) {
                if (!isset($url_menu) || $url_menu == '') {
                    $menu_1s[] = $menu;
                } else {

                    if (in_array($url_menu, $all_url)) {

                        $route = \App\Common\Router::searchRoutesUri($url_menu, $routeInfo);
                        if (isset($route)) {
                            if (AdminPermission::isAllow($route['action'])) {
                                $menu_1s[] = $menu;
                            }
                        } else {
                            $menu_1s[] = $menu;
                        }
                    }
                }
            } else {
                // menu có tồn tại hay ko
                // menu/{menu}/edit uri như này ko quan tâm @@
                if (in_array($url_menu, $all_url)) {

                    // menu - có phân quyền
                    $route = \App\Common\Router::searchRoutesUri($url_menu, $routeInfo);
                    if (isset($route)) {
                        if (AdminPermission::isAllow($route['action'])) {
                            $menu_2s[$parent_id][] = $menu;
                        }
                    } else {
                        $menu_2s[$parent_id][] = $menu;
                    }

                }
            }
        }

        if (!empty($menu_1s) && !empty($menu_2s)) {
            foreach ($menu_1s as $tmp1) {
                $url_menu = $tmp1['url'];
                $parent_id = $tmp1['id'];

                // bỏ những thằng ko có con và ko có path
                if (!isset($url_menu) || $url_menu == '') {
                    if (!isset($menu_2s[$parent_id]) || count($menu_2s[$parent_id]) == 0) {
                        continue;
                    }
                }

                $f = [
                    'title' => $tmp1['name'],
                    'class' => $tmp1['icon'],
                    'url' => $tmp1['url'],
                    // 'permission_code'   => isset($tmp1['permission_code'])?$tmp1['permission_code']:''
                ];

                $s = [];
                if (isset($menu_2s[$tmp1['id']]) && !empty($menu_2s[$tmp1['id']])) {

                    $this_menu_2s = $menu_2s[$tmp1['id']];
                    $order_m2 = [];
                    foreach ($this_menu_2s as $tmp2) {
                        $s[$tmp2['url']] = [
                            'title' => $tmp2['name'],
                            'class' => $tmp2['icon']
                        ];
                        $order_m2[] = $tmp2['order'];
                    }
                    array_multisort($order_m2, $s);
                }

                $f['actions'] = $s;
                $data[$tmp1['order']] = $f;
            }
        }
        ksort($data);

        return $data;

    }
}
