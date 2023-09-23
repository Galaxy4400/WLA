<?php

namespace App\Permissions;

use App\Policies\AdminPolicy;
use App\Policies\PagePolicy;
use App\Policies\RolePolicy;

class AdminPermissions
{
	protected array $groupedPermissions;

	/**
	 * AdminPermission constructor
	 */
	public function __construct(
		AdminPolicy $adminPolicy,
		RolePolicy $rolePolicy,
		PagePolicy $pagePolicy
	)
	{
		foreach (func_get_args() as $policy) {
			$permissionsGroup[] = $policy->getPermissions();
		}

		$this->groupedPermissions = $permissionsGroup;
	}


	/**
	 * Get all gruped permissions
	 * 
	 * @return array
	 */
	public function getGroupedPermissions() {
		return $this->groupedPermissions;
	}


	/**
	 * Get all permissions
	 * 
	 * @return array
	 */
	public function getAllPermissions() {
		return collect($this->groupedPermissions)
			->pluck('permissions')
			->collapse()
			->toArray();
	}
	
}
