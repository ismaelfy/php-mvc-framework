<?php

use App\Packages\Route;

Route::get('/', function () {
    return 'Hola mundo';
});

Route::get('/contacto', 'App\Controllers\ContactoController@show');