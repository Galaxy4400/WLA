<?php

use Illuminate\Support\Facades\Route;


/**
 * Get route names of special pages
 * Filters site route collection and leaves only web routers without any middlewares
 */
if (!function_exists('getSpecialPageRouteNames')) {
	function getSpecialPageRouteNames()
	{
		$exclude = ['page', 'sanctum.csrf-cookie'];

		$routeCollection = collect(Route::getRoutes());

		$specialRoutes = $routeCollection->map(function ($route) use ($exclude) {
			$middlewares = $route->gatherMiddleware();
			
			if (count($middlewares) !== 1) return;
			if (!in_array('web', $middlewares)) return;

			$routeName = $route->getName();

			if (!$routeName || in_array($routeName, $exclude)) return;

			return $routeName;
		});

		$specialPageNames = $specialRoutes->filter(function ($route) {
			return $route ?? false;
		});

		return $specialPageNames;
	}
}


