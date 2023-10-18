<?php

namespace WK;

readonly final class WK_Init {
	public function __construct() {
		add_action( 'init', [ $this, 'wk_init' ] );
	}

	public function wk_init(): void {
		new WK_Request_Router();
		new WK_Menu();
		new WK_Admin_Dashboard_Feed();
		new WK_Events();
		new WK_Cron();
		new WK_Event_Listener_Media();
		new WK_Event_Listener_Post();
		new WK_Event_Listener_System();
		add_action( 'admin_init', [ $this, 'wk_register_settings' ] );
	}

	public function wk_register_settings(): void {
		//
	}
}

/**
 * Helper debug function
 */
if ( ! function_exists( 'wk_p' ) ) {
	function wk_p( mixed $a ) {
		if ( null === $a ) {
			echo '<pre style="background: #333; color: #fff;padding: 10px;display: block;"><code>null</code></pre>';
		} else {
			echo '<pre style="background: #333; color: #fff;padding: 10px;display: block;"><code>',
			esc_attr( print_r( $a, 1 ) ), '</code></pre>';
		}
	}
}