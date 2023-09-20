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
	 * @var array $data
	 * @var string $path
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function createImage($model, $data, $path): Model
	{
		if ($this->isImageLoading($data)) {
			$image = $this->makeImage($data['image'], $path, ...config('image.ratio.image'));
			$thumbnail = $this->makeImage($data['image'], $path, ...config('image.ratio.thumbnail'));

			$this->saveModelImageData($model, $image, $thumbnail);
		}

		return $model;
	}


	/**
	 * Update images to the model
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @var array $data
	 * @var string $path
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function updateImage($model, $data, $path): Model
	{
		if ($this->isImageLoading($data)) {
			$this->deleteImage($model);
			
			$newImage = $this->makeImage($data['image'], $path, ...config('image.ratio.image'));
			$newThumbnail = $this->makeImage($data['image'], $path, ...config('image.ratio.thumbnail'));

			$this->saveModelImageData($model, $newImage, $newThumbnail);
		}
		
		if ($this->isDeleteImage($data)) {
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
	public function makeImage($file, $path, $width = null, $height = null): string
	{
		$publicDiscPath = config('filesystems.disks.public.root');

		if(!Storage::exists($path)) Storage::makeDirectory($path);

		$fullImageName = $path . '/' . $this->generateUniqueImageName($file);

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
	 * @var array $data
	 * @return bool
	 */
	public function isImageLoading($data): bool
	{
		if (isset($data['image'])) {
			return true;
		}

		return false;
	}

	
	/**
	 * Check if model image must be deleted
	 * 
	 * @var array $data
	 * @return bool
	 */
	public function isDeleteImage($data): bool
	{
		if (isset($data['delete_image'])) {
			return true;
		}

		return false;
	}
}
