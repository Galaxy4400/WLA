<?php

namespace App\Services\Traits;

/**
 * This trait helps to recognise if some many-to-many relation of model has been changed.
 * In order to work correctly, it is necessary to add in corespond model additional field - isMultyRelationChanged
 */
trait MultyRelationWatcher
{
	/**
	 * Musty relation watcher
	 * 
	 * @var Illuminate\Database\Eloquent\Model $model
	 * @var string $relation
	 * @var mix $selectedValues
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
