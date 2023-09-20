<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Services\Admins\AdminService;
use App\Http\Requests\Admin\Admin\StoreRequest;
use App\Http\Requests\Admin\Admin\UpdateRequest;

class AdminController extends Controller
{
	/**
	 * Create the controller instance.
	 */
	public function __construct()
	{
		$this->authorizeResource(Admin::class, 'admin');
	}


	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$admins = Admin::query()
			->whereRelation('roles', 'name', '!=', 'Super Admin')
			->with('roles')
			->paginate(20);

		return view('admin.admins.index', compact('admins'));
	}


	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$roles = Role::query()
			->where('name', '!=', 'Super Admin')
			->get();

		return view('admin.admins.edit', compact('roles'));
	}


	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreRequest $request, AdminService $service)
	{
		$service->createAdminProcess($request);

		return redirect()->route('admin.admins.index');
	}


	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Admin $admin)
	{
		$roles = Role::query()
			->where('name', '!=', 'Super Admin')
			->get();

		return view('admin.admins.edit', compact('admin', 'roles'));
	}


	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateRequest $request, AdminService $service, Admin $admin)
	{
		$admin = $service->updateAdminProcess($request, $admin);

		return redirect()->route('admin.admins.edit', compact('admin'));
	}


	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Admin $admin, AdminService $service)
	{
		$service->deleteAdminProcess($admin);

		return redirect()->route('admin.admins.index');
	}
}
