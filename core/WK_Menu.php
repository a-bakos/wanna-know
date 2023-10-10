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
			WK_Consts::APP_NAME . ' | Settings',
			WK_Consts::APP_NAME,
			WK_Consts::ADMIN_CAP, // TODO change this to WK_CAP later
			'wk_settings',
			[ $this, 'wk_settings_page' ],
			'dashicons-thumbs-down'
		);
	}

	public function wk_settings_page(): void {
		?>
		<h1>HELLO</h1>
		<?php
	}
}