<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
	use HasFactory, NodeTrait;

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

}
