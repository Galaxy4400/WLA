<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Menu\StoreRequest;
use App\Http\Requests\Admin\Menu\UpdateRequest;
use App\Models\MenuItem;

class MenuController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$menus = Menu::all();

		return view('admin.menus.index', compact('menus'));
	}


	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('admin.menus.edit');
	}


	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreRequest $request)
	{
		$validatedData = $request->validated();

		$menu = Menu::create($validatedData);

		MenuItem::create(['name' => $menu->slug . '_root', 'menu_id' => $menu->id]);

		flash('menu_created');

		return redirect()->route('admin.menu.index');
	}


	/**
	 * Display the specified resource.
	 */
	public function show(Menu $menu)
	{
		$menuTree = $menu->items()
			->defaultOrder()
			->get()
			->toTree();

		return view('admin.menus.show', compact('menu', 'menuTree'));
	}


	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Menu $menu)
	{
		return view('admin.menus.edit', compact('menu'));
	}


	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateRequest $request, Menu $menu)
	{
		$validatedData = $request->validated();

		$menu->update($validatedData);

		flash('menu_updated');

		return redirect()->route('admin.menu.edit', $menu);
	}
	

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Menu $menu)
	{
		$menu->delete();

		flash('menu_deleted');

		return redirect()->route('admin.menu.index');
	}
}
