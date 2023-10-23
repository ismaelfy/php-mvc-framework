<?php

use App\Core\Application;

// definimos el timezone
date_default_timezone_set('America/Lima');

// iniciamos la sesión
session_start();

// Incluye el archivo autoload.php de Composer
require __DIR__ . '/../vendor/autoload.php';



// Define la constante __ROOT__
define('__ROOT__', dirname(dirname(__FILE__)));

// inicializar la aplicacion
Application::run();

// Load the global functions
require_once __DIR__ . '/functions.php';

// require_once __DIR__ . '/../config/app.php';

// inicializamos las rutas web y API
require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/api.php';
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

App\Core\Route::dispatch($uri, $method);
