<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\StoreRequest;
use App\Http\Requests\Admin\Role\UpdateRequest;
use App\Permissions\AdminPermissions;
use App\Services\Roles\RoleService;

class RoleController extends Controller
{
	/**
	 * Create the controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->authorizeResource(Role::class, 'role');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$roles = Role::query()
			->with('users')
			->where('name', '!=', 'Super Admin')
			->paginate(20);

		return view('admin.roles.index', compact('roles'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$permissionGroups = AdminPermissions::groups();

		return view('admin.roles.edit', compact('permissionGroups'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  App\Http\Requests\Admin\Role\StoreRequest  $request
	 * @param  App\Services\RoleService  $service
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreRequest $request, RoleService $service)
	{
		$service->createRoleProcess($request);

		return redirect()->route('admin.roles.index');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Spatie\Permission\Models\Role $role
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Role $role)
	{
		$permissionGroups = AdminPermissions::groups();

		return view('admin.roles.edit', compact('role', 'permissionGroups'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  App\Http\Requests\Admin\Role\UpdateRequest  $request
	 * @param  App\Services\RoleService  $service
	 * @param  Spatie\Permission\Models\Role $role
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, RoleService $service, Role $role)
	{
		$service->updateRoleProcess($request, $role);

		return redirect()->route('admin.roles.edit', compact('role'));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Spatie\Permission\Models\Role $role
	 * @param  App\Services\RoleService  $service
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Role $role, RoleService $service)
	{
		$service->deleteRoleProcess($role);
		
		return redirect()->route('admin.roles.index');
	}
}
