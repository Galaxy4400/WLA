<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Page\StoreRequest;
use App\Http\Requests\Admin\Page\UpdateRequest;
use App\Services\Pages\PageService;

class PageController extends Controller
{
	/**
	 * Create the controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->authorizeResource(Page::class, 'page');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$pages = Page::query()->paginate(20);

		return view('admin.pages.index', compact('pages'));
	}
	

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(PageService $service)
	{
		$selectors = $service->getDataForSelectors();

		return view('admin.pages.create', $selectors);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  App\Http\Requests\Admin\Page\StoreRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreRequest $request, PageService $service)
	{
		$requestData = $request->validated();

		$service->createPageProcess($requestData);

		return redirect()->route('admin.pages.index');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  App\Models\Page  $page
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Page $page, PageService $service)
	{
		$selectors = $service->getDataForSelectors();
		
		return view('admin.pages.edit', compact('page'))->with($selectors);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  App\Http\Requests\Admin\Page\UpdateRequest  $request
	 * @param  App\Models\Page  $page
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, PageService $service, Page $page)
	{
		$requestData = $request->validated();

		$service->updatePageProcess($requestData, $page);

		return redirect()->route('admin.pages.edit', compact('page'));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  App\Models\Page  $page
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Page $page)
	{
		$page->delete();

		flash('page_deleted');

		return redirect()->route('admin.pages.index');
	}
}
