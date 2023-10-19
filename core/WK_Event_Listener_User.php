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

		( new WK_DB() )?->insert_log_item( WK_DB::prepare_log_item(
			user_id:      $user_data->data->ID,
			event_id:     WK_Event::USER_LOGIN->value,
			subject_id:   $user_data->data->ID,
			subject_type: WK_Subject_Type::User->value,
			user_email:   $user_data->data->user_email,
		) );

		return true; // todo - insert_log_item to return bool on successful insertion
	}
}