<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;


trait HasNest
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


	/**
	 * Move item up by the tree
	 * 
	 * @var Illuminate\Database\Eloquent\Model $item
	 * @return void
	 */
	public function doItemUp($item): void
	{
		if (!$item->up()) $item->parent->appendNode($item);
	}


	/**
	 * Move item down by the tree
	 * 
	 * @var Illuminate\Database\Eloquent\Model $item
	 * @return void
	 */
	public function doItemDown($item): void
	{
		if (!$item->down()) $item->parent->prependNode($item);
	}


	/**
	 * Move item high by the tree
	 * 
	 * @var Illuminate\Database\Eloquent\Model $item
	 * @return bool
	 */
	public function doItemHigh($item): bool
	{
		$parent = $item->parent;

		if ($parent) {
			$item->insertAfterNode($parent);
			return true;
		}

		return false;
	}


	/**
	 * Move item deep by the tree
	 * 
	 * @var Illuminate\Database\Eloquent\Model $item
	 * @return bool
	 */
	public function doItemDeep($item): bool
	{
		$previous = $item->getPrevSibling();

		if ($previous) {
			$previous->appendNode($item);
			return true;
		}

		return false;
	}
}
