<?php
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('welcome');
});



Route::get('/login', 'AuthController@LoginForm')->name('login.form');

Route::post('login', 'AuthController@LoginAttempt')->name('login');

Route::get('/users', 'UserController@index')->name('index.users');

Route::get('/create', 'UserController@create')->name('create.user');


Route::get('/user/{user}/edit', 'UserController@edit')->name('edit.user');

Route::post('/user', 'UserController@store')->name('store.user');

Route::put('/user/{user}/edit', 'UserController@update')->name('update.user');

Route::delete('/user/{user}', 'UserController@destroy')->name('destroy.user');
