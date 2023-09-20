<?php

namespace App\Services\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasParent
{
	/**
	 * Process model parent changing
	 * 
	 * @var array $validatedData
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @return bool
	 */
	public function parentProcess($validatedData, $model): Model
	{
		if ($this->isParentChanged($validatedData, $model)) {
			$this->changeParent($validatedData, $model);
		}

		return $model;
	}


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
		$modelClass = get_class($model);

		$parent = $modelClass::findOrFail($validatedData['parent_id']);

		$parent->appendNode($model);

		return $model;
	}
}
