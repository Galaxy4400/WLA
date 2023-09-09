<?php

namespace App\Policies;

use App\Models\Admin;
use App\Permissions\AdminPermissions;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view any models.
	 *
	 * @param  \App\Models\Admin  $currentAdmin
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function viewAny(Admin $currentAdmin)
	{
		return $currentAdmin->can(AdminPermissions::CAN_VIEW_ADMINS);
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param  \App\Models\Admin  $currentAdmin
	 * @param  \App\Models\Admin  $admin
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function view(Admin $currentAdmin, Admin $admin)
	{
		//
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\Models\Admin  $currentAdmin
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function create(Admin $currentAdmin)
	{
		return $currentAdmin->can(AdminPermissions::CAN_CREATE_ADMINS);
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\Admin  $currentAdmin
	 * @param  \App\Models\Admin  $admin
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function update(Admin $currentAdmin, Admin $admin)
	{
		return $currentAdmin->can(AdminPermissions::CAN_UPDATE_ADMINS);
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  \App\Models\Admin  $currentAdmin
	 * @param  \App\Models\Admin  $admin
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function delete(Admin $currentAdmin, Admin $admin)
	{
		return $currentAdmin->can(AdminPermissions::CAN_DELETE_ADMINS);
	}
}
