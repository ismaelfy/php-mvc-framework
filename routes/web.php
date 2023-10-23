<?php

use App\Core\Route;

/* Route::get('/welcome', function () {
    echo 'Hola mundo';
}); */


Route::get('/welcome', 'App\Controllers\HomeController@index');

Route::get('/contacto', 'App\Controllers\ContactoController@show');
