<?php

namespace App\Http\Controllers\Web;

use App\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class MainController extends Controller
{
	/**
	 * Display an index page
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$pages = Page::all();

		return view('web.index', compact('pages'));
	}


	/**
	 * Display the specified page
	 *
	 * @param  App\Models\Page  $page
	 * @return \Illuminate\Http\Response
	 */
	public function page(Page $page)
	{
		

		return 'page';
	}

}
