<?php

namespace App\Services\Traits;

/**
 * This trait helps to recognise if some many-to-many relation of model has been changed.
 * multyRelationWatcher method should be call before model updating
 * If multy relations has been tchanged you can to check this by $model->isMultyRelationChanged.
 */
trait HasMultyRelation
{
	/**
	 * The parameter indicate if some many-to-many relations has been changed
	 * 
	 * @var array $originPassword
	 */
	public $isMultyRelationChanged;

	/**
	 * Musty relation watcher
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @var string $relation
	 * @var mixed $selectedValues
	 * @var string $comparingField
	 * @return void
	 */
	public function multyRelationWatcher($model, $relation, $selectedValues, $comparingField = 'id')
	{
		$curentValues = collect($model->$relation->pluck($comparingField))->sort()->values();
		$selectedValues = collect($selectedValues)->sort()->values();

		if ($curentValues->count() > $selectedValues->count()) {
			$isDiff = $curentValues->diffAssoc($selectedValues)->isNotEmpty();
		} else {
			$isDiff = $selectedValues->diffAssoc($curentValues)->isNotEmpty();
		}

		if ($isDiff) {
			$model->isMultyRelationChanged = true;
		}
	}
}
