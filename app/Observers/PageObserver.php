<?php

namespace App\Observers;

use App\Models\Page;

class PageObserver
{
	/**
	 * Handle the Page "saving" event.
	 */
	public function saving(Page $page): void
	{
		if ($page->isClean() && !is_flash('message')) {
			flash('no_changes');
		}
	}
		
	/**
	 * Handle the Page "saved" event.
	 */
	public function saved(Page $page): void
	{
		if ($page->isDirty() && !is_flash('message')) {
			flash('page_updated');
		}
	}
	
	/**
	 * Handle the Page "created" event.
	 */
	public function created(Page $page): void
	{
		flash('page_created');
	}

	/**
	 * Handle the Page "updated" event.
	 */
	public function updated(Page $page): void
	{
		flash('page_updated');
	}

	/**
	 * Handle the Page "deleted" event.
	 */
	public function deleted(Page $page): void
	{
		flash('page_deleted');
	}
}
