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

Route::middleware('guest:web')->group(function () {
	Route::get('/login', 'AuthController@loginForm')->name('login.form');
	Route::post('/login', 'AuthController@login')->name('login');

	Route::get('/register', 'AuthController@registerForm')->name('register.form');
	Route::post('/register', 'AuthController@register')->name('register');

	Route::get('/forgot', 'AuthController@forgotForm')->name('forgot.form');
	Route::post('/forgot', 'AuthController@forgot')->name('forgot');
});

Route::middleware('auth:web')->group(function () {
	Route::get('/verify', 'AuthController@verifyNotice')->name('verification.notice');
	Route::post('/logout', 'AuthController@logout')->name('logout');
});

Route::middleware(['auth:web', 'signed'])->group(function () {
	Route::get('/verify/{id}/{hash}', 'AuthController@verify')->name('verification.verify');
});



Route::get('/', 'MainController@index')->name('home');

Route::get('/news', 'NewsController@index')->name('news');

Route::get('/{page}', 'MainController@page')->name('page');