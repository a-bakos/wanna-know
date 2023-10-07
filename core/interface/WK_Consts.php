<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	die;
}

interface WK_Consts {
	final public const MINIMUM_PHP_VERSION = '8.2';

	final public const MAIN_TABLE_NAME = 'wk_log';

	final public const SETTINGS_GROUP = 'wk-settings-group';

	final public const WK_CAP = 'wk_supervisor';
}

enum WK_AssetHandler: string {
	case CSS_Admin = 'wk_style_admin';
	case CSS_Front = 'wk_style_front_end';
	case JS_Admin  = 'wk_script_admin.js';
	case JS_Front  = 'wk_script_front_end';
	case CSS_FA    = 'wk_fontawesome';
	case JQuery    = 'jquery';

	public function get_path(): string {
		return match ( $this ) {
			WK_AssetHandler::CSS_Admin => WK_AssetPath::CSS_Admin->value,
			WK_AssetHandler::CSS_Front => WK_AssetPath::CSS_Front->value,
			WK_AssetHandler::JS_Admin  => WK_AssetPath::JS_Admin->value,
			WK_AssetHandler::JS_Front  => WK_AssetPath::JS_Front->value,
			WK_AssetHandler::CSS_FA    => WK_AssetPath::FA->value,
			default                    => '',
		};
	}
}

enum WK_AssetPath: string {
	case CSS_Admin = 'build/css/style-admin.css';
	case CSS_Front = 'build/css/style-theme.css';
	case JS_Admin  = 'build/js/admin/script-admin.min.js';
	case JS_Front  = 'build/js/theme/script-theme.min.js';
	case FA        = '' . WK_VERSION . '';
}