<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
	use HasFactory, NodeTrait, HasSlug;

	const CONTENT_BY_EDITOR = 0;
	const CONTENT_BY_PAGE = 1;
	const CONTENT_BY_ROUTE = 2;
	const CONTENT_BY_LINK = 3;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'slug',
		'name',
		'type',
		'page',
		'route',
		'link',
		'content',
		'description',
		'image',
		'thumbnail',
	];

	/**
	 * Get map of page content types
	 */
	public static function getContentTypes()
	{
		return [
			self::CONTENT_BY_EDITOR => 'Редактор контента',
			self::CONTENT_BY_PAGE => 'Переход на другую страницу',
			self::CONTENT_BY_ROUTE => 'Особое содержание',
			self::CONTENT_BY_LINK => 'Ссылка на другой ресурс',
		];
	}

	/**
	 * Get the options for generating the slug.
	 */
	public function getSlugOptions(): SlugOptions
	{
		return SlugOptions::create()
			->generateSlugsFrom('name')
			->saveSlugsTo('slug')
			->doNotGenerateSlugsOnUpdate();
	}

}
