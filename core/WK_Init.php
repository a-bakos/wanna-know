<?php

namespace WK;

readonly final class WK_Init {
	public function __construct() {
		add_action( 'init', [ $this, 'wk_init' ] );
	}

	public function wk_init(): void {
		new WK_Menu();
		add_action( 'admin_init', [ $this, 'wk_register_settings' ] ); // For Users
	}

	public function wk_register_settings(): void {
		//
	}
}