<?php

namespace WK;

readonly final class WK_Init extends WK_Access_Control {

	public function __construct() {
		add_action( 'init', [ $this, 'wk_init' ] );
	}

	public function wk_init(): void {
		new WK_Request_Router();

		if ( $this->user_has_access() ) {
			new WK_Menu();
		}

		if ( $this->user_has_access( get_current_user_id(), WK_Element::Dashboard_Feed ) ) {
			new WK_Admin_Dashboard_Feed();
		}
		if ( $this->user_has_access( get_current_user_id(), WK_Element::Dashboard_Stats ) ) {
			new WK_Admin_Dashboard_Stats();
		}
		if ( $this->user_has_access( get_current_user_id(), WK_Element::Dashboard_Users ) ) {
			new WK_Admin_Dashboard_Users();
		}
		new WK_Admin_Bar();
		new WK_Events();
		new WK_Cron();
		new WK_Event_Listener_Media();
		new WK_Event_Listener_Post();
		new WK_Event_Listener_System();
		new WK_Event_Listener_User();
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