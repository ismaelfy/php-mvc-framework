<?php

use Dotenv\Dotenv;
// Carga las variables de entorno desde el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return [
    'name' => 'Mi aplicación',
    'env' => 'development',
    'debug' => true,
    'url' => 'http://localhost:8000',
    'timezone' => 'America/Lima',
    'providers' => [
        // Aquí se pueden incluir los proveedores de servicios de la aplicación
        // por ejemplo: App\Providers\DatabaseServiceProvider::class,
    ],
];


