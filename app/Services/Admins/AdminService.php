<?php

namespace App\Services\Admins;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\Traits\HasImage;

class AdminService
{
	use HasImage;

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
		$this->deleteImage($admin);

		$admin->delete();
	}


	/**
	 * Create new admin
	 * 
	 * @var array $validatedData
	 * @return App\Models\Admin
	 */
	public function createAdmin($validatedData): Admin
	{
		$validatedData['password'] = $this->defineOriginPassword($validatedData);

		$this->imageCreating($validatedData, 'images/avatars');
		
		try {
			DB::beginTransaction();

			$admin = Admin::create($validatedData);
			$admin->syncRoles($validatedData['role']);

			DB::commit();

			return $admin;

		} catch (\Throwable $th) {
			DB::rollBack();

			$this->deleteImage($validatedData);
			
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
		if ($this->isNewPassword($validatedData)) {
			$validatedData['password'] = $this->defineOriginPassword($validatedData);
		}

		$this->imageUpdating($admin, $validatedData, 'images/avatars');

		try {
			DB::beginTransaction();

			$admin->syncRoles($validatedData['role']);
			$admin->update($validatedData);

			DB::commit();

			return $admin;
			
		} catch (\Throwable $th) {
			DB::rollBack();

			$this->deleteImage($validatedData);

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
		return isset($validatedData['password_random']) ? Str::random(10) : $validatedData['password'];
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
}
