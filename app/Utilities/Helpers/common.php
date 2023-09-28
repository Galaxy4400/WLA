<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

/**
 * Just an alias of the dump function
 */
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
 * @var string $fieldName
 * @var Model $model
 * @return mixed
 */
if (!function_exists('current_value')) {
	function current_value($fieldName, $model): mixed
	{
		if (!$model->exists && !old($fieldName)) return '';

		return $model->exists ? $model->$fieldName : old($fieldName);
	}
}


/**
 * Get curent checked status
 * 
 * @var string $fieldName
 * @return string
 */
if (!function_exists('current_checked')) {
	function current_checked($fieldName): string
	{
		return old($fieldName) ? 'checked' : '';
	}
}


/**
 * Get curent checked status of check group
 * 
 * @var string $name
 * @return string
 */
if (!function_exists('current_group_checked')) {
	function current_group_checked($fieldName, $currentValue, $oldValues): string
	{
		$oldValues = ($oldValues instanceof Collection) ? $oldValues : collect($oldValues);

		if ($oldValues->count()) {
			$isChecked = $oldValues->contains($currentValue);
		} else {
			$isChecked = collect(old($fieldName))->contains($currentValue);
		}

		return $isChecked ? 'checked' : '';
	}
}


/**
 * Set curent selected optons status of selector 
 * 
 * @var string $fieldName
 * @var mixed $currentValue
 * @var mixed $oldValues
 * @return string
 */
if (!function_exists('current_selected')) {
	function current_selected($fieldName, $currentValue, $oldValues): string
	{
		$oldValues = ($oldValues instanceof Collection) ? $oldValues : collect($oldValues);

		if ($oldValues->count()) {
			$isSelected = $oldValues->contains($currentValue);
		} else {
			$isSelected = old($fieldName) === (string)$currentValue;
		}

		return $isSelected ? 'selected' : '';
	}
}


/**
 * Set curent disabled optons status of selector
 * 
 * @var string $currentValue
 * @var mixed $value
 * @return string
 */
if (!function_exists('current_disabled')) {
	function current_disabled($currentValue, $value): string
	{
		return $currentValue === $value ? 'disabled' : '';
	}
}