<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Services\Pages\PageService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Page\StoreRequest;
use App\Http\Requests\Admin\Page\UpdateRequest;

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
		$pages = Page::query()->whereIsRoot()->get();

		$types = Page::getContentTypes();

		return view('admin.pages.index', compact('pages', 'types'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(PageService $service)
	{
		$selectors = $service->getDataForSelectors();

		$parent = Page::find(request()->parentId);

		return view('admin.pages.create', [...$selectors, 'parent' => $parent]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  App\Http\Requests\Admin\Page\StoreRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreRequest $request, PageService $service)
	{
		$service->createPageProcess($request, request()->parentId);

		return redirect()->route('admin.pages.index');
	}


	/**
	 * Display the specified resource.
	 * 
	 * @param  App\Models\Page  $page
	 * @return \Illuminate\Http\Response
	 */
	public function show(Page $parent)
	{
		$pages = $parent->children;

		$types = Page::getContentTypes();

		return view('admin.pages.show', compact('pages', 'parent', 'types'));
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
		$service->updatePageProcess($request, $page);

		return redirect()->route('admin.pages.edit', compact('page'));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  App\Models\Page  $page
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(PageService $service, Page $page)
	{
		$service->deletePageProcess($page);

		return redirect()->route('admin.pages.index');
	}
}
