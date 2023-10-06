<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

interface WK_Consts {
    const MINIMUM_PHP_VERSION = '8.2';

    const MAIN_TABLE_NAME = 'wk_log';

	const SETTINGS_GROUP = 'wk-settings-group';

    const ASSET_HANDLERS = [
		'admin' => [
			'css' => 'wk_style_admin',
			'js'  => 'wk_script_admin',
			'fa'  => 'wk_fontawesome',
		],
		'front' => [
			'css' => 'wk_style_front_end',
			'js'  => 'wk_script_front_end',
			'fa'  => 'wk_fontawesome_front_end',
		],
	];

    const WK_ASSET_PATH = [
        'admin' => [
			'css' => 'build/css/style-admin.css',
			'js'  => 'build/js/admin/script-admin.min.js',
        ],
        'front' => [
			'css' => 'build/css/style-theme.css',
			'js'  => 'build/js/theme/script-theme.min.js',
        ],
    
    ];

    const WK_CAP = 'wk_supervisor';
}