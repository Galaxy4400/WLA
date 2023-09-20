<?php

namespace App\Services\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasParent
{
	/**
	 * Check if the model parent changed
	 * 
	 * @var array $validatedData
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @return bool
	 */
	public function isParentChanged($validatedData, $model): bool
	{
		return $validatedData['parent_id'] !== (string)$model->parent->id;
	}


	/**
	 * Update of existing model
	 * 
	 * @var array $validatedData
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @return bool
	 */
	public function changeParent($validatedData, $model): Model
	{
		$parent = $model::class::findOrFail($validatedData['parent_id']);

		$parent->appendNode($model);

		return $model;
	}
}
