<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Permissions\AdminPermissions;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AdminPermissionsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Reset cached roles and permissions
		app()[PermissionRegistrar::class]->forgetCachedPermissions();

		// Create permissions
		foreach (AdminPermissions::all() as $permission) {
			Permission::findOrCreate($permission);
		}
	}
}
