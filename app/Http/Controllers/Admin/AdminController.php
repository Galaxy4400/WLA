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
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->authorizeResource(Admin::class, 'admin');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
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
	 *
	 * @return \Illuminate\Http\Response
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
	 *
	 * @param  App\Http\Requests\Admin\Admin\StoreRequest  $request
	 * @param  App\Services\AdminService  $service
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreRequest $request, AdminService $service)
	{
		$service->createAdminProcess($request);

		return redirect()->route('admin.admins.index');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  App\Models\Admin  $admin
	 * @return \Illuminate\Http\Response
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
	 *
	 * @param  App\Http\Requests\Admin\Admin\UpdateRequest  $request
	 * @param  App\Services\AdminService  $service
	 * @param  App\Models\Admin  $admin
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, AdminService $service, Admin $admin)
	{
		$admin = $service->updateAdminProcess($request, $admin);

		return redirect()->route('admin.admins.edit', compact('admin'));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  App\Models\Admin  $admin
	 * @param  App\Services\AdminService  $service
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Admin $admin, AdminService $service)
	{
		$service->deleteAdminProcess($admin);

		return redirect()->route('admin.admins.index');
	}
}
