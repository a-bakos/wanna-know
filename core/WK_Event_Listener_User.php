<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Event_Listener_User {
	public function __construct() {
		add_action( 'wp_login', [ $this, 'user_logged_in' ] );
	}

	public function user_logged_in() {
		// Filter $_POST array for security.
		$post_array = filter_input_array( INPUT_POST );
		$user_data  = get_user_by( 'login', $post_array['log'] );

		wk_p( $user_data );
		/*
		 [data] => stdClass Object
        (
            [ID] => 1
            [user_login] => abakos
            [user_email] => bakosattila@fastem.com
            [user_registered] => 2023-06-11 07:05:19
            [display_name] => abakos
        )
		[roles] => Array
        (
            [0] => administrator
        )
		 */
		die;
	}
}