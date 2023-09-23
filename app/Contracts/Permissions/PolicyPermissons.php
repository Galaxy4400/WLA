<?php

namespace App\Contracts\Permissions;

interface PolicyPermissons
{
	/**
	 * Return group of permissions
	 *
	 * @return array
	 */
	public function getPermissions();
}
