<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Event_Listener_Menu {
	public function __construct() {
		add_action( 'wp_create_nav_menu', [ $this, 'menu_created' ] );
		add_action( 'wp_update_nav_menu', [ $this, 'menu_updated' ] );
		add_action( 'wp_delete_nav_menu', [ $this, 'menu_deleted' ] );
	}

	public function menu_created() {}

	public function menu_updated() {}

	public function menu_deleted() {}
}