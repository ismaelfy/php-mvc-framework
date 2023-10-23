<?php

namespace App\Core;

use Exception;

class Route
{
    private static $routes = [];

    public static function add($method, $uri, $action)
    {
        self::$routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action
        ];
    }

    public static function get($uri, $action)
    {
        self::add('GET', $uri, $action);
    }

    public static function post($uri, $action)
    {
        self::add('POST', $uri, $action);
    }

    public static function match($methods, $uri, $action)
    {
        $methods = is_array($methods) ? $methods : [$methods];

        foreach ($methods as $method) {
            self::add(strtoupper($method), $uri, $action);
        }
    }

    public static function dispatch($uri, $method)
    {
        if ($uri === "/") {
            echo "welcome to page";
            exit();
        }

        $routeFound = false;

        foreach (self::$routes as $route) {
            if ($route['method'] == $method && self::matchUri($route['uri'], $uri)) {
                $action = $route['action'];

                if (is_callable($action)) {
                    return call_user_func($action);
                } else {
                    list($controller, $method) = explode('@', $action);
                    $controller = new $controller();
                    return $controller->$method();
                }
                $routeFound = true;
            }
        }

        if (!$routeFound) {
            echo 'No matching route found';
            exit();
        }

        throw new Exception("Route not found");
    }



    private static function matchUri($routeUri, $requestUri)
    {
        $routeUriParts = explode('/', $routeUri);
        $requestUriParts = explode('/', $requestUri);

        if (count($routeUriParts) !== count($requestUriParts)) {
            return false;
        }

        for ($i = 0; $i < count($routeUriParts); $i++) {
            if ($routeUriParts[$i] != $requestUriParts[$i] && !self::isParameter($routeUriParts[$i])) {
                return false;
            }
        }

        return true;
    }

    private static function isParameter($part)
    {
        return (bool) preg_match('/\{(.+?)\}/', $part);
    }
}
