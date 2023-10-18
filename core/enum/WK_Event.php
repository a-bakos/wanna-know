<?php

namespace WK;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

enum WK_Event: int {
	case POST_STATUS_CHANGED     = 100; // User changed the status of a post.
	case POST_TRASHED            = 105; // User moved a post to the trash.
	case POST_UNTRASHED          = 106; // User restored a post from the trash.
	case POST_DELETED            = 107; // User permanently deleted a post from the trash.
	case CATEGORY_CREATED        = 108; // A category has been created.
	case CATEGORY_DELETED        = 109; // A category has been deleted.
	case CATEGORY_EDITED         = 110; // A category has been edited/updated.
	case FILE_UPLOADED           = 208; // User uploaded a file/media item/attachment to the uploads folder.
	case FILE_DELETED            = 209; // User deleted a file/media item/attachment from the uploads folder.
	case PLUGIN_INSTALLED        = 300; // Plugin installed
	case PLUGIN_ACTIVATED        = 301; // Plugin activated
	case PLUGIN_DEACTIVATED      = 302; // Plugin deactivated
	case PLUGIN_UNINSTALLED      = 303; // Plugin uninstalled
	case THEME_ACTIVATED         = 400; // User activated a theme.
	case USER_REGISTERED         = 500; // A new user has been added.
	case USER_DELETED            = 501; // A user has been deleted.
	case USER_ROLE_CHANGED       = 502; // A user's role has changed.
	case USER_PASS_CHANGED       = 503; // A user's password has changed.
	case USER_EMAIL_CHANGED      = 504; // User email change
	case USER_KICKED_OUT         = 505; // User has been kicked out
	case USER_LOGIN              = 506; // The login date.
	case USER_ROLE_CHANGED_MULTI = 507; // Multiple users role has changed.
	case MENU_UPDATED            = 600; // Navigation menu updated.
	case MENU_CREATED            = 601; // Navigation menu created.
	case MENU_DELETED            = 602; // Navigation menu deleted.
	case UNKNOWN                 = 999; // Unknown event type.

	public function is_admin_only(): bool {
		return match ( $this ) {
			self::USER_KICKED_OUT => true,
			default               => false,
		};
	}

