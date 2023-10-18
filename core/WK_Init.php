<?php

namespace WK;

readonly final class WK_Init {
	public function __construct() {
		add_action( 'init', [ $this, 'wk_init' ] );
	}

	public function wk_init(): void {
		new WK_Menu();
		new WK_Admin_Dashboard_Feed();
		new WK_Events();
		new WK_Cron();
		add_action( 'admin_init', [ $this, 'wk_register_settings' ] ); // For Users
	}

	public function wk_register_settings(): void {
		//
	}
}

/**
 * Helper debug function
 *
 * @param mixed $to_check The data to observe.
 */
if ( ! function_exists( 'wk_p' ) ) {
	function wki_p( $a ) {
		if ( null === $a ) {
			echo '<pre style="background: #333; color: #fff;padding: 10px;display: block;"><code>null</code></pre>';
		} else {
			echo '<pre style="background: #333; color: #fff;padding: 10px;display: block;"><code>',
			esc_attr( print_r( $a, 1 ) ), '</code></pre>';
		}
	}
}