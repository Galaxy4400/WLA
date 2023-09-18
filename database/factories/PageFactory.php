<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{	
		$name = $this->faker->name();

		return [
			'slug' => Str::slug($name),
			'name' => $name,
			'description' => $this->faker->text(30),
			'content' => $this->faker->text(),
			// 'type' => $this->faker->numberBetween(0, 2),
		];
	}
}
