<?php

namespace App\Core;

use Dotenv\Dotenv;
use App\Core\Route;

class Application
{
    public static function run()
    {
        self::registerAutoloader();
        self::loadEnvironment();
        self::handleRequest();
    }

    private static function registerAutoloader()
    {
        spl_autoload_register(function ($class) {
            $parts = explode('\\', $class);
            $className = array_pop($parts);
            $namespace = implode('/', $parts);
            $file = __DIR__ . "/../../$namespace/$className.php";
            if (file_exists($file)) {
                require_once $file;
            }
        });
    }

    private static function loadEnvironment()
    {
        // Load environment variables from .env file
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
    }

    private static function handleRequest()
    {
        // Puedes agregar aquí la lógica para manejar las solicitudes HTTP y enrutarlas a los controladores apropiados.
        // Ejemplo:
        // $request = new Request();
        // $router = new Router();
        // $router->route($request);
    }
}



