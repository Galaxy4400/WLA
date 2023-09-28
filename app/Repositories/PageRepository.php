<?php

namespace App\Repositories;

use App\Models\Page;

class PageRepository
{
	/**
	 * Get children pages
	 * 
	 * @var App\Models\Page $perPage
	 * @return Collection
	 */
	public function getChildrenPages($parent)
	{
		$columns = ['id', 'slug', 'name'];

		$pages = $parent->children()
			->select($columns)
			->defaultOrder()
			->get();

		return $pages;
	}


	/**
	 * Get pages tree
	 * 
	 * @return Array
	 */
	public function getPagesTree()
	{
		$pagesTree = Page::query()
			->defaultOrder()
			->get()
			->toTree();

		return $pagesTree;
	}

}
