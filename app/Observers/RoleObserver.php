<?php

namespace App\Observers;

use App\Models\Role;


class RoleObserver
{
	/**
	 * Handle the Role "saving" event.
	 */
	public function saving(Role $role)
	{
		if ($role->isClean() && !$role->isAnyRelationChanged) {
			flash('no_changes');
			return false;
		}
	}
		
	/**
	 * Handle the Role "saved" event.
	 */
	public function saved(Role $role): void
	{
		if ($role->isAnyRelationChanged) {
			flash('role_updated');
		}
	}
	
	/**
	 * Handle the Role "created" event.
	 */
	public function created(Role $role): void
	{
		flash('role_created');
	}

	/**
	 * Handle the Role "updated" event.
	 */
	public function updated(Role $role): void
	{
		flash('role_updated');
	}

	/**
	 * Handle the Role "deleting" event.
	 */
	public function deleting(Role $role)
	{
		if (!$role->users->isEmpty()) {
			flash('role_delete_abort');
			return false;
		}
	}

	/**
	 * Handle the Role "deleted" event.
	 */
	public function deleted(Role $role): void
	{
		flash('role_deleted');
	}
}
