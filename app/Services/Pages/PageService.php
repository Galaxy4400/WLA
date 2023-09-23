<?php

namespace App\Services\Pages;

use App\Models\Page;
use App\Services\Traits\HasImage;
use App\Services\Traits\HasParent;
use Illuminate\Support\Facades\DB;

class PageService
{
	use HasImage, HasParent;

	/**
	 * Create new page
	 * 
	 * @var App\Http\Requests\Admin\Page\StoreRequest  $request
	 * @var App\Models\Page  $parent
	 * @return App\Models\Page
	 */
	public function createPage($request, $parent): Page
	{
		$validatedData = $request->validated();

		try {
			DB::beginTransaction();

			$this->imageCreating($page, $validatedData, 'images/pages');

			$page = Page::create($validatedData, $parent);

			DB::commit();

			return $page;

		} catch (\Throwable $th) {
			DB::rollBack();

			$this->deleteImage($validatedData);
			
			throw $th;
		}

		return $page;
	}


	/**
	 * Update of existing page
	 * 
	 * @var App\Http\Requests\Admin\Page\StoreRequest  $request
	 * @var App\Models\Page  $page
	 * @return App\Models\Page
	 */
	public function updatePage($request, $page): Page
	{
		$validatedData = $request->validated();

		try {
			DB::beginTransaction();

			$this->imageUpdating($page, $validatedData, 'images/pages');

			$this->parentProcess($validatedData, $page);

			$page->update($validatedData);

			DB::commit();
			
			return $page;
			
		} catch (\Throwable $th) {
			DB::rollBack();

			$this->deleteImage($validatedData);

			throw $th;
		}
	}


	/**
	 * Delete page
	 * 
	 * @var App\Models\Page $page
	 * @return string
	 */
	public function deletePage($page): string
	{
		$redirectUrl = $page->parent ? route('admin.pages.show', $page->parent) : route('admin.pages.index');
		
		$this->deleteImage($page);

		$page->delete();

		return $redirectUrl;
	}

}