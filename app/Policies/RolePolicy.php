<?php

namespace App\Policies;

use App\Contracts\Permissions\PolicyPermissons;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy implements PolicyPermissons
{
	use HandlesAuthorization;

	public const CAN_VIEW_ROLES = 'view roles';
	public const CAN_CREATE_ROLES = 'create roles';
	public const CAN_UPDATE_ROLES = 'update roles';
	public const CAN_DELETE_ROLES = 'delete roles';
	
	/**
	 * Return group of permissions
	 *
	 * @return array
	 */
	public function getPermissions()
	{
		return [
			'name' => 'Roles',
			'permissions' => [
				self::CAN_VIEW_ROLES,
				self::CAN_CREATE_ROLES,
				self::CAN_UPDATE_ROLES,
				self::CAN_DELETE_ROLES,
			],
		];
	}

	/**
	 * Determine whether the user can view any models.
	 *
	 * @param  \App\Models\Admin  $admin
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function viewAny(Admin $admin)
	{
		return $admin->can(self::CAN_VIEW_ROLES);
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\Models\Admin  $admin
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function create(Admin $admin)
	{
		return $admin->can(self::CAN_CREATE_ROLES);
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\Admin  $admin
	 * @param  \App\Models\Role  $role
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function update(Admin $admin, Role $role)
	{
		return $admin->can(self::CAN_UPDATE_ROLES);
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  \App\Models\Admin  $admin
	 * @param  \App\Models\Role  $role
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function delete(Admin $admin, Role $role)
	{
		return $admin->can(self::CAN_DELETE_ROLES);
	}
}
