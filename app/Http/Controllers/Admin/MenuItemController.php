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
		return view('admin.menus.item', compact('menu'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreRequest $request, Menu $menu)
	{
		$validatedData = $request->validated();

		$validatedData['menu_id'] = $menu->id;

		MenuItem::create($validatedData);

		return redirect()->route('admin.menu.show', $menu);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(MenuItem $menuItem)
	{
		//
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
	public function destroy(MenuItem $menuItem)
	{
		//
	}
}