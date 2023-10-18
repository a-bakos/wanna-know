<?php

namespace WK;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Menu implements WK_Consts {
	public function __construct() {
		if ( current_user_can( WK_Consts::ADMIN_CAP ) ) { // TODO change this to WK_CAP later
			add_action( 'admin_menu', [ $this, 'wk_admin_menu' ] );
		}
	}

	public function wk_admin_menu(): void {
		add_menu_page(
			WK_Consts::APP_NAME . ' | Log',
			WK_Consts::APP_NAME,
			WK_Consts::ADMIN_CAP, // TODO change this to WK_CAP later
			'wk_log',
			[ ( new WK_Admin_Page_Log ), 'render' ],
			'dashicons-thumbs-down'
		);

		add_submenu_page(
			'wk_log',
			WK_Consts::APP_NAME . ' | Settings',
			'Settings',
			WK_Consts::ADMIN_CAP,// TODO change this to WK_CAP later
			'wk_settings',
			[ ( new WK_Admin_Page_Settings ), 'render' ]
		);
	}
}