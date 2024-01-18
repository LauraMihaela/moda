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

Route::post('/shipments/getNumberOfProducts', [
    'as' => 'shipments.getNumberOfProducts',
    'uses' => 'App\Http\Controllers\ShipmentController@getNumberOfProducts'
]);

// Usuario
Route::post('/user/client/store', 'App\Http\Controllers\UserController@storeClient');
// Vistas de usuario logueado

Route::group(['middleware'=>['isLogged','setLocale']], function(){

    Route::get('/dashboard', 'App\Http\Controllers\ProductsController@index');
    // Route::get('/dashboard', function () {
    //     return view('dashboard.index');
    // });

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
    Route::match(array('GET', 'POST'),'/shipments/datatable', [
        'as' => 'colors.datatable',
        'uses' => 'App\Http\Controllers\ShipmentController@datatable'
    ]);
    
    
    // Categorías
    Route::get('/categories', 'App\Http\Controllers\CategoriesController@index');
    Route::resource('categories','App\Http\Controllers\CategoriesController');
    Route::match(array('GET', 'POST'),'/categories/datatable', [
        'as' => 'categories.datatable',
        'uses' => 'App\Http\Controllers\CategoriesController@datatable'
    ]);

    // Carrito
    Route::get('/cart', 'App\Http\Controllers\ProductsController@cartIndex');

    // Usuarios
    Route::get('/users/clients/create', 'App\Http\Controllers\UserController@createClient');
    Route::get('/users', 'App\Http\Controllers\UserController@index');
    // Route::resource('users','App\Http\Controllers\UserController');
    // Route::match(array('GET', 'POST'),'/users/datatable', [
    //     'as' => 'users.datatable',
    //     'uses' => 'App\Http\Controllers\UserController@datatable'
    // ]);
    // Administradores
    Route::get('/users/admins', 'App\Http\Controllers\UserAdminController@index');
    Route::get('/users/admins/create', 'App\Http\Controllers\UserAdminController@create');
    Route::post('/users/admins', 'App\Http\Controllers\UserAdminController@store');
    Route::get('/users/admins/{id}', [
        'as' => 'users.admins.show',
        'uses' => 'App\Http\Controllers\UserAdminController@show'
    ]);
    Route::get('/users/admins/{id}/edit', [
        'as' => 'users.admins.edit',
        'uses' => 'App\Http\Controllers\UserAdminController@edit'
    ]);
    Route::put('/users/admins/{id}', [
        'as' => 'users.admins.update',
        'uses' => 'App\Http\Controllers\UserAdminController@update'
    ]);
    Route::delete('/users/admins/{id}', [
        'as' => 'users.admins.destroy',
        'uses' => 'App\Http\Controllers\UserAdminController@destroy'
    ]);
    Route::match(array('GET', 'POST'),'/users/admins/datatable', [
        'as' => 'users.admins.datatable',
        'uses' => 'App\Http\Controllers\UserAdminController@datatable'
    ]);

    // Route::resource('users.admins', 'App\Http\Controllers\UserAdminController')->shallow();
    
    // Agents
    // Route::resource('users.agents', 'App\Http\Controllers\UserAgentController')->shallow();
    Route::get('/users/agents', 'App\Http\Controllers\UserAgentController@index');
    Route::get('/users/agents/create', 'App\Http\Controllers\UserAgentController@create');
    Route::post('/users/agents', 'App\Http\Controllers\UserAgentController@store');
    Route::get('/users/agents/{id}', [
        'as' => 'users.agents.show',
        'uses' => 'App\Http\Controllers\UserAgentController@show'
    ]);
    Route::get('/users/agents/{id}/edit', [
        'as' => 'users.agents.edit',
        'uses' => 'App\Http\Controllers\UserAgentController@edit'
    ]);
    Route::put('/users/agents/{id}', [
        'as' => 'users.agents.update',
        'uses' => 'App\Http\Controllers\UserAgentController@update'
    ]);
    Route::delete('/users/agents/{id}', [
        'as' => 'users.agents.destroy',
        'uses' => 'App\Http\Controllers\UserAgentController@destroy'
    ]);
    Route::match(array('GET', 'POST'),'/users/agents/datatable', [
        'as' => 'users.agents.datatable',
        'uses' => 'App\Http\Controllers\UserAgentController@datatable'
    ]);

    // Clients
    // Route::resource('users.clients', 'App\Http\Controllers\UserClientController')->shallow();
    Route::get('/users/clients', 'App\Http\Controllers\UserClientController@index');
    Route::get('/users/clients/create', 'App\Http\Controllers\UserClientController@create');
    Route::post('/users/clients', 'App\Http\Controllers\UserClientController@store');
    Route::get('/users/clients/{id}', [
        'as' => 'users.clients.show',
        'uses' => 'App\Http\Controllers\UserClientController@show'
    ]);
    Route::get('/users/clients/{id}/edit', [
        'as' => 'users.clients.edit',
        'uses' => 'App\Http\Controllers\UserClientController@edit'
    ]);
    Route::put('/users/clients/{id}', [
        'as' => 'users.clients.update',
        'uses' => 'App\Http\Controllers\UserClientController@update'
    ]);
    Route::delete('/users/clients/{id}', [
        'as' => 'users.clients.destroy',
        'uses' => 'App\Http\Controllers\UserClientController@destroy'
    ]);
    Route::match(array('GET', 'POST'),'/users/clients/datatable', [
        'as' => 'users.clients.datatable',
        'uses' => 'App\Http\Controllers\UserClientController@datatable'
    ]);

    // Perfil de usuarios
    Route::get('/profile', 'App\Http\Controllers\UserController@profileIndex');
    // A este update no se le pasa el id porque el id siempre será el del usuario logueado
    Route::put('/users/profile', [
        'as' => 'users.profile.update',
        'uses' => 'App\Http\Controllers\UserController@profileUpdate'
    ]);

    Route::get('/setLanguage/{lang?}', 'App\Http\Controllers\LoginController@setLanguage');

    // Logout
    Route::get('/logout', 'App\Http\Controllers\LoginController@logout');
});