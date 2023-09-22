<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Observers\AdminObserver;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Repositories\AdminRepository;
use App\Services\Admins\AdminService;
use App\Http\Requests\Admin\Admin\StoreRequest;
use App\Http\Requests\Admin\Admin\UpdateRequest;

class AdminController extends Controller
{
	/**
	 * @var AdminService $service
	 */
	private $service;

	/**
	 * @var AdminRepository $repository
	 */
	private $repository;


	/**
	 * Create the controller instance.
	 */
	public function __construct(AdminService $service, AdminRepository $repository, AdminObserver $observer)
	{
		$this->repository = $repository;
		$this->service = $service;

		$this->authorizeResource(Admin::class, 'admin');

		Admin::observe($observer);
	}


	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$admins = $this->repository->getAllWithPaginate(20);

		return view('admin.admins.index', compact('admins'));
	}


	/**
	 * Show the form for creating a new resource.
	 */
	public function create(RoleRepository $roleRepository)
	{
		$roles = $roleRepository->getForSelector();

		return view('admin.admins.edit', compact('roles'));
	}


	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreRequest $request)
	{
		$this->service->createAdmin($request);

		return redirect()->route('admin.admins.index');
	}


	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Admin $admin, RoleRepository $roleRepository)
	{
		$roles = $roleRepository->getForSelector();

		return view('admin.admins.edit', compact('admin', 'roles'));
	}


	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateRequest $request, Admin $admin)
	{
		$admin = $this->service->updateAdmin($request, $admin);

		return redirect()->route('admin.admins.edit', compact('admin'));
	}


	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Admin $admin)
	{
		$this->service->deleteAdmin($admin);

		return redirect()->route('admin.admins.index');
	}
}
