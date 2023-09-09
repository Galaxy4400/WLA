<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Notifications\AdminEditNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminDeletedNotification;
use App\Notifications\AdminAuthDataNotification;


class AdminService
{
	/**
	 * Temp property of new admin password before crypting for notification sending
	 */
	public string $password;

	/**
	 * Temp property of old admin email before deleting for notification sending
	 */
	public string $email;


	/**
	 * Process of new admin creating
	 * 
	 * @var array $requestData
	 *
	 * @return \App\Models\Admin
	 */
	public function createAdminProcess($requestData)
	{
		$admin = $this->createAdmin($requestData);

		$this->sendCreatedNotification($admin, $this->password);

		flash('admin_created');

		return $admin;
	}


	/**
	 * Process of new admin updating
	 * 
	 * @var array $requestData
	 * @var App\Models\Admin $admin
	 *
	 * @return App\Models\Admin
	 */
	public function updateAdminProcess($requestData, $admin)
	{
		$admin = $this->updateAdmin($requestData, $admin);

		$this->sendUpdatedNotification($admin, $this->password);

		flash('admin_updated');

		return $admin;
	}


	/**
	 * Process of new admin deleting
	 * 
	 * @var App\Models\Admin $admin
	 *
	 * @return void
	 */
	public function deleteAdminProcess($admin): void
	{
		$this->email = $admin->email;

		$this->deleteAdmin($admin);

		$this->sendDeletedNotification($this->email);

		flash('admin_deleted');
	}


	/**
	 * Create new admin
	 * 
	 * @var array $requestData
	 *
	 * @return App\Models\Admin
	 */
	public function createAdmin($requestData): Admin
	{
		$requestData['password'] = bcrypt($this->passwordDeffinition($requestData));

		try {
			DB::beginTransaction();

			$admin = Admin::create($requestData);
			$admin->syncRoles($requestData['role']);

			DB::commit();

			return $admin;

		} catch (\Throwable $th) {
			DB::rollBack();

			throw $th;
		}
	}


	/**
	 * Update of existing admin
	 * 
	 * @var array $requestData
	 * @var App\Models\Admin $admin
	 *
	 * @return App\Models\Admin
	 */
	public function updateAdmin($requestData, $admin): Admin
	{
		if (isset($requestData['password']) || isset($requestData['password_random'])) {
			$requestData['password'] = bcrypt($this->passwordDeffinition($requestData));
		} else {
			unset($requestData['password']);
			$this->password = "Старый пароль";
		}

		try {
			DB::beginTransaction();

			$admin->update($requestData);
			$admin->syncRoles($requestData['role']);

			DB::commit();

			return $admin;
			
		} catch (\Throwable $th) {
			DB::rollBack();

			throw $th;
		}
	}


	/**
	 * Password determination depending on whether it is indicated manually or randomly
	 * 
	 * @var array $requestData
	 *
	 * @return string
	 */
	public function passwordDeffinition($requestData): string
	{
		return $this->password = isset($requestData['password_random']) ? Str::random(10) : $requestData['password'];
	}


	/**
	 * Delete admin
	 * 
	 * @var App\Models\Admin $admin
	 *
	 * @return void
	 */
	public function deleteAdmin($admin): void
	{
		$admin->delete();
	}


	/**
	 * Departure Message after creating a new administrator
	 * 
	 * @var App\Models\Admin $admin
	 * @var string $password
	 *
	 * @return void
	 */
	public function sendCreatedNotification($admin, $password): void
	{
		Notification::route('mail', $admin->email)
			->notify(new AdminAuthDataNotification($admin, $password));
	}


	/**
	 * Departure Message after updating an administrator
	 * 
	 * @var App\Models\Admin $admin
	 * @var string $password
	 *
	 * @return void
	 */
	public function sendUpdatedNotification($admin, $password): void
	{
		Notification::route('mail', $admin->email)
			->notify(new AdminEditNotification($admin, $password));
	}


	/**
	 * Departure Message after deleting an administrator
	 * 
	 * @var App\Models\Admin $admin
	 * @var string $password
	 *
	 * @return void
	 */
	public function sendDeletedNotification($email): void
	{
		Notification::route('mail', $email)
			->notify(new AdminDeletedNotification());
	}
}
