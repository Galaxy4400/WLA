<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Page;
use App\Permissions\AdminPermissions;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
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
		return $admin->can(AdminPermissions::CAN_VIEW_PAGES);
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
		return $admin->can(AdminPermissions::CAN_VIEW_PAGES);
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\Models\Admin  $admin
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function create(Admin $admin)
	{
		return $admin->can(AdminPermissions::CAN_CREATE_PAGES);
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
		return $admin->can(AdminPermissions::CAN_UPDATE_PAGES);
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
		return $admin->can(AdminPermissions::CAN_DELETE_PAGES);
	}
}
