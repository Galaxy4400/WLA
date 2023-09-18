<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('guest:admin')->group(function () {
	Route::get('/login', 'AuthController@loginForm')->name('login.form');
	Route::post('/login', 'AuthController@login')->name('login');
});


Route::middleware('auth:admin')->group(function () {
	Route::get('/', 'MainController@index')->name('home');

	Route::resource('admins', 'AdminController')->except(['show']);
	Route::resource('roles', 'RoleController')->except(['show']);
	Route::resourceWithSort('pages', 'PageController');
	Route::resource('menu', 'MenuController');
	
	Route::post('/logout', 'AuthController@logout')->name('logout');
});
