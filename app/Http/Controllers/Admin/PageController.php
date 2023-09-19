<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
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
		// $pages = Page::query()->whereIsRoot()->defaultOrder()->get();

		// $types = Page::getContentTypes();

		// return view('admin.pages.show', compact('pages', 'types'));
		// return view('admin.pages.show', compact('pages'));

		return redirect()->route('admin.pages.show', 'home');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(PageService $service)
	{
		$pagesTree = Page::defaultOrder()->get()->toTree();

		// $selectors = $service->getDataForSelectors();

		$parent = Page::find(request()->parentId);

		// return view('admin.pages.edit', [...$selectors, 'parent' => $parent]);
		return view('admin.pages.edit', compact('parent', 'pagesTree'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  App\Http\Requests\Admin\Page\StoreRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreRequest $request, PageService $service)
	{
		$parentId = request()->parentId;

		$page = $service->createPageProcess($request, $parentId);

		return redirect($page->parent ? route('admin.pages.show', $page->parent->slug) : route('admin.pages.index'));
	}


	/**
	 * Display the specified resource.
	 * 
	 * @param  App\Models\Page  $page
	 * @return \Illuminate\Http\Response
	 */
	public function show(Page $parent)
	{
		$pages = $parent->children()->defaultOrder()->get();

		// $types = Page::getContentTypes();

		// return view('admin.pages.show', compact('pages', 'parent', 'types'));
		return view('admin.pages.show', compact('pages', 'parent'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  App\Models\Page  $page
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Page $page, PageService $service)
	{
		$pagesTree = Page::defaultOrder()->get()->toTree();

		// $selectors = $service->getDataForSelectors();

		// return view('admin.pages.edit', compact('page'))->with($selectors);
		return view('admin.pages.edit', compact('page', 'pagesTree'));
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
		$routeUrl = $service->deletePageProcess($page);

		return redirect($routeUrl);
	}


	/**
	 * Move the page up.
	 *
	 * @param  App\Models\Page  $page
	 * @return \Illuminate\Http\Response
	 */
	public function up(Page $page)
	{
		if (!$page->up()) $page->parent->appendNode($page);

		flash('is_moved');

		return redirect($page->parent ? route('admin.pages.show', $page->parent->slug) : route('admin.pages.index'));
	}
	
	
	/**
	 * Move the page down.
	 *
	 * @param  App\Models\Page  $page
	 * @return \Illuminate\Http\Response
	 */
	public function down(Page $page)
	{
		if (!$page->down()) $page->parent->prependNode($page);

		flash('is_moved');

		return redirect($page->parent ? route('admin.pages.show', $page->parent->slug) : route('admin.pages.index'));
	}
}
