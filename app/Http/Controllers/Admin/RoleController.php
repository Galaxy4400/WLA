<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Observers\RoleObserver;
use App\Services\Roles\RoleService;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Permissions\AdminPermissions;
use App\Http\Requests\Admin\Role\StoreRequest;
use App\Http\Requests\Admin\Role\UpdateRequest;

class RoleController extends Controller
{
	/**
	 * @var $service
	 */
	private $service;

	/**
	 * @var $repository
	 */
	private $repository;


	/**
	 * Create the controller instance.
	 */
	public function __construct(RoleService $service, RoleRepository $repository, RoleObserver $observer)
	{
		$this->service = $service;
		$this->repository = $repository;

		$this->authorizeResource(Role::class, 'role');

		Role::observe($observer);
	}

	
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$roles = $this->repository->getAllWithPaginate(20);

		return view('admin.roles.index', compact('roles'));
	}


	/**
	 * Show the form for creating a new resource.
	 */
	public function create(AdminPermissions $adminPermissions)
	{
		$permissionGroups = $adminPermissions->getGroupedPermissions();

		return view('admin.roles.edit', compact('permissionGroups'));
	}


	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreRequest $request)
	{
		$this->service->createRole($request);

		return redirect()->route('admin.roles.index');
	}


	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Role $role, AdminPermissions $adminPermissions)
	{
		$permissionGroups = $adminPermissions->getGroupedPermissions();

		return view('admin.roles.edit', compact('role', 'permissionGroups'));
	}


	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateRequest $request, Role $role)
	{
		$this->service->updateRole($request, $role);

		return redirect()->route('admin.roles.edit', compact('role'));
	}


	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Role $role)
	{
		$this->service->deleteRole($role);
		
		return redirect()->route('admin.roles.index');
	}
}
