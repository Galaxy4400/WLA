<?php

namespace App\Repositories;

use App\Models\Admin;

class AdminRepository
{
	/**
	 * Get all admins with pagination
	 * 
	 * @var int|null $perPage
	 * @return Collection
	 */
	public function getAllWithPaginate($perPage = null)
	{
		$columns = ['id', 'name', 'login', 'email', 'image'];

		$admins = Admin::query()
			->whereRelation('roles', 'name', '!=', 'Super Admin')
			->select($columns)
			->with('roles:name')
			->paginate($perPage);

		return $admins;
	}

}
