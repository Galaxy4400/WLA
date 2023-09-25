<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Services\Pages\PageService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Page\StoreRequest;
use App\Http\Requests\Admin\Page\UpdateRequest;
use App\Observers\PageObserver;
use App\Repositories\PageRepository;

class PageController extends Controller
{
	/**
	 * @var PageService $service
	 */
	private $service;

	/**
	 * @var PageRepository $repository
	 */
	private $repository;

	/**
	 * Create the controller instance.
	 */
	public function __construct(PageService $service, PageRepository $repository, PageObserver $observer)
	{
		$this->repository = $repository;
		$this->service = $service;

		$this->authorizeResource(Page::class, 'page');

		Page::observe($observer);
	}


	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		return redirect()->route('admin.pages.show', 'home');
	}


	/**
	 * Show the form for creating a new resource.
	 */
	public function create(PageService $service, Page $parent)
	{
		$page = new Page();

		$pagesTree = $this->repository->getPagesTreeForSelector();

		return view('admin.pages.edit', compact('page', 'parent', 'pagesTree'));
	}


	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreRequest $request, Page $parent)
	{
		$page = $this->service->createPage($request, $parent);

		return redirect($page->parent ? route('admin.pages.show', $page->parent->slug) : route('admin.pages.index'));
	}


	/**
	 * Display the specified resource.
	 */
	public function show(Page $parent)
	{
		$pages = $this->repository->getChildrenPages($parent);

		return view('admin.pages.show', compact('pages', 'parent'));
	}


	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Page $page)
	{
		$pagesTree = $this->repository->getPagesTreeForSelector();

		return view('admin.pages.edit', compact('page', 'pagesTree'));
	}


	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateRequest $request, Page $page)
	{
		$this->service->updatePage($request, $page);

		return redirect()->route('admin.pages.edit', compact('page'));
	}


	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Page $page)
	{
		$routeUrl = $this->service->deletePage($page);

		return redirect($routeUrl);
	}


	/**
	 * Move the page up.
	 */
	public function up(Page $page, Page $parent)
	{
		if (!$page->up()) $parent->appendNode($page);

		flash('is_moved');

		return redirect()->route('admin.pages.show', $parent->slug);
	}
	
	
	/**
	 * Move the page down.
	 */
	public function down(Page $page, Page $parent)
	{
		if (!$page->down()) $parent->prependNode($page);

		flash('is_moved');

		return redirect()->route('admin.pages.show', $parent->slug);
	}
}
