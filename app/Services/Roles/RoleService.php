<?php

namespace App\Services\Roles;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;


class RoleService
{
	/**
	 * Process of new role creating
	 */
	public function createRoleProcess($request)
	{
		$requestData = $request->validated();

		$role = $this->createRole($requestData);

		flash('role_created');

		return $role;
	}


	/**
	 * Process of new role updating
	 */
	public function updateRoleProcess($request, $role)
	{
		$requestData = $request->validated();
		
		$this->updateRole($requestData, $role);

		flash('role_updated');

		return $role;
	}


	/**
	 * Process of new role deleting
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
