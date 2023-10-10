<?php

namespace WK;

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
}