<?php

namespace App\Services\Roles;

use App\Models\Role;
use App\Services\Traits\HasMultyRelation;
use Illuminate\Support\Facades\DB;


class RoleService
{
	use HasMultyRelation;

	/**
	 * Create new role
	 */
	public function createRole($request): Role
	{
		$validatedData = $request->validated();

		try {
			DB::beginTransaction();

			$role = Role::create(['name' => $validatedData['name']]);
			$role->syncPermissions($validatedData['permissions']);

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
	public function updateRole($request, $role): Role
	{
		$validatedData = $request->validated();

		$role->multyRelationWatcher($role, 'permissions', $validatedData['permissions'], 'name');

		try {
			DB::beginTransaction();

			$role->name = $validatedData['name'];
			$role->save();
	
			$role->syncPermissions($validatedData['permissions']);

			DB::commit();

			return $role;

		} catch (\Throwable $th) {
			DB::rollBack();

			throw $th;
		}
	}


	/**
	 * Delete role
	 */
	public function deleteRole($role): void
	{
		$role->delete();
	}

}