	public function details(): array {
		return match ( $this ) {
			self::POST_STATUS_CHANGED     => [
				'desc'        => 'Changed post status.',
				'icon'        => '<i class="fas fa-exchange-alt wdi__event wdi__event--status"></i>',
				'filter_name' => 'Post status changed',
			],
			self::POST_TRASHED            => [
				'desc'        => 'Moved a post to the trash.',
				'icon'        => '<i class="fas fa-trash wdi__event wdi__event--trashed"></i>',
				'filter_name' => 'Post moved to trash',
			],
			self::POST_UNTRASHED          => [
				'desc'        => 'Restored a post from the trash.',
				'icon'        => '<i class="fas fa-recycle wdi__event wdi__event--untrashed"></i>',
				'filter_name' => 'Post restored from trash',
			],
			self::POST_DELETED            => [
				'desc'        => 'Deleted a post.',
				'icon'        => '<i class="fas fa-minus-circle wdi__event wdi__event--delete"></i>',
				'filter_name' => 'Post deleted',
			],
			self::CATEGORY_CREATED        => [
				'desc'        => 'Created a category.',
				'icon'        => '<i class="fas fa-tag wdi__event wdi__event--category-create"></i>',
				'filter_name' => 'Category created',
			],
			self::CATEGORY_DELETED        => [
				'desc'        => 'Deleted a category.',
				'icon'        => '<i class="fas fa-tag wdi__event wdi__event--category-delete"></i>',
				'filter_name' => 'Category deleted',
			],
			self::CATEGORY_EDITED         => [
				'desc'        => 'Edited a category.',
				'icon'        => '<i class="fas fa-tag wdi__event wdi__event--category-edit"></i>',
				'filter_name' => 'Category edited',
			],
			self::FILE_UPLOADED           => [
				'desc'        => 'Uploaded a file to the Media Library.',
				'icon'        => '<i class="fas fa-file-upload wdi__event wdi__event--upload"></i>',
				'filter_name' => 'Media file uploaded',
			],
			self::FILE_DELETED            => [
				'desc'        => 'Deleted a file from the Media Library.',
				'icon'        => '<i class="fas fa-folder-minus wdi__event wdi__event--remove"></i>',
				'filter_name' => 'Media file deleted',
			],
			self::PLUGIN_INSTALLED        => [
				'desc'        => 'Installed a plugin.',
				'icon'        => '<i class="fas fa-plug wdi__event wdi__event--plugin-install"></i>',
				'filter_name' => 'Plugin installed',
			],
			self::PLUGIN_ACTIVATED        => [
				'desc'        => 'Activated a plugin.',
				'icon'        => '<i class="fas fa-plug wdi__event wdi__event--plugin-activate"></i>',
				'filter_name' => 'Plugin activated',
			],
			self::PLUGIN_DEACTIVATED      => [
				'desc'        => 'Deactivated a plugin.',
				'icon'        => '<i class="fas fa-plug wdi__event wdi__event--plugin-deactivate"></i>',
				'filter_name' => 'Plugin deactivated',
			],
			self::PLUGIN_UNINSTALLED      => [
				'desc'        => 'Removed a plugin.',
				'icon'        => '<i class="fas fa-plug wdi__event wdi__event--plugin-remove"></i>',
				'filter_name' => 'Plugin removed',
			],
			self::THEME_ACTIVATED         => [
				'desc'        => 'Activated a theme.',
				'icon'        => '<i class="fas fa-file-code wdi__event wdi__event--theme-activate"></i>',
				'filter_name' => 'Theme activation',
			],
			self::USER_REGISTERED         => [
				'desc'        => 'Registered a user.',
				'icon'        => '<i class="fas fa-user-plus wdi__event wdi__event--user-register"></i>',
				'filter_name' => 'User registration',
			],
			self::USER_DELETED            => [
				'desc'        => 'Deleted a user.',
				'icon'        => '<i class="fas fa-user-times wdi__event wdi__event--user-remove"></i>',
				'filter_name' => 'User deletion',
			],
			self::USER_ROLE_CHANGED       => [
				'desc'        => 'Changed user role.',
				'icon'        => '<i class="fas fa-user-cog wdi__event wdi__event--user-role-change"></i>',
				'filter_name' => 'User role change',
			],
			self::USER_ROLE_CHANGED_MULTI => [
				'desc'        => 'Changed multiple user role.',
				'icon'        => '<i class="fas fa-user-cog wdi__event wdi__event--user-role-change"></i>',
				'filter_name' => 'User role change (multiple)',
			],
			self::USER_PASS_CHANGED       => [
				'desc'        => 'Changed password for:',
				'icon'        => '<i class="fas fa-key wdi__event wdi__event--user-pass-change"></i>',
				'filter_name' => 'User password change',
			],
			self::USER_EMAIL_CHANGED      => [
				'desc'        => 'Changed user email.',
				'icon'        => '<i class="fas fa-file-code wdi__event wdi__event--user-email-change"></i>',
				'filter_name' => 'User email change',
			],
			self::USER_KICKED_OUT         => [
				'desc'        => 'Kicked this user out:',
				'icon'        => '<i class="fas fa-user-times wdi__event wdi__event--user-boot"></i>',
				'filter_name' => 'Kick user out',
			],
			self::USER_LOGIN              => [
				'desc'        => 'Logged in at:',
				'icon'        => '<i class="fas fa-user-check wdi__event wdi__event--user-login"></i>',
				'filter_name' => 'User login',
			],
			self::MENU_UPDATED            => [
				'desc'        => 'Updated menu:',
				'icon'        => '<i class="fas fa-bars wdi__event wdi__event--menu-update"></i>',
				'filter_name' => 'Menu update',
			],
			self::MENU_CREATED            => [
				'desc'        => 'Created navigation:',
				'icon'        => '<i class="fas fa-bars wdi__event wdi__event--menu-create"></i>',
				'filter_name' => 'Menu created',
			],
			self::MENU_DELETED            => [
				'desc'        => 'Deleted menu:',
				'icon'        => '<i class="fas fa-bars wdi__event wdi__event--menu-delete"></i>',
				'filter_name' => 'Menu deleted',
			],
			default                       => [
				'desc'        => 'Error: Missing event details',
				'icon'        => '',
				'filter_name' => WK_Consts::ERROR_MISSING_FILTER_NAME,
			],
		};
	}
}

enum WK_EventInfo: string {
	case Description = 'desc';
	case Icon        = 'icon';
	case FilterName  = 'filter_name';
}