<?php

namespace Database\Seeders;

use App\Permissions\AdminPermissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminRolesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(AdminPermissions $adminPermissions)
	{
		// Create roles
		Role::create(['name' => 'Super Admin']);

		$adminRole = Role::create(['name' => 'Администратор']);

		$adminRole->givePermissionTo($adminPermissions->getAllPermissions());
	}
}
