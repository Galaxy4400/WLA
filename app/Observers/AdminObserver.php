<?php

namespace App\Observers;

use App\Models\Admin;
use App\Notifications\AdminEditNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminAuthDataNotification;


class AdminObserver
{
	/**
	 * Handle the Admin "saving" event.
	 */
	public function saving(Admin $admin)
	{
		if ($admin->isClean() && !$admin->isAnyRelationChanged) {
			flash('no_changes');
			return false;
		}
	}
	
	/**
	 * Handle the Admin "saved" event.
	 */
	public function saved(Admin $admin): void
	{
		if ($admin->isAnyRelationChanged) {
			flash('admin_updated');
		}
	}

	/**
	 * Handle the Admin "creating" event.
	 */
	public function creating(Admin $admin): void
	{
		$this->cryptingPassword($admin);
	}
	
	/**
	 * Handle the Admin "created" event.
	 */
	public function created(Admin $admin): void
	{
		$this->sendCreatedNotification($admin);

		flash('admin_created');
	}

	/**
	 * Handle the Admin "updating" event.
	 */
	public function updating(Admin $admin): void
	{
		if ($admin->isDirty('password')) {
			$this->cryptingPassword($admin);
		}
	}

	/**
	 * Handle the Admin "updated" event.
	 */
	public function updated(Admin $admin): void
	{
		if ($admin->isDirty('password') || $admin->isDirty('login')) {
			$this->sendUpdatedNotification($admin);
		}

		flash('admin_updated');
	}

	/**
	 * Handle the Admin "deleted" event.
	 */
	public function deleted(Admin $admin): void
	{
		flash('admin_deleted');
	}



	/**
	 * Crypting password
	 */
	protected function cryptingPassword($admin): void
	{
		$admin->originPassword = $admin->password;

		$admin->password = bcrypt($admin->password);
	}


	/**
	 * Departure message after creating a new administrator
	 */
	protected function sendCreatedNotification($admin): void
	{
		Notification::route('mail', $admin->email)
			->notify(new AdminAuthDataNotification($admin));
	}


	/**
	 * Departure Message after updating an administrator
	 */
	public function sendUpdatedNotification($admin): void
	{
		Notification::route('mail', $admin->email)
			->notify(new AdminEditNotification($admin));
	}
}
