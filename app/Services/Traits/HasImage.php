<?php

namespace App\Services\Traits;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


/**
 * In order for this trait to work correctly, it is necessary that the model has the image and thumbnail fields.
 * In order for images to be deleted, the image_delete parameter must be passed in the request.
 */
trait HasImage
{
	/**
	 * Create images to the model and add data to the validationData array
	 * 
	 * @var array $validatedData
	 * @var string $targetPath
	 * @return void
	 */
	public function imageCreating(&$validatedData, $targetPath): void
	{
		if ($this->isImageLoading($validatedData)) {
			$this->createImage($validatedData, $targetPath);
		}
	}


	/**
	 * Update images to the model and add data to the validationData array
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @var array $validatedData
	 * @var string $targetPath
	 * @return void
	 */
	public function imageUpdating($model, &$validatedData, $targetPath): void
	{
		if ($this->isImageLoading($validatedData)) {
			$this->deleteImage($model);
			$this->createImage($validatedData, $targetPath);
		}
		
		if ($this->isImageDeleting($validatedData)) {
			$this->deleteImage($model);

			$validatedData['thumbnail'] = null;
			$validatedData['image'] = null;
		}
	}


	/**
	 * Create image
	 * 
	 * @var array $validatedData
	 * @var string $targetPath
	 * @return void
	 */
	public function createImage(&$validatedData, $targetPath): void
	{
		$validatedData['thumbnail'] = $this->makeImage($validatedData['image'], $targetPath, ...config('image.ratio.thumbnail'));
		$validatedData['image'] = $this->makeImage($validatedData['image'], $targetPath, ...config('image.ratio.image'));
	}


	/**
	 * Delete images of the model
	 * 
	 * @var Illuminate\Database\Eloquent\Model|array $object
	 * @return void
	 */
	public function deleteImage($object): void
	{
		if ($object instanceof Model) {
			$image = $object->image;
			$thumbnail = $object->thumbnail;
		} else {
			$image = $object['image'];
			$thumbnail = $object['thumbnail'];
		}

		if ($image) {
			Storage::delete($image);
		}

		if ($thumbnail) {
			Storage::delete($thumbnail);
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
	public function isImageDeleting($validatedData): bool
	{
		if (isset($validatedData['image_delete'])) {
			return true;
		}

		return false;
	}
}
