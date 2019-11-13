<?php

namespace App\Common;

class Router
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
     * all router
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = self::getRouteSlugs();
        }

        return self::$instance;
    }

    public static function getRouteSlugs()
    {
        $slugs = [];
        $routes = \Illuminate\Support\Facades\Route::getRoutes();

        foreach ($routes as $route) {
            $_uri = '/'.ltrim($route->uri(), '/');

            $uri = [
                'uri' => $_uri,
                'action' => $route->getActionName(),
            ];

            if (in_array($uri, $slugs, true) == false) {
                $slugs[] = $uri;
            }
        }
        return $slugs;
    }

    public static function searchRoutesUri($uri,$array )
    {
        foreach ($array as $key => $val) {
            if ($val['uri'] === $uri) {
                return $val;
            }
        }
        return null;
    }

    public static function getAllUri()
    {
        return array_column(Router::getInstance(), 'uri');
    }


}