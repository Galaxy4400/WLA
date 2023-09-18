<?php

namespace App\Contracts\Filesystem;

interface ModelImage
{
	/**
	 * Create images to the model
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @var array $data
	 * @var string $path
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function createImage($model, array $data = [], string $path = "");


	/**
	 * Update images to the model
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @var array $data
	 * @var string $path
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function updateImage($model, array $data = [], string $path = "");


	/**
	 * Delete images of the model
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @return void
	 */
	public function deleteImage($model);
}
