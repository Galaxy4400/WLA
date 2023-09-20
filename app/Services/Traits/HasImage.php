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
		if ($this->isImageLoading($validatedData)) {
			$image = $this->makeImage($validatedData['image'], $targetPath, ...config('image.ratio.image'));
			$thumbnail = $this->makeImage($validatedData['image'], $targetPath, ...config('image.ratio.thumbnail'));

			$this->saveModelImageData($model, $image, $thumbnail);
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
		if ($this->isImageLoading($validatedData)) {
			$this->deleteImage($model);
			
			$newImage = $this->makeImage($validatedData['image'], $targetPath, ...config('image.ratio.image'));
			$newThumbnail = $this->makeImage($validatedData['image'], $targetPath, ...config('image.ratio.thumbnail'));

			$this->saveModelImageData($model, $newImage, $newThumbnail);
		}
		
		if ($this->isDeleteImage($validatedData)) {
			$this->deleteImage($model);
			$this->saveModelImageData($model);
		}

		return $model;
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
			Storage::delete([$model->image, $model->thumbnail]);
		}
	}


	/**
	 * Save model image to storage
	 * 
	 * @var Illuminate\Http\UploadedFile $file
	 * @return string
	 */
	public function makeImage($file, $targetPath, $width = null, $height = null): string
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
	 * Prepare image data befor saving to db
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @var string $imageName
	 * @var string $thumbnailName
	 * @return void
	 */
	public function saveModelImageData($model, $imageName = null, $thumbnailName = null): void
	{
		$model->image = $imageName;
		$model->thumbnail = $thumbnailName;

		$model->save();
	}


	/**
	 * Check if model gatting a new image
	 * 
	 * @var array $validatedData
	 * @return bool
	 */
	public function isImageLoading($validatedData): bool
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
	public function isDeleteImage($validatedData): bool
	{
		if (isset($validatedData['image_delete'])) {
			return true;
		}

		return false;
	}
}
