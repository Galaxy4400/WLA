<?php

/**
 * Just an alias of the dump function
 */

use Illuminate\Support\Facades\Route;

if (!function_exists('d')) {
	function d(...$vars): void
	{
		foreach ($vars as $v) {
			dump($v);
		}
	}
}


/**
 * Return current authenticated user
 * 
 * @return mixed
 */
if (!function_exists('current_user')) {
	function current_user(): mixed
	{
		return auth()->user();
	}
}


/**
 * Return current authenticated user
 * 
 * @var string $name
 * 
 * @return void
 */
if (!function_exists('flash')) {
	function flash(string $name): void
	{
		$message = config('messages.'.$name);

		foreach ($message as $key => $value) {
			session()->flash('flash.'.$key, $value);
		}
	}
}


/**
 * Check if flash exist
 * 
 * @var string $name
 * 
 * @return bool
 */
if (!function_exists('is_flash')) {
	function is_flash(string $name): bool
	{
		return isset(request()->session()->all()['flash'][$name]) ? true : false;
	}
}


/**
 * Return current authenticated user
 * 
 * @var string $image
 * 
 * @return void
 */
if (!function_exists('pluggable')) {
	function pluggable($image): string
	{
		return $image ? asset('storage/'.$image) : asset('storage/images/plug.jpg');
	}
}


/**
 * Check route status and retur according active class
 * 
 * @var string $routeName
 * @var string $class
 * @return bool
 */
if (!function_exists('link_status')) {
	function link_status(string $routeName, string $class = '_active'): string
	{
		return Route::is($routeName) ? $class : '';
	}
}


/**
 * Get curent value
 * 
 * @var string $name
 * @var Model $item
 * @return bool
 */
if (!function_exists('curent_value')) {
	function curent_value($name, $model): string
	{
		if (!$model->exists && !old($name)) return '';

		return $model->exists ? $model->$name : old($name);
	}
}


/**
 * Set curent selected optons of nested selectors
 * 
 * @var string $name
 * @var Model $item
 * @var Model $model
 * @return bool
 */
if (!function_exists('curent_nest_selected')) {
	function curent_nest_selected($name, $item, $model): string
	{
		if ($model->exists) {
			$isSelected = optional($model->parent)->id === $item->id;
		} else {
			$isSelected = old($name) === (string)$item->id;
		}

		return $isSelected ? 'selected' : '';
	}
}
