<?php

namespace WK;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Menu implements WK_Consts {
	public function __construct() {
		if ( current_user_can( self::ADMIN_CAP ) ) { // TODO change this to WK_CAP later
			add_action( 'admin_menu', [ $this, 'wk_admin_menu' ] );
		}
	}

	public function wk_admin_menu(): void {
		add_menu_page(
			self::APP_NAME . ' | Log',
			self::APP_NAME,
			self::ADMIN_CAP, // TODO change this to WK_CAP later
			'wk_log',
			[ ( new WK_Admin_Page_Log ), 'render' ],
			'dashicons-thumbs-down'
		);

		add_submenu_page(
			'wk_log',
			self::APP_NAME . ' | Settings',
			'Settings',
			self::ADMIN_CAP,// TODO change this to WK_CAP later
			'wk_settings',
			[ ( new WK_Admin_Page_Settings ), 'render' ]
		);
	}
}