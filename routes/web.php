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
        return view('dashboard.index');
    });

    // Products
    Route::get('/products/create', 'App\Http\Controllers\ProductsController@create');
    Route::post('/products', 'App\Http\Controllers\ProductsController@store');

    // Fashion designers
    Route::get('/fashionDesigners', 'App\Http\Controllers\FashionDesignersController@index');
    Route::get('/fashionDesigners/create', 'App\Http\Controllers\FashionDesignersController@create');
    Route::post('/fashionDesigners', 'App\Http\Controllers\FashionDesignersController@store');
    Route::post('/fashionDesigner/viewDT', 'App\Http\Controllers\FashionDesignersController@ajaxViewDatatable');
    Route::get('/fashionDesigners/{id}', [
        'as' => 'fashionDesigners.show',
        'uses' => 'App\Http\Controllers\FashionDesignersController@show'
    ]);
    Route::delete('/fashionDesigners/{id}', [
        'as' => 'fashionDesigners.destroy',
        'uses' => 'App\Http\Controllers\FashionDesignersController@destroy'
    ]);

    // Envíos
    Route::name('shipments')->get('/shipments', 'App\Http\Controllers\ShipmentController@index');

    // Categorías
    Route::get('/categories', 'App\Http\Controllers\CategoriesController@index');

    // Carrito
    Route::get('/cart', 'App\Http\Controllers\ProductsController@cartIndex');

    // Usuarios
    Route::get('/users/clients/create', 'App\Http\Controllers\UserController@createClient');
    Route::get('/users', 'App\Http\Controllers\UserController@index');
    
    // Perfil de usuarios
    Route::get('/profile', 'App\Http\Controllers\UserController@profileIndex');

    // Logout
    Route::get('/logout', 'App\Http\Controllers\LoginController@logout');
});