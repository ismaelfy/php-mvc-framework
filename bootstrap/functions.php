<?php

use Dotenv\Dotenv;
use App\Core\View;

// Función global para la clase DB
if (!function_exists('response')) {
    // Función global para la clase Response
    function response($content = '', $status = 200, $headers = [])
    {
        return new App\Core\Response($content, $status, $headers);
    }
}

// Función global para la clase View
if (!function_exists('view')) {
    function view($template, $data = [])
    {
        return View::render($template, $data);
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
            echo "<strong>Type:</strong> " . gettype($arg) . "\n";
            if (is_array($arg) || is_object($arg)) {
                echo "<pre>" . json_encode($arg, JSON_PRETTY_PRINT) . "</pre>";
            } else {
                print_r($arg);
            }
            echo "\n";
        }
        echo "</pre>";

        exit;
    }
}

// Función global para la clase Route
if (function_exists('route')) {
    function route($method, $uri, $action)
    {
        return new App\Core\Route();
    }
}


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function env($key, $default = null)
{
    return $_ENV[$key] ?? $default;
}
