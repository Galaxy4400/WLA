<?php

namespace App\Policies;

use App\Contracts\Permissions\PolicyPermissons;
use App\Models\Admin;
use App\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy implements PolicyPermissons
{
	use HandlesAuthorization;

	public const CAN_VIEW_PAGES = 'view pages';
	public const CAN_CREATE_PAGES = 'create pages';
	public const CAN_UPDATE_PAGES = 'update pages';
	public const CAN_DELETE_PAGES = 'delete pages';

	/**
	 * Return group of permissions
	 *
	 * @return array
	 */
	public function getPermissions()
	{
		return [
			'name' => 'Pages',
			'permissions' => [
				self::CAN_VIEW_PAGES,
				self::CAN_CREATE_PAGES,
				self::CAN_UPDATE_PAGES,
				self::CAN_DELETE_PAGES,
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
		return $admin->can(self::CAN_VIEW_PAGES);
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param  \App\Models\Admin  $admin
	 * @param  \App\Models\Page  $page
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function view(Admin $admin, Page $page)
	{
		return $admin->can(self::CAN_VIEW_PAGES);
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\Models\Admin  $admin
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function create(Admin $admin)
	{
		return $admin->can(self::CAN_CREATE_PAGES);
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\Admin  $admin
	 * @param  \App\Models\Page  $page
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function update(Admin $admin, Page $page)
	{
		return $admin->can(self::CAN_UPDATE_PAGES);
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  \App\Models\Admin  $admin
	 * @param  \App\Models\Page  $page
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function delete(Admin $admin, Page $page)
	{
		return $admin->can(self::CAN_DELETE_PAGES);
	}
}
