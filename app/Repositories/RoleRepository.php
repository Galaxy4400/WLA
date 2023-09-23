<?php

namespace App\Repositories;

use App\Permissions\AdminPermissions;
use Spatie\Permission\Models\Role;

class RoleRepository
{
	/**
	 * Get all roles with pagination
	 * 
	 * @return Collection
	 */
	public function getAllWithPaginate($perPage = null)
	{
		$columns = ['id', 'name'];

		$roles = Role::query()
			->with(['users:login'])
			->select($columns)
			->where('name', '!=', 'Super Admin')
			->paginate($perPage);

		return $roles;
	}


	/**
	 * Get all roles for selector
	 * 
	 * @return Array
	 */
	public function getForSelector()
	{
		$roles = Role::query()
			->where('name', '!=', 'Super Admin')
			->pluck('name', 'id');

		return $roles;
	}


	/**
	 * Get all permissions divided to groups
	 * 
	 * @return Array
	 */
	public function getAllPermissionsWithGroups()
	{
		return AdminPermissions::groups();
	}

}
