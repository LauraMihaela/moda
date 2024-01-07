<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SizesController;
use App\Http\Controllers\ColorsController;

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

Route::post('/shipments/getNumberOfProducts', [
    'as' => 'shipments.getNumberOfProducts',
    'uses' => 'App\Http\Controllers\ShipmentController@getNumberOfProducts'
]);

// Usuario
Route::post('/user/client/store', 'App\Http\Controllers\UserController@storeClient');
// Vistas de usuario logueado

Route::group(['middleware'=>['isLogged']], function(){
    // Route::get('/dashboard', function () {
    //     return view('dashboard.index');
    // });
    Route::get('/dashboard', 'App\Http\Controllers\ProductsController@index');


    // Products
    // Route::get('/products/create', 'App\Http\Controllers\ProductsController@create');
    // Route::post('/products', 'App\Http\Controllers\ProductsController@store');
    Route::resource('products','App\Http\Controllers\ProductsController');
    Route::match(array('GET', 'POST'),'/products/datatable', [
        'as' => 'products.datatable',
        'uses' => 'App\Http\Controllers\ProductsController@datatable'
    ]);
    Route::post('/products/{id}/addToCart', [
        'as' => 'products.addToCart',
        'uses' => 'App\Http\Controllers\ProductsController@addTocart'
    ]);
    Route::get('/products/{id}/showProductCartDetails', [
        'as' => 'products.showProductCartDetails',
        'uses' => 'App\Http\Controllers\ProductsController@showProductCartDetails'
    ]);

    // Fashion designers
    Route::get('/fashionDesigners', 'App\Http\Controllers\FashionDesignersController@index');
    Route::get('/fashionDesigners/create', 'App\Http\Controllers\FashionDesignersController@create');
    Route::post('/fashionDesigners', 'App\Http\Controllers\FashionDesignersController@store');
    Route::post('/fashionDesigner/viewDT', 'App\Http\Controllers\FashionDesignersController@ajaxViewDatatable');
    Route::get('/fashionDesigners/{id}', [
        'as' => 'fashionDesigners.show',
        'uses' => 'App\Http\Controllers\FashionDesignersController@show'
    ]);
    Route::get('/fashionDesigners/{id}/edit', [
        'as' => 'fashionDesigners.edit',
        'uses' => 'App\Http\Controllers\FashionDesignersController@edit'
    ]);
    Route::put('/fashionDesigners/{id}', [
        'as' => 'fashionDesigners.update',
        'uses' => 'App\Http\Controllers\FashionDesignersController@update'
    ]);
    Route::delete('/fashionDesigners/{id}', [
        'as' => 'fashionDesigners.destroy',
        'uses' => 'App\Http\Controllers\FashionDesignersController@destroy'
    ]);
    Route::match(array('GET', 'POST'),'/fashionDesigners/datatable', [
        'as' => 'fashionDesigners.datatable',
        'uses' => 'App\Http\Controllers\FashionDesignersController@datatable'
    ]);
    // Route::post('/fashionDesigners/datatable', 'App\Http\Controllers\FashionDesignersController@datatable');
    // Route::resource('fashionDesigners','App\Http\Controllers\FashionDesignersController');

    // Tamaños
    Route::resource('sizes','App\Http\Controllers\SizesController');
    Route::match(array('GET', 'POST'),'/sizes/datatable', [
        'as' => 'sizes.datatable',
        'uses' => 'App\Http\Controllers\SizesController@datatable'
    ]);
    // Colores
    Route::resource('colors','App\Http\Controllers\ColorsController');
    Route::match(array('GET', 'POST'),'/colors/datatable', [
        'as' => 'colors.datatable',
        'uses' => 'App\Http\Controllers\ColorsController@datatable'
    ]);

    // Envíos
    Route::name('shipments')->get('/shipments', 'App\Http\Controllers\ShipmentController@index');
    Route::resource('shipments','App\Http\Controllers\ShipmentController');
    
    

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