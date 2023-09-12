<?php

namespace App\Services\Admins;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Notifications\AdminEditNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminDeletedNotification;
use App\Notifications\AdminAuthDataNotification;
use Exception;

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
	 * Temp property of old admin avatar before updating for deleting
	 */
	public string $avatar;


	/**
	 * Process of new admin creating
	 * 
	 * @var App\Http\Requests\Admin\Admin\StoreRequest  $request
	 *
	 * @return \App\Models\Admin
	 */
	public function createAdminProcess($request)
	{
		$validatedData = $request->validated();
		
		$admin = $this->createAdmin($validatedData);

		$this->sendCreatedNotification($admin, $this->password);

		flash('admin_created');

		return $admin;
	}


	/**
	 * Process of new admin updating
	 * 
	 * @var App\Http\Requests\Admin\Admin\UpdateRequest  $request
	 * @var App\Models\Admin $admin
	 *
	 * @return App\Models\Admin
	 */
	public function updateAdminProcess($request, $admin)
	{
		$validatedData = $request->validated();

		$admin = $this->updateAdmin($validatedData, $admin);

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
	 * @var array $validatedData
	 *
	 * @return App\Models\Admin
	 */
	public function createAdmin($validatedData): Admin
	{
		$validatedData['password'] = bcrypt($this->passwordDeffinition($validatedData));
		
		if (isset($validatedData['avatar'])) {
			$validatedData['avatar'] = $this->saveAvatar($validatedData['avatar']);
		}
		
		try {
			DB::beginTransaction();

			$admin = Admin::create($validatedData);
			$admin->syncRoles($validatedData['role']);

			DB::commit();

			return $admin;

		} catch (\Throwable $th) {
			DB::rollBack();

			if (isset($validatedData['avatar'])) {
				Storage::delete($validatedData['avatar']);
			}

			throw $th;
		}
	}


	/**
	 * Update of existing admin
	 * 
	 * @var array $validatedData
	 * @var App\Models\Admin $admin
	 *
	 * @return App\Models\Admin
	 */
	public function updateAdmin($validatedData, $admin): Admin
	{
		if (isset($validatedData['password']) || isset($validatedData['password_random'])) {
			$validatedData['password'] = bcrypt($this->passwordDeffinition($validatedData));
		} else {
			unset($validatedData['password']);
			$this->password = "Старый пароль";
		}

		if (isset($validatedData['avatar'])) {
			$this->avatar = $admin->avatar;
			$validatedData['avatar'] = $this->saveAvatar($validatedData['avatar']);
		}

		try {
			DB::beginTransaction();

			$admin->update($validatedData);
			$admin->syncRoles($validatedData['role']);

			if (isset($validatedData['avatar'])) {
				Storage::delete($this->avatar);
			}

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
	 *
	 * @return string
	 */
	public function passwordDeffinition($validatedData): string
	{
		return $this->password = isset($validatedData['password_random']) ? Str::random(10) : $validatedData['password'];
	}


	/**
	 * Save admin avatar to storage
	 * 
	 * @var Illuminate\Http\UploadedFile $file
	 *
	 * @return string
	 */
	public function saveAvatar($file): string
	{
		if (!$file) return null;

		$fileName = $file->store('images/avatars/'.date('Y-m-d'));

		return $fileName;
	}


	/**
	 * Delete admin avatar to storage
	 * 
	 * @var Illuminate\Http\UploadedFile $file
	 *
	 * @return App\Models\Admin
	 */
	public function deleteAvatar($admin): Admin
	{
		if (!$admin->avatar) return $admin;

		Storage::delete($admin->avatar);

		return $admin;
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
