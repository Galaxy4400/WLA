<?php

namespace App\Services\Traits;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
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
	public function createImage($model, $validatedData, $targetPath): Model
	{
		if ($this->isNewImage($validatedData)) {
			$image = $this->saveImage($validatedData['image'], $targetPath, 1920, 1080);
			$thumbnail = $this->saveImage($validatedData['image'], $targetPath, 400, 400);

			$imageData['image'] = $image;
			$imageData['thumbnail'] = $thumbnail;

			$model->update($imageData);
		}

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
	public function updateImage($model, $validatedData, $targetPath): Model
	{
		if ($this->isNewImage($validatedData)) {
			$oldImage = $model->image;
			$oldThumbnail = $model->thumbnail;

			$newImage = $this->saveImage($validatedData['image'], $targetPath, 1920, 1080);
			$newThumbnail = $this->saveImage($validatedData['image'], $targetPath, 400, 400);

			$imageData['image'] = $newImage;
			$imageData['thumbnail'] = $newThumbnail;

			$model->update($imageData);

			if (isset($newImage) && $oldImage) {
				Storage::delete([$oldImage, $oldThumbnail]);
			}
		}
		
		if ($this->isRemoveImage($validatedData)) {
			Storage::delete([$model->image, $model->thumbnail]);

			$imageData['image'] = null;
			$imageData['thumbnail'] = null;

			$model->update($imageData);
		}

		return $model;
	}


	/**
	 * Save model image to storage
	 * 
	 * @var Illuminate\Http\UploadedFile $file
	 * @return string
	 */
	public function saveImage($file, $targetPath, $width = null, $height = null): string
	{
		$publicDiscPath = config('filesystems.disks.public.root');

		if(!Storage::exists($targetPath)) Storage::makeDirectory($targetPath);

		$fullImageName = $targetPath . '/' . $this->generateUniqueImageName($file);

		Image::make($file->path())
			->resize($width, $height, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			})
			->save($publicDiscPath . '/' . $fullImageName);

		return $fullImageName;
	}


	/**
	 * Delete images of the model
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @return void
	 */
	public function deleteImage($model): void
	{
		if ($model->image) {
			Storage::delete($model->image);
		}
		if ($model->thumbnail) {
			Storage::delete($model->thumbnail);
		}
	}


	/**
	 * Return unique generated name
	 * 
	 * @var Illuminate\Http\UploadedFile $file
	 * @return string
	 */
	public function generateUniqueImageName($file): string
	{
		return uniqid(time()) . '.' . $file->extension();
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
