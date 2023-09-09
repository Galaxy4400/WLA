<?php

namespace App\Http\Middleware;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
	/**
	 * Get the path the user should be redirected to when they are not authenticated.
	 */
	protected function redirectTo(Request $request): ?string
	{
		if (!$request->expectsJson()) {

			if (Str::startsWith($request->path(), 'admin')) {
				return route('admin.login.form');
			}

			return route('login.form');
		}
	}
}
