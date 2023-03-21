<?php

use Dotenv\Dotenv;

// Función global para la clase DB
if (!function_exists('response')) {
    // Función global para la clase Response
    function response($content = '', $status = 200, $headers = [])
    {
        return new App\Packages\Response($content, $status, $headers);
    }
}

// Función global para la clase View
if (!function_exists('view')) {
    function view($template, $data = [])
    {
        return new App\Packages\View($template, $data);
    }
}


if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed  $args
     * @return void
     */
    function dd(...$args)
    {
        // Get the file and line that invoked the dd function
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
        $file = $backtrace['file'];
        $line = $backtrace['line'];
        $content = file($file)[$line - 1];

        // Print the details
        echo "<pre>";
        echo "<strong>File:</strong> {$file}\n";
        echo "<strong>Line:</strong> {$line}\n";
        echo "<strong>Content:</strong> {$content}\n\n";
        foreach ($args as $arg) {
            var_dump($arg);
        }
        echo "</pre>";
        die(1);
    }
}

/* if (!function_exists('DB')) {
    $db = new App\Packages\DB('localhost', 'root', 'password', 'mydatabase');
    function DB()
    {
        global $db;
        return $db;
    }
} */

// Función global para la clase Route
if (function_exists('route')) {
    function route($method, $uri, $action)
    {
        return new App\Packages\Route();
    }
}


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function env($key, $default = null)
{
    return $_ENV[$key] ?? $default;
}
