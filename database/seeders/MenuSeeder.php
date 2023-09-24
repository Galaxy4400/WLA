<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$menu = Menu::create([
			'name' => 'Главное меню',
			'slug' => 'main',
		]);
		
		MenuItem::create([
			'name' => $menu->slug . '_root', 
			'menu_id' => $menu->id
		]);
	}
}
