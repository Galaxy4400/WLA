<?php

use Illuminate\Support\Str;
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

Route::macro('resourceWithSort', function($name, $controller, $options = []) {
	$param = Str::singular($name);
	Route::resource($name, $controller, $options);
	Route::get($name.'/{'.$param.'}/up/{parent_'.$param.'}', $controller.'@up')->name($name.'.up');
	Route::get($name.'/{'.$param.'}/down/{parent_'.$param.'}', $controller.'@down')->name($name.'.down');
});

Route::macro('resourceWithNest', function($name, $controller, $options = []) {
	$param = Str::singular($name);
	Route::resource($name, $controller, $options)->except(['create', 'store']);
	Route::get($name.'/create/parent/{parent_'.$param.'}', $controller.'@create')->name($name.'.create');
	Route::post($name.'/parent/{parent_'.$param.'}', $controller.'@store')->name($name.'.store');
	Route::get($name.'/{'.$param.'}/up/parent/{parent_'.$param.'}', $controller.'@up')->name($name.'.up');
	Route::get($name.'/{'.$param.'}/down/parent/{parent_'.$param.'}', $controller.'@down')->name($name.'.down');
});

Route::macro('resourceMenuItems', function () {
	Route::get('menu/{menu}/item/create', 'MenuItemController@create')->name('menu.item.create');
	Route::post('menu/{menu}/item', 'MenuItemController@store')->name('menu.item.store');
	Route::patch('menu/{menu}/item/{menu_item}', 'MenuItemController@update')->name('menu.item.update');
	Route::delete('menu/{menu}/item/{menu_item}', 'MenuItemController@destroy')->name('menu.item.destroy');
	Route::get('menu/{menu}/item/{menu_item}/edit', 'MenuItemController@edit')->name('menu.item.edit');
});


Route::middleware('guest:admin')->group(function () {
	Route::get('/login', 'AuthController@loginForm')->name('login.form');
	Route::post('/login', 'AuthController@login')->name('login');
});


Route::middleware('auth:admin')->group(function () {
	Route::get('/', 'MainController@index')->name('home');

	Route::resource('admins', 'AdminController')->except(['show']);
	Route::resource('roles', 'RoleController')->except(['show']);
	Route::resourceWithNest('pages', 'PageController');
	Route::resource('menu', 'MenuController');
	Route::resourceMenuItems();
	
	Route::post('/logout', 'AuthController@logout')->name('logout');
});
