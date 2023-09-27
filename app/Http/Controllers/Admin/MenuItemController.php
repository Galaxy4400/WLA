<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuItem\StoreRequest;
use App\Http\Requests\Admin\MenuItem\UpdateRequest;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Repositories\PageRepository;
use App\Traits\HasNest;

class MenuItemController extends Controller
{
	use HasNest;

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(Menu $menu, PageRepository $pageRepository)
	{
		$menuItem = new MenuItem();

		$itemTypes = MenuItem::getTypes();

		$menuTree = $menu->items()
			->defaultOrder()
			->get()
			->toTree();

		$pagesTree = $pageRepository->getPagesTreeForSelector();

		return view('admin.menus.item-edit', compact('menu', 'menuItem', 'itemTypes', 'menuTree', 'pagesTree'));
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

		return view('admin.menus.item-edit', compact('menu', 'menuItem', 'menuTree'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateRequest $request, Menu $menu, MenuItem $menuItem)
	{
		$validatedData = $request->validated();

		$this->parentProcess($validatedData, $menuItem);

		$menuItem->update($validatedData);

		flash('menu_item_updated');

		return redirect()->route('admin.menu.show', $menu);
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

	
	/**
	 * Move the menu item up.
	 */
	public function up(Menu $menu, MenuItem $item)
	{
		$this->doItemUp($item);

		flash('is_moved');

		return redirect()->route('admin.menu.show', $menu);
	}
	
	
	/**
	 * Move the menu item down.
	 */
	public function down(Menu $menu, MenuItem $item)
	{
		$this->doItemDown($item);

		flash('is_moved');

		return redirect()->route('admin.menu.show', $menu);
	}

	
	/**
	 * Move the menu item up.
	 */
	public function high(Menu $menu, MenuItem $item)
	{
		$isMoved = false;

		if ($item->parent->parent_id) {
			$isMoved = $this->doItemHigh($item);
		}

		$isMoved ? flash('is_moved') : flash('no_moved');

		return redirect()->route('admin.menu.show', $menu);
	}
	
	
	/**
	 * Move the menu item down.
	 */
	public function deep(Menu $menu, MenuItem $item)
	{
		$isMoved =  $this->doItemDeep($item);

		$isMoved ? flash('is_moved') : flash('no_moved');

		return redirect()->route('admin.menu.show', $menu);
	}
}