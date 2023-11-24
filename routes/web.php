<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/login', 'App\Http\Controllers\LoginController@login');

// Vistas de usuario logueado

Route::group(['middleware'=>['isLogged']], function(){
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    // Envíos
    Route::get('/shipments', 'App\Http\Controllers\ShipmentController@index');

    // Categorías
    Route::get('/categories', 'App\Http\Controllers\CategoriesController@index');

    // Carrito
    Route::get('/cart', 'App\Http\Controllers\ProductsController@cartIndex');

    // Usuarios
    Route::post('/user/createClient', 'App\Http\Controllers\UserController@createClient');
    Route::get('/users', 'App\Http\Controllers\UserController@index');
    // Perfil de usuarios
    Route::get('/profile', 'App\Http\Controllers\UserController@profileIndex');

});