<?php

namespace WK;

abstract readonly class WK_Access_Control {
	private function check_access_by_id( int $user_id, WK_Element $element ): bool {
		$user = get_user_by( 'ID', $user_id );
		if ( ! $user instanceof \WP_User ) {
			return false;
		}

		if (
			in_array( WK_Consts::ADMIN_CAP, $user->roles ) ||
			array_key_exists( WK_Consts::ADMIN_CAP, $user->caps )
		) {
			return true;
		} else {
			return array_key_exists( WK_Consts::WK_CAP, $user->caps ) && get_option( $element->value );
		}
	}

	public function user_has_access( WK_Cap_Type|int $cap_or_id = WK_Cap_Type::Super,
		WK_Element $element = WK_Element::General ): bool {
		return match ( is_int( $cap_or_id ) ) {
			true  => $this->check_access_by_id( $cap_or_id, $element ),
			false => current_user_can( $cap_or_id->value ),
		};
	}
}