<?php

namespace WK;

enum WK_AssetHandler: string {
	case CSS_Admin = 'wk_style_admin';
	case CSS_Front = 'wk_style_front_end';
	case JS_Admin  = 'wk_script_admin.js';
	case JS_Front  = 'wk_script_front_end';
	case CSS_FA    = 'wk_fontawesome';
	case JQuery    = 'jquery';

	public function get_path(): string {
		return match ( $this ) {
			self::CSS_Admin => WK_AssetPath::CSS_Admin->value,
			self::CSS_Front => WK_AssetPath::CSS_Front->value,
			self::JS_Admin  => WK_AssetPath::JS_Admin->value,
			self::JS_Front  => WK_AssetPath::JS_Front->value,
			default         => '',
		};
	}
}

enum WK_AssetPath: string {
	case CSS_Admin = 'build/css/style-admin.css';
	case CSS_Front = 'build/css/style-theme.css';
	case JS_Admin  = 'build/js/admin/script-admin.min.js';
	case JS_Front  = 'build/js/theme/script-theme.min.js';
}