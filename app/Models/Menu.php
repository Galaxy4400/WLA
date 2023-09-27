<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
	use HasFactory, HasSlug;

	public const TYPE_CUSTOM = 0;
	public const TYPE_PAGES = 1;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'slug',
	];


	/**
	 * Get the options for generating the slug.
	 */
	public function getSlugOptions(): SlugOptions
	{
		return SlugOptions::create()
			->generateSlugsFrom('name')
			->saveSlugsTo('slug')
			->usingSeparator('_');
	}


	/**
	 * Relation with menu items
	 */
	public function items()
	{
		return $this->hasMany(MenuItem::class);
	}


	/**
	 * Get menu types
	 */
	public function types()
	{
		return [
			self::TYPE_CUSTOM => 'Пользовательское меню',
			self::TYPE_PAGES => 'Страницы сайта',
		];
	}
}
