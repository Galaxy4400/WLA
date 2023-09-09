<?php

namespace App\Permissions;


class AdminPermissions
{
	/**
	 * Collection of administration permissions
	 */
	public const CAN_VIEW_ADMINS = 'view admins';
	public const CAN_CREATE_ADMINS = 'create admins';
	public const CAN_UPDATE_ADMINS = 'update admins';
	public const CAN_DELETE_ADMINS = 'delete admins';

	public const CAN_VIEW_ROLES = 'view roles';
	public const CAN_CREATE_ROLES = 'create roles';
	public const CAN_UPDATE_ROLES = 'update roles';
	public const CAN_DELETE_ROLES = 'delete roles';

	public const CAN_VIEW_PAGES = 'view pages';
	public const CAN_CREATE_PAGES = 'create pages';
	public const CAN_UPDATE_PAGES = 'update pages';
	public const CAN_DELETE_PAGES = 'delete pages';
	

	/**
	 * Returns all admin permissions
	 */
	static public function all(): array
	{
		return [
			self::CAN_VIEW_ADMINS,
			self::CAN_CREATE_ADMINS,
			self::CAN_UPDATE_ADMINS,
			self::CAN_DELETE_ADMINS,

			self::CAN_VIEW_ROLES,
			self::CAN_CREATE_ROLES,
			self::CAN_UPDATE_ROLES,
			self::CAN_DELETE_ROLES,

			self::CAN_VIEW_PAGES,
			self::CAN_CREATE_PAGES,
			self::CAN_UPDATE_PAGES,
			self::CAN_DELETE_PAGES,
		];
	}


	/**
	 * Returns structure of all admin permissions
	 */
	static public function groups(): array
	{
		return [
			[
				'name' => 'Admins',
				'permissions' => [
					self::CAN_VIEW_ADMINS,
					self::CAN_CREATE_ADMINS,
					self::CAN_UPDATE_ADMINS,
					self::CAN_DELETE_ADMINS,
				],
			],
			[
				'name' => 'Roles',
				'permissions' => [
					self::CAN_VIEW_ROLES,
					self::CAN_CREATE_ROLES,
					self::CAN_UPDATE_ROLES,
					self::CAN_DELETE_ROLES,
				],
			],
			[
				'name' => 'Pages',
				'permissions' => [
					self::CAN_VIEW_PAGES,
					self::CAN_CREATE_PAGES,
					self::CAN_UPDATE_PAGES,
					self::CAN_DELETE_PAGES,
				],
			],
		];
	}
	
}
