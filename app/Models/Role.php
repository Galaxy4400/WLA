<?php

namespace App\Models;

use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
	/**
	 * The parameter indicate if some many-to-many relations has been changed
	 * 
	 * @var array $isMultyRelationChanged
	 */
	public $isMultyRelationChanged;
}
