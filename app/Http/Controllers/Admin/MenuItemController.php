<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuItem\StoreRequest;
use App\Http\Requests\Admin\MenuItem\UpdateRequest;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuItemController extends Controller
{
	/**
	 * Show the form for creating a new resource.
	 */
	public function create(Menu $menu)
	{
		$menuItem = new MenuItem();

		$menuTree = $menu->items()
			->defaultOrder()
			->get()
			->toTree();
			
		return view('admin.menus.item', compact('menu', 'menuItem', 'menuTree'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreRequest $request, Menu $menu)
	{
		$validatedData = $request->validated();
		$validatedData['menu_id'] = $menu->id;

		$parent = MenuItem::findOrFail($validatedData['parent_id']);
		
		MenuItem::create($validatedData, $parent);

		flash('menu_item_created');

		return redirect()->route('admin.menu.show', $menu);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Menu $menu, MenuItem $menuItem)
	{
		$menuTree = $menu->items()
			->defaultOrder()
			->get()
			->toTree();

		return view('admin.menus.item', compact('menu', 'menuItem', 'menuTree'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateRequest $request, MenuItem $menuItem)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Menu $menu, MenuItem $menuItem)
	{
		$menuItem->delete();

		flash('menu_item_deleted');

		return redirect()->route('admin.menu.show', $menu);
	}
}