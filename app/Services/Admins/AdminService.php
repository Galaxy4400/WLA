<?php

namespace App\Services\Admins;

use App\Contracts\Filesystem\ModelImage;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Notifications\AdminEditNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminDeletedNotification;
use App\Notifications\AdminAuthDataNotification;
use App\Services\Traits\HasImage;

class AdminService implements ModelImage
{
	use HasImage;

	/**
	 * Temp property of new admin password before crypting for notification sending
	 */
	public string $originPassword;

	/**
	 * Temp email property of deleted admin for notification sending
	 */
	public string $deletedAdminEmail;


	/**
	 * Process of new admin creating
	 * 
	 * @var App\Http\Requests\Admin\Admin\StoreRequest  $request
	 * @return \App\Models\Admin
	 */
	public function createAdminProcess($request)
	{
		$validatedData = $request->validated();
		
		$admin = $this->createAdmin($validatedData);

		$this->sendCreatedNotification($admin, $this->originPassword);

		flash('admin_created');

		return $admin;
	}


	/**
	 * Process of new admin updating
	 * 
	 * @var App\Http\Requests\Admin\Admin\UpdateRequest  $request
	 * @var App\Models\Admin $admin
	 * @return App\Models\Admin
	 */
	public function updateAdminProcess($request, $admin)
	{
		$validatedData = $request->validated();

		$admin = $this->updateAdmin($validatedData, $admin);

		$this->sendUpdatedNotification($admin, $this->originPassword);

		flash('admin_updated');

		return $admin;
	}


	/**
	 * Process of new admin deleting
	 * 
	 * @var App\Models\Admin $admin
	 * @return void
	 */
	public function deleteAdminProcess($admin): void
	{
		$this->deletedAdminEmail = $admin->email;

		$this->deleteImage($admin);

		$admin->delete();

		$this->sendDeletedNotification($this->deletedAdminEmail);

		flash('admin_deleted');
	}


	/**
	 * Create new admin
	 * 
	 * @var array $validatedData
	 * @return App\Models\Admin
	 */
	public function createAdmin($validatedData): Admin
	{
		$createData = [
			'name' => $validatedData['name'],
			'post' => $validatedData['post'],
			'email' => $validatedData['email'],
			'login' => $validatedData['login'],
		];

		$createData['password'] = bcrypt($this->defineOriginPassword($validatedData));
		
		try {
			DB::beginTransaction();

			$admin = Admin::create($createData);
			$admin->syncRoles($validatedData['role']);

			$this->createImage($admin, $validatedData, 'images/avatars');

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
	 * @var array $validatedData
	 * @var App\Models\Admin $admin
	 * @return App\Models\Admin
	 */
	public function updateAdmin($validatedData, $admin): Admin
	{
		$updateData = [
			'name' => $validatedData['name'],
			'post' => $validatedData['post'],
			'email' => $validatedData['email'],
			'login' => $validatedData['login'],
		];

		if ($this->isNewPassword($validatedData)) {
			$updateData['password'] = bcrypt($this->defineOriginPassword($validatedData));
		} else {
			$this->originPassword = "Старый пароль";
		}

		try {
			DB::beginTransaction();
			
			$admin->update($updateData);
			$admin->syncRoles($validatedData['role']);

			$this->updateImage($admin, $validatedData, 'images/avatars');

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
	 * @var array $validatedData
	 * @return string
	 */
	public function defineOriginPassword($validatedData): string
	{
		return $this->originPassword = isset($validatedData['password_random']) ? Str::random(10) : $validatedData['password'];
	}


	/**
	 * Check if admin gatting new password
	 * 
	 * @var array $validatedData
	 * @return bool
	 */
	public function isNewPassword($validatedData): bool
	{
		if (isset($validatedData['password']) || isset($validatedData['password_random'])) {
			return true;
		}

		return false;
	}

	
	/**
	 * Departure Message after creating a new administrator
	 * 
	 * @var App\Models\Admin $admin
	 * @var string $password
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
	 * @return void
	 */
	public function sendDeletedNotification($email): void
	{
		Notification::route('mail', $email)
			->notify(new AdminDeletedNotification());
	}
}
