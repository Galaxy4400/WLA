<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$superAdmin = Admin::factory()->create([
			'name' => 'Super Admin',
			'post' => 'Webis',
			'login' => 'Webis',
			'email' => 'webis@laravel.admin',
			'password' => bcrypt('1234'),
		]);

		$admin = Admin::factory()->create([
			'name' => 'Иванов Иван Иванович',
			'post' => 'Директор',
			'login' => 'Admin',
			'email' => 'ivanov@ivan.ru',
			'password' => bcrypt('1234'),
		]);
		
		$superAdmin->assignRole('Super Admin');
		$admin->assignRole('Администратор');
	}
}