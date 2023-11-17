<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

interface WK_Consts {
	final public const APP_NAME            = 'WannaKnow?';
	final public const MINIMUM_PHP_VERSION = '8.2';
	final public const MAIN_TABLE_NAME     = 'wk_log';
	final public const SETTINGS_GROUP      = 'wk-settings-group';
	final public const WK_CAP              = 'wk_supervisor';
	final public const ADMIN_CAP           = 'administrator';

	final public const USER_SYSTEM = 'System';

	final public const ERROR_MISSING_FILTER_NAME = 'Missing filter name!';

	final public const UNKNOWN_ID      = 0;
	final public const UNKNOWN_POST_ID = 0;

	final public const EMPTY_STRING = '';
}