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

	public const CURRENT_WINDOW = 0;
	public const NEW_WINDOW = 1;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'menu_id',
		'type',
		'source',
		'open_type',
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


	/**
	 * Get opening types
	 */
	static public function getOpenTypes()
	{
		return [
			self::CURRENT_WINDOW => 'В текущем окне',
			self::NEW_WINDOW => 'В новом окне',
		];
	}

}
