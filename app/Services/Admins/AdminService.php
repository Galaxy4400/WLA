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

class AdminService
{
	/**
	 * Temp property of new admin password before crypting for notification sending
	 */
	public string $originPassword;

	/**
	 * Temp email property of deleted admin for notification sending
	 */
	public string $deletedAdminEmail;

	/**
	 * Temp avatar property of deleted admin for delete after deletting
	 */
	public string $deletedAdminAvatar;


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
		$this->deletedAdminAvatar = $admin->avatar;

		$admin->delete();

		$this->sendDeletedNotification($this->deletedAdminEmail);

		Storage::delete($this->deletedAdminAvatar);

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
		$createData = collect([
			'name' => $validatedData['name'],
			'post' => $validatedData['post'],
			'email' => $validatedData['email'],
			'login' => $validatedData['login'],
		]);

		$createData->put('password', bcrypt($this->defineOriginPassword($validatedData)));
		
		if ($this->isNewAvatar($validatedData)) {
			$avatar = $this->saveAvatar($validatedData['avatar']);
			$createData->put('avatar', $avatar);
		}
		
		try {
			DB::beginTransaction();

			$admin = Admin::create($createData->toArray());
			$admin->syncRoles($validatedData['role']);

			DB::commit();

			return $admin;

		} catch (\Throwable $th) {
			DB::rollBack();

			if ($avatar) {
				Storage::delete($avatar);
			}

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
		$updateData = collect([
			'name' => $validatedData['name'],
			'post' => $validatedData['post'],
			'email' => $validatedData['email'],
			'login' => $validatedData['login'],
		]);

		if ($this->isNewPassword($validatedData)) {
			$updateData->put('password', bcrypt($this->defineOriginPassword($validatedData)));
		} else {
			$this->originPassword = "Старый пароль";
		}

		if ($this->isNewAvatar($validatedData)) {
			$oldAvatar = $admin->avatar;
			$newAvatar = $this->saveAvatar($validatedData['avatar']);
			$updateData->put('avatar', $newAvatar);
		}

		if ($this->isRemoveAvatar($validatedData)) {
			Storage::delete($admin->avatar);
			$updateData->put('avatar', null);
		}

		try {
			DB::beginTransaction();
			
			$admin->update($updateData->toArray());
			$admin->syncRoles($validatedData['role']);

			if (isset($newAvatar) && $oldAvatar) Storage::delete($oldAvatar);

			DB::commit();

			return $admin;
			
		} catch (\Throwable $th) {
			DB::rollBack();

			if ($newAvatar) Storage::delete($newAvatar);

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
	 * Save admin avatar to storage
	 * 
	 * @var Illuminate\Http\UploadedFile $file
	 * @return string
	 */
	public function saveAvatar($file): string
	{
		if (!$file) return null;

		$fileName = $file->store('images/avatars/'.date('Y-m-d'));

		return $fileName;
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
	 * Check if admin gatting new avatar
	 * 
	 * @var array $validatedData
	 * @return bool
	 */
	public function isNewAvatar($validatedData): bool
	{
		if (isset($validatedData['avatar'])) {
			return true;
		}

		return false;
	}


	/**
	 * Check if admin avatar must be deleted
	 * 
	 * @var array $validatedData
	 * @return bool
	 */
	public function isRemoveAvatar($validatedData): bool
	{
		if (isset($validatedData['avatar_remove'])) {
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
