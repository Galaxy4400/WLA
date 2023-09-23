<?php

namespace App\Models;

use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
	/**
	 * The parameter of the state of the relationships
	 * 
	 * @var array $originPassword
	 * 
	 * TODO: Перевести на трейт и сделать массивом $relationsChangeStatus
	 */
	public $isAnyRelationChanged;
}
