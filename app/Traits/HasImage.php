<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasImage
{
	/**
	 * Create images to the model
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @var array $validatedData
	 * @var string $targetPath
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function createImage($model, $validatedData, $targetPath)
	{
		$imageData = collect();

		if ($this->isNewImage($validatedData)) {
			$image = $this->saveImage($validatedData['image'], $targetPath);
			$imageData->put('image', $image);
		}

		$model->update($imageData);

		return $model;
	}


	/**
	 * Update images to the model
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @var array $validatedData
	 * @var string $targetPath
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function updateImage($model, $validatedData, $targetPath)
	{
		$imageData = collect();

		if ($this->isNewImage($validatedData)) {
			$oldImage = $model->image;
			$newImage = $this->saveImage($validatedData['image'], $targetPath);
			$imageData->put('image', $newImage);
		}

		if ($this->isRemoveImage($validatedData)) {
			Storage::delete($model->image);
			$imageData->put('image', null);
		}

		$model->update($imageData);

		if (isset($newImage) && $oldImage) Storage::delete($oldImage);

		return $model;
	}


	/**
	 * Delete images of the model
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @return void
	 */
	public function deleteImage($model)
	{
		Storage::delete($model->image);
	}


	/**
	 * Save model image to storage
	 * 
	 * @var Illuminate\Http\UploadedFile $file
	 * @return string
	 */
	public function saveImage($file, $targetPath): string
	{
		if (!$file) return null;

		$fileName = $file->store($targetPath);

		return $fileName;
	}


	/**
	 * Check if model gatting a new image
	 * 
	 * @var array $validatedData
	 * @return bool
	 */
	public function isNewImage($validatedData): bool
	{
		if (isset($validatedData['image'])) {
			return true;
		}

		return false;
	}

	
	/**
	 * Check if model image must be deleted
	 * 
	 * @var array $validatedData
	 * @return bool
	 */
	public function isRemoveImage($validatedData): bool
	{
		if (isset($validatedData['image_remove'])) {
			return true;
		}

		return false;
	}
}
