<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'products');

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', 'AuthController@LoginForm')->name('login.form');

    Route::post('login', 'AuthController@LoginAttempt')->middleware('throttle:10,1')->name('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', 'AuthController@LogOut')->name('logOut');

    Route::get('/users', 'UserController@index')->name('users.index');

    Route::get('/user/create', 'UserController@create')->name('user.create');

    Route::get('/user/{user}/edit', 'UserController@edit')->name('user.edit');

    Route::post('/user', 'UserController@store')->name('user.store');

    Route::put('/user/{user}/edit', 'UserController@update')->name('user.update');

    Route::delete('/user/{user}', 'UserController@destroy')->name('user.destroy');

    Route::get('/jobs', 'SyncJobsController@index')->name('jobs.index');

    Route::get('products', 'ProductsController@index')->name('products.index');

    Route::post('product/import', 'ProductsController@import')->name('product.import');

    Route::put('product/{product}/sync', 'ProductsController@sync')->name('product.sync');

    Route::resource('sites', 'SitesController');

    Route::view('/products/show', 'products/show');

});

// test routes
Route::view('/test/product', 'test/product')->name('test.product');
