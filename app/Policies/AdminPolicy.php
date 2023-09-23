<?php

namespace App\Policies;

use App\Contracts\Permissions\PolicyPermissons;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy implements PolicyPermissons
{
	use HandlesAuthorization;

	public const CAN_VIEW_ADMINS = 'view admins';
	public const CAN_CREATE_ADMINS = 'create admins';
	public const CAN_UPDATE_ADMINS = 'update admins';
	public const CAN_DELETE_ADMINS = 'delete admins';

	/**
	 * Return group of permissions
	 *
	 * @return array
	 */
	public function getPermissions()
	{
		return [
			'name' => 'Admins',
			'permissions' => [
				self::CAN_VIEW_ADMINS,
				self::CAN_CREATE_ADMINS,
				self::CAN_UPDATE_ADMINS,
				self::CAN_DELETE_ADMINS,
			],
		];
	}

	/**
	 * Determine whether the user can view any models.
	 *
	 * @param  \App\Models\Admin  $currentAdmin
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function viewAny(Admin $currentAdmin)
	{
		return $currentAdmin->can(self::CAN_VIEW_ADMINS);
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
		return $currentAdmin->can(self::CAN_CREATE_ADMINS);
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
		return $currentAdmin->can(self::CAN_UPDATE_ADMINS);
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
		return $currentAdmin->can(self::CAN_DELETE_ADMINS);
	}
}
