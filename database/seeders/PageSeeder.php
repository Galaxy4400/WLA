<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Page::factory()->count(3)->create(['type' => Page::CONTENT_BY_EDITOR]);
		Page::create([
			'name' => 'Новости',
			'description' => '',
			'content' => route('news'),
			'type' => Page::CONTENT_BY_ROUTE,
		]);
	}
}
