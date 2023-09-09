<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;


class RoleService
{
	/**
	 * Process of new role creating
	 * 
	 * @var array $requestData
	 *
	 * @return \App\Models\Role
	 */
	public function createRoleProcess($requestData)
	{
		$role = $this->createRole($requestData);

		flash('role_created');

		return $role;
	}


	/**
	 * Process of new role updating
	 * 
	 * @var array $requestData
	 * @var App\Models\Role $role
	 *
	 * @return App\Models\Role
	 */
	public function updateRoleProcess($requestData, $role)
	{
		$this->updateRole($requestData, $role);

		flash('role_updated');

		return $role;
	}


	/**
	 * Process of new role deleting
	 * 
	 * @var App\Models\Role $role
	 *
	 * @return void
	 */
	public function deleteRoleProcess($role): void
	{
		if ($role->users->isEmpty()) {
			$role->delete();

			flash('role_deleted');
		} else {
			flash('role_delete_abort');
		}
	}


	/**
	 * Create new role
	 * 
	 * @var array $requestData
	 *
	 * @return App\Models\Role
	 */
	public function createRole($requestData): Role
	{
		try {
			DB::beginTransaction();

			$role = Role::create(['name' => $requestData['name']]);
			$role->syncPermissions($requestData['permissions']);

			DB::commit();

			return $role;

		} catch (\Throwable $th) {
			DB::rollBack();

			throw $th;
		}
	}


	/**
	 * Update of existing role
	 * 
	 * @var array $requestData
	 * @var App\Models\Role $role
	 *
	 * @return App\Models\Role
	 */
	public function updateRole($requestData, $role): Role
	{
		try {
			DB::beginTransaction();

			$role->name = $requestData['name'];
			$role->save();
	
			$role->syncPermissions($requestData['permissions']);

			DB::commit();

			return $role;

		} catch (\Throwable $th) {
			DB::rollBack();

			throw $th;
		}
	}
}
