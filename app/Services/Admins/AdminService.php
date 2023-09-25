<?php

namespace App\Services\Admins;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Traits\HasImage;

class AdminService
{
	use HasImage;

	/**
	 * Create new admin
	 * 
	 * @var App\Http\Requests\Admin\Admin\StoreRequest  $request
	 * @return App\Models\Admin
	 */
	public function createAdmin($request): Admin
	{
		$validatedData = $request->validated();
		$validatedData['password'] = $this->defineOriginPassword($validatedData);
		
		try {
			DB::beginTransaction();

			$this->imageCreating($validatedData, 'images/avatars');

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
	 * @var App\Http\Requests\Admin\Admin\UpdateRequest  $request
	 * @var App\Models\Admin $admin
	 * @return App\Models\Admin
	 */
	public function updateAdmin($request, $admin): Admin
	{
		$validatedData = $request->validated();

		if ($this->isNewPassword($validatedData)) {
			$validatedData['password'] = $this->defineOriginPassword($validatedData);
		}

		$admin->multyRelationWatcher($admin, 'roles', $validatedData['role']);

		try {
			DB::beginTransaction();

			$this->imageUpdating($admin, $validatedData, 'images/avatars');

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
	 * Admin delete
	 * 
	 * @var App\Models\Admin $admin
	 * @return void
	 */
	public function deleteAdmin($admin): void
	{
		$this->deleteImage($admin);

		$admin->delete();
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
