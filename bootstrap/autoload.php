<?php
// definimos el timezone
date_default_timezone_set('America/Lima');

// iniciamos la sesión
session_start();

// Incluye el archivo autoload.php de Composer
require __DIR__ . '/../vendor/autoload.php';

// Carga las variables de entorno desde el archivo .env
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Define la constante __ROOT__
define('__ROOT__', dirname(dirname(__FILE__)));

// Load the global functions
require_once __DIR__ . '/functions.php';

// Registrar el autoload para las clases
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../app/packages/' . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});
