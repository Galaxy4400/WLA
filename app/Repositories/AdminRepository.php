<?php

namespace App\Repositories;

use App\Models\Admin as Model;

class AdminRepository extends CoreRepository
{
	/**
	 * @return string
	 */
	protected function getModelClass()
	{
		return Model::class;
	}


	/**
	 * Get all admins with pagination
	 * 
	 * @var int|null $perPage
	 * @return Collection
	 */
	public function getAllWithPaginate($perPage = null)
	{
		$columns = ['id', 'name', 'login', 'email', 'image'];

		$admins = $this->startConditions()->query()
			->whereRelation('roles', 'name', '!=', 'Super Admin')
			->select($columns)
			->with('roles:name')
			->paginate($perPage);

		return $admins;
	}

}
