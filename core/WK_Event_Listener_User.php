<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Event_Listener_User implements WK_Consts {
	public function __construct() {
		// TODO this will be wrapped in user setting/option

		add_action( 'wp_login', [ $this, 'user_logged_in' ] );

		add_action( 'personal_options_update', [ $this, 'password_changed' ] );
		add_action( 'edit_user_profile_update', [ $this, 'password_changed' ] );
	}

	public function user_logged_in(): bool {
		// Filter $_POST array for security then try to get the user.
		$key_login  = 'log';
		$post_array = filter_input_array( INPUT_POST );
		$user_data  = isset( $post_array[ $key_login ] ) ? get_user_by( 'login', (string) $post_array[ $key_login ] ) : false;

		if ( ! $user_data ) {
			return false;
		}

		return ( new WK_DB() )?->insert_log_item( WK_DB::prepare_log_item(
			user_id:      $user_data->data->ID ?? self::UNKNOWN_ID,
			event_id:     WK_Event::USER_LOGIN->value,
			subject_id:   $user_data->data->ID ?? self::UNKNOWN_ID,
			subject_type: WK_Subject_Type::User->value,
			user_email:   $user_data->data->user_email,
		) );
	}

	public function password_changed(): bool {
		// Filter $_POST array for security
		$key_pass1  = 'pass1';
		$key_pass2  = 'pass2';
		$key_uid    = 'user_id';
		$key_email  = 'email';
		$post_array = filter_input_array( INPUT_POST );

		if ( empty( $post_array ) ) {
			return false;
		}

		if ( ! empty( $post_array[ $key_pass1 ] ) && ! empty( $post_array[ $key_pass2 ] ) ) {
			if ( trim( $post_array[ $key_pass1 ] ) === trim( $post_array[ $key_pass2 ] ) ) {
				return ( new WK_DB() )?->insert_log_item( WK_DB::prepare_log_item(
					user_id:      isset( $post_array[ $key_uid ] ) ?? self::UNKNOWN_ID,
					event_id:     WK_Event::USER_PASS_CHANGED->value,
					subject_id:   isset( $post_array[ $key_uid ] ) ?? self::UNKNOWN_ID,
					subject_type: WK_Subject_Type::User->value,
					user_email:   $post_array[ $key_email ],
				) );
			}
		}

		return false;
	}
}