<?php

namespace App\Packages;

use Exception;

class Route
{
    private static $routes = [];

    public static function get($uri, $action)
    {
        self::$routes[] = [
            'method' => 'GET',
            'uri' => $uri,
            'action' => $action
        ];
    }

    public static function post($uri, $action)
    {
        self::$routes[] = [
            'method' => 'POST',
            'uri' => $uri,
            'action' => $action
        ];
    }

    public static function match($methods, $uri, $action)
    {
        $methods = is_array($methods) ? $methods : [$methods];

        foreach ($methods as $method) {
            self::$routes[] = [
                'method' => strtoupper($method),
                'uri' => $uri,
                'action' => $action
            ];
        }
    }

    public static function dispatch($uri, $method)
    {
        foreach (self::$routes as $route) {
            if ($route['method'] == $method && $route['uri'] == $uri) {
                $action = $route['action'];

                if (is_callable($action)) {
                    return call_user_func($action);
                } else {
                    list($controller, $method) = explode('@', $action);
                    $controller = new $controller();
                    return $controller->$method();
                }
            }
        }

        throw new Exception("Route not found");
    }
}
