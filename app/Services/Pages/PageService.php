<?php

namespace App\Services\Pages;

use App\Models\Page;
use Illuminate\Support\Str;

class PageService
{
	/**
	 * Process of new page creating
	 * 
	 * @var App\Http\Requests\Admin\Page\StoreRequest  $request
	 *
	 * @return \App\Models\Page
	 */
	public function createPageProcess($request, $parentId)
	{
		$requestData = $request->validated();

		$requestData = $this->prepareRequestData($requestData);

		$page = $this->createPage($requestData, $parentId);

		flash('page_created');

		return $page;
	}


	/**
	 * Process of new page updating
	 * 
	 * @var App\Http\Requests\Admin\Page\UpdateRequest  $request
	 * @var App\Models\Page $page
	 *
	 * @return App\Models\Page
	 */
	public function updatePageProcess($request, $page): Page
	{
		$requestData = $request->validated();

		$requestData = $this->prepareRequestData($requestData);

		$page->update($requestData);

		flash('page_updated');

		return $page;
	}


	/**
	 * Process of new page deleting
	 * 
	 * @var App\Models\Page $page
	 *
	 * @return void
	 */
	public function deletePageProcess($page): void
	{
		$page->delete();

		flash('page_deleted');
	}


	/**
	 * Create new page
	 * 
	 * @var array $requestData
	 *
	 * @return App\Models\Page
	 */
	public function createPage($requestData, $parentId): Page
	{
		$parent = Page::find($parentId);

		$page = Page::create($requestData, $parent);

		return $page;
	}


	/**
	 * Prepare the request data according to the type
	 * 
	 * @var array $requestData
	 *
	 * @return array
	 */
	public function prepareRequestData($requestData): array
	{
		switch ($requestData['type']) {

			case Page::CONTENT_BY_EDITOR:
				$requestData['slug'] = Str::slug($requestData['name']);
				break;

			case Page::CONTENT_BY_PAGE:
				$requestData['content'] = route('page', $requestData['page']);
				$requestData['slug'] = $requestData['page'];
				unset($requestData['page']);
				break;
				
			case Page::CONTENT_BY_ROUTE:
				$requestData['content'] = route($requestData['route']);
				$requestData['slug'] = $requestData['route'];
				unset($requestData['route']);
				break;
				
			case Page::CONTENT_BY_LINK:
				$requestData['content'] = $requestData['link'];
				$requestData['slug'] = 'link';
				unset($requestData['link']);
				break;
		}

		return $requestData;
	}


	/**
	 * Return data for selectors
	 * 
	 * @return array
	 */
	public function getDataForSelectors(): array
	{
		$selectors['types'] = Page::getContentTypes();

		$selectors['pageList'] = Page::query()->where('type', Page::CONTENT_BY_EDITOR)->get();

		$selectors['specialPages'] = getSpecialPageRouteNames();

		return $selectors;
	}
}
