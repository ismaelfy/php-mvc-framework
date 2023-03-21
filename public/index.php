<?php

// Cargar el archivo de autoloading de Composer
require __DIR__ . '/../bootstrap/autoload.php';

use App\Packages\Application;
use App\Packages\DB;
use App\Packages\Route;

Application::run();

$query = DB::table('users')->findAll();

//dd($query);


Route::get('/welcome','HomeController@index');