<?php

namespace App\Providers;

use App\Models\Admin;
use App\Policies\AdminPolicy;
use App\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array<class-string, class-string>
	 */
	protected $policies = [
		Admin::class => AdminPolicy::class,
		Role::class => RolePolicy::class,
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		
		$this->registerPolicies();
		
		// Implicitly grant "Super Admin" role all permissions
		Gate::before(function(Admin $admin) {
			return $admin->hasRole('Super Admin') ? true : null;
		});
	}
}
