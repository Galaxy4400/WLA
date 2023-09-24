<?php

namespace App\Models;

use App\Services\Traits\HasMultyRelation;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
	use HasMultyRelation;
}
