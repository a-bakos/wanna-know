<?php

namespace WK;

abstract readonly class WK_Current_User {

	public final const KEY_FIRSTNAME   = 'first_name';
	public final const KEY_LASTNAME    = 'last_name';
	public final const VALUE_LOCALHOST = 'localhost';

	// If no user_id supplied, assume current user
	public static function get_userdata( int $user_id = null ): ?array {
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
			$roles     = $user->roles ?? [];

			return [
				// TODO - create an enum of these variants! - WIP
				'ID'          => $user->ID,
				'login'       => isset( $user->data->user_login ) ?? '',
				'email'       => isset( $user->data->user_email ) ?? '',
				'full_name'   => self::get_username( $user_id ),
				'first_name'  => isset( $user_meta[ self::KEY_FIRSTNAME ][0] ) ?? '',
				'last_name'   => isset( $user_meta[ self::KEY_LASTNAME ][0] ) ?? '',
				'role'        => $roles,
				'profile_url' => self::get_profile_link( $user_id ),
			];
		} else {
			return null;
		}
	}

	public static function get_profile_link( \WP_User|int $user ): string {
		$user_id = $user instanceof \WP_User ? $user->ID : $user;

		return get_edit_user_link( $user_id );
	}

	/**
	 * Get username by ID
	 *
	 * @param int $user_id The User ID.
	 *
	 * @return string $user_name The returned username.
	 */
	public static function get_username( int $user_id ): string {
		if ( WK_Consts::UNKNOWN_ID == $user_id ) {
			$user_name = WK_Consts::USER_SYSTEM; // TODO review this: ID 0 originally means unknown ID
		} else {
			$user = self::get_userdata( $user_id );

			// See if first or last name is available
			if ( $user[ self::KEY_FIRSTNAME ] || $user[ self::KEY_LASTNAME ] ) {
				$user_name = $user[ self::KEY_FIRSTNAME ] ?? '';
				$user_name .= isset( $user[ self::KEY_LASTNAME ] ) ? ' ' . $user[ self::KEY_LASTNAME ] : '';
			} else {
				// If first or last names are not set, use the login name
				$user_name = $user['login'] ?? '';
			}
		}

		return (string) $user_name;
	}

	/**
	 * Get the user's IP address.
	 *
	 * @return string The User IP.
	 */
	public static function get_user_ip(): string {
		$http = [
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR',
		];

		foreach ( $http as $key ) {
			if ( array_key_exists( $key, $_SERVER ) === true ) {
				foreach ( array_map( 'trim', explode( ',', $_SERVER[ $key ] ) ) as $ip ) {
					if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false ) {
						if ( null == $ip ) {
							$ip = self::VALUE_LOCALHOST;
						}

						return $ip;
					}
				}
			}
		}
	}

	/**
	 * Return the user IP address if the tracker is turned on.
	 *
	 * @return string The user IP.
	 */
	public static function the_user_ip(): string {
		if ( get_option( 'ip_tracking' ) ) { // TODO placeholder get_option
			return self::get_user_ip() ?? self::VALUE_LOCALHOST;
		}

		return '';
	}

	public static function is_user_logged_in( int $user_id ): ?bool {
		return false;
	}
}