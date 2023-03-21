<?php
// app/packages/route/Route.php

namespace App\Packages;

class Route
{
    protected static $routes = [];

    public static function get($uri, $controller_method)
    {
        self::$routes['GET'][$uri] = $controller_method;
    }

    public static function post($uri, $controller_method)
    {
        self::$routes['POST'][$uri] = $controller_method;
    }

    public static function handle()
    {
        $request_method = $_SERVER['REQUEST_METHOD'];
        $request_uri = $_SERVER['REQUEST_URI'];
        $request_uri = explode('?', $request_uri, 2)[0];

        if (isset(self::$routes[$request_method][$request_uri])) {
            $controller_method = self::$routes[$request_method][$request_uri];
            list($controller, $method) = explode('@', $controller_method);
            $controller_class = "\\App\\Controllers\\$controller";
            $controller_instance = new $controller_class();
            $controller_instance->$method();
        } else {
            http_response_code(404);
            echo 'Página no encontrada';
        }
    }
}
