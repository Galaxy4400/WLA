<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		Schema::defaultStringLength(191);

		Model::preventLazyLoading(!app()->isProduction());
		Model::preventSilentlyDiscardingAttributes(!app()->isProduction());

		DB::whenQueryingForLongerThan(500, function (Connection $connection) {
			// TODO
		});
	}
}
