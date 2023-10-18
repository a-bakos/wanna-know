<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Event_Listener_User {
	public function __construct() {
		// TODO this will be wrapped in user setting/option
		add_action( 'wp_login', [ $this, 'user_logged_in' ] );
	}

	public function user_logged_in(): bool {
		// Filter $_POST array for security.
		$post_array = filter_input_array( INPUT_POST );
		$user_data  = isset( $post_array['log'] ) ? get_user_by( 'login', $post_array['log'] ) : null;

		if ( ! $user_data ) {
			return false;
		}

		wk_p( $user_data );
		/*
		 [data] => stdClass Object
        (
            [ID] => 1
            [user_login] => xxxx
            [user_email] => xxxx
            [user_registered] => 2023-06-11 07:05:19
            [display_name] => xxxx
        )
		[roles] => Array
        (
            [0] => administrator
        )
		 */
		die;
	}
}