<?php

namespace WK;

abstract readonly class WK_Current_User {
	public static function get_userdata( ?int $user_id ): ?array {
		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}

		if ( $user_id != WK_Consts::UNKNOWN_ID ) {
			// Deal with deleted users
			/*if ( ! get_user_by( 'ID', $user_id ) ) {
				$userdata = [
					'login'      => '',
					'email'      => '',
					'first_name' => self::USER_DELETED . ' #' . $user_id,
					'last_name'  => '',
					'last_login' => '',
					'role'       => '(unknown)',
				];

				return $userdata;
			}*/

			$user      = get_userdata( $user_id );
			$user_meta = get_user_meta( $user_id );

			$roles = $user->roles ?? [];

			return [
				'login'       => $user->data->user_login,
				'email'       => $user->data->user_email,
				'first_name'  => isset( $user_meta['first_name'][0] ) ?? '',
				'last_name'   => isset( $user_meta['last_name'][0] ) ?? '',
				'role'        => $roles,
				'profile_url' => self::get_profile_link( $user_id ),
			];
		} else {
			return null;
		}
	}

	public static function get_profile_link( \WP_User|int $user ): string {
		if ( $user instanceof \WP_User ) {
			$user_id = $user->ID;
		} else {
			$user_id = $user;
		}

		return get_edit_user_link( $user_id );
	}

}