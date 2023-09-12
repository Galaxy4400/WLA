<?php

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