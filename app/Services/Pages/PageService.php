<?php

namespace App\Services\Pages;

use App\Models\Page;
use Illuminate\Support\Str;

class PageService
{
	/**
	 * Process of new page creating
	 * 
	 * @var array $requestData
	 *
	 * @return \App\Models\Page
	 */
	public function createPageProcess($requestData): Page
	{
		$requestData = $this->prepareRequestData($requestData);

		$page = Page::create($requestData);

		flash('page_created');

		return $page;
	}


	/**
	 * Process of new page updating
	 * 
	 * @var array $requestData
	 * @var App\Models\Page $page
	 *
	 * @return App\Models\Page
	 */
	public function updatePageProcess($requestData, $page): Page
	{
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
	public function deleteAdminProcess($page): void
	{
		$page->delete();

		flash('page_deleted');
	}


	/**
	 * Prepare request data before page process
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
				$requestData['content'] = $requestData['page'];
				unset($requestData['page']);
				break;

			case Page::CONTENT_BY_ROUTE:
				$requestData['content'] = $requestData['route'];
				unset($requestData['route']);
				break;

			case Page::CONTENT_BY_LINK:
				$requestData['content'] = $requestData['link'];
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
