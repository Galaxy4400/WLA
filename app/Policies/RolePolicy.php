<?php

namespace App\Policies;

use App\Models\Admin;
use App\Permissions\AdminPermissions;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view any models.
	 *
	 * @param  \App\Models\Admin  $admin
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function viewAny(Admin $admin)
	{
		return $admin->can(AdminPermissions::CAN_VIEW_ROLES);
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\Models\Admin  $admin
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function create(Admin $admin)
	{
		return $admin->can(AdminPermissions::CAN_CREATE_ROLES);
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
		return $admin->can(AdminPermissions::CAN_UPDATE_ROLES);
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
		return $admin->can(AdminPermissions::CAN_DELETE_ROLES);
	}
}
