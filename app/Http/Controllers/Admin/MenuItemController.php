<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuItem\StoreRequest;
use App\Http\Requests\Admin\MenuItem\UpdateRequest;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
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

		$pagesTree = $pageRepository->getPagesTree();

		$routes = config('routing.special');

		$openTypes = MenuItem::getOpenTypes();

		return view('admin.menus.item-edit', compact('menu', 'menuItem', 'itemTypes', 'menuTree', 'pagesTree', 'routes', 'openTypes'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreRequest $request, Menu $menu)
	{
		$validatedData = $request->validated();

		$parent = MenuItem::findOrFail($validatedData['parent_id']);
		
		MenuItem::create($validatedData, $parent);

		flash('menu_item_created');

		return redirect()->route('admin.menu.show', $menu->slug);
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

		return redirect()->route('admin.menu.show', $menu->slug);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Menu $menu, MenuItem $menuItem)
	{
		$menuItem->delete();

		flash('menu_item_deleted');

		return redirect()->route('admin.menu.show', $menu->slug);
	}

	
	/**
	 * Move the menu item up.
	 */
	public function up(Menu $menu, MenuItem $item)
	{
		$this->doItemUp($item);

		flash('is_moved');

		return redirect()->route('admin.menu.show', $menu->slug);
	}
	
	
	/**
	 * Move the menu item down.
	 */
	public function down(Menu $menu, MenuItem $item)
	{
		$this->doItemDown($item);

		flash('is_moved');

		return redirect()->route('admin.menu.show', $menu->slug);
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

		return redirect()->route('admin.menu.show', $menu->slug);
	}
	
	
	/**
	 * Move the menu item down.
	 */
	public function deep(Menu $menu, MenuItem $item)
	{
		$isMoved =  $this->doItemDeep($item);

		$isMoved ? flash('is_moved') : flash('no_moved');

		return redirect()->route('admin.menu.show', $menu->slug);
	}


	/**
	 * Create menu items by pages structure
	 */
	public function integratePagesItems(Menu $menu)
	{
		$menuRootItem = $menu->items()->whereNull('parent_id')->first();

		$pageRoot = Page::whereNull('parent_id')->first();

		$this->storePageItems($pageRoot, $menuRootItem, $menu);

		return redirect()->route('admin.menu.show', $menu->slug);
	}


	/**
	 * Store page structure in menu
	 */
	public function storePageItems($parentPage, $menuParentItem, $menu): bool
	{
		$pages = $parentPage->load('children')->children;

		foreach ($pages as $page) {
			$createData['menu_id'] = $menu->id;
			$createData['name'] = $page->name;
			$createData['type'] = MenuItem::TYPE_PAGE;
			$createData['source'] = $page->slug;
			$createData['open_type'] = MenuItem::CURRENT_WINDOW;

			$menuItem = MenuItem::create($createData, $menuParentItem);

			$this->storePageItems($page, $menuItem, $menu);
		}

		return true;
	}

}