<?php

namespace WK;

abstract readonly class WK_Access_Control {

	private function check_access_by_id( int $user_id ): bool {
		$user = get_user_by( 'ID', $user_id );

		if ( ! $user instanceof \WP_User ) {
			return false;
		}

		if (
			in_array( WK_Consts::ADMIN_CAP, $user->roles ) ||
			array_key_exists( WK_Consts::ADMIN_CAP, $user->caps ) ||
			array_key_exists( WK_Consts::WK_CAP, $user->caps )
		) {
			return true;
		}

		return false;
	}

	public function user_has_access( string|int $cap_or_id = WK_Consts::WK_CAP | WK_Consts::ADMIN_CAP ): bool {
		return match ( is_int( $cap_or_id ) ) {
			true  => $this->check_access_by_id( $cap_or_id ),
			false => current_user_can( $cap_or_id ),
		};
	}
}