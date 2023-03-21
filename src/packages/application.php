<?php

namespace App\Packages;

class Application
{
    public static function run()
    {
        spl_autoload_register(function ($class) {
            $file = str_replace('\\', '/', $class) . '.php';
            if (file_exists(__DIR__ . "/../$file")) {
                require_once __DIR__ . "/../$file";
            }
        });
    }
}
