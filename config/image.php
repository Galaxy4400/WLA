<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Image Driver
	|--------------------------------------------------------------------------
	|
	| Intervention Image supports "GD Library" and "Imagick" to process images
	| internally. You may choose one of them according to your PHP
	| configuration. By default PHP's "GD Library" implementation is used.
	|
	| Supported: "gd", "imagick"
	|
	*/

	'driver' => 'gd',

	/*
	|--------------------------------------------------------------------------
	| Upload image resolutions
	|--------------------------------------------------------------------------
	|
	| Here you can determine the size of the downloaded files
	|
	*/

	'ratio' => [
		'image' => [ 1920, 1080 ],
		'thumbnail' => [ 400, 400 ],
	],

];
