<?php

namespace App\Services\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\DB;


class RoleService
{
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

		$this->permissionsChangeWatcher($role, $validatedData);

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


	/**
	 * Whatch if role whas updated and add parameter to model for observer
	 * 
	 * @var array $validatedData
	 * @return void
	 * 
	 * TODO: Перевести на трейт и сделать массивом $relationsChangeStatus
	 */
	public function permissionsChangeWatcher($role, $validatedData): void
	{
		$curentPermissions = collect($role->permissions->pluck('name'))->sort();
		$selectedPermissions = collect($validatedData['permissions'])->sort();

		if ($curentPermissions->count() > $selectedPermissions->count()) {
			$isDiff = $curentPermissions->diffAssoc($selectedPermissions)->count();
		} else {
			$isDiff = $selectedPermissions->diffAssoc($curentPermissions)->count();
		}

		if ($isDiff) {
			$role->isAnyRelationChanged = true;
		}
	}

}
