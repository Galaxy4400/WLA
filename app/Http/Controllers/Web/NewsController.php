<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class NewsController extends Controller
{
	/**
	 * Display an index page of the news.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return 'news';
	}
}
