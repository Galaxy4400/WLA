<?php

namespace App\Contracts\Filesystem;

interface ModelImage
{
	/**
	 * Create images to the model
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @var array $validatedData
	 * @var string $targetPath
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function createImage($model, $validatedData, $targetPath);


	/**
	 * Update images to the model
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @var array $validatedData
	 * @var string $targetPath
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function updateImage($model, $validatedData, $targetPath);


	/**
	 * Delete images of the model
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @return void
	 */
	public function deleteImage($model);
}
