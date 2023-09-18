<?php

namespace App\Services\Pages;

use App\Contracts\Filesystem\ModelImage;
use App\Models\Page;
use App\Services\Traits\HasImage;
use Illuminate\Support\Str;

class PageService implements ModelImage
{
	use HasImage;

	/**
	 * Process of new page creating
	 * 
	 * @var App\Http\Requests\Admin\Page\StoreRequest  $request
	 * @return \App\Models\Page
	 */
	public function createPageProcess($request, $parentId)
	{
		$validatedData = $request->validated();

		$validatedData = $this->prepareRequestData($validatedData);

		$page = $this->createPage($validatedData, $parentId);

		flash('page_created');

		return $page;
	}


	/**
	 * Process of new page updating
	 * 
	 * @var App\Http\Requests\Admin\Page\UpdateRequest  $request
	 * @var App\Models\Page $page
	 * @return App\Models\Page
	 */
	public function updatePageProcess($request, $page)
	{
		$validatedData = $request->validated();
		
		$validatedData = $this->prepareRequestData($validatedData);

		$page = $this->updatePage($validatedData, $page);

		$this->updateImage($page, $validatedData, 'images/pages');

		flash('page_updated');

		return $page;
	}


	/**
	 * Process of new page deleting
	 * 
	 * @var App\Models\Page $page
	 * @return string
	 */
	public function deletePageProcess($page): string
	{
		$redirectUrl = $page->parent ? route('admin.pages.show', $page->parent) : route('admin.pages.index');
		
		$this->deleteImage($page);

		$page->delete();

		flash('page_deleted');

		return $redirectUrl;
	}


	/**
	 * Create new page
	 * 
	 * @var array $validatedData
	 * @return App\Models\Page
	 */
	public function createPage($validatedData, $parentId): Page
	{
		$parent = Page::find($parentId);

		$page = Page::create($validatedData, $parent);

		$this->createImage($page, $validatedData, 'images/pages');

		return $page;
	}


	/**
	 * Update of existing page
	 * 
	 * @var array $validatedData
	 * @var App\Models\Page $page
	 * @return App\Models\Page
	 */
	public function updatePage($validatedData, $page): Page
	{
		$updateData = collect($validatedData)->except('image_remove', 'image');

		$page->update($updateData->toArray());

		return $page;
	}


	/**
	 * Prepare the request data according to the type
	 * 
	 * @var array $validatedData
	 * @return array
	 */
	public function prepareRequestData($validatedData): array
	{
		switch ($validatedData['type']) {

			case Page::CONTENT_BY_EDITOR:
				$validatedData['slug'] = Str::slug($validatedData['name']);
				break;

			case Page::CONTENT_BY_PAGE:
				$validatedData['content'] = route('page', $validatedData['page']);
				$validatedData['slug'] = $validatedData['page'];
				unset($validatedData['page']);
				break;
				
			case Page::CONTENT_BY_ROUTE:
				$validatedData['content'] = route($validatedData['route']);
				$validatedData['slug'] = $validatedData['route'];
				unset($validatedData['route']);
				break;
				
			case Page::CONTENT_BY_LINK:
				$validatedData['content'] = $validatedData['link'];
				$validatedData['slug'] = 'link';
				unset($validatedData['link']);
				break;
		}

		return $validatedData;
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

		$selectors['specialPages'] = config('routing.special');

		return $selectors;
	}
	
}