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

<<<<<<< HEAD



=======
>>>>>>> b67ec6197937b166c1868ca2bbb3b6cba525ab4a
Route::get('/login', 'AuthController@LoginForm')->name('login.form');

Route::post('login', 'AuthController@LoginAttempt')->middleware('throttle:10,1')->name('login');





Route::group(['middleware'=>'auth'], function(){

Route::post('logout', 'AuthController@LogOut')->name('logOut');   

Route::get('/users', 'UserController@index')->name('index.users');

Route::get('/create', 'UserController@create')->name('create.user');

Route::get('/user/{user}/edit', 'UserController@edit')->name('edit.user');

Route::post('/user', 'UserController@store')->name('store.user');

Route::put('/user/{user}/edit', 'UserController@update')->name('update.user');

Route::delete('/user/{user}', 'UserController@destroy')->name('destroy.user');

Route::resource('/site','SitesController');

});