<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\StoreRequest;
use App\Http\Requests\Admin\Role\UpdateRequest;
use App\Permissions\AdminPermissions;
use App\Repositories\RoleRepository;
use App\Services\Roles\RoleService;

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
	public function __construct(RoleService $service, RoleRepository $repository)
	{
		$this->service = $service;
		$this->repository = $repository;

		$this->authorizeResource(Role::class, 'role');
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
	public function create()
	{
		$permissionGroups = $this->repository->getAllPermissionsWithGroups();

		return view('admin.roles.edit', compact('permissionGroups'));
	}


	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreRequest $request, RoleService $service)
	{
		$service->createRoleProcess($request);

		return redirect()->route('admin.roles.index');
	}


	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Role $role)
	{
		$permissionGroups = AdminPermissions::groups();

		return view('admin.roles.edit', compact('role', 'permissionGroups'));
	}


	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateRequest $request, RoleService $service, Role $role)
	{
		$service->updateRoleProcess($request, $role);

		return redirect()->route('admin.roles.edit', compact('role'));
	}


	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Role $role, RoleService $service)
	{
		$service->deleteRoleProcess($role);
		
		return redirect()->route('admin.roles.index');
	}
}
