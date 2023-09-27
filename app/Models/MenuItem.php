<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
	use HasFactory, NodeTrait;

	public const TYPE_URL = 0;
	public const TYPE_ROUTE = 1;
	public const TYPE_PAGE = 2;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'menu_id',
	];


	/**
	 * Relation with menu
	 */
	public function menu()
	{
		$this->belongsTo(Menu::class);
	}


	/**
	 * Get types of menu item
	 */
	static public function getTypes()
	{
		return [
			self::TYPE_URL => 'Ссылка',
			self::TYPE_ROUTE => 'Маршрут',
			self::TYPE_PAGE => 'Страница',
		];
	}

}
